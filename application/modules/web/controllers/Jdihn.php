<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jdihn extends MY_Controller {

    function __construct() {
        parent::__construct();
        parent::_visitorCounter();
        $this->load->model('Regulations_model');
        $this->load->model('Documentcategories_model');
    }

    public function index() {
        $documents = $this->Regulations_model->get_all('regulation', array('Published =' => 'Publish'));
        header("Content-Type: application/json");
        if ($documents) {
            $varjson = array();
            $row_array = (object) array();
            foreach ($documents as $doc) {
                $att = json_decode($documents->attachment);

                $row_array->idData = $doc->id; // //$row["id"]; //berisi id dokumen
                $row_array->tahun_pengundangan = $doc->year; ////$row["tahun"]; //berisi tahun penetapan atau tahun terbit ex. 2019
                $row_array->tanggal_pengundangan = $doc->assignmentdate; // //$row["tanggal_penetapan_terbit"]; //berisi tahun bulan tanggal (YYYY-MM-DD) ex. 2019-04-22
                $row_array->jenis = $doc->category; // //$row["jenis_peraturan"]; //berisi jenis peraturan ex. Peraturan Daerah
                $row_array->noPeraturan = $doc->regulationnumber; //$row["nomor_peraturan"]; //berisi no peraturan ex. 24
                $row_array->judul = $doc->title; //$row["judul"]; //berisi judul ex. Peraturan Pemerintah No 1 Tahun 2019 Tentang Peraturan
//$row_array->noPanggil='-'; //khusus untuk monografi/buku
                $row_array->singkatanJenis = $doc->acronym; //$row["singkatan_jenis_peraturan"]; //berisi singkatan dari jenis ex. Perda
                $row_array->tempatTerbit = $doc->assignmentplace; //$row["tempat_terbit"]; //berisi tempat terbit
//$row_array->penerbit='-';
//$row_array->deskripsiFisik='-'; //khusus untuk monografi/buku
                $row_array->sumber = '-';
                $row_array->subjek = '-';
//$row_array->isbn='-'; //khusus untuk monografi/buku
                $row_array->status = //$row["status"];
                        $row_array->bahasa = 'Indonesia';
                $row_array->bidangHukum = $doc->legalfield;
                $row_array->teuBadan = 'Kementerian Menteri Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi'; //nama instansi terkait
//$row_array->nomorIndukBuku='-'; //khusus untuk monografi/buku
                $row_array->fileDownload = $att->filename; //$row["judul"] . '.pdf'; //berisi nama file ex. peraturan.pdf, peraturan.docx
                $row_array->urlDownload = site_url($att->fullpath); //$row["lampiran"]; //berisi url dan nama file ex. domain.com/peraturan.pdf atau menyesuaikan
                $row_array->urlDetailPeraturan = site_url('web/documents/read/' . $doc->slug); //berisi link peraturan
                $row_array->operasi = "4";
                $row_array->display = "1";
                array_push($varjson, json_decode(json_encode($row_array)));
            }
            echo json_encode($varjson);
        } else {
            echo "0 results";
        }
    }

}
