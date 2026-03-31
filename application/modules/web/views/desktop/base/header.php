<!doctype html>
<html class="scroll-smooth" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title><?= $this->config->item('site_name') ?> | <?= $this->config->item('site_description') ?></title>
    <meta name="description"
        content="<?= $this->config->item('site_name') ?> | <?= $this->config->item('site_description') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- DNS Prefetch & Preconnect -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com/" />
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- Preload Font -->
    <link rel="preload" href="<?= site_url('assets/web/' . $device . '/fonts/flaticon/Flaticon.woff2') ?>" as="font"
        type="font/woff2" crossorigin />

    <!-- Styles -->
    <link rel="stylesheet" href="<?= site_url('assets/web/' . $device . '/css/vendor_bundle.min.css') ?>" />
    <link rel="stylesheet" href="<?= site_url('assets/web/' . $device . '/css/custom.css') ?>" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Poppins:ital,wght@0,100..900;1,100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F1F45',
                        secondary: '#D48A00'
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        figtree: ['Figtree', 'sans-serif'],
                        worksans: ['Work Sans', 'sans-serif'],
                    },
                    screens: {
                        tablet: '768px',
                        laptop: '1100px',
                        desktop: '1280px',
                    },

                },
            }
        }
    </script>

    <!-- Facebook Meta -->
    <meta property="og:url" content="<?= $permalink ?? $this->config->item('site_url') ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title"
        content="<?= $this->config->item('site_name') ?> | <?= $this->config->item('site_description') ?>" />
    <meta property="og:description" content="<?= $this->config->item('site_description') ?>" />
    <meta property="og:image" content="<?= site_url($this->config->item('site_icon')) ?>" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= site_url($this->config->item('site_icon')) ?>" />
    <link rel="apple-touch-icon" href="<?= site_url($this->config->item('site_icon')) ?>" />

    <!-- Custom CSS Per Halaman -->
    <?php if (isset($extracss))
        $this->load->view($device . '/' . $extracss); ?>

    <!-- Cloak Styling -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Pastikan CSS ini dimuat SETELAH file CSS Tailwind utama Anda */

        .rich-text-output {
            /* 1. Pengaturan Dasar Teks */
            line-height: 1.6;
            /* Wajib: Ketinggian baris agar mudah dibaca */
            word-wrap: break-word;
            /* Memastikan teks panjang tidak merusak layout */
            color: #1f2937;
            /* Contoh: Warna teks gelap, seperti text-gray-800 di Tailwind */
            font-size: 0.9375rem;
            /* Contoh: Ukuran teks sedikit lebih kecil dari default (setara text-base) */
        }

        /* 2. Paragraf */
        .rich-text-output p {
            margin-top: 0.5em;
            margin-bottom: 1em;
            /* Wajib: Memberi jarak yang jelas antar paragraf/baris */
        }

        /* 3. Daftar Tak Berurutan (<ul>) */
        .rich-text-output ul {
            list-style-type: disc;
            /* Mengaktifkan kembali bullet point */
            padding-left: 2em;
            /* Memberi indentasi */
            margin-top: 0.5em;
            margin-bottom: 1em;
        }

        /* 4. Daftar Berurutan (<ol>) */
        .rich-text-output ol {
            list-style-type: decimal;
            /* Mengaktifkan kembali penomoran */
            padding-left: 2em;
            /* Memberi indentasi */
            margin-top: 0.5em;
            margin-bottom: 1em;
        }

        /* 5. Elemen Daftar (<li>) */
        .rich-text-output li {
            margin-bottom: 0.5em;
            /* Jarak antar item list */
        }

        /* 6. Heading (Opsional: Jika Abstrak/Keterangan Status menggunakan H tag) */
        .rich-text-output h1,
        .rich-text-output h2,
        .rich-text-output h3,
        .rich-text-output h4 {
            font-weight: 700;
            /* Bold */
            margin-top: 1.5em;
            margin-bottom: 0.8em;
        }

        /* 7. Link (Opsional) */
        .rich-text-output a {
            color: #2563eb;
            /* Contoh: Warna biru (setara text-blue-600) */
            text-decoration: underline;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
</head>

<body class="font-figtree">