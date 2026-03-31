<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>

    <!-- Judul Galeri -->
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Galeri</h1>

    <!-- Breadcrumb Galeri -->
    <nav class="my-4">
        <ol class="flex flex-wrap items-center space-x-2 text-[#9D9D9D] text-sm">
            <li>
                <a class="hover:underline" href="<?php echo site_url() ?>">Beranda</a>
            </li>
            <li>
                <i data-feather="chevron-right" class="w-4 h-4"></i>
            </li>
            <li>
                <a class="hover:underline" href="<?php echo site_url('web/galleries/') ?>">Galeri</a>
            </li>
            <?php if ($this->uri->segment(4)) { ?>
                <li>
                    <i data-feather="chevron-right" class="w-4 h-4"></i>
                </li>
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
    <div class="flex flex-col gap-6 max-w-5xl mx-auto">
        <?php if ($galleries_data) { ?>
            <div class="mb-4">
                <div class="grid gap-4">
                    <div class="col-span-full">
                        <h5 class="text-lg font-semibold"><?php echo $galleries_data->title ?></h5>
                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-700 text-white rounded">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                            <span class="tanggal" data-date="<?= $galleries_data->createdat ?>"
                                data-format="DD/MM/YYYY"></span>
                        </span>
                    </div>
                    <?php if ($galleries_data->subtype == 'Photo') { ?>
                      <img class="w-full object-cover min-h-[400px] mx-auto "
                            src="<?php echo $galleries_data->postimage ? ($galleries_data->postimagethumb ? site_url($galleries_data->postimagethumb) : site_url($galleries_data->postimage)) : site_url('assets/web/desktop/images/defaultimgthumb.png'); ?>"
                            alt="<?php echo $galleries_data->title; ?>" />
                        <div id="postbody" class="prose prose-indigo max-w-full text-justify">
                            <?= ckeditor_to_tailwind($galleries_data->content) ?>
                        </div>
                    <?php } else { ?>
                        <div id="postbody" class="prose prose-indigo max-w-full text-justify">
                            <?= ckeditor_to_tailwind($galleries_data->content) ?>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $pagination ?>
            </div>
        <?php } else { ?>
            <div class="col-span-full">
                <div class="px-2 pt-3">
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
                        Tidak dapat halaman
                    </div>
                </div>
            </div>
        <?php } ?>


    </div>

</div>
<?php $this->load->view('sidebar') ?>