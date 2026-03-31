<div class="section">
    <div class="container">
        <div class="row g-xl-5">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <!-- posts -->
                <?php if ($nonregulations) { ?>
                    <div class="row">
                        <div class="mb-4">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb small mb-3">
                                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>">Beranda</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/nonregulations') ?>">Non Peraturan</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo site_url('web/nonregulations/category/' . $this->uri->segment(4)) ?>"><?php echo $nonregulations->category ?></a></li>
                                </ol>
                            </nav>
                            <h1 class="h3 mb-0">
                                <?php echo $nonregulations->title ?>
                            </h1>
                            <div class="card">

                                <div class="card-body">
                                    <div class="classic-view">
                                        <article class="post">
                                            <div class="post-content mb-5">
                                                <table class="table table-striped table-responsive">
                                                    <tr>
                                                        <td>Judul</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->title ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Peraturan</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->regulationnumber ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tahun</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->year ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tajuk Entri Utama</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->teu ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subjek Dokumen</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->subject ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tempat Penetapan</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->assignmentplace ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Penetapan</td>
                                                        <td>:</td>
                                                        <td><?php echo date_format(date_create($nonregulations->assignmentdate), 'd-m-Y') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Pengundangan</td>
                                                        <td>:</td>
                                                        <td><?php echo date_format(date_create($nonregulations->approvaldate), 'd-m-Y') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Berlaku Efektif</td>
                                                        <td>:</td>
                                                        <td><?php echo date_format(date_create($nonregulations->effectivedate), 'd-m-Y') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sumber</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->rsource ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bahasa</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->language ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bidang hukum</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->legalfield ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lokasi</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->location ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kluster</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->cluster ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->status ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan Status</td>
                                                        <td>:</td>
                                                        <td><?php echo $nonregulations->detailstatus ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sampul Buku</td>
                                                        <td>:</td>
                                                        <td><?php
                                                            $cb = json_decode($nonregulations->bookcover);

                                                            echo '<img width="285px" class="img img-thumbnail" src="' . site_url($cb->fullpath) . '"/>'
                                                            ?></td>
                                                    </tr>
                                                </table>
                                                <?php
                                                $att = json_decode($nonregulations->attachment);
                                                ?>


                                                <a href="<?php echo site_url($att->fullpath) ?>" target="_blank" onclick='docdownloaded(<?php echo '"' . $nonregulations->groups . '",' . $nonregulations->id ?>)' class="btn btn-sm text-indigo-900 text-dark-hover bg-info-soft bg-info-hover  "><i class="uil uil-document-layout-center"></i> Download Dokumen</a>
                                            </div>
                                            <!-- /.post-content -->
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
                                                        <button id='btnlike' onclick='doclike(<?php echo '"' . $nonregulations->groups . '",' . $nonregulations->id ?>)' class="btn btn-sm bg-primary-soft  btn-icon btn-icon-start"><i class="fi fi-like"></i> <span id='countliked' class="badge bg-gradient-warning text-indigo-900"><?php echo $nonregulations->liked ?></span> Suka</button>
                                                        <span class="btn btn-sm  bg-success-soft text-indigo-900"><span class="badge bg-gradient-warning text-indigo-900"><?php echo $nonregulations->viewed ?></span> Dilihat</span>
                                                        <span class="btn btn-sm  bg-warning-soft text-indigo-900"><span id='countdownloaded' class="badge bg-gradient-primary text-white"><?php echo $nonregulations->downloaded ?></span> Diunduh</span>
                                                    </div>

                                                    <!--/.share-dropdown -->
                                                </div>
                                            </div>
                                            <!-- /.post-footer -->
                                        </article>
                                        <!-- /.post -->
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-body">
                                    <embed src="<?php echo site_url($att->fullpath) ?>" frameborder="0" width="100%" height="600px"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /posts -->
                <?php } else { ?>
                    <div class="col-12 col-md-12">
                        <div class="px-2 pt-3">
                            <div class="alert alert-danger  fade show" role="alert">
                                Tidak dapat menemukan dokumen
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