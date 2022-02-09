<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_documents extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('My_documents_model');
	}

	public function index(){
		if($this->session->userdata('dts_logged_in') == TRUE){
			$this->My_documents_view();
		} else {
			redirect('Login');
		}
	}

	public function get_by_user(){
		$data = $this->My_documents_model->get_by_user();
		echo json_encode($data);
	}

	public function get_all(){
		$data = $this->My_documents_model->get_all();
		echo json_encode($data);
	}

	public function My_documents_view(){
		$this->data['title'] = 'My Documents';
		$this->middle 		 = 'My_documents_view';
		$this->layout();
	}

	public function My_documents_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('My_documents.js');
	}
	
}
