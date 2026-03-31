<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nondocumentcategories extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Nondocumentcategories_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page', TRUE) : 10;
        $start = intval($this->input->get('start'));

        // Build the base URL with query parameters
        $query_params = array();
        if ($q !== '') {
            $query_params['q'] = urlencode($q);
        }
        if ($per_page !== '10') {
            $query_params['per_page'] = $per_page;
        }

        $config['base_url'] = base_url() . 'app/nondocumentcategories/index' . ($query_params ? '?' . http_build_query($query_params) : '');
        $config['first_url'] = base_url() . 'app/nondocumentcategories/index' . ($query_params ? '?' . http_build_query($query_params) : '');

        $config['per_page'] = in_array($per_page, [10, 25, 50, 100]) ? $per_page : 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Nondocumentcategories_model->total_rows($q);
        $nondocumentcategories = $this->Nondocumentcategories_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'nondocumentcategories_data' => $nondocumentcategories,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'nondocumentcategories/nondocumentcategories_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('app/nondocumentcategories/create_action'),
            'id' => set_value('id'),
            'group_key' => set_value('group_key'),
            'group_name' => set_value('group_name'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'nondocumentcategories/nondocumentcategories_form',
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
                'group_key' => $this->input->post('group_key', TRUE),
                'group_name' => $this->input->post('group_name', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Nondocumentcategories_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/nondocumentcategories'));
        }
    }

    public function update($id)
    {
        $row = $this->Nondocumentcategories_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('app/nondocumentcategories/update_action'),
                'id' => set_value('id', $row->id),
                'group_key' => set_value('group_key', $row->group_key),
                'group_name' => set_value('group_name', $row->group_name),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'nondocumentcategories/nondocumentcategories_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/nondocumentcategories'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'group_key' => $this->input->post('group_key', TRUE),
                'group_name' => $this->input->post('group_name', TRUE),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Nondocumentcategories_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/nondocumentcategories'));
        }
    }

    public function delete($id)
    {
        $row = $this->Nondocumentcategories_model->get_by_id($id);

        if ($row) {
            // Check if category is used in regulations
            $this->db->where('groups', $row->group_key);
            $used = $this->db->count_all_results('regulations');
            if ($used > 0) {
                $this->session->set_flashdata('message', 'Kategori sedang digunakan, tidak dapat dihapus!');
                redirect(site_url('app/nondocumentcategories'));
            }
            $this->Nondocumentcategories_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/nondocumentcategories'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/nondocumentcategories'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('group_key', 'Kunci Kategori', 'trim|required|xss_clean|callback_unique_group_key');
        $this->form_validation->set_rules('group_name', 'Nama Kategori', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function unique_group_key($group_key)
    {
        $id = $this->input->post('id', TRUE);
        $this->db->where('group_key', $group_key);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get($this->Nondocumentcategories_model->table);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_group_key', 'Kunci Kategori sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}

/* End of file Nondocumentcategories.php */
/* Location: ./application/controllers/Nondocumentcategories.php */