<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends My_Controller {
	
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
		$role = $this->session->userdata('role');

		if($role){

			$result['role'] = $role;
			$this->get_Header($result);
			$this->load->view('dashboard');
			$this->get_Footer($result);
		}else{
			redirect('login');
		}
	}
}
?>
