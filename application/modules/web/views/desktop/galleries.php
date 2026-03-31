<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul Galeri -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Galeri</h1>

    <!-- Breadcrumb Galeri -->
    <nav class="my-4">
        <ol class="flex flex-wrap items-center space-x-2 text-[#9D9D9D] text-sm">
            <li><a class="hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
            <li><a class="hover:underline" href="<?php echo site_url('web/galleries/') ?>">Galeri</a></li>
            <?php if ($this->uri->segment(4)) { ?>
                <li><i data-feather="chevron-right" class="w-4 h-4"></i></li>
                <li>
                    <a class="text-white hover:underline"
                        href="<?php echo site_url('web/galleries/category/') . $this->uri->segment(4); ?>">
                        <div class="relative inline-block">
                            <?php echo ucfirst($this->uri->segment(4)); ?>
                            <span class="absolute -bottom-[15.5px] left-0 w-full h-[8px] bg-white rounded-t-full"></span>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ol>
    </nav>
</div>

<div class="container mx-auto p-4 laptop:p-8">


    <?php if ($galleries_data) { ?>
        <div class="flex flex-col justify-center items-center">
            <div class="grid grid-cols-1 laptop:grid-cols-3 gap-6">
                <?php foreach ($galleries_data as $gallery) { ?>
                    <div class="flex flex-col items-start  gap-2 bg-white  rounded-xl min-h-[160px] shadow-md">
                        <img class="text-center bg-light  bg-cover lazy h-[300px] w-full rounded-t-xl"
                            src="<?php echo $gallery->postimage ? ($gallery->postimagethumb ? site_url($gallery->postimagethumb) : site_url($gallery->postimage)) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>"
                            alt="<?php echo $gallery->title ?>" />
                        <div class="p-4">
                            <div class="h-[120px]">
                                <a href="<?php echo site_url('web/galleries/detail/' . $gallery->subtype . '/' . $gallery->id) ?>"
                                    class=" font-bold text-[#02246D] hover:underline  transition">

                                    <?php
                                    echo mb_strimwidth($gallery->title, 0, 180, '...');
                                    ?>
                                </a>
                            </div>
                            <div class=" flex items-center justify-between gap-4 mt-3">
                                <div class="flex items-center gap-1 text-[12px] text-secondary">
                                    <i data-feather="tag" class="w-4 h-4 "></i>
                                    <?php echo ucfirst($gallery->subtype) ?>
                                </div>
                                <p class="text-[#616364] text-[14px] tanggal" data-date="<?= $gallery->createdat ?>" data-format="DD/MM/YYYY">
                                </p>
                            </div>

                            <a href="<?php echo site_url('web/galleries/detail/' . $gallery->subtype . '/' . $gallery->id) ?>"
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
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mt-4">
            Tidak dapat menemukan halaman
        </div>
    <?php } ?>

</div>
<?php $this->load->view('sidebar') ?>