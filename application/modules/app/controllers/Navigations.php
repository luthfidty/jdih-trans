<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Navigations extends MY_Controller {

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->load->model('Navigations_model');
        $this->load->model('Pages_model');
        $this->load->model('Categories_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Nondocumentcategories_model'); // Load Nondocumentcategories_model
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'navigations/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'navigations/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'navigations/index';
            $config['first_url'] = base_url() . 'navigations/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Navigations_model->total_rows($q);
        $navigations = $this->Navigations_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'navigations_data' => $navigations,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'template' => 'navigations/navigations_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create() {
        $pages = $this->Pages_model->get_all(array('poststatus =' => 1));
        $categories = $this->Categories_model->get_all();
        $documentcategories = $this->Documentcategories_model->get_all();
        $modules = json_decode($this->config->item('site_modules'));
        // Fetch dynamic grouplists from Nondocumentcategories_model
        $nondocumentcategories = $this->Nondocumentcategories_model->get_all();
        $groups = [];
        foreach ($nondocumentcategories as $category) {
            $groups[$category->group_key] = $category->group_name;
        }

        // Remove duplicates
        $pages = $this->removeDuplicates($pages, 'title');
        $categories = $this->removeDuplicates($categories, 'category');
        $documentcategories = $this->removeDuplicates($documentcategories, 'acronym');
        $modules = $this->removeDuplicates($modules, 'nametext');
        $groups = array_unique($groups, SORT_REGULAR);

        $data = array(
            'button' => 'Tambah',
            'action' => site_url('app/navigations/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
            'description' => set_value('description'),
            'position' => set_value('position'),
            'menu' => set_value('menu'),
            'session' => $this->sess,
            'pages' => $pages,
            'categories' => $categories,
            'documentcategories' => $documentcategories,
            'modules' => $modules,
            'groups' => $groups,
            'template' => 'navigations/navigations_form',
            'extracss' => 'navigations/navigations_form_extracss',
            'extrajs' => 'navigations/navigations_form_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'description' => $this->input->post('description', TRUE),
                'position' => $this->input->post('position', TRUE),
                'menu' => $this->input->post('nestable_menu_output', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Navigations_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/navigations'));
        }
    }

    public function update($id) {
        $row = $this->Navigations_model->get_by_id($id);
        $pages = $this->Pages_model->get_all(array('poststatus =' => 1));
        $categories = $this->Categories_model->get_all();
        $documentcategories = $this->Documentcategories_model->get_all();
        $modules = json_decode($this->config->item('site_modules'));
        // Fetch dynamic grouplists from Nondocumentcategories_model
        $nondocumentcategories = $this->Nondocumentcategories_model->get_all();
        $groups = [];
        foreach ($nondocumentcategories as $category) {
            $groups[$category->group_key] = $category->group_name;
        }

        // Remove duplicates
        $pages = $this->removeDuplicates($pages, 'title');
        $categories = $this->removeDuplicates($categories, 'category');
        $documentcategories = $this->removeDuplicates($documentcategories, 'acronym');
        $modules = $this->removeDuplicates($modules, 'nametext');
        $groups = array_unique($groups, SORT_REGULAR);

        // Remove duplicates from menu
        $menu = json_decode($row->menu);
        $unique_menu = [];
        $ids = [];
        if ($menu) {
            foreach ($menu as $item) {
                if (!in_array($item->id, $ids)) {
                    $unique_menu[] = $item;
                    $ids[] = $item->id;
                }
            }
        }

        if ($row) {
            $data = array(
                'button' => 'Perbaharui',
                'action' => site_url('app/navigations/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
                'description' => set_value('description', $row->description),
                'position' => set_value('position', $row->position),
                'menu' => $unique_menu,
                'session' => $this->sess,
                'pages' => $pages,
                'categories' => $categories,
                'documentcategories' => $documentcategories,
                'modules' => $modules,
                'groups' => $groups,
                'template' => 'navigations/navigations_form',
                'extracss' => 'navigations/navigations_form_extracss',
                'extrajs' => 'navigations/navigations_form_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/navigations'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'description' => $this->input->post('description', TRUE),
                'position' => $this->input->post('position', TRUE),
                'menu' => $this->input->post('nestable_menu_output', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Navigations_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/navigations'));
        }
    }

    public function delete($id) {
        $row = $this->Navigations_model->get_by_id($id);

        if ($row) {
            $this->Navigations_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/navigations'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/navigations'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'trim|xss_clean');
        $this->form_validation->set_rules('position', 'position', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // Helper function to remove duplicates by key
    private function removeDuplicates($array, $key) {
        $unique = [];
        $keys = [];
        foreach ($array as $item) {
            $value = is_object($item) ? $item->$key : $item[$key];
            if (!in_array($value, $keys)) {
                $unique[] = $item;
                $keys[] = $value;
            }
        }
        return $unique;
    }
}

/* End of file Navigations.php */
/* Location: ./application/controllers/Navigations.php */