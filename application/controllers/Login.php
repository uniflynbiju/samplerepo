<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends My_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->model('Admin_model');
	}

	public function index()
	{
		$this->load->view('login');
	}

    public function auth()
	{
		if (isset($_POST['save'])) {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$this->form_validation->set_rules('email', 'email', 'required');
			$this->form_validation->set_rules('password', 'password', 'required');

			if ($this->form_validation->run()) {

				$log_details = $this->Admin_model->get_where_array('tbl_manager', array('email' => $email, 'deleted' => 0));

				if (!empty($log_details)) {
                    
					if($log_details['0']['status'] == 1) {

						if ($log_details['0']['password'] == $password) {

					        $check_roles = $this->Admin_model->get_where_array('tbl_roles', array('id' => $log_details['0']['role'], 'deleted' => 0,'status'=>1));

                            if(!empty($check_roles)){

                                $sess_data = array(
                                    'id' 		=> 	$log_details['0']['id'],
                                    'email'  	=> 	$log_details['0']['email'],
                                    'role' 	=> 	$log_details['0']['role'],
                                );
                                $this->session->set_userdata($sess_data);
                                redirect('admin');
                            }else{
                                $this->session->set_flashdata('unsuccess', 'Roles Not Been Asigned');
                                redirect('login');
                            }
						} else {
							$this->session->set_flashdata('unsuccess', 'Incorrect Password');
							redirect('login');
						}
					} else {
						$this->session->set_flashdata('unsuccess', 'Your Account Has Been Deactivated');
						redirect('login');
					}
				} else {
					$this->session->set_flashdata('unsuccess', 'Invalid Credentials');
					redirect('login');
				}
			} else {
				$this->session->set_flashdata('unsuccess', 'Credentials Missing');
				redirect('login');
			}
		}else{
			redirect('login');
		}
	}
}
?>
