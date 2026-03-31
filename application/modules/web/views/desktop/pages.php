<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul Halaman -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Halaman</h1>

    <!-- Breadcrumb Halaman -->
    <nav class="my-4">
        <ol class="flex flex-wrap items-center space-x-2 text-[#9D9D9D] text-sm">
            <li><a class="hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
            <li class="text-white">Halaman</li>
        </ol>
    </nav>
</div>

<div class="container mx-auto p-4 laptop:p-8">
    <!-- Header -->


    <div class="flex flex-col items-center justify-center">
        <!-- Konten Utama -->
        <?php if ($pages) { ?>
            <div class="space-y-6">
                <!-- Judul -->
                <h1 class="text-xl font-bold">
                    <?php echo $pages->title ?>
                </h1>

                <!-- Gambar -->
                <?php if ($pages->postimage) { ?>
                    <figure class="text-center mb-5">
                        <img class="rounded-lg mx-auto"
                            src="<?php echo $pages->postimage ? site_url($pages->postimage) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>"
                            alt="<?php echo $pages->title ?>">
                    </figure>
                <?php } ?>

                <!-- Konten -->
                <div id="postbody" class="prose max-w-none text-justify text-gray-800">
                    <?= ckeditor_to_tailwind($pages->content) ?>


                </div>

                <hr class="border-t border-gray-300" />

                <!-- Footer Post -->
                <div class="flex flex-wrap items-center justify-between gap-3 mt-6">
                    <!-- Share Modal Trigger -->
                    <div x-data="{ shareOpen: false }" class="relative w-full md:w-auto">
                        <button @click="shareOpen = true"
                            class="flex items-center justify-center w-full md:w-auto px-3 py-2 laptop:py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                            <i data-feather="share-2" class="mr-1 h-4 w-4"></i>
                            <span class="font-semibold mr-1"></span> Share
                        </button>

                        <!-- Modal Share -->
                        <div x-show="shareOpen" x-cloak
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
                            <div @click.away="shareOpen = false"
                                class="bg-white w-full max-w-sm p-6 rounded shadow-lg relative" x-transition>
                                <!-- Tombol Tutup -->
                                <button @click="shareOpen = false"
                                    class="absolute top-2 right-2 text-gray-700 hover:text-red-600 text-xl">
                                    &times;
                                </button>


                                <!-- Judul Modal -->
                                <h2 class="text-lg font-semibold mb-4">Bagikan ke</h2>

                                <!-- Isi Share -->
                                <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
                                    <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                        href="https://twitter.com/intent/tweet?text=Baca <?php echo $pages->title . ' - ' . $this->config->item('site_name') ?>&url=<?php echo site_url('pages/read/' . $pages->slug) ?>"
                                        target="_blank">
                                        <i data-feather="twitter" class="inline mr-2"></i> Twitter
                                    </a>
                                    <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url('pages/read/' . $pages->slug) ?>"
                                        target="_blank">
                                        <i data-feather="facebook" class="inline mr-2"></i> Facebook
                                    </a>
                                    <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                        href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo site_url('pages/read/' . $pages->slug) ?>&title=Baca <?php echo $pages->title . ' - ' . $this->config->item('site_name') ?>"
                                        target="_blank">
                                        <i data-feather="linkedin" class="inline mr-2"></i> LinkedIn
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Like & View -->
                    <div class="flex items-center gap-2 w-full laptop:w-auto">
                        <button id="btnlike" onclick="postlike(<?php echo $pages->id ?>, 'page')"
                            class="text-sm px-3 py-2 bg-yellow-100 text-yellow-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                            <i data-feather="thumbs-up" class="w-4 h-4 mr-1"></i>
                            <span id="countliked" class="font-semibold mr-1"><?php echo $pages->liked ?></span> Suka
                        </button>
                        <div
                            class="text-sm px-3 py-2 bg-green-100 text-green-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                            <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                            <span class="font-semibold mr-1"><?php echo $pages->viewed ?></span> Dilihat
                        </div>
                    </div>
                </div>

            </div>
        <?php } else { ?>
            <!-- Halaman tidak ditemukan -->
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded">
                Tidak dapat menemukan halaman
            </div>
        <?php } ?>

        <!-- Sidebar -->

    </div>
</div>
<?php $this->load->view('sidebar') ?>