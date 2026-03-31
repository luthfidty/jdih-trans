<div class=" flex flex-col relative" style="background-image: url('<?php echo site_url($this->config->item('site_hero')) ?>'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;">
    <div
        class="flex flex-col mt-16 items-center text-center gap-4 laptop:flex-row laptop:justify-center laptop:items-center laptop:text-left laptop:gap-4">
        <img class="h-[42px]" src="<?php echo site_url($this->config->item('site_logo1')) ?>"
            alt="<?php echo site_url($this->config->item('site_name')) ?>" />

        <div class="text-white">
            <h1 class="text-xl laptop:text-2xl font-bold uppercase">
                Kementerian Transmigrasi Republik Indonesia
            </h1>
            <p class="text-sm laptop:text-base font-light hidden laptop:block">
                Jaringan Dokumentasi dan Informasi Hukum
            </p>
        </div>
    </div>

    <form novalidate method="get" action="<?php echo site_url('web/regulations/search') ?>"
        class="w-full max-w-5xl px-4 py-8 mx-auto my-16 bg-transparent text-center">

        <!-- Judul -->
        <h1 class="text-lg laptop:text-2xl text-white uppercase mb-6">Pencarian Dokumen Peraturan</h1>

        <div class="flex flex-col gap-4 w-full">

            <!-- Alert pesan error -->
            <!-- <?php if ($this->session->userdata('message')) { ?>
            <div class="px-2">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block"><?php echo $this->session->userdata('message') ?></span>
                    <button type="button"
                        class="absolute top-1 right-2 text-red-700 hover:text-red-900 focus:outline-none">
                        <i data-feather="x"></i>
                    </button>
                </div>
            </div>
        <?php } ?> -->

            <!-- 🔹 Mobile View -->
            <div class="flex flex-col gap-4 laptop:hidden">

                <!-- Kategori + Kata Kunci -->
                <div class="relative flex flex-col gap-4 ">
                    <!-- Kategori -->
                    <div class="bg-[#F7F6F5] px-4 py-4 rounded-full">
                        <select id="rcategory" name="rcategory"
                            class="bg-transparent text-[#656565] focus:outline-none text-sm w-full">
                            <option value="0" selected>Pilih Jenis/Kategori Dokumen</option>
                            <?php
                            if (!empty($documentcategory)) {
                                foreach ($documentcategory as $dc) {
                                    echo '<option value="' . $dc->id . '">' . $dc->acronym . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Kata Kunci -->
                    <input type="text" name="kw" placeholder="Kata Kunci"
                        class="focus:outline-none focus:ring-0 w-full bg-[#F7F6F5] px-4 py-4 rounded-full text-sm border border-[#BBBBBB]" />
                </div>

                <!-- Tahun Terbit -->
                <div
                    class="bg-[#F7F6F5] p-1.5 rounded-full flex items-center gap-2 text-[#0036B8] border border-[#F7EBD8]">
                    <div class="flex items-center gap-2 border px-4 py-2 bg-[#D7E3FF] rounded-full">
                        <i data-feather="calendar"></i>
                        <p class="text-nowrap text-sm">Tahun Terbit</p>
                    </div>
                    <input type="text" name="ryear" id="ryear" placeholder="Tahun Terbit"
                        class="px-2 focus:outline-none w-full bg-transparent text-[#888888] placeholder:text-[#888888] text-sm" />
                </div>

                <!-- Nomor Peraturan -->
                <div
                    class="bg-[#F7F6F5] p-1.5 rounded-full flex items-center gap-2 text-[#0036B8] border border-[#F7EBD8]">
                    <div class="flex items-center gap-2 border px-4 py-2 bg-[#D7E3FF] rounded-full">
                        <i data-feather="file-text"></i>
                        <p class="text-nowrap text-sm">Nomor Peraturan</p>
                    </div>
                    <input type="text" name="rnumber" id="rnumber" placeholder="Nomor Peraturan"
                        class="px-2 focus:outline-none w-full bg-transparent text-[#888888] placeholder:text-[#888888] text-sm" />
                </div>
            </div>


            <!-- 🔹 Desktop View (tetap seperti desain awalmu) -->
            <div class="hidden laptop:block">
                <div class="flex flex-col gap-4 w-full">

                    <!-- Kategori + Kata Kunci dalam 1 baris -->
                    <div
                        class="relative flex items-center gap-4 border border-[#BBBBBB] p-1.5 bg-[#FFFFFF] rounded-full">
                        <div class="bg-[#F7F6F5] px-4 py-3 rounded-full">
                            <select id="rcategory" name="rcategory"
                                class="bg-transparent text-[#656565] focus:outline-none text-sm">
                                <option value="0" selected>Pilih Jenis/Kategori Dokumen</option>
                                <?php
                                if (!empty($documentcategory)) {
                                    foreach ($documentcategory as $dc) {
                                        echo '<option value="' . $dc->id . '">' . $dc->acronym . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <input type="text" name="kw" placeholder="Kata Kunci"
                            class="focus:outline-none focus:ring-0 w-full bg-transparent px-2 laptop:px-1 text-sm" />
                    </div>

                    <!-- Tahun & Nomor -->
                    <div class="flex items-center justify-center gap-4 p-1.5 bg-[#FFFFFF] bg-opacity-50 rounded-full">
                        <div class="bg-[#F7F6F5] p-1.5 rounded-full  flex items-center gap-2 text-[#0036B8] w-full">
                            <div class=" flex flex-row gap-2 border px-4 py-2 bg-[#D7E3FF] rounded-full">
                                <i data-feather="calendar"></i>
                                <p class="text-nowrap">Tahun Terbit</p>
                            </div>
                            <input type="text" name="ryear" id="ryear" placeholder="Tahun Terbit"
                                class="px-2 focus:outline-none focus:ring-0 w-full bg-transparent text-[#888888] placeholder:text-[#888888] text-sm" />
                        </div>
                        <div class="bg-[#F7F6F5] p-1.5 rounded-full  flex items-center gap-2 text-[#0036B8] w-full">

                            <div class=" flex flex-row gap-2 border px-4 py-2 bg-[#D7E3FF] rounded-full">
                                <i data-feather="file-text"></i>
                                <p class="text-nowrap">Nomor Peraturan</p>
                            </div>
                            <input type="text" name="rnumber" id="rnumber" placeholder="Nomor Peraturan"
                                class="px-2 focus:outline-none focus:ring-0 w-full bg-transparent text-[#888888] placeholder:text-[#888888] text-sm" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-center">
                <button type="submit"
                    class="flex items-center gap-3 bg-[#FFFFFF] bg-opacity-20 border border-[#FFFFFF] text-white py-3 px-16 rounded-full hover:bg-[#145072] transition">
                    <i data-feather="search"></i>
                    <span>Cari Dokumen</span>
                </button>
            </div>
        </div>
    </form>


    <div class="  bg-primary  w-full">
        <div class="container mx-auto text-white italic p-8 laptop:p-12">
            <p class="text-sm laptop:text-base laptop:text-base leading-relaxed">
                <strong class="font-semibold">Disclaimer:</strong>
                <!-- Kementerian Transmigrasi tidak menjamin keakuratan atau kelengkapan informasi yang
            terdapat dalam basis data ini. Informasi yang tersedia dapat berubah sewaktu-waktu dan mungkin belum
            mencerminkan pembaruan terbaru. Untuk keperluan analisis, keputusan hukum, atau kebijakan yang
            bersifat krusial, disarankan untuk berkonsultasi dengan pihak berwenang atau tenaga ahli yang
            berkompeten di bidang transmigrasi. Basis data ini disediakan semata-mata untuk tujuan informasi
            umum dan tidak dapat dijadikan dasar tunggal dalam pengambilan keputusan resmi. -->
                Informasi yang terdapat dalam basis data ini telah diverifikasi dengan seksama oleh Kementerian
                Transmigrasi
                dan mencerminkan data terkini. Basis data ini dapat dijadikan acuan resmi dalam analisis, pengambilan
                keputusan hukum, maupun perumusan kebijakan tanpa perlu konsultasi tambahan dengan pihak lain. Informasi
                disediakan untuk mendukung kebutuhan pengguna secara andal dan akurat.
            </p>
        </div>

    </div>


</div>

<div class=" container mx-auto flex flex-col p-4 laptop:p-8 ">
    <h2 class="text-[32px] font-medium text-primary">
        Peraturan <span class="text-secondary">Terbaru</span>
    </h2>

    <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
    <div class="h-px w-full bg-secondary"></div>
    <div class=" grid laptop:grid-cols-3 gap-8 mt-8 ">
        <?php if ($regulations): ?>
            <?php foreach ($regulations as $doc): ?>
                <div
                    class="flex flex-col items-start p-4 gap-2 bg-white border border-secondary rounded-xl min-h-[300px] shadow-md">
                    <div class="w-full">
                        <div class="flex justify-between items-center gap-2 p-0">
                            <p class="px-2 py-1 bg-[#fff8ec] text-[#D48A00] text-[12px] rounded-md">
                                <?= $doc->category ?>
                            </p>
                            <p class="px-2 py-1 text-[#969696] text-[12px]">
                                <?php
                                $numberParts = explode('/', $doc->regulationnumber);
                                echo 'No. ' . $numberParts[0];
                                ?> |
                                <span class="tanggal" data-date="<?= $doc->assignmentdate ?>" data-format="DD/MM/YYYY"></span>
                            </p>
                        </div>

                        <div class="flex flex-col p-1 mb-2">
                            <p class="text-[20px] font-medium py-2 text-[#010101] leading-snug ">
                                <?php
                                $text = $doc->category . " Nomor " . $doc->regulationnumber . " Tahun " . $doc->year . " Tentang " . $doc->title;
                                echo mb_strimwidth($text, 0, 120, '...');
                                ?>
                            </p>


                        </div>
                    </div>

                    <div class="w-full h-px bg-[#E6E3E3] mb-2 mt-auto"></div>

                    <div class="flex items-center justify-between w-full">
                        <div class="text-[12px] text-black flex items-center gap-4">
                            <p class="flex items-center gap-1"><i data-feather="eye" class="h-4 w-4 text-[#CECECE]"></i>
                                <?= $doc->viewed ?>
                                dibaca</p>
                            <p class="flex items-center gap-1"><i data-feather="download" class="h-4 w-4 text-[#CECECE]"></i>
                                <?= $doc->downloaded ?> diunduh</p>
                        </div>
                        <a href="<?= site_url('web/regulations/read/' . $doc->id) ?>"
                            class="bg-[#F1F1F1] text-black rounded-full px-3 py-1 text-[12px] flex items-center gap-1 hover:text-secondary transition">
                            Baca peraturan <i data-feather="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="text-left mt-4 flex flex-col sm:flex-row gap-2">
        <!-- Tombol ke Halaman Regulasi -->
        <a href="<?php echo site_url('web/regulations/') ?>"
            class="flex items-center justify-center gap-1 text-white text-sm px-4 py-2 rounded-md bg-secondary hover:bg-secondary/90">
            <span>Lebih banyak</span>
            <i data-feather="arrow-right"></i>
        </a>

        <!-- Tombol ke Section Kategori -->
        <a href="#kategori"
            class="flex items-center justify-center gap-1 text-secondary border border-secondary text-sm px-4 py-2 rounded-md hover:bg-secondary hover:text-white transition">
            <span>Lihat Kategori</span>
            <i data-feather="arrow-down"></i>
        </a>

    </div>


</div>


<div class="  flex flex-col p-4 laptop:p-8 bg-[linear-gradient(to_top_right,#0F1F45_50%,#80765B_100%)]">
    <div class="container mx-auto mb-8 laptop:mb-0">
        <h2 class="text-[32px] font-medium text-secondary">
            Program <span class="text-white">Unggulan</span>
        </h2>

        <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
        <div class="h-px w-full bg-secondary"></div>
        <?php
        $programs = [
            [
                'number' => 'PROGRAM 1',
                'title' => 'TRANS TUNTAS',
                'slogan' => 'Tuntas Lahan, Tuntas Harapan!',
                'content' => 'Trans Tuntas (T²), dengan slogan “Tuntas Lahan, Tuntas Harapan”, adalah program penyelesaian menyeluruh atas persoalan lahan di kawasan transmigrasi, seperti: sengketa, ketidakjelasan hak dan konflik agraria. Melalui pendataan, penyelesaian hukum, sertifikasi, dan revitalisasi serta optimalisasi lahan, program ini memberikan kepastian hak bagi transmigran dan mendorong pemanfaatan lahan yang produktif. Dengan pendekatan kolaboratif dan pemantauan berbasis teknologi, T² hadir sebagai solusi strategis dan adil untuk menciptakan kawasan transmigrasi yang tertata, legal, dan berdaya guna.'
            ],
            [
                'number' => 'PROGRAM 2',
                'title' => 'TRANSMIGRASI LOKAL',
                'slogan' => 'Dari Lokal, Maju Global',
                'content' => 'Transmigrasi lokal (Translok), dengan slogan “dari lokal, maju global”, adalah pendekatan baru dalam pembangunan yang berfokus pada penguatan ekonomi dan infrastruktur masyarakat setempat tanpa perlu berpindah jauh. Program ini bertujuan membangun kota baru dari desa, mengurangi urbanisasi, serta meningkatkan kesejahteraan masyarakat melalui pemanfaatan potensi lokal. Dengan strategi pengembangan kawasan, revitalisasi infrastruktur, pemberdayaan ekonomi, kolaborasi multi-pihak, dan integrasi program nasional, Translok diharapkan menciptakan pusat pertumbuhan baru yang mandiri dan kompetitif.'
            ],
            [
                'number' => 'PROGRAM 3',
                'title' => 'TRANSMIGRASI PATRIOT',
                'slogan' => 'Patriot Berkarya, Bangsa Berjaya',
                'content' => 'Transmigrasi Patriot, dengan slogan “Patriot Berkarya, Bangsa Berjaya”, hadir untuk menciptakan kader-kader pembangunan di kawasan transmigrasi yang memiliki semangat pengabdian, keterampilan relevan, dan kemampuan membangun komunitas yang mandiri dan maju. Program ini diluncurkan untuk mengatasi ketimpangan pembangunan antara pusat dan daerah di Indonesia, terutama di wilayah kaya sumber daya yang masih tertinggal.'
            ],
            [
                'number' => 'PROGRAM 4',
                'title' => 'TRANS KARYA NUSANTARA',
                'slogan' => 'Kawasan Berkarya, Nusantara Berdaya',
                'content' => 'Trans Karya Nusantara, dengan slogan “Kawasan Berkarya, Nusantara Berdaya”, adalah program yang berfokus pada pengembangan ekonomi berbasis potensi kawasan transmigrasi untuk menciptakan lapangan kerja berkelanjutan. Tidak hanya membangun infrastruktur, program ini mendorong tumbuhnya industri unggulan lokal seperti pertanian, perikanan, pengolahan, dan pariwisata, melalui kemitraan dengan dunia usaha, pelatihan SDM, dan pembangunan sentra ekonomi. Dengan pendekatan terintegrasi dan dukungan investasi, Trans Karya Nusa bertujuan menjadikan kawasan transmigrasi sebagai pusat pertumbuhan ekonomi baru yang kompetitif dan berdaya saing di tingkat nasional maupun global.'
            ],
            [
                'number' => 'PROGRAM 5',
                'title' => 'TRANS GOTONG ROYONG',
                'slogan' => 'Bangun Bersama, Sejahtera Semua',
                'content' => 'Trans Gotong Royong (Trans GR), dengan slogan “Bangun Bersama, Sejahtera Semua”, adalah program pembangunan kawasan transmigrasi berbasis kolaborasi antara pemerintah, masyarakat, dunia usaha, dan organisasi sosial. Program ini bertujuan mempercepat pembangunan infrastruktur dasar, mendorong kemandirian ekonomi, serta memperkuat harmoni sosial melalui prinsip gotong royong. Melalui pendekatan multi-pihak, revitalisasi kawasan, ekonomi kolaboratif, dan pemberdayaan komunitas, Trans GR membangun ekosistem yang inklusif dan berkelanjutan demi menciptakan wilayah transmigrasi yang sejahtera dan berdaya.'
            ],
            // Tambah program lain di sini
        ];
        ?>
        <div class="grid laptop:grid-cols-2 gap-8 mt-16">
            <div class="flex flex-col space-y-4 text-white text-[20px]">
                <h2 class="text-[40px] font-bold">PROGRAM 5T</h2>
                <p>transmigrasi bukan hanya soal memindahkan penduduk dari satu daerah ke daerah lain, tetapi juga
                    menciptakan peluang baru untuk hidup yang lebih baik. Untuk memastikan program ini berjalan lebih
                    efektif dan memberikan manfaat nyata bagi masyarakat, Kementerian Transmigrasi RI menghadirkan 5
                    program unggulan yang disebut Program 5T.
                </p>
                <p>Program ini dirancang untuk mempercepat penyelesaian masalah, meningkatkan kesejahteraan masyarakat
                    transmigran, serta membangun kawasan ekonomi baru yang berdaya saing tinggi.</p>
            </div>

            <?php foreach ($programs as $program): ?>
                <div class="flex flex-col text-primary text-[16px] font-light bg-white rounded-lg p-8">
                    <p class="italic"><?= $program['number'] ?></p>
                    <h2 class="text-[32px] font-bold"><?= $program['title'] ?></h2>
                    <p class="italic text-[22px]"><?= $program['slogan'] ?></p>
                    <p class="mt-4"><?= $program['content'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>



    </div>

</div>
<div x-data="{ open: false }" class=" container mx-auto flex flex-col p-4 laptop:p-8 ">
    <h2 class="text-[32px] font-medium text-primary">
        Tentang <span class="text-secondary">Pengunjung</span>
    </h2>

    <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
    <div class="h-px w-full bg-secondary"></div>
    <div class="text-center mt-8 border border-[#D9D9D9] rounded-xl p-8">
        <!-- Statistik -->
        <div class="flex flex-wrap items-start justify-between gap-4">
            <!-- Judul dan deskripsi -->
            <div class="text-start w-full laptop:w-auto">
                <h6 class="text-primary text-2xl sm:text-3xl laptop:text-[32px] font-bold">
                    Statistik Pengunjung
                </h6>
                <p class="text-[#B5B5B5] text-base sm:text-lg laptop:text-[20px]">
                    Pengunjung portal pencarian Kementerian Transmigrasi
                </p>
            </div>

            <!-- Tombol survei -->
            <div class="text-center w-full laptop:w-auto">
                <button @click="open = true"
                    class="bg-primary text-white rounded-full hover:bg-primary transition-all duration-200 px-8 py-2 sm:px-12 sm:py-3 laptop:px-24 laptop:py-4 w-full laptop:w-auto">
                    Isi Survei
                </button>
            </div>
        </div>


        <div class="grid grid-cols-2 laptop:grid-cols-3 gap-8 mt-16 laptop:mt-32 mb-16">
            <div>
                <div class="text-lg font-semibold">
                    <span id="vdaily"
                        class="font-semibold text-5xl sm:text-6xl md:text-7xl xl:text-[80px] text-secondary">0</span>
                </div>
                <h2 class="text-base sm:text-lg md:text-xl xl:text-[20px] mt-1 text-primary">
                    Pengunjung Hari ini
                </h2>
            </div>

            <div>
                <div class="text-lg font-semibold">
                    <span id="vmonthly"
                        class="font-semibold text-5xl sm:text-6xl md:text-7xl xl:text-[80px] text-primary">0</span>
                </div>
                <h2 class="text-base sm:text-lg md:text-xl xl:text-[20px] mt-1 text-primary">
                    Pengunjung Bulan ini
                </h2>
            </div>

            <div>
                <div class="text-lg font-semibold">
                    <span id="vtotal"
                        class="font-semibold text-5xl sm:text-6xl md:text-7xl xl:text-[80px] text-primary">0</span>
                </div>
                <h2 class="text-base sm:text-lg md:text-xl xl:text-[20px] mt-1 text-primary">
                    Total Klik
                </h2>
            </div>
        </div>

        <div class="text-start">
            <p class="sm:text-lg md:text-xl xl:text-[20px] text-[#B5B5B5]">Berikan penilaian kepada kami dengan mengisi
                survey berikut</p>
            <button @click="open = true"
                class="border border-primary text-white rounded-full hover:border-primary text-primary transition px-24 py-2 laptop:py-4 mt-8 w-full laptop:w-auto">
                Isi Survei
            </button>
        </div>
        <!-- Survei -->


    </div>
    <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-transition>
        <div @click.away="open = false" class="bg-white w-full max-w-md p-6 rounded shadow-lg relative" x-transition>
            <!-- Tombol Tutup -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-700 hover:text-red-600 text-xl">
                &times;
            </button>

            <h2 class="text-lg font-semibold mb-4">Survey</h2>

            <!-- Isi Survey -->
            <div class="grid grid-cols-2 gap-4 text-center">
                <div @click="submit_survey(1)"
                    class="cursor-pointer hover:scale-105 transition flex flex-col items-center justify-center">
                    <i data-feather="thumbs-up" class="w-24 h-24 text-green-500"></i>
                    <p class="mt-2">Suka</p>
                </div>

                <div @click="submit_survey(4)"
                    class="cursor-pointer hover:scale-105 transition flex flex-col items-center justify-center">
                    <i data-feather="thumbs-down" class="w-24 h-24 text-red-500"></i>
                    <p class="mt-2">Tidak Suka</p>
                </div>
            </div>

            <!-- Pesan -->
            <div class="mt-6">
                <span id="classmessage" class="block text-sm text-gray-700 font-medium"></span>
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto flex flex-col p-4 laptop:p-8">

    <h2 class="text-[32px] font-medium text-primary">
        Tautan Link <span class="text-secondary">Terkait JDIH Lainnya</span>
    </h2>

    <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
    <div class="h-px w-full bg-secondary"></div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-8">
        <?php
        if ($links) {
            foreach ($links as $le) {
                ?>
                <div class="mb-3">
                    <a href="<?php echo $le->content ?>" target="_blank"
                        class="block bg-white shadow hover:shadow-lg hover:-translate-y-1 transition-all rounded-xl px-3 py-4 text-center no-underline">
                        <img src="<?php echo site_url($le->postimage) ?>"
                            class="mx-auto max-h-[125px] object-contain rounded" />

                        <p class="text-gray-500 text-sm mb-0 mt-3">
                            <?php echo $le->title ?>
                        </p>
                    </a>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<?php $this->load->view('sidebar') ?>
<script>
    document.querySelector("form").addEventListener("submit", function () {
        // Hapus semua input dari bagian yang disembunyikan
        document.querySelectorAll(".laptop\\:hidden [name], .laptop\\:block [name]").forEach(function (input) {
            const style = window.getComputedStyle(input.closest(".laptop\\:hidden, .laptop\\:block"));
            if (style.display === "none") {
                input.disabled = true;
            }
        });
    });
</script>