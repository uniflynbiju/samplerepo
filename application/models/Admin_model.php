<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_where_array($tbl_name, $data)
    {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $this->db->where($data);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_where_row($tbl_name, $data)
    {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $this->db->where($data);
        $query = $this->db->get()->row();
        return $query;
    }

    public function insert($tbl_name, $data)
    {
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
    }

    public function count_users()
    {
        $sql = "SELECT count(*) as count FROM `tbl_users` WHERE deleted = 0 AND id != 1";
        $result = $this->db->query($sql)->result_array();
        return $result[0]['count'];
    }

    public function update_detail($table_name, $data, $where)
    {
        $this->db->update($table_name, $data, $where);
        $this->db->get_where($table_name, $where);
        return true;
    }
}
?>