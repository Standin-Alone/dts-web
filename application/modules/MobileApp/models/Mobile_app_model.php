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


// transactions

// QR Code Screen
public function get_scanned_document(){
	$result = '';
	try{

		$request = json_decode(file_get_contents('php://input'));
		
		$document_number = $request->document_number;
		$get_doc_info = $this->db->select('dp.document_number','recipient_office_code','subject','title','INFO_SERVICE','INFO_DIVISION')
								->from('document_profile as dp')								
								->join('doc_type as dt','dp.document_type = dt.type_id')
								->join('lib_office as lo','lo.office_code = dp.office_code')
								->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')
								->where('dp.document_number', $document_number)
								->get()
								->result();
		$result = ["Message" => "true", "doc_info" => $get_doc_info];		
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}

	return $result;
}


// Receive Document Screen
public function receive_document(){
	
	$result = '';
	try{

		$request = json_decode(file_get_contents('php://input'));
		
		$document_number = $request->document_number;
		$office_code = $request->office_code;
		$check_document =$this->check_document($document_number,$office_code);

		
		if($check_document){
			
			$result = ["Message" => "true", "doc_info" =>$check_document];
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
						->select('*')
						->from('document_profile as dp')								
						->join('document_recipients as dr','dp.document_number = dr.document_number')
						->join('receipt_control_logs as rcl','dr.document_number = rcl.document_number')
						->where('dp.document_number', $document_number)
						->where('dr.recipient_office_code', $office_code)
						->order_by("dr.date_added", "desc")
						->get()->result();
	if($get_records){
		return $get_records;
	}
}




}