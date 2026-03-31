<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_model extends CI_Model {

    public $table = 'categories';
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all
    function get_all() {
        $this->db->select('categories.*, count(categories.id) as counter');
        $this->db->from('categories');
        $this->db->join('posts', 'posts.category=categories.id');
        $this->db->group_by('categories.id');
        return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($id) {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    //get data by slug
    function get_by_slug($slug) {
        $this->db->where('slug', $slug);
        return $this->db->get($this->table)->row();
    }

}
