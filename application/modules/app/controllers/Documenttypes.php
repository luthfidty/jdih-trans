<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documenttypes extends MY_Controller {

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Documenttypes_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/documenttypes/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/documenttypes/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/documenttypes/index';
            $config['first_url'] = base_url() . 'app/documenttypes/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Documenttypes_model->total_rows($q);
        $documenttypes = $this->Documenttypes_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'documenttypes_data' => $documenttypes,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'documenttypes/documenttypes_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('app/documenttypes/create_action'),
            'id' => set_value('id'),
            'documenttype' => set_value('documenttype'),
            'createdat' => set_value('createdat'),
            'createdby' => set_value('createdby'),
            'updatedat' => set_value('updatedat'),
            'updatedby' => set_value('updatedby'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'documenttypes/documenttypes_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'documenttype' => $this->input->post('documenttype', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Documenttypes_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/documenttypes'));
        }
    }

    public function update($id) {
        $row = $this->Documenttypes_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('app/documenttypes/update_action'),
                'id' => set_value('id', $row->id),
                'documenttype' => set_value('documenttype', $row->documenttype),
                'createdat' => set_value('createdat', $row->createdat),
                'createdby' => set_value('createdby', $row->createdby),
                'updatedat' => set_value('updatedat', $row->updatedat),
                'updatedby' => set_value('updatedby', $row->updatedby),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'documenttypes/documenttypes_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/documenttypes'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'documenttype' => $this->input->post('documenttype', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Documenttypes_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/documenttypes'));
        }
    }

    public function delete($id) {
        $row = $this->Documenttypes_model->get_by_id($id);

        if ($row) {
            $this->Documenttypes_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/documenttypes'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/documenttypes'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('documenttype', 'documenttype', 'trim|required|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Documenttypes.php */
/* Location: ./application/controllers/Documenttypes.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-19 10:00:31 */
/* http://harviacode.com */