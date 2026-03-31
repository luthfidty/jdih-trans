<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form Container -->
<div class="bg-white shadow rounded-lg p-6">

    <form method="post" action="<?php echo $action ?>" enctype="multipart/form-data" autocomplete="off"
        class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Form (Title & Content) -->
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <label for="title" class="block font-medium text-gray-700">Judul
                        <?php echo form_error('title') ?></label>
                    <input type="text" name="title" id="title" placeholder="Judul" value="<?php echo $title; ?>"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                </div>
                <div class="mb-4">
                    <label for="content" class="block font-medium text-gray-700">Konten
                        <?php echo form_error('content') ?>
                    </label>
                   <textarea name="content" id="pagecontent" rows="6"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $content ?></textarea>
                </div>



            </div>

            <!-- Right Form (Gambar, Meta, Status) -->
            <div class="space-y-4">
                <div>
                    <label class="block font-medium text-gray-700">Gambar <?php echo form_error('postimage') ?></label>
                    <input type="file" name="postimage" id="postimage"
                        class="mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded px-3 py-2" />
                    <?php if (!empty($postimage)) { ?>
                        <div class="mt-2">
                            <a href="<?php echo site_url($postimage) ?>" class="block w-fit" target="_blank">
                                <img src="<?php echo site_url($postimagethumb) ?>" alt="<?php echo $title ?>"
                                    class="h-32 rounded border" />
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <label for="metapost" class="block font-medium text-gray-700">Meta Deskripsi
                        <?php echo form_error('metapost') ?></label>
                    <input type="text" name="metapost" id="metapost" value="<?php echo $metapost; ?>"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                </div>
                <div>
                    <label for="keywords" class="block font-medium text-gray-700">Kata Kunci Pencarian
                        <?php echo form_error('keywords') ?></label>
                    <input type="text" name="keywords" id="keywords" value="<?php echo $keywords; ?>"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                </div>
                 <input type="hidden" name="poststatus" value="1">
            </div>
        </div>

        <!-- Form Footer -->
        <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="curpostimage" value="<?php echo $postimage ?>" />
                <input type="hidden" name="curpostimagethumb" value="<?php echo $postimagethumb ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    <?php echo $button ?>
                </button>
                <a href="<?php echo site_url('app/pages') ?>"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">Batal</a>
            </div>
        </div>
    </form>
</div>