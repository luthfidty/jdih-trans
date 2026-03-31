<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends MY_Controller
{

    public $where;

    function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Categories_model');
        $this->load->model('auth/Roles_model');
        $this->load->library('form_validation');

        // Remove restriction by setting neutral where condition
        $this->where = array('createdby>=' => 0);
    }

    public function index()
    {

        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/categories/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/categories/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/categories/index';
            $config['first_url'] = base_url() . 'app/categories/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Categories_model->total_rows($this->where, $q);
        $categories = $this->Categories_model->get_limit_data($this->where, $config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'categories_data' => $categories,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'categories/categories_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('app/categories/create_action'),
            'id' => set_value('id'),
            'category' => set_value('category'),
            'slug' => set_value('slug'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'categories/categories_form',
            'extrajs' => 'categories/categories_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'category' => $this->input->post('category', TRUE),
                'slug' => $this->input->post('slug', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Categories_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/categories'));
        }
    }

    public function update($id)
    {
        $row = $this->Categories_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Perbaharui',
                'action' => site_url('app/categories/update_action'),
                'id' => set_value('id', $row->id),
                'category' => set_value('category', $row->category),
                'slug' => set_value('slug', $row->slug),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'categories/categories_form',
                'extrajs' => 'categories/categories_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/categories'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'category' => $this->input->post('category', TRUE),
                'slug' => $this->input->post('slug', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Categories_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/categories'));
        }
    }

    public function delete($id)
    {
        $row = $this->Categories_model->get_by_id($id);

        if ($row) {
            $this->Categories_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/categories'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/categories'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slug', 'slug', 'trim|required|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Categories.php */
/* Location: ./application/controllers/Categories.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-11-07 12:59:55 */
/* http://harviacode.com */