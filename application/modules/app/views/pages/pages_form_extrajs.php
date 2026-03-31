<!-- CKEditor4 -->

<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/adapters/jquery.js"></script>

<!-- lightbox popup -->
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/lightbox.js"></script>


<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('pagecontent', {
            extraPlugins: 'embed',
            toolbar: [
                { name: 'insert', items: ['Embed'] },
                { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
            ],
            embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
            allowedContent: true,

        });

    });


</script>