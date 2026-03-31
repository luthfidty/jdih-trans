<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="space-y-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

            <div>
                <?php echo $this->myacl->_btnCreate(site_url('auth/roles/create'), "Tambah");
                ?>
            </div>
            <!-- <div class="text-center text-sm text-green-700 font-medium">
                <?php echo $this->session->userdata('message') ?? ''; ?>
            </div> -->
            <form action="<?php echo site_url('auth/roles/index'); ?>" method="get" class="flex gap-2 items-center">
                <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Cari..."
                    class="border border-gray-300 rounded px-2 py-1 text-sm w-48">
                <?php if ($q <> ''): ?>
                    <a href="<?php echo site_url('auth/roles'); ?>" class="text-sm text-yellow-600 hover:underline">Atur
                        Ulang</a>
                <?php endif; ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Rolename</th>
                        <th class="py-2 px-4 border">Rolelist</th>
                        <th class="py-2 px-4 border">CreatedAt</th>
                        <th class="py-2 px-4 border">UpdatedAt</th>
                        <th class="py-2 px-4 border">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($roles_data as $roles): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border"><?php echo ++$start ?></td>
                            <td class="py-2 px-4 border"><?php echo $roles->rolename ?></td>
                            <td class="py-2 px-4 border"><?php echo $roles->rolename ?></td>
                            <td class="py-2 px-4 border tanggal" data-format='DD/MM/YYYY HH:mm'
                                data-date='<?php echo $roles->createdat ?>'></td>
                            <td class="py-2 px-4 border tanggal" data-format='DD/MM/YYYY HH:mm'
                                data-date='<?php echo $roles->updatedat ?>'></td>
                            <td class="py-2 px-4 border space-x-1">
                                <?php echo anchor('auth/roles/reload_session_action/', 'Reload Session', 'class="bg-cyan-500 hover:bg-cyan-600 text-white px-2 py-1 rounded text-xs"'); ?>
                                <?php echo anchor('auth/roles/roledetail/' . $roles->id, 'Role Lists', 'class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs"'); ?>
                                <?php echo anchor('auth/roles/update/' . $roles->id, 'Update', 'class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs"'); ?>
                                <?php echo anchor('auth/roles/delete/' . $roles->id, 'Delete', 'class="bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded text-xs" onclick="return confirm(\'Are You Sure ?\')"'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="text-sm text-gray-600 mb-2 md:mb-0">
            Total Record: <span class="font-semibold"><?php echo $total_rows ?></span>
        </div>
        <div class="text-sm">
            <?php echo $pagination ?>
        </div>
    </div>
</div>