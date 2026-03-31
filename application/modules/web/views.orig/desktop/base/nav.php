<!-- Header -->
<header id="header" class="shadow-xs bg-green2">
    <!-- topbar -->
    <div class="container position-relative">
        <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit">
            <div class="align-items-start">
                <!-- mobile menu button : show -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg width="25" viewBox="0 0 20 20">
                    <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                    <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                    <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                    <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                    </svg>
                </button>

                <!-- navbar : brand (logo) -->
                <a class="navbar-brand m-0 ms-2" href="<?php echo site_url() ?>">
                    <img src="<?php echo site_url($this->config->item('site_logo1')) ?>" width="100%"  alt="<?php echo $this->config->item('site_name') ?>"/>
                </a>
            </div>
            <div class="d-none d-md-block d-lg-block d-xl-block">
                <p class="fw-bold fs-5"><?php echo $this->config->item('site_description') ?></p>
            </div>

            <div class="align-items-start d-none d-lg-block d-xl-block">
                <!-- mobile menu button : show -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg width="25" viewBox="0 0 20 20">
                    <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                    <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                    <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                    <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                    </svg>
                </button>
                <!-- navbar : brand (logo) -->
                <a class="navbar-brand m-0" href="<?php echo site_url() ?>">
                    <img src="<?php echo site_url($this->config->item('site_logo2')) ?>" width="80%"  alt="<?php echo $this->config->item('site_name') ?>"/>
                </a>
            </div>
        </nav>
    </div>
    <!--/topbar-->
    <!--nav-->
    <div class = "clearfix">
        <!--line-->

        <div class = "container">
            <hr class = "m-0 bg-gray-500 opacity-25">
            <nav class = "navbar navbar-expand-lg navbar-light h-auto justify-content-lg-between justify-content-md-inherit">
                <!--Menu-->
                <div class = "collapse navbar-collapse navbar-animate-fadein" id = "navbarMainNav">
                    <!--navbar : mobile menu-->
                    <div class = "navbar-xs d-none bg-green">
                        <!--mobile menu button : close-->
                        <button class = "navbar-toggler pt-0 border-0" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navbarMainNav" aria-controls = "navbarMainNav" aria-expanded = "false" aria-label = "Toggle navigation">
                            <svg width = "20" viewBox = "0 0 20 20">
                            <path d = "M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                            </svg>
                        </button>
                        <!--
                        Mobile Menu Logo
                        Logo : height: 70px max
                        -->
                        <a class = "navbar-brand" href = "<?php echo site_url() ?>">
                            <img src = "<?php echo site_url($this->config->item('site_logo_mobile')) ?>" width = "110" height = "38" alt = "...">
                        </a>
                    </div>
                    <!--/navbar : mobile menu-->
                    <!--navbar : navigation-->
                    <ul class = "navbar-nav navbar-sm">
                        <?php
                        $confmainmenu = $this->config->item('mainmenu');
                        if (!empty($confmainmenu->menu)) {
                            $menu = json_decode($confmainmenu->menu);
                            foreach ($menu as $m) {
                                $tmpmenu = explode(";", $m->id);
                                if (!$m->children) {
                                    ?>

                                    <li class = "nav-item">
                                        <a class="nav-link " href="<?php echo site_url($tmpmenu[1]) ?>">
                                            <?php echo $tmpmenu[0]; ?>
                                        </a>
                                    </li>
                                <?php } else {
                                    ?>
                                    <li class = "nav-item dropdown">
                                        <a href="<?php echo site_url($tmpmenu[1]) ?>" class = "nav-link dropdown-toggle"  data-bs-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">
                                            <?php echo $tmpmenu[0] ?>
                                        </a>
                                        <ul class = "dropdown-menu dropdown-menu-clean dropdown-menu-hover prefix-link-icon prefix-icon-arrow" >
                                            <?php
                                            foreach ($m->children as $mc) {
                                                $tmpmc = explode(";", $mc->id);
                                                echo '<li class = "dropdown-item"><a class = "dropdown-link" href = "' . site_url($tmpmc[1]) . '">' . $tmpmc[0] . '</a></li>';
                                            }
                                            ?>

                                        </ul>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                    <!--/navbar : navigation-->
                </div>
                <!--desktop social-->

            </nav>
        </div>
        <div class = "container d-none d-lg-block ">
            <hr class = "m-0 bg-gray-500 opacity-25">
            <div class = "row">
                <div class="col-lg-2 col-md-4 mt-2 mb-2"><span class="btn btn-sm p-1 bg-gradient-warning">Berita Terbaru</span></div>
                <div class="col-lg-10 col-md-8 mt-2 mb-2">
                    <marquee class="mt-2">
                        <?php
                        if (!empty($latestpost)) {
                            foreach ($latestpost as $ltp) {
                                echo '<a href="' . site_url('web/posts/read/' . $ltp->slug) . '" class="fw-medium text-dashed text-white me-3">' . $ltp->title . '</a>';
                            }
                        }
                        ?>
                    </marquee>
                </div>
            </div>
        </div>
        <!--/nav-->
</header>
<!--/Header-->