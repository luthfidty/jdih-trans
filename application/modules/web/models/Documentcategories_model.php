<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documentcategories_model extends CI_Model
{

    public $table = 'documentcategories';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('
        documentcategories.*, 
        COUNT(regulations.id) as countdc,
        IFNULL(SUM(regulations.downloaded), 0) as total_downloaded
    ');
        $this->db->from('documentcategories');
        $this->db->join(
            'regulations',
            "regulations.documentcategory = documentcategories.id AND regulations.published = 'Publish'",
            'left'
        );
        $this->db->group_by('documentcategories.id');

        return $this->db->get()->result();
    }



    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    //get data by slug
    function get_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        return $this->db->get($this->table)->row();
    }

    //get data by acronym slug (exact match)
    function get_by_acronym_slug($acslug)
    {
        $this->db->where('acslug', $acslug);
        return $this->db->get($this->table)->row();
    }
    
    //get data by acronym slug using LIKE (Mencari di mana saja, mengembalikan banyak hasil)
    function get_like_acronym_slug($acslug)
    {
        // $this->db->like('acslug', $acslug); menghasilkan WHERE `acslug` LIKE '%rancangan%'
        $this->db->like('acslug', $acslug);
        // Mengubah dari ->row() menjadi ->result() untuk mendapatkan semua kategori yang cocok
        return $this->db->get($this->table)->result(); 
    }

}