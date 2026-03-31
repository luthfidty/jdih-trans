<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->



<div id="content" class="padding-20">
    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="pull-left hidden-xs">
                Laporan Grafik
            </div>

            <div class="pull-right">
                <button id="getdatagraph" type="button" class="btn btn-sm btn-aqua"><i class="fas fa-chart-area"></i> Tampilkan Grafik</button>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div id="alertblock" class=""><!-- SUCCESS -->
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <span id="alertmessage"></span>
                    </div>
                </div>
                <form id='summaryopt' method="post">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <label>Jenis Data</label>
                            <select name="datatype" id="datatype" class="form-control">
                                <option value="0">----</option>
                                <option value="regulations">Peraturan</option>
                                <option value="nonregulations">Non Peraturan</option>
                                <option value="posts">Berita</option>

                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <label>Kategori Dokumen</label>
                            <select name="documentcategory" id="documentcategory" class="form-control">
                                <option value="0">----</option>
                                <?php
                                foreach ($documentcategories as $dc) {
                                    echo '<option value="' . $dc->id . '">' . $dc->category . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <label>Kategori Non peraturan</label>
                            <select name="nonregulations" id="nonregulations" class="form-control">
                                <option value="0">----</option>
                                <?php
                                foreach ($nonregulations as $k => $v) {
                                    echo '<option value="' . $k . '">' . $v . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <label>Group</label>
                            <select name="roles" id="roles" class="form-control">
                                <option value="0">----</option>
                                <?php
                                foreach ($roles as $r) {
                                    if ($r->id == 1) {
                                        continue;
                                    } else {
                                        echo '<option value="' . $r->id . '">' . $r->rolename . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <label>User</label>
                            <select name="users" id="users" class="form-control">
                                <option value="0">----</option>
                                <?php
                                foreach ($users as $u) {
                                    echo '<option value="' . $u->id . '">' . ($u->fullname ? $u->fullname : $u->username) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-6 col-sm-12">
                            <label>Dari</label>
                            <input type="text" name="startdate" id="startdate" class="datepicker form-control" placeholder="Tanggal" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" onkeydown="return filterchar(event)"/>

                        </div>
                        <div class="col-lg-1 col-md-6 col-sm-12">
                            <label>Sampai</label>
                            <input type="text" name="enddate" id="enddate" class="datepicker form-control" placeholder="Tanggal" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" onkeydown="return filterchar(event)"/>
                        </div>
                    </div>
                    <input type="hidden" id="<?= $this->security->get_csrf_token_name() ?>" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                </form>

                <div class="col-sm-12">
                    <div id="summaryoutput" class="margin-top-20">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>