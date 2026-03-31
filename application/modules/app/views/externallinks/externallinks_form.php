<!-- page title -->
<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?php echo ucfirst($this->uri->segment(2)) ?></h1>
    <nav class="text-sm text-gray-500 mt-1">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="<?php echo base_url($this->uri->segment(1)) ?>"
                    class="text-blue-500 hover:underline">Beranda</a>
            </li>
            <li>/</li>
            <li>
                <a href="<?php echo base_url($this->uri->segment(1) . "/" . $this->uri->segment(2)) ?>"
                    class="text-blue-500 hover:underline"><?php echo ucfirst($this->uri->segment(2)) ?></a>
            </li>
            <li>/</li>
            <li class="text-gray-600"><?php echo ucfirst($this->uri->segment(3)) ?></li>
        </ol>
    </nav>
</header>

<!-- Form Container -->
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" enctype="multipart/form-data"
        class="space-y-6">
        <div class="space-y-4">
            <div>
                <label for="name" class="block font-medium text-gray-700">Nama Situs
                    <?php echo form_error('name') ?></label>
                <input type="text" name="name" id="name" placeholder="Nama Situs" value="<?php echo $name; ?>"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label for="addressurl" class="block font-medium text-gray-700">Alamat URL
                    <?php echo form_error('addressurl') ?></label>
                <input type="url" name="addressurl" id="addressurl" placeholder="Alamat URL. Cth : https://urlsitus.com"
                    value="<?php echo $addressurl; ?>"
                    class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label for="postimage" class="block font-medium text-gray-700">Logo
                    <?php echo form_error('postimage') ?></label>
                <input type="file" name="postimage" id="postimage"
                    class="mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded px-3 py-2" />
                <?php if (!empty($postimage)) { ?>
                    <div class="mt-2">
                        <img src="<?php echo site_url($postimagethumb) ?>" alt="Logo"
                            class="h-36 rounded border object-contain" />
                    </div>
                <?php } ?>
                
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="pt-6 border-t border-gray-200 flex justify-between items-center">
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="curpostimage" value="<?php echo $postimage ?>" />
            <input type="hidden" name="curpostimagethumb" value="<?php echo $postimagethumb ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                value="<?= $this->security->get_csrf_hash() ?>">

            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                    <?php echo $button ?>
                </button>
                <a href="<?php echo site_url('app/externallinks') ?>"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow text-sm">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>