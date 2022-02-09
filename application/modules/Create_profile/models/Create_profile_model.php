<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Create_profile_model extends CI_Model
{

	public function add_profile()
	{

		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

		$result['event'] = 'success';
		$recipients = $this->input->post('recipients', true);
		$signatory_user_id = $this->input->post('signatory_user_id', true);
		$signatory_designation_desc = $this->input->post('signatory_designation_desc', true);
		$signatory_office_code = $this->input->post('signatory_office_code', true);
		$signatory_user_fullname = $this->input->post('signatory_user_fullname', true);

		$id   = Uuid::uuid4()->toString();
		$data = array(
			'document_id'				=> $id,
			'document_type' 	=> $this->input->post('document_type', true),
			'sender_name' 	=> strtoupper($this->input->post('sender_name', true)),
			'sender_position' 	=> $this->input->post('sender_position', true),
			'sender_address' 	=> $this->input->post('sender_address', true),
			'for'			=> $this->input->post('for', true),
			'origin_type'			=> $this->input->post('origin_type', true),
			'subject'		=> $this->input->post('subject', true),
			'remarks'			=> $this->input->post('remarks', true),
			'status'			=> 'Draft',
			'date' 	=> date("Y-m-d", strtotime($this->input->post('date', true))),
			'OFFICE_CODE' 	=> $this->session->userdata('office'),
			'created_by_user_id'		=> $this->session->userdata('user_id'),
			'created_by_user_fullname'		=> $this->session->userdata('fullname')
		);

		$query = $this->db->insert('document_profile', $data);

		if ($query) {

			$last_query 	= $this->db->get_where('document_profile', array('document_id' => $id));
			$result['data'] = $last_query->result();
			$result['data'][0]->for = $this->check_action($result['data'][0]->for);

			$logs = array(
				'type'						=> 'Received',
				'document_number' 			=> $result['data'][0]->document_number,
				'transacting_office' 				=> $this->session->userdata('office'),
				'action'					=> 'Received',
				'transacting_user_id'		=> $this->session->userdata('user_id'),
				'transacting_user_fullname'	=> $this->session->userdata('fullname')
			);

			$query_logs = $this->db->insert('receipt_control_logs', $logs);

			if (!empty($this->input->post('sender_name', true))) {
				if ($this->check_sender_name($this->input->post('sender_name', true)) == 0) {
					$sender_array = array('sender_name' => strtoupper($this->input->post('sender_name', true)));
					$insert_name = $this->db->insert('sender_library', $sender_array);
				}
			}

			$data_recipients = [];
			if (isset($recipients)) {
				if (count($recipients) > 0) {
					foreach ($recipients as $k => $v) {
						$data_recipients[$k] = array(
							'document_number' 			=> $result['data'][0]->document_number,
							'recipient_office_code' 	=> $recipients[$k],
							'sequence' 					=> $k+1,
							'added_by_user_id'			=> $this->session->userdata('user_id'),
							'added_by_user_fullname'	=> $this->session->userdata('fullname'),
							'added_by_user_office'		=> $this->session->userdata('office')
						);
					}
				}
			}

			if (isset($recipients)) {
				$query1 = $this->db->insert_batch('document_recipients', $data_recipients);
			}

			$data_signatories = [];
			if (isset($signatory_user_fullname)) {
				if (count($signatory_user_fullname) > 0) {
					foreach ($signatory_user_fullname as $k => $v) {
						$data_signatories[$k] = array(
							'document_number' => $result['data'][0]->document_number,
							'signatory_user_id' => $signatory_user_id[$k],
							'signatory_user_fullname' => $signatory_user_fullname[$k],
							'designation' 	  => $signatory_designation_desc[$k],
							'office_code' 		  => $signatory_office_code[$k],
							'added_by_user_id'			=> $this->session->userdata('user_id'),
							'added_by_user_fullname'	=> $this->session->userdata('fullname')
						);
					}
				}
			}

			if (isset($signatory_user_fullname)) {
				$query2 = $this->db->insert_batch('document_signatories', $data_signatories);
			}

			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function check_sender_name($params)
	{
		$query = $this->db->where('sender_name', strtoupper($params))
			->get('sender_library');
		$output = $query->num_rows();

		if ($query) {
			return $output;
		}
	}

	public function check_action($params)
	{
		$query = $this->db->select('for')
			->where('for_id', $params)
			->get('document_for');
		$output = $query->result();
		//$result['data'] = $last_query->result();
		//echo $output;
		if ($query) {
			return $output[0]->for;
		}
	}

	public function get_offices(){
		$term = $this->input->get('term', true); //search input field value

		$this->db->select('*')
				 ->from('lib_office')
				 ->where('STATUS_CODE', '1');

		if($term != ''){
			$this->db->group_start()
					 ->like('INFO_REGION', trim($term))
					 ->or_like('INFO_SERVICE', trim($term))
					 ->or_like('SHORTNAME_SERVICE', trim($term))
					 ->or_like('INFO_DIVISION', trim($term))
					 ->or_like('OFFICE_CODE', trim($term))
					 ->group_end();
		}

		$query = $this->db->get();

		$data 	= []; //temporary array
		$result = []; //return result
		$key	= 0;

		//group query result by INFO_REGION and INFO_SERVICE to data array
		foreach ($query->result() as $k => $v) {

			//group name
			$data[$v->INFO_REGION.' - '.$v->INFO_SERVICE][] = array( 
				//divisions
				'id'	=> $v->OFFICE_CODE,
				'text'  => $v->INFO_DIVISION
			);
		}

		//extract data array
		foreach ($data as $k => $v) {
			$result[$key] = array(
				'text' 	   => $k, //text label group name
				'children' => $v  //division under the group
			);
			$key++;
		}

		return $result;
	}

	// public function get_offices($office_name)
	// {
	// 	$this->db->select('ID_REGION, INFO_REGION')
	// 		->like('INFO_REGION', $office_name)
	// 		->group_by("ID_REGION")
	// 		->order_by("INFO_REGION", "asc");
	// 	$query = $this->db->get('office');
	// 	if ($query->num_rows() > 0) {
	// 		foreach ($query->result_array() as $row) {
	// 			//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
	// 			$new_row['label'] = stripslashes($row['INFO_REGION']);
	// 			$new_row['value'] = htmlentities(stripslashes($row['ID_REGION']));
	// 			$row_set[] = $new_row;
	// 		}
	// 		echo json_encode($row_set); //format the array into json data
	// 	}
	// }

	public function get_services($service_name, $office_code)
	{
		$this->db->select('ID_SERVICE, INFO_SERVICE')
			->like('INFO_SERVICE', $service_name)
			->where('ID_REGION', $office_code)
			->group_by("ID_SERVICE")
			->order_by("INFO_SERVICE", "asc");
		$query = $this->db->get('office');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
				$new_row['label'] = stripslashes($row['INFO_SERVICE']);
				$new_row['value'] = htmlentities(stripslashes($row['ID_SERVICE']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function get_divisions($division_name, $service_code, $office_code)
	{
		$this->db->select('ID_DIVISION, INFO_DIVISION')
			->like('INFO_DIVISION', $division_name)
			->where('ID_SERVICE', $service_code)
			->where('ID_REGION', $office_code)
			->group_by("ID_DIVISION")
			->order_by("INFO_DIVISION", "asc");
		$query = $this->db->get('office');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
				$new_row['label'] = stripslashes($row['INFO_DIVISION']);
				$new_row['value'] = htmlentities(stripslashes($row['ID_DIVISION']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function remove_uploaded_file($rm_id)
	{
		$query = $this->db->where('file_id', $rm_id)
			->delete('document_file');

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function document_type()
	{
		$query = $this->db->get('doc_type');
		return $query->result();
	}

	public function document_for()
	{
		$query = $this->db->get('document_for');
		return $query->result();
	}

	public function get_recipients($q)
	{
		$this->db->select('ID_DIVISION, INFO_DIVISION')
			->from('lib_office')
			->like('INFO_DIVISION', $q);
		//->limit('50');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['label'] = stripslashes(stripslashes($row['INFO_DIVISION']));
				//$new_row['value']=htmlentities(stripslashes($row['ID_DIVISION']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function recipients()
	{
		$this->db->select('ID_AGENCY, INFO_SERVICE, ORIG_SHORTNAME, SHORTNAME_REGION, OFFICE_CODE, INFO_DIVISION')
			->from('lib_office')
			->where('STATUS_CODE', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_signature_da_name($q)
	{
		$this->db->select('first_name, middle_name, last_name, ext_name, profile_id')
			->from('employees')
			//->where('agency_id', $w)
			->like('last_name', $q)
			->limit('50');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$name_ext = $row['ext_name'] == '' ? '' : ' ' . $row['ext_name'];
				$new_row['label'] = stripslashes(stripslashes($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . $name_ext));
				$new_row['value'] = htmlentities(stripslashes($row['profile_id']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function get_signature_div_da($q)
	{
		$this->db->select('INFO_SERVICE, INFO_DIVISION, OFFICE_CODE')
			->from('lib_office')
			//->where('agency_id', $w)
			->like('INFO_DIVISION', $q)
			->or_like('INFO_SERVICE', $q)
			->limit('50');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['label'] = stripslashes(stripslashes($row['INFO_SERVICE'] . ' / ' . $row['INFO_DIVISION']));
				$new_row['value'] = htmlentities(stripslashes($row['OFFICE_CODE']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function get_sender_name($q)
	{
		$this->db->select('sender_name')
			->from('sender_library')
			->like('sender_name', $q)
			->limit('50');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['label'] = stripslashes(stripslashes($row['sender_name']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function insert_upload_details($file_name = null, $doc_number, $type, $mode, $db)
	{
		if ($mode == 'file') { //add details
			$mode_type = 'base_file';
		} else { //add attachments
			$mode_type = 'attachment';
		}
		$data = array(
			'document_number' => $doc_number,
			'type'		  => $mode_type,
			'file_name'		  => $file_name,
			'uploaded_by_user_office'		=> $this->session->userdata('office'),
			'uploaded_by_user_id'		=> $this->session->userdata('user_id'),
			'uploaded_by_user_fullname'		=> $this->session->userdata('fullname')
		);

		$query = $this->db->insert($db, $data);

		if ($query) {
			return $this->db->insert_id();
		} else {
			return 'fail';
		}
	}

	public function document_recipients($doc_number)
	{
		$query = $this->db->where('document_number', $doc_number)
			->get('vw_document_recipients');
		return $query->result();
	}
}
