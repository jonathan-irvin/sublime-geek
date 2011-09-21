<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_SG_Admin extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Sublime Geek Admin'
			),
			'description' => array(
				'en' => 'Sublime Geek Admin Panel'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{

		// It worked!
		return TRUE;
	}

	public function uninstall()
	{
		// Get 
		
		return TRUE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// You could include a file and return it here.
		return "Some Help Stuff";
	}
}
/* End of file details.php */
