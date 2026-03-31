<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Non Peraturan</h1>

    <!-- Breadcrumb -->
    <nav class="my-4">
        <ol class="flex flex-wrap items-center space-x-2 text-[#9D9D9D] text-sm">
            <li><a href="<?php echo site_url() ?>" class="hover:underline">Beranda</a></li>
            <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
            <li><a href="<?php echo site_url('web/nonregulations/') ?>" class="hover:underline">Non Peraturan</a></li>
            <?php if ($currentgroups) { ?>
                <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
                <li>
                    <a href="<?php echo site_url('web/nonregulations/category/' . $currentgroups) ?>"
                        class="text-white hover:underline">
                        <div class="relative inline-block">
                            <?php echo $groups[$currentgroups] ?>
                            <span class="absolute -bottom-[15.5px] left-0 w-full h-[8px] bg-white rounded-t-full"></span>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ol>
    </nav>
</div>

<div class="container mx-auto p-4 laptop:p-8">
    <div class="flex flex-col gap-6 mx-auto">
        <div class="laptop:flex laptop:gap-6">
            <div class="laptop:w-9/12 w-full">
                <?php if ($nonregulations) { ?>
                    <div class="row g-xl-5">
                        <div class="col-lg-8 col-md-7 col-sm-12">
                            <h1 class="text-xl font-bold mb-4"><?php echo $nonregulations->title ?></h1>

                            <div class="bg-white shadow rounded-md p-4">
                                <table class="w-full text-sm text-left border-collapse">
                                    <tbody class="divide-y">
                                        <tr>
                                            <td class="py-2 font-semibold w-1/3">Judul</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->title ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Nomor Peraturan</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->regulationnumber ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tahun</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->year ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tajuk Entri Utama</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->teu ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Subjek Dokumen</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->subject ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tempat Penetapan</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->assignmentplace ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tanggal Penetapan</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2 tanggal" data-date="<?= $nonregulations->assignmentdate ?>"
                                                data-format="DD/MM/YYYY">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tanggal Pengundangan</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2 tanggal" data-date="<?= $nonregulations->approvaldate ?>"
                                                data-format="DD/MM/YYYY">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Tanggal Berlaku Efektif</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2 tanggal" data-date="<?= $nonregulations->effectivedate ?>"
                                                data-format="DD/MM/YYYY">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Sumber</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->rsource ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Bahasa</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->language ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Bidang hukum</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->legalfield ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Lokasi</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->location ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Kluster</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->cluster ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Status</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->status ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Keterangan Status</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2"><?php echo $nonregulations->detailstatus ?: '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-semibold">Sampul Buku</td>
                                            <td class="py-2">:</td>
                                            <td class="py-2">
                                                <?php $cb = json_decode($nonregulations->bookcover);
                                                echo '<img src="' . site_url($cb->fullpath) . '" class="w-72 rounded shadow border" />'; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php
                                $att = json_decode($nonregulations->attachment);
                                $group = $nonregulations->groups;
                                $id = $nonregulations->id;
                                ?>

                                <?php if (!empty($att) && !empty($att->fullpath)): ?>
                                    <a href="<?php echo site_url($att->fullpath) ?>" target="_blank"
                                        onclick='docdownloaded("<?php echo $group ?>", <?php echo $id ?>)'
                                        class="inline-flex items-center px-3 py-1 mt-4 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                                        <i data-feather="download" class="mr-1 h-4 w-4"></i>
                                        <span class="font-semibold mr-1"></span>
                                        Download Dokumen
                                    </a>
                                <?php endif; ?>


                            </div>

                            <div class="bg-white shadow rounded-lg p-4 mt-6 hidden laptop:block">
                                <embed src="<?php echo site_url($att->fullpath) ?>" type="application/pdf" width="100%"
                                    height="600px" />
                            </div>

                            <hr class="my-6" />

                            <div class="flex flex-wrap items-center justify-between gap-3 mt-6">
                                <div x-data="{ shareOpen: false }" class="relative inline-block text-left w-full md:w-auto">
                                    <!-- Tombol Share -->
                                    <button @click="shareOpen = true"
                                        class="flex items-center justify-center w-full md:w-auto px-3 py-2 laptop:py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                                        <i data-feather="share-2" class="mr-1 h-4 w-4"></i>
                                        <span class="font-semibold mr-1"></span>
                                        Share
                                    </button>

                                    <!-- Modal -->
                                    <div x-show="shareOpen" x-cloak
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                        x-transition>
                                        <div @click.away="shareOpen = false"
                                            class="bg-white w-full max-w-sm p-6 rounded shadow-lg relative" x-transition>

                                            <!-- Tombol Tutup -->
                                            <button @click="shareOpen = false"
                                                class="absolute top-2 right-2 text-gray-700 hover:text-red-600 text-xl">
                                                &times;
                                            </button>

                                            <h2 class="text-lg font-semibold mb-4">Bagikan ke</h2>

                                            <div class="space-y-2 text-sm text-gray-700">
                                                <a href="https://facebook.com/sharer/sharer.php?u=<?php echo current_url() ?>"
                                                    target="_blank"
                                                    class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                                    <i data-feather="facebook" class="inline mr-2"></i>Facebook
                                                </a>
                                                <a href="https://twitter.com/intent/tweet?url=<?php echo current_url() ?>"
                                                    target="_blank"
                                                    class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                                    <i data-feather="twitter" class="inline mr-2"></i>Twitter
                                                </a>
                                                <a href="https://api.whatsapp.com/send?text=<?php echo current_url() ?>"
                                                    target="_blank"
                                                    class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                                                    <i data-feather="phone" class="inline mr-2"></i>WhatsApp
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex items-center gap-2 w-full laptop:w-auto">
                                    <button id="btnlike"
                                        onclick='doclike("<?php echo $nonregulations->groups ?>",<?php echo $nonregulations->id ?>)'
                                        class="text-sm px-3 py-2 bg-yellow-100 text-yellow-800 rounded inline-flex items-center gap-1 w-full laptop:w-auto">
                                        <i data-feather="thumbs-up" class="mr-1 h-4 w-4"></i>
                                        <span id="countliked"><?php echo $nonregulations->liked ?></span> Suka
                                    </button>
                                    <span
                                        class="text-sm px-3 py-2 bg-green-100 text-green-800 rounded flex items-center gap-1 w-full laptop:w-auto">

                                        <i data-feather="eye" class="mr-1 h-4 w-4"></i>
                                        <span class="font-semibold mr-1"><?php echo $nonregulations->viewed ?></span>
                                        Dilihat
                                    </span>
                                    <span
                                        class="text-sm px-3 py-2 bg-orange-100 text-orange-800 rounded flex items-center gap-1 w-full laptop:w-auto">
                                        <i data-feather="download-cloud" class="mr-1 h-4 w-4"></i>
                                        <span id="countdownloaded"
                                            class="font-semibold mr-1"><?php echo $nonregulations->downloaded ?></span>
                                        Diunduh
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
                        Tidak dapat menemukan dokumen
                    </div>
                <?php } ?>
            </div>
            <div class="laptop:w-3/12 w-full mt-8 laptop:mt-0">
                <?php if ($nonregulationsexts) { ?>
                    <div class="flex flex-col gap-4">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-2">Non Peraturan Terkait</h2>
                        <?php foreach ($nonregulationsexts as $nondoc) { ?>
                            <div
                                class="flex flex-col items-start p-4 gap-2 bg-white border border-[#e5af4c] rounded-xl min-h-[120px] shadow-md">
                                <div class="w-full">
                                    <div class="flex justify-between items-t gap-2 p-0">
                                        <?php
                                        $text = $nondoc->location ?? '';
                                        if (empty($text)) {
                                            echo '<p></p>';
                                        } else {
                                            $short = strlen($text) > 30 ? substr($text, 0, 25) . '...' : $text;
                                            echo '<p class="px-2 py-1 bg-[#fff8ec] text-[#D48A00] text-[12px] rounded-md">' . $short . '</p>';
                                        }
                                        ?>

                                        <p class="px-2 py-1 text-[#969696] text-[12px] text-nowrap">
                                            <?php echo $nondoc->assignmentplace ?> | <?php echo $nondoc->year ?: '-' ?>


                                        </p>
                                    </div>

                                    <div class="flex flex-col p-1 mb-2">
                                        <p class="text-[20px] font-medium py-2 text-[#010101] leading-snug ">
                                            <?php echo $nondoc->title ?>
                                        </p>

                                        <p class="text-[12px] text-[#969696]"><?= $doc->doctype ?></p>
                                    </div>
                                </div>

                                <div class="w-full h-px bg-[#E6E3E3] mb-2 mt-auto"></div>

                                <div class="flex items-center justify-between w-full">
                                    <div class="text-[12px] text-black flex gap-4">
                                        <p class="flex items-center gap-1"><i data-feather="eye"
                                                class="h-4 w-4 text-[#CECECE]"></i>
                                            <?= $nondoc->viewed ?>
                                            dibaca</p>
                                        <p class="flex items-center gap-1"><i data-feather="download"
                                                class="h-4 w-4 text-[#CECECE]"></i>
                                            <?= $nondoc->downloaded ?> diunduh</p>

                                    </div>
                                    <a href="<?php echo site_url('web/nonregulations/read/' . $nondoc->groups . '/' . $nondoc->id) ?>"
                                        class="bg-[#F1F1F1] text-black rounded-full px-3 py-1 text-[12px] flex items-center gap-1 hover:text-secondary transition">
                                        Baca <i data-feather="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Sidebar -->

    </div>
</div>
<?php $this->load->view('sidebar') ?>