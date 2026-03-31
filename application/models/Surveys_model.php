<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Surveys_model extends CI_Model {

    public $table = 'survey';
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    function insert($data) {
        $this->db->insert($this->table, $data);
    }

    function total_rows() {
        $this->db->from('survey');
        return $this->db->count_all_results();
    }

    function get_all() {
        return $this->db->get($this->table)->result();
    }

    //get all survey
    function get_all_count() {
        $this->db->select('
SUM(CASE WHEN svalue = 1 THEN 1 ELSE 0 END) AS count_1,
SUM(CASE WHEN svalue = 2 THEN 1 ELSE 0 END) AS count_2,
SUM(CASE WHEN svalue = 3 THEN 1 ELSE 0 END) AS count_3,
SUM(CASE WHEN svalue = 4 THEN 1 ELSE 0 END) AS count_4');
        $this->db->from($this->table);
        return $this->db->get()->row();
    }

}
