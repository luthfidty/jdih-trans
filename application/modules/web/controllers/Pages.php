<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends MY_Controller
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
        $this->load->model('Surveys_model');
        $this->load->model('Galleries_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {
        redirect(site_url());
    }

    public function read($slug)
    {
        $pages = $this->Posts_model->get_by_slug('page', $slug);
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvdocuments = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $survey = $this->Surveys_model->get_all_count();
        if ($pages) {
            $this->Posts_model->update('page', $pages->id, array('viewed' => $pages->viewed + 1));
            $data = array(
                'pages' => $this->Posts_model->get_by_id('page', $pages->id),
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'category' => $category,
                'mostvdocuments' => $mostvdocuments,
                'template' => $this->device . '/pages',
                'extracss' => 'base/postdetail_extracss',
                'extrajs' => 'base/posts_extrajs',
                'survey' => $survey,
                'device' => $this->device
            );
        } else {
            $data = array(
                'pages' => '',
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'category' => $category,
                'mostvdocuments' => $mostvdocuments,
                'template' => $this->device . '/pages',
                'survey' => $survey,
                'device' => $this->device
            );
        }
        $this->load->view($this->device . '/base/content', $data);
    }

    public function like($id)
    {
        $curlike = $this->Posts_model->get_by_id('page', $id);
        if ($curlike) {
            $cl = $curlike->liked + 1;
            $data = array('liked' => $cl);
            $this->Posts_model->update('page', $id, $data);
            echo json_encode(array('status' => 'success', 'like' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

}
