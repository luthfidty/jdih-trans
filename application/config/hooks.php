<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	https://codeigniter.com/user_guide/general/hooks.html
  |
 */
$hook['post_controller_constructor'] = function () {
//    if (!password_verify(str_replace(array('http:', 'https:', '/'), "", get_instance()->config->item('site_url')), get_instance()->config->item('encryption_key'))) {
//        echo '<center><strong style="font-size:30px;margin:0 auto;">' . base64_decode('TWVuZ2luc3RhbGwgU2NyaXB0IGRpIHRlbXBhdCBsYWluLCBkaWtlbmFrYW4gU2Fua3NpIFVVLUlURS4gRGFuIFNheWEgQmVyc3VtcGFoIFNpYWwgNyB0dXJ1bmFuIHNhbXBhaSB0dXJ1bmFuIGtlIDc3Nzc3') . '</strong></center>';
//    }
};
