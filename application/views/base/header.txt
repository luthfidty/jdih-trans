<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php echo empty($this->config->item('site_title')) ? $this->config->item('site_name') : $this->config->item('site_title') ?></title>
        <meta content="<?php echo $this->config->item('site_name') ?>" name="description" />
        <meta content="<?php echo $this->config->item('default_author') ?>" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo base_url($this->config->item('site_icon')) ?>">

        <!-- WEB FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

        <!-- CORE CSS -->
        <link href="<?php echo base_url() ?>assets/app/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- THEME CSS -->
        <link href="<?php echo base_url() ?>assets/app/css/essentials.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/app/fonts/fa5/css/all.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/app/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/app/css/color_scheme/blue.css" rel="stylesheet" type="text/css" id="color_scheme" />
        <?php
        if (isset($extracss)) {
            $this->load->view($extracss);
        }
        ?>
    </head>
    <body>


        <!-- WRAPPER -->
        <div id="wrapper" class="clearfix">
