<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {


	public function get_Header($result = false)
	{
		$this->load->view('includes/header',$result);
		$this->load->view('includes/topbar',$result);
		$this->load->view('includes/sidebar',$result);
	}

    public function get_Footer($result = false)
	{
		$this->load->view('includes/footer',$result);
	}
}
?>
