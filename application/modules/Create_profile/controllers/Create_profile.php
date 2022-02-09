<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_profile extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Create_profile_model');
		if($this->session->userdata('dts_logged_in') == FALSE){
			redirect('Login');
		}
	}

	public function index(){ 
		$this->Create_profile_view();
	}

    public function add_profile(){
        $result = $this->Create_profile_model->add_profile();
        echo json_encode($result);
    }

	public function get_offices(){
		$results = $this->Create_profile_model->get_offices();
		echo json_encode($results);
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
		$this->data['title'] = 'Create Document';
		$this->middle 		 = 'Create_profile_view';
		$this->layout();
	}

	public function upload_file(){
		$this->load->library('form_validation');

		// echo '<pre>';\
		// print_r($this->input->post('doc_number'));
		// echo '</pre>';

		$doc_number  = $this->input->post('doc_number');
		$doc_prefix  = $this->input->post('doc_type');
		$mode  	 = $this->input->post('mode');

		if($mode == 'file'){ //add details
			$folder_name = 'files';
		}else { //add attachments
			$folder_name = 'attachments';
		}

		$year    	 = date('Y');
		$month   	 = date('m');

		$base_path = './uploads/';
		$docPath   = './uploads/'.$folder_name.'/'.$doc_prefix;

		if(!is_dir($base_path)){
			$oldmask = umask(0);
			mkdir($base_path, 0775, TRUE);
			umask($oldmask);
		}

		if(!is_dir($docPath)){
			$oldmask = umask(0);
			mkdir($docPath, 0777, TRUE);
			umask($oldmask);
		}

		$this->load->library('upload');
		$config['upload_path']	= $docPath;
		$config['allowed_types']= 'pdf';//'jpg|jpeg|png|bitmap|pdf|docx|doc'
		$config['max_size']		= 0;
		$oldname = $_FILES["doc_file"]['name'];
		$config['file_name'] = trim(strtolower(md5(time().$oldname)));
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
			$db = 'document_file';

			$results   = $this->Create_profile_model->insert_upload_details($file_name, $doc_number, $doc_prefix, $mode, $db);

			echo $results.'-'.$file_name;
		}
	}

	public function remove_uploaded_file(){
		$mode 		 = $this->input->post('mode');
		$rm_id		 = $this->input->post('rm_id', true);
		//$doc_prefix  = explode('-', $this->input->post('doc_number'));
		$year    	 = date('Y');
		$month   	 = date('m');
		$doc_type 	 = $this->input->post('doc_type', true);

		if($mode == 'file'){ //add details
			$folder_name = 'files';
		}else { //add attachments
			$folder_name = 'attachments';
		}

		$fullpath  = FCPATH.'uploads/'.$folder_name.'/'.$doc_type;

		$results = $this->Create_profile_model->remove_uploaded_file($rm_id);

		if($results){
			unlink($fullpath.'/'.$this->input->post('rm_file_name', true));
		}
	}

	public function Create_profile_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('Create_profile.js');
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
			$q = strtoupper($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->Create_profile_model->get_signature_div_da($q);
		}
	}

	public function get_sender_name(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->Create_profile_model->get_sender_name($q);
		}
	}

	public function insert_signatories(){
		$results = $this->Insert_document_model->insert_signatories();
		echo json_encode($results);
	}

	public function qr_code($size1,$size2,$doc_number){
		$this->load->library('phpqrcode/qrlib');

		//$QR = QRcode::png($doc_number, false,QR_ECLEVEL_H, 3, 2, true);
		$QR = QRcode::png($doc_number, false,QR_ECLEVEL_H, $size1, $size2, true);

		return $QR;
	}

	public function document_recipients(){
		$doc_number 		 = $this->input->post('doc_number');
		$results = $this->Create_profile_model->document_recipients($doc_number);
		echo json_encode($results);
	}

}
