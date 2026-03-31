<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Content -->
<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <!-- Tombol kiri -->
            <div class="flex flex-wrap items-center">
                <!-- <?php if (in_array('create', $rolelist)) {
                    echo $this->myacl->_btnCreate(site_url('app/media/create'), "Tambah");
                } ?> -->
            </div>

            <!-- Info tengah -->
            <!-- <div class="flex-1 text-center text-sm text-gray-600">
                <?= $this->session->userdata('message') ?? '' ?>
            </div> -->

            <!-- Form pencarian -->
            <form action="<?= site_url('app/media/index') ?>" method="get" class="flex gap-2 items-center">
                <input type="text" name="q" value="<?= $q ?>" placeholder="Cari..."
                    class="border border-gray-300 rounded px-2 py-1 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <?php if ($q <> ''): ?>
                    <a href="<?= site_url('app/media') ?>" class="text-sm text-yellow-600 hover:underline">Atur Ulang</a>
                <?php endif; ?>
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Cari</button>
            </form>
        </div>

        <!-- Body / Gallery -->
        <div class="p-4">
            <div x-data="{ open: false, image: '' }">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <?php foreach ($media_data as $m): ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 group">
                            <div class="relative">
                                <img src="<?= base_url($m->filepath . '/' . $m->filename) ?>" alt="Thumbnail"
                                    class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-300">

                                <!-- Overlay icon saat hover -->
                                <div class="absolute inset-0 flex items-center justify-center gap-3
            bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button title="lihat" @click="image = '<?= site_url($m->fullpath) ?>'; open = true"
                                        class="w-10 h-10 flex items-center justify-center text-white bg-green-600 hover:bg-green-700 rounded-full shadow">
                                        <i class="fa fa-eye text-sm"></i>
                                    </button>

                                    <button title="salin" onclick="copyToClipboard('<?= base_url($m->fullpath) ?>')"
                                        class="w-10 h-10 flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow">
                                        <i class="fa fa-copy text-sm"></i>
                                    </button>

                               
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>

                <!-- Modal Preview -->
                <!-- Modal Preview -->
                <div x-show="open"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4" x-transition>
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-5xl p-6 relative">
                        <button @click="open = false"
                            class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-xl">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="overflow-hidden rounded-md">
                            <img :src="image" alt="Preview"
                                class="w-full max-h-[80vh] object-contain transition-all duration-300 ease-in-out">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="text-sm text-gray-600">
                Jumlah Data: <strong><?= $total_rows ?></strong>
            </div>
            <div>
                <?= $pagination ?>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        if (!navigator.clipboard) {
            // fallback untuk browser lama
            const tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("Disalin ke clipboard!");
        } else {
            navigator.clipboard.writeText(text)
                .then(() => {
                    console.log('Copied:', text);
                    alert("Disalin ke clipboard!");
                })
                .catch(err => {
                    console.error('Gagal menyalin:', err);
                    alert("Gagal menyalin ke clipboard.");
                });
        }
    }
</script>