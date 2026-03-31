<?php
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>

<div id="content" class="p-5 bg-white rounded shadow">
    <!-- Peringatan Integrasi JDIHN -->
    <?php if ($publish_jdihn == '1'): ?>
    <div class="mb-4 p-3 bg-blue-100 border border-blue-400 text-blue-800 rounded-lg flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <span class="font-semibold text-lg">DOKUMEN TERINTEGRASI DENGAN JDIHN</span>
    </div>
    <?php endif; ?>
    
    <div class="mb-4 text-lg font-semibold text-gray-700">Detil Dokumen - <?= $title ?></div>
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left border-t border-gray-200">
            <tbody class="divide-y divide-gray-100">
                <?php
                // Tentukan status JDIHN dalam bahasa Indonesia
                $status_jdihn = $publish_jdihn == '1' ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya (Disetujui)</span>' : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak (Belum Disetujui)</span>';

                $rows = [
                    "Judul" => $title,
                    "Jenis Dokumen" => $documenttype,
                    "Kategori / Jenis Dokumen" => $documentcategory,
                    "Tajuk Entri Utama" => $teu,
                    "Nomor Peraturan" => $regulationnumber,
                    "Tahun" => $year,
                    "Tempat Penetapan" => $assignmentplace,
                    "Tanggal Penetapan" => "<span class='tanggal' data-date='$assignmentdate'></span>",
                    "Tanggal Pengundangan" => "<span class='tanggal' data-date='$approvaldate'></span>",
                    "Tanggal Berlaku Efektif" => "<span class='tanggal' data-date='$effectivedate'></span>",
                    "Lokasi" => $location,
                    "Sumber" => $source,
                    "Bahasa" => $language,
                    "Bidang Hukum" => $legalfield,
                    "Subjek" => $subject,
                    "Klaster" => $cluster,
                    "Status" => $status,
                    "Detail Status" => $detailstatus,
                    "Status Publikasi JDIHN" => $status_jdihn, // <-- FIELD BARU
                    "Dikunjungi" => $viewed,
                    "Diunduh" => $downloaded,
                    "Abstrak" => $abstract,
                    "Status Publikasi" => $published,
                    "Dipublikasi Pada" => "<span class='tanggal' data-format='D MMMM YYYY HH:mm' data-date='$publishdate'></span>",
                    "Alasan" => $reason,
                    "Dibuat Pada" => "<span class='tanggal' data-format='D MMMM YYYY HH:mm' data-date='$createdat'></span>",
                    "Dibuat Oleh" => $fullname ? $fullname : $username,
                    "Diperbaharui Pada" => "<span class='tanggal' data-format='D MMMM YYYY HH:mm' data-date='$updatedat'></span>",
                    "Diperbaharui Oleh" => $fullnameupdate ? $fullnameupdate : $userupdate,
                ];

                foreach ($rows as $label => $value): 
                    // Logika untuk menampilkan HTML/Rich Text jika labelnya Detail Status atau Abstrak
                    $is_rich_text = ($label === "Detail Status" || $label === "Abstrak" || $label === "Alasan");
                    $value_display = $value;
                    
                    if ($is_rich_text) {
                        // Untuk konten rich text, bungkus dalam div dengan class agar CSS kustom bisa merapikan
                        $cleaned_value = str_replace(array('<p>&nbsp;</p>', '<p> </p>', "[removed]"), '', $value);
                        // Tambahkan class agar CSS merapikan p, ul, li
                        $value_display = '<div class="rich-text-output">' . $cleaned_value . '</div>';
                    }

                    // Hanya tampilkan jika nilai tidak kosong (kecuali untuk rich text dan tanggal yang ditangani JS)
                    if ($value === null || $value === '' || $value === false) {
                        // Jangan tampilkan baris yang kosong, kecuali untuk baris yang sengaja diproses di JS
                        if (!strpos($value, 'data-date=') && $label !== "Status Publikasi JDIHN") {
                             continue;
                        }
                    }
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="w-1/3 px-4 py-3 font-medium text-gray-700 whitespace-nowrap"><?= $label ?></td>
                        <td class="px-4 py-3 text-gray-600 <?= $is_rich_text ? '' : 'whitespace-nowrap' ?>">
                            <?= $is_rich_text ? $value_display : $value ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Abstrak Dokumen (File) -->
                <tr x-data="{ showAbstract: false }" class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-700">Abstrak Dokumen</td>
                    <td class="px-4 py-3">
                        <?php if (!empty($abstractfile->fullpath)): ?>
                        <button @click="showAbstract = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            Lihat Abstrak
                        </button>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                        
                        <div x-show="showAbstract" x-transition
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl h-[90vh]">
                                <div class="flex justify-between items-center px-4 py-2 border-b">
                                    <h4 class="text-lg font-semibold">Abstrak Dokumen - <?= $title ?></h4>
                                    <button @click="showAbstract = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                </div>
                                <div class="p-4 h-[calc(90vh-60px)]">
                                    <?php if (!empty($abstractfile->fullpath)): ?>
                                        <embed src="<?= site_url($abstractfile->fullpath) ?>" frameborder="0"
                                            width="100%" height="100%">
                                    <?php else: ?>
                                        <div class="text-red-600 font-semibold">File tidak ditemukan.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Dokumen Lampiran -->
                <tr x-data="{ showDokumen: false }" class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-700">Dokumen</td>
                    <td class="px-4 py-3">
                        <?php if (!empty($attachment->fullpath)): ?>
                        <button @click="showDokumen = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            Lihat Dokumen
                        </button>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                        
                        <div x-show="showDokumen" x-transition
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg overflow-hidden shadow-lg w-3/4 max-w-4xl h-[90vh]">
                                <div class="flex justify-between items-center px-4 py-2 border-b">
                                    <h4 class="text-lg font-semibold">Dokumen - <?= $title ?></h4>
                                    <button @click="showDokumen = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                </div>
                                <div class="p-4 h-[calc(90vh-60px)]">
                                    <?php if (!empty($attachment->fullpath)): ?>
                                        <embed src="<?= site_url($attachment->fullpath) ?>" frameborder="0" width="100%"
                                            height="100%">
                                    <?php else: ?>
                                        <div class="text-red-600 font-semibold">File tidak ditemukan.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <a href="<?= site_url('app/regulations') ?>"
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Kembali</a>
        <div>
            <?php if ($published == 'Pending' && ($session['id'] == 1 || $session['id'] == $this->config->item('approval_user'))): ?>
                <?= $this->myacl->_btnDefault(site_url('app/regulations/approve/' . $id), 'Publis Dokumen', 'bg-green-600 text-white', 'fa-paper-plane') ?>
                <?= $this->myacl->_btnDefault(site_url('app/regulations/reject/' . $id), 'Tolak Dokumen', 'bg-red-600 text-white', 'fa-ban') ?>
            <?php endif; ?>
        </div>
    </div>
</div>