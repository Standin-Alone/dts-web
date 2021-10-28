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
	

    public function login(){						
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
	
	



}