<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('dts_logged_in') == FALSE) {
			redirect('Login');
			$this->load->view('Login_view');
		}
		$this->load->model('Dashboard_model');
	}

	public function index()
	{
		$this->data = [];
		$this->data['count_data'] = $this->Dashboard_model->get_count();
		$this->data['received_documents'] = $this->Dashboard_model->received_documents();
		$this->data['released_documents'] = $this->Dashboard_model->released_documents();
		$this->data['incoming_documents'] = $this->Dashboard_model->incoming_documents();
		$this->data['outgoing_documents'] = $this->Dashboard_model->outgoing_documents();
		// $this->data['check_status'] = $this->Dashboard_model->check_status();
		$this->data['title'] 		 = 'DTS | Dashboard';
		$this->middle 		 		 = 'Dashboard_view';
		$this->layout();
	}

	public function Received_Documents_view()
	{
		$this->data = [];
		$this->data['count_data'] = $this->Dashboard_model->get_count();
		$this->data['invalid_data'] = $this->Dashboard_model->get_invalid_count();
		$this->data['received_documents'] = $this->Dashboard_model->received_documents();
		$this->data['get_received_documents'] = $this->Dashboard_model->get_received_documents();
		$this->data['released_documents'] = $this->Dashboard_model->released_documents();
		$this->data['document_type'] = $this->Dashboard_model->get_document_type();
		$this->data['title'] 		 = 'DTS | Received Documents';
		$this->middle 		 		 = 'Received_Documents_view';
		$this->layout();
	}

	public function Released_Documents_view()
	{
		$this->data = [];
		$this->data['count_data'] = $this->Dashboard_model->get_count();
		$this->data['invalid_data'] = $this->Dashboard_model->get_invalid_count();
		$this->data['received_documents'] = $this->Dashboard_model->received_documents();
		$this->data['released_documents'] = $this->Dashboard_model->released_documents();
		$this->data['get_released_documents'] = $this->Dashboard_model->get_released_documents();
		$this->data['title'] 		 = 'DTS | Received Documents';
		$this->middle 		 		 = 'Released_Documents_view';
		$this->layout();
	}
	public function Incoming_Documents_view()
	{
		$this->data = [];
		$this->data['get_incoming_documents'] = $this->Dashboard_model->get_incoming_documents();
		$this->data['title'] 		 = 'DTS | Incoming Documents';
		$this->middle 		 		 = 'Incoming_Documents_view';
		$this->layout();
	}
	public function Outgoing_Documents_view()
	{
		$this->data = [];
		$this->data['title'] 		 = 'DTS | Outgoing Documents';
		$this->middle 		 		 = 'Outgoing_Documents_view';
		$this->layout();
	}

	public function Dashboard_js()
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('Dashboard.js');
	}
	public function Received_js()
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('Received_view.js');
	}

	public function received_documents()
	{
		$results = $this->Dashboard_model->received_documents();
		echo json_encode($results);
	}
	public function released_documents()
	{
		$results = $this->Dashboard_model->released_documents();
		echo json_encode($results);
	}

	public function get_history($document_number)
	{
		$results = $this->Dashboard_model->get_history($document_number);
		echo json_encode($results);
	}

	public function receive_document()
	{
		$result = $this->Dashboard_model->receive_document();
		echo json_encode($result);
	}
	public function check_status($document_number)
	{
		$result = $this->Dashboard_model->receive_document($document_number);
		echo json_encode($result);
	}
}
