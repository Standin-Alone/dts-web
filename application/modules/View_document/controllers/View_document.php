<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_document extends MY_Controller {

	public function __construct(){	
		parent::__construct();
		$this->load->model('View_document_model');
	}

	public function index(){
		$this->document();
	}

	public function document($doc_number = null){
		$this->data['document_information']	= $this->View_document_model->get_doc_information($doc_number);
		//$this->data['doc_types'] = $this->View_document_model->get_doc_types();
		//$this->data['offices'] 	 = $this->View_document_model->get_offices();
		$this->data['doc_number'] 			= $doc_number;
		$this->data['title'] 				= 'View Document | '.$doc_number;
		$this->middle 		 				= 'View_document_view';
		$this->layout();
	}

	public function update_status(){
		$results = $this->View_document_model->update_status();
		echo json_encode($results);
	}

	public function edit_document_info(){
		$results = $this->View_document_model->edit_document_info();
		echo json_encode($results);
	}

	public function edit_signatories(){
		$results = $this->View_document_model->edit_signatories();
		echo json_encode($results);
	}

	public function update_document_info(){
		$results = $this->View_document_model->update_document_info();
		echo json_encode($results);
	}

	public function update_sender_info(){
		$results = $this->View_document_model->update_sender_info();
		echo json_encode($results);
	}

	public function edit_document_sender(){
		$results = $this->View_document_model->edit_document_sender();
		echo json_encode($results);
	}

	public function get_da_services(){
    	$results = $this->View_document_model->get_da_services();
    	echo json_encode($results);
  	}

  	public function get_da_divisions(){
    	$results = $this->View_document_model->get_da_divisions();
    	echo json_encode($results);
  	}

	public function get_courier(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->View_document_model->get_courier($q);
		}
	}

	public function get_phlpost(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->View_document_model->get_phlpost($q);
		}
	}

	public function get_agency(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->View_document_model->get_agency($q);
		}
	}

	public function tracking($doc_number = null){
		$this->data['rc_logs']				= $this->View_document_model->get_rc_logs($doc_number);
		$this->data['doc_number'] 			= $doc_number;
		$this->data['title'] 				= 'Document Tracking | '.$doc_number;
		$this->middle 		 				= 'Tracking_view';
		$this->layout();
	}

	public function view_document_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('View_document.js');
	}

	public function upload_attachment(){
		$remarks 	= $this->input->post('remarks', true);
		$doc_number = $this->input->post('doc_number', true);

		$doc_prefix  = explode('-', $doc_number);
		$year    	 = date('Y');
		$month   	 = date('m');
		$doc_type 	 = $doc_prefix[0];
		$service	 = $this->session->userdata('service_long_name');

		$fullpath  = './uploads/'.$year.'/'.$month.'/'.$doc_type.'/'.$service;
		$docPath   = './uploads/'.$year.'/'.$month.'/'.$doc_type;
		$pathYear  = './uploads/'.$year;
		$pathMonth = './uploads/'.$year.'/'.$month;

		if(!is_dir($pathYear)){
			$oldmask = umask(0);
			mkdir($pathYear, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($pathMonth)){
			$oldmask = umask(0);
			mkdir($pathMonth, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($docPath)){
			$oldmask = umask(0);
			mkdir($docPath, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($fullpath)){
			$oldmask = umask(0);
			mkdir($fullpath, 0777, TRUE);
			umask($oldmask);
		}

		$this->load->library('upload');

		$config['upload_path']	= $fullpath;
		$config['allowed_types']= 'pdf';//'jpg|jpeg|png|bitmap|pdf|docx|doc'
		$config['max_size']		= 0;
		
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('doc_file')){
			$error = array('error' => $this->upload->display_errors());
			echo '<pre>';
			print_r($error);
			echo '</pre>';
		}else {
			$data = array(
				'uploaded_data' => $this->upload->data()
			);

			$file_name  = $data['uploaded_data']['file_name'];

			$result = $this->View_document_model->upload_amendments($remarks, $file_name, $doc_number);
		}

		$date = date('F d, Y, l, h:i A',strtotime($result[0]->date_uploaded));
		echo $result[0]->id.'*'.$date.'*'.$result[0]->full_name.'*'.$result[0]->file_name;
	}

	public function other_attach_title(){
		$result = $this->View_document_model->other_attach_title();
		echo json_encode($result);
	}

	public function archive_document(){
		$doc_number = $this->input->post('doc_number', true);

		$doc_prefix  = explode('-', $doc_number);
		$year    	 = date('Y');
		$month   	 = date('m');
		$doc_type 	 = $doc_prefix[0];
		$service	 = $this->session->userdata('service_long_name');

		$fullpath  = './uploads/'.$year.'/'.$month.'/'.$doc_type.'/'.$service;
		$docPath   = './uploads/'.$year.'/'.$month.'/'.$doc_type;
		$pathYear  = './uploads/'.$year;
		$pathMonth = './uploads/'.$year.'/'.$month;

		if(!is_dir($pathYear)){
			$oldmask = umask(0);
			mkdir($pathYear, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($pathMonth)){
			$oldmask = umask(0);
			mkdir($pathMonth, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($docPath)){
			$oldmask = umask(0);
			mkdir($docPath, 0777, TRUE);
			umask($oldmask);
		}

		if(!is_dir($fullpath)){
			$oldmask = umask(0);
			mkdir($fullpath, 0777, TRUE);
			umask($oldmask);
		}

		$this->load->library('upload');

		$config['upload_path']	= $fullpath;
		$config['allowed_types']= 'pdf';//'jpg|jpeg|png|bitmap|pdf|docx|doc'
		$config['max_size']		= 0;
		
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('doc_file')){
			$error = array('error' => $this->upload->display_errors());
			echo '<pre>';
			print_r($error);
			echo '</pre>';
		}else {
			$data = array(
				'uploaded_data' => $this->upload->data()
			);

			$file_name  = $data['uploaded_data']['file_name'];

			$result = $this->View_document_model->archive_document($file_name, $doc_number);

			echo $result;
		}
	}

	public function re_printQR($doc_number){
		$this->data['doc_number'] 			= $doc_number;
		$this->data['title'] 				= 'Document Tracking | '.$doc_number;
		$this->middle 		 				= 'Reprint_view';
		$this->layout();
		/*$data['doc_number'] = $doc_number;
		$this->load->view('Reprint_view', $data);*/
	}

	public function add_recipients(){
		$results = $this->View_document_model->add_recipients();
		echo json_encode($results);
	}

	public function add_recipients_v2(){
		$results = $this->View_document_model->add_recipients_v2();
		echo json_encode($results);
	}

	public function remove_recipient(){
		$results = $this->View_document_model->remove_recipient();
		echo json_encode($results);
	}


	public function get_signature_da_name(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_da_name($q,$w);
		}
	}

	public function get_signature_notda_name(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_notda_name($q,$w);
		}
	}

	public function get_signature_div_da(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_div_da($q);
		}
	}

	public function get_signature_other(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->View_document_model->get_signature_other($q);
		}
	}

	public function get_signature_office_other(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_office_other($q,$w);
		}
	}

	public function insert_signatories(){
		$results = $this->View_document_model->insert_signatories();
		echo json_encode($results);
	}

    public function remove_signature(){
        $result = $this->View_document_model->remove_signature();
        echo json_encode($result);
    }

    public function release_document1(){
        $result = $this->View_document_model->release_document1();
        echo json_encode($result);
    }

}
