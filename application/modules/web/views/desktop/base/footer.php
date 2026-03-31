<footer class="bg-secondary text-white flex flex-col self-end">
    <!-- Section CTA -->
    <div class="py-8 px-4 laptop:px-12 hidden laptop:block">
        <div class="max-w-7xl mx-auto flex flex-col laptop:flex-row justify-between items-center gap-6 text-left">
            <div>
                <h3 class="text-xl font-semibold">Selalu Terhubung! Akses Dokumen Darimana saja!</h3>
                <p class="text-sm">Anda akan selalu mendapatkan berita terbaru pertama kali!</p>
            </div>
            <div>
                <a href="<?php echo $this->config->item('playstoreurl') ?>" target="_blank"
                    class="flex items-center gap-4 bg-[#3d3d3d] hover:bg-gray-800 text-white rounded-full px-8 py-2 transition duration-300 shadow-md">

                    <div class="w-8 h-8">
                        <svg height="100%" width="100%" viewBox="0 0 58.282 63.725" xmlns="http://www.w3.org/2000/svg">
                            <g id="Google_Play_Shape">
                                <g>
                                    <path
                                        d="M0.257,3.012C0.106,3.547,0,4.121,0,4.779v54.172c0,0.649,0.102,1.22,0.25,1.748l30.378-28.805L0.257,3.012z"
                                        style="fill:#48A0DC;" />
                                </g>
                            </g>
                            <g id="Google_Play_Shape_5_">
                                <g>
                                    <path
                                        d="M7.016,0.908C5.602,0.045,4.208-0.171,3.031,0.127l30.505,29.01l8.948-8.483L7.016,0.908z"
                                        style="fill:#88C057;" />
                                </g>
                            </g>
                            <g id="Google_Play_Shape_2_">
                                <g>
                                    <path
                                        d="M55.56,27.934l-9.468-5.271l-9.696,9.194l9.878,9.396l9.213-5.063C59.98,33.627,58.339,29.497,55.56,27.934z"
                                        style="fill:#FFCC66;" />
                                </g>
                            </g>
                            <g id="Google_Play_Shape_3_">
                                <g>
                                    <path
                                        d="M33.487,34.613L2.944,63.571c1.195,0.335,2.621,0.136,4.071-0.749l35.579-19.549L33.487,34.613z"
                                        style="fill:#ED7161;" />
                                </g>
                            </g>
                        </svg>
                    </div>

                    <div class="text-left leading-tight">
                        <span class="block text-xs">Unduh di</span>
                        <span class="block font-semibold text-sm">Play Store</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/30"></div>

    <!-- Main Footer -->
    <div class="py-10 px-4 laptop:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 laptop:grid-cols-4 gap-8 text-sm">

            <!-- Logo dan Deskripsi -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img class="h-[42px] w-[42px] desktop:w-[72px] desktop:h-[72px]"
                        src="<?php echo site_url($this->config->item('site_logo1')) ?>"
                        alt="<?php echo site_url($this->config->item('site_name')) ?>" />
                    <img class="h-[42px] 2-[42px] desktop:w-[72px] desktop:h-[72px]"
                        src="<?php echo site_url($this->config->item('site_logo2')) ?>"
                        alt="<?php echo site_url($this->config->item('site_name')) ?>" />
                </div>
                <p><?= $this->config->item('site_name') ?></p>
            </div>

            <!-- Kontak -->
            <div>
                <h4 class="font-semibold mb-2">Kontak Kami</h4>
                <ul>
                    <li class="flex items-start gap-2"><span class="mt-1">📍</span>
                        <?= $this->config->item('site_address') ?></li>
                    <li class="flex items-center gap-2 mt-2">✉️ <a
                            href="mailto:<?= $this->config->item('site_email') ?>"
                            class="hover:underline"><?= $this->config->item('site_email') ?></a></li>
                    <li class="flex items-center gap-2 mt-2">📞 <a href="tel:<?= $this->config->item('site_phone') ?>"
                            class="hover:underline"><?= $this->config->item('site_phone') ?></a></li>
                </ul>
            </div>

            <!-- Menu -->
            <?php if ($this->config->item('footermenu')): ?>
                <div>
                    <h4 class="font-semibold mb-2">Menu</h4>
                    <ul class="space-y-1">
                        <?php
                        $menu = json_decode($this->config->item('footermenu')->menu);
                        foreach ($menu as $item):
                            $parts = explode(";", $item->id);
                            ?>
                            <li><a href="<?= $parts[1] ?>" class="hover:underline"><?= $parts[0] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Sosial Media -->
                <div>
                    <h4 class="font-semibold mb-2">Ikuti Kami</h4>
                    <div class="flex space-x-4 mt-2">
                        <a href="<?php echo $this->config->item('social_facebook') ?>" 
                            target="_blank" 
                            aria-label="Facebook" 
                            class="social-icon"> <svg height="41px" width="41px" id="Layer_1" style="enable-background:new 0 0 64 63.999;" version="1.1"
                                    viewBox="0 0 64 63.999" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Shape_74_">
                                        <g>
                                            <circle cx="32" cy="32" r="32" style="fill:#1877F2;" />
                                        </g>
                                    </g>
                                    <g id="Facebook_Logo">
                                        <g>
                                            <path
                                                d="M35.896,22.028h4.125v-6.093h-4.848v0.022c-5.872,0.208-7.078,3.51-7.184,6.979h-0.011v3.04h-3.999    v5.968h3.999v15.991h6.029V31.944h4.938l0.951-5.968h-5.889V24.14C34.007,22.97,34.785,22.028,35.896,22.028z"
                                                style="fill:#FFFFFF;" />
                                        </g>
                                    </g>
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                        </svg>
                    </a>
                    <a href="<?php echo $this->config->item('social_twitter') ?>" 
                        target="_blank" 
                        aria-label="Twitter" 
                        class="social-icon"> <svg height="41px" width="41px" id="Layer_1" style="enable-background:new 0 0 1000 1000;"
                                version="1.1" viewBox="0 0 1000 1000" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <style type="text/css">
                                    /* Mengganti ke biru Twitter yang lebih identik (#1DA1F2) */
                                    .st0 {
                                        fill: #1DA1F2;
                                    }

                                    .st1 {
                                        fill: #FFFFFF;
                                    }

                                    .st2 {
                                        fill: none;
                                    }
                                </style>
                                <g>
                                    <g id="Dark_Blue">
                                        <path class="st0"
                                            d="M500,0L500,0c276.1,0,500,223.9,500,500v0c0,276.1-223.9,500-500,500h0C223.9,1000,0,776.1,0,500v0    C0,223.9,223.9,0,500,0z" />
                                    </g>
                                    <g id="Logo_FIXED">
                                        <path class="st1"
                                            d="M384,754c235.8,0,364.9-195.4,364.9-364.9c0-5.5,0-11.1-0.4-16.6c25.1-18.2,46.8-40.6,64-66.4    c-23.4,10.4-48.2,17.2-73.6,20.2c26.8-16,46.8-41.2,56.4-70.9c-25.2,14.9-52.7,25.5-81.4,31.1c-48.6-51.6-129.8-54.1-181.4-5.6    c-33.3,31.3-47.4,78-37.1,122.5c-103.1-5.2-199.2-53.9-264.3-134c-34,58.6-16.7,133.5,39.7,171.2c-20.4-0.6-40.4-6.1-58.2-16    c0,0.5,0,1.1,0,1.6c0,61,43,113.6,102.9,125.7c-18.9,5.1-38.7,5.9-57.9,2.2c16.8,52.2,64.9,88,119.8,89.1    c-45.4,35.7-101.5,55.1-159.2,55c-10.2,0-20.4-0.6-30.5-1.9C246.1,734,314.4,754,384,753.9" />
                                        <path class="st2"
                                            d="M500,0L500,0c276.1,0,500,223.9,500,500v0c0,276.1-223.9,500-500,500h0C223.9,1000,0,776.1,0,500v0    C0,223.9,223.9,0,500,0z" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    <a href="<?php echo $this->config->item('social_youtube') ?>" 
                    target="_blank" 
                    aria-label="Youtube" 
                    class="social-icon"> <svg height="41px" width="41px" id="Layer_1" style="enable-background:new 0 0 64.002 63.996;" version="1.1"
                            viewBox="0 0 64.002 63.996" xml:space="preserve"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Shape_57_">
                                <g>
                                    <circle cx="32.001" cy="31.998" r="31.998" style="fill:#FF0000;" />
                                </g>
                            </g>
                            <g id="YouTube_Logo">
                                <g>
                                    <path
                                        d="M37.925,25.993c0.354,0,0.72-0.204,1.096-0.409    c0.379-0.208,0.742-0.511,1.088-0.907v1.077h1.89v-9.728h-1.89v7.385c-0.176,0.211-0.371,0.385-0.581,0.521    c-0.215,0.137-0.391,0.205-0.529,0.205c-0.177,0-0.307-0.051-0.384-0.156c-0.078-0.103-0.122-0.268-0.122-0.496v-7.459h-1.887    v8.13c0,0.58,0.111,1.013,0.331,1.3C37.159,25.749,37.486,25.993,37.925,25.993z M31.229,25.999c1.013,0,1.807-0.322,2.386-0.779    c0.575-0.459,0.863-1.088,0.863-1.891v-4.851c0-0.716-0.295-1.304-0.88-1.759c-0.591-0.451-1.346-0.68-2.269-0.68    c-1.012,0-1.819,0.216-2.418,0.646c-0.599,0.432-0.898,1.008-0.898,1.738v4.867c0,0.8,0.293,1.432,0.876,1.905    C29.474,25.668,30.255,25.999,31.229,25.999z M30.172,18.657c0-0.184,0.095-0.332,0.283-0.449c0.193-0.113,0.44-0.168,0.745-0.168    c0.331,0,0.599,0.055,0.803,0.168c0.203,0.117,0.306,0.266,0.306,0.449v4.611c0,0.228-0.102,0.406-0.301,0.537    c-0.2,0.13-0.469,0.193-0.808,0.193c-0.33,0-0.585-0.062-0.763-0.191c-0.177-0.128-0.266-0.306-0.266-0.539V18.657z M22.845,26.02    h2.387v-5.812l2.778-8.2h-2.425l-1.478,5.602h-0.15l-1.551-5.602h-2.403l2.842,8.462V26.02z M43.422,30.014H20.58    c-3.631,0-6.574,2.83-6.574,6.315v5.342c0,3.487,2.943,6.316,6.574,6.316h22.842c3.63,0,6.574-2.829,6.574-6.316v-5.342    C49.996,32.844,47.052,30.014,43.422,30.014z M23.98,35.433h-2.021v8.363h-1.953v-8.363h-2.021v-1.424h5.996V35.433z     M30.006,43.913H27.9v-0.865c-0.392,0.319-0.795,0.564-1.217,0.729c-0.42,0.172-0.827,0.253-1.224,0.253    c-0.488,0-0.852-0.117-1.101-0.354c-0.244-0.234-0.369-0.586-0.369-1.059v-6.603h2.105v6.06c0,0.188,0.046,0.32,0.13,0.404    c0.092,0.086,0.237,0.125,0.435,0.125c0.151,0,0.35-0.055,0.586-0.165c0.239-0.111,0.456-0.253,0.654-0.424v-6h2.105V43.913z     M37.979,42.41c0,0.517-0.163,0.913-0.489,1.19c-0.323,0.276-0.798,0.413-1.413,0.413c-0.409,0-0.772-0.052-1.089-0.16    c-0.318-0.104-0.617-0.269-0.89-0.495v0.562h-2.103v-9.911h2.103V37.2c0.282-0.221,0.581-0.391,0.892-0.507    c0.318-0.117,0.638-0.173,0.961-0.173c0.658,0,1.16,0.153,1.507,0.464c0.349,0.313,0.521,0.77,0.521,1.367V42.41z M45.993,40.181    h-3.882v1.427c0,0.398,0.064,0.674,0.197,0.83c0.136,0.154,0.365,0.23,0.688,0.23c0.339,0,0.572-0.065,0.707-0.196    c0.132-0.133,0.202-0.419,0.202-0.864v-0.345h2.088v0.389c0,0.775-0.253,1.361-0.767,1.756c-0.505,0.391-1.265,0.584-2.276,0.584    c-0.909,0-1.627-0.206-2.147-0.623c-0.521-0.412-0.785-0.987-0.785-1.717v-3.403c0-0.654,0.289-1.192,0.864-1.604    c0.574-0.415,1.312-0.62,2.222-0.62c0.929,0,1.643,0.19,2.142,0.573c0.499,0.385,0.748,0.934,0.748,1.651V40.181z M34.969,37.681    c-0.148,0-0.297,0.023-0.441,0.071c-0.146,0.046-0.288,0.124-0.43,0.223v4.555c0.168,0.119,0.333,0.209,0.493,0.261    c0.161,0.05,0.326,0.078,0.503,0.078c0.255,0,0.441-0.051,0.562-0.156c0.118-0.103,0.179-0.271,0.179-0.502v-3.777    c0-0.248-0.07-0.435-0.217-0.562C35.465,37.745,35.248,37.681,34.969,37.681z"
                                        style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" />
                                </g>
                            </g>
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                        </svg>
                    </a>
                    <a href="<?php echo $this->config->item('social_instagram') ?>" 
                        target="_blank"
                        aria-label="Instagram"
                        class="social-icon"> <svg height="41px" width="41px" id="Layer_1" version="1.1"
                                viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g>
                                    <path
                                        d="M17,22H7c-2.7614236,0-5-2.2385769-5-5V7c0-2.7614236,2.2385764-5,5-5h10c2.7614231,0,5,2.2385764,5,5v10   C22,19.7614231,19.7614231,22,17,22z"
                                        fill="#FFFFFF" />
                                    
                                    <radialGradient cx="2.4583333" cy="22.208334" gradientUnits="userSpaceOnUse"
                                        id="SVGID_1_" r="26.8152752">
                                        <stop offset="0" style="stop-color:#FFD35A" />
                                        <stop offset="0.2548544" style="stop-color:#F7964C" />
                                        <stop offset="0.5995145" style="stop-color:#F05B70" />
                                        <stop offset="0.7174556" style="stop-color:#BD6186" />
                                        <stop offset="0.8532288" style="stop-color:#85659B" />
                                        <stop offset="0.9509482" style="stop-color:#5C66A9" />
                                        <stop offset="1" style="stop-color:#4766B0" />
                                    </radialGradient>
                                    
                                    <path
                                        d="M17.0219727,1H6.9780273C3.6816406,1,1,3.6816406,1,6.9780273v10.0439453   C1,20.3183594,3.6816406,23,6.9780273,23h10.0439453C20.3183594,23,23,20.3183594,23,17.0219727V6.9780273   C23,3.6816406,20.3183594,1,17.0219727,1z M21,17.0219727C21,19.215332,19.215332,21,17.0219727,21H6.9780273   C4.784668,21,3,19.215332,3,17.0219727V6.9780273C3,4.784668,4.784668,3,6.9780273,3h10.0439453   C19.215332,3,21,4.784668,21,6.9780273V17.0219727z M12,6c-3.3085938,0-6,2.6914063-6,6s2.6914063,6,6,6s6-2.6914063,6-6   S15.3085938,6,12,6z M12,16c-2.2055664,0-4-1.7944336-4-4s1.7944336-4,4-4s4,1.7944336,4,4S14.2055664,16,12,16z M18,5   c-0.5512695,0-1,0.4487305-1,1s0.4487305,1,1,1s1-0.4487305,1-1S18.5512695,5,18,5z"
                                        fill="url(#SVGID_1_)" />
                                </g>
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                            <g />
                        </svg>
                    </a>
                    <a href="<?php echo $this->config->item('social_tiktok') ?>" 
                        target="_blank" 
                        aria-label="TikTok" 
                        class="social-icon"> 
                            <svg height="41px" width="41px"
                                style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                version="1.1" viewBox="0 0 512 512" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="Layer_x0020_1">
                                    <g id="_2515485150816">
                                        <path fill="#000000"
                                            d="M256 0c141.39,0 256,114.61 256,256 0,141.39 -114.61,256 -256,256 -141.39,0 -256,-114.61 -256,-256 0,-141.39 114.61,-256 256,-256z" />
                                        
                                        <path fill="#FFFFFF"
                                            d="M313.5 106.01c0.01,4.58 1.36,70.83 70.87,74.96 0,19.1 0.02,32.95 0.02,51.18 -5.26,0.3 -45.76,-2.64 -70.97,-25.12l-0.08 99.64c0.96,69.16 -49.93,111.24 -116.46,96.7 -114.71,-34.31 -76.59,-204.44 38.59,-186.24 0,54.93 0.03,-0.01 0.03,54.93 -47.58,-7 -63.5,32.58 -50.85,60.93 11.5,25.8 58.88,31.39 75.41,-5.01 1.87,-7.12 2.8,-15.25 2.8,-24.37l0 -197.85 50.64 0.25z" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    <!-- Tambahkan sosial media lainnya -->
                </div>
            </div>
        </div>

        <!-- Garis Bawah -->
    </div>
    <div class="py-6  bg-primary px-4">
        <p class="mx-auto  text-start text-base">
            &copy; <?= date('Y') ?> <?= $this->config->item('site_name') ?>. All rights reserved.
        </p>
    </div>
