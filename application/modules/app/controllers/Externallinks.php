<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Externallinks extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Externallinks_model');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/externallinks/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/externallinks/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/externallinks/index';
            $config['first_url'] = base_url() . 'app/externallinks/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Externallinks_model->total_rows($q);
        $externallinks = $this->Externallinks_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'externallinks_data' => $externallinks,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'externallinks/externallinks_list',
        );
        $this->load->view('base/content', $data);
    }

    public function create()
    {
        //$roles = $this->ifroled ? $this->Roles_model->get_by_id($this->sess['role']) : $this->Roles_model->get_all();
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('app/externallinks/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
            'addressurl' => set_value('addressurl'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'externallinks/externallinks_form',
        );
        $this->load->view('base/content', $data);
    }

    public function create_action()
    {
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
                'title' => $this->input->post('name', TRUE),
                'content' => $this->input->post('addressurl', TRUE),
                'postimage' => $picture['fullpath'],
                'postimagethumb' => $picthumb,
                'type' => 'link',
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Externallinks_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/externallinks'));
        }
    }

    public function update($id)
    {
        $row = $this->Externallinks_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Perbaharui',
                'action' => site_url('app/externallinks/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->title),
                'addressurl' => set_value('addressurl', $row->content),
                'postimage' => set_value('postimage', $row->postimage),
                'postimagethumb' => set_value('postimagethumb', $row->postimagethumb),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'externallinks/externallinks_form',
            );

            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/externallinks'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $picture['fullpath'] = $this->input->post('curpostimage');
            $picthumb = $this->input->post('curpostimagethumb');
            $uuid = $this->uuid->v4();
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
                'title' => $this->input->post('name', TRUE),
                'content' => $this->input->post('addressurl', TRUE),
                'postimage' => $picture['fullpath'],
                'postimagethumb' => $picthumb,
                'type' => 'link',
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Externallinks_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/externallinks'));
        }
    }

    public function delete($id)
    {
        $row = $this->Externallinks_model->get_by_id($id);

        if ($row) {
            $this->Externallinks_model->delete($id);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/externallinks'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/externallinks'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('addressurl', 'addressurl', 'trim|required|valid_url|xss_clean');

        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Externallinks.php */
/* Location: ./application/controllers/Externallinks.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-11-07 12:59:55 */
/* http://harviacode.com */