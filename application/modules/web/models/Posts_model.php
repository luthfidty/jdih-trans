<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends CI_Model
{

    public $table = 'posts';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get data by id
    function get_by_id($type, $id, $status = array('poststatus !=' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname, users.username, userdetails.fullname');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->join('users', 'users.id=posts.createdby', 'left');
        $this->db->join('userdetails', 'userdetails.userid=users.id', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where('posts.id', $id);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    //get data by slug
    function get_by_slug($type, $slug, $status = array('poststatus !=' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname, users.username, userdetails.fullname');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->join('users', 'users.id=posts.createdby', 'left');
        $this->db->join('userdetails', 'userdetails.userid=users.id', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where('posts.slug', $slug);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    //get popular posts
    function get_popular_posts($type, $limit, $start = 0, $status = array('poststatus !=' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname,');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->from('posts');
        $this->db->where('type', $type);
        $this->db->where($status);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // get total rows
    function total_rows($type, $status = array('poststatus !=' => 4))
    {
        $this->db->where('type', $type);
        $this->db->where($status);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($type, $limit, $start = 0, $status = array('poststatus != ' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // get total rows by slug category
    function total_rows_slug_category($type, $slug, $status = array('poststatus !=' => 4))
    {
        $this->db->select('posts.*,categories.category,categories.slug');
        $this->db->from('posts');
        $this->db->join('categories', ' categories.id=posts.category', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where('categories.slug', $slug);
        $this->db->where($status);
        return $this->db->count_all_results();
    }

    // get data with limit by slug category
    function get_limit_data_slug_category($type, $slug, $limit, $start = 0, $status = array('poststatus != ' => 4))
    {
        $this->db->select('posts.*,categories.category as categoryname, categories.slug as categoryslug');
        $this->db->from('posts');
        $this->db->join('categories', ' categories.id=posts.category', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where('categories.slug', $slug);
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function update($type, $id, $data)
    {
        $this->db->where('type', $type);
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    // get random posts
    function get_random_data_slug_category($type, $slug, $limit = 7, $status = array('poststatus != ' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname, categories.slug as categoryslug');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->where('posts.type', $type);
        $this->db->where('categories.slug', $slug);
        $this->db->where($status);
        $this->db->order_by('RAND()'); // ambil secara acak
        $this->db->limit($limit);
        return $this->db->get()->result();
    }


}

/* End of file Posts_model.php */
/* Location: ./application/models/Posts_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-11-07 12:59:55 */
/* http://harviacode.com */