<?php
class Login extends Controller {
	
	function Login()
	{
		parent::Controller();		
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{		
		$h_data = array('title' => 'Sublime Geek Control Panel - Please Login');
		$this->load->view('login',$h_data);
		$this->output->enable_profiler(FALSE);			
	}	
}
?>
