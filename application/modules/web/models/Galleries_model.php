<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galleries_model extends CI_Model {

    public $table = 'posts';
    public $id = 'id';
    public $order = 'ASC';
    public $type = 'gallery';

    function __construct() {
        parent::__construct();
    }

// get all
    function get_all($status = array('poststatus !=' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        return $this->db->get()->result();
    }

    //get by slug
    function get_by_slug($slug, $subtype, $status = array('poststatus != ' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where('subtype', $subtype);
        $this->db->where('slug', $slug);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    function get_by_id($id, $subtype, $status = array('poststatus != ' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where('subtype', $subtype);
        $this->db->where('id', $id);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    //get total rows
    function total_rows($status = array('poststatus !=' => 4)) {
        $this->db->select('posts.*');
        $this->db->where('type', $this->type);
        $this->db->where($status);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    //get all limit data

    function get_limit_data($limit, $start = 0, $status = array('poststatus != ' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

// get total rows
    function total_rows_by_subtype($subtype, $status = array('poststatus !=' => 4)) {
        $this->db->select('posts.*');
        $this->db->where('type', $this->type);
        $this->db->where('subtype', $subtype);
        $this->db->where($status);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_all_by_subtype($subtype, $status = array('poststatus !=' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where('subtype', $subtype);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        return $this->db->get()->result();
    }

    function get_limit_data_by_subtype($subtype, $limit, $start = 0, $status = array('poststatus != ' => 4)) {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', $this->type);
        $this->db->where('subtype', $subtype);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

}
