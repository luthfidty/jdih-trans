<header
    class="fixed top-0 left-0 right-0 w-full bg-primary shadow px-4 py-2 flex justify-between items-center z-40 h-16">
    <!-- Kiri: Tombol Toggle + Logo -->
    <div class="flex items-center space-x-4">
        <button @click="collapsed = !collapsed" class="text-white focus:outline-none w-8">
            <i :class="[collapsed ? 'fa fa-bars-staggered' : 'fa fa-bars', 'text-xl']"></i>
        </button>
        <div class="flex items-center space-x-2">
            <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
                src="<?= site_url($this->config->item('site_logo1')) ?>"
                alt="<?= site_url($this->config->item('site_name')) ?>" />
            <img class="h-[32px] w-[32px] desktop:w-[42px] desktop:h-[42px]"
                src="<?= site_url($this->config->item('site_logo2')) ?>"
                alt="<?= site_url($this->config->item('site_name')) ?>" />
        </div>
    </div>

    <!-- User Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
            <img class="w-9 h-9 rounded-full object-cover"
                src="<?php echo $session['image'] ? base_url($session['image']) : base_url("assets/app/images/noavatar.jpg") ?>"
                alt="avatar" />
            <span class="hidden sm:inline text-white font-semibold">
                <?php echo $session['username'] ?> <i class="fa fa-angle-down ml-1"></i>
            </span>
        </button>

        <div x-show="open" @click.away="open = false"
            class="absolute right-0 mt-2 w-48 bg-white border border-secondary rounded-lg shadow-lg z-50 py-2 space-y-1">
            <a href="<?php echo base_url('auth/users/userdetails/' . $session['id']) ?>"
                class="block px-4 py-2 text-gray-700 hover:bg-secondary hover:text-white">
                <i class="fa fa-user mr-2"></i>Profil Akun
            </a>
            <a href="<?php echo base_url('auth/users/account/' . $session['id']) ?>"
                class="block px-4 py-2 text-gray-700 hover:bg-secondary hover:text-white">
                <i class="fa fa-user-secret mr-2"></i>Pengaturan Akun
            </a>
            <hr class="my-1 border-secondary">
            <a href="<?php echo base_url('auth/auth/logout') ?>"
                class="block px-4 py-2 text-red-600 hover:bg-secondary hover:text-white">
                <i class="fa fa-power-off mr-2"></i>Keluar
            </a>
        </div>
    </div>
</header>
<aside :class="collapsed ? 'w-20' : 'w-64'"
    class="bg-primary shadow h-[calc(100vh-4rem)] fixed  top-16 left-0 overflow-y-auto z-30 transition-all duration-200">
    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="<?php echo base_url() ?>" target="new"
                    class="flex items-center p-2 rounded hover:bg-secondary text-white">
                    <i class="fas fa-globe w-5 mr-2"></i>
                    <span x-show="!collapsed" x-transition>Website</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url("app/") ?>"
                    class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "" ? 'bg-secondary font-semibold' : '' ?>">
                    <i class="fas fa-home w-5 mr-2"></i>
                    <span x-show="!collapsed" x-transition>Beranda</span>
                </a>
            </li>
            <?php
            $orderGroups = [
                
                'halaman',
                'media file',
                'galeri',
                'tautan lain',
                'survey',

                '-', // pembatas
                'artikel',
                'kategori artikel',
                '-', // pembatas
                'peraturan',
                'tipe peraturan',
                'kategori peraturan',
                '-', // pembatas
                'non peraturan',
                'kategori non peraturan',
                '-', // pembatas
            ];

            // Urutkan sesuai urutan $orderGroups
            usort($session['menus'], function ($a, $b) use ($orderGroups) {
                $labelA = strtolower(empty($a['alias']) ? $a['name'] : $a['alias']);
                $labelB = strtolower(empty($b['alias']) ? $b['name'] : $b['alias']);

                $posA = array_search($labelA, $orderGroups);
                $posB = array_search($labelB, $orderGroups);

                if ($posA === false)
                    $posA = PHP_INT_MAX;
                if ($posB === false)
                    $posB = PHP_INT_MAX;

                return $posA <=> $posB;
            });

            // Untuk menambahkan garis, kita cari posisi tiap menu di orderGroups
            $groupPositions = [];
            foreach ($session['menus'] as $menu) {
                $label = strtolower(empty($menu['alias']) ? $menu['name'] : $menu['alias']);
                $pos = array_search($label, $orderGroups);
                if ($pos !== false) {
                    $groupPositions[] = $pos;
                }
            }
            ?>

            <?php
            $lastPos = null;
            foreach ($session['menus'] as $m) {
                $label = strtolower(empty($m['alias']) ? $m['name'] : $m['alias']);
                $pos = array_search($label, $orderGroups);

                // Cek apakah perlu garis pembatas
                if ($lastPos !== null && $pos !== false) {
                    // Kalau di $orderGroups ada "-" di antara $lastPos dan $pos
                    for ($i = $lastPos + 1; $i < $pos; $i++) {
                        if (isset($orderGroups[$i]) && $orderGroups[$i] === '-') {
                            echo '<hr class="my-2 border-gray-600">';
                            break;
                        }
                    }
                }
                $lastPos = $pos;
                ?>
                <li>
                    <a href="<?= $m['url'] ?>"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo ucfirst($this->uri->segment(2)) == $m['name'] ? 'bg-secondary font-semibold' : '' ?>">
                        <?= !empty($m['icon']) ? '<i class="fas fa-' . $m['icon'] . ' w-5 mr-2"></i>' : '' ?>
                        <span x-show="!collapsed" x-transition>
                            <?= empty($m['alias']) ? $m['name'] : $m['alias'] ?>
                        </span>
                    </a>
                </li>
            <?php } ?>



        </ul>

        <?php if ($session['role'] == 1) { ?>
            <hr class="my-4 border-gray-300" x-show="!collapsed">
            <ul class="space-y-2">
                <li>
                    <a href="<?php echo base_url() ?>auth/users"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "users" ? 'bg-secondary font-semibold' : '' ?>">
                        <i class="fas fa-users w-5 mr-2"></i>
                        <span x-show="!collapsed" x-transition>Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>auth/roles"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "roles" ? 'bg-secondary font-semibold' : '' ?>">
                        <i class="fas fa-user-check w-5 mr-2"></i>
                        <span x-show="!collapsed" x-transition>Hak Akses</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>auth/routings"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "routings" ? 'bg-secondary font-semibold' : '' ?>">
                        <i class="fas fa-paper-plane w-5 mr-2"></i>
                        <span x-show="!collapsed" x-transition>Akses URL</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>app/navigations"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "navigations" ? 'bg-secondary font-semibold' : '' ?>">
                        <i class="fas fa-th-list w-5 mr-2"></i>
                        <span x-show="!collapsed" x-transition>Navigasi Menu</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>app/settings"
                        class="flex items-center p-2 rounded hover:bg-secondary text-white <?php echo $this->uri->segment(2) == "settings" ? 'bg-secondary font-semibold' : '' ?>">
                        <i class="fas fa-cog w-5 mr-2"></i>
                        <span x-show="!collapsed" x-transition>Pengaturan</span>
                    </a>
                </li>
            </ul>
        <?php } ?>


    </nav>
</aside>