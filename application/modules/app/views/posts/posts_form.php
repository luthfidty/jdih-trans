<?php
$this->load->view('base/headercontent');
?>
<!-- /Page Title -->

<!-- Form Container -->
<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" enctype="multipart/form-data" autocomplete="off" class="space-y-6" id="postForm">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left (Title & Content) -->
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <label for="title" class="block font-medium text-gray-700">Judul <?php echo form_error('title') ?></label>
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>" placeholder="Judul"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500" />
                </div>
                <div>
                    <label for="content" class="block font-medium text-gray-700">Konten <?php echo form_error('content') ?></label>
                    <textarea name="content" id="pagecontent" rows="6"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $content ?></textarea>
                </div>
            </div>

            <!-- Right (Kategori, Gambar, Meta) -->
            <div class="space-y-4">
                <div>
                    <label for="category" class="block font-medium text-gray-700">Kategori <?php echo form_error('category') ?></label>
                    <select name="category" id="category"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c->id ?>" <?= $c->id == $category ? 'selected' : '' ?>><?= $c->category ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label for="postimage" class="block font-medium text-gray-700">Gambar Thumbnail <?php echo form_error('postimage') ?></label>
                    <input type="file" name="postimage" id="postimage"
                        class="mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded px-3 py-2" />
                    <?php if (!empty($postimage)): ?>
                        <a href="<?php echo site_url($postimage) ?>" target="_blank" class="block mt-2 w-fit">
                            <img src="<?php echo site_url($postimagethumb) ?>" alt="<?= $title ?>" class="h-32 rounded border" />
                        </a>
                    <?php endif ?>
                </div>
                <div>
                    <label for="metapost" class="block font-medium text-gray-700">Meta Deskripsi <?php echo form_error('metapost') ?></label>
                    <input type="text" name="metapost" id="metapost" value="<?php echo $metapost ?>"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500" />
                </div>
                <div>
                    <label for="keywords" class="block font-medium text-gray-700">Kata Kunci Pencarian <?php echo form_error('keywords') ?></label>
                    <input type="text" name="keywords" id="keywords" value="<?php echo $keywords ?>"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500" />
                </div>
                <div>
                    <label for="poststatus" class="block font-medium text-gray-700">Status Artikel <?php echo form_error('poststatus') ?></label>
                    <select name="poststatus" id="poststatus"
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                        <?php
                        foreach ($status as $k => $v) {
                            if ($k == 1) {
                                if ($session['id'] == 1 || $session['id'] == $this->config->item('approval_user') || $roled) {
                                    echo "<option value='{$k}'" . ($k == $poststatus ? ' selected' : '') . ">{$v}</option>";
                                }
                            } else {
                                echo "<option value='{$k}'" . ($k == $poststatus ? ' selected' : '') . ">{$v}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="curpostimage" value="<?php echo $postimage ?>" />
                <input type="hidden" name="curpostimagethumb" value="<?php echo $postimagethumb ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
            </div>
            <div class="space-x-2">
                <button type="button" onclick="showPreview()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm">
                    Preview
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    <?= $button ?>
                </button>
                <a href="<?php echo site_url('app/posts') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">Batal</a>
            </div>
        </div>
    </form>

    <!-- Modal Preview -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-4xl shadow-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h5 class="text-xl font-semibold">Preview Data</h5>
                <button onclick="hidePreview()" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border-t border-gray-200">
                        <tbody class="divide-y divide-gray-100" id="previewTable">
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Judul</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-title">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Konten</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-content">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Kategori</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-category">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Gambar Thumbnail</td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div id="preview-postimage">Tidak ada file dipilih</div>
                                    <?php if (!empty($postimage)): ?>
                                        <button onclick="showFilePreview('postimage', '<?php echo site_url($postimagethumb); ?>')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mt-2">
                                            Lihat Thumbnail
                                        </button>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Meta Deskripsi</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-metapost">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Kata Kunci Pencarian</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-keywords">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Status Artikel</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-poststatus">Tidak diisi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="hidePreview()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow text-sm">Kembali</button>
                <button type="submit" form="postForm" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow text-sm"><?php echo $button ?></button>
            </div>
        </div>
    </div>

    <!-- Modal Preview File -->
    <div id="filePreviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl h-[80vh]">
            <div class="flex justify-between items-center px-4 py-2 border-b">
                <h4 class="text-lg font-semibold" id="filePreviewTitle">Preview Thumbnail</h4>
                <button onclick="hideFilePreview()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <div class="p-4 h-[calc(80vh-60px)] flex items-center justify-center">
                <img id="filePreviewContent" class="max-w-full max-h-full object-contain" src="" alt="Preview Thumbnail" />
            </div>
        </div>
    </div>
</div>