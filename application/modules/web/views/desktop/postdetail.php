<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul Berita -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Berita</h1>

    <!-- Breadcrumb Berita -->
    <nav class="my-4">
        <ol class="flex flex-wrap items-center space-x-2 text-[#9D9D9D] text-sm">
            <li><a class="hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
            <li><a class="hover:underline" href="<?php echo site_url('web/posts/') ?>">Artikel</a></li>
            <?php if ($currentdoccategory) { ?>
                <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
                <li>
                    <a href="<?php echo site_url('web/posts/category/' . $currentdoccategory->slug) ?>"
                        class="text-white hover:underline">
                        <div class="relative inline-block">
                            <?php echo $currentdoccategory->category ?>
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
                <?php if ($posts) { ?>
                    <div class="row g-xl-5">
                        <div class="col-lg-8 col-md-7 col-sm-12">
                            <div class="mb-10 p-6 bg-white rounded-xl shadow-lg">
                                <h1 class="text-2xl font-bold text-gray-900 mb-4">
                                    <?= $posts->title ?>
                                </h1>

                                <div class="flex flex-wrap gap-3 mb-6 text-sm text-white justify-between">
                                    <span class="flex items-center gap-1 text-gray-800">
                                        <i data-feather="calendar"></i>
                                        <span class="tanggal" data-date="<?= $posts->createdat ?>"
                                            data-format="DD/MM/YYYY"></span>
                                    </span>
                                    <span class="flex items-center gap-1 text-gray-800">
                                        <i data-feather="user"></i>
                                        <?= $posts->fullname ?: $posts->username ?>
                                    </span>
                                </div>

                                <?php if ($posts->postimage): ?>
                                    <figure class="overflow-hidden rounded-xl shadow mb-6">
                                        <img class="w-full object-cover min-h-[400px] mx-auto transition-transform hover:scale-105 duration-300"
                                            src="<?= site_url($posts->postimage) ?>" alt="<?= $posts->title ?>">
                                    </figure>
                                <?php endif; ?>

                                <div id="postbody" class="prose prose-indigo max-w-full text-justify">
                                    <?= ckeditor_to_tailwind($posts->content) ?>
                                </div>
                            </div>

                            <hr class="my-6" />
                            <div class="flex flex-wrap items-center justify-between gap-3 mt-6">
                                <div x-data="{ shareOpen: false }" class="relative inline-block text-left w-full md:w-auto">
                                    <button @click="shareOpen = true"
                                        class="flex items-center justify-center w-full md:w-auto px-3 py-2 laptop:py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                                        <i data-feather="share-2" class="mr-1 h-4 w-4"></i>
                                        <span class="font-semibold mr-1"></span> Share
                                    </button>

                                    <!-- Modal Share -->
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

                                            <!-- Judul Modal -->
                                            <h2 class="text-lg font-semibold mb-4">Bagikan ke</h2>

                                            <!-- Isi Share -->
                                            <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
                                                <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                                    target="_blank"
                                                    href="https://twitter.com/intent/tweet?text=Baca <?php echo $pages->title . ' - ' . $this->config->item('site_name') ?>&url=<?php echo site_url('pages/read/' . $pages->id) ?>">
                                                    <i data-feather="twitter" class="inline mr-2"></i> Twitter
                                                </a>
                                                <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                                    target="_blank"
                                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url('pages/read/' . $pages->id) ?>">
                                                    <i data-feather="facebook" class="inline mr-2"></i> Facebook
                                                </a>
                                                <a class="block px-4 py-2 rounded bg-gray-100 hover:bg-gray-200"
                                                    target="_blank"
                                                    href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo site_url('pages/read/' . $pages->id) ?>&title=Baca <?php echo $pages->title . ' - ' . $this->config->item('site_name') ?>">
                                                    <i data-feather="linkedin" class="inline mr-2"></i> LinkedIn
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex items-center gap-2 w-full laptop:w-auto">
                                    <button id='btnlike' onclick="postlike(<?php echo $posts->id ?>, 'post')"
                                        class="text-sm px-3 py-2 bg-yellow-100 text-yellow-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                                        <i data-feather="thumbs-up" class="mr-1 h-4 w-4"></i>
                                        <span id="countliked" class="font-semibold mr-1"><?php echo $posts->liked ?></span>
                                        Suka
                                    </button>
                                    <span
                                        class="text-sm px-3 py-2 bg-green-100 text-green-800 rounded flex items-center justify-center gap-1 w-full laptop:w-auto">
                                        <i data-feather="eye" class="mr-1 h-4 w-4"></i>
                                        <span class="font-semibold mr-1"><?php echo $posts->viewed ?></span> Dilihat
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="col-span-12">
                        <div class="px-4 py-3">
                            <div class="bg-red-100 text-red-800 text-sm font-semibold p-3 rounded">
                                Tidak dapat menemukan artikel
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="laptop:w-3/12 w-full mt-8 laptop:mt-0">
                <?php if ($postsexts) { ?>
                    <div class="flex flex-col gap-4">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-2">Berita Terkait</h2>
                        <?php foreach ($postsexts as $post) { ?>
                            <div class="flex flex-row bg-white rounded-xl shadow-md overflow-hidden min-h-[140px] border">
                                <!-- Thumbnail -->
                                <div class="w-[80px] h-[80px] flex-shrink-0 mt-4 ml-4">
                                    <img class="w-full h-full object-cover rounded-lg"
                                        src="<?php echo $post->postimage ? ($post->postimagethumb ? site_url($post->postimagethumb) : site_url($post->postimage)) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>" />
                                </div>

                                <!-- Content -->
                                <div class="p-4 flex flex-col justify-between flex-grow">
                                    <div>
                                        <a href="<?php echo site_url('web/posts/read/' . $post->id) ?>"
                                            class="font-bold text-[#02246D] hover:underline transition block mb-2 leading-tight text-[16px]">
                                            <?php echo mb_strimwidth($post->title, 0, 40, '...'); ?>
                                        </a>
                                        <p class="text-[#616364] text-[13px] tanggal" data-date="<?= $post->createdat ?>"
                                            data-format="DD/MM/YYYY"></p>
                                    </div>

                                    <!-- Tombol -->
                                    <div class="mt-4 flex items-center justify-end">
                                        <a href="<?php echo site_url('web/posts/read/' . $post->id) ?>"
                                            class="inline-flex items-center gap-1 text-sm text-white bg-primary border border-[#00A54E] pl-4 pr-1 py-1 rounded-md hover:text-secondary">
                                            Baca <i data-feather="chevron-right" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>

    </div>


</div>
<?php $this->load->view('sidebar') ?>