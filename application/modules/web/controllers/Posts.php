<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Posts extends MY_Controller
{

    public $device;

    function __construct()
    {
        parent::__construct();
        parent::_visitorCounter();
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Categories_model');
        $this->load->model('Posts_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();

        $start = intval($this->input->get('start'));

        $config['base_url'] = base_url() . 'web/documents/category/';
        $config['first_url'] = base_url() . 'web/documents/category/';

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Posts_model->total_rows('post');
        $posts = $this->Posts_model->get_limit_data('post', $config['per_page'], $start, array('poststatus' => 1));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts' => $posts,
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvdocuments' => $mostvdocuments,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'template' => $this->device . '/posts',
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function category($slug)
    {
        $pcategory = $this->Categories_model->get_by_slug($slug);

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();

        $start = intval($this->input->get('start'));

        $config['base_url'] = base_url() . 'web/posts/category/' . $slug;
        $config['first_url'] = base_url() . 'web/posts/category/' . $slug;

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Posts_model->total_rows_slug_category('post', $pcategory->slug);
        $posts = $this->Posts_model->get_limit_data_slug_category('post', $pcategory->slug, $config['per_page'], $start, array('poststatus' => 1));


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts' => $posts,
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'currentdoccategory' => $pcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvdocuments' => $mostvdocuments,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'template' => $this->device . '/posts',
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function read($id)
    {
        $posts = $this->Posts_model->get_by_id('post', $id);
        $latestpost = $this->Posts_model->get_limit_data('post', $this->config->item('site_limit_post'), 0, array('poststatus' => 1));
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $pcategory = $this->Categories_model->get_by_id($posts->category);
        if ($posts) {
            $this->Posts_model->update('post', $posts->id, array('viewed' => $posts->viewed + 1));
            $postsexts = $this->Posts_model->get_random_data_slug_category('post', $pcategory->slug, 8);
            $data = array(
                'posts' => $this->Posts_model->get_by_id('post', $posts->id),
                'postsexts' => $postsexts,
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'category' => $category,
                'currentdoccategory' => $pcategory,
                'mostvdocuments' => $mostvdocuments,
                'template' => $this->device . '/postdetail',
                'extrajs' => 'base/posts_extrajs',
                'extracss' => 'base/postdetail_extracss',
                'device' => $this->device
            );
        } else {
            $data = array(
                'posts' => '',
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'category' => $category,
                'currentdoccategory' => $pcategory,
                'mostvdocuments' => $mostvdocuments,
                'template' => $this->device . '/postdetail',
                'device' => $this->device
            );
        }
        $this->load->view($this->device . '/base/content', $data);
    }

    public function like($id)
    {
        $curlike = $this->Posts_model->get_by_id('post', $id);
        if ($curlike) {
            $cl = $curlike->liked + 1;
            $data = array('liked' => $cl);
            $this->Posts_model->update('post', $id, $data);
            echo json_encode(array('status' => 'success', 'like' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

}
