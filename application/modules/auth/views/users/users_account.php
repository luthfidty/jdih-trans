<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div id="content" class="max-w-2xl mx-auto">
    <form action="<?php echo $action ?>" method="post" autocomplete="off" class="bg-white shadow-md rounded px-6 py-5 space-y-5">
        <h2 class="text-lg font-semibold text-gray-700"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></h2>

        <!-- <?php if ($this->session->userdata('message') != ''): ?>
            <div class="bg-yellow-100 text-yellow-800 p-2 rounded text-sm">
                <?php echo $this->session->userdata('message'); ?>
            </div>
        <?php endif; ?> -->

        <div>
            <label for="username" class="block font-medium text-gray-700">Username <?php echo form_error('username') ?></label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly class="mt-1 w-full p-2 border border-gray-300 rounded bg-gray-100" />
        </div>

        <div>
            <label for="email" class="block font-medium text-gray-700">Email <?php echo form_error('email') ?></label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="mt-1 w-full p-2 border border-gray-300 rounded" />
        </div>

        <div>
            <label for="password" class="block font-medium text-gray-700">Old Password <?php echo form_error('password') ?></label>
            <?php if (!empty($id)) { ?>
                <p class="text-xs text-yellow-600">* Kosongkan jika tidak ingin mengubah password</p>
            <?php } ?>
            <input type="password" name="password" id="password" placeholder="Old Password" class="mt-1 w-full p-2 border border-gray-300 rounded" />
        </div>

        <div>
            <label for="newpassword" class="block font-medium text-gray-700">New Password <?php echo form_error('newpassword') ?></label>
            <?php if (!empty($id)) { ?>
                <p class="text-xs text-yellow-600">* Kosongkan jika tidak ingin mengubah password</p>
            <?php } ?>
            <input type="password" name="newpassword" id="newpassword" placeholder="New Password" class="mt-1 w-full p-2 border border-gray-300 rounded" />
        </div>

        <div class="flex items-center justify-between">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="oldpassword" value="<?php echo $password ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow"><?php echo $button ?></button>
                <a href="<?php echo site_url('app') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">Cancel</a>
            </div>
        </div>
    </form>
</div>
