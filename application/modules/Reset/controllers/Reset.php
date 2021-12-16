<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends CI_Controller {

	public function index(){
		$this->validate_email();
	}

	public function validate_email(){
		$this->load->view('Validate_email_view');
	}

	public function check_email(){
		$this->load->model('Reset_model');

		$results = $this->Reset_model->check_email();

		if($results > 0){
			
		}
		//echo json_encode($results);
	}

}