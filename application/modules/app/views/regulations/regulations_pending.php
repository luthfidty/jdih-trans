<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->
<!-- Content -->
<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow">
        <!-- Header Panel -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <!-- Kiri: Tombol -->
            <div class="flex flex-wrap gap-2">
                <?php
                echo $this->myacl->_btnDefault(site_url('app/regulations'), "Peraturan", "bg-cyan-600 hover:bg-cyan-700", "fa-list");
                if (in_array('update', $rolelist)) {
                    echo '<button type="button" id="publishSelectedBtn" onclick="publishSelected()" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm hidden"><i class="fas fa-check-circle mr-1"></i> Publish Terpilih</button>';
                }
                ?>
            </div>

            <!-- Kanan: Pencarian -->
            <form action="<?php echo site_url('app/regulations/pending'); ?>" method="get"
                class="flex gap-2 items-center">
                <input type="text" name="q" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    value="<?php echo $q; ?>" placeholder="Cari...">
                <?php if ($q != ''): ?>
                    <a href="<?php echo site_url('app/regulations/pending'); ?>"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
                <?php endif; ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>
        </div>

        <!-- Table -->
        <form id="bulkPublishForm" action="<?php echo site_url('app/regulations/bulk_publish'); ?>" method="post">
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
                            <th class="px-4 py-2 border-b whitespace-nowrap">Jenis Dokumen</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tipe Dokumen</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">TEU</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Nomor Peraturan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tahun</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tempat Penetapan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tanggal Penetapan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tanggal Pengundangan</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Tanggal Berlaku Efektif</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Status</th>
                            <th class="px-4 py-2 border-b whitespace-nowrap">Publikasi</th>
                            <th class="sticky right-0 z-30 bg-gray-100 px-4 py-2 border-b w-[140px] text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($regulations_data as $regulations): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[40px]">
                                    <?php if (in_array('update', $rolelist)): ?>
                                        <input type="checkbox" name="ids[]" value="<?= $regulations->id ?>" class="rowCheckbox">
                                    <?php endif; ?>
                                </td>
                                <td class="sticky left-[40px] z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start ?></td>
                                <td class="sticky left-[100px] z-10 bg-white px-4 py-2 w-[200px]">
                                    <?php echo $regulations->title ?>
                                </td>
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
                                <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[140px]">
                                    <div class="flex justify-center gap-2">
                                        <?php if (in_array('update', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/approve/' . $regulations->id) ?>" title="Publish"
                                                onclick="return confirm('Yakin ingin mempublish data ini?')"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 hover:text-teal-800 transition">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('read', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/read/' . $regulations->id) ?>" title="Detail"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('update', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/update/' . $regulations->id) ?>" title="Edit"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('delete', $rolelist)): ?>
                                            <a href="<?= site_url('app/regulations/delete/' . $regulations->id) ?>" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 transition">
                                                <i class="fas fa-trash-alt"></i>
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

<script>
    let selectedIds = JSON.parse(sessionStorage.getItem('selectedRegulationIds')) || [];

    function updateSelectedIds() {
        console.log('Updating selectedIds:', selectedIds);
        sessionStorage.setItem('selectedRegulationIds', JSON.stringify(selectedIds));
        togglePublishButton();
    }

    function togglePublishButton() {
        const publishButton = document.getElementById('publishSelectedBtn');
        if (publishButton) {
            publishButton.classList.toggle('hidden', selectedIds.length === 0);
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

    function publishSelected() {
        if (selectedIds.length === 0) {
            alert('Pilih setidaknya satu data untuk dipublish!');
            return;
        }

        if (confirm('Yakin ingin mempublish ' + selectedIds.length + ' data terpilih?')) {
            const form = document.getElementById('bulkPublishForm');

            // Remove old hidden inputs if any
            const existingContainer = document.getElementById('bulkPublishHiddenInputs');
            if (existingContainer) {
                existingContainer.remove();
            }

            // Create new hidden inputs container
            const hiddenContainer = document.createElement('div');
            hiddenContainer.id = 'bulkPublishHiddenInputs';
            hiddenContainer.style.display = 'none';

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                hiddenContainer.appendChild(input);
            });

            form.appendChild(hiddenContainer);

            // Log for debugging
            console.log('Submitting bulk publish form with IDs:', selectedIds);

            // Submit form
            form.submit();

            // Clear session storage
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

        togglePublishButton();
    });
</script>