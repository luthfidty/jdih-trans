<?php

defined('BASEPATH') or exit('No direct script access allowed');

class App extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
        $this->load->model('Regulations_model');
        $this->load->model('Posts_model');
        $this->load->model('Nonregulations_model');
        $this->load->model('Galleries_model');
        $this->load->model('Visitors_model');
        $this->load->model('Surveys_model');
        $this->load->model('Media_model');

    }

    public function index()
    {
        $regulations = $this->Regulations_model->total_docs();
        $yearlydocs = $this->Regulations_model->get_total_doc_by_year();
        $numdocscat = $this->Regulations_model->get_total_doc_by_category();
        $rawSurvey = $this->Surveys_model->get_all_count();
        $rawMedia = $this->Media_model->get_all_count();

        $survey = (object) [
            'suka' => (int) ($rawSurvey->count_1 ?? 0) + (int) ($rawSurvey->count_2 ?? 0),
            'tidakSuka' => (int) ($rawSurvey->count_3 ?? 0) + (int) ($rawSurvey->count_4 ?? 0),
        ];
        $dvisitor = $this->Visitors_model->get_weekly_count();
        $pubPost = $this->Posts_model->get_all();
        $publishDoc = $this->Regulations_model->get_all(array('regulations.isdeleted' => 0), array('regulations.published' => 'Publish'));

        $pendingDoc = $this->Regulations_model->get_all(array('regulations.isdeleted' => 0), array('regulations.published' => 'Pending'));
        $pendingNonreg = $this->Nonregulations_model->get_all(array('regulations.isdeleted' => 0), array('regulations.published' => 'Pending'));
        $pubNonreg = $this->Nonregulations_model->get_all(array('regulations.isdeleted' => 0), array('regulations.published' => 'Publish'));
        $pubGal = $this->Galleries_model->get_all(array('poststatus ' => 1));
        $data = array(
            'regulations' => $regulations,
            'yearlydocs' => $yearlydocs,
            'numdocscat' => $numdocscat,
            'survey' => $survey,
            'dvisitor' => $dvisitor,
            'pubDoc' => count($publishDoc),
            'pendDoc' => count($pendingDoc),
            'pendNon' => count($pendingNonreg),
            'pubNon' => count($pubNonreg),
            'allSurvey' => ($rawSurvey->count_1 ?? 0) + ($rawSurvey->count_2 ?? 0) + ($rawSurvey->count_3 ?? 0) + ($rawSurvey->count_4 ?? 0),
            'allMedia' => $rawMedia,
            'pubPost' => count($pubPost),
            'pubGal' => count($pubGal),
            "template" => 'app/app/dashboard',
            "extrajs" => 'app/app/dashboard_extrajs',
            "session" => $this->sess,
        );
        $this->load->view('base/content', $data);
    }

}
