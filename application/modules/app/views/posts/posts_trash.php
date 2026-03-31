<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->
<!-- Content Wrapper -->
<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
        <!-- Header Panel -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <!-- Tombol -->
            <div class="flex flex-wrap gap-2">
                <?php
                echo $this->myacl->_btnDefault(site_url('app/posts'), "Daftar Artikel", "bg-cyan-600 hover:bg-cyan-700", "fa-list");
                if (in_array('restore', $rolelist) || in_array('permanent_delete', $rolelist)) {
                    echo '<button type="button" id="deleteSelectedBtn" onclick="deleteSelected()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm hidden"><i class="fas fa-trash-alt mr-1"></i> Hapus Terpilih</button>';
                }
                ?>
            </div>

            <!-- Form pencarian -->
            <form action="<?php echo site_url('app/posts/trash'); ?>" method="get"
                class="flex flex-wrap gap-2 items-center">
                <input type="text" name="q" class="border border-gray-300 rounded px-2 py-1 text-sm"
                    value="<?php echo $q; ?>" placeholder="Cari...">
                <?php if ($q != ''): ?>
                    <a href="<?php echo site_url('app/posts/trash'); ?>"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Atur Ulang</a>
                <?php endif; ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>
        </div>

        <!-- Table Responsive -->
        <form id="bulkDeleteForm" action="<?php echo site_url('app/posts/bulk_permanent_delete'); ?>" method="post">
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
                            <th class="px-4 py-2 border-b">Thumbnail</th>
                            <th class="px-4 py-2 border-b">Judul</th>
                            <th class="px-4 py-2 border-b">Alias URL</th>
                            <th class="px-4 py-2 border-b">Kategori</th>
                            <th class="px-4 py-2 border-b">Status</th>
                            <th class="sticky right-0 z-30 bg-gray-100 px-4 py-2 border-b text-center w-[120px]">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts_data as $posts): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="sticky left-0 z-10 bg-white px-4 py-2 w-[40px]">
                                    <?php if (in_array('permanent_delete', $rolelist)): ?>
                                        <input type="checkbox" name="ids[]" value="<?= $posts->id ?>" class="rowCheckbox">
                                    <?php endif; ?>
                                </td>
                                <td class="sticky left-[40px] z-10 bg-white px-4 py-2 w-[60px]"><?php echo ++$start ?></td>
                                <td class="px-4 py-2">
                                    <a href="<?php echo site_url($posts->postimage) ?>" target="_blank" class="block w-24">
                                        <img src="<?php echo site_url($posts->postimagethumb) ?>" class="rounded border"
                                            alt="Thumbnail" />
                                    </a>
                                </td>
                                <td class="px-4 py-2"><?php echo $posts->title ?></td>
                                <td class="px-4 py-2"><?php echo $posts->slug ?></td>
                                <td class="px-4 py-2"><?php echo $posts->categoryname ?></td>
                                <td class="px-4 py-2"><?php echo $status[$posts->poststatus] ?></td>
                                <td class="sticky right-0 z-10 bg-white px-4 py-2 text-center w-[120px]">
                                    <div class="flex justify-center gap-2">
                                        <?php if (in_array('restore', $rolelist)): ?>
                                            <a href="<?php echo site_url('app/posts/restore/' . $posts->id) ?>" title="Pulihkan"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition duration-200">
                                                <i class="fas fa-sync-alt text-sm"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (in_array('permanent_delete', $rolelist)): ?>
                                            <a href="<?php echo site_url('app/posts/permanent_delete/' . $posts->id) ?>"
                                                onclick="return confirm('Hapus permanen?')" title="Hapus Permanen"
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
        <div class="px-4 py-3 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center gap-2 mb-2 md:mb-0">
                <form action="<?php echo site_url('app/posts/trash'); ?>" method="get" class="flex items-center">
                    <select name="per_page" id="per_page" class="border border-gray-300 rounded px-2 py-1 text-sm"
                        onchange="this.form.submit();">
                        <?php
                        $page_sizes = [10, 25, 50, 100];
                        foreach ($page_sizes as $size): ?>
                            <option value="<?= $size ?>" <?= isset($_GET['per_page']) && $_GET['per_page'] == $size ? 'selected' : '' ?>>
                                <?= $size ?> per halaman
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Preserve other query parameters -->
                    <?php if ($q != ''): ?>
                        <input type="hidden" name="q" value="<?php echo $q; ?>">
                    <?php endif; ?>
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
    let selectedIds = JSON.parse(sessionStorage.getItem('selectedPostIds')) || [];

    function updateSelectedIds() {
        console.log('Updating selectedIds:', selectedIds);
        sessionStorage.setItem('selectedPostIds', JSON.stringify(selectedIds));
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

        if (confirm('Yakin ingin menghapus permanen ' + selectedIds.length + ' data terpilih?')) {
            const form = document.getElementById('bulkDeleteForm');

            // Hapus input hidden lama jika ada
            const existingContainer = document.getElementById('bulkDeleteHiddenInputs');
            if (existingContainer) {
                existingContainer.remove();
            }

            // Buat elemen hidden container baru
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

            // Log untuk debugging
            console.log('Submitting bulk permanent delete form with IDs:', selectedIds);

            // Submit form
            form.submit();

            // Clear session storage
            sessionStorage.removeItem('selectedPostIds');
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