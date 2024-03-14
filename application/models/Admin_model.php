<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function store($data)
    {
        $this->db->insert('customer', $data);
        return true;
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

    public function insert_data($data)
    {
        return $this->db->insert('crudcd', $data);
    }

    public function reed_data()
    {
        $query =  $this->db->get('crudcd'); //->result_array();
        return $query->result();
    }

    public function edit_data($table, $data)
    {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($data);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_detail($table_name, $data, $where)
    {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->update($table_name, $data);
        return true;
    }

    public function getAllRecords($tableName ,$data)
    {
        // Fetch all rows from the specified table
        $query = $this->db->get($tableName , $data);
        return $query->result_array();
    }

    public function update_details($name, $id)
    {
        $query = "UPDATE crudcd SET company_name='$name' WHERE id='$id'";
        $result = $this->db->query($query);

        if (!$result) {
            // Display or log the database error
            echo $this->db->error();
        }
    }

    public function delete_record($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('crudcd');
    }




    public function count_users()
    {
        $sql = "SELECT count(*) as count FROM `client` WHERE service_package = 1 OR product_pckage = 1";
        $result = $this->db->query($sql)->result_array();
        return $result[0]['count'];
    }

    public function get_count($table_name = '', $where = array())
    {
        return $this->db->get_where($table_name, $where)->num_rows();
    }

    

    public function update_detail2($table_name, $data, $where)
    {
        $this->db->update($table_name, $data, $where);

        // Check if the update was successful
        return $this->db->affected_rows() > 0;
    }

    public function get_transaction()
    {
        $this->db->select("a.cost,a.type,a.created_at,a.user_id,a.provider_id,a.trasaction_id,b.booking_id");
        $this->db->from("transactions as a");
        $this->db->join('booking as b', 'a.booking_id = b.id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_rating()
    {
        $this->db->select("c.name as client_name,b.name as pro_name ,a.rating ");
        $this->db->from("tbl_rating_prof as a");
        $this->db->join('provider as b', 'a.prof_id = b.id');
        $this->db->join('client as c', 'a.user_id = c.id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_order_details($where = array())
    {
        $this->db->select("b.name as client_name,c.name as product_name,c.cost,a.sub_total,a.qty,a.booking_id as order_id");
        $this->db->from("order_items as a");
        $this->db->join('client as b', 'a.user_id = b.id');
        $this->db->join('products as c', 'a.product_id = c.id');
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}
