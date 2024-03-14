<?php
class Csvupload extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->model('Csv_model');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->dbforge();
    }

    public function index()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('csv/list');
        $this->load->view('includes/footer');
    }

    public function company_method()
    {
        $this->load->view('document/company_view');
        if (isset($_POST['submit'])) {
            $data['company_name'] = $this->input->post('company_name');
            $result = $this->Admin_model->insert_data($data);

            if ($result === true) {
                redirect('csvupload/company_reed');
            } else {
                echo "Error inserting data: " . $result['message'];
            }
        }
    }

    public function company_reed()
    {
        $result['data'] = $this->Admin_model->reed_data();
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/company_view', $result);
        $this->load->view('includes/footer');
    }

    public function edit($id, $table_name)
    {

        $result['data'] = $this->Admin_model->edit_data($table_name, array('id' => $id));
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/update_view', $result);
        $this->load->view('includes/footer');
    }

    public function update()
    {
        if (isset($_POST['submit'])) {
            $table_name = $this->input->post('table_name');

            if (isset($_POST['id'])) {
                $id = $this->input->post('id');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($id)) {
                    $data['id'] = $id;
                }
            }

            if (isset($_POST['isrc'])) {
                $isrc = $this->input->post('isrc');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($isrc)) {
                    $data['isrc'] = $isrc;
                }
            }

            if (isset($_POST['Main_Label'])) {
                $Main_Label = $this->input->post('Main_Label');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($Main_Label)) {
                    $data['Main_Label'] = $Main_Label;
                }
            }

            if (isset($_POST['song_name'])) {
                $song_name = $this->input->post('song_name');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($song_name)) {
                    $data['song_name'] = $song_name;
                }
            }

            if (isset($_POST['album_name'])) {
                $album_name = $this->input->post('album_name');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($album_name)) {
                    $data['album_name'] = $album_name;
                }
            }

            if (isset($_POST['artist_name'])) {
                $artist_name = $this->input->post('artist_name');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($artist_name)) {
                    $data['artist_name'] = $artist_name;
                }
            }

            if (isset($_POST['income'])) {
                $income = $this->input->post('income');
                // Check if 'isrc' is not empty before adding it to the $data array
                if (!empty($income)) {
                    $data['income'] = $income;
                }
            }


            // Asuming $name is not defined, updating details based on other parameters
            $this->Admin_model->update_detail($table_name, $data, array('id' => $data['id']));
            redirect('csvupload/get_method');
        }
    }

    public function edit2($id, $table_name)
    {

        $result['data'] = $this->Admin_model->edit_data($table_name, array('id' => $id));
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/company_view2', $result);
        $this->load->view('includes/footer');
    }


    public function changeValue()
    {
        redirect('Csvupload/view_file');
    }

    public function delete($id)
    {
        // $this->load->model('Admin_model');
        $this->Admin_model->delete_record($id);
        redirect('csvupload/company_reed');
    }


    public function reed_form()
    {
        $result['data'] = $this->Csv_model->reed_data();
        $this->load->view('percentage_view', $result);
    }



    public function insert_data()
    {
        if (isset($_POST["submit"])) {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");

            // Read the first row to get column headers
            $headers = fgetcsv($handle, 1000, ",");



            // Process each row in the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                // Generate a unique table name based on the current timestamp
                $tableName = $tablePrefix . time();
                print_r($tableName);die;

                // Create a table with the generated name and columns based on headers
                $this->createTable($tableName, $headers);

                // Initialize an empty associative array for storing column data
                $rowData = array();

                // Iterate through each column in the row
                foreach ($headers as $index => $header) {
                    // Use the header as the column name and assign the corresponding value
                    $rowData[$header] = $data[$index];
                    print_r( $rowData[$header]);die;
                }

                // Insert the row data into the dynamically created table
                $this->insertIntoTable($tableName, $rowData);
            }

            fclose($handle);

            // Redirect to the desired page after processing the CSV
            redirect('csvupload/get_method');
        }
    }

    // Helper function to create a table
    public function createTable($tableName, $columns)
    {
        $fields = array(
            'id' => array('type' => 'INT', 'auto_increment' => true),
            'file_name' => array('type' => 'VARCHAR', 'constraint' => 255),
            'type' => array('type' => 'VARCHAR', 'constraint' => 255),
            'month_year' => array('type' => 'VARCHAR', 'constraint' => 255),
            'table_name' => array('type' => 'VARCHAR', 'constraint' => 255),
        );

        foreach ($columns as $column) {
            $fields[$column] = array('type' => 'VARCHAR', 'constraint' => 255);
        }

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table($tableName, true);
    }

    // Helper function to insert into the dynamically created table
    public function insertIntoTable($tableName, $data)
    {
        // Insert data into the table
        $this->db->insert($tableName, $data);
    }


    //get_method
    public function get_method()
    {
        // Fetch all table names with any prefix
        $tableQuery = $this->db->query("SHOW TABLES");

        if ($tableQuery->num_rows() > 0) {
            // If there are matching tables, fetch the data
            $tableNames = $tableQuery->result_array();
            $tableNames = array_reverse($tableNames, true);

            // Initialize result data
            $result['userData'] = array();

            foreach ($tableNames as $tableRow) {
                $tableName = current($tableRow);

                // Exclude specific tables (e.g., tbl_manager, tbl_roles)
                if ($tableName !== 'tbl_manager' && $tableName !== 'tbl_roles') {
                    // Get the first row from each table
                    $tableData = $this->Csv_model->getFirstRow($tableName);

                    // If a row is found, add it to the result array
                    if ($tableData) {
                        $result['userData'][] = $tableData;
                    }
                }
            }

            $this->load->view('includes/header');
            $this->load->view('includes/topbar');
            $this->load->view('includes/sidebar');
            $this->load->view('document/list', $result);
            $this->load->view('includes/footer');
        } else {
            // Handle the case where no tables are found
            redirect('Csvupload/documents_list');
        }
    }


    // public function get_method1()
    // {
    //     // Fetch all table names with the common prefix
    //     $tablePrefix = 'csv_table_';
    //     $tableQuery = $this->db->query("SHOW TABLES LIKE '{$tablePrefix}%'");
    //     // $tableQuery = $this->db->query("SHOW TABLES LIKE '{$tablePrefix}%' AND Tables_in_database NOT LIKE 'exclude_table1' AND Tables_in_database NOT LIKE 'exclude_table2'");

    //     // print_r($tableQuery);die;

    //     if ($tableQuery->num_rows() > 0) {
    //         // If there are matching tables, fetch the data
    //         $tableNames = $tableQuery->result_array();
    //         $tableNames = array_reverse($tableNames, true);

    //         // Initialize result data
    //         $result['userData'] = array();

    //         foreach ($tableNames as $tableRow) {
    //             $tableName = current($tableRow);

    //             // Get records from each table
    //             $tableData = $this->Csv_model->getrecords($tableName);

    //             // Merge the data into the result array
    //             $result['userData'] = array_merge($result['userData'], $tableData);
    //         }

    //         $this->load->view('includes/header');
    //         $this->load->view('includes/topbar');
    //         $this->load->view('includes/sidebar');
    //         $this->load->view('reports', $result);
    //         $this->load->view('includes/footer');
    //     } else {
    //         // Handle the case where no tables with the prefix are found
    //         echo "No tables found with the prefix '{$tablePrefix}'.";
    //     }
    // }


    public function percentage_method()
    {
        //$result = $this->Admin_model->get_where_row('inputfield', array('status'=>1 ,'deleted'=>0));
        //var_dump($result);

        $data['percentage'] = $this->Admin_model->get_where_array('inputfield', array('status' => 1, 'deleted' => 0));
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/percentage_view', $data);
        $this->load->view('includes/footer');
    }

    public function update_percentage()
    {
        $id = $this->input->post('id');
        $percentage = $this->input->post('percentage');

        $data = [
            'percentage' => $percentage,
        ];
        $where = ['id' => $id];
        $success = $this->Admin_model->update_detail2('inputfield', $data, $where);

        if ($success) {
            redirect('Csvupload/percentage_method');
        } else {
        }
    }


    public function documents_list()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/list');
        $this->load->view('includes/footer');
    }

    public function insert_doc()
    {
        if (isset($_POST["submit"])) {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");

            $headers = fgetcsv($handle, 1000, ",");
            $filename = $_FILES['file']['name'];  // Use the uploaded file name directly

            // Define a default value for $result
            $result = 'default_prefix';  // Change 'default_prefix' to your desired default value

            $pattern = '/^(.*?)_(\d{2}_\d{4})/';
            preg_match($pattern, $filename, $matches);
            if (count($matches) >= 3) {
                $amazonPart = $matches[1];
                $datePart = $matches[2];
                $result = $amazonPart . $datePart;
                echo $result;
            }

            $tablePrefix = $result;

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $tableName = $tablePrefix;

                $this->createTable($tableName, $headers);

                $rowData = array();

                foreach ($headers as $index => $header) {
                    $rowData[$header] = $data[$index];
                }

                // Add file_name, type, and month_year to $rowData
                $rowData['file_name'] = $_FILES['file']['name'];
                $rowData['type'] = $this->input->post('type');
                $rowData['month_year'] = $this->input->post('month_year');

                // Add table_name to $rowData
                $rowData['table_name'] = $tableName;

                // Insert the row data into the dynamically created table
                $this->insertIntoTable($tableName, $rowData);
            }

            fclose($handle);

            redirect('csvupload/get_method');
        }
    }


    public function view_file($tableName)
    {
        $this->load->model('Admin_model');
        // Fetch data from the specified table
        $tableData = $this->Csv_model->getAllRecords($tableName);
        $data['percentage'] = $this->Admin_model->get_where_array('inputfield', array('status' => 1, 'deleted' => 0));
        // print_r($data['percentage']);die;
        // Calculate total income
        $totalIncome = 0;
        foreach ($tableData as $row) {
            $totalIncome += isset($row['income']) ? $row['income'] : 0;
        }

        // Pass the total income and data to the view
        $data['totalIncome'] = $totalIncome;
        $data['userData'] = $tableData;

        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('document/view_file', $data); // Change 'document/view' to the actual path of your view file
        $this->load->view('includes/footer');
    }



    public function delete_table($tableName)
    {
        $this->dbforge->drop_table($tableName, true);
        redirect('Csvupload/get_method');
    }

    public function dashboard()
    {
        $allTables = $this->db->list_tables();
        $incomeData = [];

        foreach ($allTables as $tableName) {
            // Extract type from table name (assuming table names are like "type_tablename")
            $type = explode('_', $tableName)[0];



            if ($this->db->table_exists($tableName) && $this->db->field_exists('income', $tableName)) {
                $query = $this->db->select_sum('income')->get($tableName);
                $result = $query->row();
                $totalIncome = ($result) ? $result->income : 0;

                // Group by type
                if (!isset($incomeData[$type])) {
                    $incomeData[$type] = 0;
                }
                $incomeData[$type] += $totalIncome;
            }
        }

        $data['incomeData'] = $incomeData;

        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('test', $data); // Use the appropriate view file
        $this->load->view('includes/footer');
    }
}
