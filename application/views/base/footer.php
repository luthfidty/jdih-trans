</div>
<!-- END wrapper -->

<!-- ======================== -->
<!-- JAVASCRIPT FILES        -->
<!-- ======================== -->

<!-- Alpine JS -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- jQuery & App Core -->
<script src="<?php echo base_url() ?>assets/app/plugins/jquery/jquery-2.2.3.min.js"></script>
<script>
    var plugin_path = '<?php echo base_url() ?>assets/app/plugins/';
</script>
<script src="<?php echo base_url() ?>assets/app/js/app.js"></script>



<!-- Flatpickr -->

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Month Select Plugin -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<!-- QuillJS -->
<!-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> -->

<!-- ECharts (optional) -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>



<?php if ($this->session->userdata('message')): ?>
    <script>
        window.flashMessage = <?php echo json_encode($this->session->userdata('message')); ?>;
    </script>


<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        if (window.flashMessage) {
            const snackbar = document.createElement('div');
            snackbar.className = 'fixed bottom-4 right-4 z-50 bg-green-600 text-white px-4 py-3 rounded shadow-lg flex items-center gap-2 transition-opacity duration-300';
            snackbar.innerHTML = `
        <span class="flex-1">${window.flashMessage}</span>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      `;

            document.body.appendChild(snackbar);

            setTimeout(() => {
                snackbar.classList.add('opacity-0');
                setTimeout(() => snackbar.remove(), 500);
            }, 3000);
        }
    });
</script>

<!-- Inisialisasi Editor & Picker -->
<script>
    // Helper untuk decode HTML entities
    function decodeHTML(html) {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }

    // Moment.js - Format tanggal
    moment.locale('id');
    document.querySelectorAll('.tanggal').forEach(function (el) {
        const rawDate = el.dataset.date;
        const format = el.dataset.format || 'D MMMM YYYY';

        if (rawDate) {
            const parsedDate = moment(rawDate);
            el.textContent = parsedDate.isValid() ? parsedDate.format(format) : '-';
        } else {
            el.textContent = '-';
        }
    });

    document.getElementById('year').addEventListener('input', function (e) {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });

    // Inisialisasi Quill Editor
    // const editors = document.querySelectorAll('.quill-editor');
    // const quillInstances = {};

    // if (editors.length > 0) {
    //     editors.forEach(editor => {
    //         const fieldName = editor.dataset.name;
    //         const quill = new Quill(editor, {
    //             theme: 'snow',
    //             placeholder: 'Tulis di sini...',
    //             modules: {
    //                 toolbar: [
    //                     [{ header: [1, 2, false] }],
    //                     ['bold', 'italic', 'underline'],
    //                     ['link', 'blockquote', 'code-block'],
    //                     [{ list: 'ordered' }, { list: 'bullet' }]
    //                 ]
    //             }
    //         });

    //         quillInstances[fieldName] = quill;

    //         // Set value dari hidden input jika ada
    //         const hiddenInput = document.querySelector(`input[name="${fieldName}"]`);
    //         if (hiddenInput && hiddenInput.value) {
    //             quill.root.innerHTML = decodeHTML(hiddenInput.value);
    //         }
    //     });
    // }

    // // Saat form disubmit, isi hidden input dari editor Quill
    // const formEl = document.querySelector('form');
    // if (formEl) {
    //     formEl.addEventListener('submit', function () {
    //         for (const name in quillInstances) {
    //             const quill = quillInstances[name];
    //             const hiddenInput = document.querySelector(`input[name="${name}"]`);
    //             if (hiddenInput) {
    //                 hiddenInput.value = quill.root.innerHTML;
    //             }
    //         }
    //     });
    // }

    // Flatpickr Time Picker
    if (typeof flatpickr !== 'undefined') {
        // Time Picker (jam dan menit saja)
        flatpickr(".jdihtimepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        // Date Picker (tanggal lengkap)
        flatpickr(".jdihdatepicker", {
            dateFormat: "Y-m-d",         // e.g. 2025-07-30
            altInput: true,
            altFormat: "j F Y",          // e.g. 30 Juli 2025
            allowInput: true,
            locale: "id"
        });

        // Year Picker (hanya tahun)
        // flatpickr(".jdihyearpicker", {
        //     plugins: [
        //         new monthSelectPlugin({
        //             shorthand: true,
        //             dateFormat: "Y",     // value yang dikirim
        //             altFormat: "Y",      // yang terlihat
        //             theme: "light"
        //         })
        //     ],
        //     locale: "id"
        // });


    } else {
        console.warn("flatpickr belum dimuat.");
    }

</script>



<!-- Extra JS jika ada -->
<?php if (isset($extrajs)) {
    $this->load->view($extrajs);
} ?>
</body>

</html>