<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div class="bg-white shadow rounded-lg p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold mb-4"><?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?></h2>
            <div class="mb-4">
                <label for="rolename" class="block font-medium text-gray-700 mb-1">Rolename <?php echo form_error('rolename') ?></label>
                <input type="text" name="rolename" id="rolename" value="<?php echo $rolename; ?>" readonly
                    class="w-full px-3 py-2 border rounded bg-gray-100 text-gray-700" />
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-2">Role Lists</label>
                <div class="flex gap-2 mb-4">
                    <button type="button" id="checkall" class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded">Tick All</button>
                    <button type="button" id="uncheckall" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">Untick All</button>
                </div>

                <div class="space-y-4">
                    <?php
                    $classRoute = !empty($roledetails) ? json_decode($roledetails->roledetail, true) : [];
                    foreach ($routings as $r) {
                    ?>
                        <div class="border p-4 rounded">
                            <div class="font-semibold mb-2"><?php echo ucfirst($r->routealias) ?></div>
                            <div class="space-y-1">
                                <?php
                                if (!empty($r->functionname)) {
                                    foreach (json_decode($r->functionname) as $f => $v) {
                                        $checked = array_key_exists($r->routename, $classRoute) && in_array($v, $classRoute[$r->routename]) ? 'checked' : '';
                                ?>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" name="<?php echo $r->routename ?>[]" value="<?php echo $v ?>" class="form-checkbox" <?php echo $checked ?>>
                                            <span class="text-sm text-gray-700"><?php echo $v ?></span>
                                        </label>
                                <?php
                                    }
                                } else {
                                ?>
                                    <span class="text-yellow-700 bg-yellow-100 text-sm px-2 py-1 rounded">Function not generate yet!</span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-4 border-t">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <div class="space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"><?php echo $button ?></button>
                <a href="<?php echo site_url('auth/roles') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('checkall').addEventListener('click', () => {
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
});
document.getElementById('uncheckall').addEventListener('click', () => {
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
});
</script>
