<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct(){	
		parent::__construct();
		$this->load->model('Dashboard_model');
	}
	
	public function index(){
			$this->data['title'] 		 = 'Dashboard';
			$this->middle 		 		 = 'Dashboard_view';
			$this->layout();
	}

	public function dashboard_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('Dashboard.js');
	}

}