<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8">
            <title><?php echo $this->config->item('site_name') . " | " . $this->config->item('site_description') ?></title>
            <meta name="description" content="<?php echo $this->config->item('site_name') . " | " . $this->config->item('site_description') ?>"/>

            <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1"/>
            <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

            <!-- up to 10% speed up for external res -->
            <link rel="dns-prefetch" href="https://fonts.googleapis.com/"/>
            <link rel="dns-prefetch" href="https://fonts.gstatic.com/"/>
            <link rel="preconnect" href="https://fonts.googleapis.com/"/>
            <link rel="preconnect" href="https://fonts.gstatic.com/"/>
            <!-- preloading icon font is helping to speed up a little bit -->
            <link rel="preload" href="<?php echo site_url() ?>assets/web/fonts/flaticon/Flaticon.woff2" as="font" type="font/woff2" crossorigin/>
            <link rel="stylesheet" href="<?php echo site_url() ?>assets/web/css/core.min.css"/>
            <link rel="stylesheet" href="<?php echo site_url() ?>assets/web/css/vendor_bundle.min.css"/>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet"/>

            <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo site_url($this->config->item('site_icon')) ?>"/>
            <link rel="apple-touch-icon" href="<?php echo site_url($this->config->item('site_icon')) ?>"/>
            <?php
            if (isset($extracss)) {
                $this->load->view($extracss);
            }
            ?>
    </head>
    <body>