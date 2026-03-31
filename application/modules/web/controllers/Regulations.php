<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regulations extends MY_Controller
{

    public $device;

    function __construct()
    {
        parent::__construct();
        parent::_visitorCounter();
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
        $this->load->model('Posts_model');
        $this->load->model('Categories_model');
        $this->load->model('app/Externallinks_model');
        $this->load->library('form_validation');
        $this->load->model('Surveys_model');
        $this->device = $this->session->userdata('device');
    }

    public function index()
    {
        // 1. Load data widget (berita, sidebar, dll) - Bagian ini tetap sama
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();

        // 2. Ambil parameter halaman (pagination)
        $start = intval($this->input->get('start'));

        // 3. Konfigurasi URL Paginasi
        $config['base_url'] = base_url() . 'web/regulations/';
        $config['first_url'] = base_url() . 'web/regulations/';
        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;

        // =========================================================================
        // [BAGIAN BARU] Filter Sembunyikan Naskah Akademik & Urgensi
        // =========================================================================
        
        // Masukkan 'slug' (nama di URL) yang ingin disembunyikan di sini
        $exclude_slugs = array('naskah-akademik', 'naskah-urgensi'); 
        $exclude_ids = array();

        // Loop otomatis mencari ID kategori berdasarkan slug
        foreach ($exclude_slugs as $es) {
            $found_cat = $this->Documentcategories_model->get_by_acronym_slug($es);
            if ($found_cat) {
                $exclude_ids[] = $found_cat->id;
            }
        }

        // Terapkan filter ke Query Total Baris (untuk Paginasi)
        if (!empty($exclude_ids)) {
            $this->db->where_not_in('documentcategory', $exclude_ids);
        }
        $config['total_rows'] = $this->Regulations_model->total_rows('regulation', $status = array('Published =' => 'Publish'));

        // Terapkan filter ke Query Pengambilan Data Utama
        if (!empty($exclude_ids)) {
            $this->db->where_not_in('documentcategory', $exclude_ids);
        }
        $regulations = $this->Regulations_model->get_limit_data('regulation', $config['per_page'], $start);

        // =========================================================================
        // [AKHIR BAGIAN BARU]
        // =========================================================================

        $survey = $this->Surveys_model->get_all_count();

        // 4. Inisialisasi Paginasi
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        // 5. Siapkan Data untuk View
        $data = array(
            'regulations' => $regulations,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'pojokuke' => $pojokuke,
            'category' => $category,
            'mostvregulations' => $mostvregulations,
            'links' => $links,
            'template' => $this->device . '/regulationcategories',
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'survey' => $survey,
            'device' => $this->device
        );

        // 6. Tampilkan View
        $this->load->view($this->device . '/base/content', $data);
    }
    
    public function popular()
    {

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();

        $start = intval($this->input->get('start'));

        $config['base_url'] = base_url() . 'web/regulations/popular/';
        $config['first_url'] = base_url() . 'web/regulations/popular/';

        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Regulations_model->total_rows_most_viewed('regulation', $status = array('Published =' => 'Publish'));
        $regulations = $this->Regulations_model->get_most_viewed('regulation', $config['per_page'], $start);
        $survey = $this->Surveys_model->get_all_count();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'regulations' => $regulations,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'pojokuke' => $pojokuke,
            'category' => $category,
            'mostvregulations' => $mostvregulations,
            'links' => $links,
            'template' => $this->device . '/regulationcategories',
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'survey' => $survey,
            'device' => $this->device
        );

        $this->load->view($this->device . '/base/content', $data);
    }

    public function category($slug)
    {
        // Inisialisasi variabel untuk menampung ID kategori (bisa array atau integer)
        $current_doc_category_ids = array();
        $dcategory = NULL; // Default, akan diisi di bawah
        $is_rancangan = false; // <<< VARIABEL BARU

        if ($slug === 'rancangan-peraturan') {
            $is_rancangan = true; // <<< SET JIKA INI ADALAH KATEGORI GABUNGAN

            // 1. Ambil SEMUA kategori yang cocok (array of objects)
            $dcategories_list = $this->Documentcategories_model->get_like_acronym_slug("rancangan");

            // 2. Ekstrak ID dari hasil
            if ($dcategories_list) {
                foreach ($dcategories_list as $dc) {
                    $current_doc_category_ids[] = $dc->id;
                }
            }

            // 3. Buat objek dummy $dcategory untuk passing ke view
            // Objek ini mewakili kategori gabungan "Rancangan Peraturan"
            if (!empty($current_doc_category_ids)) {
                $dcategory = (object) [
                    'id' => $current_doc_category_ids, // ID sekarang adalah array
                    'name' => 'Kumpulan Rancangan Peraturan',
                    'slug' => $slug
                ];
            }

        } else {
            // Kasus default (hanya satu kategori dokumen, exact match)
            $dcategory = $this->Documentcategories_model->get_by_acronym_slug($slug);

            // Dibuat array ID jika kategori ditemukan
            if ($dcategory) {
                $current_doc_category_ids[] = $dcategory->id;
            }
        }

        // --- Pengambilan data pendukung (Tidak berubah) ---
        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        // -------------------------------------------------

        // Cek apakah ada ID kategori yang berhasil ditemukan (untuk single atau multiple)
        if (!empty($current_doc_category_ids)) {

            $start = intval($this->input->get('start'));

            $config['base_url'] = base_url() . 'web/regulations/category/' . $slug;
            $config['first_url'] = base_url() . 'web/regulations/category/' . $slug;

            $config['per_page'] = $this->config->item('site_limit_post');
            $config['page_query_string'] = TRUE;

            // PENTING: Menggunakan array ID untuk total baris
            $config['total_rows'] = $this->Regulations_model->total_rows_by_dc($current_doc_category_ids, 'regulation', $status = array('Published =' => 'Publish'));

            // PENTING: Menggunakan array ID untuk pengambilan data
            $regulations = $this->Regulations_model->get_limit_data_by_dc($current_doc_category_ids, 'regulation', 9, $start);


            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $data = array(
                'regulations' => $regulations,
                'documentcategory' => $documentcategory,
                'currentdoccategory' => $dcategory, // Objek (tunggal atau dummy)
                'latestpost' => $latestpost,
                'pojokuke' => $pojokuke,
                'category' => $category,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/regulationcategories',
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $config['total_rows'],
                'start' => $start,
                'device' => $this->device,
                'is_rancangan' => $is_rancangan // <<< VARIABEL BARU DITAMBAHKAN
            );
            $this->load->view($this->device . '/base/content', $data);
        } else {
            // Blok ELSE jika tidak ada kategori atau regulasi yang ditemukan
            $data = array(
                'regulations' => '',
                'documentcategory' => $documentcategory,
                'currentdoccategory' => $dcategory,
                'latestpost' => $latestpost,
                'pojokuke' => $pojokuke,
                'category' => $category,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/regulationcategories',
                'device' => $this->device,
                'is_rancangan' => $is_rancangan // <<< VARIABEL BARU DITAMBAHKAN
            );

            $this->load->view($this->device . '/base/content', $data);
        }
    }

    public function read($id): void
    {
        $regulations = $this->Regulations_model->get_by_id('regulation', $id, array('published' => 'Publish'));

        // Ambil kategori dokumen terkait
        $dcategory = $this->Documentcategories_model->get_by_id($regulations->documentcategory);

        // <<< PENGECEKAN FLAG IS_RANCANGAN DITAMBAHKAN DI SINI
        $is_rancangan = false;
        if ($dcategory) {
            // Cek apakah 'slug' atau 'acronym' mengandung kata 'rancangan' (case-insensitive)
            $category_name = strtolower($dcategory->slug . ' ' . $dcategory->acronym);
            if (strpos($category_name, 'rancangan') !== false) {
                $is_rancangan = true;
            }
        }
        // >>>

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $links = $this->Externallinks_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $regulationsexts = $this->Regulations_model->get_random_regulations_by_dc(
            'regulation',
            7,
            array('regulations.published' => 'Publish'),
            $dcategory->id
        );


        if ($regulations) {
            $this->Regulations_model->update($regulations->id, array('viewed' => $regulations->viewed + 1));
            $data = array(
                'regulations' => $this->Regulations_model->get_by_id('regulation', $regulations->id, array('published' => 'Publish')),
                'regulationsexts' => $regulationsexts,
                'fulltitle' => $regulations->category . " Nomor " . $regulations->regulationnumber . " Tahun " . $regulations->year . " Tentang " . $regulations->title,
                'permalink' => site_url(),
                'documentcategory' => $documentcategory,
                'currentdoccategory' => $dcategory,
                'latestpost' => $latestpost,
                'pojokuke' => $pojokuke,
                'category' => $category,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/regulations',
                'extrajs' => 'base/regulations_extrajs',
                'survey' => $survey,
                'device' => $this->device,
                'is_rancangan' => $is_rancangan // <<< VARIABEL BARU DITAMBAHKAN
            );
        } else {
            $data = array(
                'regulations' => '',
                'pojokuke' => $pojokuke,
                'documentcategory' => $documentcategory,
                'latestpost' => $latestpost,
                'category' => $category,
                'mostvregulations' => $mostvregulations,
                'links' => $links,
                'template' => $this->device . '/regulations',
                'survey' => $survey,
                'device' => $this->device,
                'is_rancangan' => $is_rancangan // <<< VARIABEL BARU DITAMBAHKAN
            );
        }
        $this->load->view($this->device . '/base/content', $data);
    }

    public function search()
    {

        $kw = urldecode($this->input->get('kw', TRUE));
        $rnumber = intval(urldecode($this->input->get('rnumber', TRUE)));
        $ryear = intval(urldecode($this->input->get('ryear', TRUE)));
        $rcategory = intval(urldecode($this->input->get('rcategory', TRUE)));
        $start = intval($this->input->get('start', TRUE));

        if ($rnumber <> '' | $ryear <> '' || $rcategory <> '') {
            $config['base_url'] = base_url() . 'web/regulations/search?kw=' . urlencode($kw) . '&rnumber=' . urlencode($rnumber) . '&ryear=' . urlencode($ryear) . '&rcategory=' . urlencode($rcategory);
            $config['first_url'] = base_url() . 'web/regulations/search?kw=' . urlencode($kw) . '&rnumber=' . urlencode($rnumber) . '&ryear=' . urlencode($ryear) . '&rcategory=' . urlencode($rcategory);
            $rnum = $rnumber == 0 ? 'regulations.regulationnumber >=' : 'regulations.regulationnumber =';
            $ry = $ryear == 0 ? 'regulations.year >=' : 'regulations.year =';
            $rdoc = $rcategory == 0 ? 'regulations.documentcategory >=' : 'regulations.documentcategory =';
            $wSearch = array(
                $rnum => $rnumber,
                $ry => $ryear,
                $rdoc => $rcategory,
            );
        } else {
            $config['base_url'] = base_url() . 'web/regulations/search?kw=' . urlencode($kw);
            $config['first_url'] = base_url() . 'web/regulations/search?kw=' . urlencode($kw);
            $wSearch = array(
                'regulations.regulationnumber <>' => 0,
                'regulations.year <>' => 0,
                'regulations.documentcategory <>' => 0,
            );
        }
        $config['per_page'] = $this->config->item('site_limit_post');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Regulations_model->total_rows_by_search('regulation', $kw, $wSearch);
        $regulations = $this->Regulations_model->get_limit_data_by_search('regulation', $kw, $wSearch, $config['per_page'], $start);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $pojokuke = $this->Posts_model->get_limit_data('post', 2, 0, array('poststatus' => 1));
        $latestpost = $this->Posts_model->get_limit_data('post', 4, 0, array('poststatus' => 1));
        $category = $this->Categories_model->get_all();
        $mostvregulations = $this->Regulations_model->get_most_viewed('regulation', $this->config->item('site_limit_post'), 0, array('published' => 'Publish'));
        $documentcategory = $this->Documentcategories_model->get_all();
        $survey = $this->Surveys_model->get_all_count();

        $data = array(
            'regulations' => $regulations,
            'pojokuke' => $pojokuke,
            'documentcategory' => $documentcategory,
            'latestpost' => $latestpost,
            'category' => $category,
            'mostvregulations' => $mostvregulations,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'template' => $this->device . '/regulationcategories',
            'survey' => $survey,
            'device' => $this->device
        );
        $this->load->view($this->device . '/base/content', $data);
    }

    public function like($id)
    {
        $curlike = $this->Regulations_model->get_by_id('regulation', $id);
        if ($curlike) {
            $cl = $curlike->liked + 1;
            $data = array('liked' => $cl);
            $this->Regulations_model->update($id, $data);
            echo json_encode(array('status' => 'success', 'like' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function downloadcount($id)
    {
        $curdown = $this->Regulations_model->get_by_id('regulation', $id);
        if ($curdown) {
            $cl = $curdown->downloaded + 1;
            $data = array('downloaded' => $cl);
            $this->Regulations_model->update($id, $data);
            echo json_encode(array('status' => 'success', 'downloaded' => $cl));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('kw', 'kw', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rnumber', 'rnumber', 'trim|xss_clean');
        $this->form_validation->set_rules('ryear', 'ryear', 'trim|xss_clean');
        $this->form_validation->set_rules('rcategory', 'rcategory', 'trim|xss_clean');
    }

}
