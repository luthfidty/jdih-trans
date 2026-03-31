<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries extends MY_Controller {

    public function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Nonregulations_model');
        $this->load->model('Categories_model');
        $this->load->model('Posts_model');
        $this->load->model('Visitors_model');
        $this->load->model('Surveys_model');
        $this->load->model('Auth/Users_model');
        $this->load->model('Auth/Roles_model');
        $this->load->model('Nondocumentcategories_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $documentcategory = $this->Documentcategories_model->get_all();
        $categories = $this->Categories_model->get_all();
        // Fetch dynamic nonregulations from Nondocumentcategories_model
        $nondocumentcategories = $this->Nondocumentcategories_model->get_all();
        $nonregulation = [];
        foreach ($nondocumentcategories as $category) {
            $nonregulation[$category->group_key] = $category->group_name;
        }
        $users = $this->Users_model->get_all_with_profile();
        $roles = $this->Roles_model->get_all();
        $data = array(
            'categories' => $categories,
            'documentcategories' => $documentcategory,
            'nonregulations' => $nonregulation,
            'users' => $users,
            'roles' => $roles,
            "template" => 'summaries/summaries_list',
            "extrajs" => 'summaries/summaries_extrajs',
            "session" => $this->sess,
        );
        $this->load->view('base/content', $data);
    }

    public function ajax_summary() {
        $this->_rules();
        $status = '';
        $msg = '';
        $dataGraph = array();
        $where = '';
        $opt = array();

        // Fetch dynamic nonregulations from Nondocumentcategories_model
        $nondocumentcategories = $this->Nondocumentcategories_model->get_all();
        $nonregulation = [];
        foreach ($nondocumentcategories as $category) {
            $nonregulation[$category->group_key] = $category->group_name;
        }

        if ($this->form_validation->run() == FALSE) {
            $status = 'failed';
            $msg = form_error();
        } else {
            $datatype = $this->input->post('datatype', TRUE);
            $documentcategory = $this->input->post('documentcategory', TRUE);
            $nonregulations = $this->input->post('nonregulations', TRUE);
            $roles = $this->input->post('roles', TRUE);
            $users = $this->input->post('users', TRUE);
            $startdate = $this->input->post('startdate', TRUE);
            $enddate = $this->input->post('enddate', TRUE);
            $title = '';
            $opt['datatype'] = $datatype;
            $opt['documentcategory'] = $documentcategory;
            $opt['nonregulations'] = $nonregulations;
            $opt['roles'] = $roles;
            $opt['users'] = $users;
            $opt['startdate'] = $startdate;
            $opt['enddate'] = $enddate;
            switch ($datatype) {
                case 'regulations':
                    if ($documentcategory == 0) {
                        $dataGraph = $this->Regulations_model->get_total_doc_by_category();
                        $title = 'Data Jumlah Dokumen Peraturan Perkategori';
                    }
                    if ($documentcategory > 0) {
                        $where .= ' and regulations.documentcategory = ' . $documentcategory;
                        $cat = $this->Documentcategories_model->get_by_id($documentcategory);
                        $title = 'Data Jumlah Dokumen Peraturan Kategori : ' . $cat->category;
                    }
                    if ($users > 0) {
                        $where .= ' and regulations.createdby = ' . $users;
                    }
                    if ($startdate != '' && $enddate == '') {
                        $where .= ' and date_format(regulations.createdat, "%Y-%m-%d") = "' . $startdate . '"';
                    }
                    if ($startdate != '' && $enddate != '') {
                        $where .= ' and date_format(regulations.createdat, "%Y-%m-%d") between "' . $startdate . '" AND "' . $enddate . '"';
                    }

                    $dataGraph = $this->Regulations_model->get_sumary($where);
                    $status = 'success';
                    $msg = 'Sukses mengambil data!';
                    break;
                case 'nonregulations':
                    // Validate if nonregulations input is a valid group_key
                    if ($nonregulations && array_key_exists($nonregulations, $nonregulation)) {
                        $where .= ' and nonregulations.group_key = "' . $this->db->escape_str($nonregulations) . '"';
                        $title = 'Data Jumlah Dokumen Non-Peraturan Kategori : ' . $nonregulation[$nonregulations];
                    }
                    if ($users > 0) {
                        $where .= ' and nonregulations.createdby = ' . $users;
                    }
                    if ($startdate != '' && $enddate == '') {
                        $where .= ' and date_format(nonregulations.createdat, "%Y-%m-%d") = "' . $startdate . '"';
                    }
                    if ($startdate != '' && $enddate != '') {
                        $where .= ' and date_format(nonregulations.createdat, "%Y-%m-%d") between "' . $startdate . '" AND "' . $enddate . '"';
                    }

                    $dataGraph = $this->Nonregulations_model->get_summary($where);
                    $status = 'success';
                    $msg = 'Sukses mengambil data!';
                    break;
                case 'posts':
                    $status = 'success';
                    $msg = 'Sukses mengambil data!';
                    break;
                default:
                    $status = 'failed';
                    $msg = 'Gagal mengambil data. Kombinasi pilihan tidak tepat!';
                    break;
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg, 'opt' => $opt, 'dataGraph' => $dataGraph, 'csrftoken' => $this->security->get_csrf_hash()));
    }

    function _rules() {
        $this->form_validation->set_rules('datatype', 'datatype', 'trim|required|xss_clean');
        $this->form_validation->set_rules('documentcategory', 'documentcategory', 'trim|xss_clean');
        $this->form_validation->set_rules('nonregulations', 'nonregulations', 'trim|xss_clean');
        $this->form_validation->set_rules('roles', 'roles', 'trim|xss_clean');
        $this->form_validation->set_rules('users', 'users', 'trim|xss_clean');
        $this->form_validation->set_rules('startdate', 'startdate', 'trim|xss_clean');
        $this->form_validation->set_rules('enddate', 'enddate', 'trim|xss_clean');
    }

}

/* End of file Summaries.php */
/* Location: ./application/controllers/Summaries.php */