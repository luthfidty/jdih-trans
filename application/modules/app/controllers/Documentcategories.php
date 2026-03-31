<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documentcategories extends MY_Controller {

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Documentcategories_model');
        $this->load->library('form_validation');
        
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/documentcategories/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/documentcategories/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/documentcategories/index';
            $config['first_url'] = base_url() . 'app/documentcategories/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Documentcategories_model->total_rows($q);
        $documentcategories = $this->Documentcategories_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'documentcategories_data' => $documentcategories,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'documentcategories/documentcategories_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create() {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('app/documentcategories/create_action'),
            'id' => set_value('id'),
            'category' => set_value('category'),
            'acronym' => set_value('acronym'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'documentcategories/documentcategories_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'category' => $this->input->post('category', TRUE),
                'slug' => url_title($this->input->post('category', TRUE), "-", TRUE),
                'acronym' => $this->input->post('acronym', TRUE),
                'acslug' => url_title($this->input->post('acronym', TRUE), "-", TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Documentcategories_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/documentcategories'));
        }
    }

    public function update($id) {
        $row = $this->Documentcategories_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('app/documentcategories/update_action'),
                'id' => set_value('id', $row->id),
                'category' => set_value('category', $row->category),
                'acronym' => set_value('acronym', $row->acronym),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'documentcategories/documentcategories_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/documentcategories'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'category' => $this->input->post('category', TRUE),
                'slug' => url_title($this->input->post('category', TRUE), "-", TRUE),
                'acronym' => $this->input->post('acronym', TRUE),
                'acslug' => url_title($this->input->post('acronym', TRUE), "-", TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Documentcategories_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/documentcategories'));
        }
    }

    public function delete($id) {
        $row = $this->Documentcategories_model->get_by_id($id);

        if ($row) {
            $this->Documentcategories_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/documentcategories'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/documentcategories'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('acronym', 'acronym', 'trim|required|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Documentcategories.php */
/* Location: ./application/controllers/Documentcategories.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-02 14:43:59 */
/* http://harviacode.com */