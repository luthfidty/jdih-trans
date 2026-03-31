<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Regulations_model extends CI_Model
{

    public $table = 'regulations';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($groups, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($groups, $id, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug,documenttypes.documenttype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where('regulations.id', $id);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    function get_by_slug($groups, $slug, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug, documenttypes.documenttype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where('regulations.slug', $slug);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($groups, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($groups, $limit, $start = 0, $status = array('regulations.published' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug,documenttypes.documenttype as doctype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // get total rows
    function total_rows_by_dc($dcid, $groups, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);

        // --- PERBAIKAN PENTING: Menangani Array ID (WHERE IN) ---
        if (is_array($dcid)) {
            $this->db->where_in('regulations.documentcategory', $dcid);
        } else {
            $this->db->where('regulations.documentcategory', $dcid);
        }
        // --------------------------------------------------------

        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_by_dc($dcid, $groups, $limit, $start = 0, $status = array('regulations.published' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug,documenttypes.documenttype as doctype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);

        // --- PERBAIKAN PENTING: Menangani Array ID (WHERE IN) ---
        if (is_array($dcid)) {
            $this->db->where_in('regulations.documentcategory', $dcid);
        } else {
            $this->db->where('regulations.documentcategory', $dcid);
        }
        // --------------------------------------------------------

        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function total_rows_most_viewed($groups, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->order_by('regulations.viewed', $this->order);
        return $this->db->count_all_results();
    }
    // get most viewed
    function get_most_viewed($groups, $limit, $start = 0, $status = array('regulations.published' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->limit($limit, $start);
        $this->db->order_by('regulations.viewed', $this->order);
        return $this->db->get()->result();
    }

    function get_random_regulations_by_dc($groups, $limit = 7, $status = array('regulations.published' => 'Publish'), $dcid = null)
    {
        $this->db->select('regulations.*, documentcategories.category, documentcategories.acronym, documentcategories.acslug as dcslug, documenttypes.documenttype as doctype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id = regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id = regulations.doctype', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);

        if (!is_null($dcid)) {
            // Menambahkan penanganan array untuk fungsi ini juga, untuk jaga-jaga
            if (is_array($dcid)) {
                $this->db->where_in('regulations.documentcategory', $dcid);
            } else {
                $this->db->where('regulations.documentcategory', $dcid);
            }
        }

        $this->db->order_by('RAND()'); // ambil data acak
        $this->db->limit($limit);

        return $this->db->get()->result();
    }




    // get most downloaded
    function get_most_downloaded($groups, $limit, $start = 0, $status = array('regulations.published' => 'Publish'))
    {
        $this->db->select('regulations.*,documentcategories.category,documentcategories.acronym,documentcategories.acslug as dcslug');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->limit($limit, $start);
        $this->db->order_by('regulations.downloaded', $this->order);
        return $this->db->get()->result();
    }

    // get total rows by search
    function total_rows_by_search($groups, $kw, $wSearch, $status = array('regulations.published =' => 'Publish'))
    {
        $this->db->select('regulations.*, 
                        documentcategories.category, 
                        documentcategories.acronym, 
                        documentcategories.acslug as dcslug, 
                        documenttypes.documenttype as doctype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id = regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id = regulations.doctype', 'left'); // tambahkan join ini
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->where($wSearch);
        $this->db->group_start();
        $this->db->like('regulations.title', $kw);
        $this->db->or_like('regulations.abstract', $kw);
        $this->db->group_end();
        return $this->db->count_all_results();
    }


    // get data with limit and search
    function get_limit_data_by_search($groups, $kw, $wSearch, $limit, $start = 0, $status = array('regulations.published' => 'Publish'))
    {
        $this->db->select('regulations.*, 
                        documentcategories.category, 
                        documentcategories.acronym, 
                        documentcategories.acslug as dcslug, 
                        documenttypes.documenttype as doctype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id = regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id = regulations.doctype', 'left'); // JOIN tambahan
        $this->db->where('regulations.groups', $groups);
        $this->db->where($status);
        $this->db->where($wSearch);
        $this->db->group_start();
        $this->db->like('regulations.title', $kw);
        $this->db->or_like('regulations.abstract', $kw);
        $this->db->group_end();
        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    //update for like/download counter
    function update($id, $data)
    {
        $this->db->where('groups', 'regulation');
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    // application/models/Regulations_model.php

    public function get_all_jdih_data()
    {
        $this->db->select("
        regulations.id AS idData,

        COALESCE(NULLIF(regulations.year, ''), YEAR(regulations.assignmentdate)) AS tahun_pengundangan,
        regulations.assignmentdate AS tanggal_pengundangan,

        CASE
            WHEN regulations.groups = 'regulation' THEN documentcategories.category
            ELSE
                CASE regulations.groups
                    WHEN 'monographs' THEN 'Monografi'
                    WHEN 'jurisprudence' THEN 'Yurisprudensi'
                    WHEN 'book' THEN 'Artikel Hukum'
                    WHEN 'haki' THEN 'Hak Kekayaan Intelektual'
                    ELSE regulations.groups
                END
        END AS jenis,

        regulations.regulationnumber AS noPeraturan,

        CASE
            WHEN regulations.groups = 'regulation' THEN
                CONCAT(
                    documentcategories.category,
                    ' Nomor ',
                    regulations.regulationnumber,
                    ' Tahun ',
                    COALESCE(NULLIF(regulations.year, ''), YEAR(regulations.assignmentdate)),
                    ' Tentang ',
                    regulations.title
                )
            ELSE regulations.title
        END AS judul,

        regulations.callnumber AS noPanggil,
        documentcategories.acronym AS singkatanJenis,
        regulations.assignmentplace AS tempatTerbit,
        regulations.publisher AS penerbit,
        regulations.description AS deskripsiFisik,
        regulations.source AS sumber,
        regulations.subject AS subjek,
        regulations.isbnissnnumber AS isbn,

        CASE WHEN regulations.groups != 'regulation' THEN 'Berlaku' ELSE regulations.status END AS status,
        regulations.language AS bahasa,
        regulations.legalfield AS bidangHukum,
        regulations.teu AS teuBadan,
        '-' AS nomorIndukBuku,

        JSON_UNQUOTE(JSON_EXTRACT(regulations.attachment, '$.filename')) AS fileDownload,
        JSON_UNQUOTE(JSON_EXTRACT(regulations.abstractfile, '$.filename')) AS abstrak,

        CONCAT('" . base_url('web/regulations/read/') . "', regulations.id) AS urlDetailPeraturan,
        regulations.groups,
        regulations.slug
    ", FALSE); // FALSE = biar tidak escape kolom

        $this->db->from('regulations');
        $this->db->where('regulations.publish_jdihn', 1);
        $this->db->where('regulations.published', 'Publish');
        $this->db->group_start();
        $this->db->where("regulations.groups = 'regulation' AND regulations.status IN ('Berlaku', 'Tidak Berlaku')", NULL, FALSE);
        $this->db->or_where("regulations.groups != 'regulation'", NULL, FALSE);
        $this->db->group_end();
        $this->db->join('documentcategories', 'documentcategories.id = regulations.documentcategory', 'left');
        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);

        $query = $this->db->get();
        $result_array = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $temp_row = (array) $row;

                if ($temp_row['groups'] === 'regulation' && empty($temp_row['tanggal_pengundangan'])) {
                    continue;
                }

                // === Bikin URL dengan ?v= berdasarkan waktu file di server (PALING AKURAT) ===
                $base_url = 'https://jdih.transmigrasi.go.id/public/documents/';
                $doc_path = FCPATH . 'public/documents/';

                // Attachment
                $attachment_file = $temp_row['fileDownload'];
                $attachment_v = $attachment_file && file_exists($doc_path . $attachment_file)
                    ? filemtime($doc_path . $attachment_file)
                    : time();

                $temp_row['urlDownload'] = $attachment_file
                    ? $base_url . $attachment_file . '?v=' . $attachment_v
                    : null;

                // Abstract (hanya untuk regulation)
                $abstrak_file = $temp_row['abstrak'];
                $abstrak_v = $abstrak_file && file_exists($doc_path . $abstrak_file)
                    ? filemtime($doc_path . $abstrak_file)
                    : time();

                $temp_row['urlabstrak'] = ($temp_row['groups'] === 'regulation' && $abstrak_file)
                    ? $base_url . $abstrak_file . '?v=' . $abstrak_v
                    : null;

                // Ganti nilai kosong jadi null
                foreach ($temp_row as $key => &$value) {
                    if ($value === '' || $value === '-' || $value === ' ' || $value === null) {
                        $value = null;
                    }
                }
                unset($value);

                // Logika singkatan jenis (sama seperti sebelumnya)
                $jenis_text = $temp_row['jenis'];
                $singkatan_db = $temp_row['singkatanJenis'];
                if (empty($singkatan_db) || $singkatan_db === $jenis_text || strpos($singkatan_db, ' ') !== false) {
                    $acronym = '';
                    if (!empty($jenis_text)) {
                        $words = array_filter(explode(' ', $jenis_text));
                        $word_count = count($words);
                        if ($word_count >= 3) {
                            foreach ($words as $word)
                                $acronym .= mb_substr($word, 0, 1);
                        } elseif ($word_count === 2) {
                            $words_arr = array_values($words);
                            $acronym = mb_substr($words_arr[0], 0, 3) . mb_substr($words_arr[1], 0, 3);
                        } elseif ($word_count === 1) {
                            $acronym = mb_substr($words[0], 0, 4);
                        }
                    }
                    $temp_row['singkatanJenis'] = strtoupper($acronym);
                }

                // URL detail
                $temp_row['urlDetailPeraturan'] = $temp_row['groups'] !== 'regulation'
                    ? base_url("web/nonregulations/read/" . $temp_row['groups'] . "/" . $temp_row['idData'])
                    : base_url("web/regulations/read/" . $temp_row['idData']);

                $temp_row['operasi'] = "4";
                $temp_row['display'] = "1";

                unset($temp_row['groups'], $temp_row['slug']);

                $result_array[] = (object) $temp_row;
            }
        }

        return $result_array;
    }
}

/* End of file regulations_model.php */
/* Location: ./application/models/regulations_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-04 05:51:07 */
/* http://harviacode.com */