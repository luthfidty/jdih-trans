<div class="section">
    <div class="container">
        <div class="row g-xl-5">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <!-- posts -->
                <?php if ($pages) { ?>
                    <div class="row">
                        <div class="mb-4">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb small mb-3">
                                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>">Beranda</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/pages/') ?>">Pages</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/pages/' . $pages->title) ?>"><?php echo $pages->title ?></a></li>

                                </ol>
                            </nav>
                            <h1 class = "h3 mb-0">
                                <?php echo $pages->title
                                ?>
                            </h1>
                            <figure class="d-block text-center rounded overflow-hidden mb-5">
                                <?php if ($pages->postimage) { ?>
                                    <img class="img-fluid rounded" src="<?php echo $pages->postimage ? site_url($pages->postimage) : site_url("assets/web/desktop/images/defaultimgthumb.png") ?>" alt="<?php echo $pages->title ?>">
                                <?php } ?>
                            </figure>
                            <div class="article-format" style="text-align: justify !important">
                                <?php echo $pages->content ?>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--                        <div class="border-top-1 small">

                                                </div>-->
                        <hr />
                        <div class="post-footer d-md-flex flex-md-row justify-content-md-between align-items-center mt-3">
                            <div class="mb-0 ">
                                <div class="dropdown share-dropdown btn-group">
                                    <button class="btn btn-sm bg-gradient-info  dropdown-toggle mb-0 me-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fi fi-share"></i> Share </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"><i class="uil uil-twitter"></i>Twitter</a>
                                        <a class="dropdown-item" href="#"><i class="uil uil-facebook-f"></i>Facebook</a>
                                        <a class="dropdown-item" href="#"><i class="uil uil-linkedin"></i>Linkedin</a>
                                    </div>
                                    <!--/.dropdown-menu -->
                                    <button id='btnlike' onclick="postlike(<?php echo $pages->id ?>, 'page')" class="btn btn-sm bg-primary-soft  btn-icon btn-icon-start"><i class="fi fi-like"></i> <span id='countliked' class="badge bg-gradient-warning text-indigo-900"><?php echo $pages->liked ?></span> Suka</button>
                                    <span class="btn btn-sm  bg-success-soft text-indigo-900"><span class="badge bg-gradient-warning text-indigo-900"><?php echo $pages->viewed ?></span> Dilihat</span>
                                </div>

                                <!--/.share-dropdown -->
                            </div>
                        </div>
                    </div>
                    <!-- /posts -->
                <?php } else { ?>
                    <div class="col-12 col-md-12">
                        <div class="px-2 pt-3">
                            <div class="alert alert-danger  fade show" role="alert">
                                Tidak dapat menenukan halaman
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