<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>
        <?php echo empty($this->config->item('site_title')) ? $this->config->item('site_name') : $this->config->item('site_title') ?>
    </title>
    <meta name="description" content="<?php echo $this->config->item('site_name') ?>" />
    <meta name="author" content="<?php echo $this->config->item('default_author') ?>" />
    <link rel="shortcut icon" href="<?php echo base_url($this->config->item('site_icon')) ?>">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F1F45',
                        secondary: '#C09546'
                    },
                    fontFamily: {
                        opensans: ['"Open Sans"', 'sans-serif']
                    },
                    screens: {
                        tablet: '768px',
                        laptop: '1100px',
                        desktop: '1280px'
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Quill Custom Style -->
    <style>
        
    </style>

    <!-- Extra CSS -->
    <?php if (isset($extracss)) {
        $this->load->view($extracss);
    } ?>
</head>

<body>
    <div id="wrapper" class="clearfix">