<!-- Dropzone js -->
<script src="<?php echo base_url() ?>assets/app/plugins/dropzone/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;

    var foto_upload = new Dropzone("#dropzone", {
        url: "<?php echo $action ?>",
        maxFilesize: 10240,
        method: "post",
        acceptedFiles: ".gif,.jpg,.jpeg,.png,.pdf,.doc,.docx,.xlsx,.ppt,.pptx,.zip,.rar",
        paramName: "file",
        parallelUploads: 20,
        dictInvalidFileType: "Tipe file ini tidak dizinkan",
        addRemoveLinks: false,
        timeout: 1
    });
    foto_upload.on('success', function (file) {
        var result = JSON.parse(file.xhr.responseText);
        $("#<?= $this->security->get_csrf_token_name() ?>").val(result.token);
    });
    foto_upload.on('error', function (file) {
        var result = JSON.parse(file.xhr.responseText);
        $("#<?= $this->security->get_csrf_token_name() ?>").val(result.token);
        $('.dz-error-message span').text(result.message);

    });
</script>