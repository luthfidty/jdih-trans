<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="space-y-6">
    <!-- Panel -->
    <div class="bg-white border border-gray-200 rounded-lg shadow">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <!-- Tombol kiri -->
            <div class="flex flex-wrap items-center ">
                <?php
                if (in_array('create', $rolelist)) {
                    echo $this->myacl->_btnCreate(site_url('app/pages/create'), "Tambah");
                    echo $this->myacl->_btnDefault(site_url('app/pages/trash'), "Tong Sampah", "bg-teal-600 hover:bg-teal-700", "fa-trash");
                }
                ?>
            </div>


            <!-- Info center -->
            <!-- <div class="flex-1 text-center text-sm text-gray-600">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            </div> -->

            <!-- Form pencarian -->
            <form action="<?php echo site_url('app/pages/index'); ?>" method="get" class="flex gap-2 items-center">
                <input type="text" name="q" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    value="<?php echo $q; ?>" placeholder="Cari...">
                <?php if ($q <> '') { ?>
                    <a href="<?php echo site_url('app/pages'); ?>"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur
                        Ulang</a>
                <?php } ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto">  
            <table class="min-w-full text-sm text-left border-t border-gray-200 table-fixed">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-20">
                    <tr>
                        <th class="sticky left-0 z-30 bg-gray-100 px-4 py-2 border-b w-[60px]">No</th>
                        <th class="px-4 py-2 border-b">Thumbnail</th>
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">Alias URL</th>
                        <th class="sticky right-0 z-30 bg-gray-100 px-4 py-2 border-b text-center w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages_data as $pages): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start ?></td>
                            <td class="px-4 py-2">
                                <a href="<?php echo site_url($pages->postimage ?: 'assets/app/images/noimage.jpg') ?>"
                                    class="block">
                                    <img src="<?php echo site_url($pages->postimagethumb ?: 'assets/app/images/noimage.jpg') ?>"
                                        alt="" class="h-24 object-contain rounded shadow" />
                                </a>
                            </td>
                            <td class="px-4 py-2"><?php echo $pages->title ?></td>
                            <td class="px-4 py-2"><?php echo $pages->slug ?></td>
                            <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                                <div class="flex justify-center gap-2">
                                    <?php if (in_array('update', $rolelist)): ?>
                                        <a href="<?= site_url('app/pages/update/' . $pages->id) ?>" title="Edit"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition duration-200">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (in_array('delete', $rolelist)): ?>
                                        <a href="<?= site_url('app/pages/delete/' . $pages->id) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition duration-200">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-gray-600 mb-2 md:mb-0">
                Jumlah Data: <strong><?php echo $total_rows ?></strong>
            </div>
            <div>
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</div>