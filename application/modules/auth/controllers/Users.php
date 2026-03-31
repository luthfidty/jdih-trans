<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

    public $sess;

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->load->model('Users_model');
        $this->load->model('Userdetails_model');
        $this->load->model('Roles_model');
        $this->load->library('form_validation');
        $this->sess = $this->session->logged_in;
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'auth/users/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'auth/users/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'auth/users/index';
            $config['first_url'] = base_url() . 'auth/users/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'template' => 'users/users_list',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id) {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'username' => $row->username,
                'email' => $row->email,
                'password' => $row->password,
                'status' => $row->isactive,
                'role' => $row->role,
                'resetkey' => $row->resetkey,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
            );
            $this->load->view('auth/users/users_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/users'));
        }
    }

    public function create() {
        $roles = $this->Roles_model->get_all();
        $data = array(
            'button' => 'Create',
            'action' => site_url('auth/users/create_action'),
            'id' => set_value('id'),
            'username' => set_value('username'),
            'email' => set_value('email'),
            'password' => set_value('newpassword'),
            'oldpassword' => set_value('oldpassword'),
            'isactive' => set_value('isactive'),
            'role' => set_value('role'),
            'updatedby' => set_value('updatedby'),
            'roles' => $roles,
            'session' => $this->sess,
            'template' => 'users/users_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => sha1($this->config->item('encryption_key') . $this->input->post('newpassword', TRUE)),
                'isactive' => $this->input->post('isactive', TRUE),
                'role' => $this->input->post('role', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Users_model->insert($data);
            $user = $this->Users_model->get_by_username_email($this->input->post('username', TRUE), $this->input->post('email', TRUE));
            $data2 = array(
                'userid' => $user->id,
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Userdetails_model->insert($data2);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('auth/users'));
        }
    }

    public function update($id) {
        $row = $this->Users_model->get_by_id($id);

        $roles = $this->Roles_model->get_all();
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/users/update_action'),
                'id' => set_value('id', $row->id),
                'username' => set_value('username', $row->username),
                'email' => set_value('email', $row->email),
                'newpassword' => set_value('newpassword'),
                'oldpassword' => set_value('oldpassword', $row->password),
                'isactive' => set_value('isactive', $row->isactive),
                'role' => set_value('role', $row->role),
                'roles' => $roles,
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
                'session' => $this->sess,
                'template' => 'users/users_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/users'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            if (!empty($this->input->post('newpassword', TRUE))) {
                $this->_rules_update();
                if ($this->form_validation->run() == FALSE) {
                    $this->update($this->input->post('id', TRUE));
                } else {
                    $data = array(
                        'username' => $this->input->post('username', TRUE),
                        'email' => $this->input->post('email', TRUE),
                        'password' => sha1($this->config->item('encryption_key') . $this->input->post('newpassword', TRUE)),
                        'isactive' => $this->input->post('isactive', TRUE),
                        'role' => $this->input->post('role', TRUE),
                        'updatedat' => date('Y-m-d H:i:s'),
                        'updatedby' => $this->sess['id'],
                    );
                    $this->Users_model->update($this->input->post('id', TRUE), $data);
                    $this->session->set_flashdata('message', 'Sukses mengupdate data!');
                    redirect(site_url('auth/users'));
                }
            } else {
                $data = array(
                    'username' => $this->input->post('username', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'isactive' => $this->input->post('isactive', TRUE),
                    'role' => $this->input->post('role', TRUE),
                    'updatedat' => date('Y-m-d H:i:s'),
                    'updatedby' => $this->sess['id'],
                );
                $this->Users_model->update($this->input->post('id', TRUE), $data);
                $this->session->set_flashdata('message', 'Sukses mengupdate data!');
                redirect(site_url('auth/users'));
            }
        }
    }

    public function account($id) {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/users/account_action'),
                'id' => set_value('id', $row->id),
                'username' => set_value('username', $row->username),
                'email' => set_value('email', $row->email),
                'password' => set_value('password', $row->password),
                'isactive' => set_value('isactive', $row->isactive),
                'session' => $this->sess,
                'template' => 'users/users_account',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/users'));
        }
    }

    public function account_action() {
        $this->_rules_account();

        if ($this->form_validation->run() == FALSE) {
            $this->account($this->input->post('id', TRUE));
        } else {
            if (!empty($this->input->post('newpassword', TRUE))) {
                $this->_rules_update();
                if ($this->form_validation->run() == FALSE) {
                    $this->account($this->input->post('id', TRUE));
                } else {
                    $data = array(
                        'email' => $this->input->post('email', TRUE),
                        'password' => sha1($this->config->item('encryption_key') . $this->input->post('newpassword', TRUE)),
                        'updatedat' => date('Y-m-d H:i:s'),
                        'updatedby' => $this->sess['id'],
                    );
                    $this->Users_model->update($this->input->post('id', TRUE), $data);
                    $this->session->set_flashdata('message', 'Sukses mengupdate data!');
                    redirect(site_url('auth/users/account/' . $this->input->post('id', TRUE)));
                }
            } else {
                $data = array(
                    'email' => $this->input->post('email', TRUE),
                    'updatedat' => date('Y-m-d H:i:s'),
                    'updatedby' => $this->sess['id'],
                );
                $this->Users_model->update($this->input->post('id', TRUE), $data);
                $this->session->set_flashdata('message', 'Sukses mengupdate data!');
                redirect(site_url('auth/users/account/' . $this->input->post('id', TRUE)));
            }
        }
    }

    public function userdetails($id) {
        $row = $this->Userdetails_model->get_by_userid($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('auth/users/userdetails_action'),
                'id' => set_value('id', $row->id),
                'userid' => set_value('userid', $row->userid),
                'fullname' => set_value('fullname', $row->fullname),
                'address' => set_value('address', $row->address),
                'url' => set_value('url', $row->url),
                'image' => set_value('image', $row->image),
                'description' => set_value('description', $row->description),
                'session' => $this->sess,
                'template' => 'users/userdetails_form',
                'extrajs' => 'users/userdetails_form_extrajs'
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/home'));
        }
    }

    public function userdetails_action() {
        $this->_rules_userdetails();

        if ($this->form_validation->run() == FALSE) {
            $this->userdetails($this->input->post('id', TRUE));
        } else {
            if (!empty($_FILES['fileimage']['name'])) {
                $result = fileuploader($_FILES, "fileimage");
            }

            $data = array(
                'fullname' => $this->input->post('fullname', TRUE),
                'address' => $this->input->post('address', TRUE),
                'url' => $this->input->post('url', TRUE),
                'image' => $result['message']['fullpath'],
                'description' => $this->input->post('description', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->upload->display_errors();
            $this->Userdetails_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('auth/users/userdetails/' . $this->input->post('id', TRUE)));
        }
    }

    public function newpassword() {
        if ($this->Users_model->get_by_username_password($this->input->post('username', TRUE), sha1($this->config->item('encryption_key') . $this->input->post('newpassword', TRUE)))) {
            $this->form_validation->set_message('newpassword', 'The password has been used. Please use another password!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function activate($id) {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $this->Users_model->update($row->id, array('isactive' => 1));
            $this->session->set_flashdata('message', 'Activate User' . $row->username . ' Success');
            redirect(site_url('auth/users'));
        } else {
            $this->session->set_flashdata('message', 'User Not Found');
            redirect(site_url('auth/users'));
        }
    }

    public function delete($id) {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $this->Users_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('auth/users'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('auth/users'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('isactive', 'isactive', 'trim|required|xss_clean');
        $this->form_validation->set_rules('role', 'role', 'trim|required|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_account() {
        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_userdetails() {
        $this->form_validation->set_rules('fullname', 'fullname', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'address', 'trim|xss_clean');
        $this->form_validation->set_rules('url', 'url', 'trim|valid_url|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'trim|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_update() {
        $this->form_validation->set_rules('newpassword', 'newpassword', 'trim|required|xss_clean|callback_newpassword');
    }

}

/* End of file Users.php */
/* Location: ./authlication/controllers/Users.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-01-04 06:40:06 */
/* http://harviacode.com */