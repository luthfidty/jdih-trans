<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Regulations_model extends CI_Model
{
    public $table = 'regulations';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // In Regulations_model.php
    function get_by_id_simple($id)
    {
        $this->db->select('id');
        $this->db->from('regulations');
        $this->db->where('id', (int) $id); // Explicitly cast to int
        $this->db->where('groups', 'regulation');
        $this->db->where('isdeleted', 0);
        return $this->db->get()->row();
    }
    function bulk_delete($ids)
    {
        if (!is_array($ids) || empty($ids)) {
            log_message('debug', 'Bulk delete: No valid IDs provided');
            return 0;
        }

        $this->db->where('groups', 'regulation');
        $this->db->where('isdeleted', 0);
        $this->db->where_in('id', $ids);
        $this->db->update($this->table, array('isdeleted' => 1));

        $affected_rows = $this->db->affected_rows();
        log_message('debug', 'Bulk delete: Affected rows: ' . $affected_rows . ' for IDs: ' . print_r($ids, true));
        return $affected_rows;
    }
    // Get all
    function get_all($isdeleted = array('regulations.isdeleted' => 0), $published = array('regulations.published<>' => 'Pending'))
    {
        $this->db->select('regulations.*, documentcategories.category, documentcategories.acronym, documenttypes.documenttype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', 'regulation');
        $this->db->where($isdeleted);
        $this->db->where($published);
        return $this->db->get()->result();
    }

    // Get data by id
    function get_by_id($id, $isdeleted = array('regulations.isdeleted' => 0))
    {
        $this->db->select('regulations.*, documentcategories.category, documentcategories.acronym, uc.username, udc.fullname, uu.username as userupdate, uud.fullname as fullnameupdate, documenttypes.documenttype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->join('users uc', 'uc.id=regulations.createdby', 'left');
        $this->db->join('userdetails udc', 'udc.userid=uc.id', 'left');
        $this->db->join('users uu', 'uu.id=regulations.updatedby', 'left');
        $this->db->join('userdetails uud', 'uud.userid=uu.id', 'left');
        $this->db->where('regulations.groups', 'regulation');
        $this->db->where('regulations.id', $id);
        $this->db->where($isdeleted);
        return $this->db->get()->row();
    }

    // Get total rows
    function total_rows($whereby, $q = NULL, $conditions = array('regulations.isdeleted' => 0))
    {
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', 'regulation');
        $this->db->where($whereby);
        $this->db->where($conditions);
        if ($q !== NULL && $q !== '') {
            $this->db->group_start();
            $this->db->like('regulations.title', $q);
            $this->db->or_like('regulations.slug', $q);
            $this->db->or_like('regulations.documentcategory', $q);
            $this->db->or_like('regulations.doctype', $q);
            $this->db->or_like('regulations.teu', $q);
            $this->db->or_like('regulations.regulationnumber', $q);
            $this->db->or_like('regulations.registrationnumber', $q);
            $this->db->or_like('regulations.callnumber', $q);
            $this->db->or_like('regulations.year', $q);
            $this->db->or_like('regulations.edition', $q);
            $this->db->or_like('regulations.assignmentplace', $q);
            $this->db->or_like('regulations.assignmentdate', $q);
            $this->db->or_like('regulations.approvaldate', $q);
            $this->db->or_like('regulations.effectivedate', $q);
            $this->db->or_like('regulations.location', $q);
            $this->db->or_like('regulations.source', $q);
            $this->db->or_like('regulations.language', $q);
            $this->db->or_like('regulations.legalfield', $q);
            $this->db->or_like('regulations.subject', $q);
            $this->db->or_like('regulations.cluster', $q);
            $this->db->or_like('regulations.status', $q);
            $this->db->or_like('regulations.detailstatus', $q);
            $this->db->or_like('regulations.bookcover', $q);
            $this->db->or_like('regulations.isbnissnnumber', $q);
            $this->db->or_like('regulations.publisher', $q);
            $this->db->or_like('regulations.description', $q);
            $this->db->or_like('regulations.liked', $q);
            $this->db->or_like('regulations.abstract', $q);
            $this->db->or_like('regulations.abstractfile', $q);
            $this->db->or_like('regulations.attachment', $q);
            $this->db->or_like('regulations.published', $q);
            $this->db->or_like('regulations.publishdate', $q);
            $this->db->or_like('regulations.reason', $q);
            $this->db->or_like('regulations.isdeleted', $q);
            $this->db->or_like('regulations.createdat', $q);
            $this->db->or_like('regulations.createdby', $q);
            $this->db->or_like('regulations.updatedat', $q);
            $this->db->or_like('regulations.updatedby', $q);
            $this->db->or_like('documentcategories.category', $q);
            $this->db->or_like('documentcategories.acronym', $q);
            $this->db->or_like('documenttypes.documenttype', $q);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    // Get data with limit and search
    function get_limit_data($whereby, $limit, $start = 0, $q = NULL, $conditions = array('regulations.isdeleted' => 0), $sort_by = 'regulations.id', $sort_order = 'desc')
    {
        $this->db->select('regulations.*, documentcategories.category, documentcategories.acronym, documenttypes.documenttype');
        $this->db->from('regulations');
        $this->db->join('documentcategories', 'documentcategories.id=regulations.documentcategory', 'left');
        $this->db->join('documenttypes', 'documenttypes.id=regulations.doctype', 'left');
        $this->db->where('regulations.groups', 'regulation');
        $this->db->where($whereby);
        $this->db->where($conditions);
        if ($q !== NULL && $q !== '') {
            $this->db->group_start();
            $this->db->like('regulations.title', $q);
            $this->db->or_like('regulations.slug', $q);
            $this->db->or_like('regulations.documentcategory', $q);
            $this->db->or_like('regulations.doctype', $q);
            $this->db->or_like('regulations.teu', $q);
            $this->db->or_like('regulations.regulationnumber', $q);
            $this->db->or_like('regulations.registrationnumber', $q);
            $this->db->or_like('regulations.callnumber', $q);
            $this->db->or_like('regulations.year', $q);
            $this->db->or_like('regulations.edition', $q);
            $this->db->or_like('regulations.assignmentplace', $q);
            $this->db->or_like('regulations.assignmentdate', $q);
            $this->db->or_like('regulations.approvaldate', $q);
            $this->db->or_like('regulations.effectivedate', $q);
            $this->db->or_like('regulations.location', $q);
            $this->db->or_like('regulations.source', $q);
            $this->db->or_like('regulations.language', $q);
            $this->db->or_like('regulations.legalfield', $q);
            $this->db->or_like('regulations.subject', $q);
            $this->db->or_like('regulations.cluster', $q);
            $this->db->or_like('regulations.status', $q);
            $this->db->or_like('regulations.detailstatus', $q);
            $this->db->or_like('regulations.bookcover', $q);
            $this->db->or_like('regulations.isbnissnnumber', $q);
            $this->db->or_like('regulations.publisher', $q);
            $this->db->or_like('regulations.description', $q);
            $this->db->or_like('regulations.liked', $q);
            $this->db->or_like('regulations.abstract', $q);
            $this->db->or_like('regulations.abstractfile', $q);
            $this->db->or_like('regulations.attachment', $q);
            $this->db->or_like('regulations.published', $q);
            $this->db->or_like('regulations.publishdate', $q);
            $this->db->or_like('regulations.reason', $q);
            $this->db->or_like('regulations.isdeleted', $q);
            $this->db->or_like('regulations.createdat', $q);
            $this->db->or_like('regulations.createdby', $q);
            $this->db->or_like('regulations.updatedat', $q);
            $this->db->or_like('regulations.updatedby', $q);
            $this->db->or_like('documentcategories.category', $q);
            $this->db->or_like('documentcategories.acronym', $q);
            $this->db->or_like('documenttypes.documenttype', $q);
            $this->db->group_end();
        }
        $this->db->order_by($sort_by, $sort_order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // Get distinct years
    function get_years()
    {
        $this->db->select('year');
        $this->db->from('regulations');
        $this->db->where('regulations.groups', 'regulation');
        $this->db->where('regulations.isdeleted', 0);
        $this->db->where('regulations.year IS NOT NULL', NULL, FALSE);
        $this->db->where('regulations.year !=', '');
        $this->db->group_by('year');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get();
        return array_column($query->result_array(), 'year');
    }

    function get_total_doc_by_year()
    {
        $this->db->select('date_format(updatedat,"%Y") as years, count(*) as numdocs');
        $this->db->from('regulations');
        $this->db->group_by('year(updatedat)');
        return $this->db->get()->result();
    }

    function total_docs()
    {
        $this->db->from('regulations');
        return $this->db->count_all_results();
    }

    function get_total_doc_by_category()
    {
        $this->db->select('dc.acronym, count(doc.id) as numdocs');
        $this->db->from('regulations doc');
        $this->db->join('documentcategories dc', 'dc.id=doc.documentcategory');
        $this->db->where('doc.groups', 'regulation');
        $this->db->group_by('dc.id');
        return $this->db->get()->result();
    }

    // Insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // Update data
    function update($id, $data)
    {
        $this->db->where('groups', 'regulation');
        $this->db->where($this->id, (int) $id); // Explicitly cast to int
        $this->db->update($this->table, $data);
    }

    // Delete data
    function delete($id)
    {
        $this->db->where('groups', 'regulation');
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}