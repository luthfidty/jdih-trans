<!-- CKEditor4 -->

<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/adapters/jquery.js"></script>

<!-- lightbox popup -->
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/lightbox.js"></script>

<script type="text/javascript">
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active states
            tabButtons.forEach(b => b.classList.remove('text-blue-600', 'border-blue-600'));
            tabContents.forEach(c => c.classList.add('hidden'));

            // Activate clicked tab
            this.classList.add('text-blue-600', 'border-blue-600');
            const targetId = this.getAttribute('data-tab-target');
            document.getElementById(targetId).classList.remove('hidden');
        });
    });
    function filterchar(e) {
        if (e.shiftKey || e.altKey) {
            e.preventDefault();
        } else {
            var key = e.keyCode;
            if (!((key === 8) || (key === 9) || (key >= 35 && key <= 40) || (key === 46) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key === 115) || (key === 13) || (key === 116) || (key === 17) || (key === 67) || (key === 86))) {
                e.preventDefault();
            }
        }
    }
    function filterlength(e, lgt) {
        if (e.length === lgt || e.lenght > lgt)
            return false;
        else
            return true;
    }
    $("#system_mailer").on('change', function () {
        if (this.value === 'smtp') {
            $("#smtp_host").attr('required', 'required');
            $("#smtp_user").attr('required', 'required');
            $("#smtp_pass").attr('required', 'required');
        } else {
            $("#smtp_host").removeAttr('required');
            $("#smtp_user").removeAttr('required');
            $("#smtp_pass").removeAttr('required');
        }
    });
    function initCKEditor(id) {
        CKEDITOR.replace(id, {
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
    }

    ['site_greeting1', 'site_greeting2'].forEach(initCKEditor);

</script>