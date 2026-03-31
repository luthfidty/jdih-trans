<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visitors_model extends CI_Model
{

    public $table = 'visitors';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    //get all visitour count
    function get_all_count()
    {
        $this->db->select('count(id) as visitor');
        return $this->db->get($this->table)->row();
    }


    function get_unique_count()
    {
        $this->db->select('count(distinct(visitorip)) as vunique');
        return $this->db->get($this->table)->row();
    }

    // //get all this month count
    // function get_monthly_count() {
    //     $this->db->select('count(id) as visitor');
    //     $this->db->where('date_format(visitdate,"%Y-%m")', date('Y-m'));
    //     return $this->db->get($this->table)->row();
    // }
    function get_monthly_count()
    {
        $start = date('Y-m-01'); // Awal bulan ini, contoh: 2025-07-01
        $end = date('Y-m-01', strtotime('+1 month')); // Awal bulan depan, contoh: 2025-08-01

        $this->db->select('COUNT(DISTINCT visitorip) as visitor');
        $this->db->where('visitdate >=', $start);
        $this->db->where('visitdate <', $end);

        return $this->db->get($this->table)->row();
    }


    //get all this day count
    // function get_daily_count()
    // {
    //     $this->db->select('count(id) as visitor');
    //     $this->db->where('visitdate', date('Y-m-d'));
    //     return $this->db->get($this->table)->row();
    // }

    function get_daily_count()
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $this->db->select('COUNT(DISTINCT visitorip) as visitor');
        $this->db->where('visitdate >=', $today);
        $this->db->where('visitdate <', $tomorrow);

        return $this->db->get($this->table)->row();
    }

    //get this weekly count
    // function get_weekly_count()
    // {
    //     $this->db->select('count(id) as count, visitdate');
    //     $this->db->where('visitdate >=', date("Y-m-d", strtotime("-1 week")));
    //     $this->db->where('visitdate <=', date("Y-m-d"));
    //     $this->db->group_by('visitdate');
    //     return $this->db->get($this->table)->result();
    // }
    function get_weekly_count()
    {
        // Cari Senin minggu ini
        $start = date('Y-m-d', strtotime('monday this week'));

        // Cari hari Senin berikutnya (agar range < Senin berikutnya = sampai Minggu jam 23:59:59)
        $end = date('Y-m-d', strtotime($start . ' +7 days'));

        // Ambil visitor unik per tanggal
        $this->db->select('DATE(visitdate) as visitdate, COUNT(DISTINCT visitorip) as count');
        $this->db->where('visitdate >=', $start);
        $this->db->where('visitdate <', $end);
        $this->db->group_by('DATE(visitdate)');
        $this->db->order_by('DATE(visitdate)', 'ASC');
        $result = $this->db->get($this->table)->result();

        // Mapping hasil query
        $mapped = [];
        foreach ($result as $row) {
            $mapped[$row->visitdate] = (int) $row->count;
        }

        // Bangun hasil akhir dari Senin - Minggu
        $final = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime($start . " +$i days"));
            $final[] = [
                'visitdate' => $date,
                'count' => $mapped[$date] ?? 0,
            ];
        }

        return $final;
    }






}
