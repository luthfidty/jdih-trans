<?php

/*
 * Ini adalah file helper untuk menangani proses unggahan file.
 * Mengatasi masalah TIME OUT dan MEMORY LIMIT pada file besar dengan ini_set().
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * mapres uploader file helper
 */
if (!function_exists('fileuploader')) {

    function fileuploader($file, $input, $prefixname = NULL, $type = 'jpg|jpeg|png|pdf|svg|ico|gif', $uploadpath = NULL) {

        // --- SOLUSI KRITIS UNTUK TIME OUT DAN MEMORI ---
        // Menaikkan batas waktu eksekusi (3600 detik = 1 jam)
        ini_set('max_execution_time', 3600);
        // Menaikkan waktu maksimal untuk menerima unggahan (KRITIS untuk file besar)
        ini_set('max_input_time', 3600); 
        // Menaikkan batas memori (1 GB, penting untuk memproses file 250MB)
        ini_set('memory_limit', '1024M'); 
        // ------------------------------------------------

        $result = array();
        // initialize config
        $config['upload_path'] = $uploadpath ? $uploadpath : 'public/uploads/' . date("Y") . "/" . date("m");
        $config['allowed_types'] = $type;
        $config['max_size'] = 0; // Mengizinkan ukuran file tak terbatas di level CI (batas di PHP/Nginx)
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['file_name'] = $prefixname . $file[$input]['name'];

        // Memuat dan menginisialisasi library upload
        get_instance()->load->library('upload', $config);
        get_instance()->upload->initialize($config);

        // Membuat direktori jika belum ada
        if (!file_exists($config['upload_path'])) {
            // Memberikan izin 0755 saat membuat folder baru
            mkdir($config['upload_path'], 0755, true); 
        }

        if (!empty($file[$input]['name'])) {
            if (get_instance()->upload->do_upload($input)) {
                $file = array(
                    'filename' => get_instance()->upload->data('file_name'),
                    'filepath' => $config['upload_path'],
                    'fullpath' => $config['upload_path'] . "/" . get_instance()->upload->data('file_name'),
                    'filetype' => get_instance()->upload->data('file_type'),
                );
                $result['message'] = $file;
                $result['status'] = 'success';
            } else {
                $result['status'] = 'error';
                $result['message'] = get_instance()->upload->display_errors();
            }
        }
        return $result;
    }

}

if (!function_exists("file_validation")) {

    function file_validation($file, $type = 'jpg|jpeg|png|pdf') {
        $allowmimes = get_mimes();
        $allowed = explode("|", $type);
        $mime = get_mime_by_extension($_FILES[$file]['name']);
        if (isset($_FILES[$file]['name']) && $_FILES[$file]['name'] != "") {
            foreach ($allowed as $am => $m) {
                if (in_array($m, $allowmimes)) {
                    return true;
                } else {
                    // Perlu memuat form_validation secara manual karena ini Helper
                    if (!isset(get_instance()->form_validation)) {
                        get_instance()->load->library('form_validation');
                    }
                    get_instance()->form_validation->set_message('file_validation', 'Please select only' . str_replace("|", "/", $type), ' file.');
                    return false;
                }
            }
        } else {
             if (!isset(get_instance()->form_validation)) {
                get_instance()->load->library('form_validation');
            }
            get_instance()->form_validation->set_message('file_validation', 'Please choose a file to upload.');
            return false;
        }
    }

}