<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->

<!-- Content -->
<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <div>
                <?= $this->myacl->_btnCreate(site_url('app/navigations/create'), 'Tambah') ?>
            </div>
            <!-- <div class="text-sm text-center text-gray-600 flex-1">
                <?= $this->session->userdata('message') ?? '' ?>
            </div> -->
        </div>

        <!-- Table -->
        <div class="overflow-x-auto relative z-0">
            <table class="min-w-full text-sm text-left border-t border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Name</th>
                        <th class="px-4 py-2 border-b">Position</th>
                        <th class="px-4 py-2 border-b">Description</th>
                        <th class="px-4 py-2 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($navigations_data as $navigations): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?= ++$start ?></td>
                            <td class="px-4 py-2"><?= $navigations->name ?></td>
                            <td class="px-4 py-2"><?= $navigations->position ?></td>
                            <td class="px-4 py-2"><?= $navigations->description ?></td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="<?= site_url('app/navigations/update/' . $navigations->id) ?>"
                                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                                    <i class="fas fa-edit mr-2 text-xs"></i> Edit
                                </a>
                                <a href="<?= site_url('app/navigations/delete/' . $navigations->id) ?>"
                                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash-alt mr-2 text-xs"></i> Hapus
                                </a>
                            </td>


                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="text-sm text-gray-600">
                Jumlah Data: <strong><?= $total_rows ?></strong>
            </div>
            <div>
                <?= $pagination ?>
            </div>
        </div>
    </div>
</div>