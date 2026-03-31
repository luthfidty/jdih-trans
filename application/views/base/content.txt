<?php
$this->load->view('base/header');
$this->load->view('base/nav');
?>
<!-- Start right Content here -->

<section id="middle">
    <?php $this->load->view($template) ?>
</section>
<!-- /MIDDLE -->
<!-- End Right content here -->
<?php
$this->load->view('base/footer');
