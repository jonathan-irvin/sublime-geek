<?php

class Welcome extends Controller {
	
	var $data;
	
	function Welcome()
	{
		parent::Controller();
		$this->output->cache(60);
		$this->load->library('parser');
		$this->load->helper('url');		
		$this->load->helper('date');
		
		$this->data = array(
			'title'		=> 	'Sublime Geek',
			'products' 	=>  array(
				array('product_name' => 'LiveMark - Dynamic LandMark System','product_url' 					=> 'http://blog.sublimegeek.com/products/livemark-dynamic-landmark-system/'),
				array('product_name' => 'metaCast Cloud - Streaming Media Service','product_url' 			=> 'http://metacast.sublimegeek.com/'),
				array('product_name' => 'metaTip - Web-Based Tip Jar','product_url' 						=> 'http://blog.sublimegeek.com/products/metatip-instructions/'),
				array('product_name' => 'metaTrinity Task HUD','product_url' 								=> 'http://blog.sublimegeek.com/products/metatrinity-todo-hud-instructions/'),
				array('product_name' => 'metaVotr Voting Box','product_url' 								=> 'http://blog.sublimegeek.com/products/metavotr-instructions/')
				),
			'metavotr' 	=>  array(
				array('metavotr_name' => 'Hot Now!','metavotr_url' 											=> 'http://sublimegeek.com/popular/'),
				array('metavotr_name' => 'Daily','metavotr_url' 											=> 'http://sublimegeek.com/popular/daily'),
				array('metavotr_name' => 'Weekly','metavotr_url' 											=> 'http://sublimegeek.com/popular/weekly'),
				array('metavotr_name' => 'Monthly','metavotr_url' 											=> 'http://sublimegeek.com/popular/monthly'),
				array('metavotr_name' => 'All-Time','metavotr_url' 											=> 'http://sublimegeek.com/popular/alltime')				
				),
			'links' 	=>  array(
				array('link_title'   => 'Second Life','link_url' 											=> 'http://secondlife.com'),
				array('link_title'   => 'Apez.Biz','link_url' 	 											=> 'http://apez.biz'),
				array('link_title'   => 'HippoTech','link_url' 	 											=> 'http://hippo-tech-sl.com'),
				array('link_title'   => 'Popular SL Locations','link_url' 	 								=> 'http://sublimegeek.com/popular')
				)			
		);
	}
	
	function index()
	{		
		$DB 		= $this->load->database();
		$source 	= $this->uri->segment_array();		
		
		$this->parser->parse('index.php',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
