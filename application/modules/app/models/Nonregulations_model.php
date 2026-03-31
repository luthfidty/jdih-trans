<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nonregulations_model extends CI_Model {

    public $table = 'regulations';
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all
    function get_all($isdeleted = array('regulations.isdeleted' => 0), $published = array('regulations.published<>' => 'Pending')) {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups !=', 'regulation');
        $this->db->where($isdeleted);
        $this->db->where($published);
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id) {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups <>', 'regulation');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->where('regulations.id', $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($whereby,$q = NULL, $isdeleted = array('regulations.isdeleted' => 0), $published = array('regulations.published<>' => 'Pending')) {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups <>', 'regulation');
        $this->db->where($whereby);
        $this->db->where($isdeleted);
        $this->db->where($published);
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->group_start();
        $this->db->like('regulations.id', $q);
        $this->db->or_like('regulations.groups', $q);
        $this->db->or_like('regulations.title', $q);
        $this->db->or_like('regulations.teu', $q);
        $this->db->or_like('regulations.callnumber', $q);
        $this->db->or_like('regulations.year', $q);
        $this->db->or_like('regulations.assignmentplace', $q);
        $this->db->or_like('regulations.location', $q);
        $this->db->or_like('regulations.edition', $q);
        $this->db->or_like('regulations.publisher', $q);
        $this->db->or_like('regulations.language', $q);
        $this->db->or_like('regulations.subject', $q);
        $this->db->or_like('regulations.description', $q);
        $this->db->or_like('regulations.isbnissnnumber', $q);
        $this->db->or_like('regulations.viewed', $q);
        $this->db->or_like('regulations.downloaded', $q);
        $this->db->or_like('regulations.abstractfile', $q);
        $this->db->or_like('regulations.attachment', $q);
        $this->db->or_like('regulations.published', $q);
        $this->db->or_like('regulations.createdat', $q);
        $this->db->or_like('regulations.createdby', $q);
        $this->db->or_like('regulations.updatedat', $q);
        $this->db->or_like('regulations.updatedby', $q);
        $this->db->group_end();
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($whereby,$limit, $start = 0, $q = NULL, $isdeleted = array('regulations.isdeleted' => 0), $published = array('regulations.published<>' => 'Pending')) {
        $this->db->select('regulations.*,uc.username,udc.fullname,uu.username as userupdate, uud.fullname as fullnameupdate');
        $this->db->where('regulations.groups <>', 'regulation');
        $this->db->where($whereby);
        $this->db->where($isdeleted);
        $this->db->where($published);
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->group_start();
        $this->db->like('regulations.id', $q);
        $this->db->or_like('regulations.groups', $q);
        $this->db->or_like('regulations.title', $q);
        $this->db->or_like('regulations.teu', $q);
        $this->db->or_like('regulations.callnumber', $q);
        $this->db->or_like('regulations.year', $q);
        $this->db->or_like('regulations.assignmentplace', $q);
        $this->db->or_like('regulations.location', $q);
        $this->db->or_like('regulations.edition', $q);
        $this->db->or_like('regulations.publisher', $q);
        $this->db->or_like('regulations.language', $q);
        $this->db->or_like('regulations.subject', $q);
        $this->db->or_like('regulations.description', $q);
        $this->db->or_like('regulations.isbnissnnumber', $q);
        $this->db->or_like('regulations.viewed', $q);
        $this->db->or_like('regulations.downloaded', $q);
        $this->db->or_like('regulations.abstractfile', $q);
        $this->db->or_like('regulations.attachment', $q);
        $this->db->or_like('regulations.published', $q);
        $this->db->or_like('regulations.createdat', $q);
        $this->db->or_like('regulations.createdby', $q);
        $this->db->or_like('regulations.updatedat', $q);
        $this->db->or_like('regulations.updatedby', $q);
        $this->db->group_end();
        $this->db->order_by('regulations.id',$this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data) {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data) {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id) {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file regulations_model.php */
/* Location: ./application/models/regulations_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-11-09 10:16:08 */
/* http://harviacode.com */