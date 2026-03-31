<?php $this->load->view($device . '/base/header') ?>
<div id="wrapper">
    <?php $this->load->view($device . '/base/nav') ?>
    <!-- CONTENT  -->
    <div class="section pt-0 mt-16">
        <?php $this->load->view($template) ?>
    </div>
    <?php
    $this->load->view($device . '/base/footer');
