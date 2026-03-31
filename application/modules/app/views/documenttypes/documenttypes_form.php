<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form Container -->
<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" class="space-y-6">
        <!-- Form Field -->
        <div>
            <label for="documenttype" class="block font-medium text-gray-700">
                Documenttype <?php echo form_error('documenttype') ?>
            </label>
            <input type="text" name="documenttype" id="documenttype" placeholder="Tipe Dokumen"
                value="<?php echo $documenttype; ?>"
                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        </div>

        <!-- Form Footer -->
        <div class="pt-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-600">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    <?php echo $button ?>
                </button>
                <a href="<?php echo site_url('app/documenttypes') ?>"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">Batal</a>
            </div>
        </div>
    </form>
</div>
