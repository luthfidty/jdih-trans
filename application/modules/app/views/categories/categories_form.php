<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form Section -->
<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" class="space-y-6">
        <!-- Form Heading -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700">
                <?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?>
            </h2>
        </div>

        <!-- Form Fields -->
        <div class="space-y-4">
            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori <?php echo form_error('category') ?></label>
                <input type="text" name="category" id="category" placeholder="Kategori Artikel"
                    value="<?php echo $category; ?>"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">
                    Alias URL <span id="clickforedit" class="text-xs text-blue-600 italic ml-1">(Klik untuk edit)</span>
                    <?php echo form_error('slug') ?>
                </label>
                <input type="text" name="slug" id="slug" placeholder="Alias URL. Cth : kerja-sama-pemerintah"
                    value="<?php echo $slug; ?>"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Form Footer -->
        <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    <?php echo $button ?>
                </button>
                <a href="<?php echo site_url('app/categories') ?>"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
