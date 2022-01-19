<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		if($this->session->userdata('dts_logged_in') == TRUE){
			redirect('Dashboard');
		}else {
			$this->load->view('Login_view');
		}
	}

	public function otp($token_value){
		if($this->session->userdata('dts_logged_in') == TRUE){
			redirect('Dashboard');
		}
		/*$this->load->library('encryption');
		$this->load->model('Login_model');

		$token 		= $this->base64url_decode($token_value);
		$cleanToken = $this->security->xss_clean($token);
		$user_info  = $this->Login_model->check_active_otp($cleanToken);*/
		$data['token'] = $token_value;
		$this->load->view('Login_otp', $data);
	}

	public function check_otp(){
		$this->load->library('encryption');
		$this->load->model('Login_model');

		$token_value = $this->input->post('utoken', true);
		$otp 		 = $this->input->post('otp', true);
		$token 		 = $this->base64url_decode(trim($token_value));
		$cleanToken  = $this->security->xss_clean($token);

		$uid   = substr($cleanToken, 6, 36);
		$email = substr($cleanToken, 42);

		$results = $this->Login_model->check_active_otp(trim($otp),trim($uid),trim($email));

		if($results['result'] == 'success'){
			$this->session->set_userdata($results['user_data']);
			$this->Login_model->deactivate_token($results['user_data']['user_id']);
		}

		echo json_encode($results);
	}

	public function resend_otp(){
		$this->load->library('encryption');
		$this->load->model('Login_model');

		$token_value = $this->input->post('utoken', true);
		$token 		 = $this->base64url_decode($token_value);
		$cleanToken  = $this->security->xss_clean($token);

		$otp   = substr($cleanToken, 0, 6);
		$uid   = substr($cleanToken, 6, 36);
		$email = substr($cleanToken, 42);

		$results = $this->Login_model->insertOTP($uid, $email);

		$output['result'] = 'success';
		$output['token']  = $this->security->get_csrf_hash();

		echo json_encode($output);
	}

	public function recover(){
		$this->load->view('Validate_email_view');
	}

	public function check_email(){
		$this->load->model('Login_model');
		$output['result'] = 'failed';
		$output['token']  = $this->security->get_csrf_hash();

		$results = $this->Login_model->check_email();

		if($results > 0){


			$output['result'] = 'success';
		}

		echo json_encode($output);
	}

	public function check(){
		$this->load->model('Login_model');
		$email 	  = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		$results = $this->Login_model->check_user($email, $password);
		echo json_encode($results);
	}

	public function information($token_name, $token_value){
		if($token_name != 'token'){
			redirect('Login');
		}

		$this->load->library('encryption');
		$this->load->model('Login_model');

		$token 		 = $this->base64url_decode(trim($token_value));
		$cleanToken  = $this->security->xss_clean($token);

		$otp   = substr($cleanToken, 0,6);
		$uid   = substr($cleanToken, 6, 36);
		$email = substr($cleanToken, 42);

		$results = $this->Login_model->check_active_otp(trim($otp),trim($uid),trim($email));

		if($results['result'] == 'success'){
			$output['user_data'] = $results['user_data'];
			$output['utoken']	 = $token_value;

			$this->load->view('Create_account_view', $output);

		}else {
			redirect('Login');
		}
	}

	public function insert_user_information(){
		$this->load->model('Login_model');
		$utoken_value = $this->input->post('utoken', true);
		$cleanToken 	  = $this->base64url_decode(trim($utoken_value));

		$uid   = substr($cleanToken, 6, 36);

		$result = $this->Login_model->insert_user_information($uid);
		echo json_encode($result);
	}

	public function get_offices(){
		$this->load->model('Login_model');
		$results = $this->Login_model->get_offices();
		echo json_encode($results);
	}

	public function logout(){
		if($this->session->userdata('dts_logged_in') == TRUE){
			$ci =& get_instance();
			$ci->session->sess_destroy();
		}
		redirect(base_url());
	}

	public function base64url_decode($data) { 
    	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 

	public function Login_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('Login.js');
	}
}