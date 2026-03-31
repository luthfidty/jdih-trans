<div class="section">
    <div class="container">
        <div class="row g-xl-5">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <!-- galleries_data -->
                <?php if ($galleries_data) { ?>
                    <div class="row">
                        <div class="mb-4">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb small mb-3">
                                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>">Beranda</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/galleries/') ?>">Galeri</a></li>
                                    <?php
                                    if ($this->uri->segment(4)) {
                                        echo '<li class="breadcrumb-item"><a href="' . site_url('web/galleries/category/') . $this->uri->segment(4) . '">' . $this->uri->segment(4) . '</a></li>';
                                    }
                                    ?>
                                </ol>
                            </nav>
                            <div class="row">
                                <?php foreach ($galleries_data as $gallery) { ?>
                                    <!-- post -->
                                    <div class="col-6">

                                        <div class="bg-white p-2 shadow-primary-xs transition-hover-top transition-all-ease-250">
                                            <a href="<?php echo site_url('web/galleries/detail/' . $gallery->subtype . '/' . $gallery->slug) ?>" class="d-block overflow-hidden overlay-dark-hover overlay-opacity-2 text-decoration-none text-dark">
                                                <img class="img img-fluid img-responsive"  src="<?php echo $gallery->postimage ? ($gallery->postimagethumb ? site_url($gallery->postimagethumb) : site_url($gallery->postimage)) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>" alt="<?php echo $gallery->title ?>">
                                            </a>

                                            <div class="p-3">

                                                <h5 class="m-0">
                                                    <a href="<?php echo site_url('web/galleries/detail/' . $gallery->subtype . '/' . $gallery->slug) ?>" class="d-block overflow-hidden overlay-dark-hover text-decoration-none text-primary-emphasis"><?php echo $gallery->title ?></a>
                                                </h5>

                                                <ul class="list-inline small m-0">
                                                    <li class="list-inline-item">
                                                        <a class="text-primary-emphasis" href="<?php echo site_url('web/galleries/category/' . $gallery->subtype) ?>" class="text-gray-500"><svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-tag-fill" viewBox="0 0 16 16">
                                                                <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                            </svg> <?php echo ucfirst($gallery->subtype) ?> </a>
                                                    </li>
                                                    <li class="list-inline-item text-primary-emphasis">
                                                        <i class="fi fi-calendar"></i> <?php echo date_format(date_create($gallery->createdat), 'd-m-Y') ?>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>

                                    </div>

                                    <!--/post-->
                                    <?php
                                }
                                ?>
                            </div>
                            <!-- /.card -->
                            <?php echo $pagination ?>
                        </div>

                    </div>
                    <!-- /galleries_data -->
                <?php } else { ?>
                    <div class="col-12 col-md-12">
                        <div class="px-2 pt-3">
                            <div class="alert alert-danger  fade show" role="alert">
                                Tidak dapat halaman
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