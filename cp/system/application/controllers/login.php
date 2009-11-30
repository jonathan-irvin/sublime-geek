<?php
class login extends Controller {
	
	function login()
	{
		parent::Controller();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		$session_id = $this->session->userdata('session_id');
		$h_data = array('title' => 'Sublime Geek Control Panel - Please Login');
		$this->load->view('login',$h_data);
		$this->output->enable_profiler(TRUE);			
	}	
}
?>
