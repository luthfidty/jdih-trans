<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div id="content" class="py-6">
    <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="bg-white shadow rounded-lg border border-gray-200">

            <!-- Heading -->
            <div class="px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">
                <?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?>
            </div>

            <!-- Body -->
            <div class="px-6 py-6 space-y-6">

                <div>
                    <label for="fullname" class="block text-sm font-medium text-gray-700">Fullname <?php echo form_error('fullname') ?></label>
                    <input type="text" name="fullname" id="fullname" placeholder="Fullname"
                        value="<?php echo $fullname; ?>"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address <?php echo form_error('address') ?></label>
                    <textarea name="address" id="address" rows="3" placeholder="Address"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"><?php echo $address; ?></textarea>
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700">Url <?php echo form_error('url') ?></label>
                    <input type="url" name="url" id="url" placeholder="Url" value="<?php echo $url; ?>"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image <?php echo form_error('image') ?></label>
                    <?php if (!empty($image)) { ?>
                        <img class="mt-2 w-1/3 rounded border" src="<?php echo site_url($image) ?>" />
                    <?php } ?>
                    <input type="text" name="image" id="image" value="<?php echo $image; ?>" readonly
                        class="mt-2 block w-full rounded-md bg-gray-100 border border-gray-300 px-3 py-2 shadow-sm" />
                    <input type="file" name="fileimage" id="fileimage"
                        class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">About Me <?php echo form_error('description') ?></label>
                    <textarea name="description" id="description" rows="3" placeholder="Aboutme"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"><?php echo $description; ?></textarea>
                </div>

            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex gap-3">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                           value="<?= $this->security->get_csrf_hash() ?>">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <?= $button ?>
                    </button>
                    <a href="<?php echo site_url('auth/users') ?>"
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
