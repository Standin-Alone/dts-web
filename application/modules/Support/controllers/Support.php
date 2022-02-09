<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends MY_Controller
{
	public function index()
	{
		// $this->data['check_status'] = $this->Dashboard_model->check_status();
		$this->data['title'] 		 = 'DTS | Support';
		$this->middle 		 		 = 'Support_view';
		$this->layout();
	}

	public function Report_bugs()
	{
		$this->data['title'] = 'DTS | Report a Bug';
		$this->middle 		 = 'Report_bugs_view';
		$this->layout();
	}
	public function Assistance()
	{
		$this->data['title'] = 'DTS | Assistance';
		$this->middle 		 = 'Assistance_view';
		$this->layout();
	}
	public function User_feedback()
	{
		$this->data['title'] = 'DTS | Assistance';
		$this->middle 		 = 'User_feedback_view';
		$this->layout();
	}
}
