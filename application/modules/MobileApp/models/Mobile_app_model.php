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
								->join('lib_office as lo','lo.office_code = rcl.office_code')
								->where('rcl.office_code',$office_code)																								
								->where('rcl.status','1')								
								->limit(5,$current_page  == 1 ? 0 : $current_page)
								->group_by(['rcl.document_number','rcl.status'])
								->order_by('log_date')
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
		// payload
		$document_number = $request->document_number;
		$office_code = $request->office_code;
		$user_id = $request->user_id;
		$full_name = $request->full_name;


		// $check_if_release = $this->check_if_release($document_number, $office_code);

		$check_document_exist = $this->db
									->limit(1)
									->select('*')
									->from('receipt_control_logs')
									->where('document_number',$document_number)
									->order_by('log_date','desc')									
									->get()
									->result();

		// check if the document is exist
		if($check_document_exist){
		
			$check_if_receive = $this->db
										->limit(1)
										->select('*,(select lo_sender.INFO_DIVISION as sender_division  from users as u
										inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
										where u.user_id = dr.added_by_user_id)  as sender_division,
									(select lo_sender.INFO_SERVICE as sender_service   from users as u
										inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
										where u.user_id = dr.added_by_user_id)  as sender_service,
									(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
										inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
										where u.user_id = dr.added_by_user_id)  as sender_office_code')
										->from('document_profile as dp')
										->join('document_recipients as dr','dr.document_number = dp.document_number')
										->join('lib_office as lo','lo.office_code = dr.recipient_office_code')																			
										->where('dr.document_number',$document_number)
										->where('dr.recipient_office_code',$office_code)
										->where('dr.active','1')
										->get()
										->result();

			// check if valid to receive
			if($check_if_receive){

				$get_doc_info = $check_if_receive;
				$type="receive";

				$result = ["Message" => "true", "type" => $type,"doc_info" => $get_doc_info];		
						
			}else{

				// check scanned document if for release
				$check_if_release = $this->db
											->limit(1)
											->select('*,(select lo_sender.INFO_DIVISION as sender_division  from users as u
											inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
											where u.user_id = dr.added_by_user_id)  as sender_division,
										(select lo_sender.INFO_SERVICE as sender_service   from users as u
											inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
											where u.user_id = dr.added_by_user_id)  as sender_service,
										(select lo_sender.OFFICE_CODE as sender_office_code   from users as u
											inner join lib_office as lo_sender on lo_sender.office_code = u.office_code
											where u.user_id = dr.added_by_user_id)  as sender_office_code')
											->from('document_profile as dp')																						
											->join('receipt_control_logs as rcl','rcl.document_number = dp.document_number')
											->join('document_recipients as dr','dr.document_number = rcl.document_number')											
											->where('dp.document_number',$document_number)
											->where('rcl.office_code',$office_code)																						
											->where('rcl.status','1')		
											->where('dr.active','0')											
											->order_by('log_date','DESC')																			
											->get()
											->result();

				if($check_if_release[0]->transacting_office == $office_code && $check_if_release[0]->type == 'Received'  ){

					$get_doc_info = $check_if_release;
					$type="release";
					$result = ["Message" => "true", "type" => $type,"doc_info" => $get_doc_info];		

				}else{

					// insert to logs not valid to receive
					$this->db->insert('receipt_control_logs',[
						'type' => 'Received',
						'document_number' => $document_number,
						'office_code' => $office_code,
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
			
		
		}else{
			$result = ["Message" => "Document not found."];		
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
							'active' => '0',							
						]);						
				$this->db->insert('receipt_control_logs',[
					'type' => 'Received',
					'document_number' => $value->document_number,
					'office_code' => $value->recipient_office_code,
					'action' => 'Received',
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
		

		
		
				
		$document_number = json_decode($this->input->post('document_number'));
		$office_code = json_decode($this->input->post('office_code'));
		$recipients_office_code =json_decode( $this->input->post('recipients_office_code'));
		$user_id =json_decode( $this->input->post('user_id'));
		$full_name = json_decode($this->input->post('full_name'));
		$info_division =json_decode($this->input->post('info_division'));
		$info_service = json_decode($this->input->post('info_service'));
		$action = json_decode($this->input->post('action'));
		$doc_prefix = json_decode($this->input->post('doc_prefix'));
		$file=json_decode($this->input->post('file_attachments'));

		// file upload
		if(count($file) != 0 ){
			for($i = 0 ; $i < count($file) ; $i++){

				$base_path = './uploads/';
				$docPath = './uploads/files/'.$doc_prefix;

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

				$encrypted_filename = md5($file[$i]->base_name).$file[$i]->file_extension;
				$this->db->insert('document_file',[					
					'document_number' => $document_number,
					'file_name' =>  $encrypted_filename,							
					'type' => 'base_file',
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
						'office_code' => $office_code,
						'action' => $action,
						'remarks' => $release_doc->remarks,
						'file' => '',
						'attachment' => '',
						'transacting_user_id' => $user_id,
						'transacting_user_fullname' => $full_name,
						'transacting_office' => $office_code
					]);
			}

			// get the last sequence
			$get_last_sequence = $this->db
										->select('sequence')
										->from('document_recipients')
										->where('document_number',$document_number)
										->where('active','0')
										->where('recipient_office_code',$office_code)
										->order_by('sequence','DESC')
										->limit(1)
										->get()->result();

			// insert recipients
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
						where u.user_id = dr.added_by_user_id)  as sender_office_code
						
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
						->join('lib_office as lo','lo.office_code = rcl.office_code')						
						->where('dp.document_number',$document_number)
						->where('rcl.office_code',$office_code)						
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
										rcl.office_code,
										subject,dp.remarks,
										INFO_SERVICE,
										INFO_DIVISION,
										rcl.type,
										rcl.transacting_user_fullname,  
										rcl.status as rcl_status,  
										CONCAT( DATE_FORMAT(rcl.log_date,"%M %e, %Y"),"\n", TIME_FORMAT(rcl.log_date,"%r")) as time')
							->from('document_profile as dp')															
							->join('receipt_control_logs as rcl','dp.document_number = rcl.document_number')
							->join('lib_office as lo','lo.office_code = rcl.office_code')														
							->where('dp.document_number', $document_number)														
							->where('log_id !=',$get_first_log_id)
							->order_by("rcl.log_date", "desc")							
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

				$get_records = $this->db->select('INFO_SERVICE,OFFICE_CODE,SHORTNAME_REGION,INFO_DIVISION')->from('lib_office')->where('INFO_DIVISION',$item->INFO_DIVISION)->get();		
				foreach($get_records->result() as $value){	
					
					
					foreach($office_array as $office_value){						
						if($office_value['id'] == $division_key){
							array_push($office_array[$division_key]['children'],["division"=>$value->INFO_DIVISION,"name"=>($value->SHORTNAME_REGION  == 'OSEC' ? 'DA / ' : '').$value->INFO_SERVICE,'id'=>$value->OFFICE_CODE]);
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