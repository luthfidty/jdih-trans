<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- content -->
<div id="content" class="space-y-6">

    <div class="bg-white rounded shadow">
        <div class="border-b px-4 py-3">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <?php echo $this->myacl->_btnCreate(site_url('auth/users/create'), "Tambah");
                    ?>
                </div>
                <div class="text-center text-sm text-gray-700 w-full md:w-auto">
                    <?php echo $this->session->userdata('message') ?: ''; ?>
                </div>
                <div>
                    <form action="<?php echo site_url('auth/users/index'); ?>" method="get"
                        class="flex gap-2 items-center">
                        <input type="text" name="q" value="<?php echo $q; ?>"
                            class="border border-gray-300 rounded px-2 py-1 text-sm" placeholder="Cari...">
                        <?php if ($q <> ''): ?>
                            <a href="<?php echo site_url('auth/users'); ?>"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
                        <?php endif; ?>
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">CreatedAt</th>
                        <th class="px-4 py-2">UpdatedAt</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users_data as $users): ?>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2"><?php echo ++$start ?></td>
                            <td class="px-4 py-2"><?php echo $users->username ?></td>
                            <td class="px-4 py-2"><?php echo $users->rolename ?></td>
                            <td class="px-4 py-2"><?php echo $users->isactive == 1 ? 'Activated' : 'Not Activated Yet' ?>
                            </td>
                            <td class="px-4 py-2 tanggal" data-date="<?= $users->createdat ?>"
                                data-format='DD/MM/YYYY HH:mm'></td>
                            <td class="px-4 py-2 tanggal" data-date="<?= $users->updatedat ?>"
                                data-format='DD/MM/YYYY HH:mm'></td>
                            <td class="px-4 py-2 space-x-2">
                                <?php echo anchor(site_url('auth/users/update/' . $users->id), 'Update', 'class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm"'); ?>
                                <?php if ($users->isactive == 0): ?>
                                    <?php echo anchor(site_url('auth/users/activate/' . $users->id), 'Activate', 'class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm" onclick="return confirm(\'Are You Sure ?\')"'); ?>
                                <?php endif; ?>
                                <?php echo anchor(site_url('auth/users/delete/' . $users->id), 'Delete', 'class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" onclick="return confirm(\'Are You Sure ?\')"'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="border-t px-4 py-3 flex flex-wrap justify-between items-center text-sm">
            <div class="mb-2 md:mb-0">
                <span class="bg-blue-600 text-white px-3 py-1 rounded">Total Record: <?php echo $total_rows ?></span>
            </div>
            <div>
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</div>