<!-- Clipboardjs -->
<script src="<?php echo base_url() ?>assets/app/plugins/clipboard/clipboard.min.js"></script>
<script>
    var clipboard = new ClipboardJS('.copylink');

    clipboard.on('success', function (e) {
        console.log(e);
    });

    clipboard.on('error', function (e) {
        console.log(e);
    });
</script>