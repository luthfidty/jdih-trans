<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
  Default route Godesa
 */
$route['default_controller'] = 'web/Web';
$route['translate_uri_dashes'] = FALSE;
/* Route Web Module for pages */
$route['web/pages/(:any)'] = 'web/Pages/index';
