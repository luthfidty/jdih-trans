<?php
$this->load->view('base/headercontent');
?>
<!-- /Page Title -->

<style>
    .modal-checkbox {
        display: none;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }
    .modal-checkbox:checked ~ .modal {
        display: flex;
    }
</style>

<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
        <!-- Header Panel -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <!-- Tombol -->
            <div class="flex flex-wrap">
                <?php
                if (in_array('pending', $rolelist)) {
                    echo $this->myacl->_btnDefault(site_url('app/regulations/pending'), "Pending", "bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm", "fa-question-circle");
                }
                if (in_array('create', $rolelist)) {
                    echo $this->myacl->_btnCreate(site_url('app/regulations/create'), "Tambah");
                    echo $this->myacl->_btnDefault(site_url('app/regulations/trash'), "Tong Sampah", "bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded text-sm", "fa-trash");
                }
                if (in_array('delete', $rolelist)) {
                    echo '<button type="button" id="deleteSelectedBtn" onclick="deleteSelected()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm hidden"><i class="fas fa-trash-alt mr-1"></i> Hapus Terpilih</button>';
                }
                ?>
                <label for="filterModalCheckbox" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm cursor-pointer">
                    <i class="fas fa-filter mr-1"></i> Filter
                </label>
            </div>
        </div>

        <!-- Modal untuk Filter tanpa JavaScript -->
        <input type="checkbox" id="filterModalCheckbox" class="modal-checkbox">
        <div class="modal bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-md shadow-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h5 class="text-lg font-semibold">Filter Data</h5>
                    <label for="filterModalCheckbox" class="text-gray-600 hover:text-gray-800 cursor-pointer">
                        <i class="fas fa-times text-lg"></i>
                    </label>
                </div>
                <div class="p-4">
                    <form action="<?php echo site_url('app/regulations/index'); ?>" method="get" id="filterForm">
                        <div class="mb-3">
                            <select name="category" id="category" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Jenis Dokumen ---</option>
                                <?php foreach ($doccategory as $cat): ?>
                                    <option value="<?= $cat->id ?>" <?= isset($_GET['category']) && $_GET['category'] == $cat->id ? 'selected' : '' ?>>
                                        <?= $cat->category ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="doctype" id="doctype" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Tipe Dokumen ---</option>
                                <?php foreach ($doctypes as $type): ?>
                                    <option value="<?= $type->id ?>" <?= isset($_GET['doctype']) && $_GET['doctype'] == $type->id ? 'selected' : '' ?>>
                                        <?= $type->documenttype ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="year" id="year" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Tahun ---</option>
                                <?php foreach ($years as $y): ?>
                                    <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="status" id="status" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Status ---</option>
                                <?php foreach ($isStatus as $k => $v): ?>
                                    <option value="<?= $v ?>" <?= isset($_GET['status']) && $_GET['status'] == $v ? 'selected' : '' ?>>
                                        <?= $v ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="published" id="published" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Publikasi ---</option>
                                <?php foreach ($isPublished as $k => $v): ?>
                                    <option value="<?= $v ?>" <?= isset($_GET['published']) && $_GET['published'] == $v ? 'selected' : '' ?>>
                                        <?= $v ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- FIELD BARU: PUBLISH JDIHN FILTER -->
                        <div class="mb-3">
                             <select name="publish_jdihn" id="publish_jdihn" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="">--- Publikasi JDIHN ---</option>
                                <option value="1" <?= isset($_GET['publish_jdihn']) && $_GET['publish_jdihn'] == '1' ? 'selected' : '' ?>>Ya</option>
                                <option value="0" <?= isset($_GET['publish_jdihn']) && $_GET['publish_jdihn'] == '0' ? 'selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                        <!-- BATAS FIELD BARU -->

                        <div class="mb-3">
                            <label for="assignmentdate_from" class="text-sm text-gray-700 block">Tgl Penetapan:</label>
                            <div class="flex items-center gap-2">
                                <input type="date" name="assignmentdate_from" id="assignmentdate_from"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                                    value="<?php echo isset($_GET['assignmentdate_from']) ? $_GET['assignmentdate_from'] : ''; ?>">
                                <span class="text-sm text-gray-700">-</span>
                                <input type="date" name="assignmentdate_to" id="assignmentdate_to"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                                    value="<?php echo isset($_GET['assignmentdate_to']) ? $_GET['assignmentdate_to'] : ''; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="q" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                                value="<?php echo $q; ?>" placeholder="Cari...">
                        </div>
                        <!-- Preserve sort parameters -->
                        <?php if (isset($_GET['sort_by'])): ?>
                            <input type="hidden" name="sort_by" value="<?php echo $_GET['sort_by']; ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['sort_order'])): ?>
                            <input type="hidden" name="sort_order" value="<?php echo $_GET['sort_order']; ?>">
                        <?php endif; ?>
                    </form>
                </div>
                <div class="p-4 border-t border-gray-200 flex justify-end gap-2">
                    <?php if ($q != '' || isset($_GET['category']) || isset($_GET['doctype']) || isset($_GET['year']) || isset($_GET['status']) || isset($_GET['published']) || isset($_GET['publish_jdihn']) || isset($_GET['assignmentdate_from']) || isset($_GET['assignmentdate_to'])): ?>
                        <a href="<?php echo site_url('app/regulations'); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
                    <?php endif; ?>
                    <label for="filterModalCheckbox" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm cursor-pointer">Tutup</label>
                    <button type="submit" form="filterForm" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Cari</button>
                </div>
            </div>
        </div>

        <!-- Table Responsive -->
        <form id="bulkDeleteForm" action="<?php echo site_url('app/regulations/bulk_delete'); ?>" method="post">
            <input type="hidden" id="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="relative overflow-x-auto">
                <table class="min-w-full text-sm text-left border-t border-gray-200 table-fixed">
                    <thead class="bg-gray-100 text-gray-700 sticky top-0 z-20">
                        <tr>
                            <th class="sticky left-0 z-30 bg-gray-100 px-4 py-2 border-b w-[40px]">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                            </th>
                            <th class="sticky left-[40px] z-30 bg-gray-100 px-4 py-2 border-b w-[60px]">No</th>
                            <th class="sticky left-[100px] z-30 bg-gray-100 px-4 py-2 border-b w-[200px]">Judul</th>
                            <!-- FIELD BARU DITAMBAHKAN -->
                            <th class="px-4 py-2 border-b whitespace-nowrap">JDIHN</th>
                            <!-- BATAS FIELD BARU -->
                            <th class="px-4 py-2 border-b whitespace-nowrap">Jenis Dokumen</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tipe Dokumen</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">TEU</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">No Peraturan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">
                                <a href="<?php echo site_url('app/regulations/index?' . http_build_query(array_merge($_GET, ['sort_by' => 'regulations.year', 'sort_order' => $sort_by === 'regulations.year' && $sort_order === 'asc' ? 'desc' : 'asc']))); ?>">
                                    Tahun
                                    <?php if ($sort_by === 'regulations.year'): ?>
                                        <i class="fas fa-sort-<?php echo $sort_order === 'asc' ? 'up' : 'down'; ?> ml-1"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort ml-1"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tempat Penetapan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tgl Penetapan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tgl Pengesahan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tgl Berlaku</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Status</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Publikasi</th>
                            <th class="sticky right-0 z-10 bg-gray-100 px-4 py-2 border-b text-center w-[120px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($regulations_data as $i => $regulations): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="sticky left-0 z-20 bg-white px-4 py-2 border-b">
                                    <input type="checkbox" class="rowCheckbox" value="<?php echo $regulations->id ?>" onchange="handleCheckboxChange(this)">
                                </td>
                                <td class="sticky left-[40px] z-20 bg-white px-4 py-2 border-b"><?php echo ++$start ?></td>
                                <td class="sticky left-[100px] z-20 bg-white px-4 py-2 border-b"><?php echo $regulations->title ?></td>
                                <!-- DATA FIELD BARU -->
                                <td class="px-4 py-2">
                                    <?php if ($regulations->publish_jdihn == 1): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <!-- BATAS DATA FIELD BARU -->
                                <td class="px-4 py-2"><?php echo $regulations->category ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->documenttype ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->teu ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->regulationnumber ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->year ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->assignmentplace ?></td>
                                <td class="px-4 py-2 tanggal" data-date="<?= $regulations->assignmentdate ?>"></td>
                                <td class="px-4 py-2 tanggal" data-date="<?= $regulations->approvaldate ?>"></td>
                                <td class="px-4 py-2 tanggal" data-date="<?= $regulations->effectivedate ?>"></td>
                                <td class="px-4 py-2"><?php echo $regulations->status ?></td>
                                <td class="px-4 py-2"><?php echo $regulations->published ?></td>
                                <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                                    <div class="flex justify-center gap-2">
                                        <?php if (in_array('read', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/read/' . $regulations->id) ?>" title="Detail"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition duration-200">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('update', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/update/' . $regulations->id) ?>" title="Edit"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition duration-200">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('delete', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/delete/' . $regulations->id) ?>"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition duration-200">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Footer -->
        <div class="p-3 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center gap-2 mb-2 md:mb-0">
                <form action="<?php echo site_url('app/regulations/index'); ?>" method="get" class="flex items-center">
                    <select name="per_page" id="per_page" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="this.form.submit();">
                        <?php
                        $page_sizes = [10, 25, 50, 100];
                        foreach ($page_sizes as $size): ?>
                            <option value="<?= $size ?>" <?= $per_page == $size ? 'selected' : '' ?>>
                                <?= $size ?> per halaman
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Preserve ALL possible filters, bahkan jika kosong -->
                <?php 
                // Daftar parameter yang harus selalu dipertahankan
                $preserve = [
                    'q' => $q,
                    'category' => $this->input->get('category'),
                    'doctype' => $this->input->get('doctype'),
                    'year' => $this->input->get('year'),
                    'status' => $this->input->get('status'),
                    'published' => $this->input->get('published'),
                    'publish_jdihn' => $this->input->get('publish_jdihn'),
                    'assignmentdate_from' => $this->input->get('assignmentdate_from'),
                    'assignmentdate_to' => $this->input->get('assignmentdate_to'),
                    'sort_by' => $sort_by,
                    'sort_order' => $sort_order,
                ];

                foreach ($preserve as $key => $val):
                    if ($val !== null): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>">
                    <?php endif;
                endforeach; ?>
                </form>
                <div class="text-sm text-gray-600">
                    Jumlah Data: <strong><?php echo $total_rows ?></strong>
                </div>
            </div>
            <div>
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedIds = JSON.parse(sessionStorage.getItem('selectedRegulationIds')) || [];

    function updateSelectedIds() {
        console.log('Updating selectedIds:', selectedIds);
        sessionStorage.setItem('selectedRegulationIds', JSON.stringify(selectedIds));
        toggleDeleteButton();
    }

    function toggleDeleteButton() {
        const deleteButton = document.getElementById('deleteSelectedBtn');
        if (deleteButton) {
            deleteButton.classList.toggle('hidden', selectedIds.length === 0);
        }
    }

    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');

        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
            const id = checkbox.value;
            if (selectAllCheckbox.checked) {
                if (!selectedIds.includes(id)) {
                    selectedIds.push(id);
                }
            } else {
                selectedIds = selectedIds.filter(selectedId => selectedId !== id);
            }
        });

        updateSelectedIds();
    }

    function handleCheckboxChange(checkbox) {
        const id = checkbox.value;
        if (checkbox.checked) {
            if (!selectedIds.includes(id)) {
                selectedIds.push(id);
            }
        } else {
            selectedIds = selectedIds.filter(selectedId => selectedId !== id);
        }

        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
        document.getElementById('selectAll').checked = allChecked;

        updateSelectedIds();
    }

    function deleteSelected() {
        if (selectedIds.length === 0) {
            alert('Pilih setidaknya satu data untuk dihapus!');
            return;
        }

        if (confirm('Yakin ingin menghapus ' + selectedIds.length + ' data terpilih?')) {
            const form = document.getElementById('bulkDeleteForm');

            const existingContainer = document.getElementById('bulkDeleteHiddenInputs');
            if (existingContainer) {
                existingContainer.remove();
            }

            const hiddenContainer = document.createElement('div');
            hiddenContainer.id = 'bulkDeleteHiddenInputs';
            hiddenContainer.style.display = 'none';

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                hiddenContainer.appendChild(input);
            });

            form.appendChild(hiddenContainer);

            console.log('Submitting bulk delete form with IDs:', selectedIds);

            form.submit();

            sessionStorage.removeItem('selectedRegulationIds');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        console.log('Row checkboxes found:', rowCheckboxes.length);
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = selectedIds.includes(checkbox.value);
            checkbox.addEventListener('change', () => handleCheckboxChange(checkbox));
        });

        const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
        document.getElementById('selectAll').checked = allChecked && rowCheckboxes.length > 0;

        toggleDeleteButton();
    });
</script>