<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");

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

		// $username = $this->input->post('username');
		// $password =$this->input->post('password');
		
	
		
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
		$current_page = $request->current_page;



		

		$get_doc_info = $this->db
								->select('*')
								->from('document_profile as dp')
								->join('receipt_control_logs as rcl','dp.document_number = rcl.document_number')								
								->join('lib_office as lo','lo.office_code = rcl.transacting_office')
								->where('rcl.transacting_office',$office_code)
								->or_where('dp.office_code',$office_code)
								->where('rcl.status','1')														
								->group_by(['rcl.document_number','rcl.status'])
								->order_by('log_date','desc')
								->get()
								->result();
	
		
		$result = ["Message" => "true", "doc_info" => $get_doc_info];		
	
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}

	return $result;
}	

// incoming documents model
public function incoming_documents($my_office_code){

	$result = '';

	try{
		
		$get_incoming  = $this->db
								->select('*')																		
								->from('document_profile as dp')
								->join('document_recipients as dr','dp.document_number = dr.document_number')								
								->where('dr.recipient_office_code',$my_office_code)
								->where('dr.received','1')																
								->where('DATE(dr.date_added) = DATE(NOW())')
								->where('dp.status ','Verified')
								->order_by('dr.date_added','desc')															
								->get()->result();

		$get_incoming_resend = $this->db
									->select('*')																				
									->from('document_profile as dp')
									->join('document_recipients as dr','dp.document_number = dr.document_number')								
									->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')								
									->where('dr.recipient_office_code',$my_office_code)
									->where('rcl.status','1')
									->where('dr.received','0')								
									->where('rcl.type','Released')
									->where('rcl.action','Return to Sender')
									->order_by('dr.date_added','desc')		
									->where('DATE(dr.date_added) = DATE(NOW())')
									->get()->result();

		$merge_incoming_documents = array_merge($get_incoming,$get_incoming_resend);									

		
		$result = ["Message" => "true", "doc_info" => $get_incoming];	
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}

	return $result;
}


