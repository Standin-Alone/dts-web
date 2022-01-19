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
		   	->get();

		$document_recipients = $this->db->select('*')
		   	->from('vw_document_recipients')
		   	->where('document_number', $doc_number)
		   	->order_by('sequence', 'ASC')
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

        $check_if_archived = $this->db->where("document_number", $doc_number)
                ->where("added_by_user_id", $this->session->userdata('user_id'))
                ->where("active", "0")
                ->from("document_recipients")
                ->get();

		$data = array(
			'document_details' => $information->result(),
			'document_file' => $document_file->result(),
			'document_attachments' => $document_attachments->result(),
			'document_signatories' => $document_signatories->result(),
			'document_recipients' => $document_recipients->result(),
			'document_status' => $document_status->num_rows(),
			'document_current_status' => $document_current_status->result(),
			'check_if_archived' => $check_if_archived->num_rows()

		);

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		return $data;
	}

	public function update_status(){
		$result['event'] = 'success';

		$id   = Uuid::uuid4()->toString();
		$data = array(
			'id'				=> $id,
			'document_number' => $this->input->post('status_document_no', true),
			'status' => $this->input->post('status', true),
			'time_received' => $this->input->post('time_received', true),
			'date_received' => date("Y-m-d", strtotime($this->input->post('date_received', true))),
			'received_by' => $this->input->post('received_by', true),
			'no_pages' => $this->input->post('no_pages', true),
			'created_by'		=> $this->session->userdata('user_id')
		);

		$query = $this->db->insert('document_status', $data);

		if($query){
			$last_query 	= $this->db->get_where('document_status', array('id' => $id));
			$result['data'] = $last_query->result();
			$update_active = $this->db->set('active', '0')
									  ->where('id !=', $result['data'][0]->id)
									  ->where('document_number', $result['data'][0]->document_number)
									  ->update('document_status');
			if($update_active){
				return $result;
			}
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function update_document_info(){
		$result['event'] = 'success';
		$edit_document_no = $this->input->post('edit_document_no', true);

		$data = array(
			'reference_no' => $this->input->post('reference_no', true),
			'document_type' => $this->input->post('doc_type', true),
			'subject' => $this->input->post('subject', true),
			'document_year' =>$this->input->post('document_year', true),
			'remarks' => $this->input->post('remarks', true)
		);

		$query = $this->db->where('document_number', $edit_document_no)
							  ->update('document', $data);

		if($query){
			$last_query 	= $this->db->get_where('document', array('document_number' => $edit_document_no));
			$result['data'] = $last_query->result();

			$this->insert_logs($result['data'][0]->document_number);
			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function update_sender_info(){
		$result['event'] = 'success';
		$edit_document_no = $this->input->post('edit_document_no', true);
		if($this->input->post('company', true) == 'DA'){
			$data = array(
				'company' => $this->input->post('company', true),
				'office_code' => $this->input->post('offices', true),
				'service_code' => $this->input->post('services', true),
				'division_code' => $this->input->post('divisions', true),
				'company_code' => NULL,
				'tracking_no' => $this->input->post('tracking_no', true),
				'sender_name' => $this->input->post('sender_name', true),
				'sender_office' =>$this->input->post('sender_office', true)
			);
		} else {
			$data = array(
				'company' => $this->input->post('company', true),
				'office_code' => NULL,
				'service_code' => NULL,
				'division_code' => NULL,
				'company_code' => $this->input->post('company_code', true),
				'tracking_no' => $this->input->post('tracking_no', true),
				'sender_name' => $this->input->post('sender_name', true),
				'sender_office' =>$this->input->post('sender_office', true)
			);
		}
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		$query = $this->db->where('document_number', $edit_document_no)
							  ->update('document', $data);

		if($query){
			$last_query 	= $this->db->get_where('document', array('document_number' => $edit_document_no));
			$result['data'] = $last_query->result();

			$this->insert_logs($result['data'][0]->document_number);
			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

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
		   	->from('vw_document')
		   	->where('document_number', $document_number)
			->get();

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
		$query = $this->db->select("*")
						  ->from('office')
						  ->group_by('ID_AGENCY')
						  ->get();
		return $query->result();
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

	public function get_courier($q){
		$this->db->select('name, courier_id')
				 ->from('courier')
				 ->like('name', $q)
				 ->limit('50');
		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['name']));
					$new_row['value']=htmlentities(stripslashes($row['courier_id']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function get_phlpost($q){
		$this->db->select('name, phlpost_id')
				 ->from('phlpost')
				 ->like('name', $q)
				 ->limit('50');
		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['name']));
					$new_row['value']=htmlentities(stripslashes($row['phlpost_id']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function get_agency($q){
		$this->db->select('agency_name, agency_id')
				 ->from('agency')
				 ->like('agency_name', $q)
				 ->limit('50');
		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['agency_name']));
					$new_row['value']=htmlentities(stripslashes($row['agency_id']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}


	public function get_document($doc_number, $tbl, $where = null, $column = null){
		$this->db->where('document_number', $doc_number);
		
		if($where != null) {
			$this->db->where($column, $where);
		}

		$query	= $this->db->get($tbl);

		return $query->result();
	}

	public function get_rc_logs($doc_number){
		$data = [];
		$ok  = 0;
		$rk  = 0;
		$ek	 = 0;

		$query = $this->db->where('document_number', $doc_number)
						  ->order_by('trans_date','ASC')
						  ->get('rc_logs_view');


		$origin = $this->get_doc_origin($doc_number);

		return $query->result();
		/*foreach ($query->result() as $k => $v) {
			if($v->status == 'Error'){
				$data['error'][$ek] = $v;
				$ek++;
			}else {
				if
				(
				    $origin[0]->ID_REGION == $v->ID_REGION AND 
				    $origin[0]->ID_SERVICE == $v->ID_SERVICE //AND 
				    //$origin[0]->ID_DIVISION == $v->ID_DIVISION 
				){
					$data['origin'][$ok] = $v;
					$ok++;
				}else {
				  	$data['receiver'][$v->INFO_SERVICE][$rk] = $v;
				  	$rk++;
				}
			}
		}

		
		return $data;*/
	}

	public function upload_amendments($remarks, $file_name, $doc_number){
		$data = array(
			'document_number' => $doc_number,
			'file_name'		  => $file_name,
			'upload_type'	  => '1',
			'user_id'		  => $this->session->userdata('user_id'),
			'description'	  => $remarks
		);

		$query_insert = $this->db->insert('document_attachments', $data);

		$last_id 	  = $this->db->insert_id();

		$query_get	  = $this->db->where('id', $last_id)
								 ->get('attachments_view');
		if($query_get){
			return $query_get->result();
		}else {
			return 'fail';
		}
	}

	public function other_attach_title(){
		$id    = $this->input->post('id', true);
		$title = $this->input->post('title', true);

		$query = $this->db->where('id', $id)
						  ->update('document_attachments', array('description' => $title));

		if($query){
			return 'success';
		}else {
			return 'fail';
		}
	}

	public function get_doc_origin($doc_number){
		$query = $this->db->select('office_code, ID_REGION, ID_SERVICE, ID_DIVISION, LOCATION_CODE')
						  ->from('doc_profile_view')
						  ->where('document_number', $doc_number)
						  ->get();

		return $query->result();
	}

	public function add_recipients(){
		$input_data = $this->input->post(null, true);
		$data = [];

		/*echo '<pre>';
		print_r($input_data);
		echo '</pre>';*/

		if(isset($input_data['recipients'])){
			foreach ($input_data['recipients'] as $k => $v) {
				$data[$k] = array(
					'document_number' => $input_data['document_number'],
					'office'		  => $v
				);
			}

			$query = $this->db->insert_batch('document_recipients', $data);

			if($query){
				$this->release_document($input_data['document_number'], $input_data['remarks'], $input_data['status']);

				return 'success';
			}else {
				return 'fail';
			}
		}else {
			$resp['status'] = 'norecipients';
			$resp['level']	= $input_data['level'];
			return $resp;
		}
		
	}

	public function insert_notif($data){
		$this->db->insert('notification', $data);
	}

	public function remove_notif($data){
		
	}

	public function add_recipients_v2(){
		$input_data = $this->input->post(null, true);

		$check = $this->db->where('document_number', $input_data['doc_number'])
						  ->where('office', $input_data['trans_office'])
						  ->get('document_recipients');

		$n = $check->num_rows();
		if($n > 0){
			$d['r'] = 'duplicate';
			return $d;
		}

		$data = array(
			'document_number' => $input_data['doc_number'],
			'office'		  => $input_data['trans_office'],
			'added_by'		  => $input_data['added_by'],
		);

		$notif = array(
			'document_number' => $input_data['doc_number'],
			'origin_office'	  => $input_data['origin_office'],
			'trans_office'	  => $input_data['trans_office'],
			'title'		  	  => 'incoming document: '.$input_data['doc_number'].'.',
			'type'		  	  => 'incoming',
		);

		$query = $this->db->insert('document_recipients', $data);

		if($query){
			$this->insert_notif($notif);
			$d['r'] 	  = 'success';
			$d['last_id'] = $this->db->insert_id();
			return $d;
		}else {
			$d['r'] = 'fail';
			return $d;
		}
	}

	public function release_document($doc_number, $remarks, $status){
		$log = array(
			'id'   			   => Uuid::uuid4(),
			'type' 			   => 'Released',
			'document_number'  => $doc_number,
			'remarks'		   => $remarks,
			'transacting_user' => $this->session->userdata('user_id'),
			'office' 		   => $this->session->userdata('office'),
			'status' 		   => 'Profiled'
		);

		$query = $this->db->insert('receipt_control_logs', $log);

		if($query){
			return 'success';
		}else {
			return 'fail';
		}
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

	// public function archive_document($file_name, $doc_number){
	// 	$data = array(
	// 		'document_number' => $doc_number,
	// 		'user_id'		  => $this->session->userdata('user_id'),
	// 		'file_name'		  => $file_name,
	// 		'type'			  => '1'
	// 	);

	// 	$query = $this->db->insert('document_details', $data);

	// 	if($query){
	// 		return 'success';
	// 	}else {
	// 		return 'fail';
	// 	}
	// }

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
		$rid = $this->input->post('rid', true);

		$data = array(
			'removed_by'   => $this->session->userdata('user_id'),
			'date_removed' => date('Y-m-d H:i:s'),
			'status'	   => '0'
		);
		$query = $this->db->where('id', $rid)
						  ->update('document_recipients', $data);

		if($query){
			return 'success';
		}else {
			return 'fail';
		}
	}

	public function count_logs($doc_number){
		$query = $this->db->where('document_number', $doc_number)
						  ->get('receipt_control_logs');
						  
		return $query->num_rows();
	}

	public function origin_last_log($document_number){
		$office = $this->session->userdata('office');
		
		$this->db->select('*')
				 ->from('receipt_control_logs')
				 ->where('document_number' , $document_number)
				 ->where('office', $office)
				 ->order_by('trans_date', 'DESC')
				 ->limit(1);

		$query = $this->db->get();

		return $query->result();
	}

	public function get_signature_da_name($q,$w){
		$this->db->select('Name_F, Name_L, Name_M, Name_EXT, EMP_NO')
				 ->from('employee')
				 ->where('agency_id', $w)
				 ->like('Name_L', $q)
				 ->limit('50');

		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$name_ext = $row['Name_EXT'] == '' ? '' : ' '.$row['Name_EXT'];
					$new_row['label']=stripslashes(stripslashes($row['Name_F'].' '.$row['Name_M'].' '.$row['Name_L'].$name_ext));
					$new_row['value']=htmlentities(stripslashes($row['EMP_NO']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function get_signature_notda_name($q,$w){
		$this->db->select('Name_F, Name_L, Name_M, Name_EXT, EMP_NO')
				 ->from('employee')
				 ->where('agency_id !=', $w)
				 ->like('Name_L', $q)
				 ->limit('50');

		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$name_ext = $row['Name_EXT'] == '' ? '' : ' '.$row['Name_EXT'];
					$new_row['label']=stripslashes(stripslashes($row['Name_F'].' '.$row['Name_M'].' '.$row['Name_L'].$name_ext));
					$new_row['value']=htmlentities(stripslashes($row['EMP_NO']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function get_signature_div_da($q){
		$this->db->select('INFO_SERVICE, INFO_DIVISION, ID')
				 ->from('office')
				 //->where('agency_id', $w)
				 ->like('INFO_DIVISION', $q)
				 ->or_like('INFO_SERVICE', $q)
				 ->limit('50');

		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['INFO_SERVICE'].' / '.$row['INFO_DIVISION']));
					$new_row['value']=htmlentities(stripslashes($row['ID']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function get_signature_office_other($q,$w){
		$this->db->select('*')
				 ->from('agency')
				 ->where('agency_id !=', $w)
				 ->like('agency_name', $q)
				 //->or_like('agency_shortname', $q)
				 ->limit('50');

		$query = $this->db->get();
		//echo $this->db->last_query();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['agency_name']));
					$new_row['value']=htmlentities(stripslashes($row['agency_id']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function insert_signatories(){
		$result['event'] = 'success';
		$input_data = $this->input->post(null, true);
		//$document_no = $this->input->post('add_signatory_doc_number', true);

		if($input_data['modal_sig_emp_code'] != ''){
			$data = array(
				'document_number' => $input_data['add_signatory_doc_number'],
				'employee' => $input_data['modal_sig_emp_code'],
				'designation' => $input_data['sinatory_designation'],
				'office' => $input_data['modal_sig_office_code'],
				'sig_type' => '1'
			);
		} else {
			$data = array(
				'document_number' => $input_data['add_signatory_doc_number'],
				'employee' => $input_data['modal_oth_name_code'],
				'designation' => $input_data['modal_oth_name_codesig'],
				'office' => $input_data['modal_oth_office_code'],
				'sig_type' => '0'
			);
		}

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		$query = $this->db->insert('document_signatories', $data);

		if($query){
			// $last_query 	= $this->db->get_where('document_signatories', array('document_number' => $edit_document_no));
			// $result['data'] = $last_query->result();

			// $this->insert_logs($result['data'][0]->document_number);
			return $result;
		}

		$result['event'] = 'fail';
		return $result;
	}

	public function remove_signature(){
		$result   = 'failed';
		$id   = $this->input->post('id_sig', true);

    	$remove_sig = $this->db->where('id', $id)
    					       ->set('status', 'inactive')
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
			$result = 'success';
		}

		return $result;

    }

}
