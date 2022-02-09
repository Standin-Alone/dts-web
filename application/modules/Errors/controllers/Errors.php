<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function __construct(){	
		parent::__construct();
		if(!$this->session->userdata('dts_logged_in')){
			redirect('Login');
		}
	}

	public function index(){
		$this->document_not_found();
	}

	public function document_not_found(){
		$this->load->view('Errors/E_not_exists');
		// $this->data['title'] = 'Document Tracking | Error on profiling a document';
		// $this->middle 		 = 'E_not_exists';
		// $this->layout();
	}

	public function not_allowed(){
		$this->load->view('Errors/E_not_received');
		// $this->data['title'] = 'Document Tracking | Error on profiling a document';
		// $this->middle 		 = 'E_not_received';
		// $this->layout();
	}

}