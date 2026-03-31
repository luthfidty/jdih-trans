<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Form Content -->
<div class="space-y-6">
    <form id="savemenu" method="post" action="<?php echo $action ?>" autocomplete="off">
        <div class="bg-white border border-gray-200 rounded-lg shadow p-6 space-y-6">
            <div>
                <label for="name" class="block font-medium text-gray-700">
                    Name <?php echo form_error('name') ?>
                </label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            </div>

            <div>
                <label for="description" class="block font-medium text-gray-700">
                    Description <?php echo form_error('description') ?>
                </label>
                <input type="text" id="description" name="description" value="<?php echo $description; ?>" placeholder="Description"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            </div>

            <div>
                <label for="position" class="block font-medium text-gray-700">
                    Position <?php echo form_error('position') ?>
                </label>
                <select id="position" name="position"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                    <option value="mainmenu" <?php echo $position == 'mainmenu' ? 'selected' : '' ?>>Main Menu</option>
                    <option value="secondarymenu" <?php echo $position == 'secondarymenu' ? 'selected' : '' ?>>Secondary Menu</option>
                    <option value="footermenu" <?php echo $position == 'footermenu' ? 'selected' : '' ?>>Footer Menu</option>
                </select>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="space-y-6">
                        <!-- Panel: Daftar Halaman -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 font-semibold">Daftar Halaman</div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_pages">
                                    <ol class="dd-list">
                                        <?php foreach ($pages as $p) { ?>
                                            <li class="dd-item"
                                                data-id="<?php echo $p->title . ';web/pages/read/' . $p->slug ?>">
                                                <div class="dd-handle"> <?php echo $p->title ?> </div>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Kategori Dokumen -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 font-semibold">Kategori Dokumen</div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_documentcategory">
                                    <ol class="dd-list">
                                        <?php foreach ($documentcategories as $dc) { ?>
                                            <li class="dd-item"
                                                data-id="<?php echo $dc->acronym . ';web/regulations/category/' . $dc->acslug ?>">
                                                <div class="dd-handle"> <?php echo $dc->acronym ?> </div>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Kategori Non Peraturan -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 font-semibold">Kategori Non Peraturan</div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_nonreg">
                                    <ol class="dd-list">
                                        <?php foreach ($groups as $k => $v) { ?>
                                            <li class="dd-item"
                                                data-id="<?php echo $v . ';web/nonregulations/category/' . $k ?>">
                                                <div class="dd-handle"> <?php echo $v ?> </div>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Daftar Module -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 font-semibold">Daftar Module</div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_modules">
                                    <ol class="dd-list">
                                        <?php foreach ($modules as $m) { ?>
                                            <li class="dd-item" data-id="<?php echo $m->nametext . ';web/' . $m->uri ?>">
                                                <div class="dd-handle"> <?php echo $m->nametext ?> </div>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Kategori Artikel -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 font-semibold">Kategori Artikel</div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_category">
                                    <ol class="dd-list">
                                        <?php foreach ($categories as $pc) { ?>
                                            <li class="dd-item"
                                                data-id="<?php echo $pc->category . ';web/posts/category/' . $pc->slug ?>">
                                                <div class="dd-handle"> <?php echo $pc->category ?> </div>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Panel: Add Text -->
                        <div class="border border-blue-200 rounded-md">
                            <div class="bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-800">Add Text</div>
                            <div class="p-4 space-y-4">
                                <div>
                                    <label for="nameurl" class="block font-medium text-gray-700">Text Name</label>
                                    <input type="text" id="nameurl" name="nameurl" placeholder="Nama Com"
                                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="url" class="block font-medium text-gray-700">Text URL</label>
                                    <input type="url" id="url" name="url" placeholder="e.g: http://name.com"
                                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                </div>
                                <button type="button" id="btnaddmenu" name="btnaddmenu"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Menu</button>
                            </div>
                        </div>

                        <!-- Panel: Trash Bin -->
                        <div class="border border-gray-200 rounded-md">
                            <div class="bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4M9 7v12m6-12v12"></path>
                                </svg>
                                Trash Bin
                            </div>
                            <div class="p-4">
                                <div class="custom-dd dd" id="nestable_trash">
                                    <ol class="dd-list trash-list"></ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="space-y-4">
                    <!-- Panel Menu -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h6 class="text-lg font-semibold text-green-700 mb-3">List Menu</h6>
                        <div class="custom-dd dd" id="nestable_menu">
                            <ol class="dd-list space-y-2" id="main-list">
                                <?php if (empty($menu)) { ?>
                                    <li class="dd-item bg-white border rounded shadow-sm p-2" data-id="Beranda;">
                                        <div class="dd-handle cursor-move">Beranda</div>
                                        <ol class="dd-list"></ol>
                                    </li>
                                <?php } else {
                                    foreach ($menu as $mn) { ?>
                                        <li class="dd-item bg-white border rounded shadow-sm p-2"
                                            data-id="<?php echo $mn->id ?>">
                                            <div class="dd-handle cursor-move"><?php echo current(explode(";", $mn->id)) ?></div>
                                            <ol class="dd-list ml-4 space-y-2">
                                                <?php if (isset($mn->children)) { ?>
                                                    <?php foreach ($mn->children as $chld) { ?>
                                                        <li class="dd-item bg-white border rounded shadow-sm p-2"
                                                            data-id="<?php echo $chld->id ?>">
                                                            <div class="dd-handle cursor-move">
                                                                <?php echo current(explode(";", $chld->id)) ?>
                                                            </div>
                                                            <ol class="dd-list"></ol>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ol>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                <div class="space-x-2">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    <input type="hidden" name="nestable_menu_output" id="nestable_menu_output" value="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>">
                    <button type="submit" id="menusave"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"><?php echo $button ?></button>
                    <a href="<?php echo site_url('app/navigations') ?>"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>