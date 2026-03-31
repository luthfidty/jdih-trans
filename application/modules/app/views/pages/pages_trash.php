<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="bg-white border rounded shadow p-4">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
        <div class="flex flex-wrap items-center">
            <?php
            echo $this->myacl->_btnDefault(site_url('app/pages'), "Daftar Halaman", "bg-cyan-600 hover:bg-cyan-700", "fa-list");

            ?>
        </div>
        <!-- <div class="text-sm text-gray-700">
            <?php echo $this->session->userdata('message') ?: ''; ?>
        </div> -->
        <form action="<?php echo site_url('app/pages/index'); ?>" method="get" class="flex gap-2">
            <input type="text" name="q" value="<?php echo $q; ?>" class="border px-2 py-1 rounded text-sm"
                placeholder="Cari...">
            <?php if ($q != ''): ?>
                <a href="<?php echo site_url('app/pages'); ?>" class="text-yellow-600 text-sm hover:underline">Atur
                    Ulang</a>
            <?php endif; ?>
            <button class="bg-red-600 text-white px-3 py-1 text-sm rounded" type="submit">Cari</button>
        </form>
    </div>

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
                        <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start; ?></td>
                        <td class="px-4 py-2">
                            <a href="<?php echo site_url($pages->postimage ?: 'assets/app/images/noimage.jpg') ?>"
                                class="block">
                                <img src="<?php echo site_url($pages->postimagethumb ?: 'assets/app/images/noimage.jpg') ?>"
                                    alt="" class="h-24 object-contain rounded shadow" />
                            </a>
                        </td>
                        <td class="px-4 py-2"><?php echo $pages->title; ?></td>
                        <td class="px-4 py-2"><?php echo $pages->slug; ?></td>
                        <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                            <div class="flex justify-center gap-2">
                                <?php if (in_array('restore', $rolelist)): ?>
                                    <a href="<?php echo site_url('app/pages/restore/' . $pages->id); ?>"
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition duration-200"
                                        title="Restore">
                                        <i class="fas fa-sync-alt text-sm"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (in_array('permanent_delete', $rolelist)): ?>
                                    <a href="<?php echo site_url('app/pages/permanent_delete/' . $pages->id); ?>"
                                        onclick="return confirm('Yakin ingin menghapus permanen data ini?')"
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition duration-200"
                                        title="Hapus Permanen">
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


    <div class="mt-4 flex flex-wrap justify-between items-center text-sm">
        <div>Jumlah Data: <strong><?php echo $total_rows; ?></strong></div>
        <div><?php echo $pagination; ?></div>
    </div>
</div>