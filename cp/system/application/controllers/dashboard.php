<?php
class dashboard extends Controller {

	function dashboard()
	{
		parent::Controller();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		$user = $this->input->post('username', TRUE);
		$pass = $this->input->post('password', TRUE);
		
		if($user && $pass)
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
		}else{
			redirect('/login/', 'refresh');
		}
	}
}
?>
