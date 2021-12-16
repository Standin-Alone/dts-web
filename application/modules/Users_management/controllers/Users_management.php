<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_management extends MY_Controller {

	public function index(){
		$this->accounts();
	}

	public function accounts(){
		$this->data['title'] = 'Accounts';
		$this->middle 		 = 'Accounts_view';
		$this->layout();
	}

/*	public function accounts_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('My_documents.js');
	}*/
}