<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->




<!-- Content -->
<div class="space-y-4">

    <!-- Header Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap">

            <?php
            echo $this->myacl->_btnCreate(site_url('auth/routings/create'), "Tambah");
            echo $this->myacl->_btnDefault(site_url('auth/routings/generateAll'), "Generate Semua Fungsi", "bg-teal-600 hover:bg-teal-700", "fa-refresh");

            ?>
        </div>

        <!-- <div class="text-center text-green-700 text-sm font-medium">
            <?= $this->session->userdata('message') ?? '' ?>
        </div> -->

        <form action="<?= site_url('auth/routings/index') ?>" method="get" class="flex items-center gap-2">
            <input type="text" name="q" value="<?= $q ?>" placeholder="Cari..."
                class="border border-gray-300 rounded px-2 py-1 text-sm w-48 focus:outline-none focus:ring focus:ring-blue-300" />

            <?php if ($q != ''): ?>
                <a href="<?= site_url('auth/routings') ?>" class="text-sm text-yellow-600 hover:underline">Atur Ulang</a>
            <?php endif; ?>

            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
        </form>

    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Routename</th>
                    <th class="px-4 py-3">Routealias</th>
                    <th class="px-4 py-3">Routeurl</th>
                    <th class="px-4 py-3">Createdat</th>
                    <th class="px-4 py-3">Updatedat</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($routings_data as $routings): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2"><?= ++$start ?></td>
                        <td class="px-4 py-2"><?= $routings->routename ?></td>
                        <td class="px-4 py-2"><?= $routings->routealias ?></td>
                        <td class="px-4 py-2"><?= $routings->routeurl ?></td>
                        <td class="px-4 py-2 tanggal" data-format='DD/MM/YYYY HH:mm'
                            data-date='<?= $routings->createdat ?>'></td>
                        <td class="px-4 py-2 tanggal" data-format='DD/MM/YYYY HH:mm'
                            data-date='<?= $routings->updatedat ?>'></td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="<?= site_url('auth/routings/generateOne/' . $routings->id) ?>"
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">Generate</a>
                            <a href="<?= site_url('auth/routings/update/' . $routings->id) ?>"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">Update</a>
                            <a href="<?= site_url('auth/routings/delete/' . $routings->id) ?>"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs"
                                onclick="return confirm('Are You Sure ?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Pagination -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-4">
        <div class="text-sm text-gray-700">
            Total Record : <span class="font-semibold"><?= $total_rows ?></span>
        </div>
        <div>
            <?= $pagination ?>
        </div>
    </div>
</div>