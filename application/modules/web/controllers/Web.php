<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Web extends MY_Controller
{

    public $device;

    function __construct()
    {
        parent::__construct();
        parent::_visitorCounter();
        $this->load->model('Posts_model');
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('app/Externallinks_model');
        $this->load->model('Galleries_model');
        $this->load->model('Surveys_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', $this->config->item('site_limit_post'), 0, array('poststatus' => 1));
        $regulations = $this->Regulations_model->get_limit_data('regulation', 6, 0, array('published' => 'Publish'));
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', 2, 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        $survey = $this->Surveys_model->get_all_count();
        $data = array(
            'pojokuke' => $pojokuke,
            'latestpost' => $latestpost,
            'template' => $this->device . '/web',
            'documentcategory' => $documentcategory,
            'regulations' => $regulations,
            'mostvregulations' => $mostvregulations,
            'links' => $links,
            'survey' => $survey,
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function ajax_get_visitor_counter()
    {
        $msg = array(
            'status' => 'success',
            'vtotal' => $this->Visitors_model->get_all_count(),
            'vunique' => $this->Visitors_model->get_unique_count(),
            'vmonthly' => $this->Visitors_model->get_monthly_count(),
            'vdaily' => $this->Visitors_model->get_daily_count()
        );
        echo json_encode($msg);
    }

    public function jdih_integration_jdihn()
    {
        // Ambil data gabungan dari Model
        // Catatan: Pastikan Regulations_model sudah dimuat di __construct
        $data_integrasi = $this->Regulations_model->get_all_jdih_data();

        if (empty($data_integrasi)) {
            // Jika tidak ada data yang ditemukan, kembalikan array kosong
            $msg = array(
                'status' => 'success',
                'data' => [],
            );
        } else {
            // Jika ada data, kembalikan array data mentah yang sudah dibentuk di Model
            // Sesuai dengan format yang Anda inginkan (yaitu array of objects)
            $msg = $data_integrasi;
        }

        // Mengatur Content-Type header dan menampilkan output JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($msg));
    }

}
