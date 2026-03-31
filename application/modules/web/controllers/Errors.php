<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Errors extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('base/content', array('template' => '404'));
    }

}
