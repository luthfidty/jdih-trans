<?php

$config['query_string_segment'] = 'start';

$config['full_tag_open'] = '<nav aria-label="pagination" class="my-8 "><ul class="flex items-center gap-4 justify-center">';
$config['full_tag_close'] = '</ul></nav>';

$config['first_link'] = '<< Pertama';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Terakhir >>';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Selanjutnya >';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '< Sebelumnya';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li><a class="bg-primary text-white px-4 py-2 rounded-md font-semibold">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

// Tambahkan link class default
$config['attributes'] = ['class' => 'px-4 py-2 rounded-md border text-primary hover:bg-primary transition'];
