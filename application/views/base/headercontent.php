<?php
// includes/header.php

$segments = $this->uri->segment_array();

// buang segmen terakhir jika angka
if (!empty($segments) && is_numeric(end($segments))) {
    array_pop($segments);
}

// judul halaman: segmen terakhir yang tersisa, fallback Dashboard
$pageTitle = !empty($segments) ? ucfirst(end($segments)) : 'Dashboard';
if (!empty($segments) && strtolower(end($segments)) === 'app') {
    $pageTitle = 'Beranda';
}
?>
<!-- font Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    .breadcrumb-link {
        text-decoration: underline dotted;
        transition: color .3s;
    }

    .breadcrumb-link:hover {
        color: #fff;
    }
</style>

<header class="mb-6 bg-secondary text-white p-6 rounded-xl shadow-lg fade-in">
    <div class="flex items-center space-x-3">
        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="text-3xl font-bold m-0"><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
    </div>
    <nav class="text-sm mt-2" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <?php
            $built = [];
            $count = count($segments);
            foreach ($segments as $index => $seg) {
                $built[] = $seg;
                $isLast = ($index === $count);

                $label = ucfirst($seg);
                if (strtolower($seg) === 'app') {
                    $label = 'Beranda';
                }
                if (strtolower($seg) === 'auth') {
                    $label = 'Beranda';
                }
                $url = base_url(implode('/', $built));

                if ($index > 1) {
                    echo '<li class="text-blue-100 select-none">/</li>';
                }

                if (!$isLast) {
                    echo '<li>';
                    echo '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" class="breadcrumb-link text-blue-200">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
                    echo '</li>';
                } else {
                    echo '<li aria-current="page" class="text-white font-semibold">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</li>';
                }
            }

            if (empty($segments)) {
                echo '<li class="text-white font-semibold">Beranda</li>';
            }
            ?>
        </ol>
    </nav>
</header>