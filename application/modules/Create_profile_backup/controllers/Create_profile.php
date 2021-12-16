<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_profile extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Create_profile_model');
	}

	public function index(){
		// if($this->session->userdata('user_type') == 'user' && $this->session->userdata('bids_logged_in') == TRUE){
		// 	redirect('Proposal');
		// } elseif($this->session->userdata('user_type') == 'admin' && $this->session->userdata('bids_logged_in') == TRUE OR $this->session->userdata('user_type') == 'super_admin' && $this->session->userdata('bids_logged_in') == TRUE ){
			$this->Create_profile_view();
		// } else {
		// 	redirect('Login');
		// }
	}

    public function add_pras_profile(){
        $result = $this->Create_profile_model->add_pras_profile();
        echo json_encode($result);
    }

	public function get_offices(){
		$office_name = strtolower($_GET['office_name']);
		$this->Create_profile_model->get_offices($office_name);
	}

	public function get_services(){
		if (isset($_GET['office_code'])){
			$service_name = strtolower($_GET['service_name']);
			$office_code = strtolower($_GET['office_code']);
			$this->Create_profile_model->get_services($service_name,$office_code);
		}
	}

	public function get_divisions(){
		if (isset($_GET['service_code'])){
			$division_name = strtolower($_GET['division_name']);
			$service_code = strtolower($_GET['service_code']);
			$office_code = strtolower($_GET['office_code']);
			$this->Create_profile_model->get_divisions($division_name,$service_code,$office_code);
		}
	}

	public function Create_profile_view(){
		$this->data['document_type'] = $this->Create_profile_model->document_type();
		$this->data['document_for'] = $this->Create_profile_model->document_for();
		$this->data['recipients'] = $this->Create_profile_model->recipients();
		$this->data['title'] = 'Add PRAS Profile';
		$this->middle 		 = 'Create_profile_view';
		$this->layout();
	}

	public function upload_file(){
		$this->load->library('form_validation');

		// echo '<pre>';\
		// print_r($this->input->post('doc_number'));
		// echo '</pre>';

		//$mode 		 = $this->input->get('mode');
		$doc_prefix  = $this->input->post('mode');
		$year    	 = date('Y');
		$month   	 = date('m');
		//$doc_type 	 = $doc_prefix[0];
		//$service	 = $this->session->userdata('service_long_name');

		$base_path = './uploads/';
		//$fullpath  = './uploads/'.$year.'/'.$month.'/'.$doc_type.'/'.$service;
		//$docPath   = './uploads/'.$year.'/'.$month.'/'.$doc_prefix;
		$docPath   = './uploads/attachment/'.$doc_prefix;
		$pathYear  = './uploads/'.$year;
		$pathMonth = './uploads/'.$year.'/'.$month;

		if(!is_dir($base_path)){
			$oldmask = umask(0);
			mkdir($base_path, 0775, TRUE);
			umask($oldmask);
		}

		if(!is_dir($pathYear)){
			$oldmask = umask(0);
			mkdir($pathYear, 0775, TRUE);
			umask($oldmask);
		}

		if(!is_dir($pathMonth)){
			$oldmask = umask(0);
			mkdir($pathMonth, 0775, TRUE);
			umask($oldmask);
		}

		if(!is_dir($docPath)){
			$oldmask = umask(0);
			mkdir($docPath, 0777, TRUE);
			umask($oldmask);
		}

		// if(!is_dir($fullpath)){
		// 	$oldmask = umask(0);
		// 	mkdir($fullpath, 0775, TRUE);
		// 	umask($oldmask);
		// }

		$this->load->library('upload');

		//$config['upload_path'] = "D:/uploads";
		//$config['upload_path']	= "https://devsysadd.da.gov.ph/philaimis/try_uploads";
		//$config['upload_path']	= "../../../uploads/";
		$config['upload_path']	= $docPath;
		$config['allowed_types']= 'pdf';//'jpg|jpeg|png|bitmap|pdf|docx|doc'
		$config['max_size']		= 0;
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload('doc_file')){
			$error = array('error' => $this->upload->display_errors());
			echo '<pre>';
			print_r($error);
			echo '</pre>';
		} else {
			$data = array(
				'uploaded_data' => $this->upload->data()
			);

			$file_name  = $data['uploaded_data']['file_name'];
			$pras_id = $this->input->post('pras_id');

			$db = 'pras_attachment_file';

			$results   = $this->Create_profile_model->insert_upload_details($file_name, $pras_id, $db);

			echo $results.'-'.$file_name;
		}
	}

	public function remove_uploaded_file(){
		$mode 		 = $this->input->post('mode');
		$rm_id		 = $this->input->post('rm_id', true);
		$doc_prefix  = explode('-', $this->input->post('doc_number'));
		$year    	 = date('Y');
		$month   	 = date('m');
		$doc_type 	 = $doc_prefix[0];
		//$service	 = $this->session->userdata('service_long_name');

		$fullpath  = FCPATH.'uploads/'.$year.'/'.$month.'/'.$doc_type;

		if($mode == 'd'){ //add details
			$db = 'document_details';
		}else { //add attachments
			$db = 'document_attachments';
		}

		$results = $this->Create_profile_model->remove_uploaded_file($rm_id, $db);

		if($results){
			unlink($fullpath.'/'.$this->input->post('rm_file_name', true));
		}
	}

	public function Create_profile_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('Create_profile.js');
	}
	
    public function check_exists(){
      	if (isset($_GET['params'])) {
	        $params = strtoupper($_GET['params']);
	        $results = $this->Create_profile_model->check_exists($params);
	      	echo json_encode($results);
    	}
	}

	public function get_recipients(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->Create_profile_model->get_recipients($q);
		}
	}

	public function get_signature_da_name(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->Create_profile_model->get_signature_da_name($q);
		}
	}
	public function get_signature_div_da(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->Create_profile_model->get_signature_div_da($q);
		}
	}

}