<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Mobile_app_model');
	}

	public function index(){

		$this->load->view('otp');
	}
	

    public function sign_in(){						
        $result = $this->Mobile_app_model->login();

        echo json_encode($result);
    }


	public function verify_otp(){
		$result = $this->Mobile_app_model->verify_otp();
		echo json_encode($result);
	}

	public function resend_otp(){
		$result = $this->Mobile_app_model->resend_otp();
		echo json_encode($result);
	}
	
	
	// transactions
	public function get_scanned_document(){
		$result = $this->Mobile_app_model->get_scanned_document();
		echo json_encode($result);
	}
	

	public function receive_document(){
		$result = $this->Mobile_app_model->receive_document();
		echo json_encode($result);
	}

	public function my_documents(){
		$result = $this->Mobile_app_model->my_documents();
		echo json_encode($result);
	}

	// incoming
	
	public function incoming_documents($my_office_code){
		$result = $this->Mobile_app_model->incoming_documents($my_office_code);
		echo json_encode($result);
	}

	// outgoing
	
	public function outgoing_documents($my_office_code,$page){
		$result = $this->Mobile_app_model->outgoing_documents($my_office_code,$page);
		echo json_encode($result);
	}

	public function get_history($document_number){
		$result = $this->Mobile_app_model->get_history($document_number);
		echo json_encode($result);
	}

	
	public function get_offices($document_number,$my_office_code){
		$result = $this->Mobile_app_model->get_offices($document_number,$my_office_code);
		echo json_encode($result);
	}


	public function get_last_recipients($document_number,$my_office_code){
		$result = $this->Mobile_app_model->get_last_recipients($document_number,$my_office_code);
		echo json_encode($result);
	}


	public function get_doc_type(){
		$result = $this->Mobile_app_model->get_doc_type();
		echo json_encode($result);
	}

	public function release_document(){
		$result = $this->Mobile_app_model->release_document();
		echo json_encode($result);
	}

	public function check_utility($version){
		$result = $this->Mobile_app_model->check_utility($version);
		echo json_encode($result);
	}

	public function get_actions(){
		$result = $this->Mobile_app_model->get_actions();
		echo json_encode($result);
	}


}