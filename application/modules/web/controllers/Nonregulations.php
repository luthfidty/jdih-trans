<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nonregulations extends MY_Controller
{

    static $grouplists = array('monographs' => 'Monografi', 'jurisprudence' => 'Yurisprudensi', 'book' => 'Artikel Hukum', 'haki' => 'Hak Kekayaan Intelektual');
    public $device;

    function __construct()
    {
        parent::__construct();
        parent::_visitorCounter();
        $this->load->model('Nonregulations_model');
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Posts_model');
        $this->load->model('app/Externallinks_model');
        $this->load->model('Surveys_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {
        $start = intval($this->input->get('start'));
        $config['base_url'] = base_url() . 'web/nonregulations/index';
        $config['first_url'] = base_url() . 'web/nonregulations/index';

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Nonregulations_model->total_rows();
        $nonregulations = $this->Nonregulations_model->get_limit_data($config['per_page'], $start,array('published' => 'Publish'));

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'nonregulations' => $nonregulations,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'pojokuke' => $pojokuke,
            'mostvregulations' => $mostvregulations,
            'links' => $links,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'survey' => $survey,
            'device' => $this->device,
            'groups' => self::$grouplists,
            'template' => $this->device . '/nonregulations',
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function category($groups)
    {
        $start = intval($this->input->get('start'));
        $config['base_url'] = base_url() . 'web/nonregulations/category/' . $groups;
        $config['first_url'] = base_url() . 'web/nonregulations/category/' . $groups;

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Nonregulations_model->total_rows_by_groups($groups);
        $nonregulations = $this->Nonregulations_model->get_limit_data_by_groups($groups, 9, $start);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'nonregulations' => $nonregulations,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'pojokuke' => $pojokuke,
            'mostvregulations' => $mostvregulations,
            'links' => $links,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'survey' => $survey,
            'device' => $this->device,
            'currentgroups' => $groups,
            'groups' => self::$grouplists,
            'template' => $this->device . '/nonregulations',
        );

        $this->load->view($this->device . '/base/content', $data);
    }

    public function read($group, $id)
    {
        $nonregulations = $this->Nonregulations_model->get_by_id($group, $id, array('published' => 'Publish'));

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        if ($nonregulations) {
            $this->Nonregulations_model->update($nonregulations->id, $nonregulations->groups, array('viewed' => $nonregulations->viewed + 1));
            $nonsingle = $this->Nonregulations_model->get_by_id($group, $nonregulations->id, array('published' => 'Publish'));
            $nonregulationsexts = $this->Nonregulations_model->get_random_by_groups(
                $group,
                7,
            );
            $data = array(
                'nonregulations' => $nonsingle,
                'nonregulationsexts' => $nonregulationsexts,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'pojokuke' => $pojokuke,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/nonregulationdetail',
                'extrajs' => 'base/nonregulations_extrajs',
                'survey' => $survey,
                'device' => $this->device,
                'currentgroups' => $group,
                'groups' => self::$grouplists,
            );
        } else {
            $data = array(
                'nonregulations' => '',
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/nonregulationdetail',
                'survey' => $survey,
                'device' => $this->device,
                'currentgroups' => $group,
                'groups' => self::$grouplists,
            );
        }
        $this->load->view($this->device . '/base/content', $data);
    }

    public function like($group, $id)
    {
        $curlike = $this->Nonregulations_model->get_by_id($group, $id);
        if ($curlike) {
            $cl = $curlike->liked + 1;
            $data = array('liked' => $cl);
            $this->Nonregulations_model->update($id, $group, $data);
            echo json_encode(array('status' => 'success', 'like' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function downloadcount($group, $id)
    {
        $curdown = $this->Nonregulations_model->get_by_id($group, $id);
        if ($curdown) {
            $cl = $curdown->downloaded + 1;
            $data = array('downloaded' => $cl);
            $this->Nonregulations_model->update($id, $group, $data);
            echo json_encode(array('status' => 'success', 'downloaded' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

}
