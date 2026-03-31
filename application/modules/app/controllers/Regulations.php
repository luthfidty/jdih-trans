<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Regulations extends MY_Controller
{

    static $isPublished = array(1 => 'Publish', 2 => 'Draft', 3 => 'Archive', 4 => 'Pending', 5 => 'Reject');
    static $isStatus = array(1 => 'Berlaku', 2 => 'Tidak Berlaku', 3 => 'Dicabut', 4 => 'Mencabut', 5 => 'Diubah', 6 => 'Mengubah');
    public $where;

    function __construct()
    {
        parent::__construct();
        $is_chunk_upload = ($this->uri->segment(3) === 'chunk_upload_action');

        // Hanya lakukan Auth jika bukan permintaan chunk upload AJAX
        if (!$is_chunk_upload) {
            parent::_auth($this->uri->uri_string());
        } else {
            // Jika ini chunk upload, kita perlu memuat session/rolelist secara manual 
            // jika _auth() tidak dijalankan, tetapi kita tetap perlu memastikan user login!
            $this->sess = $this->session->logged_in;
            // Kita ASUMSIKAN session sudah ada saat permintaan AJAX dikirim. 
            // Jika tidak, Anda mungkin harus membuat fungsi auth ringan di sini.
            if (empty($this->sess['id'])) {
                // Jika tidak ada session, kirim JSON error secara manual, JANGAN redirect.
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized Access.']));
                // Matikan eksekusi setelah mengirim error
                exit();
            }
        }
        $this->sess = $this->session->logged_in;
        $this->rolelist = $this->sess['rolelist'][ucfirst($this->uri->segment(2))];
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Documenttypes_model');
        $this->load->library('form_validation');

        // Remove the restriction by setting a neutral where condition
        $this->where = array('regulations.createdby>=' => 0);
    }
    /**
     * Mencari counter tertinggi dan menentukan nama file unik berikutnya (_1, _2, dst.)
     * @param string $final_dir Direktori tempat file disimpan.
     * @param string $base_filename_placeholder Nama file dasar yang dikirim dari JS (tanpa counter).
     * @return string Nama file final yang unik.
     */
    // private function get_next_counter_filename($final_dir, $base_filename_placeholder)
    // {
    //     // Pisahkan nama dasar dan ekstensi
    //     $file_parts = pathinfo($base_filename_placeholder);
    //     $base_name_clean = $file_parts['filename'];
    //     $extension = $file_parts['extension'] ?? 'pdf';

    //     // Pattern RegEx untuk mencari file yang cocok: baseName, diikuti opsional _[angka], dan diakhiri ekstensi.
    //     $escaped_base_name = preg_quote($base_name_clean, '/');

    //     // Pola mencari nama dasar diikuti opsional underscore dan angka (_\d+) atau tanpa apa-apa di akhir
    //     $pattern = '/^' . $escaped_base_name . '(_\d+)?\.' . preg_quote($extension) . '$/i';

    //     $max_counter = 0;
    //     $found_base_file = false;

    //     if (is_dir($final_dir)) {
    //         $files = scandir($final_dir);
    //         if ($files) {
    //             foreach ($files as $file) {
    //                 if (preg_match($pattern, $file, $matches)) {
    //                     $found_base_file = true;
    //                     // $matches[1] akan berisi '_1', '_2', atau string kosong jika tanpa counter.
    //                     $current_counter = 0;
    //                     if (isset($matches[1]) && !empty($matches[1])) {
    //                         $current_counter = (int) substr($matches[1], 1); // Ambil angka setelah underscore
    //                     }
    //                     $max_counter = max($max_counter, $current_counter);
    //                 }
    //             }
    //         }
    //     }

    //     // Jika tidak ditemukan file sama sekali, kita pakai nama dasar tanpa counter.
    //     if (!$found_base_file) {
    //         return $base_name_clean . '.' . $extension; // Nama dasar
    //     }

    //     // Jika ditemukan file (nama dasar, atau _1, dst.), kita gunakan counter berikutnya
    //     $next_counter = $max_counter + 1;

    //     // Counter berikutnya: _1, _2, _3, dst.
    //     $counter_suffix = '_' . $next_counter;

    //     return $base_name_clean . $counter_suffix . '.' . $extension;
    // }


    public function chunk_upload_action()
    {
        ob_start();
        set_time_limit(0);

        $response = ['status' => 'error', 'message' => 'Permintaan tidak valid.'];

        if ($this->input->method() !== 'post' || empty($_FILES['chunk']['name'])) {
            goto cleanup_and_return;
        }

        $chunk = $_FILES['chunk'];
        $unique_id = $this->input->post('resumableIdentifier', TRUE);
        $chunk_number = (int) $this->input->post('resumableChunkNumber', TRUE);
        $total_chunks = (int) $this->input->post('resumableTotalChunks', TRUE);
        $filename_original = $this->input->post('resumableFilename', TRUE);
        $file_target = $this->input->post('fileTarget', TRUE);

        if (empty($unique_id) || empty($filename_original) || empty($file_target) || $chunk_number < 1 || $total_chunks < 1) {
            log_message('error', 'Chunk upload gagal: Data tidak lengkap.');
            $response = ['status' => 'error', 'message' => 'Data upload tidak lengkap.'];
            goto cleanup_and_return;
        }

        $temp_dir = FCPATH . 'public/temp_chunks/' . $unique_id . '/';
        $chunk_path = $temp_dir . $chunk_number;

        if (!is_dir($temp_dir) && !mkdir($temp_dir, 0755, TRUE)) {
            $response = ['status' => 'error', 'message' => 'Gagal membuat direktori sementara.'];
            goto cleanup_and_return;
        }

        if (!move_uploaded_file($chunk['tmp_name'], $chunk_path)) {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan chunk.'];
            goto cleanup_and_return;
        }

        // Cek MIME hanya di chunk pertama
        if ($chunk_number === 1) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $chunk_path);
            finfo_close($finfo);
            if ($mime !== 'application/pdf') {
                @unlink($chunk_path);
                $this->cleanup_temp_dir($temp_dir);
                $response = ['status' => 'error', 'message' => 'Hanya file PDF yang diizinkan.'];
                goto cleanup_and_return;
            }
        }

        // Jika chunk terakhir → gabungkan & overwrite
        if ($chunk_number == $total_chunks) {
            $final_dir = FCPATH . 'public/documents/';
            if (!is_dir($final_dir) && !mkdir($final_dir, 0755, TRUE)) {
                $response = ['status' => 'error', 'message' => 'Gagal membuat direktori dokumen.'];
                goto cleanup_and_return;
            }

            $final_filename = basename($filename_original);
            $final_file_path = $final_dir . $final_filename;

            // Hapus file lama dengan paksa (brutal tapi pasti berhasil)
            if (file_exists($final_file_path)) {
                @chmod($final_file_path, 0777);
                @unlink($final_file_path);
                clearstatcache();
            }

            $out_file = fopen($final_file_path, 'wb');
            if (!$out_file) {
                $response = ['status' => 'error', 'message' => 'Gagal menulis file. Periksa izin folder documents.'];
                goto cleanup_and_return;
            }

            $merge_success = true;
            for ($i = 1; $i <= $total_chunks; $i++) {
                $in_path = $temp_dir . $i;
                if (!file_exists($in_path)) {
                    $merge_success = false;
                    break;
                }
                $in_file = fopen($in_path, 'rb');
                if ($in_file) {
                    while ($buff = fread($in_file, 4096)) {
                        fwrite($out_file, $buff);
                    }
                    fclose($in_file);
                    @unlink($in_path);
                } else {
                    $merge_success = false;
                    break;
                }
            }
            fclose($out_file);

            // Set permission aman untuk overwrite berikutnya
            @chmod($final_file_path, 0664);
            clearstatcache();

            if ($merge_success && file_exists($final_file_path) && filesize($final_file_path) > 0) {
                $this->cleanup_temp_dir($temp_dir);

                // Cache buster: tambah timestamp agar browser selalu ambil file baru
                $cache_buster = time();

                $file_data = [
                    'fullpath' => 'public/documents/' . $final_filename . '?v=' . $cache_buster,
                    'filepath' => 'public/documents/',
                    'filename' => $final_filename,
                    'raw_filename' => $final_filename,        // untuk simpan ke DB
                    'filetype' => 'application/pdf',
                    'cache_buster' => $cache_buster
                ];

                $response = [
                    'status' => 'success',
                    'message' => "File berhasil diganti: {$final_filename}",
                    'file_data' => $file_data,
                    'file_target' => $file_target
                ];
            } else {
                @unlink($final_file_path);
                $response = ['status' => 'error', 'message' => 'Gagal menggabungkan file.'];
            }
        } else {
            $response = [
                'status' => 'success',
                'message' => "Chunk $chunk_number dari $total_chunks disimpan."
            ];
        }

        cleanup_and_return:
        $output = ob_get_clean();
        if (!empty($output)) {
            log_message('error', 'Unexpected output: ' . substr($output, 0, 500));
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

        return;
    }

    // Optional: fungsi cleanup (pastikan ada di controller)
    private function cleanup_temp_dir($dir)
    {
        if (is_dir($dir)) {
            array_map('unlink', glob($dir . '*'));
            @rmdir($dir);
        }
    }
    // Pastikan tidak ada karakter atau spasi di bawah tag penutup PHP ini
    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $category = urldecode($this->input->get('category', TRUE));
        $doctype = urldecode($this->input->get('doctype', TRUE));
        $year = urldecode($this->input->get('year', TRUE));
        $assignmentdate_from = urldecode($this->input->get('assignmentdate_from', TRUE));
        $assignmentdate_to = urldecode($this->input->get('assignmentdate_to', TRUE));
        $status = urldecode($this->input->get('status', TRUE));
        $published = urldecode($this->input->get('published', TRUE));
        $publish_jdihn = urldecode($this->input->get('publish_jdihn', TRUE));
        
        $per_page_input = $this->input->get('per_page', TRUE);
        $per_page = $per_page_input ? intval($per_page_input) : 10;
        $start = intval($this->input->get('start'));
        $sort_by = $this->input->get('sort_by', TRUE) ?: 'regulations.id';
        $sort_order = $this->input->get('sort_order', TRUE) === 'asc' ? 'asc' : 'desc';

        $allowed_per_page = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed_per_page)) {
            $per_page = 10;
        }

        $url_params = [];
        
        // Kumpulkan SEMUA parameter query yang mungkin diset, 
        // termasuk yang bernilai kosong, agar base URL pagination konsisten.
        if ($q !== NULL && $q !== '')
            $url_params['q'] = urlencode($q);
        if ($category !== NULL && $category !== '')
            $url_params['category'] = urlencode($category);
        if ($doctype !== NULL && $doctype !== '')
            $url_params['doctype'] = urlencode($doctype);
        if ($year !== NULL && $year !== '')
            $url_params['year'] = urlencode($year);
        if ($assignmentdate_from !== NULL && $assignmentdate_from !== '')
            $url_params['assignmentdate_from'] = urlencode($assignmentdate_from);
        if ($assignmentdate_to !== NULL && $assignmentdate_to !== '')
            $url_params['assignmentdate_to'] = urlencode($assignmentdate_to);
        if ($status !== NULL && $status !== '')
            $url_params['status'] = urlencode($status);
        if ($published !== NULL && $published !== '')
            $url_params['published'] = urlencode($published);
        if ($publish_jdihn !== NULL && $publish_jdihn !== '')
            $url_params['publish_jdihn'] = urlencode($publish_jdihn);
            
        // Per_page, sort_by, dan sort_order harus diset jika tidak default
        if ($per_page !== 10)
            $url_params['per_page'] = $per_page;
        if ($sort_by !== 'regulations.id')
            $url_params['sort_by'] = $sort_by;
        if ($sort_order !== 'desc')
            $url_params['sort_order'] = $sort_order;

        $base_url = base_url() . 'app/regulations/index' . ($url_params ? '?' . http_build_query($url_params) : '');
        $config['base_url'] = $base_url;
        $config['first_url'] = $base_url;

        $key = $q;

        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;

        $conditions = array('regulations.isdeleted' => 0);
        if ($category !== '')
            $conditions['regulations.documentcategory'] = $category;
        if ($doctype !== '')
            $conditions['regulations.doctype'] = $doctype;
        if ($year !== '')
            $conditions['regulations.year'] = $year;
        if ($assignmentdate_from !== '')
            $conditions['regulations.assignmentdate >='] = $assignmentdate_from;
        if ($assignmentdate_to !== '')
            $conditions['regulations.assignmentdate <='] = $assignmentdate_to;
        if ($status !== '')
            $conditions['regulations.status'] = $status;
        if ($published !== '')
            $conditions['regulations.published'] = $published;
        if ($publish_jdihn !== '')
            $conditions['regulations.publish_jdihn'] = $publish_jdihn;

        $config['total_rows'] = $this->Regulations_model->total_rows($this->where, $key, $conditions);
        $regulation = $this->Regulations_model->get_limit_data($this->where, $config['per_page'], $start, $key, $conditions, $sort_by, $sort_order);
        $doccategory = $this->Documentcategories_model->get_all();
        $doctypes = $this->Documenttypes_model->get_all();
        $years = $this->Regulations_model->get_years();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'regulations_data' => $regulation,
            'doccategory' => $doccategory,
            'doctypes' => $doctypes,
            'years' => $years,
            'q' => $q,
            'category' => $category,
            'doctype' => $doctype,
            'year' => $year,
            'assignmentdate_from' => $assignmentdate_from,
            'assignmentdate_to' => $assignmentdate_to,
            'status' => $status,
            'published' => $published,
            'publish_jdihn' => $publish_jdihn,
            'per_page' => $per_page,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'sort_by' => $sort_by,
            'sort_order' => $sort_order,
            'isStatus' => self::$isStatus,
            'isPublished' => self::$isPublished,
            'template' => 'regulations/regulations_list',
        );
        $this->load->view('base/content', $data);
    }
    public function bulk_delete()
    {
        if (!in_array('delete', $this->rolelist)) {
            $this->session->set_flashdata('message', 'Anda tidak memiliki izin untuk menghapus data!');
            return redirect(site_url('app/regulations'));
        }

        $ids = $this->input->post('ids', TRUE);

        if (!is_array($ids) || empty($ids)) {
            $this->session->set_flashdata('message', 'Tidak ada data yang dipilih untuk dihapus!');
            return redirect(site_url('app/regulations'));
        }

        $ids = array_map('intval', $ids);
        $deleted_count = 0;
        $failed_ids = [];

        foreach ($ids as $id) {
            // Ambil hanya data yang belum dihapus
            $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 0));

            if ($row) {
                $this->Regulations_model->update($row->id, array('isdeleted' => 1, 'published' => 'Draft'));
                $deleted_count++;
            } else {
                $failed_ids[] = $id;
            }
        }

        if ($deleted_count > 0) {
            $this->session->set_flashdata('message', $deleted_count . ' data berhasil dihapus!');
        } else {
            $this->session->set_flashdata('message', 'Gagal menghapus data. Pastikan data tersedia dan belum dihapus!');
        }

        if (!empty($failed_ids)) {
            $this->session->set_flashdata('message', $this->session->flashdata('message') . ' Gagal menghapus ID: ' . implode(', ', $failed_ids));
        }

        return redirect(site_url('app/regulations'));
    }
    public function bulk_publish()
    {
        if (!in_array('update', $this->rolelist)) {
            $this->session->set_flashdata('message', 'Anda tidak memiliki izin untuk mempublikasikan data!');
            return redirect(site_url('app/regulations/pending'));
        }

        $ids = $this->input->post('ids', TRUE);

        if (!is_array($ids) || empty($ids)) {
            $this->session->set_flashdata('message', 'Tidak ada data yang dipilih untuk dipublikasikan!');
            return redirect(site_url('app/regulations/pending'));
        }

        $ids = array_map('intval', $ids);
        $updated_count = 0;
        $failed_ids = [];

        foreach ($ids as $id) {
            $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 0, 'regulations.published' => 'Pending'));

            if ($row) {
                $data = array(
                    'published' => 'Publish',
                    'publishdate' => date('Y-m-d H:i:s'),
                    'updatedat' => date('Y-m-d H:i:s'),
                    'updatedby' => $this->sess['id'],
                    'reason' => null // Clear reason field
                );
                $this->Regulations_model->update($id, $data);
                $updated_count++;
            } else {
                $failed_ids[] = $id;
            }
        }

        if ($updated_count > 0) {
            $this->session->set_flashdata('message', $updated_count . ' data berhasil dipublikasikan!');
        } else {
            $this->session->set_flashdata('message', 'Gagal mempublikasikan data. Pastikan data tersedia dan berstatus Pending!');
        }

        if (!empty($failed_ids)) {
            $this->session->set_flashdata('message', $this->session->flashdata('message') . ' Gagal mempublikasikan ID: ' . implode(', ', $failed_ids));
        }

        log_message('debug', 'Redirecting to app/regulations/pending after bulk_publish');
        return redirect(site_url('app/regulations/pending'));
    }
    public function pending()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $year = urldecode($this->input->get('year', TRUE));
        $per_page = $this->input->get('per_page', TRUE) ? intval($this->input->get('per_page', TRUE)) : 10;
        $start = intval($this->input->get('start'));
        $sort_by = $this->input->get('sort_by', TRUE) ?: 'regulations.id'; // Default sort by ID
        $sort_order = $this->input->get('sort_order', TRUE) === 'asc' ? 'asc' : 'desc'; // Default DESC

        // Validate per_page
        $allowed_per_page = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed_per_page)) {
            $per_page = 10;
        }

        // Build base URL for pagination
        $url_params = [];
        if ($q !== '')
            $url_params['q'] = urlencode($q);
        if ($year !== '')
            $url_params['year'] = urlencode($year);
        if ($per_page !== 10)
            $url_params['per_page'] = $per_page;
        if ($sort_by !== 'regulations.id')
            $url_params['sort_by'] = $sort_by;
        if ($sort_order !== 'desc')
            $url_params['sort_order'] = $sort_order;

        $base_url = base_url() . 'app/regulations/pending' . ($url_params ? '?' . http_build_query($url_params) : '');
        $config['base_url'] = $base_url;
        $config['first_url'] = $base_url;

        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;

        // Combine conditions for pending regulations
        $conditions = array(
            'regulations.isdeleted' => 0,
            'regulations.published' => 'Pending'
        );
        if ($year !== '')
            $conditions['regulations.year'] = $year;

        $config['total_rows'] = $this->Regulations_model->total_rows($this->where, $q, $conditions);
        $regulation = $this->Regulations_model->get_limit_data($this->where, $config['per_page'], $start, $q, $conditions, $sort_by, $sort_order);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'regulations_data' => $regulation,
            'q' => $q,
            'year' => $year,
            'per_page' => $per_page,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'sort_by' => $sort_by,
            'sort_order' => $sort_order,
            'template' => 'regulations/regulations_pending',
        );
        $this->load->view('base/content', $data);
    }

    public function read($id)
    {
        $row = $this->Regulations_model->get_by_id($id);

        if ($row) {
            $data = array(
                'id' => $row->id,
                'title' => $row->title,
                'documentcategory' => $row->category,
                'documenttype' => $row->documenttype,
                'doctype' => $row->doctype,
                'teu' => $row->teu,
                'regulationnumber' => $row->regulationnumber,
                'year' => $row->year,
                'assignmentplace' => $row->assignmentplace,
                'assignmentdate' => $row->assignmentdate,
                'approvaldate' => $row->approvaldate,
                'effectivedate' => $row->effectivedate,
                'location' => $row->location,
                'source' => $row->source,
                'language' => $row->language,
                'legalfield' => $row->legalfield,
                'subject' => $row->subject,
                'cluster' => $row->cluster,
                'status' => $row->status,
                'detailstatus' => $row->detailstatus,
                'viewed' => $row->viewed,
                'downloaded' => $row->downloaded,
                'abstractfile' => json_decode($row->abstractfile),
                'abstract' => json_decode($row->abstract),
                'attachment' => json_decode($row->attachment),
                'published' => $row->published,
                'publishdate' => $row->publishdate,
                'reason' => $row->reason,
                'createdat' => $row->createdat,
                'createdby' => $row->createdby,
                'updatedat' => $row->updatedat,
                'updatedby' => $row->updatedby,
                'username' => $row->username,
                'fullname' => $row->fullname,
                'userupdate' => $row->userupdate,
                'fullnameupdate' => $row->fullnameupdate,
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'isPublished' => self::$isPublished,
                'isStatus' => self::$isStatus,
                'publish_jdihn' => $row->publish_jdihn, // <-- FIELD BARU
                'template' => 'regulations/regulations_read',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations'));
        }
    }

    public function create()
    {
        $dcdata = $this->Documentcategories_model->get_all();
        $doctype = $this->Documenttypes_model->get_all();
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('app/regulations/create_action'),
            'id' => set_value('id'),
            'title' => set_value('title'),
            'documentcategory' => set_value('documentcategory'),
            'doctype' => set_value('doctype'),
            'teu' => set_value('teu'),
            'regulationnumber' => set_value('regulationnumber'),
            'year' => set_value('year'),
            'assignmentplace' => set_value('assignmentplace'),
            'assignmentdate' => set_value('assignmentdate'),
            'approvaldate' => set_value('approvaldate'),
            'effectivedate' => set_value('effectivedate'),
            'location' => set_value('location'),
            'source' => set_value('source'),
            'language' => set_value('language'),
            'legalfield' => set_value('legalfield'),
            'subject' => set_value('subject'),
            'cluster' => set_value('cluster'),
            'status' => set_value('status'),
            'detailstatus' => set_value('detailstatus'),
            'abstract' => set_value('abstract'),
            'abstractfile' => set_value('abstractfile'),
            'attachment' => set_value('attachment'),
            'published' => set_value('published'),
            'publishdate' => set_value('publishdate'),
            'reason' => set_value('reason'),
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'dcdata' => $dcdata,
            'docstype' => $doctype,
            'isPublished' => self::$isPublished,
            'isStatus' => self::$isStatus,
            'curAbstractfile' => set_value('curAbstracfile'),
            'curAttachment' => set_value('curAttachment'),
            'publish_jdihn' => set_value('publish_jdihn', '0'), // <-- FIELD BARU (Default 0/False)
            'template' => 'regulations/regulations_form',
            'extrajs' => 'regulations/regulations_form_extrajs',

        );
        $this->load->view('base/content', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            //$this->create();
            echo validation_errors();
        } else {
            $uuid = $this->uuid->v4();
            $abstract_file_json = $this->input->post('abstractfile_json', TRUE);
            $attachment_json = $this->input->post('attachment_json', TRUE);

            $abstract = !empty($abstract_file_json) ? json_decode($abstract_file_json, TRUE) : array();
            $attachment = !empty($attachment_json) ? json_decode($attachment_json, TRUE) : array();

            // Generate Slug
            $slug = url_title($this->input->post('title'), "-", TRUE) . "-" . $this->input->post('regulationnumber', TRUE) . "-" . $this->input->post('year', TRUE);

            $data = array(
                'groups' => 'regulation',
                'title' => $this->input->post('title', TRUE),
                'slug' => $slug,
                'documentcategory' => $this->input->post('documentcategory', TRUE),
                'doctype' => $this->input->post('doctype', TRUE),
                'teu' => $this->input->post('teu', TRUE),
                'regulationnumber' => $this->input->post('regulationnumber', TRUE),
                'year' => $this->input->post('year', TRUE),
                'assignmentplace' => $this->input->post('assignmentplace', TRUE),
                'assignmentdate' => $this->input->post('assignmentdate', TRUE),
                'approvaldate' => $this->input->post('approvaldate', TRUE),
                'effectivedate' => $this->input->post('effectivedate', TRUE),
                'location' => $this->input->post('location', TRUE),
                'source' => $this->input->post('source', TRUE),
                'language' => $this->input->post('language', TRUE),
                'legalfield' => $this->input->post('legalfield', TRUE),
                'subject' => $this->input->post('subject', TRUE),
                'cluster' => $this->input->post('cluster', TRUE),
                'status' => $this->input->post('status', TRUE),
                'detailstatus' => str_replace("[removed]", "", $this->input->post('detailstatus', FALSE)),
                'abstract' => str_replace("[removed]", "", $this->input->post('abstract', FALSE)),
                'abstractfile' => json_encode($abstract),
                'attachment' => json_encode($attachment),
                'published' => $this->input->post('published', TRUE),
                'publishdate' => $this->input->post('publishdate', TRUE) . " " . str_replace(" ", "", $this->input->post('publishtime', TRUE)) . ":00",
                'reason' => str_replace("[removed]", "", $this->input->post('reason', FALSE)),
                'publish_jdihn' => $this->input->post('publish_jdihn', TRUE), // <-- FIELD BARU DISIMPAN
                'createdat' => date('Y-m-d H:i:s'),
                'createdby' => $this->sess['id'],
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Regulations_model->insert($data);
            $this->session->set_flashdata('message', 'Sukses menyimpan data!');
            redirect(site_url('app/regulations'));
        }
    }

    public function update($id)
    {
        $row = $this->Regulations_model->get_by_id($id);
        $dcdata = $this->Documentcategories_model->get_all();
        $doctype = $this->Documenttypes_model->get_all();

        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('app/regulations/update_action'),
                'id' => set_value('id', $row->id),
                'title' => set_value('title', $row->title),
                'documentcategory' => set_value('documentcategory', $row->documentcategory),
                'doctype' => set_value('doctype', $row->doctype),
                'teu' => set_value('teu', $row->teu),
                'regulationnumber' => set_value('regulationnumber', $row->regulationnumber),
                'year' => set_value('year', $row->year),
                'assignmentplace' => set_value('assignmentplace', $row->assignmentplace),
                'assignmentdate' => set_value('assignmentdate', $row->assignmentdate),
                'approvaldate' => set_value('approvaldate', $row->approvaldate),
                'effectivedate' => set_value('effectivedate', $row->effectivedate),
                'location' => set_value('location', $row->location),
                'source' => set_value('source', $row->source),
                'language' => set_value('language', $row->language),
                'legalfield' => set_value('legalfield', $row->legalfield),
                'subject' => set_value('subject', $row->subject),
                'cluster' => set_value('cluster', $row->cluster),
                'status' => set_value('status', $row->status),
                'detailstatus' => set_value('detailstatus', $row->detailstatus),
                'abstract' => set_value('abstract', $row->abstract),
                'abstractfile' => json_decode($row->abstractfile),
                'attachment' => json_decode($row->attachment),
                'published' => set_value('published', $row->published),
                'publishdate' => set_value('publishdate', $row->publishdate),
                'reason' => set_value('reason', $row->reason),
                'publish_jdihn' => set_value('publish_jdihn', $row->publish_jdihn), // <-- FIELD BARU
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'dcdata' => $dcdata,
                'docstype' => $doctype,
                'isPublished' => self::$isPublished,
                'isStatus' => self::$isStatus,
                'curAbstractfile' => set_value('curAbstracfile', $row->abstractfile),
                'curAttachment' => set_value('curAttachment', $row->attachment),
                'template' => 'regulations/regulations_form',
                'extrajs' => 'regulations/regulations_form_extrajs',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {

            $uploaded_abstract_json = $this->input->post('abstractfile_json', TRUE);
            $uploaded_attachment_json = $this->input->post('attachment_json', TRUE);
            $curAbstractfile_json = $this->input->post('curAbstractfile', TRUE);
            $curAttachment_json = $this->input->post('curAttachment', TRUE);

            $abstract = !empty($uploaded_abstract_json) ? json_decode($uploaded_abstract_json, TRUE) : json_decode($curAbstractfile_json, TRUE);
            $attachment = !empty($uploaded_attachment_json) ? json_decode($uploaded_attachment_json, TRUE) : json_decode($curAttachment_json, TRUE);

            // Generate Slug
            $slug = url_title($this->input->post('title'), "-", TRUE) . "-" . $this->input->post('regulationnumber', TRUE) . "-" . $this->input->post('year', TRUE);

            $data = array(
                'groups' => 'regulation',
                'title' => $this->input->post('title', TRUE),
                'slug' => $slug,
                'documentcategory' => $this->input->post('documentcategory', TRUE),
                'doctype' => $this->input->post('doctype', TRUE),
                'teu' => $this->input->post('teu', TRUE),
                'regulationnumber' => $this->input->post('regulationnumber', TRUE),
                'year' => $this->input->post('year', TRUE),
                'assignmentplace' => $this->input->post('assignmentplace', TRUE),
                'assignmentdate' => $this->input->post('assignmentdate', TRUE),
                'approvaldate' => $this->input->post('approvaldate', TRUE),
                'effectivedate' => $this->input->post('effectivedate', TRUE),
                'location' => $this->input->post('location', TRUE),
                'source' => $this->input->post('source', TRUE),
                'language' => $this->input->post('language', TRUE),
                'legalfield' => $this->input->post('legalfield', TRUE),
                'subject' => $this->input->post('subject', TRUE),
                'cluster' => $this->input->post('cluster', TRUE),
                'status' => $this->input->post('status', TRUE),
                'detailstatus' => str_replace("[removed]", "", $this->input->post('detailstatus', FALSE)),
                'abstract' => str_replace("[removed]", "", $this->input->post('abstract', FALSE)),
                'abstractfile' => json_encode($abstract),
                'attachment' => json_encode($attachment),
                'published' => $this->input->post('published', TRUE),
                'publishdate' => $this->input->post('publishdate', TRUE) . " " . str_replace(" ", "", $this->input->post('publishtime', TRUE)) . ":00",
                'reason' => str_replace("[removed]", "", $this->input->post('reason', FALSE)),
                'publish_jdihn' => $this->input->post('publish_jdihn', TRUE), // <-- FIELD BARU DISIMPAN
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Regulations_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/regulations'));
        }
    }

    public function trash()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $per_page = $this->input->get('per_page', TRUE) ? intval($this->input->get('per_page', TRUE)) : 10;
        $start = intval($this->input->get('start'));

        // Validate per_page to ensure it's one of the allowed values
        $allowed_per_page = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed_per_page)) {
            $per_page = 10; // Default to 10 if invalid
        }

        // Build base URL for pagination
        $url_params = [];
        if ($q !== '') {
            $url_params['q'] = urlencode($q);
        }
        if ($per_page !== 10) {
            $url_params['per_page'] = $per_page; // Include per_page only if non-default
        }
        $base_url = base_url() . 'app/regulations/trash' . ($url_params ? '?' . http_build_query($url_params) : '');
        $config['base_url'] = $base_url;
        $config['first_url'] = $base_url;

        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;

        // Conditions for trashed records
        $conditions = array('regulations.isdeleted' => 1);

        $config['total_rows'] = $this->Regulations_model->total_rows($this->where, $q, $conditions);
        $regulation = $this->Regulations_model->get_limit_data($this->where, $config['per_page'], $start, $q, $conditions);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'regulations_data' => $regulation,
            'q' => $q,
            'per_page' => $per_page,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'session' => $this->sess,
            'rolelist' => $this->rolelist,
            'template' => 'regulations/regulations_trash',
        );
        $this->load->view('base/content', $data);
    }

    public function delete($id)
    {
        $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 0));

        if ($row) {
            $this->Regulations_model->update($row->id, array('isdeleted' => 1, 'published' => 'Draft'));
            $this->session->set_flashdata('message', 'Data sudah dihapus, silahkan cek tong sampah jika ingin mengembalikan data!');
            redirect(site_url('app/regulations'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations'));
        }
    }

    public function restore($id)
    {
        $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 1));

        if ($row) {
            $this->Regulations_model->update($row->id, array('regulations.isdeleted' => 0, 'published' => 'Draft'));
            $this->session->set_flashdata('message', 'Data sudah direstore sebagai draf!');
            redirect(site_url('app/regulations/trash'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations/trash'));
        }
    }
    public function bulk_permanent_delete()
    {
        if (!in_array('permanent_delete', $this->rolelist)) {
            $this->session->set_flashdata('message', 'Anda tidak memiliki izin untuk menghapus data secara permanen!');
            return redirect(site_url('app/regulations/trash'));
        }

        $ids = $this->input->post('ids', TRUE);

        if (!is_array($ids) || empty($ids)) {
            $this->session->set_flashdata('message', 'Tidak ada data yang dipilih untuk dihapus secara permanen!');
            return redirect(site_url('app/regulations/trash'));
        }

        $ids = array_map('intval', $ids);
        $deleted_count = 0;
        $failed_ids = [];

        foreach ($ids as $id) {
            $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 1));

            if ($row) {
                // Delete associated files
                $abstract = json_decode($row->abstractfile);
                if ($abstract && isset($abstract->fullpath) && file_exists($abstract->fullpath)) {
                    unlink($abstract->fullpath);
                }
                $attachment = json_decode($row->attachment);
                if ($attachment && isset($attachment->fullpath) && file_exists($attachment->fullpath)) {
                    unlink($attachment->fullpath);
                }

                // Permanently delete the record
                $this->Regulations_model->delete($id);
                $deleted_count++;
            } else {
                $failed_ids[] = $id;
            }
        }

        if ($deleted_count > 0) {
            $this->session->set_flashdata('message', $deleted_count . ' data berhasil dihapus secara permanen!');
        } else {
            $this->session->set_flashdata('message', 'Gagal menghapus data. Pastikan data tersedia di tong sampah!');
        }

        if (!empty($failed_ids)) {
            $this->session->set_flashdata('message', $this->session->flashdata('message') . ' Gagal menghapus ID: ' . implode(', ', $failed_ids));
        }

        return redirect(site_url('app/regulations/trash'));
    }
    public function permanent_delete($id)
    {
        $row = $this->Regulations_model->get_by_id($id, array('regulations.isdeleted' => 1));

        if ($row) {
            $this->Regulations_model->delete($id);
            $abstract = json_decode($row->abstractfile);
            unlink($abstract->fullpath);
            $attach = json_decode($row->attachment);
            unlink($attach->fullpath);
            $this->session->set_flashdata('message', 'Data sudah dihapus secara permanen!');
            redirect(site_url('app/regulations'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations'));
        }
    }

    public function approve($id)
    {
        $doc = $this->Regulations_model->get_by_id($id);
        if ($doc) {
            $data = array(
                'published' => 'Publish',
                'publishdate' => date('Y-m-d H:i:s'),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );
            $this->Regulations_model->update($doc->id, $data);
            $this->session->set_flashdata('message', 'Dokumen berhasil di publis');
            redirect(site_url('app/regulations'));
        } else {
            $this->session->set_flashdata('message', 'Data dokumen tidak ditemukan. Pastikan data tidak dalam posisi tong sampah ');
            redirect(site_url('app/regulations'));
        }
    }

    public function reject($id)
    {
        $row = $this->Regulations_model->get_by_id($id);
        $dcdata = $this->Documentcategories_model->get_all();
        $doctype = $this->Documenttypes_model->get_all();

        if ($row) {
            $data = array(
                'button' => 'Tolak Dokumen',
                'action' => site_url('app/regulations/reject_action'),
                'id' => set_value('id', $row->id),
                'title' => set_value('title', $row->title),
                'documentcategory' => set_value('documentcategory', $row->documentcategory),
                'doctype' => set_value('doctype', $row->doctype),
                'teu' => set_value('teu', $row->teu),
                'regulationnumber' => set_value('regulationnumber', $row->regulationnumber),
                'year' => set_value('year', $row->year),
                'assignmentplace' => set_value('assignmentplace', $row->assignmentplace),
                'assignmentdate' => set_value('assignmentdate', $row->assignmentdate),
                'approvaldate' => set_value('approvaldate', $row->approvaldate),
                'effectivedate' => set_value('effectivedate', $row->effectivedate),
                'location' => set_value('location', $row->location),
                'source' => set_value('source', $row->source),
                'language' => set_value('language', $row->language),
                'legalfield' => set_value('legalfield', $row->legalfield),
                'subject' => set_value('subject', $row->subject),
                'cluster' => set_value('cluster', $row->cluster),
                'status' => set_value('status', $row->status),
                'detailstatus' => set_value('detailstatus', $row->detailstatus),
                'abstract' => set_value('abstract', $row->abstract),
                'abstractfile' => json_decode($row->abstractfile),
                'attachment' => json_decode($row->attachment),
                'published' => set_value('published', $row->published),
                'publishdate' => set_value('publishdate', $row->publishdate),
                'reason' => set_value('reason', $row->reason),
                'session' => $this->sess,
                'rolelist' => $this->rolelist,
                'dcdata' => $dcdata,
                'docstype' => $doctype,
                'isPublished' => self::$isPublished,
                'isStatus' => self::$isStatus,
                'curAbstractfile' => set_value('curAbstracfile', $row->abstractfile),
                'curAttachment' => set_value('curAttachment', $row->attachment),
                'template' => 'regulations/regulations_reject',
            );
            $this->load->view('base/content', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan!');
            redirect(site_url('app/regulations'));
        }
    }

    public function reject_action()
    {
        $this->_rules2();
        if ($this->form_validation->run() == FALSE) {
            $this->reject($this->input->post('id', TRUE));
        } else {

            $data = array(
                'published' => $this->input->post('published', TRUE),
                'reason' => $this->input->post('reason', TRUE),
                'updatedat' => date('Y-m-d H:i:s'),
                'updatedby' => $this->sess['id'],
            );

            $this->Regulations_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Sukses mengupdate data!');
            redirect(site_url('app/regulations'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('documentcategory', 'documentcategory', 'trim|required|xss_clean');
        $this->form_validation->set_rules('doctype', 'doctype', 'trim|required|xss_clean');
        $this->form_validation->set_rules('teu', 'teu', 'trim|xss_clean');
        $this->form_validation->set_rules('regulationnumber', 'regulationnumber', 'trim|required|xss_clean');
        $this->form_validation->set_rules('year', 'year', 'trim|required|xss_clean');
        $this->form_validation->set_rules('assignmentplace', 'assignmentplace', 'trim|required|xss_clean');
        $this->form_validation->set_rules('assignmentdate', 'assignmentdate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('approvaldate', 'approvaldate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('effectivedate', 'effectivedate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('location', 'location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('source', 'source', 'trim|required|xss_clean');
        $this->form_validation->set_rules('language', 'language', 'trim|required|xss_clean');
        $this->form_validation->set_rules('legalfield', 'legalfield', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cluster', 'cluster', 'trim|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('detailstatus', 'detailstatus', 'trim|xss_clean');
        $this->form_validation->set_rules('abstract', 'abstract', 'trim|xss_clean');
        $this->form_validation->set_rules('published', 'published', 'trim|required|xss_clean');
        $this->form_validation->set_rules('publishdate', 'publishdate', 'trim|xss_clean');
        $this->form_validation->set_rules('publishtime', 'publishtime', 'trim|xss_clean');
        $this->form_validation->set_rules('reason', 'reason', 'trim|xss_clean');
        $this->form_validation->set_rules('curAbstractfile', 'curAbstractfile', 'trim|xss_clean');
        $this->form_validation->set_rules('curAttachment', 'curAttachment', 'trim|xss_clean');
        $this->form_validation->set_rules('publish_jdihn', 'publish_jdihn', 'trim|required|xss_clean|in_list[0,1]');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules2()
    {
        $this->form_validation->set_rules('published', 'published', 'trim|required|xss_clean');
        $this->form_validation->set_rules('reason', 'reason', 'trim|xss_clean');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}