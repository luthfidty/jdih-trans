<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nondocumentcategories_model extends CI_Model
{
    public $table = 'nondocumentcategories';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // Get all groups as an associative array
    function get_all_active()
    {
        $this->db->order_by('group_name', $this->order);
        $query = $this->db->get($this->table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->group_key] = $row->group_name;
        }
        return $result;
    }

    // Get all groups for admin management
    function get_all()
    {
        $this->db->order_by('group_name', $this->order);
        return $this->db->get($this->table)->result();
    }

    // Get group by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // Get group by group_key
    function get_by_group_key($group_key)
    {
        $this->db->where('group_key', $group_key);
        return $this->db->get($this->table)->row();
    }

    // Get total rows
    function total_rows($q = NULL)
    {
        if ($q) {
            $this->db->like('id', $q);
            $this->db->or_like('group_key', $q);
            $this->db->or_like('group_name', $q);
            $this->db->or_like('created_at', $q);
            $this->db->or_like('updated_at', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by('group_name', $this->order);
        if ($q) {
            $this->db->like('id', $q);
            $this->db->or_like('group_key', $q);
            $this->db->or_like('group_name', $q);
            $this->db->or_like('created_at', $q);
            $this->db->or_like('updated_at', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Insert a new group
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update a group
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Delete a group (hard delete)
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Nondocumentcategories_model.php */
/* Location: ./application/models/Nondocumentcategories_model.php */