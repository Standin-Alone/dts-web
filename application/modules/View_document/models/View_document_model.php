<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class View_document_model extends CI_Model {

	public function get_doc_information($doc_number){
		$information  = $this->db->select('*')
						   ->from('vw_document_profile_info')
				   		   ->where('document_number', $doc_number)
				   		   ->get();

		$document_file = $this->db->select('*')
		   	->from('vw_document_file_type')
		   	->where('document_number', $doc_number)
		   	->where('type', 'base_file')
		   	->get();

		$document_attachments = $this->db->select('*')
		   	->from('vw_document_file_type')
		   	->where('document_number', $doc_number)
		   	->where('type', 'attachment')
		   	->get();

		$document_signatories = $this->db->select('*')
		   	->from('vw_document_signatories')
		   	->where('document_number', $doc_number)
		   	->where('active', '1')
		   	->get();

		$document_recipients = $this->db->select('*')
		   	->from('vw_document_recipients')
		   	->where('document_number', $doc_number)
		   	//->where('active', '1')
		   	->order_by('date_added', 'ASC')
		   	->get();

		$document_status = $this->db->select('*')
			->from('receipt_control_logs')
		   	->where('document_number', $doc_number)
		   	->get();

		$document_current_status = $this->db->select('*')
		   	->from('receipt_control_logs')
		   	->where('document_number', $doc_number)
		   	// ->group_by('document_number')
		   	->order_by('log_date', 'DESC')
		   	->limit('1')
		   	->get();

        // $check_if_archived = $this->db->where("document_number", $doc_number)
        //         ->where("added_by_user_id", $this->session->userdata('user_id'))
        //         ->where("active", "0")
        //         ->from("document_recipients")
        //         ->get();

		$data = array(
			'document_details' => $information->result(),
			'document_file' => $document_file->result(),
			'document_attachments' => $document_attachments->result(),
			'document_signatories' => $document_signatories->result(),
			'document_recipients' => $document_recipients->result(),
			'document_status' => $document_status->num_rows(),
			'document_current_status' => $document_current_status->result()
			//'check_if_archived' => $check_if_archived->num_rows()

		);

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		return $data;
	}

	public function update_document_info(){
		$result['event'] = 'success';
		$document_number = $this->input->post('document_number', true);

		$data = array(
			//'date' 	=> date("Y-m-d", strtotime($this->input->post('date', true))),
			//'document_type' 	=> $this->input->post('document_type', true),
			'sender_name' 	=> strtoupper($this->input->post('sender_name', true)),
			'sender_position' 	=> $this->input->post('sender_position', true),
			'sender_address' 	=> $this->input->post('sender_address', true),
			'for'			=> $this->input->post('for', true),
			'origin_type'			=> $this->input->post('origin_type', true),
			'subject'		=> $this->input->post('subject', true),
			'remarks'			=> $this->input->post('remarks', true)
		);

		$query = $this->db->where('document_number', $document_number)
							  ->update('document_profile', $data);

		if($query){
			$last_query 	= $this->db->get_where('document_profile', array('document_number' => $document_number));
			$result['data'] = $last_query->result();

			//$this->insert_logs($result['data'][0]->document_number);
			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function add_document_recipient(){
		$result['event'] = 'success';
		$document_number = $this->input->post('document_number', true);
		$recipients = $this->input->post('recipients_office_code', true);


			$data_recipients = [];
			if (isset($recipients)) {
				if (count($recipients) > 0) {
					foreach ($recipients as $k => $v) {
						$data_recipients[$k] = array(
							'document_number' 			=> $document_number,
							'recipient_office_code' 	=> $recipients[$k],
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


		//$query = $this->db->insert('document_recipients', $data);

		if($query1){
			$last_query 	= $this->db->get_where('document_recipients', array('document_number' => $document_number));
			$result['data'] = $last_query->result();

			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function document_for()
	{
		$query = $this->db->get('document_for');
		return $query->result();
	}

	public function recipients()
	{
		$this->db->select('ID_AGENCY, INFO_SERVICE, ORIG_SHORTNAME, SHORTNAME_REGION, OFFICE_CODE, INFO_DIVISION')
			->from('lib_office')
			->where('STATUS_CODE', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_signature_list()
	{
		$this->db->select('*')
			->from('vw_document_signatories')
			->where('document_number', $this->input->post('document_number', true))
			->where('active', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_recipients_list()
	{
		$this->db->select('*')
			->from('vw_document_recipients')
			->where('document_number', $this->input->post('document_number', true));
			//->where('active', '1');
		$query = $this->db->get();
		return $query->result();
	}

	// function check_in_recipients()
 //    {
	// 	$this->db->select('*')
	// 		->from('vw_document_recipients')
	// 		->where('document_number', $this->input->post('document_number', true))
	// 		->where('active', '1');
 //        $rows = array(); //will hold all results
 //        $query = $this->db->get();

 //        foreach($query->result_array() as $row)
 //        {    
 //            $rows[] = $row; //add the fetched result to the result array;
 //        }

 //        return $rows; // returning rows, not row
 //    }

	public function insert_logs($doc_number){
		
		//$check = $this->check_logs($doc_number);

		//if($check == 0){
		$log = array(
			'log_id'   			   => Uuid::uuid4(),
			'document_number'  => $doc_number,
			'encoder_id'	   => $this->session->userdata('user_id')
			//'status' 		   => 'Received'
		);

		$query = $this->db->insert('document_logs_update', $log);

		if($query){
			return 'success';
		} else {
			return 'fail';
		}
		//}
	}

	public function edit_document_info(){
		$document_number = $this->input->post('document_number', true);

		$query = $this->db->select('*')
		   	->from('vw_document_profile_info')
		   	->where('document_number', $document_number)
			->get();

		return $query->result();
	}

	public function document_type()
	{
		$query = $this->db->get('doc_type');
		return $query->result();
	}

	public function edit_signatories(){
		$document_number = $this->input->post('document_number', true);

		$query = $this->db->select('*')
		   	->from('vw_document_signatories')
		   	->where('document_number', $document_number)
			->get();

		return $query->result();
	}

	public function get_doc_types(){
		$query = $this->db->order_by('type')
						  ->get('doc_type');
		return $query->result();
	}

	public function get_offices(){
		$doc_number = $this->input->get('document_number', true);
		$term = $this->input->get('term', true); //search input field value

		$this->db->select('*')
				 ->from('lib_office')
				 ->where('NOT EXISTS (SELECT * FROM document_recipients WHERE document_recipients.recipient_office_code = lib_office.OFFICE_CODE AND document_recipients.document_number="'.$doc_number.'" )', '', FALSE)
				 //->where('document_number', $doc_number)
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

	public function get_da_services(){
		$office_code = $this->input->post('office_code',true);
		$query = $this->db->order_by('ID_SERVICE, INFO_SERVICE')
						  ->where('ID_REGION', $office_code)
						  ->group_by('ID_SERVICE')
						  ->get('office');
		return $query->result();
	}

	public function get_da_divisions(){
		$office_code = $this->input->post('office_code',true);
		$service_code = $this->input->post('service_code',true);
		$query = $this->db->order_by('ID_DIVISION, INFO_DIVISION')
						  ->where('ID_REGION', $office_code)
						  ->where('ID_SERVICE', $service_code)
						  ->group_by('ID_DIVISION')
						  ->get('office');
		return $query->result();
	}

	public function get_document($doc_number, $tbl, $where = null, $column = null){
		$this->db->where('document_number', $doc_number);
		
		if($where != null) {
			$this->db->where($column, $where);
		}

		$query	= $this->db->get($tbl);

		return $query->result();
	}

	public function get_doc_origin($doc_number){
		$query = $this->db->select('office_code, ID_REGION, ID_SERVICE, ID_DIVISION, LOCATION_CODE')
						  ->from('doc_profile_view')
						  ->where('document_number', $doc_number)
						  ->get();

		return $query->result();
	}

	public function check_received($doc_number){
		$query = $this->db->select('*')
						  ->from('receiving_logs')
						  ->where('document_number', $doc_number)
						  ->get();

		$row = $query->row_array();
		
		return $row['receive_indicator'];
	}

	public function check_archived_document($doc_number){
		$query = $this->db->where('document_number', $doc_number)
						  ->where('type', '1')
						  ->get('document_details');

		return $query->num_rows();
	}

	public function is_received($doc_number){
		$office = $this->session->userdata('office');
		$query = $this->db->query("SELECT *
			FROM receipt_control_logs as a
			WHERE a.trans_date = (
				SELECT MAX(b.trans_date)
			    FROM receipt_control_logs as b 
			    WHERE b.document_number = '$doc_number'
			    AND b.office = '$office'
			)
			AND a.office = '$office'
			AND a.status <> 'Profiled'
			AND a.document_number = '$doc_number'"
		);

		return $query->row();
	}

	public function remove_recipient(){
		$result   = 'failed';
		$id   = $this->input->post('id_rec', true);

    	// $remove_sig = $this->db->where('recipient_id', $id)
    	// 				       ->set('active', '0')
     //                           ->update('document_recipients');
		$remove_sig = $this->db->where('recipient_id', $id)
					 				->delete('document_recipients');
		if($remove_sig){
			$result = 'success';
		}
		return $result;
	}

	public function get_signature_da_name($q){
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

	public function get_signature_div_da($q){
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

	public function get_recipients_autocomplete($q){
		$this->db->select('INFO_SERVICE, INFO_DIVISION, OFFICE_CODE')
			->from('lib_office')
			//->where('document_number', $w)
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

	public function insert_signatories(){
		$result['event'] = 'success';
		//$document_number = $this->input->post('document_number', true);

		$data = array(
			'document_number' => $this->input->post('document_number', true),
			'signatory_user_fullname' => $this->input->post('signatory_emp', true),
			'designation' 	  => $this->input->post('signatory_designation', true),
			'office_code' 		  => $this->input->post('modal_sig_office_code', true),
			'added_by_user_id'			=> $this->session->userdata('user_id'),
			'added_by_user_fullname'	=> $this->session->userdata('fullname')
		);

		$query = $this->db->insert('document_signatories', $data);

		if($query){
			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function remove_signature(){
		$result   = 'failed';
		$id   = $this->input->post('id_sig', true);

    	$remove_sig = $this->db->where('signatory_id', $id)
    					       ->set('active', '0')
                               ->update('document_signatories');

		if($remove_sig){
			$result = 'success';
		}
		return $result;
    }

	public function release_document1(){
		$result   = 'failed';
		$doc_number   = $this->input->post('doc_number', true);

		$logs = array(
			'type'			=> 'Released',
			'document_number' 	=> $doc_number,
			'transacting_office' 	=> $this->session->userdata('office'),
			'action'			=> 'Profiled',
			'transacting_user_id'		=> $this->session->userdata('user_id'),
			'transacting_user_fullname'		=> $this->session->userdata('fullname')
		);

		$query_logs = $this->db->insert('receipt_control_logs', $logs);

		if($query_logs){
			$Verified = array('status' => 'Verified');
   			$query = $this->db->where('document_number', $doc_number)
                			  ->update('document_profile', $Verified);
		}

		if($query_logs){
			$result = 'success';
		}

		return $result;

    }

	public function archive_document(){
		$result   = 'failed';
		$doc_number   = $this->input->post('doc_number', true);


		$archive = array('status' => 'Archived');
		$query = $this->db->where('document_number', $doc_number)
            			  ->update('document_profile', $archive);

		if($query){
			$logs = array(
				'type'						=> 'Completed',
				'document_number' 			=> $doc_number,
				'transacting_office' 		=> $this->session->userdata('office'),
				'action'					=> 'Marked as Completed',
				'transacting_user_id'		=> $this->session->userdata('user_id'),
				'transacting_user_fullname'	=> $this->session->userdata('fullname')
			);

			$query_logs = $this->db->insert('receipt_control_logs', $logs);
			if($query_logs){
				$result = 'success';
			}
		}

		return $result;

    }

}
