<div class="section">
    <div class="container">
        <div class="row g-xl-5">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <!-- posts -->
                <?php if ($posts) { ?>
                    <div class="row">
                        <div class="mb-4">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb small mb-3">
                                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>">Beranda</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/posts/') ?>">Artikel</a></li>
                                    <?php if ($currentdoccategory) { ?>
                                        <li class="breadcrumb-item"><a href="<?php echo site_url('web/posts/category/' . $currentdoccategory->slug) ?>"><?php echo $currentdoccategory->category ?></a></li>
                                    <?php } ?>
                                </ol>
                            </nav>
                            <div class="row">
                                <?php foreach ($posts as $post) { ?>
                                    <!-- post -->
                                    <div class="col-sm-12 mt-3" >
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <img src="<?php echo $post->postimage ? ($post->postimagethumb ? site_url($post->postimagethumb) : site_url($post->postimage)) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>" class="img img-responsive img-thumbnail"/>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <a class="text-primary-emphasis link-dark" href="<?php echo site_url('web/posts/read/' . $post->slug) ?>"><span class="fs-6 fw-light"><?php echo $post->title ?></span></a>

                                            </div>
                                        </div>

                                        <a class = "btn btn-sm pt-1 pb-1 bg-primary text-white text-dark-hover bg-primary-soft-hover" href = "<?php echo site_url('web/posts/read/' . $post->slug) ?>"><i class = "fi fi-bookmark"></i> Baca </a>
                                        <span class = "badge bg-info text-danger-emphasis"><i class = "fi fi-like"></i> <?php echo $docv->liked
                                    ?> </span>
                                        <span class = "badge bg-info text-danger-emphasis"><i class="fi fi-eye"></i> <?php echo $docv->viewed ?> </span>
                                    </div>
                                    <!-- /post -->
                                <?php } ?>
                            </div>
                            <!-- /.card -->
                            <?php echo $pagination ?>
                        </div>

                    </div>
                    <!-- /posts -->
                <?php } else { ?>
                    <div class="col-12 col-md-12">
                        <div class="px-2 pt-3">
                            <div class="alert alert-danger  fade show" role="alert">
                                Tidak dapat memuat artikel
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <?php $this->load->view('sidebar') ?>
        </div>

    </div>
</div>
<!-- end :: blog content -->