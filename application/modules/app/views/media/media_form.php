<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Dropzone Form Container -->
<div class="bg-white border border-gray-200 shadow rounded-lg p-6 space-y-6">
    <div class="text-lg font-semibold text-gray-700">
        <?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?>
    </div>

    <!-- Dropzone Form -->
    <form method="post" action="<?php echo $action ?>" class="dropzone rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-6"
        id="dropzone" enctype="multipart/form-data">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    </form>

    <!-- Footer Buttons -->
    <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
        <a href="<?php echo site_url('app/media') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
            Kembali
        </a>
    </div>
</div>
