<?php

class Welcome extends CI_Controller {
	
	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->output->cache(60);
		$this->load->library('parser');
		$this->load->helper('url');		
		$this->load->helper('date');
		
		$this->data = array(
			'title'		=> 	'Sublime Geek',
			'products' 	=>  array(
				/*				
				array('product_name' => 'LiveMark - Dynamic LandMark System','product_url' 					=> 'http://blog.sblg.net/products/livemark-dynamic-landmark-system/'),
				array('product_name' => 'metaCast Cloud - Streaming Media Service','product_url' 			=> 'http://metacast.sblg.net/'),
				array('product_name' => 'metaTip - Web-Based Tip Jar','product_url' 								=> 'http://blog.sblg.net/products/metatip-instructions/'),
				array('product_name' => 'metaTrinity Task HUD','product_url' 										=> 'http://blog.sblg.net/products/metatrinity-todo-hud-instructions/'),
				array('product_name' => 'metaVotr Voting Box','product_url' 										=> 'http://blog.sblg.net/products/metavotr-instructions/')
				*/
				),
			'metavotr' 	=>  array(
				array('metavotr_name' => 'Hot Now!','metavotr_url' 													=> 'http://sblg.net/popular/'),
				array('metavotr_name' => 'Daily','metavotr_url' 														=> 'http://sblg.net/popular/daily'),
				array('metavotr_name' => 'Weekly','metavotr_url' 														=> 'http://sblg.net/popular/weekly'),
				array('metavotr_name' => 'Monthly','metavotr_url' 														=> 'http://sblg.net/popular/monthly'),
				array('metavotr_name' => 'All-Time','metavotr_url' 													=> 'http://sblg.net/popular/alltime')				
				),
			'links' 	=>  array(
				array('link_title'   => 'Second Life','link_url' 														=> 'http://secondlife.com'),				
				array('link_title'   => 'HippoTech','link_url' 	 														=> 'http://hippo-tech-sl.com'),
				array('link_title'   => 'Popular SL Locations','link_url' 	 										=> 'http://sblg.net/popular')
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
