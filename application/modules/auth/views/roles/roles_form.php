<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></h2>
            <div class="mb-4">
                <label for="rolename" class="block text-gray-700 font-medium mb-1">Rolename <?php echo form_error('rolename') ?></label>
                <input type="text" name="rolename" id="rolename" placeholder="Rolename"
                    value="<?php echo $rolename; ?>"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <div class="flex justify-between items-center border-t pt-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"><?php echo $button ?></button>
                <a href="<?php echo site_url('auth/roles') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>
