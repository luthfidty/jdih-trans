<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nonregulations extends MY_Controller
{
    static $isPublished = array(1 => 'Publish', 2 => 'Draft', 3 => 'Archive', 4 => 'Pending');
    static $isStatus = array(1 => 'Berlaku', 2 => 'Tidak Berlaku', 3 => 'Dicabut', 4 => 'Mencabut', 5 => 'Diubah', 6 => 'Mengubah');
    public $where;

    function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Nonregulations_model');
        $this->load->model('Nondocumentcategories_model');
        $this->load->library('form_validation');

        // Remove restriction by setting neutral where condition
        $this->where = array('regulations.createdby>=' => 0);
    }
    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $category = urldecode($this->input->get('category', TRUE));
        $published = urldecode($this->input->get('published', TRUE));
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page', TRUE) : 10;
        $start = intval($this->input->get('start'));

        // Build the base URL with query parameters
        $query_params = array();
        if ($q !== '') {
            $query_params['q'] = urlencode($q);
        }
        if ($category !== '') {
            $query_params['category'] = urlencode($category);
        }
        if ($published !== '') {
            $query_params['published'] = urlencode($published);
        }
        if ($per_page !== '10') {
            $query_params['per_page'] = $per_page;
        }

        $config['base_url'] = base_url() . 'app/nonregulations/index' . ($query_params ? '?' . http_build_query($query_params) : '');
        $config['first_url'] = base_url() . 'app/nonregulations/index' . ($query_params ? '?' . http_build_query($query_params) : '');

        $config['per_page'] = in_array($per_page, [10, 25, 50, 100]) ? $per_page : 10;
        $config['page_query_string'] = TRUE;
        $where = $this->where;
        if ($category !== '') {
            $where['regulations.groups'] = $category;
        }
        if ($published !== '') {
            $where['regulations.published'] = $published;
        }
        $config['total_rows'] = $this->Nonregulations_model->total_rows($where, $q, array('regulations.isdeleted' => 0));
        $nonregulations = $this->Nonregulations_model->get_limit_data($where, $config['per_page'], $start, $q, array('regulations.isdeleted' => 0));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'nonregulations_data' => $nonregulations,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'groups' => $this->Nondocumentcategories_model->get_all_active(),
            'isStatus' => self::$isStatus,
            'isPublished' => self::$isPublished,
            'template' => 'nonregulations/nonregulations_list',
        );
        $this->load->view('base/content', $data);
    }
    public function pending()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page', TRUE) : 10;
        $start = intval($this->input->get('start'));

        // Build the base URL with query parameters
        $query_params = array();
        if ($q !== '') {
            $query_params['q'] = urlencode($q);
        }
        if ($per_page !== '10') { // Default is 10, only add if different
            $query_params['per_page'] = $per_page;
        }

        $config['base_url'] = base_url() . 'app/nonregulations/pending' . ($query_params ? '?' . http_build_query($query_params) : '');
        $config['first_url'] = base_url() . 'app/nonregulations/pending' . ($query_params ? '?' . http_build_query($query_params) : '');

        $config['per_page'] = in_array($per_page, [10, 25, 50, 100]) ? $per_page : 10; // Validate per_page
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Nonregulations_model->total_rows($this->where, $q, array('regulations.isdeleted' => 0), array('regulations.published' => 'Pending'));
        $nonregulations = $this->Nonregulations_model->get_limit_data($this->where, $config['per_page'], $start, $q, array('regulations.isdeleted' => 0), array('regulations.published' => 'Pending'));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'nonregulations_data' => $nonregulations,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'groups' => $this->Nondocumentcategories_model->get_all_active(),
            'isPublished' => self::$isPublished,
            'template' => 'nonregulations/nonregulations_pending',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id)
    {
        $row = $this->Nonregulations_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'groups' => $row->groups,
                'title' => $row->title,
                'documentcategory' => $row->documentcategory,
                'teu' => $row->teu,
                'callnumber' => $row->callnumber,
                'year' => $row->year,
                'assignmentplace' => $row->assignmentplace,
                'location' => $row->location,
                'edition' => $row->edition,
                'language' => $row->language,
                'isbnissnnumber' => $row->isbnissnnumber,
                'publisher' => $row->publisher,
                'description' => $row->description,
                'viewed' => $row->viewed,
                'downloaded' => $row->downloaded,
                'bookcoverfile' => json_decode($row->bookcover),
                'attachment' => json_decode($row->attachment),
                'published' => $row->published,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
                'username' => $row->username,
                'fullname' => $row->fullname,
                'userupdate' => $row->userupdate,
                'fullnameupdate' => $row->fullnameupdate,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'grouplists' => $this->Nondocumentcategories_model->get_all_active(),
                'isPublished' => self::$isPublished,
                'template' => 'nonregulations/nonregulations_read',
                'extracss' => 'nonregulations/nonregulations_extracss',
                'extrajs' => 'nonregulations/nonregulations_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/nonregulations'));
        }
    }

    // --- CREATE FUNCTION DENGAN publish_jdihn ---
    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('app/nonregulations/create_action'),
            'id' => set_value('id'),
            'groups' => set_value('groups'),
            'title' => set_value('title'),
            'teu' => set_value('teu'),
            'callnumber' => set_value('callnumber'),
            'year' => set_value('year'),
            'assignmentplace' => set_value('assignmentplace'),
            'location' => set_value('location'),
            'publisher' => set_value('publisher'),
            'edition' => set_value('edition'),
            'language' => set_value('language'),
            'isbnissnnumber' => set_value('isbnissnnumber'),
            'bookcover' => set_value('bookcover'),
            'attachment' => set_value('attachment'),
            'published' => set_value('published'),
            'curBookcover' => set_value('curBookcover'),
            'curattachment' => set_value('curAttachment'),
            'publish_jdihn' => set_value('publish_jdihn', '0'), // <-- FIELD BARU (Default 0)
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'isPublished' => self::$isPublished,
            'isStatus' => self::$isStatus,
            'grouplists' => $this->Nondocumentcategories_model->get_all_active(),
            'template' => 'nonregulations/nonregulations_form',
        );
        $this->load->view('base/content', $data);
    }

    // --- CREATE ACTION DENGAN publish_jdihn ---
    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $uuid = $this->uuid->v4();
            $bookcover = array();
            $attachment = array();

            // File Upload Logic
            if (!empty($_FILES['bookcover']['name'])) {
                $result = fileuploader($_FILES, "bookcover", $uuid, "jpg|jpeg|png", "public/documents/");
                if ($result['status'] == "success") {
                    $bookcover = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                }
            }
            if (!empty($_FILES['attachment']['name'])) {
                $result = fileuploader($_FILES, "attachment", $uuid, "pdf", "public/documents/");
                if ($result['status'] == "success") {
                    $attachment = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                }
            }

            $data = array(
                'groups' => $this->input->post('groups', TRUE),
                'title' => $this->input->post('title', TRUE),
                'slug' => url_title($this->input->post('title'), "-", TRUE),
                'teu' => $this->input->post('teu', TRUE),
                'callnumber' => $this->input->post('callnumber', TRUE),
                'year' => $this->input->post('year', TRUE),
                'assignmentplace' => $this->input->post('assignmentplace', TRUE),
                'location' => $this->input->post('location', TRUE),
                'publisher' => $this->input->post('publisher', TRUE),
                'language' => $this->input->post('language', TRUE),
                'edition' => $this->input->post('edition', TRUE),
                'isbnissnnumber' => $this->input->post('isbnissnnumber', TRUE),
                'bookcover' => json_encode($bookcover),
                'attachment' => json_encode($attachment),
                'published' => $this->input->post('published', TRUE),
                'publish_jdihn' => $this->input->post('publish_jdihn', TRUE), // <-- FIELD BARU DISIMPAN
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Nonregulations_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/nonregulations'));
        }
    }

    // --- UPDATE FUNCTION DENGAN publish_jdihn ---
    public function update($id)
    {
        $row = $this->Nonregulations_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('app/nonregulations/update_action'),
                'id' => set_value('id', $row->id),
                'groups' => set_value('groups', $row->groups),
                'title' => set_value('title', $row->title),
                'teu' => set_value('teu', $row->teu),
                'callnumber' => set_value('callnumber', $row->callnumber),
                'year' => set_value('year', $row->year),
                'assignmentplace' => set_value('assignmentplace', $row->assignmentplace),
                'location' => set_value('location', $row->location),
                'language' => set_value('language', $row->language),
                'publisher' => set_value('publisher', $row->publisher),
                'edition' => set_value('edition', $row->edition),
                'isbnissnnumber' => set_value('isbnissnnumber', $row->isbnissnnumber),
                'bookcover' => json_decode($row->bookcover),
                'attachment' => json_decode($row->attachment),
                'published' => set_value('published', $row->published),
                'publish_jdihn' => set_value('publish_jdihn', $row->publish_jdihn), // <-- FIELD BARU
                'curBookcover' => set_value('curBookcover', $row->bookcover),
                'curAttachment' => set_value('curAttachment', $row->attachment),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'isPublished' => self::$isPublished,
                'isStatus' => self::$isStatus,
                'grouplists' => $this->Nondocumentcategories_model->get_all_active(),
                'template' => 'nonregulations/nonregulations_form',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/nonregulations'));
        }
    }

    // --- UPDATE ACTION DENGAN publish_jdihn ---
    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $uuid = $this->uuid->v4();
            $bookcover = json_decode($this->input->post('curBookcover', TRUE));
            $attachment = json_decode($this->input->post('curAttachment', TRUE));

            // File Upload Logic
            if (!empty($_FILES['bookcover']['name'])) {
                $result = fileuploader($_FILES, "bookcover", $uuid, "jpg|jpeg|png", "public/documents/");
                if ($result['status'] == "success") {
                    $bookcover = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                }
            }
            if (!empty($_FILES['attachment']['name'])) {
                $result = fileuploader($_FILES, "attachment", $uuid, "pdf", "public/documents/");
                if ($result['status'] == "success") {
                    $attachment = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                }
            }

            $data = array(
                'title' => $this->input->post('title', TRUE),
                'slug' => url_title($this->input->post('title'), "-", TRUE),
                'groups' => $this->input->post('groups', TRUE),
                'teu' => $this->input->post('teu', TRUE),
                'callnumber' => $this->input->post('callnumber', TRUE),
                'year' => $this->input->post('year', TRUE),
                'assignmentplace' => $this->input->post('assignmentplace', TRUE),
                'location' => $this->input->post('location', TRUE),
                'publisher' => $this->input->post('publisher', TRUE),
                'language' => $this->input->post('language', TRUE),
                'edition' => $this->input->post('edition', TRUE),
                'isbnissnnumber' => $this->input->post('isbnissnnumber', TRUE),
                'bookcover' => json_encode($bookcover),
                'attachment' => json_encode($attachment),
                'published' => $this->input->post('published', TRUE),
                'publish_jdihn' => $this->input->post('publish_jdihn', TRUE), // <-- FIELD BARU DISIMPAN
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Nonregulations_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/nonregulations'));
        }
    }
    public function delete($id) {
        $row = $this->Nonregulations_model->get_by_id($id);

        if ($row) {
            $this->Nonregulations_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/nonregulations'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/nonregulations'));
        }
    }
    // --- RULES DENGAN publish_jdihn ---
    public function _rules()
    {
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('teu', 'teu', 'trim|required');
        $this->form_validation->set_rules('callnumber', 'callnumber', 'trim|required');
        $this->form_validation->set_rules('year', 'year', 'trim|required');
        $this->form_validation->set_rules('assignmentplace', 'assignmentplace', 'trim|required');
        $this->form_validation->set_rules('location', 'location', 'trim|required');
        $this->form_validation->set_rules('language', 'language', 'trim|required');
        $this->form_validation->set_rules('edition', 'edition', 'trim|required');
        $this->form_validation->set_rules('publisher', 'publisher', 'trim|required');
        $this->form_validation->set_rules('isbnissnnumber', 'isbnissnnumber', 'trim|required');
        $this->form_validation->set_rules('published', 'published', 'trim|required');
        $this->form_validation->set_rules('publish_jdihn', 'publish_jdihn', 'trim|required|in_list[0,1]'); // <-- RULE BARU
        $this->form_validation->set_rules('groups', 'groups', 'trim|required|callback_valid_group');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function valid_group($group)
    {
        $valid_groups = array_keys($this->Nondocumentcategories_model->get_all_active());
        if (!in_array($group, $valid_groups)) {
            $this->form_validation->set_message('valid_group', 'Kategori tidak valid.');
            return FALSE;
        }
        return TRUE;
    }
}