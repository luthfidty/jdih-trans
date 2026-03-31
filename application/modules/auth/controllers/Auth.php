<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends MY_Controller {

    public $uri_to = 'app';

    function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('mycaptcha');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect(site_url('app'));
        }

        $data = array(
            'username' => set_value('username'),
            'password' => set_value('password'),
            'captcha' => set_value('captcha'),
            'captchaimg' => $this->get_captcha(),
            'action' => site_url('auth/auth/login_action'),
            'forgot' => site_url('auth/auth/reset'),
            'redirect_back' => $this->session->userdata('redirect_back'),
        );
        $this->load->view("auth/auth/login", $data);
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect(site_url('app'));
        }
        $data = array(
            'username' => set_value('username'),
            'password' => set_value('password'),
            'captcha' => set_value('captcha'),
            'captchaimg' => $this->get_captcha(),
            'action' => site_url('auth/auth/login_action'),
            'forgot' => site_url('auth/auth/reset'),
            'redirect_back' => set_value('redirect_back', $this->session->userdata('redirect_back')),
        );
        $this->load->view("auth/auth/login", $data);
    }

    public function login_action() {
        $this->load->model("auth/Userdetails_model");
        $this->load->model("auth/Roledetails_model");
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
            $username = $this->input->post('username', TRUE);
            $password = sha1($this->config->item('encryption_key') . $this->input->post('password', TRUE));

            $userlogin = $this->Authentication_model->checklogin($username, $password);
            if (!empty($userlogin)) {
                if ($userlogin->status == 0) {

                    $userdata = $this->Userdetails_model->get_by_userid($userlogin->id);
                    $rolelist = $this->Roledetails_model->get_by_roleid($userlogin->role);
                    $menu = $this->myacl->_generateMenus(json_decode($rolelist->roledetail));
                    $button = $this->myacl->_generateButtons(json_decode($rolelist->roledetail));
                    $curlogin = date('Y-m-d H:i:s');
                    $session_data = array(
                        'id' => $userlogin->id,
                        'email' => $userlogin->email,
                        'username' => $userlogin->username,
                        'role' => $userlogin->role,
                        'rolename' => $rolelist->rolename,
                        'rolelist' => (array) json_decode($rolelist->roledetail),
                        'menus' => $menu,
                        'button' => $button,
                        'name' => $userdata->fullname,
                        'image' => $userdata->image,
                        'lastlogin' => $userlogin->lastlogin,
                    );
                    $this->Authentication_model->loginstat($userlogin->id, array('status' => 1, 'currentlogin' => $curlogin));
                    $this->session->set_userdata("logged_in", $session_data);
                    if (!empty($this->input->post('redirect_back', TRUE))) {
                        $this->uri_to = $this->input->post('redirect_back', TRUE);
                    }
                    $this->session->set_flashdata('message', 'Selamat Datang Kembali, ' . $session_data['name']);
                    redirect(site_url($this->uri_to));
                } elseif ($userlogin->status == 1) {
                    $userdata = $this->Userdetails_model->get_by_userid($userlogin->id);
                    $rolelist = $this->Roledetails_model->get_by_roleid($userlogin->role);
                    $menu = $this->myacl->_generateMenus(json_decode($rolelist->roledetail));
                    $button = $this->myacl->_generateButtons(json_decode($rolelist->roledetail));
                    $curlogin = date('Y-m-d H:i:s');
                    $session_data = array(
                        'id' => $userlogin->id,
                        'email' => $userlogin->email,
                        'username' => $userlogin->username,
                        'role' => $userlogin->role,
                        'rolename' => $rolelist->rolename,
                        'rolelist' => (array) json_decode($rolelist->roledetail),
                        'menus' => $menu,
                        'name' => $userdata->fullname,
                        'image' => $userdata->image,
                        'lastlogin' => $userlogin->lastlogin,
                    );
                    $this->Authentication_model->loginstat($userlogin->id, array('status' => 1, 'currentlogin' => $curlogin));
                    $this->session->set_userdata("logged_in", $session_data);
                    if (!empty($this->input->post('redirect_back', TRUE))) {
                        $this->uri_to = $this->input->post('redirect_back', TRUE);
                    }
                    $this->session->set_flashdata('message', 'Selamat Datang Kembali, ' . $session_data['name']);
                    redirect(site_url($this->uri_to));
                } else {
                    $this->session->set_flashdata('message', 'Anda sudah login di komputer lain, silahkan logout terlebih dahulu!');
                    redirect(site_url('auth/auth'));
                }
            } else {
                $this->session->set_flashdata('message', 'Username dan Katasandi mungkin salah atau user belum aktif, silahkan hubungu administrator atau cek email');
                redirect(site_url('auth/auth'));
            }
        }
    }

    public function logout() {
        $this->sess = $this->session->logged_in;
        $user = $this->Authentication_model->get_by_id($this->sess['id']);
        $this->Authentication_model->loginstat($this->sess['id'], array('status' => 0, 'currentlogin' => '0000-00-00 00:00:00', 'lastlogin' => $user->currentlogin));
        $this->session->unset_userdata('logged_in');
        redirect(site_url('auth/auth'));
    }

    public function reset($key = NULL) {
        if (!$key) {
            $data = array(
                'action' => site_url('auth/auth/reset_action'),
                'step' => 1,
                'stepbtn' => 1,
                'redirect_back' => $this->session->userdata('redirect_back'),
            );
            $this->load->view("auth/auth/reset", $data);
        } else {
            $user = $this->Users_model->get_by_resetkey($key);
            if ($user) {
                $now = (new DateTime())->format('Y-m-d H:i:s');
                if ($now > $user->resettime) {
                    $data = array(
                        'action' => site_url('auth/auth/reset_action'),
                        'step' => 1,
                        'stepbtn' => 1,
                        'redirect_back' => $this->session->userdata('redirect_back'),
                    );
                    $this->session->set_flashdata('message', array('type' => 'warning', 'message' => 'Waktu sesi atur ulang kata sandi habis. Silahkan ajukan pengaturan ulang'));
                    $this->load->view("auth/auth/reset", $data);
                } else {
                    $data = array(
                        'user' => $user,
                        'action' => site_url('auth/auth/reset_change_password'),
                        'step' => 2,
                        'stepbtn' => 1,
                        'redirect_back' => $this->session->userdata('redirect_back'),
                    );
                    $this->session->set_flashdata('message', array('type' => 'success', 'message' => 'Masukkan kata sandi baru anda'));
                    $this->load->view("auth/auth/reset", $data);
                }
            } else {
                $data = array(
                    'user' => $user,
                    'action' => site_url('auth/auth/reset'),
                    'step' => 3,
                    'stepbtn' => 0,
                    'redirect_back' => $this->session->userdata('redirect_back'),
                );
                $this->session->set_flashdata('message', array('type' => 'warning', 'message' => 'Kode Reset sudah tidak berlaku!'));
                $this->load->view("auth/auth/reset", $data);
            }
        }
    }

    public function reset_action() {

        $this->_rules2();
        if ($this->form_validation->run() == FALSE) {
            $this->reset();
        } else {
            $user = $this->Users_model->get_by_email($this->input->post('email', TRUE));
            if ($user) {
                $resetkey = str_replace("-", "", $this->uuid->v4());
                $expiretime = (new DateTime())->add(new DateInterval('P1D'))->format("Y-m-d H:i:s");

                $this->Users_model->update($user->id, array('resetkey' => $resetkey, 'resettime' => $expiretime));
                $this->load->library('email');
                $data = array('user' => $user, 'resetkey' => $resetkey);
                switch ($this->config->item('system_mailer')) {
                    case 'smtp':
                        $message = $this->load->view('auth/auth/templateemail', $data, TRUE);

                        $mail = new PHPMailer(true); //From email address and name
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->isSMTP();
                        $mail->Host = $this->config->item('smtp_host');
                        $mail->SMTPAuth = true;
                        $mail->Username = $this->config->item('smtp_user'); // ubah dengan alamat email Anda
                        $mail->Password = base64_decode($this->config->item('smtp_pass')); // ubah dengan password email Anda
                        $mail->SMTPSecure = $this->config->item('smtp_secure');
                        $mail->Port = $this->config->item('smtp_port');

                        $mail->From = $this->config->item('email_from');
                        $mail->FromName = $this->config->item('email_from_name'); //To address and name
                        $mail->addAddress($user->email); //Address to which recipient will reply
                        $mail->isHTML(true);
                        $mail->Subject = "Pemulihan Kata Sandi - " . $this->config->item('site_name');
                        $mail->Body = $message;
                        if (!$mail->send()) {
                            $this->session->set_flashdata('message', array('type' => 'warning', 'message' => 'Gagal Mengirim Tautan Perubahan Kata Sandi. Silahkan hubungi Administrator!'));
                        } else {
                            $this->session->set_flashdata('message', array('type' => 'success', 'message' => 'Silahkan cek email anda untuk link reset!'));
                        }

                        redirect(site_url('auth/auth/reset'));
                    default:

                        $to = $user->email;
                        $subject = 'Pemulihan Katasandi - ' . $this->config->item('site_name');

// Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
                        $headers .= 'From: ' . $this->config->item('email_from') . "\r\n";
                        $message = $this->load->view('auth/auth/templateemail', $data, TRUE);

                        mail($to, $subject, $message, $headers);

                        $this->session->set_flashdata('message', array('type' => 'success', 'message' => 'Silahkan cek email anda untuk link reset!'));
                        redirect(site_url('auth/auth/reset'));
                        break;
                }
            } else {
                $data = array(
                    'action' => site_url('auth/auth/reset_action'),
                    'step' => 1,
                    'stepbtn' => 1,
                    'redirect_back' => $this->session->userdata('redirect_back'),
                );

                $this->session->set_flashdata('message', array('type' => 'warning', 'message' => 'Alamat Email Address tidak ditemukan. Pastikan penulisan alamat Email Address dengan benar!'));
                $this->load->view("auth/auth/reset", $data);
            }
        }
    }

    public function reset_change_password() {
        $this->_rules3();
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('auth/reset/' . $this->input->post('userresetkey', TRUE)));
        } else {
            $user = $this->input->post('username', TRUE);
            $email = $this->input->post('useremail', TRUE);
            $data = array(
                'password' => sha1($this->config->item('encryption_key') . $this->input->post('newpassword', TRUE)),
                'resetkey' => '',
                'resettime' => '0000-00-00 00:00:00'
            );
            $validate = $this->Users_model->get_by_username_email($user, $email);
            if ($validate) {
                $this->Users_model->update($validate->id, $data);
                $this->session->set_flashdata('message', array('type' => 'success', 'message' => 'Password Sudah Diperbaharui!'));
                $data = array(
                    'step' => 3,
                    'stepbtn' => 0,
                );
                $this->load->view("auth/auth/reset", $data);
            }
        }
    }

    public function get_captcha()
    {
        
        return $this->mycaptcha->get_captcha();
    }

    public function refresh_captcha()
    {
        $captcha= $this->mycaptcha->refresh_captcha();
        echo json_encode($captcha);
    }

    public function captcha_validation($captcha)
    {
        if ($captcha != $this->session->userdata('captchacode')) {
            $this->form_validation->set_message('captcha_validation', 'The {field} code does not match!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('captcha', 'captcha', 'callback_captcha_validation');
        $this->form_validation->set_error_delimiters('<span class = "text-danger">', '</span>');
    }

    public function _rules2() {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('step', 'step', 'trim|required|numeric|xss_clean');
    }

    public function _rules3() {
        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('useremail', 'useremail', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('newpassword', 'newpassword', 'trim|required|xss_clean');
        $this->form_validation->set_rules('confpassword', 'confpassword', 'trim|required|matches[newpassword]|xss_clean');
        $this->form_validation->set_rules('step', 'step', 'trim|required|numeric|xss_clean');
    }

}
