<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends MY_Controller {

    public $sess;

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->load->model('Roles_model');
        $this->load->model('Roledetails_model');
        $this->load->model('Routings_model');
        $this->load->library('form_validation');
        $this->sess = $this->session->logged_in;
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'auth/roles/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'auth/roles/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'auth/roles/index';
            $config['first_url'] = base_url() . 'auth/roles/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Roles_model->total_rows($q);
        $roles = $this->Roles_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'roles_data' => $roles,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'template' => 'roles/roles_list',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id) {
        $row = $this->Roles_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'rolename' => $row->rolename,
                'moduleroute' => $row->moduleroute,
                'rolelist' => $row->rolelist,
                'roleaction' => $row->roleaction,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
            );
            $this->load->view('roles/roles_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/roles'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('auth/roles/create_action'),
            'id' => set_value('id'),
            'rolename' => set_value('rolename'),
            'createdat' => set_value('createdat'),
            'createdby' => set_value('createdby'),
            'updatedat' => set_value('updatedat'),
            'updatedby' => set_value('updatedby'),
            'session' => $this->sess,
            'template' => 'roles/roles_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'rolename' => $this->input->post('rolename', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Roles_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('auth/roles'));
        }
    }

    public function update($id) {
        $row = $this->Roles_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/roles/update_action'),
                'id' => set_value('id', $row->id),
                'rolename' => set_value('rolename', $row->rolename),
                'session' => $this->sess,
                'template' => 'roles/roles_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/roles'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'rolename' => $this->input->post('rolename', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Roles_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('auth/roles'));
        }
    }

    public function roledetail($roleid) {
        $role = $this->Roles_model->get_by_id($roleid);
        $roled = $this->Roledetails_model->get_by_roleid($roleid);
        if ($role) {
            $routes = $this->Routings_model->get_all();
            $data = array(
                'button' => 'Save',
                'action' => site_url('auth/roles/roledetail_action'),
                'id' => set_value('id', $role->id),
                'rolename' => set_value('rolename', $role->rolename),
                'routings' => $routes,
                'roledetails' => $roled,
                'session' => $this->sess,
                'template' => 'roles/roledetails_form',
                'extrajs' => 'roles/roledetails_form_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/roles'));
        }
    }

    public function roledetail_action() {
        $temproles = $this->input->post();
        $id = $temproles['id'];
        unset($temproles['id']);

        $rd = $this->Roledetails_model->get_by_roleid($id);
        if ($rd) {
            $data = array(
                "roledetail" => json_encode($temproles),
                "roleid" => $id,
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Roledetails_model->update_by_roleid($id, $data);
            $this->session->set_flashdata('message', 'Update Role Lists Success');
        } else {
            $data = array(
                "roledetail" => json_encode($temproles),
                "roleid" => $id,
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Roledetails_model->insert($data);
            $this->session->set_flashdata('message', 'Added Role Lists Success');
        }
        redirect(site_url('auth/roles'));
    }

    public function reload_session_action() {

        $this->load->model("auth/Roledetails_model");
        $rolelist = $this->Roledetails_model->get_by_roleid($this->sess['role']);
        $menu = $this->myacl->_generateMenus(json_decode($rolelist->roledetail));
        $button = $this->myacl->_generateButtons(json_decode($rolelist->roledetail));

        $newsession_data = array(
            'id' => $this->sess['id'],
            'email' => $this->sess['email'],
            'username' => $this->sess['username'],
            'role' => $this->sess['role'],
            'rolename' => $this->sess['rolename'],
            'rolelist' => (array) json_decode($rolelist->roledetail),
            'menus' => $menu,
            'button' => $button,
            'name' => $this->sess['name'],
            'image' => $this->sess['image'],
            'lastlogin' => $this->sess['lastlogin'],
        );

        if ($this->session->has_userdata('logged_in')) {
            $this->session->unset_userdata('logged_in');
            $this->session->set_userdata("logged_in", $newsession_data);
            $this->session->set_flashdata('message', 'Success to reload session data');
            redirect(site_url('auth/roles'));
        } else {
            $this->session->set_flashdata('message', 'Failed to reload session data');
            redirect(site_url('auth/roles'));
        }
    }

    public function navigation($role) {
        $row = $this->Roledetails_model->get_by_roleid($role);
        $routes = $this->Routings_model->get_all();
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/roles/navigation_action'),
                'id' => $row->id,
                'roleid' => $row->roleid,
                'rolename' => $row->rolename,
                'roledetail' => json_decode($row->roledetail),
                'routings' => $routes,
                'session' => $this->sess,
                'navigation' => json_decode($row->navigation),
                'template' => 'navigation/navigation_form',
                'extracss' => 'navigation/navigation_form_extracss',
                'extrajs' => 'navigation/navigation_form_extrajs',
            );
            echo"<pre>";
            print_r(json_decode($row->navigation));
            echo "<br>";
            print_r($this->sess);
            //$this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/roles'));
        }
    }

    public function navigation_action() {
        $data = array(
            'navigation' => $this->input->post('nestable_menu_output', TRUE),
            'updatedat' => date('Y-m-d H:i:s'),
            'updatedby' => $this->sess['id'],
        );

        $this->Roledetails_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Sukses mengupdate data!');
        redirect(site_url('auth/roles'));
    }

    public function delete($id) {
        $row = $this->Roles_model->get_by_id($id);

        if ($row) {
            $this->Roles_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('auth/roles'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/roles'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('rolename', 'rolename', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Roles.php */
/* Location: ./authlication/controllers/Roles.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-09-14 19:52:53 */
/* http://harviacode.com */