<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts extends MY_Controller
{
    public $poststatus = array(1 => 'Published', 2 => 'Draft', 3 => 'Private', 4 => 'Trash', 5 => 'Pending');
    public $where, $wherecat;

    function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Posts_model');
        $this->load->model('Categories_model');
        $this->load->model('auth/Roles_model');
        $this->load->library('form_validation');

        // Remove restriction by setting neutral where conditions
        $this->where = array('posts.createdby>=' => 0);
        $this->wherecat = array('createdby>=' => 0);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $poststatus = urldecode($this->input->get('poststatus', TRUE)); // Tambahan filter poststatus
        $start = intval($this->input->get('start'));
        $per_page = intval($this->input->get('per_page', TRUE)) ?: 10;

        // Build base URL for pagination
        $url_params = [];
        if ($q !== '')
            $url_params['q'] = urlencode($q);
        if ($poststatus !== '')
            $url_params['poststatus'] = urlencode($poststatus);
        $base_url = base_url() . 'app/posts/index' . ($url_params ? '?' . http_build_query($url_params) : '');
        $config['base_url'] = $base_url;
        $config['first_url'] = $base_url;

        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;

        // Set status filter
        $status = $poststatus !== '' ? array('posts.poststatus' => $poststatus) : array('posts.poststatus !=' => 4);

        $config['total_rows'] = $this->Posts_model->total_rows($this->where, $q, $status);
        $posts = $this->Posts_model->get_limit_data($this->where, $config['per_page'], $start, $q, $status);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts_data' => $posts,
            'q' => $q,
            'poststatus' => $poststatus, // Tambahan untuk form filter
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $this->poststatus,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'posts/posts_list',
            'extracss' => 'posts/posts_extracss',
            'extrajs' => 'posts/posts_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id)
    {
        $row = $this->Posts_model->get_by_id('post', $id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'guuid' => $row->guuid,
                'title' => $row->title,
                'slug' => $row->slug,
                'content' => $row->content,
                'category' => $row->category,
                'postimage' => $row->postimage,
                'postimagethumb' => $row->postimagethumb,
                'type' => $row->type,
                'metapost' => $row->metapost,
                'keywords' => $row->keywords,
                'commentstatus' => $row->commentstatus,
                'poststatus' => $row->poststatus,
                'status' => $this->poststatus,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'posts/posts_read',
                'extracss' => 'posts/posts_extracss',
                'extrajs' => 'posts/posts_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/posts'));
        }
    }

    public function create()
    {
        $categories = $this->Categories_model->get_all($this->wherecat);
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('app/posts/create_action'),
            'id' => set_value('id'),
            'guuid' => set_value('guuid'),
            'title' => set_value('title'),
            'slug' => set_value('slug'),
            'content' => set_value('content'),
            'category' => set_value('category'),
            'postimage' => set_value('postimage'),
            'postimagethumb' => set_value('postimagethumb'),
            'type' => set_value('type'),
            'metapost' => set_value('metapost'),
            'keywords' => set_value('keywords'),
            'commentstatus' => set_value('commentstatus'),
            'poststatus' => set_value('poststatus'),
            'status' => $this->poststatus,
            'categories' => $categories,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'posts/posts_form',
            'extracss' => 'posts/posts_form_extracss',
            'extrajs' => 'posts/posts_form_extrajs',
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
            $picture_path = "";
            $picthumb_path = "";

            // Perbaikan: Tambahkan ['name'] agar tidak error jika form kosong
            if (!empty($_FILES['postimage']['name'])) { 
                // Anda bisa menambahkan format lain di sini jika diperlukan, misal: "jpeg|jpg|png|JPG|PNG"
                $result = fileuploader($_FILES, "postimage", $uuid, "jpeg|jpg|png|JPG|PNG|webp"); 
                
                if ($result['status'] == "success") {
                    $picture_path = $result['message']['fullpath'];
                    $picthumb_path = $result['message']['filepath'] . "/thumbs/thumb_" . $result['message']['filename'];

                    imageresize($result['message']);
                } else {
                    // Opsi: Jika ingin memunculkan error saat upload gagal
                    $this->session->set_flashdata('message', 'Gagal meng-upload gambar: Cek format atau ukuran file.');
                }
            }

            $data = array(
                'guuid' => $uuid,
                'title' => $this->input->post('title', TRUE),
                'slug' => url_title($this->input->post('title', TRUE), "-", TRUE),
                'content' => str_replace("[removed]", "", $this->input->post('content', FALSE)),
                'category' => $this->input->post('category', TRUE),
                'postimage' => $picture_path,      // Gunakan variabel yang sudah diperbaiki
                'postimagethumb' => $picthumb_path, // Gunakan variabel yang sudah diperbaiki
                'type' => 'post',
                'metapost' => $this->input->post('metapost', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'poststatus' => $this->input->post('poststatus', TRUE),
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Posts_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/posts'));
        }
    }

    public function update($id)
    {
        $row = $this->Posts_model->get_by_id($id);
        $categories = $this->Categories_model->get_all($this->wherecat);
        $roles = $this->ifroled ? $this->Roles_model->get_by_id($this->sess['role']) : $this->Roles_model->get_all();
        if ($row) {
            $data = array(
                'button' => 'Perbaharui',
                'action' => site_url('app/posts/update_action'),
                'id' => set_value('id', $row->id),
                'guuid' => set_value('guuid', $row->guuid),
                'title' => set_value('title', $row->title),
                'slug' => set_value('slug', $row->slug),
                'content' => set_value('content', $row->content),
                'category' => set_value('category', $row->category),
                'postimage' => set_value('postimage', $row->postimage),
                'postimagethumb' => set_value('postimagethumb', $row->postimagethumb),
                'type' => set_value('type', $row->type),
                'metapost' => set_value('metapost', $row->metapost),
                'keywords' => set_value('keywords', $row->keywords),
                'poststatus' => set_value('poststatus', $row->poststatus),
                'status' => $this->poststatus,
                'categories' => $categories,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'template' => 'posts/posts_form',
                'extracss' => 'posts/posts_form_extracss',
                'extrajs' => 'posts/posts_form_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/posts'));
        }
    }

    public function update_action()
    {
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
                'slug' => url_title($this->input->post('title', TRUE), "-", TRUE),
                'content' => str_replace("[removed]", "", $this->input->post('content', FALSE)),
                'category' => $this->input->post('category', TRUE),
                'postimage' => $picture['fullpath'],
                'postimagethumb' => $picthumb,
                'type' => 'post',
                'metapost' => $this->input->post('metapost', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'poststatus' => $this->input->post('poststatus', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Posts_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/posts'));
        }
    }

    public function trash()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $per_page = intval($this->input->get('per_page', TRUE)) ?: 10;

        if ($q <> '') {
            $config['base_url'] = base_url() . 'app/posts/trash?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'app/posts/trash?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'app/posts/trash';
            $config['first_url'] = base_url() . 'app/posts/trash';
        }

        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Posts_model->total_rows($this->where, $q, array('posts.poststatus' => 4));
        $posts = $this->Posts_model->get_limit_data($this->where, $config['per_page'], $start, $q, array('posts.poststatus' => 4));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts_data' => $posts,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $this->poststatus,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'posts/posts_trash',
            'extracss' => 'posts/posts_extracss',
            'extrajs' => 'posts/posts_extrajs',
        );
        $this->load->view('base/content', $data);
    }

    public function delete($id)
    {
        $row = $this->Posts_model->get_by_id($id);
        if ($row) {
            $this->Posts_model->update($id, array('poststatus' => 4));
            $this->session->set_flashdata('message', 'Data sudah dihapus, silahkan cek tong sampah jika ingin mengembalikan data!');
            redirect(site_url('app/posts'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/posts'));
        }
    }

    public function bulk_delete()
    {
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids) && is_array($ids)) {
            $success_count = 0;
            foreach ($ids as $id) {
                $row = $this->Posts_model->get_by_id($id);
                if ($row) {
                    $this->Posts_model->update($id, array('poststatus' => 4));
                    $success_count++;
                }
            }
            if ($success_count > 0) {
                $this->session->set_flashdata('message', "$success_count data sudah dihapus, silahkan cek tong sampah jika ingin mengembalikan data!");
            } else {
                $this->session->set_flashdata('message', 'Tidak ada data yang berhasil dihapus!');
            }
        } else {
            $this->session->set_flashdata('message', 'Tidak ada data yang dipilih untuk dihapus!');
        }
        redirect(site_url('app/posts'));
    }

    public function bulk_permanent_delete()
    {
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids) && is_array($ids)) {
            $success_count = 0;
            foreach ($ids as $id) {
                $row = $this->Posts_model->get_by_id($id, array('poststatus' => 4));
                if ($row) {
                    $this->Posts_model->delete($id);
                    if (file_exists($row->postimage)) {
                        unlink($row->postimage);
                    }
                    if (file_exists($row->postimagethumb)) {
                        unlink($row->postimagethumb);
                    }
                    $success_count++;
                }
            }
            if ($success_count > 0) {
                $this->session->set_flashdata('message', "$success_count data sudah dihapus secara permanen!");
            } else {
                $this->session->set_flashdata('message', 'Tidak ada data yang berhasil dihapus!');
            }
        } else {
            $this->session->set_flashdata('message', 'Tidak ada data yang dipilih untuk dihapus!');
        }
        redirect(site_url('app/posts/trash'));
    }

    public function restore($id)
    {
        $row = $this->Posts_model->get_by_id($id, array('poststatus' => 4));
        if ($row) {
            $this->Posts_model->update($id, array('poststatus' => 2));
            $this->session->set_flashdata('message', 'Data sudah direstore sebagai draf!');
            redirect(site_url('app/posts/trash'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/posts/trash'));
        }
    }

    public function permanent_delete($id)
    {
        $row = $this->Posts_model->get_by_id($id, array('poststatus' => 4));
        if ($row) {
            $this->Posts_model->delete($id);
            if (file_exists($row->postimage)) {
                unlink($row->postimage);
            }
            if (file_exists($row->postimagethumb)) {
                unlink($row->postimagethumb);
            }
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/posts/trash'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/posts/trash'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'content', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('metapost', 'metapost', 'trim|xss_clean');
        $this->form_validation->set_rules('keywords', 'keywords', 'trim|xss_clean');
        $this->form_validation->set_rules('poststatus', 'poststatus', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}