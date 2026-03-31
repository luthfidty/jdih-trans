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

    // get all
    function get_all($status = array('posts.poststatus !=' => 4))
    {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', 'post');
        $this->db->where($status);
        $this->db->order_by('posts.id', $this->order);
        return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($id, $status = array('posts.poststatus !=' => 4))
    {
        $this->db->select('posts.*');
        $this->db->from('posts');
        $this->db->where('type', 'post');
        $this->db->where('posts.id', $id);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    // get data by slug
    function get_by_slug($slug, $status = array('posts.poststatus !=' => 4))
    {
        $this->db->select('posts.*, users.username, userdetails.fullname');
        $this->db->from('posts');
        $this->db->join('users', 'users.id=posts.createdby', 'left');
        $this->db->join('userdetails', 'userdetails.userid=users.id', 'left');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->where('posts.type', 'post');
        $this->db->where('posts.slug', $slug);
        $this->db->where($status);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($whereby, $q = NULL, $status = array('posts.poststatus !=' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->where('posts.type', 'post');
        $this->db->where($status);
        $this->db->where($whereby);
        if ($q !== NULL && $q !== '') {
            $this->db->group_start();
            $this->db->like('posts.title', $q);
            $this->db->or_like('posts.slug', $q);
            $this->db->or_like('posts.content', $q);
            $this->db->or_like('categories.category', $q);
            $this->db->group_end();
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($whereby, $limit, $start = 0, $q = NULL, $status = array('posts.poststatus !=' => 4))
    {
        $this->db->select('posts.*, categories.category as categoryname');
        $this->db->join('categories', 'categories.id = posts.category', 'left');
        $this->db->from('posts');
        $this->db->where('posts.type', 'post');
        $this->db->where($status);
        $this->db->where($whereby);
        if ($q !== NULL && $q !== '') {
            $this->db->group_start();
            $this->db->like('posts.title', $q);
            $this->db->or_like('posts.slug', $q);
            $this->db->or_like('posts.content', $q);
            $this->db->or_like('categories.category', $q);
            $this->db->group_end();
        }
        $this->db->order_by('posts.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('type', 'post');
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // bulk update data
    function bulk_update($ids, $data)
    {
        if (!empty($ids) && is_array($ids)) {
            $this->db->where('type', 'post');
            $this->db->where_in($this->id, $ids);
            $this->db->update($this->table, $data);
            return $this->db->affected_rows();
        }
        return 0;
    }

    // delete data
    function delete($id)
    {
        $this->db->where('type', 'post');
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // bulk delete data
    function bulk_delete($ids)
    {
        if (!empty($ids) && is_array($ids)) {
            $this->db->where('type', 'post');
            $this->db->where_in($this->id, $ids);
            $this->db->where('poststatus', 4);
            $this->db->delete($this->table);
            return $this->db->affected_rows();
        }
        return 0;
    }
}
?>