<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div id="content" class="max-w-3xl mx-auto">
    <form action="<?php echo $action ?>" method="post" autocomplete="off" class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></h2>

        <div class="space-y-4">
            <div>
                <label for="username" class="block font-medium text-gray-700">Username <?php echo form_error('username') ?></label>
                <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" class="w-full mt-1 p-2 border rounded-md" />
            </div>

            <div>
                <label for="email" class="block font-medium text-gray-700">Email <?php echo form_error('email') ?></label>
                <input type="text" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" class="w-full mt-1 p-2 border rounded-md" />
            </div>

            <div>
                <label for="newpassword" class="block font-medium text-gray-700">Password <?php echo form_error('newpassword') ?></label>
                <?php if (!empty($id)) { ?>
                    <p class="text-sm text-yellow-600 mt-1">* Kosongkan jika tidak ingin mengubah password</p>
                <?php } ?>
                <input type="password" name="newpassword" id="newpassword" placeholder="Password" class="w-full mt-1 p-2 border rounded-md" />
            </div>

            <div>
                <label for="role" class="block font-medium text-gray-700">Role <?php echo form_error('role') ?></label>
                <select name="role" id="role" class="w-full mt-1 p-2 border rounded-md">
                    <option value="">--Pilih Role--</option>
                    <?php foreach ($roles as $r) { ?>
                        <option value="<?php echo $r->id ?>" <?php echo $r->id == $role ? 'selected' : '' ?>><?php echo $r->rolename ?></option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label for="isactive" class="block font-medium text-gray-700">Status <?php echo form_error('isactive') ?></label>
                <select name="isactive" id="isactive" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1" <?php echo $isactive == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo $isactive == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div class="space-x-2">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="oldpassword" value="<?php echo $oldpassword ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow"><?php echo $button ?></button>
                <a href="<?php echo site_url('auth/users') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">Cancel</a>
            </div>
        </div>
    </form>
</div>
