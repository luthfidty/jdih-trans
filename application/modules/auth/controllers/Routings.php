<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Routings extends MY_Controller {

    public $sess;

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->load->model('Routings_model');
        $this->load->model('auth/Icons_model');
        $this->load->library('form_validation');
        $this->sess = $this->session->logged_in;
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'auth/routings/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'auth/routings/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'auth/routings/index';
            $config['first_url'] = base_url() . 'auth/routings/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Routings_model->total_rows($q);
        $routings = $this->Routings_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'routings_data' => $routings,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'template' => 'routings/routings_list',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id) {
        $row = $this->Routings_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'routename' => $row->routename,
                'routealias' => $row->routealias,
                'functionname' => $row->functionname,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
                'session' => $this->sess,
                'template' => 'routings/routings_read',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/routings'));
        }
    }

    public function create() {
        $icons = $this->Icons_model->get_all();
        $data = array(
            'button' => 'Create',
            'action' => site_url('auth/routings/create_action'),
            'id' => set_value('id'),
            'routename' => set_value('routename'),
            'routealias' => set_value('routealias'),
            'icon' => set_value('icon'),
            'functionname' => set_value('functionname'),
            'createdat' => set_value('createdat'),
            'createdby' => set_value('createdby'),
            'updatedat' => set_value('updatedat'),
            'updatedby' => set_value('updatedby'),
            'icons' => $icons,
            'session' => $this->sess,
            'template' => 'routings/routings_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'routename' => ucfirst($this->input->post('routename', TRUE)),
                'routealias' => ucfirst($this->input->post('routealias', TRUE)),
                'icon' => $this->input->post('icon', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Routings_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('auth/routings'));
        }
    }

    public function update($id) {
        $row = $this->Routings_model->get_by_id($id);
        $icons = $this->Icons_model->get_all();
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/routings/update_action'),
                'id' => set_value('id', $row->id),
                'routename' => set_value('routename', $row->routename),
                'routealias' => set_value('routename', $row->routealias),
                'icon' => set_value('icon', $row->icon),
                'createdat' => set_value('createdat', $row->createdat),
                'createdby' => set_value('createdby', $row->createdby),
                'updatedat' => set_value('updatedat', $row->updatedat),
                'updatedby' => set_value('updatedby', $row->updatedby),
                'icons' => $icons,
                'session' => $this->sess,
                'template' => 'routings/routings_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/routings'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'routename' => ucfirst($this->input->post('routename', TRUE)),
                'routealias' => ucfirst($this->input->post('routealias', TRUE)),
                'icon' => $this->input->post('icon', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Routings_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('auth/routings'));
        }
    }

    function generateOne($id) {
        $row = $this->Routings_model->get_by_id($id);
        $func = $this->myacl->_getFunction($row->routename);
        if (is_array($func)) {
            $this->Routings_model->update($id, array("routeurl" => $func['module'] . "/" . strtolower($row->routename), "functionname" => json_encode($func['functions']), 'updatedat' => date('Y-m-d H:i:s'),));
            $this->session->set_flashdata('message', 'Generate Functions Success');
        } else {
            $this->session->set_flashdata('message', 'Generate Functions Failed!');
        }
        redirect(site_url('auth/routings'));
    }

    function generateAll() {
        $row = $this->Routings_model->get_all();
        foreach ($row as $c) {
            $func = $this->myacl->_getFunction($c->routename);
            if (is_array($func)) {
                $this->Routings_model->update($c->id, array("routeurl" => $func['module'] . "/" . strtolower($c->routename), "functionname" => json_encode($func['functions']), 'updatedat' => date('Y-m-d H:i:s'), 'updatedby' => $this->sess['id']));
                $this->session->set_flashdata('message', 'Generate Functions Success');
            } else {
                $this->session->set_flashdata('message', 'Generate Functions Failed!');
            }
        }
        $this->session->set_flashdata('message', 'Generate Functions Success');
        redirect(site_url('auth/routings'));
    }

    public function delete($id) {
        $row = $this->Routings_model->get_by_id($id);

        if ($row) {
            $this->Routings_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('auth/routings'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/routings'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('routename', 'routename', 'trim|required');
        $this->form_validation->set_rules('routealias', 'routealias', 'trim');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Routings.php */
/* Location: ./authlication/controllers/Routings.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-01-20 08:59:20 */
/* http://harviacode.com */