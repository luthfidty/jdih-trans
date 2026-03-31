<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul Berita -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Berita</h1>

    <!-- Breadcrumb Berita -->
    <nav class="my-4">
        <ol class="flex flex-wrap desktop:flex-row items-center space-x-2 text-[#9D9D9D]">
            <li><a class="hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li class="text-sm desktop:text-3xl"><i data-feather="chevron-right"></i></li>
            <li><a class="hover:underline" href="<?php echo site_url('web/posts/') ?>">Artikel</a></li>
            <?php if ($currentdoccategory) { ?>
                <li class="text-sm desktop:text-3xl"><i data-feather="chevron-right"></i></li>
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
    <?php if ($posts) { ?>
        <div class="flex flex-col justify-center items-center">
            <div class="grid laptop:grid-cols-3 gap-4 laptop:gap-8 w-full ">
                <?php foreach ($posts as $post) { ?>
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

                            <p class="text-[#616364] text-[14px] tanggal" data-date="<?= $post->createdat ?>"
                                data-format="DD/MM/YYYY">

                            </p>
                            <a href="<?php echo site_url('web/posts/read/' . $post->id) ?>"
                                class="bg-primary border border-[#00A54E] text-white rounded-md px-8 text-center py-3 mt-4 text-[14px] flex items-center justify-center gap-1 hover:text-secondary text-nowrap ">
                                Baca selengkapnya <i data-feather="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>

                    </div>

                <?php } ?>
            </div>
            <?php echo $pagination ?>
        </div>
    <?php } else { ?>
        <div class="col-span-full">
            <div class="px-2 pt-3">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    Tidak dapat memuat artikel
                </div>
            </div>
        </div>
    <?php } ?>
</div>