<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<!-- Content -->
<div class="bg-white shadow rounded-lg p-6">
    <form action="<?php echo $action ?>" method="post" autocomplete="off" class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></h2>

            <!-- Routename -->
            <div class="mb-4">
                <label for="routename" class="block text-gray-700 font-medium mb-1">Routename <?php echo form_error('routename') ?></label>
                <input type="text" name="routename" id="routename" placeholder="Routename"
                    value="<?php echo $routename; ?>"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Routealias -->
            <div class="mb-4">
                <label for="routealias" class="block text-gray-700 font-medium mb-1">Routealias <?php echo form_error('routealias') ?></label>
                <input type="text" name="routealias" id="routealias" placeholder="Routealias"
                    value="<?php echo $routealias; ?>"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Route Icon -->
            <div class="mb-4">
                <label for="icon" class="block text-gray-700 font-medium mb-1">Route Icon <?= form_error('icon') ?></label>
                
                <select name="icon" id="icon"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-awesome">
                    <?php foreach ($icons as $i): ?>
                        <option value="<?= $i->icon ?>" <?= $icon == $i->icon ? 'selected' : '' ?>>
                            &#x<?= $i->unicode ?> <?= $i->icon ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="flex justify-between items-center border-t pt-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"><?php echo $button ?></button>
                <a href="<?php echo site_url('auth/routings') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>