</footer>

<!-- /Footer -->
</div><!-- /#wrapper -->
<script src="<?php echo site_url('assets/web/' . $device . '/js/core.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.userway.org/widget.js" data-account="pBrpqo8U13"></script>
<script src="https://unpkg.com/feather-icons"></script>


<!-- Feather Icons -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
    feather.replace();  
    });

</script>


<!-- Dropdown Toggle -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const button = document.getElementById("dropdownButton");
        const menu = document.getElementById("dropdownMenu");

        if (!button || !menu) return;

        button.addEventListener("click", function () {
            menu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add("hidden");
            }
        });
    });
</script>

<!-- Flash Message (Snackbar) -->
<?php if ($this->session->userdata('message')): ?>
    <script>
        window.flashMessage = <?php echo json_encode($this->session->userdata('message')); ?>;
    </script>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.flashMessage) {
            const snackbar = document.createElement("div");
            snackbar.className =
                "fixed bottom-4 right-4 z-50 bg-green-600 text-white px-4 py-3 rounded shadow-lg flex items-center gap-2 transition-opacity duration-300";
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
                snackbar.classList.add("opacity-0");
                setTimeout(() => snackbar.remove(), 500);
            }, 3000);
        }
    });
</script>

<!-- Survey Submit -->
<script>
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
    function submit_survey(value) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/surveys/submit/") ?>" + value,
            dataType: "JSON",
            async: false,
            success: function (data) {
                const cls = data.status === "success"
                    ? "alert alert-mini alert-success text-wrap"
                    : "alert alert-mini alert-danger text-wrap";
                const msg = data.status === "success"
                    ? "Terima kasih sudah melakukan survey"
                    : "Tidak dapat mengirim survey";

                $("#classmessage").attr("class", cls).html(msg);
                $("#surveymessage").show();
                setTimeout(() => $("#surveymessage").hide(), 5000);
            },
            error: function () {
                $("#classmessage")
                    .attr("class", "alert alert-mini alert-danger text-wrap")
                    .html("Tidak dapat mengirim survey");
                $("#surveymessage").show();
                setTimeout(() => $("#surveymessage").hide(), 5000);
            }
        });
    }
</script>

<!-- Visitor Counter -->
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url("web/Web/ajax_get_visitor_counter") ?>",
                dataType: "JSON",
                async: false,
                success: function (data) {
                    if (data.status === "success") {
                        $("#vunique").html(data.vunique.vunique);
                        $("#vtotal").html(data.vtotal.visitor);
                        $("#vmonthly").html(data.vmonthly.visitor);
                        $("#vdaily").html(data.vdaily.visitor);
                    }
                },
                error: function () {
                    console.log("cannot send like");
                }
            });
        }, 2000);

        $("#surveymessage").hide();
    });
</script>

<!-- Extra JS if provided -->
<?php
if (isset($extrajs)) {
    $this->load->view($device . '/' . $extrajs);
}
?>

</body>
</html>