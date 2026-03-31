<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Galleries extends MY_Controller
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
        $this->load->model('Galleries_model');
        $this->load->model('Surveys_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {
        $start = intval($this->input->get('start'));

        $config['base_url'] = base_url() . 'web/galleries/index';
        $config['first_url'] = base_url() . 'web/galleries/index';

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Galleries_model->total_rows();
        $galleries = $this->Galleries_model->get_limit_data($config['per_page'], $start, array('poststatus' => 1));


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvdocuments' => $mostvdocuments,
            'galleries_data' => $galleries,
            'survey' => $survey,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'template' => $this->device . '/galleries',
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function category($subtype)
    {
        $start = intval($this->input->get('start'));

        $config['base_url'] = base_url() . 'web/galleries/category/' . $subtype;
        $config['first_url'] = base_url() . 'web/galleries/category/' . $subtype;

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Galleries_model->total_rows_by_subtype($subtype);
        $galleries = $this->Galleries_model->get_limit_data_by_subtype($subtype, $config['per_page'], $start, array('poststatus' => 1));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvdocuments' => $mostvdocuments,
            'galleries_data' => $galleries,
            'survey' => $survey,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'template' => $this->device . '/galleries',
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function detail($subtype, $id)
    {

        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $galleries = $this->Galleries_model->get_by_id($id, $subtype);
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvdocuments' => $mostvdocuments,
            'galleries_data' => $galleries,
            'survey' => $survey,
            'template' => $this->device . '/gallerydetail',
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

}
