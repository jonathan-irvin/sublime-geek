<?php
class Dashboard extends Controller {

	function Dashboard()
	{
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('url');	
	}
	
	function index()
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
