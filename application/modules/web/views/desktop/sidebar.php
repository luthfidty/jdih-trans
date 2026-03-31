<div id="kategori" class=" container mx-auto flex flex-col p-4 laptop:p-8 ">
    <h2 class="text-[32px] font-medium text-primary">
        Kategori <span class="text-secondary">Dokumen</span>
    </h2>

    <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
    <div class="h-px w-full bg-secondary"></div>
    <div class=" grid grid-cols-1  laptop:grid-cols-3 gap-4 mt-8 ">

        <?php if ($documentcategory): ?>
            <?php foreach ($documentcategory as $dc): ?>
                <div class="flex flex-col items-start p-4 bg-white shadow-md border border-[#D9D9D9] p-2 rounded ">
                    <div class="flex items-center gap-2 mb-4">
                        <?php
                        $icon_map = [
                            "Instruksi Menteri" => "icon_1.svg",
                            "Memorandum of Understanding" => "icon_4.svg",
                            "Keputusan Menteri" => "icon_2.svg",
                            "Keputusan Presiden" => "icon_3.svg",
                        ];

                        // Ambil nama icon sesuai acronym, atau default jika tidak ditemukan
                        $icon_filename = isset($icon_map[$dc->acronym]) ? $icon_map[$dc->acronym] : "icon_0.svg";
                        ?>

                        <img src="<?php echo site_url('assets/web/' . $device . '/images/icons/' . $icon_filename); ?>" />


                        <div>
                            <p class="text-base font-bold ">
                                <?= $dc->acronym ?>

                            </p>
                            <div class="  text-xs rounded-full flex items-center gap-1 text-[#878787] text-light">
                                <i data-feather="download" class="h-4 w-4"></i>
                                <p><?= $dc->total_downloaded ?> kali diunduh</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-px bg-[#E6E3E3] mb-2 mt-auto"></div>

                    <div class="flex items-center justify-between w-full">
                        <div class="text-[12px] text-black  gap-2 flex items-center">
                            <i data-feather="file-text" class="h-4 w-4"></i>
                            <p><?= $dc->countdc ?> dokumen</p>
                        </div>
                        <a href="<?= site_url('web/regulations/category/' . $dc->acslug) ?>"
                            class="bg-[#F1F1F1] text-black rounded-full px-3 py-1 text-[12px] flex items-center gap-1 hover:text-secondary transition">
                            Lihat semua <i data-feather="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</div>
<div class="  flex flex-col p-4 laptop:p-8 bg-primary">
    <div class="container mx-auto mb-8 laptop:mb-0">
        <h2 class="text-[32px] font-medium text-secondary">
            Berita <span class="text-white">Terkini</span>
        </h2>

        <div class="h-[6px] w-[200px] bg-secondary rounded-t-3xl"></div>
        <div class="h-px w-full bg-secondary"></div>
        <div class="flex flex-wrap justify-between mt-8 gap-4 md:gap-0">
            <div class="flex flex-col w-full laptop:w-4/12 text-white">
                <h1 class="text-[32px] font-bold">Berita Terkini seputar Kementerian Transmigrasi</h1>
                <p class="text-[16px]">Pojok unit kerja, update seputar kegiatan pembangunan dan pelaksanaan tugas
                    Kementerian Transmigrasi Republik Indonesia </p>
                <a href="<?php echo site_url('web/posts/category/berita') ?>"
                    class="border border-white text-white rounded-md px-8 text-center py-3 mt-4 text-[14px] flex items-center justify-center gap-1 hover:text-secondary text-nowrap ">
                    Lihat berita lainnya <i data-feather="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
            <div class=" grid grid-cols-1  laptop:grid-cols-2 gap-4  w-full laptop:w-7/12 ">
                <?php
                if ($pojokuke) {
                    foreach ($pojokuke as $post) {
                        ?>
                        <div class="flex flex-col items-start  gap-2 bg-white  rounded-xl min-h-[160px] shadow-md">
                            <img class="text-center bg-light  bg-cover lazy h-[300px] w-full rounded-t-xl"
                                src="<?php echo $post->postimage ? ($post->postimagethumb ? site_url($post->postimagethumb) : site_url($post->postimage)) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>" />
                            <div class="p-4">
                                <div class="h-[120px]">
                                    <a href="<?php echo site_url('web/posts/read/' . $post->id) ?>"
                                        class=" font-bold text-[#02246D] hover:underline  transition">

                                        <?php
                                        echo mb_strimwidth($post->title, 0, 180, '...');
                                        ?>
                                    </a>
                                </div>

                                <p class="text-[#616364] text-[14px] tanggal" data-date="<?= $post->createdat ?>" data-format="DD/MM/YYYY">

                                </p>
                                <a href="<?php echo site_url('web/posts/read/' . $post->id) ?>"
                                    class="bg-primary border border-[#00A54E] text-white rounded-md px-8 text-center py-3 mt-4 text-[14px] flex items-center justify-center gap-1 hover:text-secondary text-nowrap ">
                                    Baca selengkapnya <i data-feather="chevron-right" class="w-4 h-4"></i>
                                </a>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

    </div>
</div>