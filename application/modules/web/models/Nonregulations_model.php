<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nonregulations_model extends CI_Model
{

    public $table = 'regulations';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups !=', 'regulation');
        $this->db->where('regulations.published','Publish');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    //get data by slug
    function get_by_slug($group, $slug)
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->where('regulations.groups ', $group);
        $this->db->where('regulations.slug', $slug);
        return $this->db->get($this->table)->row();
    }

    //get data by id
    function get_by_id($group, $id)
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->where('regulations.groups ', $group);
        $this->db->where('regulations.id', $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows()
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups <>', 'regulation');
        $this->db->where('regulations.published','Publish');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0)
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups <>', 'regulation');
        $this->db->where('regulations.published','Publish');

        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');

        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // get total rows
    function total_rows_by_groups($groups)
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups', $groups);
        $this->db->where('regulations.published','Publish');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_by_groups($groups, $limit, $start = 0)
    {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups', $groups);
        $this->db->where('regulations.published','Publish');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->order_by('regulations.year', $this->order);
        $this->db->order_by('regulations.id', $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // update data
    function update($id, $group, $data)
    {
        $this->db->where('groups', $group);
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    function get_random_by_groups($groups, $limit = 7)
    {
        $this->db->select('regulations.*, uc.username, udc.fullname, uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->from($this->table);
        $this->db->join('users uc', 'uc.id = regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid = uc.id', 'left');
        $this->db->join('users uu', 'uu.id = regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid = uu.id', 'left');
        $this->db->where('regulations.groups', $groups);
        $this->db->where('regulations.published','Publish');
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }



}

/* End of file regulations_model.php */
/* Location: ./application/models/regulations_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-09 10:16:08 */
/* http://harviacode.com */