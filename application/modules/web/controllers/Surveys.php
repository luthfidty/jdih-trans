<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Surveys extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Surveys_model');
    }

    public function submit($value) {
        $ip = visitorip();
        $data = array('ipaddress' => $ip, 'svalue' => $value);
        $this->Surveys_model->insert($data);
        echo json_encode(array('status' => 'success', 'message' => array('ip' => $ip, 'value' => $value)));
    }

}