// outgoing documents model
public function outgoing_documents($my_office_code){
	$result = '';

	try{
			
		// $get_outgoing  =  $this->db											
		// 							->select("*,
		// 							(SELECT count(*) FROM receipt_control_logs as rcl2
		// 							WHERE rcl.log_id > rcl2.log_id and rcl2.type= 'Released'
		// 							ORDER BY log_id ASC LIMIT 1) as check_next_log_if_release
									
		// 							")
		// 							->from('document_profile as dp')																															
		// 							->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')																													
		// 							->where('dp.office_code',$my_office_code)
		// 							->where('rcl.transacting_office',$my_office_code)									
		// 							->where('rcl.status','1')
		// 							->where('dp.status','Verified')
		// 							->order_by('log_date','desc')
		// 							->get()
		// 							->result();


		$get_outgoing = $this->db
								->select('*')
								->from('document_profile')
								->where('office_code',$my_office_code)
								->where('status','Verified')
								->or_where('status','Archived')
								->get()
								->result();
		// $consolidate_outgoing = array();
		// foreach($get_outgoing as  $item){

		// 	if($item->check_next_log_if_release == 0){

		// 		array_push($consolidate_outgoing,$item);
		// 	}

										
		// }
		
		
		$result = ["Message" => "true", "doc_info" => $get_outgoing];	
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
		// payload
		$document_number = $request->document_number;
		$office_code = $request->office_code;
		$user_id = $request->user_id;
		$full_name = $request->full_name;
		
		$check_document_if_exist  = $this->db
										->select('*')
										->from('document_profile')
										->where('document_number', $document_number)
										->get()->row();

		$check_last_log  = $this->db
								->limit(1)
								->select('*')
								->from('receipt_control_logs')
								->where('document_number', $document_number)																
								->where('status', '1')																
								->order_by('log_date', 'desc')
								->get()->row();

		// check if document exist.
		if($check_document_if_exist ){
			
			$check_if_recipient  = $this->db
								->select('*')
								->from('document_recipients')
								->where('document_number', $document_number)								
								->where('recipient_office_code', $office_code)
								->where('received', '1')
								->where('active', '1')
								->get()->row();

			// check if created
			if($check_document_if_exist->status == 'Verified'){
				



			// condition if receive		
			if($check_if_recipient && $check_last_log->type == 'Released'){

					// get the document_info
					$get_document_info = $this->db												
										->select("*,
												(select lo_sender.INFO_DIVISION as sender_division  from users as u
													inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
													where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_division,
												(select lo_sender.INFO_SERVICE as sender_service   from users as u
													inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
													where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_service,
												(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
													inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
													where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_office_code,


												(select log_origin.INFO_DIVISION as origin_division  from users as u
													inner join lib_office as log_origin on log_origin.office_code = u.office_code
													where u.user_id = dp.created_by_user_id)  as origin_division,
												(select log_origin.INFO_SERVICE as origin_service   from users as u
													inner join lib_office as log_origin on log_origin.office_code = u.office_code
													where u.user_id = dp.created_by_user_id)  as origin_service,
												(select log_origin.OFFICE_CODE as origin_office_code   from users as u
													inner join lib_office as log_origin on log_origin.office_code = u.office_code
													where u.user_id = dp.created_by_user_id)  as origin_office_code,

												(select remarks from receipt_control_logs where document_number = dr.document_number  and type = 'Released' order by log_date DESC limit 1) as rcl_remarks,
												dp.type as document_type
										
										")
										->from('document_profile as dp')
										->join('document_recipients as dr','dp.document_number = dr.document_number')
										->join('receipt_control_logs as rcl','rcl.document_number = dr.document_number')
										->where('dr.document_number', $document_number)								
										->where('recipient_office_code', $office_code)
										->order_by('log_date','desc')
										->get()->row();

				$result = ["Message" => "true", "type" => 'receive',"doc_info" => array($get_document_info)];		
			}
			//condition if release
			else{



				// check if return to sender condition if release
				if($check_last_log->action == 'Return to Sender' && $check_last_log->transacting_office != $office_code ){

					$check_if_already_recipient  = $this->db
								->select('*')
								->from('document_recipients')
								->where('document_number', $document_number)																
								->where('added_by_user_office', $office_code)
								->or_where('recipient_office_code', $office_code)
								->where('received', '0')
								->get()->row();

					// check if already recipient 
					if($check_if_already_recipient){

						
						// get the document_info
						$get_document_info = $this->db
												
												->select("*,
												(select lo_sender.INFO_DIVISION as sender_division  from users as u
												inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
												where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_division,
											(select lo_sender.INFO_SERVICE as sender_service   from users as u
												inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
												where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_service,
											(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
												inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
												where u.user_id = '".$check_last_log->transacting_user_id."')  as sender_office_code,
	
	
											(select log_origin.INFO_DIVISION as origin_division  from users as u
												inner join lib_office as log_origin on log_origin.office_code = u.office_code
												where u.user_id = dp.created_by_user_id)  as origin_division,
											(select log_origin.INFO_SERVICE as origin_service   from users as u
												inner join lib_office as log_origin on log_origin.office_code = u.office_code
												where u.user_id = dp.created_by_user_id)  as origin_service,
											(select log_origin.OFFICE_CODE as origin_office_code   from users as u
												inner join lib_office as log_origin on log_origin.office_code = u.office_code
												where u.user_id = dp.created_by_user_id)  as origin_office_code,

											(select remarks from receipt_control_logs where document_number = dr.document_number  and type = 'Released' order by log_date DESC limit 1) as rcl_remarks,
											dp.type as document_type
												
												")
												->from('document_profile as dp')
												->join('document_recipients as dr','dp.document_number = dr.document_number')
												->join('receipt_control_logs as rcl','rcl.document_number = dr.document_number')
												->where('dr.document_number', $document_number)								
												->where('recipient_office_code', $office_code)
												->or_where('added_by_user_office', $office_code)
												->order_by('log_date','desc')
												->get()->row();
						
					

						$result = ["Message" => "true", "type" => 'receive',"doc_info" => array($get_document_info)];		

					}else{

						$result = ["Message" => 'Not Authorize to Receive' ];
					}
						
				}else{



					
						// RELEASE FUNCTION
						$get_sender =  $this->db							
								->select('*')
								->from('receipt_control_logs')
								->where('document_number', $document_number)																
								->where('status', '1')																
								->order_by('log_date', 'desc')
								->get()->result();

						

						
								

						if($check_last_log->type == 'Received' && $check_last_log->transacting_office == $office_code){

							
						$check_if_release = $this->db
						->select("*,
								(select lo_sender.INFO_DIVISION as sender_division  from users as u
								inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
								where u.user_id = '".$get_sender[1]->transacting_user_id."')  as sender_division,
							(select lo_sender.INFO_SERVICE as sender_service   from users as u
								inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
								where u.user_id = '".$get_sender[1]->transacting_user_id."')  as sender_service,
							(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
								inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
								where u.user_id = '".$get_sender[1]->transacting_user_id."')  as sender_office_code,


							(select log_origin.INFO_DIVISION as origin_division  from users as u
								inner join lib_office as log_origin on log_origin.office_code = u.office_code
								where u.user_id = dp.created_by_user_id)  as origin_division,
							(select log_origin.INFO_SERVICE as origin_service   from users as u
								inner join lib_office as log_origin on log_origin.office_code = u.office_code
								where u.user_id = dp.created_by_user_id)  as origin_service,
							(select log_origin.OFFICE_CODE as origin_office_code   from users as u
								inner join lib_office as log_origin on log_origin.office_code = u.office_code
								where u.user_id = dp.created_by_user_id)  as origin_office_code,

							(select remarks from receipt_control_logs where document_number = dr.document_number  and type = 'Released' order by log_date DESC limit 1) as rcl_remarks,
							dp.type as document_type
						
						")
						->from('document_profile as dp')																						
						->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')
						->join('document_recipients as dr','dr.document_number = rcl.document_number')											
						->join('lib_office as lo','lo.office_code = dp.office_code')											
						->where('dp.document_number',$document_number)	
						->where('rcl.transacting_office',$office_code)											
						->where('rcl.status','1')		
						->where('dr.received','0')											
						->order_by('log_date','DESC')																			
						->get()
						->row();
						
							// check if last log is release
							if( isset($check_if_release->type) == 'Received'  && isset($check_if_release->transacting_office) == $office_code  ){
								$get_document_info = $check_if_release;
								$result = ["Message" => "true", "type" => 'release',"doc_info" => array($get_document_info)];		
							}else{
									// insert to logs not valid to receive
									$this->db->insert('receipt_control_logs',[
										'type' => 'Received',
										'document_number' => $document_number,						
										'action' => 'Received',
										'remarks' => '',
										'file' => '',
										'attachment' => '',
										'transacting_user_id' => $user_id,
										'transacting_user_fullname' => $full_name,
										'transacting_office' => $office_code,
										'status' => '0'
									]);
									$result = ["Message" => "Not Authorize"];
							}	
							
					
														




						}else{
								// insert to logs not valid to receive
								$this->db->insert('receipt_control_logs',[
									'type' => 'Received',
									'document_number' => $document_number,						
									'action' => 'Received',
									'remarks' => '',
									'file' => '',
									'attachment' => '',
									'transacting_user_id' => $user_id,
									'transacting_user_fullname' => $full_name,
									'transacting_office' => $office_code,
									'status' => '0'
								]);
								$result = ["Message" => "Not Authorize"];
						}
												
					
				}

				
			}
			}else if($check_document_if_exist->status == 'Archived'){
				$result = ["Message" => 'This document process is already completed.' ];
			}
			else{

				$result = ["Message" => 'The document profile was still draft.' ];
			}


		}else{
			$result = ["Message" => "Invalid document number or document does not exist."];
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



		

		$check_last_log  = $this->db
								->limit(1)
								->select('*')
								->from('receipt_control_logs')
								->where('document_number', $document_number)																
								->where('status', '1')																
								->order_by('log_date', 'desc')
								->get()->row();

		if($check_last_log->type == 'Released'){
			$update_document_recipient =$this->db
							->where('document_number',$document_number)
							->where('recipient_office_code',$office_code)						
							->update('document_recipients',[
								'received' => '0',							
							]);						
			$insert_record = $this->db->insert('receipt_control_logs',[
						'type' => 'Received',
						'document_number' => $document_number,					
						'action' => 'Received',
						'remarks' => '',
						'file' => '',
						'attachment' => '',
						'transacting_user_id' => $user_id,
						'transacting_user_fullname' => $full_name,
						'transacting_office' => $office_code,
						'status' => '1',
					]);

			if($insert_record && $update_document_recipient){

				$result = ["Message" => "true"];
			}else{
				$result = ["Message" => "false"];
			};
		}else{

			$result = ["Message" => "false"];
		}
		
				
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}
	return $result;
}



// Receive Document Screen
public function release_document(){

	$result = '';

	try{
		$uuid = $this->generate_uuid();
		
		$request = json_decode(file_get_contents('php://input'));
		

		
		
				
		$document_number = json_decode($this->input->post('document_number'));
		$office_code = json_decode($this->input->post('office_code'));
		$recipients_office_code =json_decode( $this->input->post('recipients_office_code'));
		$user_id =json_decode( $this->input->post('user_id'));
		$full_name = json_decode($this->input->post('full_name'));
		$info_division =json_decode($this->input->post('info_division'));
		$info_service = json_decode($this->input->post('info_service'));
		$action = json_decode($this->input->post('action'));
		$remarks = json_decode($this->input->post('remarks'));
		$doc_prefix = json_decode($this->input->post('doc_prefix'));
		$file=json_decode($this->input->post('file_attachments'));		
		// file upload
		if(count($file) != 0 ){
			for($i = 0 ; $i < count($file) ; $i++){

				$base_path = './uploads/';
				$docPath = './uploads/attachments/'.$doc_prefix;

				if(!is_dir($base_path)){
					$oldmask = umask(0);
					mkdir($base_path, 0775, TRUE);
					umask($oldmask);
				}

				if(!is_dir($docPath)){
					$oldmask = umask(0);
					mkdir($docPath, 0777, TRUE);
					umask($oldmask);
				}

				$encrypted_filename = md5($file[$i]->base_name).'.'.$file[$i]->file_extension;
				$this->db->insert('document_file',[					
					'document_number' => $document_number,
					'file_name' =>  $encrypted_filename,							
					'type' => 'attachment',
					'uploaded_by_user_id' => $user_id,
					'uploaded_by_user_fullname' => $full_name
				]);		

				$upload_file = file_put_contents($docPath.'/'.$encrypted_filename, base64_decode($file[$i]->uri));				

			}
		}
		
	


		$check_if_release = $this->db
									->limit(1)
									->select('*')
									->from('document_profile as dp')
									->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')
									->where('dp.document_number',$document_number)
									->where('rcl.type','Received')											
									->where('rcl.status','1')											
									->order_by('log_date','DESC')																			
									->get()
									->result();

		
		


			// insert release receipt acontrol logs
			foreach($check_if_release as $release_doc){

				
					$this->db->insert('receipt_control_logs',[
						'type' => 'Released',
						'document_number' => $document_number,						
						'action' => $action,
						'remarks' => $remarks,
						'file' => '',
						'attachment' => '',
						'transacting_user_id' => $user_id,
						'transacting_user_fullname' => $full_name,
						'transacting_office' => $office_code
					]);
			}

			

			$get_owner = $this->db
									->select('office_code')
									->from('document_profile')
									->where('document_number', $document_number)
									->get()->row()->office_code;


			


			if($action != 'Return to Sender'){
			// insert recipients
			foreach($recipients_office_code as $value){
				
				$get_document_recipients = $this->db
								->select('recipient_office_code')
								->from('document_recipients')
								->where('document_number',$document_number)
								->where('received','1')
								->get()->result_array();

								
				if(!in_array($value,array_column($get_document_recipients,"recipient_office_code"))){
					$this->db->insert('document_recipients',[					
						'document_number' => $document_number,
						'recipient_office_code' => $value,		
						'owner' => $value == $get_owner ? 'Y' : 'N',		
						'added_by_user_id' => $user_id,
						'added_by_user_fullname' => $full_name			
					]);	
				}

			}
			}
			$result = ["Message" => "true"];
		

		return $result;					
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];				
	}
}








// check document if the recipient is valid to receive
public function check_document($document_number,$office_code){

	$get_records = $this->db
						->limit(1)
						->select('dp.document_number,recipient_office_code,subject,dp.remarks,INFO_SERVICE,INFO_DIVISION,
						
						(select lo_sender.INFO_DIVISION as sender_division  from users as u
						inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
						where u.user_id = dr.added_by_user_id)  as sender_division,

					(select lo_sender.INFO_SERVICE as sender_service   from users as u
						inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
						where u.user_id = dr.added_by_user_id)  as sender_service,

					(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
						inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
						where u.user_id = dr.added_by_user_id)  as sender_office_code,



					(select log_origin.INFO_DIVISION as origin_division  from users as u
						inner join lib_office as log_origin on log_origin.office_code = u.office_code
						where u.user_id =  dp.created_by_user_id)  as origin_division,

					(select log_origin.INFO_SERVICE as origin_service   from users as u
						inner join lib_office as log_origin on log_origin.office_code = u.office_code
						where u.user_id =  dp.created_by_user_id)  as origin_service,
				
					(select log_origin.OFFICE_CODE as origin_office_code   from users as u
						inner join lib_office as log_origin on log_origin.office_code = u.office_code
						where u.user_id =  dp.created_by_user_id)  as origin_office_code
						
						')
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
						->limit(1)
						->select('*')						
						->join('receipt_control_logs as rcl')						
						->join('lib_office as lo','lo.office_code = rcl.transacting_office')						
						->where('dp.document_number',$document_number)
						->where('rcl.transacting_office',$office_code)						
						->where('rcl.action','Received')
						->where('rcl.status','1')						
						->order_by('rcl.log_date', 'DESC')
						->get()->result();


	if($get_records){
		return $get_records;
	}
}

// get history timeline (Document History Screen)
public function get_history($document_number){
	$result = '';
	try{

		$get_first_log_id = $this->db->select("MIN(log_id) as first_log_id")->from('receipt_control_logs')->where('document_number',$document_number)->get()->row()->first_log_id;
		$get_records = $this->db									
							->select('dp.document_number,
										rcl.transacting_office,
										subject,dp.remarks,
										INFO_SERVICE,
										INFO_DIVISION,
										rcl.type,
										rcl.transacting_user_fullname,  
										rcl.status as rcl_status,  
										CONCAT( DATE_FORMAT(rcl.log_date,"%M %e, %Y"),"\n", TIME_FORMAT(rcl.log_date,"%r")) as time,
										rcl.remarks as rcl_remarks,
										dp.origin_type
										
										')
							->from('document_profile as dp')															
							->join('receipt_control_logs as rcl','dp.document_number = rcl.document_number')
							->join('lib_office as lo','lo.office_code = rcl.transacting_office')														
							->where('dp.document_number', $document_number)														
							->where('log_id !=',$get_first_log_id)							
							->order_by("rcl.log_date", "desc")									
							->get()->result();

		$get_document_info = $this->db->select('*')
									->from('document_profile')
									->where('document_number', $document_number)
									->get()->row();
		$get_recipients = $this->db			
								->select('*')
								->from('document_recipients as dr')
								->join('lib_office as lo','lo.office_code = dr.recipient_office_code')
								->where('document_number', $document_number)																	
								->get()
								->result();																				
								
								
		if($get_records){
			$result = ["Message" => "true", "history" =>$get_records,"released_to" => $get_recipients,"document_info" => $get_document_info];
		}
		
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];		
	}
	return $result;
}


// list of offices
public function get_offices($document_number,$my_office_code){
	$result = '';
	try{


		$get_document_recipients = $this->db
										->select('recipient_office_code')
										->from('document_recipients')
										->where('document_number',$document_number)
										->where('received','1')
										->get()->result();
		$consolidate_recipients = [];									
		//  push default recipients
		foreach($get_document_recipients as $item){
			array_push($consolidate_recipients,$item->recipient_office_code);
		}
								
		$check_if_recipient_is_empty = isset($consolidate_recipients) ? $consolidate_recipients  : array() ;
		
		array_push($check_if_recipient_is_empty,$my_office_code);
		
		
		$get_division = $this->db->distinct()->select('INFO_DIVISION ,office_code')->from('lib_office')->where('STATUS_CODE','1')->group_by('INFO_DIVISION')->get();
		
		$office_array = [];
		if($get_division){

			foreach($get_division->result() as $division_key => $item){

				array_push($office_array , ["name"=>$item->INFO_DIVISION,'id'=>$division_key, "children"=>[]]);

				$get_records = $this->db->select('INFO_SERVICE,OFFICE_CODE,SHORTNAME_REGION,INFO_DIVISION')->from('lib_office')->where('STATUS_CODE','1')->where('INFO_DIVISION',$item->INFO_DIVISION)->where_not_in('office_code',$check_if_recipient_is_empty )->get();		
				foreach($get_records->result() as $value){	
					
					
					foreach($office_array as $office_value){						
						if($office_value['id'] == $division_key){
						
								array_push($office_array[$division_key]['children'],["division"=>$value->INFO_DIVISION,"name"=>($value->SHORTNAME_REGION  == 'OSEC' ? 'DA / ' : '').$value->INFO_SERVICE,'id'=>$value->OFFICE_CODE]);
							
						}
					}

					
				
				}
			}
		
			

			// get default recipients
			$get_default_recipient_office_info = $this->db->select('info_service,office_Code,shortname_region,info_division')->from('lib_office')->where('STATUS_CODE','1')
										->where_in('office_code',count($consolidate_recipients) != 0 ? $consolidate_recipients : '')->get()->result();



			
			
	
		
			$result = ["Message" => "true", "offices" =>$office_array,"default_recipients" =>$consolidate_recipients ,"default_recipients_info" =>$get_default_recipient_office_info ];
		}
		return $result;

	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];
	}
}


public function get_doc_type(){
	$result = '';
	try{
		$get_doc_type =  $this->db->select('*')
									->from('doc_type')
									->get()->result();
		$result = ["Message" => "true", "doc_type" =>$get_doc_type ];
	}catch(\Exception $e){
		$result = ["Message" => "false", "error" => $e->getMessage()];
	}
	return $result;
}



}