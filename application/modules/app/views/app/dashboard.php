<!-- Page Title -->
<header id="page-header" class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Beranda</h1>
</header>

<div id="content" class="p-5 bg-white rounded-lg shadow-sm">
    <!-- <?php if ($this->session->userdata('message') <> ''): ?>
        <div class="mb-4 text-center">
            <div class="inline-block bg-blue-100 text-blue-800 text-sm px-4 py-2 rounded">
                <strong><?php echo $this->session->userdata('message'); ?>.</strong>
            </div>
        </div>
    <?php endif; ?> -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">

        <!-- Card Template -->
        <div
            class="bg-gradient-to-br from-teal-500 to-teal-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-file text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pubDoc ?> Dokumen Peraturan</h4>
                    <p class="text-sm text-teal-100 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/regulations') ?>" class="text-sm underline text-white">Lihat Detil</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div
            class="bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-file text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pubNon ?> Dokumen Non Peraturan</h4>
                    <p class="text-sm text-indigo-100 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/nonregulations') ?>" class="text-sm underline text-white">Lihat
                    Detil</a>
            </div>
        </div>

        <!-- Card 3 -->
        <div
            class="bg-gradient-to-br from-pink-500 to-pink-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-file text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pendDoc ?> Dokumen Peraturan</h4>
                    <p class="text-sm text-pink-100 mt-1">Perlu Disetujui</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/regulations/pending') ?>" class="text-sm underline text-white">Lihat
                    Detil</a>
            </div>
        </div>

        <!-- Card 4 -->
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-file text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pendNon ?> Non Peraturan</h4>
                    <p class="text-sm text-blue-100 mt-1">Perlu Disetujui</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/nonregulations/pending') ?>"
                    class="text-sm underline text-white">Lihat Detil</a>
            </div>
        </div>

        <!-- Artikel -->
        <div
            class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-paper-plane text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pubPost ?> Artikel</h4>
                    <p class="text-sm text-yellow-100 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/posts') ?>" class="text-sm underline text-white">Lihat
                    Detil</a>
            </div>
        </div>

        <!-- Galeri -->
        <div
            class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-images text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $pubGal ?> Galeri</h4>
                    <p class="text-sm text-green-100 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/galleries') ?>" class="text-sm underline text-white">Lihat Detil</a>
            </div>
        </div>
        <!-- Galeri -->
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-clipboard-list text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $allSurvey ?> Survey</h4>
                    <p class="text-sm text-purple-100 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/surveys') ?>" class="text-sm underline text-white">Lihat Detil</a>
            </div>
        </div>
        <!-- Media -->
        <div
            class="bg-gradient-to-br from-gray-600 to-gray-800 text-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div class="flex items-start gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full h-16 w-16 flex items-center justify-center">
                    <i class="fa fa-photo-video text-3xl"></i> <!-- Alternatif: fa-images -->
                </div>
                <div>
                    <h4 class="text-xl font-bold"><?php echo $allMedia ?> Media</h4>
                    <p class="text-sm text-gray-200 mt-1">Dipublish</p>
                </div>
            </div>
            <div class="text-right mt-6">
                <a href="<?php echo site_url('app/media') ?>" class="text-sm underline text-white">Lihat Detil</a>
            </div>
        </div>


    </div>



    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Dokumen Pertahun -->
        <div class="bg-white border border-teal-500 rounded-lg shadow p-4">
            <h4 class="text-teal-700 text-lg font-semibold mb-3">Dokumen Peraturan Pertahun</h4>
            <div id="barNumDocsYears" class="w-full h-72"></div>
        </div>

        <!-- Dokumen Perkategori -->
        <div class="bg-white border border-blue-500 rounded-lg shadow p-4">
            <h4 class="text-blue-700 text-lg font-semibold mb-3">Dokumen Peraturan Perkategori</h4>
            <div id="barNumDocsCat" class="w-full h-72"></div>
        </div>

        <!-- Survey Kepuasan -->
        <div class="bg-white border border-yellow-500 rounded-lg shadow p-4">
            <h4 class="text-yellow-700 text-lg font-semibold mb-3">Survey Kepuasan Layanan</h4>
            <div id="graph-donut" class="w-full h-72"></div>
        </div>

        <!-- Grafik Pengunjung -->
        <div class="bg-white border border-green-500 rounded-lg shadow p-4">
            <h4 class="text-green-700 text-lg font-semibold mb-3">Grafik Pengunjung Harian</h4>
            <div id="graph-non-date" class="w-full h-72"></div>
        </div>
    </div>

</div>