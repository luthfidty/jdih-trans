<?php
$this->load->view('base/headercontent');
?>
<!-- /Page Title -->

<div id="content" class="p-5">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" id="regulationForm">
        <div class="bg-white shadow rounded-lg">
            <div class="bg-gray-100 px-5 py-3 border-b border-gray-300">
                <div class="text-lg font-semibold">
                    <?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="title" class="block font-medium mb-1">Judul
                                <?php echo form_error('title') ?></label>
                            <input type="text" name="title" id="title" placeholder="Judul" value="<?php echo $title; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="documentcategory" class="block font-medium mb-1">Kategori Dokumen
                                <?php echo form_error('documentcategory') ?></label>
                            <select name="documentcategory" id="documentcategory"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <option value="">Pilih Kategori</option>
                                <?php
                                if (!empty($dcdata)) {
                                    foreach ($dcdata as $dc) {
                                        echo '<option value="' . $dc->id . '" ' . ($dc->id == $documentcategory ? 'selected' : '') . '>' . $dc->category . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="doctype" class="block font-medium mb-1">Jenis Dokumen
                                <?php echo form_error('doctype') ?></label>
                            <select name="doctype" id="doctype"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <option value="">Pilih Jenis</option>
                                <?php
                                if (!empty($docstype)) {
                                    foreach ($docstype as $dt) {
                                        echo '<option value="' . $dt->id . '" ' . ($dt->id == $doctype ? 'selected' : '') . '>' . $dt->documenttype . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="teu" class="block font-medium mb-1">Tajuk Entri Utama
                                <?php echo form_error('teu') ?></label>
                            <input type="text" name="teu" id="teu" placeholder="Tajuk Entri Utama"
                                value="<?php echo $teu; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="regulationnumber" class="block font-medium mb-1">Nomor Peraturan
                                <?php echo form_error('regulationnumber') ?></label>
                            <input type="text" name="regulationnumber" id="regulationnumber"
                                placeholder="Nomor Peraturan" value="<?php echo $regulationnumber; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="year" class="block font-medium mb-1">Tahun
                                <?php echo form_error('year') ?></label>
                            <input type="text" name="year" id="year" placeholder="Contoh: 2024"
                                value="<?php echo $year; ?>" maxlength="4" pattern="\d{4}" inputmode="numeric"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="assignmentplace" class="block font-medium mb-1">Tempat Penetapan
                                <?php echo form_error('assignmentplace') ?></label>
                            <input type="text" name="assignmentplace" id="assignmentplace"
                                placeholder="Tempat Penetapan" value="<?php echo $assignmentplace; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="assignmentdate" class="block font-medium mb-1">Tanggal Penetapan
                                <?php echo form_error('assignmentdate') ?></label>
                            <input type="text" name="assignmentdate" id="assignmentdate" placeholder="Tanggal Penetapan"
                                value="<?php echo $assignmentdate ? date_format(date_create($assignmentdate), "Y-m-d") : ''; ?>"
                                class="jdihdatepicker mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="approvaldate" class="block font-medium mb-1">Tanggal Pengundangan
                                <?php echo form_error('approvaldate') ?></label>
                            <input type="text" name="approvaldate" id="approvaldate" placeholder="Tanggal Pengundangan"
                                value="<?php echo $approvaldate ? date_format(date_create($approvaldate), "Y-m-d") : ''; ?>"
                                class="jdihdatepicker mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="effectivedate" class="block font-medium mb-1">Tanggal Efektif Berlaku
                                <?php echo form_error('effectivedate') ?></label>
                            <input type="text" name="effectivedate" id="effectivedate"
                                placeholder="Tanggal Efektif Berlaku"
                                value="<?php echo $effectivedate ? date_format(date_create($effectivedate), "Y-m-d") : ''; ?>"
                                class="jdihdatepicker mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block font-medium mb-1">Lokasi
                                <?php echo form_error('location') ?></label>
                            <input type="text" name="location" id="location" placeholder="Lokasi"
                                value="<?php echo $location; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="source" class="block font-medium mb-1">Sumber
                                <?php echo form_error('source') ?></label>
                            <input type="text" name="source" id="source" placeholder="Sumber"
                                value="<?php echo $source; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="language" class="block font-medium mb-1">Bahasa
                                <?php echo form_error('language') ?></label>
                            <select name="language" id="language"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <option value="Indonesia" <?php echo $language == "Indonesia" ? 'selected' : '' ?>>
                                    Indonesia</option>
                                <option value="Inggris" <?php echo $language == "Inggris" ? 'selected' : '' ?>>Inggris
                                </option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="legalfield" class="block font-medium mb-1">Bidang Hukum
                                <?php echo form_error('legalfield') ?></label>
                            <input type="text" name="legalfield" id="legalfield" placeholder="Bidang Hukum"
                                value="<?php echo $legalfield; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block font-medium mb-1">Subjek
                                <?php echo form_error('subject') ?></label>
                            <input type="text" name="subject" id="subject" placeholder="Subjek"
                                value="<?php echo $subject; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                    </div>
                    <div>
                        <div class="mb-4">
                            <label for="cluster" class="block font-medium mb-1">Klaster
                                <?php echo form_error('cluster') ?></label>
                            <input type="text" name="cluster" id="cluster" placeholder="Klaster"
                                value="<?php echo $cluster; ?>"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block font-medium mb-1">Status
                                <?php echo form_error('status') ?></label>
                            <select name="status" id="status"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <?php
                                foreach ($isStatus as $k => $v) {
                                    echo '<option value="' . $v . '" ' . ($v == $status ? 'selected' : '') . '>' . $v . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="detailstatus" class="block font-medium text-gray-700">Detil Status</label>
                            <textarea name="detailstatus" id="detailstatus" rows="6"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $detailstatus ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="abstract" class="block font-medium text-gray-700">Abstrak</label>
                            <textarea name="abstract" id="abstract" rows="6"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $abstract ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="abstractfile" class="block font-medium mb-1">Abstrak Dokumen
                                <?php echo form_error('abstractfile') ?></label>
                            <?php if ($abstractfile) { ?>
                                <a href="<?php echo site_url($abstractfile->fullpath) ?>" target="_blank"
                                    id="current-abstract-link"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Abstrak Dokumen Saat Ini
                                </a>
                                <button type="button" id="upload-abstract-btn" data-target="abstractfile"
                                    class="upload-chunk-btn bg-yellow-600 hover:bg-yellow-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Pilih dan Unggah File Baru
                                </button>
                            <?php } else { ?>
                                <button type="button" id="upload-abstract-btn" data-target="abstractfile"
                                    class="upload-chunk-btn bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Pilih dan Unggah File
                                </button>
                            <?php } ?>
                            <input type="file" name="abstractfile_chunk_input" id="abstractfile_chunk_input"
                                class="hidden" accept=".pdf" />
                            <div id="abstractfile-progress-container" class="mt-2 hidden">
                                <div class="text-sm font-medium text-gray-700" id="abstractfile-status">Menunggu file...
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                                    <div id="abstractfile-progress-bar" class="bg-blue-600 h-2.5 rounded-full"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="attachment" class="block font-medium mb-1">Dokumen
                                <?php echo form_error('attachment') ?></label>
                            <?php if ($attachment) { ?>
                                <a href="<?php echo site_url($attachment->fullpath) ?>" target="_blank"
                                    id="current-attachment-link"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Dokumen Saat Ini
                                </a>
                                <button type="button" id="upload-attachment-btn" data-target="attachment"
                                    class="upload-chunk-btn bg-yellow-600 hover:bg-yellow-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Pilih dan Unggah File Baru
                                </button>
                            <?php } else { ?>
                                <button type="button" id="upload-attachment-btn" data-target="attachment"
                                    class="upload-chunk-btn bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded mb-2 inline-block">
                                    Pilih dan Unggah File
                                </button>
                            <?php } ?>
                            <input type="file" name="attachment_chunk_input" id="attachment_chunk_input" class="hidden"
                                accept=".pdf" />
                            <div id="attachment-progress-container" class="mt-2 hidden">
                                <div class="text-sm font-medium text-gray-700" id="attachment-status">Menunggu file...
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                                    <div id="attachment-progress-bar" class="bg-blue-600 h-2.5 rounded-full"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- FIELD BARU: Status Publikasi JDIHN -->
                        <div class="mb-4">
                            <label for="publish_jdihn" class="block font-medium mb-1">Status Publikasi JDIHN</label>
                            <select name="publish_jdihn" id="publish_jdihn"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <option value="0" <?php echo ($publish_jdihn === '0' || $publish_jdihn === false) ? 'selected' : ''; ?>>
                                    Tidak Publish
                                </option>
                                <option value="1" <?php echo ($publish_jdihn === '1' || $publish_jdihn === true) ? 'selected' : ''; ?>>
                                    Publish
                                </option>
                            </select>
                        </div>
                        <!-- BATAS FIELD BARU -->

                        <div class="mb-4">
                            <label for="published" class="block font-medium mb-1">Status Publikasi
                                <?php echo form_error('published') ?></label>
                            <select name="published" id="published"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                <?php
                                foreach ($isPublished as $k => $v) {
                                    if ($v == 'Publish') {
                                        if ($session['id'] == 1 || $session['id'] == $this->config->item('approval_user')) {
                                            echo '<option value="' . $v . '" ' . ($v == $published ? 'selected' : '') . '>' . $v . '</option>';
                                        }
                                    } else {
                                        echo '<option value="' . $v . '" ' . ($v == $published ? 'selected' : '') . '>' . $v . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="publishdate" class="block font-medium mb-1">Tanggal Publikasi
                                <?php echo form_error('publishdate') ?></label>
                            <input type="text" name="publishdate" id="publishdatedate" placeholder="Tanggal Publikasi"
                                value="<?php echo $publishdate ? date_format(date_create($publishdate), "Y-m-d") : ''; ?>"
                                class="jdihdatepicker mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="publishtime" class="block font-medium text-gray-700 mb-1">Waktu Publikasi
                                <?php echo form_error('publishtime') ?></label>
                            <div class="relative">
                                <input type="text" name="publishtime" id="publishtime"
                                    value="<?php echo $publishdate ? date_format(date_create($publishdate), 'H:i') : '00:00'; ?>"
                                    class="jdihtimepicker w-full pl-10 pr-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700" />
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="block font-medium text-gray-700">Reason
                                <?php echo form_error('reason') ?></label>
                            <textarea name="reason" id="reason" rows="6"
                                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $reason ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="pt-6 border-t border-gray-200 mt-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="space-y-2 w-full md:w-auto">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="curAbstractfile" name="curAbstractfile"
                                value="<?php echo $curAbstractfile; ?>" />
                            <input type="hidden" id="curAttachment" name="curAttachment"
                                value="<?php echo $curAttachment; ?>" />
                            <input type="hidden" id="abstractfile_json" name="abstractfile_json" value="" />
                            <input type="hidden" id="attachment_json" name="attachment_json" value="" />
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                value="<?= $this->security->get_csrf_hash() ?>">
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="showPreview()"
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow text-sm">
                                Preview
                            </button>
                            <button type="submit" form="regulationForm"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow text-sm">
                                <?php echo $button ?>
                            </button>
                            <a href="<?php echo site_url('app/regulations') ?>"
                                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow text-sm">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
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
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Kategori Dokumen
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-documentcategory">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tipe Dokumen
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-doctype">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tajuk Entri
                                    Utama</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-teu">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Nomor Peraturan
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-regulationnumber">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tahun</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-year">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tempat Penetapan
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-assignmentplace">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tanggal
                                    Penetapan</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-assignmentdate">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tanggal
                                    Pengundangan</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-approvaldate">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tanggal Efektif
                                    Berlaku</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-effectivedate">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Lokasi</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-location">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Sumber</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-source">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Bahasa</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-language">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Bidang Hukum
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-legalfield">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Subjek</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-subject">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Klaster</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-cluster">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Status</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-status">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Detil Status
                                </td>
                                <td class="px-4 py-3 text-gray-600 whitespace-pre-wrap" id="preview-detailstatus">Tidak
                                    diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Abstrak</td>
                                <td class="px-4 py-3 text-gray-600 whitespace-pre-wrap" id="preview-abstract">Tidak
                                    diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Abstrak Dokumen
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div id="preview-abstractfile">Tidak ada file dipilih</div>
                                    <?php if ($abstractfile) { ?>
                                        <button
                                            onclick="showFilePreview('abstractfile', '<?php echo site_url($abstractfile->fullpath); ?>')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mt-2">
                                            Lihat Abstrak
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Dokumen</td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div id="preview-attachment">Tidak ada file dipilih</div>
                                    <?php if ($attachment) { ?>
                                        <button
                                            onclick="showFilePreview('attachment', '<?php echo site_url($attachment->fullpath); ?>')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded mt-2">
                                            Lihat Dokumen
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Status Publikasi
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-published">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Tanggal
                                    Publikasi</td>
                                <td class="px-4 py-3 text-gray-600" id="preview-publishdate">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Waktu Publikasi
                                </td>
                                <td class="px-4 py-3 text-gray-600" id="preview-publishtime">Tidak diisi</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap">Reason</td>
                                <td class="px-4 py-3 text-gray-600 whitespace-pre-wrap" id="preview-reason">Tidak diisi
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="hidePreview()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow text-sm">Kembali</button>
                <button type="submit" form="regulationForm"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow text-sm"><?php echo $button ?></button>
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