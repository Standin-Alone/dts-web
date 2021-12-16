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

    public function update_user(){
        $result = $this->My_documents_model->update_user();
        echo json_encode($result);
    }

	public function get_by_user(){
		$data = $this->My_documents_model->get_by_user();
		echo json_encode($data);
	}

	public function get_all(){
		$data = $this->My_documents_model->get_all();
		echo json_encode($data);
	}

	public function get_users_update(){
		$data = $this->My_documents_model->get_users_update();
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
	
    public function check_exists(){
      	if (isset($_GET['params'])) {
	        $params = strtoupper($_GET['params']);
	        $results = $this->My_documents_model->check_exists($params);
	      	echo json_encode($results);
    	}
	}

    public function register(){
		$email = $this->input->post('add_email', true);
		$fullname = 'DEPARTMENT OF AGRICULTURE';
		$username_register = $this->input->post('add_username', true);
		$password = 'adminpassword';
		$password_confirmation = 'adminpassword';
		$clean_pass = $this->security->xss_clean($password);
        $clean_pass_conf = $this->security->xss_clean($password_confirmation);


        if($clean_pass === $clean_pass_conf){
        	$pw_update_data = array(
    			'email' => $email,
    			'fullname' => $fullname,
    			'username' => $username_register,
    			'password' => $this->_encPass($clean_pass)
    		);
    		unset($clean_pass_conf);
    		$results = $this->My_documents_model->register($pw_update_data);
        }

		echo json_encode($results);
    }

	function _encPass($input, $rounds = 9){
		$salt = "";
		$saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
			for($i=0; $i<22; $i++){
				$salt .= $saltChars[array_rand($saltChars)];
			}
		return crypt($input, sprintf('$2y$%02d$', $rounds) .$salt);
    }

}
