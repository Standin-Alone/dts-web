<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
{ 
    //set the class variable.
    public $template  = array();
    public $data      = array();
	
    /*Loading the default libraries, helper, language */
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form','language','url'));
        $this->load->library('user_agent');
    }
	
    /*Front Page Layout*/
    public function layout() {
        $this->template['assets']   = $this->load->view('template/assets', $this->data, true);
        $this->template['navbar']   = $this->load->view('template/navbar', $this->data, true);
        $this->template['topbar']   = $this->load->view('template/topbar', $this->data, true);
        $this->template['banner']   = $this->load->view('template/banner', $this->data, true);
        $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
        $this->template['footer'] = $this->load->view('template/footer', $this->data, true);
        $this->template['sidebar'] = $this->load->view('template/sidebar', $this->data, true);
        $this->load->view('template/front', $this->template);
    }
}