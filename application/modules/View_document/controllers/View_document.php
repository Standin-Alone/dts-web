<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_document extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('View_document_model');
		if($this->session->userdata('dts_logged_in') == FALSE){
			redirect('Login');
		}
	}

	public function index(){
		$this->document();
	}

	public function document($doc_number = null){
		$this->data['document_type'] = $this->View_document_model->document_type();
		$this->data['document_information']	= $this->View_document_model->get_doc_information($doc_number);
		$this->data['document_for'] = $this->View_document_model->document_for();
		$this->data['recipients'] = $this->View_document_model->recipients();
		$this->data['doc_number'] 			= $doc_number;
		$this->data['title'] 				= 'View Document | '.$doc_number;
		$this->middle 		 				= 'View_document_view';
		$this->layout();
	}

	public function edit_document_info(){
		$results = $this->View_document_model->edit_document_info();
		echo json_encode($results);
	}

	public function edit_signatories(){
		$results = $this->View_document_model->edit_signatories();
		echo json_encode($results);
	}

	public function get_signature_list(){
		$results = $this->View_document_model->get_signature_list();
		echo json_encode($results);
	}

	public function get_recipients_list(){
		$results = $this->View_document_model->get_recipients_list();
		echo json_encode($results);
	}

	public function update_document_info(){
		$results = $this->View_document_model->update_document_info();
		echo json_encode($results);
	}

	public function add_document_recipient(){
		$results = $this->View_document_model->add_document_recipient();
		echo json_encode($results);
	}

	public function get_signature_da_name(){
		if (isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_da_name($q);
		}
	}

	public function get_signature_div_da(){
		if (isset($_GET['term'])){
			$q = strtoupper($_GET['term']);
			//$w = strtolower($_GET['agency_id']);
			$this->View_document_model->get_signature_div_da($q);
		}
	}

	public function get_offices(){
		$results = $this->View_document_model->get_offices();
		echo json_encode($results);
	}

	public function view_document_js(){
		$this->output->set_content_type('text/javascript');
		$this->load->view('View_document.js');
	}

	public function check_in_recipients(){
		$results = $this->View_document_model->check_in_recipients();
		echo json_encode($results);
	}

	public function remove_recipient(){
		$results = $this->View_document_model->remove_recipient();
		echo json_encode($results);
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

    public function archive_document(){
        $result = $this->View_document_model->archive_document();
        echo json_encode($result);
    }

}
