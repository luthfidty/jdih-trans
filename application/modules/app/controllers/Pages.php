<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends MY_Controller {

    public $poststatus = array(1 => 'Published', 2 => 'Draft', 3 => 'Private', 4 => 'Trash', 5 => 'Pending');

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Pages_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/pages/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/pages/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/pages/index';
            $config['first_url'] = base_url() . 'app/pages/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pages_model->total_rows($q);
        $pages = $this->Pages_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pages_data' => $pages,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $this->poststatus,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'pages/pages_list',
            'extracss' => 'pages/pages_extracss',
            'extrajs' => 'pages/pages_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id) {
        $row = $this->Pages_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'guuid' => $row->guuid,
                'title' => $row->title,
                'slug' => $row->slug,
                'content' => $row->content,
                'postimage' => $row->postimage,
                'postimagethumb' => $row->postimagethumb,
                'type' => $row->type,
                'metapost' => $row->metapost,
                'keywords' => $row->keywords,
                'poststatus' => $row->poststatus,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
                'status' => $this->poststatus,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'pages/pages_read',
                'extracss' => 'pages/pages_extracss',
                'extrajs' => 'pages/pages_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/pages'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('app/pages/create_action'),
            'id' => set_value('id'),
            'guuid' => set_value('guuid'),
            'title' => set_value('title'),
            'slug' => set_value('slug'),
            'content' => set_value('content'),
            'postimage' => set_value('postimage'),
            'postimagethumb' => set_value('postimagethumb'),
            'metapost' => set_value('metapost'),
            'keywords' => set_value('keywords'),
            'commentstatus' => set_value('commentstatus'),
            'poststatus' => set_value('poststatus'),
            'status' => $this->poststatus,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'pages/pages_form',
            'extracss' => 'pages/pages_form_extracss',
            'extrajs' => 'pages/pages_form_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $uuid = $this->uuid->v4();
            $picture = "";
            $picthumb = "";
            if (!empty($_FILES['postimage'])) {
                $result = fileuploader($_FILES, "postimage", $uuid, "jpeg|jpg|png");
                if ($result['status'] == "success") {
                    $img = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => 'thumbs/thumb_' . $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                    $picture = $img;
                    $picthumb = $picture['filepath'] . "/" . $picture['filename'];
                    
                    imageresize($result['message']);
                }
            }
            $data = array(
                'guuid' => $uuid,
                'title' => $this->input->post('title', TRUE),
                'slug' => url_title($this->input->post('title', TRUE),"-",TRUE),
                'content' => str_replace("[removed]", "", $this->input->post('content', FALSE)),
                'postimage' => $picture['fullpath'],
                'postimagethumb' => $picthumb,
                'type' => 'page',
                'metapost' => $this->input->post('metapost', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'poststatus' => $this->input->post('poststatus', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Pages_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/pages'));
        }
    }

    public function update($id) {
        $row = $this->Pages_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('app/pages/update_action'),
                'id' => set_value('id', $row->id),
                'guuid' => set_value('guuid', $row->guuid),
                'title' => set_value('title', $row->title),
                'slug' => set_value('slug', $row->slug),
                'content' => set_value('content', $row->content),
                'postimage' => set_value('postimage', $row->postimage),
                'postimagethumb' => set_value('postimagethumb', $row->postimagethumb),
                'metapost' => set_value('metapost', $row->metapost),
                'keywords' => set_value('keywords', $row->keywords),
                'poststatus' => set_value('poststatus', $row->poststatus),
                'status' => $this->poststatus,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'pages/pages_form',
                'extracss' => 'pages/pages_form_extracss',
                'extrajs' => 'pages/pages_form_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/pages'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $uuid = $this->uuid->v4();
            $picture['fullpath'] = $this->input->post('curpostimage');
            $picthumb = $this->input->post('curpostimagethumb');
            if (!empty($_FILES['postimage']['name'])) {
                $result = fileuploader($_FILES, "postimage", $uuid, "jpeg|jpg|png");
                if ($result['status'] == "success") {
                    $img = array(
                        'fullpath' => $result['message']['fullpath'],
                        'filepath' => $result['message']['filepath'],
                        'filename' => 'thumbs/thumb_' . $result['message']['filename'],
                        'filetype' => $result['message']['filetype'],
                    );
                    $picture = $img;
                    $picthumb = $picture['filepath'] . "/" . $picture['filename'];
                    
                    imageresize($result['message']);
                }
            }
            $data = array(
                'title' => $this->input->post('title', TRUE),
                'slug' => url_title($this->input->post('title', TRUE),"-",TRUE),
                'content' => str_replace("[removed]", "", $this->input->post('content', FALSE)),
                'postimage' => $picture['fullpath'],
                'postimagethumb' => $picthumb,
                'type' => 'page',
                'metapost' => $this->input->post('metapost', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'poststatus' => $this->input->post('poststatus', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Pages_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/pages'));
        }
    }

    public function trash() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/pages/trash?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/pages/trash?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/pages/trash';
            $config['first_url'] = base_url() . 'app/pages/trash';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pages_model->total_rows($q, array('poststatus' => 4));
        $pages = $this->Pages_model->get_limit_data($config['per_page'], $start, $q, array('poststatus' => 4));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pages_data' => $pages,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $this->poststatus,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'pages/pages_trash',
            'extracss' => 'pages/pages_extracss',
            'extrajs' => 'pages/pages_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function delete($id) {
        $row = $this->Pages_model->get_by_id($id);

        if ($row) {
            $this->Pages_model->update($id, array('poststatus' => 4));
            $this->session->set_flashdata('message', 'Data sudah dihapus, silahkan cek tong sampah jika ingin mengembalikan data!');
            redirect(site_url('app/pages'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/pages'));
        }
    }

    public function restore($id) {
        $row = $this->Pages_model->get_by_id($id, $status = array('poststatus' => 4));

        if ($row) {
            $this->Pages_model->update($id, array('poststatus' => 1));
            $this->session->set_flashdata('message', 'Data sudah direstore sebagai draf!');
            redirect(site_url('app/pages/trash'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/pages/trash'));
        }
    }

    public function permanent_delete($id) {
        $row = $this->Pages_model->get_by_id($id, $status = array('poststatus' => 4));
        if ($row) {
            $this->Pages_model->delete($id);
            unlink($row->postimage);
            unlink($row->postimagethumb);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/pages/trash'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/pages/trash'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'content', 'trim|required');
        $this->form_validation->set_rules('metapost', 'metapost', 'trim|xss_clean');
        $this->form_validation->set_rules('keywords', 'keywords', 'trim|xss_clean');
        $this->form_validation->set_rules('poststatus', 'poststatus', 'trim|required|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-11-07 12:59:55 */
/* http://harviacode.com */