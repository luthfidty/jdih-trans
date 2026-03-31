<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow">
        <!-- Header Controls -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <div class="flex flex-wrap">
                <?php
                if (in_array('pending', $rolelist)) {
                    echo $this->myacl->_btnDefault(site_url('app/nonregulations/pending'), "Pending", "bg-yellow-500 hover:bg-yellow-600", "fa-question-circle");
                }
                if (in_array('create', $rolelist)) {
                    echo $this->myacl->_btnCreate(site_url('app/nonregulations/create'), "Tambah");
                }
                ?>
            </div>

            <form action="<?php echo site_url('app/nonregulations/index'); ?>" method="get"
                class="flex flex-wrap gap-2 items-center">
                <select name="category" id="category" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    onchange="if(this.value != 0) { this.form.submit(); }">
                    <option value="">--- Kategori Non Peraturan ---</option>
                    <?php foreach ($groups as $k => $v): ?>
                        <option value="<?= $k ?>" <?= isset($_GET['category']) && $_GET['category'] == $k ? 'selected' : '' ?>>
                            <?= $v ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                 <select name="published" id="published" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    onchange="if(this.value != '') { this.form.submit(); }">
                    <option value="">--- Status ---</option>
                    <?php foreach ($isPublished as $k => $v): ?>
                        <option value="<?= $v ?>" <?= isset($_GET['published']) && $_GET['published'] == $v ? 'selected' : '' ?>>
                            <?= $v ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Cari..."
                    class="border border-gray-300 rounded px-2 py-1 text-sm" />
                <?php if ($q != '' || isset($_GET['category'])): ?>
                    <a href="<?php echo site_url('app/nonregulations'); ?>"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
                <?php endif; ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto">
            <table class="min-w-full text-sm text-left border-t border-gray-200 table-fixed">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-20">
                    <tr>
                        <th class="sticky left-0 z-30 bg-gray-100 px-4 py-2 border-b w-[60px]">No</th>
                        <th class="px-4 py-2 border-b">Kulit Buku</th>
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">Kategori</th>
                        <th class="px-4 py-2 border-b">TEU</th>
                        <th class="px-4 py-2 border-b">Nomor Panggil</th>
                        <th class="px-4 py-2 border-b">Tahun Terbit</th>
                        <th class="px-4 py-2 border-b">Penerbit</th>
                        <th class="px-4 py-2 border-b">ISBN/ISSN</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="sticky right-0 z-30 bg-gray-100 px-4 py-2 border-b text-center w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nonregulations_data as $nonregulations):
                        $cover = json_decode($nonregulations->bookcover);
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start ?></td>
                            <td class="px-4 py-2">
                                <a href="<?= site_url($cover->fullpath) ?>" target="_blank">
                                    <img src="<?= site_url($cover->filepath . '/' . $cover->filename) ?>"
                                        alt="<?= $nonregulations->title ?>" class="h-24 object-contain rounded shadow" />
                                </a>
                            </td>
                            <td class="px-4 py-2"><?php echo $nonregulations->title ?></td>
                            <td class="px-4 py-2"><?php echo $groups[$nonregulations->groups] ?></td>
                            <td class="px-4 py-2"><?php echo $nonregulations->teu ?></td>
                            <td class="px-4 py-2"><?php echo $nonregulations->callnumber ?></td>
                            <td class="px-4 py-2"><?php echo $nonregulations->year ?></td>
                            <td class="px-4 py-2"><?php echo $nonregulations->publisher ?></td>
                            <td class="px-4 py-2"><?php echo $nonregulations->isbnissnnumber ?></td>
                            <td class="px-4 py-2"><?php echo isset($isPublished[$nonregulations->published]) ? $isPublished[$nonregulations->published] : $nonregulations->published ?></td>
                            <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                                <div class="flex justify-center gap-2">
                                    <?php if (in_array('read', $rolelist)) { ?>
                                        <a href="<?= site_url('app/nonregulations/read/' . $nonregulations->id) ?>"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition duration-200"
                                            title="Detail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if (in_array('update', $rolelist)) { ?>
                                        <a href="<?= site_url('app/nonregulations/update/' . $nonregulations->id) ?>"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition duration-200"
                                            title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if (in_array('delete', $rolelist)) { ?>
                                        <a href="<?= site_url('app/nonregulations/delete/' . $nonregulations->id) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
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
            <div class="flex items-center gap-2 mb-2 md:mb-0">
              <form action="<?= site_url('app/nonregulations/index') ?>" method="get" class="flex items-center">
                    <select name="per_page" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="this.form.submit();">
                        <?php foreach ([10, 25, 50, 100] as $size): ?>
                            <option value="<?= $size ?>" <?= ($this->input->get('per_page') ?: 10) == $size ? 'selected' : '' ?>>
                                <?= $size ?> per halaman
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Otomatis preserve SEMUA parameter yang ada di URL (kecuali per_page yang diganti) -->
                    <?php foreach ($this->input->get() as $key => $value): ?>
                        <?php if ($key !== 'per_page'): ?>
                            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </form>
                <div class="text-sm text-gray-600">
                    Jumlah Data: <strong><?php echo $total_rows ?></strong>
                </div>
            </div>
            <div><?php echo $pagination ?></div>
        </div>
    </div>
</div>
