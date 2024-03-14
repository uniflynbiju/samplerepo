<?php
class Csv_model extends CI_Model
{
    public function __construct()
    {
        /*call CodeIgniter's default Constructor*/
        parent::__construct();

        /*load model*/
        $this->load->model('Csv_model');
        $this->load->database();
        $this->load->helper('url');
    }

    // public function saverecords($data)
    // {

    //     $this->db->insert('csv', $data);
    // }


    public function getrecords($tableName)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result_array();
    }

    // public function get_column_values($value)
    // {

    //     $query = $this->db->select($value)->get('csv');
    //     return $query->result_array();
    // }


    //search method

    // public function searchRecords($searchTerm) {
    //     $this->db->like('song_name', $searchTerm);
    //     $query = $this->db->get('csv');

    //     return ($query->num_rows() > 0) ? $query->result_array() : false;
    // }


    public function getTables()
    {
        // Retrieve a list of tables from your database
        $tables = $this->db->list_tables();

        // Filter out tables that don't match your naming convention (csv_table_)
        $filteredTables = array_filter($tables, function ($table) {
            return strpos($table, 'csv_table_') !== false;
        });

        return $filteredTables;
    }

    public function getDataFromTable($table)
    {
        // Fetch data from the specified table
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function getSingleRow($tableName, $desiredType, $desiredMonthYear)
    {
        // Assuming 'type' and 'month_year' are columns in your tables
        $query = $this->db->get_where($tableName, array('type' => $desiredType, 'month_year' => $desiredMonthYear));

        // Return the first row if found, otherwise return false
        return $query->row_array();
    }

    // In Csv_model.php
public function getFileById($id)
{
    // Assuming 'csv_table_' is the common prefix for your tables
    $tableName = 'csv_table_' . $id;

    // Assuming 'id' is the primary key in your tables
    $query = $this->db->get_where($tableName, array('id' => $id));

    // Return the row data if found, otherwise return false
    return ($query->num_rows() > 0) ? $query->row_array() : false;
}
public function getFirstRow($tableName)
{
    // Fetch the first row from the specified table
    $query = $this->db->limit(1)->get($tableName);
    return $query->row_array();
}
public function getAllRecords($tableName)
{
    // Fetch all rows from the specified table
    $query = $this->db->get($tableName);
    return $query->result_array();
}



public function insert_data($data)
{
    return $this->db->insert('inputfield', $data);
}

public function reed_data()
{
    $query =  $this->db->get('inputfield'); //->result_array();
    return $query->result();
}




// public function updatePercentage($id, $newPercentage)
// {
//     // Update logic here
//     $data = array('percentage_field' => $newPercentage);
//     $this->db->where('id', $id);
//     $this->db->update('', $data);
// }

}
