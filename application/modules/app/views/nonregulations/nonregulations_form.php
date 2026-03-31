<?php
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form -->
<div id="content" class="p-5 bg-white rounded shadow">
    <form method="post" action="<?= $action ?>" enctype="multipart/form-data" autocomplete="off" id="nonregulationForm">
        <div class="grid grid-cols-1 gap-6">

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul <?= form_error('title') ?></label>
                <input type="text" name="title" id="title" placeholder="Judul" value="<?= $title ?>"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori <?= form_error('groups') ?></label>
                <select name="groups" id="groups"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <?php foreach ($grouplists as $k => $v): ?>
                        <option value="<?= $k ?>" <?= $k == $groups ? 'selected' : '' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Input Texts -->
            <?php
            $inputs = [
                'teu' => 'Tajuk Entri Utama',
                'callnumber' => 'Nomor Panggil',
                'edition' => 'Cetakan',
                'assignmentplace' => 'Tempat Terbit',
                'publisher' => 'Penerbit',
                'year' => 'Tahun Terbit',
                'isbnissnnumber' => 'Nomor ISSN/ISBN',
                'location' => 'Lokasi'
            ];
            foreach ($inputs as $key => $label): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700"><?= $label ?>      <?= form_error($key) ?></label>
                    <input type="text" name="<?= $key ?>" id="<?= $key ?>" placeholder="<?= $label ?>" value="<?= $$key ?>"
                        class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            <?php endforeach; ?>

            <!-- Bahasa -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Bahasa <?= form_error('language') ?></label>
                <select name="language" id="language"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Indonesia" <?= $language == "Indonesia" ? 'selected' : '' ?>>Indonesia</option>
                    <option value="Inggris" <?= $language == "Inggris" ? 'selected' : '' ?>>Inggris</option>
                </select>
            </div>

            <!-- File Book Cover -->
            <div x-data="{ showCover: false }">
                <label class="block text-sm font-medium text-gray-700">Kulit Buku <?= form_error('bookcover') ?></label>
                <?php if ($bookcover): ?>
                    <button type="button" @click="showCover = true"
                        class="mt-1 mb-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                        Lihat Book Cover
                    </button>

                    <!-- Modal Book Cover -->
                    <div x-show="showCover" x-transition
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl">
                            <div class="flex justify-between items-center px-4 py-2 border-b">
                                <h4 class="text-lg font-semibold">Book Cover - <?= $title ?></h4>
                                <button type="button" @click="showCover = false"
                                    class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                            </div>
                            <div class="p-4">
                                <?php if ($bookcover->fullpath): ?>
                                    <embed src="<?= site_url($bookcover->fullpath) ?>" width="100%" height="600px"
                                        frameborder="0" />
                                <?php else: ?>
                                    <div class="text-red-600 font-semibold">File tidak ditemukan.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" name="bookcover" id="bookcover"
                    class="block w-full mt-1 border border-gray-300 rounded px-3 py-2">
            </div>

            <!-- File Attachment -->
            <div x-data="{ showAttachment: false }">
                <label class="block text-sm font-medium text-gray-700">Lampiran File
                    <?= form_error('attachment') ?></label>
                <?php if ($attachment): ?>
                    <button type="button" @click="showAttachment = true"
                        class="mt-1 mb-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                        Lihat Dokumen
                    </button>

                    <!-- Modal Attachment -->
                    <div x-show="showAttachment" x-transition
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl">
                            <div class="flex justify-between items-center px-4 py-2 border-b">
                                <h4 class="text-lg font-semibold">Dokumen - <?= $title ?></h4>
                                <button type="button" @click="showAttachment = false"
                                    class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                            </div>
                            <div class="p-4">
                                <embed src="<?= site_url($attachment->fullpath) ?>" width="100%" height="600px"
                                    frameborder="0" />
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" name="attachment" id="attachment"
                    class="block w-full mt-1 border border-gray-300 rounded px-3 py-2">
            </div>

            <!-- Status Publikasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status Publikasi
                    <?= form_error('published') ?></label>
                <select name="published" id="published"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <?php foreach ($isPublished as $k => $v): ?>
                        <?php if ($v == 'Publish' && ($session['id'] != 1 && $session['id'] != $this->config->item('approval_user')))
                            continue; ?>
                        <option value="<?= $v ?>" <?= $v == $published ? 'selected' : '' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- PUBLISH JDIHN BARU (Dropdown) -->
            <div>
                <label for="publish_jdihn" class="block text-sm font-medium text-gray-700">Publikasi ke JDIHN
                    <?= form_error('publish_jdihn') ?></label>
                <select name="publish_jdihn" id="publish_jdihn"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="0" <?= $publish_jdihn == '0' ? 'selected' : '' ?>>
                        Tidak Publish
                    </option>
                    <option value="1" <?= $publish_jdihn == '1' ? 'selected' : '' ?>>
                        Publish
                    </option>
                </select>
            </div>

        </div>

        <!-- Hidden & Buttons -->
        <div class="mt-6 flex items-center justify-between">
            <div>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="curBookcover" value="<?= $curBookcover ?>">
                <input type="hidden" name="curAttachment" value="<?= $curAttachment ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="showPreview()"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow text-sm">
                    Preview
                </button>
                <button type="submit" form="nonregulationForm" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow text-sm">
                    <?php echo $button ?>
                </button>
                <a href="<?php echo site_url('app/nonregulations') ?>"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow text-sm">
                    Batal
                </a>
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
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Kategori</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-groups">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tajuk Entri
                                    Utama</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-teu">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Nomor Panggil
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-callnumber">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Cetakan</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-edition">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tempat Terbit
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-assignmentplace">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Penerbit</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-publisher">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tahun Terbit
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-year">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Nomor ISSN/ISBN
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-isbnissnnumber">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Lokasi</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-location">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Bahasa</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-language">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Kulit Buku</td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div id="preview-bookcover">Tidak ada file dipilih</div>
                                    <?php if ($bookcover): ?>
                                        <button
                                            onclick="showFilePreview('bookcover', '<?= site_url($bookcover->fullpath) ?>')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mt-2">
                                            Lihat Book Cover
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Lampiran File
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div id="preview-attachment">Tidak ada file dipilih</div>
                                    <?php if ($attachment): ?>
                                        <button
                                            onclick="showFilePreview('attachment', '<?= site_url($attachment->fullpath) ?>')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mt-2">
                                            Lihat Dokumen
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Status Publikasi
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-published">Tidak diisi</td>
                            </tr>
                            <!-- FIELD BARU -->
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Publikasi JDIHN
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-publish_jdihn">Tidak disetujui</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="hidePreview()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow text-sm">Kembali</button>
                <button type="submit" form="nonregulationForm"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow text-sm"><?= $button ?></button>
            </div>
        </div>
    </div>

    <!-- Modal Preview File -->
    <div id="filePreviewModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl h-[80vh]">
            <div class="flex justify-between items-center px-4 py-2 border-b">
                <h4 class="text-lg font-semibold" id="filePreviewTitle">Preview File</h4>
                <button onclick="hideFilePreview()"
                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <div class="p-4 h-[calc(80vh-60px)]">
                <div id="filePreviewContent" class="w-full h-full"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showPreview() {
        const form = document.getElementById('nonregulationForm');
        const formData = new FormData(form);
        const publishJdihnDropdown = document.getElementById('publish_jdihn');

        // Fungsi untuk mendapatkan teks dari opsi dropdown yang dipilih
        const getSelectedText = (selector) => {
            const element = document.querySelector(selector);
            return element ? element.options[element.selectedIndex]?.text || 'Tidak diisi' : 'Tidak diisi';
        };
        
        // Fungsi untuk mendapatkan nilai dari opsi dropdown yang dipilih (0 atau 1)
        const getSelectedValue = (selector) => {
            const element = document.querySelector(selector);
            return element ? element.options[element.selectedIndex]?.value || '0' : '0';
        };


        // Update data preview
        document.getElementById('preview-title').textContent = formData.get('title') || 'Tidak diisi';
        document.getElementById('preview-groups').textContent = getSelectedText('#groups');
        document.getElementById('preview-teu').textContent = formData.get('teu') || 'Tidak diisi';
        document.getElementById('preview-callnumber').textContent = formData.get('callnumber') || 'Tidak diisi';
        document.getElementById('preview-edition').textContent = formData.get('edition') || 'Tidak diisi';
        document.getElementById('preview-assignmentplace').textContent = formData.get('assignmentplace') || 'Tidak diisi';
        document.getElementById('preview-publisher').textContent = formData.get('publisher') || 'Tidak diisi';
        document.getElementById('preview-year').textContent = formData.get('year') || 'Tidak diisi';
        document.getElementById('preview-isbnissnnumber').textContent = formData.get('isbnissnnumber') || 'Tidak diisi';
        document.getElementById('preview-location').textContent = formData.get('location') || 'Tidak diisi';
        document.getElementById('preview-language').textContent = getSelectedText('#language');
        document.getElementById('preview-published').textContent = getSelectedText('#published');
        
        // --- LOGIKA FIELD BARU: PUBLISH JDIHN ---
        const publishJdihnValue = getSelectedValue('#publish_jdihn');
        document.getElementById('preview-publish_jdihn').textContent = publishJdihnValue === '1' ? 'Disetujui (Ya)' : 'Tidak Disetujui (Tidak)';
        // --- BATAS LOGIKA FIELD BARU ---

        document.getElementById('preview-bookcover').textContent = document.querySelector('#bookcover')?.files[0]?.name || '<?= $bookcover ? $bookcover->fullpath : "Tidak ada file dipilih"; ?>';
        document.getElementById('preview-attachment').textContent = document.querySelector('#attachment')?.files[0]?.name || '<?= $attachment ? $attachment->fullpath : "Tidak ada file dipilih"; ?>';

        // Tampilkan modal
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function hidePreview() {
        // Sembunyikan modal
        document.getElementById('previewModal').classList.add('hidden');
        // Pastikan modal file preview juga tertutup
        hideFilePreview();
    }

    function showFilePreview(type, url) {
        const modal = document.getElementById('filePreviewModal');
        const title = document.getElementById('filePreviewTitle');
        const content = document.getElementById('filePreviewContent');

        // Set judul modal
        title.textContent = type === 'bookcover' ? 'Preview Kulit Buku' : 'Preview Lampiran File';

        // Set konten preview
        if (url && url !== 'Tidak ada file dipilih') {
            content.innerHTML = `<embed src="${url}" frameborder="0" width="100%" height="100%">`;
        } else {
            content.innerHTML = `<div class="text-red-600 font-semibold">File tidak ditemukan atau belum diunggah.</div>`;
        }

        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    function hideFilePreview() {
        // Sembunyikan modal file preview
        document.getElementById('filePreviewModal').classList.add('hidden');
        // Kosongkan konten untuk mencegah memori berlebih
        document.getElementById('filePreviewContent').innerHTML = '';
    }
</script>