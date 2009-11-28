<?php
class dashboard extends Controller {

	function dashboard()
	{
		parent::Controller();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	function index()
	{
		$session_id = $this->session->userdata('session_id');
		$h_data = array('title' => 'Sublime Geek Control Panel - Please Login');
		$this->load->view('login',$h_data);
		
		$user = $this->input->post('username', TRUE);
		$pass = $this->input->post('password', TRUE);
		
		if($user && $pass)
		{
			
		}
		
		$this->output->enable_profiler(TRUE);			
	}
	
	function home()
	{
		$h_data = array(
               'title' => 'Sublime Geek Control Panel',
               'logo' => 'Sublime Geek <span>CP</span><em>v2.0</em>',
               'username' => 'Jon Desmoulins'               
          );		
		
		$this->load->view('header',$h_data);
		$this->load->view('menu');
		$this->load->view('index');
		$this->load->view('footer');
	}
}
?>
