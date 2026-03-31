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


<body class="font-opensans">

    <div class="min-h-screen flex flex-col laptop:flex-row w-full">
        <!-- Kiri: Background Hero -->
        <div class="hidden laptop:block laptop:w-8/12 bg-cover bg-center" style="background: url('<?php echo base_url(); ?>assets/app/images/bglogin.jpg'); background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;">
        </div>


        <div class="w-full laptop:w-4/12 flex items-center justify-center  p-6 relative">

            <div class="w-full max-w-md bg-white rounded-xl  space-y-6 z-20">
                <!-- login form -->
                <form action="<?= $action ?>" method="post" class="space-y-4 ">
                    <div class="flex items-center gap-4">
                        <div class="text-center flex items-center gap-2 justify-center">
                            <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
                                src="<?= site_url($this->config->item('site_logo1')) ?>"
                                alt="<?= site_url($this->config->item('site_name')) ?>" />
                            <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
                                src="<?= site_url($this->config->item('site_logo2')) ?>"
                                alt="<?= site_url($this->config->item('site_name')) ?>" />
                        </div>
                        <div class="flex flex-col items-start">
                            <h2 class="text-2xl tablet:text-3xl laptop:text-4xl font-bold text-gray-700">
                                JDIH
                            </h2>
                            <p class="text-sm text-gray-600">
                                Jaringan Dokumentasi dan Informasi Hukum
                            </p>
                        </div>
                    </div>

                    <!-- <?php if ($this->session->userdata('message') != ''): ?>
                        <?php $msg = $this->session->userdata('message'); ?>
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center">
                            <strong><?= $msg['message'] ?></strong>
                        </div>
                    <?php endif; ?> -->

                    <?php switch ($step):
                        case 1: ?>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Email Pengguna</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email"
                                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                        placeholder="Email Pengguna">
                                    <i class="fa fa-envelope absolute left-3 top-2.5 text-gray-400"></i>
                                </div>
                                <?php if (form_error('email')): ?>
                                    <p class="text-sm text-red-600 mt-1"><?= form_error('email') ?></p>
                                <?php endif; ?>
                            </div>
                            <?php break; ?>

                        <?php case 2: ?>
                            <div class="mb-4">
                                <p class="text-sm text-yellow-800 bg-yellow-100 border border-yellow-300 px-3 py-2 rounded">
                                    Gunakan kombinasi huruf besar, kecil, angka. Minimal 8 karakter.
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password" name="newpassword" id="newpassword"
                                        onkeyup="passwordstrength(this.value)"
                                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('newpassword') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                        placeholder="Kata Sandi Baru">
                                    <i class="fa fa-key absolute left-3 top-2.5 text-gray-400"></i>
                                </div>
                                <span id="alertpass" class="text-sm text-green-600 hidden mt-1"></span>
                                <?php if (form_error('newpassword')): ?>
                                    <p class="text-sm text-red-600 mt-1"><?= form_error('newpassword') ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input type="password" name="confpassword" id="confpassword"
                                        onkeyup="confirmsame(this.value)"
                                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 <?= form_error('confpassword') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' ?>"
                                        placeholder="Konfirmasi Kata Sandi">
                                    <i class="fa fa-key absolute left-3 top-2.5 text-gray-400"></i>
                                </div>
                                <span id="alertsame" class="text-sm text-green-600 hidden mt-1"></span>
                                <?php if (form_error('confpassword')): ?>
                                    <p class="text-sm text-red-600 mt-1"><?= form_error('confpassword') ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4 text-sm text-gray-600">
                                <label><input type="checkbox" onchange="showpassword()" /> Lihat Kata Sandi</label>
                            </div>

                            <div class="mb-4">
                                <p id="alerterror" class="text-sm text-red-600 hidden"></p>
                            </div>

                            <input type="hidden" name="username" value="<?= $user->username ?>" />
                            <input type="hidden" name="useremail" value="<?= $user->email ?>" />
                            <input type="hidden" name="userresetkey" value="<?= $user->resetkey ?>" />
                            <?php break; ?>
                    <?php endswitch; ?>

                    <div class="flex justify-between text-sm text-blue-800">
                        <a href="<?= base_url() ?>" class="hover:underline">Kembali ke Situs</a>
                        <a href="<?= base_url('app') ?>" class="hover:underline">Kembali ke Halaman Masuk</a>
                    </div>

                    <?php if ($stepbtn != 0): ?>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-opacity-90 text-white font-semibold py-2 rounded-lg">
                            Atur Ulang
                        </button>
                    <?php endif; ?>

                    <input type="hidden" name="step" value="<?= $step ?>" />
                    <input type="hidden" name="redirect_back" value="<?= $redirect_back ?>" />
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>" />
                </form>

                <!-- /login form -->

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
        function checkpwd(pwd) {
            var regularExpression = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{8,})");
            var valid = regularExpression.test(pwd);
            console.log(valid);
            return valid;
        }
        function passwordstrength(val) {
            if (!checkpwd(val)) {
                $("#alerterror").html('Kata sandi kurang dari 8 karakter / Tanpa Kapital/Angka');
                $("#alertpass").hide();
                $("#alerterror").show();
            } else {
                $("#alertpass").html('<i class="fa fa-check"></i>');
                $("#alertpass").addClass('alert-success');
                $("#alertpass").show();
                $("#alerterror").hide();
            }
        }
        function showpassword() {
            var p1 = document.getElementById("newpassword");
            var p2 = document.getElementById("confpassword");
            if (p1.type === 'password' && p2.type === 'password') {
                p1.type = 'text';
                p2.type = 'text';
            } else {
                p1.type = 'password';
                p2.type = 'password';
            }
        }
        function confirmsame(val) {
            var pass = $("#newpassword").val();
            if (pass !== val) {
                $("#alerterror").html('Kata sandi tidak sama');
                $("#alerterror").show();
            } else {
                $("#alertsame").html('<i class="fa fa-check"></i>');
                $("#alertsame").removeClass('alert-warning');
                $("#alertsame").addClass('alert-success');
                $("#alerterror").hide();
                $("#alertsame").show();
            }
        }

        $(function () {
            $("#alertsame").hide();
            $("#alertpass").hide();
            $("#alerterror").hide();
        }
        );
    </script>
</body>

</html>