<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Mobile_app_model extends CI_Model {

	public function generate_uuid(){
		return Uuid::uuid4();
	}


	// login model function
	public function login(){

	$this->load->config('email');			
	$this->load->library('email');	

	$result = '';

	try{
		
		
		$request = json_decode(file_get_contents('php://input'));
		$username = $request->username;
		$password = $request->password;
		$random_otp = mt_rand(100000, 999999);
		$otp_to_send = "";

		$user_data = array(			
			'email'   => $username,			
		); 

		$get_records = $this->db	
							->select('*')						
							->from('users as u')
							->join('lib_office as lo', 'u.office_code = lo.office_code')
							->where('email',$username)->get()->result();


	

		// check if account exist
		if($get_records){
			
			foreach($get_records as $value){
			
				// check password
				if(password_verify($password,$value->password)){

					// otp here
					$check_otp = $this->db									
									->get_where('user_otp',['user_id' => $value->user_id,'status' => 1])					
									->result();
					// check otp if exist or valid
					if($check_otp){
						foreach($check_otp as $check_otp_value){
							$otp_to_send = $check_otp_value->otp;
						}						
					}else{

						$this->db->insert('user_otp',['user_id' => $value->user_id,'otp' => $random_otp]);
						$otp_to_send = $random_otp;
					}



					// send otp to email
					$from = $this->config->item('smtp_user');
					$to = $username;
					$subject = 'User OTP | Document Tracking System';

					$cid = $this->email->attachment_cid(base_url().'/assets/edcel_images/DA-Logo.png','inline');

					$data = ['otp' => $otp_to_send , 'full_name' => $value->first_name.' '.$value->last_name,'office' => $value->INFO_DIVISION];
					$load_view = $this->load->view('otp',$data,true);
					$this->email->from($from, 'Department of Agriculture');
					$this->email->to($to);
					$this->email->subject($subject);
					
					$this->email->message($load_view);
					// $this->email->send();
					
					if ($this->email->send()) {
						$result = ["Message"=>'true', "user_id" => $value->user_id,'email'=>$value->email];
					} else {
						$result = $this->email->print_debugger();
					}
					
				}else{
					$result = ["Message"=>'false'];	
				}
			}
		}else{
			$result = ["Message"=>'false'];	
		}
		
	
		return $result;
	}catch(\Exception $e){
		
		return $result = $e->getMessage();
	}
	}
	
// verify otp model functions
public function verify_otp(){
	$request = json_decode(file_get_contents('php://input'));
	$user_id = $request->user_id;
	$otp     = $request->otp;

	$condition  = ['user_id' => $user_id, 'otp' => $otp , 'status' => 1];
	$verify_otp = $this->db->get_where('user_otp',$condition)->result();
	
	$result = "";
	if($verify_otp){
		// set otp status to 0;
		$this->db->where('user_id',$user_id)->update('user_otp',['status' => 0]);
		$get_user_info = $this->db	
								->select('*')						
								->from('users as u')
								->join('lib_office as lo', 'u.office_code = lo.office_code')
								->where('user_id',$user_id)->get()->result();
						

		foreach($get_user_info as $value){
			$result = [
				'Message' => 'true', 
				"user_id" => $value->user_id,
				'email'=>$value->email,
				'full_name'=>$value->first_name.' '.$value->last_name,
				'mobile'=>$value->mobile,
				'division'=>$value->INFO_DIVISION,
				'service'=>$value->INFO_SERVICE,
				'office_code'=>$value->office_code
			];
		}
		
	}else{
		$result = ['Message' => 'false'];
	}
	return $result;
}


// resend otp 
public function resend_otp(){
	$this->load->config('email');			
	$this->load->library('email');	
	$request = json_decode(file_get_contents('php://input'));
	$otp_to_send = mt_rand(100000, 999999);
	
	$result = '';

	try{
		

		$user_id = $request->user_id;
		//  disable the last otp of the user
		$this->db->where('user_id',$user_id)->update('user_otp',['status' => 0]);

		
		$get_user_info =  $this->db	
								->select('*')						
								->from('users as u')
								->join('lib_office as lo', 'u.office_code = lo.office_code')
								->where('user_id',$user_id)->get()->result();

		// insert new otp 
		$this->db->insert('user_otp',['user_id' => $user_id,'otp' => $otp_to_send]);								

		foreach($get_user_info as $value){
			// send new otp to email
			$from = $this->config->item('smtp_user');
			$to = $value->email;
			$subject = 'User OTP | Document Tracking System';

			

			$data = ['otp' => $otp_to_send , 'full_name' => $value->first_name.' '.$value->last_name,'office' => $value->INFO_DIVISION];
			$load_view = $this->load->view('otp',$data,true);
			$this->email->from($from, 'Department of Agriculture');
			$this->email->to($to);
			$this->email->subject($subject);
			
			$this->email->message($load_view);
			
			
			if ($this->email->send()) {
				$result = ["Message"=>'true'];
			} else {
				$result = $this->email->print_debugger();
			}
			return $result;
		}
	}catch(\Exception $e){

		$result = ["Message"=>'false'];
	}

}	


//  My documents Screen
public function my_documents(){
	$result = '';
	try{

		$request = json_decode(file_get_contents('php://input'));
				
		$office_code = $request->office_code;
		$get_doc_info = $this->db								
								->select('dp.document_number,subject,dp.type,dp.status')
								->from('document_profile as dp')								
								->join('document_recipients as dr','dp.document_number = dr.document_number')
								->join('doc_type as dt','dp.document_type = dt.type_id')
								->join('lib_office as lo','lo.office_code = dp.office_code')
								->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')														
								->where('dr.recipient_office_code', $office_code)
								->or_where('dp.office_code', $office_code)
								->where('rcl.type', 'Received')
								->where('dr.status', '0')								
								->order_by("dr.date_added", "desc")								
								->get()
								->result();
				
		$result = ["Message" => "true", "doc_info" => $get_doc_info];		
	
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}

	return $result;
}


// transactions

// QR Code Screen
public function get_scanned_document(){
	$result = '';
	$type = '';
	$get_doc_info = [];
	try{

		$request = json_decode(file_get_contents('php://input'));
		
		$document_number = $request->document_number;
		$office_code = $request->office_code;

		$check_if_release = $this->check_if_release($document_number, $office_code);
		

		if($check_if_release){

			$get_doc_info = $check_if_release;
			$type="release";
		}else{
		
			$get_doc_info = $this->db
									->limit(1)
									->select('*')
									->from('document_profile as dp')								
									->join('document_recipients as dr','dp.document_number = dr.document_number')
									->join('doc_type as dt','dp.document_type = dt.type_id')
									->join('lib_office as lo','lo.office_code = dp.office_code')
									->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')
									->where('dp.document_number', $document_number)								
									->where('dr.recipient_office_code', $office_code)
									->where('dr.status', '1')
									->order_by("dr.date_added", "desc")								
									->get()
									->result();
			$type="receive";
		}

		if($get_doc_info){				
			$result = ["Message" => "true", "type" => $type,"doc_info" => $get_doc_info];		
		}else{
			$result = ["Message" => "Not Authorize"];		
		}
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}

	return $result;
}





// Receive Document Screen
public function receive_document(){
	
	$result = '';
	try{
		$uuid = $this->generate_uuid();
		$request = json_decode(file_get_contents('php://input'));
		
		$document_number = $request->document_number;
		$office_code = $request->office_code;
		$user_id = $request->user_id;
		$full_name = $request->full_name;
		$info_division = $request->info_division;
		$info_service = $request->info_service;


		$check_document =$this->check_document($document_number,$office_code);

		
		if($check_document){

			foreach($check_document as $value){
				$this->db
						->where('document_number',$value->document_number)
						->where('recipient_office_code',$value->recipient_office_code)						
						->update('document_recipients',[
							'status' => '0'
						]);						
				$this->db->insert('receipt_control_logs',[
					'type' => 'Received',
					'document_number' => $value->document_number,
					'office_code' => $value->recipient_office_code,
					'action' => 'No Action',
					'remarks' => $value->remarks,
					'file' => '',
					'attachment' => '',
					'transacting_user_id' => $user_id,
					'transacting_user_fullname' => $full_name,
					'transacting_office' => $office_code

				]);
	
			}
		
			$result = ["Message" => "true", "doc_info" =>$check_document];
		}else{
			$result = ["Message" => "false"];
		};

		return $result;
				
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}
}



// Receive Document Screen
public function release_document(){
	
	$result = '';
	try{
		$uuid = $this->generate_uuid();
		
		$request = json_decode(file_get_contents('php://input'));
		
		$document_number = $request->document_number;
		$office_code = $request->office_code;
		$recipients_office_code = $request->recipients_office_code;
		$user_id = $request->user_id;
		$full_name = $request->full_name;
		$info_division = $request->info_division;
		$info_service = $request->info_service;


		$check_if_release =$this->check_if_release($document_number,$office_code);

		
		if($check_if_release){

			foreach($check_if_release as $release_doc){
					$this->db->insert('receipt_control_logs',[
						'type' => 'Released',
						'document_number' => $document_number,
						'office_code' => $office_code,
						'action' => 'No Action',
						'remarks' => $release_doc->remarks,
						'file' => '',
						'attachment' => '',
						'transacting_user_id' => $user_id,
						'transacting_user_fullname' => $full_name,
						'transacting_office' => $office_code
					]);
			}

			$get_last_sequence = $this->db
										->select('sequence')
										->from('document_recipients')
										->where('document_number',$document_number)
										->where('status','0')
										->where('recipient_office_code',$office_code)
										->order_by('sequence','DESC')
										->limit(1)
										->get()->result();


			foreach($recipients_office_code as $value){

				
				$this->db->insert('document_recipients',[					
					'document_number' => $document_number,
					'recipient_office_code' => $value,
					'sequence' => $get_last_sequence[0]->sequence +1,					
					'added_by_user_id' => $user_id,
					'added_by_user_fullname' => $full_name			
				]);				
			}
		
			$result = ["Message" => "true"];
		}else{
			$result = ["Message" => "false"];
		};

		return $result;
				
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}
}








// check document if the recipient is valid to receive
public function check_document($document_number,$office_code){

	$get_records = $this->db
						->limit(1)
						->select('dp.document_number,recipient_office_code,subject,dp.remarks,INFO_SERVICE,INFO_DIVISION')
						->from('document_profile as dp')
						->join('document_recipients as dr','dp.document_number = dr.document_number')
						->join('lib_office as lo','lo.office_code = dr.recipient_office_code')
						->join('receipt_control_logs as rcl','dr.document_number = rcl.document_number')
						->where('dp.document_number', $document_number)
						->where('dr.recipient_office_code', $office_code)
						->where('rcl.type', 'Released')
						->order_by("dr.date_added", "desc")
						->get()->result();
	if($get_records){
		return $get_records;
	}
}



// check document if the recipient is valid to release
public function check_if_release($document_number,$office_code){

	$get_records = $this->db
						->select('*')
						->from('document_profile as dp')
						->join('receipt_control_logs as rcl','dp.document_number = rcl.document_number')						
						->join('lib_office as lo','lo.office_code = rcl.office_code')
						->where('dp.document_number',$document_number)
						->where('lo.office_code',$office_code)
						->where('rcl.type','Received')
						->get()->result();
						
	if($get_records){
		return $get_records;
	}
}

public function get_history($document_number){
	$result = '';
	try{

		$get_records = $this->db
							->select('dp.document_number,
										recipient_office_code,
										subject,dp.remarks,
										INFO_SERVICE,
										INFO_DIVISION,
										rcl.type,
										rcl.transacting_user_fullname,  
										CONCAT( DATE_FORMAT(dr.date_added,"%M %d, %Y"),"\n", TIME_FORMAT(dr.date_added,"%r")) as time')
							->from('document_profile as dp')								
							->join('document_recipients as dr','dp.document_number = dr.document_number')
							->join('receipt_control_logs as rcl','dr.document_number = rcl.document_number','left')
							->join('lib_office as lo','lo.office_code = dr.recipient_office_code')							
							->where('dp.document_number', $document_number)														
							->order_by("dr.sequence", "desc")
							->get()->result();
		if($get_records){
			$result = ["Message" => "true", "history" =>$get_records];
		}
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];		
	}
	return $result;
}


// list of offices
public function get_offices(){
	$result = '';
	try{
		$get_division = $this->db->distinct()->select('INFO_DIVISION ,office_code')->from('lib_office')->group_by('INFO_DIVISION')->get();
		
		$office_array = [];
		if($get_division){

			foreach($get_division->result() as $division_key => $item){

				array_push($office_array , ["name"=>$item->INFO_DIVISION,'id'=>$division_key, "children"=>[]]);

				$get_records = $this->db->select('INFO_SERVICE,OFFICE_CODE,SHORTNAME_REGION')->from('lib_office')->where('INFO_DIVISION',$item->INFO_DIVISION)->get();		
				foreach($get_records->result() as $value){	
					
					
					foreach($office_array as $office_value){						
						if($office_value['id'] == $division_key){
							array_push($office_array[$division_key]['children'],["name"=>($value->SHORTNAME_REGION  == 'OSEC' ? 'DA /' : '').$value->INFO_SERVICE,'id'=>$value->OFFICE_CODE]);
						}
					}

					
				
				}
			}
		
			
			$result = ["Message" => "true", "offices" =>$office_array];
		}
		return $result;

	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];
	}
}




}