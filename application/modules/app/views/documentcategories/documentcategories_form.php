<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form Container -->
<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" class="space-y-6">
        <!-- Form Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Jenis / Kategori -->
            <div>
                <label for="category" class="block font-medium text-gray-700">
                    Jenis / Kategori <?php echo form_error('category') ?>
                </label>
                <input type="text" name="category" id="category" placeholder="Kategori Dokumen"
                    value="<?php echo $category; ?>"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            </div>

            <!-- Akronim / Singkatan -->
            <div>
                <label for="acronym" class="block font-medium text-gray-700">
                    Akronim / Singkatan <?php echo form_error('acronym') ?>
                </label>
                <input type="text" name="acronym" id="acronym" placeholder="Singkatan Kategori"
                    value="<?php echo $acronym; ?>"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            </div>
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
                <a href="<?php echo site_url('app/documentcategories') ?>"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">Batal</a>
            </div>
        </div>
    </form>
</div>
