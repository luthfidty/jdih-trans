<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $sess;
    public $rolelist;
    public $vtotal, $vunique, $vdaily, $vmonthly;

    function __construct() {
        parent::__construct();
        $this->load->model('app/Settings_model');
        $this->load->model('app/Navigations_model');
        $this->load->model('auth/Routings_model');
        $this->load->model('Visitors_model');
        $this->_loadConfig();
        $this->_mobiledetect();
    }

    public function _loadConfig() {
        foreach ($this->Settings_model->get_all() as $s) {
            $this->config->set_item($s->setting_name, $s->setting_value);
        }
        $this->config->set_item('base_url', $this->config->item('site_url'));
        $this->config->set_item('site_url', $this->config->item('site_url'));

        foreach ($this->Navigations_model->get_all() as $menu) {
            $this->config->set_item($menu->position, $menu);
        }
    }

    function _mobiledetect() {
        $this->load->library('Mobiledetect');
        if ($this->mobiledetect->isMobile()) {
            $this->session->set_userdata('device', 'desktop');
//            // Detect mobile/tablet
//            if ($this->mobiledetect->isTablet()) {
//                echo 'Tablet Device Detected!<br/>';
//            } else {
//                echo 'Mobile Device Detected!<br/>';
//            }
//
//            // Detect platform
//            if ($this->mobiledetect->isiOS()) {
//                echo 'IOS';
//            } elseif ($this->mobiledetect->isAndroidOS()) {
//                echo 'ANDROID';
//            }
        } else {
            $this->session->set_userdata('device', 'desktop');
        }
    }

    public function _auth($uri) {
        if ($this->session->userdata('logged_in')) {
            return TRUE;
        } else {
            $this->session->unset_userdata('logged_in');
            $this->session->set_flashdata('message', 'Please login!');
            $this->session->set_flashdata('redirect_back', $uri);
            redirect(base_url('auth/auth'));
        }
    }

    public function _visitorCounter() {
        if (!$this->session->userdata('visitor_data')) {
            $ip = visitorip();
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $visitor_data = array(
                'visitorip' => $ip,
                'visitdate' => date('Y-m-d'),
                'visittime' => date('H:i:s'),
                'useragent' => $useragent,
            );
            $this->Visitors_model->insert($visitor_data);
            $this->session->set_userdata("visitor_data", $visitor_data);
        }
    }

}
