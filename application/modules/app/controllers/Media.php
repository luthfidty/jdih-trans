<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends MY_Controller {

    function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Media_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/media/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/media/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/media/index';
            $config['first_url'] = base_url() . 'app/media/index';
        }

        $config['per_page'] = 12;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Media_model->total_rows($q);
        $media = $this->Media_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'media_data' => $media,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'media/media_list',
            'extrajs' => 'media/media_list_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('app/media/create_action'),
            'id' => set_value('id'),
            'filename' => set_value('filename'),
            'filepath' => set_value('filepath'),
            'fullpath' => set_value('fullpath'),
            'filetype' => set_value('filetype'),
            'descriptions' => set_value('descriptions'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'media/media_form',
            'extracss' => 'media/media_form_extracss',
            'extrajs' => 'media/media_form_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action() {
        $uuid = $this->uuid->v4();
        $picture = "";
        $picthumb = "";
        if (!empty($_FILES['file'])) {
            $result = fileuploader($_FILES, "file", $uuid, "zip|rar|gif|jpeg|jpg|png|doc|docx|ppt|pdf|pptx|xls|xlsx|txt|rtf|mp4|avi");
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

                $data = array(
                    'filename' => $img['filename'],
                    'filepath' => $img['filepath'],
                    'fullpath' => $img['fullpath'],
                    'filetype' => $img['filetype'],
                    'descriptions' => '',
                    'createdat' => date('Y-m-d H:i:s'),
                    'createdby' => $this->sess['id'],
                    'updatedat' => date('Y-m-d H:i:s'),
                    'updatedby' => $this->sess['id'],
                );
                $this->Media_model->insert($data);
                $response = array(
                    'status' => 'ok',
                    'message' => 'Upload success',
                    'token' => $this->security->get_csrf_hash()
                );
                $this->output
                        ->set_status_header(200)
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => $result['message'],
                    'token' => $this->security->get_csrf_hash()
                );
                $this->output
                        ->set_status_header(500)
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }

    public function ajax_get_by_type($type) {
        $file = $this->Media_model->get_all_by_type($type);
        if ($file) {
            echo json_encode($file);
        }
    }

    public function delete($id) {
        $row = $this->Media_model->get_by_id($id);

        if ($row) {
            $this->Media_model->delete($id);
            unlink($row->fullpath);
            unlink($row->filepath . "/" . $row->filename);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/media'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/media'));
        }
    }

}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-11-07 12:59:55 */
/* http://harviacode.com */