<!doctype html>
<html lang="en-US">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title><?php echo $this->config->item('site_title') ?></title>
    <meta name="description" content="<?php echo $this->config->item('site_description') ?>" />
    <meta name="Author" content="GoDesa" />
    <link rel="shortcut icon" href="<?php echo base_url($this->config->item('site_icon')) ?>">
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

    <!-- WEB FONTS -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext"
        rel="stylesheet" type="text/css" />

    <!-- CORE CSS -->
    <!-- <link href="<?php echo base_url() ?>assets/app/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" /> -->

    <!-- THEME CSS -->
    <!-- <link href="<?php echo base_url() ?>assets/app/css/essentials.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo base_url() ?>assets/app/fonts/fa5/css/all.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url() ?>assets/app/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/app/css/color_scheme/blue.css" rel="stylesheet" type="text/css" id="color_scheme" /> -->
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#163B54', // contoh warna kustom
                        secondary: '#C09546'
                    },
                    fontFamily: {
                        opensans: ['"Open Sans"', 'sans-serif'],
                    },
                    screens: {
                        'tablet': '768px',
                        'laptop': '1100px', // ubah sesuai kebutuhan
                        'desktop': '1280px',
                    },
                },

            }
        }
    </script>

</head>
<!--
        .boxed = boxed version
    -->

<body class="font-opensans">

    <div class="min-h-screen flex flex-col laptop:flex-row w-full">
        <!-- Kiri: Background Hero -->
        <div class="hidden laptop:block laptop:w-8/12 bg-cover bg-center" style="background: url('<?php echo site_url($this->config->item('site_hero')) ?>'); background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;">
        </div>


        <!-- Kanan: Login Form -->
        <div class="w-full laptop:w-4/12 flex items-center justify-center  p-6 relative">

            <div class="w-full max-w-md rounded-xl  space-y-6 z-20">
                <form action="<?= $action ?>" method="post" class="space-y-4">
                    <div class="flex items-center gap-4">

                        <div class="text-center flex items-center gap-2 justify-center">
                            <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
                                src="<?php echo site_url($this->config->item('site_logo1')) ?>"
                                alt="<?php echo site_url($this->config->item('site_name')) ?>" />
                            <img class="h-[32px] 2-[32px] desktop:w-[42px] desktop:h-[42px]"
                                src="<?php echo site_url($this->config->item('site_logo2')) ?>"
                                alt="<?php echo site_url($this->config->item('site_name')) ?>" />
                        </div>
                        <div class="flex flex-col items-start ">
                            <h2 class="text-2xl tablet:text-3xl laptop:text-4xl font-bold text-gray-700">
                                JDIH
                            </h2>
                            <p class="text-sm text-gray-600">
                                Jaringan Dokumentasi dan Informasi Hukum
                            </p>
                        </div>

                    </div>

                    <!-- <?php if ($this->session->userdata('message') != ''): ?>
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center">
                            <strong><?= $this->session->userdata('message') ?></strong>
                        </div>
                    <?php endif; ?> -->

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1" for="username">Nama Pengguna</label>
                        <div class="relative">
                            <input type="text" name="username" id="username"
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('username') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                placeholder="Nama Pengguna">
                            <i class="fa fa-envelope absolute left-3 top-2.5 text-gray-400"></i>
                        </div>
                        <?php if (form_error('username')): ?>
                            <p class="text-sm text-red-600 mt-1"><?= form_error('username') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1" for="password">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                placeholder="Kata Sandi">
                            <i class="fa fa-lock absolute left-3 top-2.5 text-gray-400"></i>
                        </div>
                        <?php if (form_error('password')): ?>
                            <p class="text-sm text-red-600 mt-1"><?= form_error('password') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1" for="captcha">Captcha</label>
                        <div class="flex items-end space-x-2 mb-2">
                            <img id="image_captcha" class="h-[80px] w-full rounded-lg" src="<?= $captchaimg ?>"
                                alt="captcha">
                            <button type="button" id="captcha_refresh"
                                class="text-sm px-2 py-1 border rounded hover:bg-gray-200">
                                <i class="fa fa-sync"></i>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="captcha" id="captcha"
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('captcha') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                placeholder="Captcha">
                            <i class="fa fa-key absolute left-3 top-2.5 text-gray-400"></i>
                        </div>
                        <?php if (form_error('captcha')): ?>
                            <p class="text-sm text-red-600 mt-1"><?= form_error('captcha') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex justify-between text-sm text-blue-800">
                        <a href="<?= $forgot ?>" class="hover:underline">Lupa Kata Sandi?</a>
                        <a href="<?= base_url() ?>" class="hover:underline">Kembali ke Situs</a>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary hover:bg-opacity-95 text-white font-semibold py-2 rounded-lg">
                            Masuk
                        </button>
                    </div>

                    <input type="hidden" name="redirect_back" value="<?= $redirect_back ?>" />
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>">
                </form>
            </div>
            <img src="<?php echo base_url(); ?>assets/app/images/shapes/shape-5.png" alt="curve-bottom"
                class="hidden laptop:block absolute top-[6rem] right-[6rem] z-10 animate-bounce" />

            <img src="<?php echo base_url(); ?>assets/app/images/shapes/shape-8.png" alt="curve-bottom"
                class="hidden laptop:block absolute left-1/4 top-[12rem] z-10" />

            <img src="<?php echo base_url(); ?>assets/app/images/shapes/shape-7.png" alt="curve-bottom"
                class="hidden laptop:block absolute bottom-[12rem] right-[6rem] z-10" />

        </div>

    </div>



    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript">var plugin_path = '<?php echo base_url() ?>assets/app/plugins/';</script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/app/plugins/jquery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/app/js/app.js"></script>
    <script type="text/javascript">
        $("#captcha_refresh").on('click', function () {
            var img = document.querySelector('#image_captcha');
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('auth/auth/refresh_captcha') ?>",
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    img.src = data.image;
                },
                error: function (error) {
                    console.log("failed to get captcha");
                }
            });
        });
    </script>
</body>

</html>