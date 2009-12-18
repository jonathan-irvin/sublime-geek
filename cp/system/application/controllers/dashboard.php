<?php
class Dashboard extends Controller {

    function index()
    {   
        //For Testing
        $username = "Jon Desmoulins";
        
        //Inject the Configs
        $data_header	['title'] 			= "Sublime Geek CP";
        
        $data_masthead	['apptitle'] 		= "Sublime Geek <span>CP</span>";
        $data_masthead	['version'] 		= "2.0";
        $data_masthead	['username'] 		= $username;
        
        $data_navigation = array(
			
        );
        
        $data_content = "";
        
        $data_footer	['title'] 			= $data_header['title'];
        $data_footer	['version'] 		= $data_masthead['version'];
        $data_footer	['copy_year'] 		= "2008-2009";
        $data_footer	['company'] 		= "Sublime Geek";
        
        //Load the pieces
        $output  = $this->load->view('dashboard/header',		$data_header,		TRUE);
        $output .= $this->load->view('dashboard/masthead',		$data_masthead,		TRUE);
        $output .= $this->load->view('dashboard/navigation',	$data_navigation,	TRUE);
        $output .= $this->load->view('dashboard/content',		$data_content,		TRUE);
        $output .= $this->load->view('dashboard/footer',		$data_footer,		TRUE);
        
        //Display them
        $this->output->set_output($output);        
    }    

}
