<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div id="content" class="padding-20">
    <form id="savemenu" method="post" action="<?php echo $action ?>" autocomplete="off">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-12"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="varchar">Role Name<?php echo form_error('name') ?></label>
                    <input readonly="" type="text" class="form-control" name="name" id="name" value="<?php echo $rolename; ?>" />
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h6>Roles Lists</h6>
                            </div>
                            <div class="panel-body">
                                <div class="custom-dd dd" id="nestable_pages">
                                    <ol class="dd-list">
                                        <?php
                                        foreach ($roledetail as $key => $value) {
                                            if ($key == 'rolename') {
                                                continue;
                                            }
                                            ?>
                                            <li class="dd-item" data-id="<?php echo $key . ";" . base_url("app/" . strtolower($key)) ?>">
                                                <div class="dd-handle">
                                                    <?php echo $key ?>
                                                </div>

                                                <ol class="dd-list">
                                                    <?php
                                                    foreach ($value as $index => $val) {
                                                        if ($val == "index" || $val == "create") {
                                                            ?>
                                                            <li class="dd-item" data-id="<?php echo $val . ";" . base_url("app/" . strtolower($key) . "/" . strtolower($val)) ?>">
                                                                <div class="dd-handle">
                                                                    <?php echo $val; ?>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ol>

                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12s">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h6>Roles Navigation</h6>
                            </div>
                            <div class="panel-body">
                                <div class="custom-dd dd" id="nestable_menu">
                                    <ol class="dd-list" id="main-list">
                                        <?php if (empty($navigation)) { ?>
                                            <li class="dd-item" data-id="Website;<?php echo base_url("/") ?>">
                                                <div class="dd-handle">
                                                    Website
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="Beranda;<?php echo base_url("/app") ?>">
                                                <div class="dd-handle">
                                                    Beranda
                                                </div>
                                            </li>
                                            <?php
                                        } else {
                                            $web = explode(";", $navigation[0]->id);
                                            if (in_array("Website", $web) !== TRUE) {
                                                ?>
                                                <li class="dd-item" data-id="Website;<?php echo base_url("/") ?>">
                                                    <div class="dd-handle">
                                                        Website
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            $home = explode(";", $navigation[1]->id);
                                            if (in_array("Beranda", $home) !== TRUE) {
                                                ?>
                                                <li class="dd-item" data-id="Beranda;<?php echo base_url("/app") ?>">
                                                    <div class="dd-handle">
                                                        Beranda
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            foreach ($navigation as $mn) {
                                                ?>
                                                <li class="dd-item" data-id="<?php echo $mn->id ?>">
                                                    <div class="dd-handle">
                                                        <?php echo current(explode(";", $mn->id)) ?>
                                                    </div>
                                                    <?php if (isset($mn->children)) { ?>
                                                        <ol class="dd-list">
                                                            <?php foreach ($mn->children as $chld) { ?>
                                                                <li class="dd-item" data-id="<?php echo $chld->id ?>">
                                                                    <div class="dd-handle">
                                                                        <?php echo current(explode(";", $chld->id)) ?>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ol>
                                                    <?php } ?>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="roleid" name="roleid" value="<?php echo $roleid; ?>" />
                            <input type="hidden" name="nestable_menu_output" id="nestable_menu_output" value="" />
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <button type="submit" id="menusave" class="btn btn-primary"><?php echo $button ?></button>
                            <a href="<?php echo site_url('app/navigations') ?>" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>