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
            <!-- Left Actions -->
            <div class="flex flex-wrap items-center gap-2">
                <?php
                if (in_array('create', $rolelist)) {
                    echo $this->myacl->_btnCreate(site_url('app/categories/create'), "Tambah");
                }
                ?>
            </div>

            <!-- Center Message -->
            <!-- <div class="flex-1 text-center text-sm text-gray-600">
                <?php echo $this->session->userdata('message') ?: ''; ?>
            </div> -->

            <!-- Right Search Form -->
            <form action="<?php echo site_url('app/categories/index'); ?>" method="get" class="flex gap-2 items-center">
                <input type="text" name="q" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    value="<?php echo $q; ?>" placeholder="Cari...">
                <?php if ($q !== '') { ?>
                    <a href="<?php echo site_url('app/categories'); ?>"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
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
                        <th class="px-4 py-2 border-b">Kategori</th>
                        <th class="px-4 py-2 border-b">Alias URL</th>
                        <th class="sticky right-0 z-30 bg-gray-100 px-4 py-2 border-b text-center w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories_data as $categories): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start ?></td>
                            <td class="px-4 py-2"><?php echo $categories->category ?></td>
                            <td class="px-4 py-2">/<?php echo $categories->slug ?></td>
                            <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                                <div class="flex justify-center gap-2">
                                    <?php if (in_array('update', $rolelist)) { ?>
                                        <a href="<?php echo site_url('app/categories/update/' . $categories->id) ?>"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition duration-200"
                                            title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if (in_array('delete', $rolelist)) { ?>
                                        <a href="<?php echo site_url('app/categories/delete/' . $categories->id) ?>"
                                            onclick="return confirm('Yakin ingin menghapus?')"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition duration-200"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
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