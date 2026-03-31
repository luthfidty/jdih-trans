

<!-- CKEditor4 -->
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/adapters/jquery.js"></script>

<!-- Magnific Popup -->
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/lightbox.js"></script>

<script>
    function showPreview() {
        const form = document.getElementById('galleryForm');
        const formData = new FormData(form);

        // Fungsi untuk mendapatkan teks dari opsi dropdown yang dipilih
        const getSelectedText = (selector) => {
            const element = document.querySelector(selector);
            return element ? element.options[element.selectedIndex]?.text || 'Tidak diisi' : 'Tidak diisi';
        };

        // Update data preview
        document.getElementById('preview-title').textContent = formData.get('title') || 'Tidak diisi';
        document.getElementById('preview-content').innerHTML = CKEDITOR.instances.pagecontent.getData() || 'Tidak diisi';
        document.getElementById('preview-subtype').textContent = getSelectedText('#subtype') === '- Pilih Jenis Galeri -' ? 'Tidak diisi' : getSelectedText('#subtype');
        document.getElementById('preview-postimage').textContent = document.querySelector('#postimage')?.files[0]?.name || '<?php echo !empty($postimage) ? $postimage : "Tidak ada file dipilih"; ?>';
        document.getElementById('preview-metapost').textContent = formData.get('metapost') || 'Tidak diisi';
        document.getElementById('preview-keywords').textContent = formData.get('keywords') || 'Tidak diisi';
        document.getElementById('preview-poststatus').textContent = getSelectedText('#poststatus');

        // Tampilkan modal
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function hidePreview() {
        // Sembunyikan modal
        document.getElementById('previewModal').classList.add('hidden');
        // Pastikan modal file preview juga tertutup
        hideFilePreview();
    }

    function showFilePreview(type, url) {
        const modal = document.getElementById('filePreviewModal');
        const title = document.getElementById('filePreviewTitle');
        const content = document.getElementById('filePreviewContent');

        // Set judul modal
        title.textContent = 'Preview Thumbnail';

        // Cek apakah ada file baru yang diunggah
        const fileInput = document.querySelector('#postimage');
        if (fileInput?.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                content.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else if (url && url !== 'Tidak ada file dipilih') {
            content.src = url;
        } else {
            content.src = '';
            content.alt = 'File tidak ditemukan atau belum diunggah';
        }

        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    function hideFilePreview() {
        // Sembunyikan modal file preview
        document.getElementById('filePreviewModal').classList.add('hidden');
        // Kosongkan src untuk mencegah memori berlebih
        document.getElementById('filePreviewContent').src = '';
    }

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
            allowedContent: true
        });
    });
</script>