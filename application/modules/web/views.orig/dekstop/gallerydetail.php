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
                            <div class="row g-4">
                                <div class='col-lg-12'>
                                    <h5><?php echo $galleries_data->title ?></h5>
                                    <span class="badge bg-gray-700"><i class="fi fi-calendar text-white"></i ><?php echo date_format(date_create($galleries_data->createdat), "d-m-Y") ?></span>
                                </div>
                                <?php
                                $img = $galleries_data->content;
                                if ($galleries_data->subtype == 'Photo') {
                                    foreach (json_decode($img) as $kj => $v) {
                                        ?>
                                        <div class="col-12 col-lg-3 mb-4">

                                            <a class="fancybox fancybox-primary" data-fancybox="gallery" href="<?php echo site_url($v) ?>">
                                                <img class="img-fluid" src="<?php echo site_url($v) ?>" alt="..." />
                                            </a>

                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a class="d-inline-block fancybox overlay-dark overlay-opacity-4" href="<?php echo $galleries_data->content ?>">
                                        <img class="img-fluid" src="<?php echo $galleries_data->postimage ? ($galleries_data->postimagethumb ? site_url($galleries_data->postimagethumb) : site_url($galleries_data->postimage)) : site_url("assets/web/images/defaultvideothumb.png") ?>" alt="..." />
                                        <!-- play button -->
                                        <span class="absolute-full d-flex align-items-center justify-content-center">
                                            <span class="d-inline-flex bg-white text-dark rounded-circle align-items-center justify-content-center shadow-lg" style="width:70px;
                                                  height:70px;
                                                  ">
                                                <i class="fi fi-arrow-end-full lh-1 fs-4"></i>
                                            </span>
                                        </span>
                                    </a>
                                <?php }
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
                            <div class="alert alert-danger fade show" role="alert">
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