<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_management extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('email');
		$this->load->model('Users_management_model');
	}

	public function index(){
		$this->accounts();
	}

	public function accounts(){
		$this->data['title'] = 'Accounts';
		$this->middle 		 = 'Accounts_view';
		$this->layout();
	}

	public function send_invite(){
		$email 	 = $this->input->post('email', true);
		$results = $this->Users_management_model->check_email($email);

		$config['protocol']  = 'smtp';  
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '5';
		$config['mailtype']  = 'html';
		$config['smtp_user'] = 'support.sadd@da.gov.ph';
		$config['smtp_pass'] = 'B9F@kn@Ubz4GTLFe';
		$config['validate']	 = FALSE;
		$config['charset']  = 'iso-8859-1';
		$config['wordwrap'] = true;
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		//$token = $this->Users_management_model->insertToken($email);


		$email_template = '';
		$link = '';

		if(count($results) > 0){
			$user_token = $this->Users_management_model->insertOTP($results[0]->user_id,$email);
			$token 		= $this->base64url_encode($user_token);
			$url 		= base_url() . 'Login/information/token/'. $token;
			$link		= '<a href="'.$url.'">'.$url.'</a>';

			$subject = 'Reset Information | Document Tracking System';
			$email_template .= 'A request to reset the information for your account has been made at Document Tracking System of Department of Agriculture. <br> You may now reset your information by clicking 
                this link or copying and pasting it to your browser: <p></p';
            $email_template .= $link;
			$email_template .= '<p></p>This link can only be used once and will lead you to a page where
					you can complete your registration. It expires after one day and nothing will happen if it is not used. <br><p></p>';
			$email_template .= 'DA-ICTS SysADD | DTS Team<p></p>';
			$email_template .=  '<strong> This is a system-generated email, please do not reply.</strong>';
	
		}else {
			$user_token = $this->Users_management_model->pre_register($email);
			$token 		= $this->base64url_encode($user_token);
			$url 		= base_url() . 'Login/information/token/'. $token;
			$link		= '<a href="'.$url.'">'.$url.'</a>';

			$subject = 'User Invitation | Document Tracking System';
			$email_template .= 'Hi, your were invited to register to the Document Tracking System of Department of Agriculture.';
			$email_template .= '<br> To complete the registration, you may click this link or copying and pasting it to your browser: <p></p>';
			$email_template .= $link;
			$email_template .= '<p></p>This link can only be used once and will lead you to a page where
					you can complete your registration. It expires after one day and nothing will happen if it is not used. <br><p></p>';
			$email_template .= 'DA-ICTS SysADD | DTS Team<p></p>';
			$email_template .=  '<strong> This is a system-generated email, please do not reply.</strong>';
		}

		$this->email->from('support.sadd@da.gov.ph', 'no-reply');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($email_template);

		if($this->email->send()){
			$output['result'] = 'send';
		}else {
			$output['result'] = 'failed';
			$output['error'] = $this->email->print_debugger();
		}

		echo json_encode($output);

	}

	public function base64url_encode($data) { 
 	   return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	}  

	public function upload_users_csv(){
		echo json_encode('success');
	}

/*	public function accounts_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('My_documents.js');
	}*/
}