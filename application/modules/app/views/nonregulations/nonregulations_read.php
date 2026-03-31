<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Content -->
<div id="content" class="p-5 bg-white rounded shadow">
    <div class="mb-4 text-lg font-semibold text-gray-700">Detil Dokumen - <?= $title ?></div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left border-t border-gray-200">
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="w-1/3 px-4 py-3 font-medium text-gray-700">Sampul</td>
                    <td class="px-4 py-3">
                        <a href="<?= site_url($bookcoverfile->fullpath) ?>" target="_blank">
                            <img src="<?= site_url($bookcoverfile->filepath . '/' . $bookcoverfile->filename) ?>"
                                 class="h-32 rounded shadow border object-contain" alt="<?= $title ?>" />
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Judul</td><td class="px-4 py-3"><?= $title ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Jenis</td><td class="px-4 py-3"><?= $grouplist[$groups] ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Tajuk Entri Utama</td><td class="px-4 py-3"><?= $teu ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Tahun Terbit</td><td class="px-4 py-3"><?= $year ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Tempat Terbit</td><td class="px-4 py-3"><?= $assignmentplace ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Lokasi</td><td class="px-4 py-3"><?= $location ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Bahasa</td><td class="px-4 py-3"><?= $language ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Nomor ISSN/ISBN</td><td class="px-4 py-3"><?= $isbnissnnumber ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Penerbit</td><td class="px-4 py-3"><?= $publisher ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Deskripsi</td><td class="px-4 py-3"><?= $description ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Dilihat</td><td class="px-4 py-3"><?= $viewed ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Diunduh</td><td class="px-4 py-3"><?= $downloaded ?></td></tr>

                <!-- Dokumen Lampiran -->
                <tr x-data="{ showDokumen: false }" class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-700">File Lampiran</td>
                    <td class="px-4 py-3">
                        <button @click="showDokumen = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            Lihat Dokumen
                        </button>
                        <div x-show="showDokumen" x-transition
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl">
                                <div class="flex justify-between items-center px-4 py-2 border-b">
                                    <h4 class="text-lg font-semibold">Dokumen - <?= $title ?></h4>
                                    <button @click="showDokumen = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                </div>
                                <div class="p-4">
                                    <?php if (!empty($attachment->fullpath)): ?>
                                        <embed src="<?= site_url($attachment->fullpath) ?>" frameborder="0"
                                            width="100%" height="600px">
                                    <?php else: ?>
                                        <div class="text-red-600 font-semibold">File tidak ditemukan.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Status Publikasi</td><td class="px-4 py-3"><?= $published ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Dibuat Pada</td><td class="px-4 py-3"><?= $createdat ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Dibuat Oleh</td><td class="px-4 py-3"><?= $fullname ?: $username ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Diperbaharui Pada</td><td class="px-4 py-3"><?= $updatedat ?></td></tr>
                <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-medium text-gray-700">Diperbaharui Oleh</td><td class="px-4 py-3"><?= $fullnameupdate ?: $userupdate ?></td></tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="mt-6">
        <a href="<?= site_url('app/nonregulations') ?>"
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
