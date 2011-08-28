<?php

class Popular extends CI_Controller {
	
	var $data;
	
	function __construct()
	{
		parent::__construct();
		
		//Backend Specific		
		$this->load->helper('date');
		
		//Application Specific		
		$this->load->model('sg_popular');
		
		//Requires
		$this->load->library('parser');
		$this->load->helper('url');		
		//$this->output->cache(15);		
		
		$this->output->enable_profiler(FALSE);
		
		$DB 		= $this->load->database();
		$source 	= $this->uri->segment_array();
						
		$this->data = array(
			'title'		=> 	'Sublime Geek SL Popular Locations',
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
		$locations = $this->sg_popular->grab_ratings("1 HOUR",25);		
		$popular_title = array('popular_scope' => 'Hot Now! Top 25 Locations','location'	=> $locations);		
		$this->data = array_merge($this->data,$popular_title);
		
		$str = $this->db->last_query();
		
		//echo "<!-- ".$str." -->";
		
		$this->parser->parse('popular.php',$this->data);
	}
	
	function daily()
	{			
		$locations = $this->sg_popular->grab_ratings("1 DAY",25);		
		$popular_title = array('popular_scope' => 'Daily Top 25 Locations','location'	=> $locations);		
		$this->data = array_merge($this->data,$popular_title);
		$this->parser->parse('popular.php',$this->data);		
	}
	
	function weekly()
	{			
		$locations = $this->sg_popular->grab_ratings("168 HOUR",25);		
		$popular_title = array('popular_scope' => 'Weekly Top 25 Locations','location'	=> $locations);		
		$this->data = array_merge($this->data,$popular_title);
		$this->parser->parse('popular.php',$this->data);
	}
	
	function monthly()
	{			
		$locations = $this->sg_popular->grab_ratings("1 MONTH",25);		
		$popular_title = array('popular_scope' => 'Monthly Top 25 Locations','location'	=> $locations);		
		$this->data = array_merge($this->data,$popular_title);
		$this->parser->parse('popular.php',$this->data);
	}
	
	function alltime()
	{			
		$locations = $this->sg_popular->grab_ratings("10 YEAR",25);		
		$popular_title = array('popular_scope' => 'All-Time Top 25 Locations','location'	=> $locations);		
		$this->data = array_merge($this->data,$popular_title);
		$this->parser->parse('popular.php',$this->data);
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
