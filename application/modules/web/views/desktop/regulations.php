<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
      background-repeat: no-repeat; 
      background-position: center;'>
    <h1 class="text-[32px] desktop:text-[48px] font-bold">
        <?php echo ($is_rancangan ?? false) ? 'Rancangan Peraturan' : 'Peraturan'; ?>
    </h1>
    <nav class="my-4">
        <ol class="flex flex-wrap desktop:flex-row items-center space-x-2">
            <li><a class="text-[#9D9D9D] hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li class="text-sm desktop:text-3xl text-[#9D9D9D]"><i data-feather="chevron-right"></i></li>

            <li>
                <a class="text-[#9D9D9D] hover:underline"
                    href="<?php echo ($is_rancangan ?? false) ? site_url('web/regulations/category/rancangan-peraturan') : site_url('web/regulations/'); ?>">
                    <?php echo ($is_rancangan ?? false) ? 'Rancangan Peraturan' : 'Peraturan'; ?>
                </a>
            </li>

            <?php if ($currentdoccategory) { ?>
                <?php if (!($is_rancangan ?? false)): ?>
                    <li class="text-sm desktop:text-3xl text-[#9D9D9D]"><i data-feather="chevron-right"></i></li>
                    <li>
                        <a href="<?php echo site_url('web/regulations/category/' . $currentdoccategory->slug) ?>"
                            class="text-white hover:underline">
                            <div class="relative inline-block gap-2">
                                <?php echo $currentdoccategory->acronym ?>
                                <span class="absolute -bottom-[15.5px] left-0 w-full h-[8px] bg-white rounded-t-full"></span>
                            </div>
                        </a>
                    </li>
                <?php endif; ?>
            <?php } ?>
        </ol>
    </nav>
</div>
<div class="container mx-auto p-4 laptop:p-8">
    <div class="flex flex-col gap-6 mx-auto">
        <div class="laptop:flex laptop:gap-6">
            <div class="laptop:w-9/12 w-full">
                <?php if ($regulations) { ?>

                    <h1 class="text-2xl font-semibold mb-4 flex items-center gap-2">
                        <?php echo $fulltitle ?>
                        <?php if ($is_rancangan ?? false): ?>
                            <span
                                class="text-sm font-bold px-2 py-1 bg-red-100 text-red-700 rounded-full border border-red-300 shadow-sm">
                                RANCANGAN
                            </span>
                        <?php endif; ?>
                    </h1>
                    <div class="bg-white shadow rounded-lg p-6">
                        <table class="w-full text-sm text-left border-collapse">
                            <tbody class="divide-y">
                                <tr>
                                    <td class="py-2 font-medium w-1/3">Judul</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $fulltitle ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Jenis Dokumen</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->documenttype ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Nomor Peraturan</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->regulationnumber ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tahun</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->year ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tajuk Entri Utama</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->teu ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Subjek Dokumen</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->subject ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tempat Penetapan</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->assignmentplace ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tanggal Penetapan</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2 tanggal" data-date="<?= $regulations->assignmentdate ?>"
                                        data-format="DD/MM/YYYY">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tanggal Pengundangan</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2 tanggal" data-date="<?= $regulations->approvaldate ?>"
                                        data-format="DD/MM/YYYY">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Tanggal Berlaku Efektif</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2 tanggal" data-date="<?= $regulations->effectivedate ?>"
                                        data-format="DD/MM/YYYY">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Sumber</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->source ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Bahasa</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->language ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Bidang Hukum</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->legalfield ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Lokasi</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->location ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Kluster</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->cluster ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Status</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2"><?php echo $regulations->status ?></td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Keterangan Status</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <?php
                                        $detail_status_content = $regulations->detailstatus ?? '';

                                        if ($detail_status_content) {
                                            $cleaned_content = preg_replace('/(xss|style)="[^"]*"/', '', $detail_status_content);
                                            $cleaned_content = preg_replace('/<span[^>]*>\s*<\/span>/i', '', $cleaned_content);
                                            $cleaned_content = str_replace(array('<p>&nbsp;</p>', '<p> </p>', "[removed]"), '', $cleaned_content);

                                            echo '<div class="rich-text-output">' . $cleaned_content . '</div>';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Abstrak</td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <?php
                                        $abstract_content = $regulations->abstract ?? '';

                                        if ($abstract_content) {
                                            $cleaned_content = preg_replace('/(xss|style)="[^"]*"/', '', $abstract_content);
                                            $cleaned_content = preg_replace('/<span[^>]*>\s*<\/span>/i', '', $cleaned_content);
                                            $cleaned_content = str_replace(array('<p>&nbsp;</p>', '<p> </p>', "[removed]"), '', $cleaned_content);

                                            echo '<div class="rich-text-output">' . $cleaned_content . '</div>';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <?php
                        $abs = json_decode($regulations->abstractfile);
                        $att = json_decode($regulations->attachment);

                        $hasAbs = !empty($abs) && !empty($abs->fullpath);
                        $hasAtt = !empty($att) && !empty($att->fullpath);
                        ?>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <div class="hidden md:flex flex-wrap gap-2">
                                <?php if ($hasAbs): ?>
                                    <a href="<?= site_url($abs->fullpath) ?>" target="_blank"
                                        onclick="mulai_survey()"
                                        class="text-sm bg-blue-100 text-blue-800 px-3 py-2 rounded inline-flex items-center">
                                        <i data-feather="file-text" class="mr-1 h-4 w-4"></i>
                                        Download Abstrak
                                    </a>
                                <?php endif; ?>

                                <?php if ($hasAtt): ?>
                                    <a href="<?= site_url($att->fullpath) ?>" target="_blank"
                                        onclick="docdownloaded(<?= $regulations->id ?>); mulai_survey()"
                                        class="text-sm bg-cyan-100 text-cyan-800 px-3 py-2 rounded inline-flex items-center">
                                        <i data-feather="download" class="mr-1 h-4 w-4"></i>
                                        Download Dokumen
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="md:hidden flex flex-col gap-2 w-full">
                                <?php if ($hasAbs): ?>
                                    <a href="<?= site_url($abs->fullpath) ?>" target="_blank"
                                        onclick="mulai_survey()"
                                        class="text-sm border border-gray-300 bg-blue-50 text-blue-800 px-3 py-2.5 rounded-lg flex items-center justify-center w-full hover:bg-blue-100 transition">
                                        <i data-feather="eye" class="mr-2 h-4 w-4"></i>
                                        View Abstrak
                                    </a>
                                <?php endif; ?>

                                <?php if ($hasAtt): ?>
                                    <a href="<?= site_url($att->fullpath) ?>" target="_blank"
                                        onclick="docdownloaded(<?= $regulations->id ?>); mulai_survey()"
                                        class="text-sm border border-gray-300 bg-cyan-50 text-cyan-800 px-3 py-2.5 rounded-lg flex items-center justify-center w-full hover:bg-cyan-100 transition">
                                        <i data-feather="eye" class="mr-2 h-4 w-4"></i>
                                        View Dokumen
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>


                    </div>

                    <div class="bg-white shadow rounded-lg p-4 mt-6 hidden laptop:block">
                        <embed src="<?php echo site_url($att->fullpath) ?>" type="application/pdf" width="100%"
                            height="600px" />
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 mt-6">
                        <div x-data="{ shareOpen: false }" class="relative inline-block text-left w-full md:w-auto">
                            <button @click="shareOpen = true"
                                class="flex items-center justify-center w-full md:w-auto px-3 py-2 laptop:py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                                <i data-feather="share-2" class="mr-1 h-4 w-4"></i>
                                <span class="font-semibold mr-1"></span> Share
                            </button>

                            <div x-show="shareOpen" x-cloak
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                x-transition>
                                <div @click.away="shareOpen = false"
                                    class="bg-white w-full max-w-sm p-6 rounded shadow-lg relative" x-transition>
                                    <button @click="shareOpen = false"
                                        class="absolute top-2 right-2 text-gray-700 hover:text-red-600 text-xl">
                                        &times;
                                    </button>

                                    <h2 class="text-lg font-semibold mb-4">Bagikan ke</h2>

                                    <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
                                        <a href="https://facebook.com/sharer/sharer.php?u=<?php echo current_url() ?>"
                                            target="_blank" class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                            <i data-feather="facebook" class="inline mr-2"></i>Facebook
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo current_url() ?>"
                                            target="_blank" class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                            <i data-feather="twitter" class="inline mr-2"></i>Twitter
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text=<?php echo current_url() ?>"
                                            target="_blank" class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                            <i data-feather="phone" class="inline mr-2"></i>WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full laptop:w-auto">
                            <button id="btnlike" onclick="doclike(<?php echo $regulations->id ?>)"
                                class="text-sm px-3 py-2 bg-yellow-100 text-yellow-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                                <i data-feather="thumbs-up" class="mr-1 h-4 w-4"></i>
                                <span id="countliked" class="font-semibold mr-1"><?php echo $regulations->liked ?></span>
                                Suka
                            </button>

                            <span
                                class="text-sm px-3 py-2 bg-green-100 text-green-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                                <i data-feather="eye" class="mr-1 h-4 w-4"></i>
                                <span class="font-semibold mr-1"><?php echo $regulations->viewed ?></span> Dilihat
                            </span>

                            <span
                                class="text-sm px-3 py-2 bg-orange-100 text-orange-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                                <i data-feather="download-cloud" class="mr-1 h-4 w-4"></i>
                                <span id="countdownloaded"
                                    class="font-semibold mr-1"><?php echo $regulations->downloaded ?></span> Diunduh
                            </span>
                        </div>
                    </div>


                <?php } else { ?>
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
                        Tidak dapat menemukan dokumen
                    </div>
                <?php } ?>
            </div>

            <div class="laptop:w-3/12 w-full mt-8 laptop:mt-0">
                <?php if ($regulationsexts) { ?>
                    <div class="flex flex-col gap-4">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-2">Peraturan Terkait</h2>
                        <?php foreach ($regulationsexts as $doc) { ?>
                            <div
                                class="flex flex-col items-start p-4 gap-2 bg-white border border-[#e5af4c] rounded-xl min-h-[150px] shadow-md w-full">
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
                                            <span class="tanggal" data-date="<?= $doc->assignmentdate ?>"
                                                data-format="DD/MM/YYYY"></span>
                                        </p>
                                    </div>

                                    <div class="flex flex-col p-1 mb-2">
                                        <p class="text-[20px] font-medium py-2 text-[#010101] leading-snug ">
                                            <?php
                                            $text = $doc->category . " Nomor " . $doc->regulationnumber . " Tahun " . $doc->year . " Tentang " . $doc->title;
                                            echo mb_strimwidth($text, 0, 120, '...');
                                            ?>
                                        </p>

                                        <p class="text-[12px] text-[#969696]"><?= $doc->doctype ?></p>
                                    </div>
                                </div>

                                <div class="w-full h-px bg-[#E6E3E3] mb-2 mt-auto"></div>

                                <div class="flex items-center justify-between w-full">
                                    <div class="text-[12px] text-black flex gap-4">
                                        <p class="flex items-center gap-1"><i data-feather="eye"
                                                class="h-4 w-4 text-[#CECECE]"></i>
                                            <?= $doc->viewed ?>
                                            dibaca</p>
                                        <p class="flex items-center gap-1"><i data-feather="download"
                                                class="h-4 w-4 text-[#CECECE]"></i>
                                            <?= $doc->downloaded ?> diunduh</p>

                                    </div>
                                    <a href="<?= site_url('web/regulations/read/' . $doc->id) ?>"
                                        class="bg-[#F1F1F1] text-black rounded-full px-3 py-1 text-[12px] flex items-center gap-1 hover:text-secondary transition">
                                        Baca <?php echo ($is_rancangan ?? false) ? 'rancangan' : 'peraturan' ?> <i
                                            data-feather="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<style>
    .modal_survey_box {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
    }
    .modal-content_survey_box {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        width: 90%;
        max-width: 800px;
        height: 80vh;
        border-radius: 15px;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .close-survey {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 32px;
        cursor: pointer;
        color: #999;
        font-weight: bold;
    }
    .close-survey:hover { color: #333; }
</style>

<div id="statusModalSurvey" class="modal_survey_box">
    <div class="modal-content_survey_box">
        <span class="close-survey">&times;</span>
        <h3 style="margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 1.5rem; color: #1e3a8a;">Survei Kepuasan Layanan JDIH</h3>
        <iframe src="https://surveidigital.spbe.go.id/embed/survey/eyJzdXJ2ZXlfaWQiOjIsInNlcnZpY2VfaWQiOjc4LCJob3N0IjoiaHR0cHM6Ly9qZGloLnRyYW5zbWlncmFzaS5nby5pZC8saHR0cDovL2xvY2FsaG9zdDo4MDAwLyIsImtleSI6InBCVzRpelNzIn0=/embed/view/" style="width: 100%; height: 85%; border: none; border-radius: 10px;"></iframe>
    </div>
</div>

<script>
    function mulai_survey() {
        // Tampilkan modal setelah delay kecil agar proses download browser berjalan lancar
        setTimeout(function() {
            document.getElementById('statusModalSurvey').style.display = "block";
        }, 800);
    }

    const modalS = document.getElementById('statusModalSurvey');
    const closeS = document.querySelector('.close-survey');

    closeS.onclick = function() {
        modalS.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modalS) {
            modalS.style.display = "none";
        }
    }
</script>

<?php $this->load->view('sidebar') ?>