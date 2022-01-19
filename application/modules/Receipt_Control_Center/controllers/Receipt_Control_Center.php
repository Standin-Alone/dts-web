<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receipt_Control_Center extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('dts_logged_in') == FALSE) {
			redirect('Login');
			$this->load->view('Login_view');
		}
		$this->load->library('upload');
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$this->load->model('RCC_model');
	}

	public function index()
	{
		$this->data['title']          = 'Receipt Control Center';
		$this->middle                   = 'RCC_view';
		$this->layout();
	}

	public function Receive()
	{
		$this->data['title']          = 'DTS | Receive Document';
		$this->data['incoming_documents'] = $this->RCC_model->incoming_documents();
		$this->data['invalid_data'] = $this->RCC_model->get_invalid_count();
		$this->data['count_data'] = $this->RCC_model->get_count();
		$this->data['received_documents']          = $this->RCC_model->received_documents();
		$this->data['get_received_documents'] = $this->RCC_model->get_received_documents();
		$this->middle                   = 'Receive_view';
		$this->layout();
	}

	public function Release()
	{
		$this->data['title']          = 'DTS | Release Document';
		$this->data['count_data'] = $this->RCC_model->get_count();
		$this->data['recipients']          = $this->RCC_model->recipients();
		$this->data['invalid_data'] = $this->RCC_model->get_invalid_count();
		$this->data['received_documents']          = $this->RCC_model->received_documents();
		$this->data['get_released_documents'] = $this->RCC_model->get_released_documents();
		$this->middle                   = 'Release_view';
		$this->layout();
	}

	public function RCC_js()
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('RCC.js');
	}
	public function Release_js()
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('Release.js');
	}

	public function receive_document()
	{
		$result = $this->RCC_model->receive_document();
		echo json_encode($result);
	}
	public function release_document()
	{
		$result = $this->RCC_model->release_document();
		echo json_encode($result);
	}

	public function get_history($document_number)
	{
		$results = $this->RCC_model->get_history($document_number);
		echo json_encode($results);
	}
	public function Get_origin_current_office($document_number)
	{
		$result = $this->RCC_model->get_origin_current_office($document_number);
		echo json_encode($result);
	}

	public function upload_file()
	{

		if (!empty($_FILES)) {
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
			$docPath   = './uploads/attachment/' . $doc_prefix;
			$pathYear  = './uploads/' . $year;
			$pathMonth = './uploads/' . $year . '/' . $month;

			if (!is_dir($base_path)) {
				$oldmask = umask(0);
				mkdir($base_path, 0775, TRUE);
				umask($oldmask);
			}

			if (!is_dir($pathYear)) {
				$oldmask = umask(0);
				mkdir($pathYear, 0775, TRUE);
				umask($oldmask);
			}

			if (!is_dir($pathMonth)) {
				$oldmask = umask(0);
				mkdir($pathMonth, 0775, TRUE);
				umask($oldmask);
			}

			if (!is_dir($docPath)) {
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
			$config['allowed_types'] = 'pdf'; //'jpg|jpeg|png|bitmap|pdf|docx|doc'
			$config['max_size']		= 0;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('doc_file')) {
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

				$db = 'da_dts_db';

				$results   = $this->Add_profile_model->insert_upload_details($file_name, $pras_id, $db);

				echo $results . '-' . $file_name;
			}
		}
	}
}
