<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
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
		$this->data['title'] 		 = 'DTS | Dashboard';
		$this->middle 		 		 = 'Dashboard_view';
		$this->layout();
	}

	public function Received_Documents_view()
	{
		$this->data = [];
		$this->data['count_data'] = $this->Dashboard_model->get_count();
		$this->data['received_documents'] = $this->Dashboard_model->received_documents();
		$this->data['released_documents'] = $this->Dashboard_model->released_documents();
		$this->data['title'] 		 = 'DTS | Received Documents';
		$this->middle 		 		 = 'Received_Documents_view';
		$this->layout();
	}
	public function Released_Documents_view()
	{
		$this->data = [];
		$this->data['count_data'] = $this->Dashboard_model->get_count();
		$this->data['received_documents'] = $this->Dashboard_model->received_documents();
		$this->data['released_documents'] = $this->Dashboard_model->released_documents();
		$this->data['title'] 		 = 'DTS | Received Documents';
		$this->middle 		 		 = 'Released_Documents_view';
		$this->layout();
	}

	public function Dashboard_js()
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('Dashboard.js');
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
}
