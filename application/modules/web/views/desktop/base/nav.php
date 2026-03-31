<header class="shadow bg-primary fixed w-full top-0 z-50">
  <div class="container mx-auto px-4 relative">
    <nav class="flex items-center gap-4  py-4 justify-center w-full">

      <!-- Brand & Mobile Toggle -->
      <div class="flex items-center justify-between w-full laptop:w-auto">
        <!-- Mobile Menu Button -->
        <button class="block laptop:hidden text-white focus:outline-none" type="button" aria-label="Toggle navigation"
          id="mobileMenuToggle">
          <i data-feather="menu"></i>
        </button>

        <!-- Logo -->
        <a class="ml-3 flex items-center gap-2" href="<?php echo site_url() ?>">
          <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
            src="<?php echo site_url($this->config->item('site_logo1')) ?>"
            alt="<?php echo site_url($this->config->item('site_name')) ?>" />
          <img class="h-[32px] 2-[32px] desktop:w-[42px] desktop:h-[42px]"
            src="<?php echo site_url($this->config->item('site_logo2')) ?>"
            alt="<?php echo site_url($this->config->item('site_name')) ?>" />
        </a>
      </div>

      <!-- Desktop Menu (hidden on mobile) -->
      <div class="hidden laptop:block">
        <?php
        $confmainmenu = $this->config->item('mainmenu');
        $current_url = trim(uri_string(), '/'); // buang trailing slash
        $menu = !empty($confmainmenu->menu) ? json_decode($confmainmenu->menu) : [];
        ?>

        <ul class="flex space-x-6 text-white text-lg laptop:text-base">
          <?php


          if (!empty($confmainmenu->menu)) {
            foreach ($menu as $m) {
              $tmpmenu = explode(";", $m->id);
              $menu_url = trim($tmpmenu[1], '/'); // pastikan tanpa slash
          
              // Cek apakah current URL mengandung menu_url di awal
               $is_active = ($menu_url === '' && $current_url === '') || ($menu_url !== '' && strpos($current_url, $menu_url) === 0)
          ? 'font-semibold text-secondary'
          : 'hover:text-secondary';

              if (!$m->children) {
                ?>
                <li>
                  <a class="block py-3 <?php echo $is_active; ?>" href="<?php echo site_url($menu_url); ?>">
                    <?php echo $tmpmenu[0]; ?>
                  </a>
                </li>
                <?php
              } else {
                $child_active = false;
                foreach ($m->children as $mc) {
                  $tmpmc = explode(";", $mc->id);
                  $child_url = trim($tmpmc[1], '/');
                  if (strpos($current_url, $child_url) === 0) {
                    $child_active = true;
                    break;
                  }
                }

                // ✅ Tambahkan logika ini
                $is_parent_active = ($menu_url !== '' && strpos($current_url, $menu_url) === 0);

                $parent_active = ($child_active || $is_parent_active)
                  ? 'font-semibold text-secondary'
                  : 'hover:text-secondary';
                ?>
                <li class="relative group">
                  <?php
                  $clean_url = trim($menu_url);
                  if ($clean_url !== '' && $clean_url !== '#' && $clean_url !== '/' && $clean_url !== 'javascript:void(0)'):
                    ?>
                    <a class="flex items-center gap-2 py-3 <?php echo $parent_active; ?>"
                      href="<?php echo site_url($menu_url); ?>">
                      <?php echo $tmpmenu[0]; ?>
                      <i data-feather="chevron-down"></i>
                    </a>
                  <?php else: ?>
                    <span class="flex items-center gap-2 py-3 cursor-pointer <?php echo $parent_active; ?>">
                      <?php echo $tmpmenu[0]; ?>
                      <i data-feather="chevron-down"></i>
                    </span>
                  <?php endif; ?>



                 <ul
  class="absolute left-0 mt-2 w-48 bg-white border rounded-lg shadow-lg invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 z-50 text-gray-800 overflow-y-auto"
  style="top: 100%; max-height: 250px;">
  <?php
  foreach ($m->children as $mc) {
    $tmpmc = explode(";", $mc->id);
    $child_url = trim($tmpmc[1], '/');
    $child_is_active = (strpos($current_url, $child_url) === 0)
      ? 'text-secondary font-semibold'
      : 'hover:text-secondary';
    echo '<li><a class="block px-4 py-2 ' . $child_is_active . '" href="' . site_url($tmpmc[1]) . '">' . $tmpmc[0] . '</a></li>';
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
      </div>
    </nav>
  </div>

  <!-- Mobile Menu (hidden on desktop) -->
  <div id="navbarMobileMenu" class="fixed inset-0 bg-primary z-50 hidden flex-col p-6  laptop:hidden">

    <!-- Tombol close sticky di atas -->
    <div class="sticky top-0 bg-primary flex justify-between items-center mb-6 p-4 z-50">
      <div class="flex items-center gap-2">
        <img class="h-[32px]" src="<?php echo site_url($this->config->item('site_logo1')) ?>"
          alt="<?php echo site_url($this->config->item('site_name')) ?>" />
        <img class="h-[32px]" src="<?php echo site_url($this->config->item('site_logo2')) ?>"
          alt="<?php echo site_url($this->config->item('site_name')) ?>" />
      </div>
      <button id="mobileMenuClose" class="text-white text-3xl font-bold focus:outline-none"
        aria-label="Close navigation menu">&times;</button>
    </div>
    <?php
    $confmainmenu = $this->config->item('mainmenu');
    $current_url = trim(uri_string(), '/'); // buang trailing slash
    $menu = !empty($confmainmenu->menu) ? json_decode($confmainmenu->menu) : [];
    ?>

    <!-- Konten menu scrollable -->
    <ul class="flex flex-col text-white text-lg overflow-y-auto" style="max-height: calc(100vh - 80px);">
      <?php foreach ($menu as $m): ?>
        <?php

        $tmpmenu = explode(";", $m->id);
        $menu_url = trim($tmpmenu[1], '/');

        $is_active = ($menu_url === '' && $current_url === '') || ($menu_url !== '' && strpos($current_url, $menu_url) === 0)
          ? 'font-semibold text-secondary'
          : 'hover:text-secondary';
        ?>

        <?php if (empty($m->children)): ?>
          <li>
            <a class="block py-3 <?= $is_active ?>" href="<?= site_url($menu_url) ?>">
              <?= $tmpmenu[0] ?>
            </a>
          </li>
        <?php else: ?>
          <?php
          $child_active = false;
          foreach ($m->children as $mc) {
            $tmpmc = explode(";", $mc->id);
            $child_url = trim($tmpmc[1], '/');
            if (strpos($current_url, $child_url) === 0) {
              $child_active = true;
              break;
            }
          }

          // ✅ Tambahkan logika ini
          $is_parent_active = ($menu_url !== '' && strpos($current_url, $menu_url) === 0);

          $parent_active = ($child_active || $is_parent_active)
            ? 'font-semibold text-secondary'
            : 'hover:text-secondary';
          ?>

          <li>
            <?php
            $clean_url = trim($menu_url);
            if ($clean_url !== '' && $clean_url !== '#' && $clean_url !== '/' && $clean_url !== 'javascript:void(0)'):
              ?>
              <a class="block py-3 <?= $parent_active ?>" href="<?= site_url($menu_url) ?>">
                <?= $tmpmenu[0] ?>
              </a>
            <?php else: ?>
              <span class="block py-3 <?= $parent_active ?>">
                <?= $tmpmenu[0] ?>
              </span>
            <?php endif; ?>

            <ul class="pl-4">
              <?php foreach ($m->children as $mc): ?>
                <?php
                $tmpmc = explode(";", $mc->id);
                $child_url = trim($tmpmc[1], '/');
                $child_is_active = (strpos($current_url, $child_url) === 0)
                  ? 'text-secondary font-semibold'
                  : 'hover:text-secondary';
                ?>
                <li>
                  <a class="block py-2 <?= $child_is_active ?>" href="<?= site_url($tmpmc[1]) ?>">
                    <?= $tmpmc[0] ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

  </div>

</header>

<script>
  const toggleBtn = document.getElementById('mobileMenuToggle');
  const closeBtn = document.getElementById('mobileMenuClose');
  const mobileMenu = document.getElementById('navbarMobileMenu');

  toggleBtn.addEventListener('click', () => {
    mobileMenu.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // disable scroll saat menu mobile buka
  });

  closeBtn.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    document.body.style.overflow = ''; // enable scroll saat menu mobile tutup
  });
</script>