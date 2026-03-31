<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        parent::_auth($this->uri->uri_string());
        $this->sess = $this->session->logged_in;
    }

    public function index() {

        $filemngr = new \EdSDK\FlmngrServer\FlmngrServer;
        $filemngr::flmngrRequest(
                array(
                    'dirFiles' => $this->config->item('folder_upload'),
                )
        );
    }

}
