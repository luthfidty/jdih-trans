<?php
$this->load->view('base/header');

?>
<!-- Start right Content here -->


<!-- HEADER -->
<div x-data="{ collapsed: false }">
    <!-- HEADER -->
    <?php
    $this->load->view('base/nav');

    ?>

    <!-- /HEADER -->
    <!-- Konten -->
    <main :class="collapsed ? 'ml-20' : 'ml-64'"
        class="pt-16 px-4 pb-4 min-h-screen bg-gray-50 transition-all duration-200 overflow-x-hidden">




        <section id="middle" class="mt-4">
            <?php $this->load->view($template); ?>
        </section>
    </main>
</div>
<!-- /MIDDLE -->
<!-- End Right content here -->
<?php
$this->load->view('base/footer');
