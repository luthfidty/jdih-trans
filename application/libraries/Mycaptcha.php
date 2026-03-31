<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;

class Mycaptcha {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function get_captcha()
    {
        $phrase = $this->generateMediumCode();

        $builder = new CaptchaBuilder($phrase);
        $builder
            ->setDistortion(false)             // Nonaktifkan distorsi
            ->setMaxBehindLines(0)             // Tidak ada garis belakang
            ->setMaxFrontLines(0)              // Tidak ada garis depan
            ->setBackgroundColor(255,255,255)  // Background putih
            ->setTextColor(0, 0, 0)            // Teks hitam
            ->build(160, 50);

        $this->CI->session->set_userdata('captchacode', $phrase);
        return $builder->inline(); // base64 image
    }

    public function refresh_captcha()
    {
        $phrase = $this->generateMediumCode();

        $builder = new CaptchaBuilder($phrase);
        $builder
            ->setDistortion(false)
            ->setMaxBehindLines(0)
            ->setMaxFrontLines(0)
            ->setBackgroundColor(255,255,255)
            ->setTextColor(0, 0, 0)
            ->build(160, 50);

        $this->CI->session->set_userdata('captchacode', $phrase);
        return ['image' => $builder->inline()];
    }

    private function generateMediumCode()
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $length = 5;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $code;
    }
}
