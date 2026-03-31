<?php
// CKEditor4
?>
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/ckeditor4/adapters/jquery.js"></script>

<!-- lightbox popup -->
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url() ?>assets/app/plugins/magnific-popup/lightbox.js"></script>


<script type="text/javascript">
    // Fungsi untuk menampilkan error pada field
    function showError(element, message) {
        element.classList.add('border-red-500'); // Tambah border merah
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-sm mt-1';
        errorDiv.innerText = message;
        errorDiv.id = element.id + '-error';
        if (!document.getElementById(errorDiv.id)) {
            element.parentNode.appendChild(errorDiv);
        }
    }

    // Fungsi untuk hapus error pada field
    function clearError(element) {
        element.classList.remove('border-red-500');
        const errorDiv = document.getElementById(element.id + '-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    function initChunkUpload() {
        const CHUNK_SIZE = 1024 * 1024 * 5; // 5MB
        const UPLOAD_URL = '<?php echo site_url('app/Regulations/chunk_upload_action') ?>';
        const CSRF_TOKEN = '<?= $this->security->get_csrf_hash() ?>';
        const submitButtons = document.querySelectorAll('button[type="submit"][form="regulationForm"]');

        function generateAcronym(text) {
            if (!text) return '';
            return text.toLowerCase()
                .replace(/[^a-z0-9]/g, ' ')
                .replace(/\s+/g, ' ')
                .trim()
                .split(' ')
                .join('-');
        }

        function setFormStatus(isUploading) {
            submitButtons.forEach(button => {
                button.disabled = isUploading;
                button.textContent = isUploading ? 'Mengunggah... Mohon Tunggu' : '<?php echo $button ?>';
                button.classList.toggle('opacity-50', isUploading);
                button.classList.toggle('cursor-not-allowed', isUploading);
            });
        }
        setFormStatus(false);

        document.querySelectorAll('.upload-chunk-btn').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                document.getElementById(targetId + '_chunk_input').click();
            });
        });

        document.querySelectorAll('input[type="file"][id$="_chunk_input"]').forEach(input => {
            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const year = document.getElementById('year')?.value.trim() || '';
                const regulationnumber = document.getElementById('regulationnumber')?.value.trim() || '';
                const documentCategorySelect = document.getElementById('documentcategory');
                const categoryValue = documentCategorySelect?.value || '';

                let validationFailed = false;
                if (!year) { showError(document.getElementById('year'), 'Tahun wajib diisi.'); validationFailed = true; } else clearError(document.getElementById('year'));
                if (!regulationnumber) { showError(document.getElementById('regulationnumber'), 'Nomor Peraturan wajib diisi.'); validationFailed = true; } else clearError(document.getElementById('regulationnumber'));
                if (!categoryValue) { showError(documentCategorySelect, 'Kategori wajib dipilih.'); validationFailed = true; } else clearError(documentCategorySelect);

                if (validationFailed) {
                    e.target.value = '';
                    return;
                }

                const categoryText = documentCategorySelect.options[documentCategorySelect.selectedIndex]?.text || 'KATEGORI';
                const categoryAcronym = generateAcronym(categoryText);
                const sanitizedRegulationNumber = regulationnumber.replace(/[^a-z0-9]/gi, '_');
                const fileExtension = file.name.split('.').pop().toLowerCase();
                const fileTarget = this.id.replace('_chunk_input', '');
                const prefix = (fileTarget === 'abstractfile') ? 'AB_' : '';
                const newFileName = `${prefix}${year}${categoryAcronym}${sanitizedRegulationNumber}.${fileExtension}`;
                const uniqueId = Date.now() + '-' + file.size + '-' + Math.random().toString(36).substr(2, 9);

                setFormStatus(true);
                const progressBar = document.getElementById(fileTarget + '-progress-bar');
                const statusText = document.getElementById(fileTarget + '-status');
                const progressContainer = document.getElementById(fileTarget + '-progress-container');
                progressBar.style.width = '0%';
                statusText.textContent = `Mempersiapkan ${newFileName}...`;
                progressContainer.classList.remove('hidden');

                const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
                let currentChunk = 0;

                uploadNextChunk();

                function uploadNextChunk() {
                    if (currentChunk >= totalChunks) {
                        statusText.textContent = 'Menunggu konfirmasi server...';
                        return;
                    }
                    currentChunk++;
                    const start = (currentChunk - 1) * CHUNK_SIZE;
                    const end = Math.min(file.size, start + CHUNK_SIZE);
                    const chunk = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('chunk', chunk, file.name);
                    formData.append('resumableChunkNumber', currentChunk);
                    formData.append('resumableTotalChunks', totalChunks);
                    formData.append('fileTarget', fileTarget);
                    formData.append('resumableIdentifier', uniqueId);
                    formData.append('resumableFilename', newFileName);
                    formData.append('<?= $this->security->get_csrf_token_name() ?>', CSRF_TOKEN);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', UPLOAD_URL, true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.status === 'success') {
                                    const percent = ((currentChunk / totalChunks) * 100).toFixed(0);
                                    progressBar.style.width = percent + '%';
                                    statusText.textContent = `Mengunggah... ${percent}%`;

                                    if (response.file_data) {
                                        // Simpan ke hidden input
                                        document.getElementById(fileTarget + '_json').value = JSON.stringify(response.file_data);

                                        // UPDATE SEMUA PREVIEW & LINK DENGAN URL BARU (anti-cache)
                                        const freshUrl = response.file_data.fullpath; // sudah ada ?v=123456

                                        const iframe = document.getElementById(fileTarget + '-preview');
                                        if (iframe) iframe.src = freshUrl;

                                        const link = document.getElementById(fileTarget + '-download-link');
                                        if (link) {
                                            link.href = freshUrl;
                                            link.textContent = response.file_data.filename;
                                            link.classList.remove('hidden');
                                        }

                                        statusText.textContent = `Sukses! File diperbarui: ${response.file_data.filename}`;
                                        progressContainer.classList.add('hidden');
                                        setFormStatus(false);
                                        return;
                                    }
                                    uploadNextChunk();
                                } else {
                                    statusText.textContent = `Gagal: ${response.message}`;
                                    setFormStatus(false);
                                }
                            } catch (e) {
                                statusText.textContent = 'Error respons server.';
                                console.error(e);
                                setFormStatus(false);
                            }
                        } else {
                            statusText.textContent = `Error HTTP ${xhr.status}`;
                            setFormStatus(false);
                        }
                    };
                    xhr.onerror = () => {
                        statusText.textContent = 'Koneksi terputus.';
                        setFormStatus(false);
                    };
                    xhr.send(formData);
                }
            });
        });
    }
    initChunkUpload();


    // Event listener untuk submit form
    document.getElementById('regulationForm').addEventListener('submit', function (e) {
        let valid = true;
        const requiredFields = [
            { id: 'title', message: 'Judul harus diisi' },
            { id: 'documentcategory', message: 'Kategori Dokumen harus dipilih' },
            { id: 'doctype', message: 'Tipe Dokumen harus dipilih' },
            { id: 'regulationnumber', message: 'Nomor Peraturan harus diisi' },
            { id: 'year', message: 'Tahun harus diisi' },
            { id: 'assignmentplace', message: 'Tempat Penetapan harus diisi' },
            { id: 'assignmentdate', message: 'Tanggal Penetapan harus diisi' },
            { id: 'approvaldate', message: 'Tanggal Pengundangan harus diisi' },
            { id: 'effectivedate', message: 'Tanggal Efektif Berlaku harus diisi' },
            { id: 'location', message: 'Lokasi harus diisi' },
            { id: 'source', message: 'Sumber harus diisi' },
            { id: 'legalfield', message: 'Bidang Hukum harus diisi' },
            { id: 'subject', message: 'Subjek harus diisi' }
        ];

        // Clear semua error sebelumnya
        requiredFields.forEach(field => {
            const elem = document.getElementById(field.id);
            clearError(elem);
        });

        // Check setiap field
        requiredFields.forEach(field => {
            const elem = document.getElementById(field.id);
            let value = elem.value.trim();
            if (elem.tagName === 'SELECT') {
                value = elem.options[elem.selectedIndex]?.value || '';
            }
            if (!value) {
                valid = false;
                showError(elem, field.message);
            }
        });

        if (!valid) {
            e.preventDefault(); // Cegah submit jika invalid
            alert('Mohon isi semua field yang wajib!');
            // Scroll ke field error pertama
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // Optional: Clear error saat user mulai input
    document.querySelectorAll('input, select').forEach(elem => {
        elem.addEventListener('input', function () {
            clearError(this);
        });
    });

    // --- PERUBAHAN FUNGSI PREVIEW UNTUK MENGAMBIL DATA CKEDITOR ---
    function cleanHtmlForPreview(html) {
        // Fungsi untuk membersihkan markup CKEditor yang tidak perlu
        let cleaned = html;
        // 1. Hapus attribute xss dan style
        cleaned = cleaned.replace(/(xss|style)="[^"]*"/g, '');
        // 2. Hapus [removed]
        cleaned = cleaned.replace(/\[removed\]/g, '');
        // 3. Hapus span kosong yang berlebihan
        cleaned = cleaned.replace(/<span[^>]*>\s*<\/span>/gi, '');
        // 4. Hapus paragraf kosong
        cleaned = cleaned.replace(/<p>&nbsp;<\/p>/g, '');

        return cleaned;
    }

    function showPreview() {
        const form = document.getElementById('regulationForm');
        const formData = new FormData(form);

        // Fungsi untuk mendapatkan teks dari opsi dropdown yang dipilih
        const getSelectedText = (selector) => {
            const element = document.querySelector(selector);
            return element ? element.options[element.selectedIndex]?.text || 'Tidak diisi' : 'Tidak diisi';
        };

        // Dapatkan konten CKEditor dari instance
        const abstractContent = CKEDITOR.instances.abstract.getData() || 'Tidak diisi';
        const detailStatusContent = CKEDITOR.instances.detailstatus.getData() || 'Tidak diisi';
        const reasonContent = CKEDITOR.instances.reason ? CKEDITOR.instances.reason.getData() : (formData.get('reason') || 'Tidak diisi');

        // Update data preview
        document.getElementById('preview-title').textContent = formData.get('title') || 'Tidak diisi';
        document.getElementById('preview-documentcategory').textContent = getSelectedText('#documentcategory');
        document.getElementById('preview-doctype').textContent = getSelectedText('#doctype');
        document.getElementById('preview-teu').textContent = formData.get('teu') || 'Tidak diisi';
        document.getElementById('preview-regulationnumber').textContent = formData.get('regulationnumber') || 'Tidak diisi';
        document.getElementById('preview-year').textContent = formData.get('year') || 'Tidak diisi';
        document.getElementById('preview-assignmentplace').textContent = formData.get('assignmentplace') || 'Tidak diisi';
        document.getElementById('preview-assignmentdate').textContent = formData.get('assignmentdate') || 'Tidak diisi';
        document.getElementById('preview-approvaldate').textContent = formData.get('approvaldate') || 'Tidak diisi';
        document.getElementById('preview-effectivedate').textContent = formData.get('effectivedate') || 'Tidak diisi';
        document.getElementById('preview-location').textContent = formData.get('location') || 'Tidak diisi';
        document.getElementById('preview-source').textContent = formData.get('source') || 'Tidak diisi';
        document.getElementById('preview-language').textContent = formData.get('language') || 'Tidak diisi';
        document.getElementById('preview-legalfield').textContent = formData.get('legalfield') || 'Tidak diisi';
        document.getElementById('preview-subject').textContent = formData.get('subject') || 'Tidak diisi';
        document.getElementById('preview-cluster').textContent = formData.get('cluster') || 'Tidak diisi';
        document.getElementById('preview-status').textContent = formData.get('status') || 'Tidak diisi';

        // CKEDITOR CONTENTS: Gunakan innerHTML dan bersihkan markup
        document.getElementById('preview-detailstatus').innerHTML = cleanHtmlForPreview(detailStatusContent);
        document.getElementById('preview-abstract').innerHTML = cleanHtmlForPreview(abstractContent);
        document.getElementById('preview-reason').innerHTML = cleanHtmlForPreview(reasonContent);

        // PUBLISH JDIHN
        document.getElementById('preview-published').textContent = getSelectedText('#published');

        // FILE DATA: Perlu dicek apakah ada file baru yang diupload via chunk
        const abstractJson = document.getElementById('abstractfile_json').value;
        const attachmentJson = document.getElementById('attachment_json').value;

        let abstractFileName = 'Tidak ada file dipilih';
        let attachmentFileName = 'Tidak ada file dipilih';

        if (abstractJson) {
            abstractFileName = JSON.parse(abstractJson).filename;
        } else if ('<?php echo $abstractfile ? 1 : 0; ?>' === '1') {
            abstractFileName = '<?php echo $abstractfile ? $abstractfile->filename : "Tidak ada file dipilih"; ?> (Lama)';
        }

        if (attachmentJson) {
            attachmentFileName = JSON.parse(attachmentJson).filename;
        } else if ('<?php echo $attachment ? 1 : 0; ?>' === '1') {
            attachmentFileName = '<?php echo $attachment ? $attachment->filename : "Tidak ada file dipilih"; ?> (Lama)';
        }

        document.getElementById('preview-abstractfile').textContent = abstractFileName;
        document.getElementById('preview-attachment').textContent = attachmentFileName;

        document.getElementById('preview-publishdate').textContent = formData.get('publishdate') || 'Tidak diisi';
        document.getElementById('preview-publishtime').textContent = formData.get('publishtime') || 'Tidak diisi';

        // Tampilkan modal
        document.getElementById('previewModal').classList.remove('hidden');
    }
    // --- BATAS PERUBAHAN FUNGSI PREVIEW ---

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
        title.textContent = type === 'abstractfile' ? 'Preview Abstrak Dokumen' : 'Preview Dokumen';

        // Set konten preview
        if (url && url !== 'Tidak ada file dipilih') {
            content.innerHTML = `<embed src="${url}" frameborder="0" width="100%" height="100%">`;
        } else {
            content.innerHTML = `<div class="text-red-600 font-semibold">File tidak ditemukan atau belum diunggah.</div>`;
        }

        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    function hideFilePreview() {
        // Sembunyikan modal file preview
        document.getElementById('filePreviewModal').classList.add('hidden');
        // Kosongkan konten untuk mencegah memori berlebih
        document.getElementById('filePreviewContent').innerHTML = '';
    }
    $(function () {
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

        ['detailstatus', 'abstract', 'reason'].forEach(initCKEditor);
    });
</script>