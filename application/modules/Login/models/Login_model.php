<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function check_user($email, $password){
		$output['result'] = 'success';

		$query = $this->db->select("a.user_id,a.password,a.email")
						  ->from('users as a')
						  ->where('a.email', $email)
						  ->where('a.status', '1')
						  ->get();

		$row = $query->row_array();

		if($query->num_rows() > 0) {
			if(crypt($password, $row['password']) == $row['password']){
				$data  = $this->insertOTP(trim($row['user_id']), trim($row['email']));
				$token = $this->base64url_encode($data);
				$output['token'] = $token;
				return $output;
			}
		}

		$output['result'] = 'failed';
		$output['token']  = $this->security->get_csrf_hash();
		
		return $output;
	}

	public function check_email(){
		$email = $this->input->post('email', true);
		
		$query = $this->db->get_where('users', array('email' => $email, 'status' => '1'), 1);
		return $query->result();
	}

	public function insertOTP($user_id,$email, $mode = null){
		$check_rows = $this->get_duplicates($user_id);
		if(sizeof($check_rows) > 0){
			$this->db->set('status',0)
					 ->where('user_id', $user_id)
					 ->update('user_otp');
		}

		$otp = rand(100000,999999);

		$data = array(
			'otp'  	  => $otp,
			'user_id' => $user_id
		);

		$qs    = $this->db->insert_string('user_otp', $data);
		$query = $this->db->query($qs);

		//email here
		if($query){
			$this->send_email($user_id,$otp,$email, $mode);
		}

		return $otp.$user_id.$email;
	}

	public function send_email($user_id,$otp,$email,$mode){
		$this->load->library('email');

		$user_data = $this->getUserData($user_id);

		$data = array(
			'otp' 		=> $otp,
			'full_name' => $user_data['fullname'],
			'office' 	=> $user_data['division_name']
		);

		$config['protocol']  = 'smtp';  
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '5';
		$config['mailtype']  = 'html';
		$config['smtp_user'] = 'support.sadd@da.gov.ph';
		$config['smtp_pass'] = 'B9F@kn@Ubz4GTLFe';
		$config['validate']	 = FALSE;
		$config['charset']  = 'iso-8859-1';
		$config['wordwrap'] = true;
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		$token  = $this->base64url_encode($otp.$user_id.$email);
		$url	= base_url() . 'Login/reset_password/token/' . $token;
		$link 	= '<a href="'.$url.'">'.$url.'</a>';

		$email_template = '';

		if($mode != null){
			$subject = 'Reset Information | Document Tracking System';
			$email_template .= 'A request to reset the information for your account has been made at Document Tracking System of Department of Agriculture. <br> You may now reset your information by clicking 
                this link or copying and pasting it to your browser: <p></p';
            $email_template .= $link;
			$email_template .= '<p></p>This link can only be used once and will lead you to a page where
					you can complete your registration. It expires after one day and nothing will happen if it is not used. <br><p></p>';
			$email_template .= 'DA-ICTS SysADD | DTS Team<p></p>';
			$email_template .=  '<strong> This is a system-generated email, please do not reply.</strong>';
		}else {
			$subject = 'User OTP | Document Tracking System';
			$email_template = $this->load->view('Email_otp_view', $data, true);
		}
	
		$this->email->from('support.sadd@da.gov.ph', 'no-reply');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($email_template);

		if($this->email->send()){
			$result['result'] = 'send';
		}else {
			$result['error'] = $this->email->print_debugger();
		}

		return $result;
	}

	public function get_duplicates($user_id){
		$this->db->select('user_otp_id, user_id')
				 ->from('user_otp')
				 ->where('status', 1)
				 ->where('user_id', $user_id);

		$query = $this->db->get();
		$data  = $query->result_array();
		return $data;
	}

	public function check_active_otp($otp,$uid,$email){
		/*$otp = substr($token, 0, 6);
		$uid = substr($token, 6);*/

/*		echo $email.'<br>';
		echo $otp.'<br>';
		echo $uid.'<br>';*/
		$output['result'] = 'failed';
		$output['token']  = $this->security->get_csrf_hash();

		$query = $this->db->get_where('user_otp', array(
			'otp' 	  => $otp,
			'user_id' => $uid
		), 1);

		if($this->db->affected_rows() > 0){
			$row = $query->row();

			$date 	= $row->date_created;
			$dateTS = date('Y-m-d', strtotime($date));
			$dateTS = strtotime($dateTS);
			$today  = date('Y-m-d');
			$todayTS = strtotime($today);

			if($dateTS != $todayTS){
				return $output;
			}

			if($row->status != 1){
				return $output;
			}

			$user_data = $this->getUserData($row->user_id);
			$output['user_data'] = $user_data;
			$output['result'] 	 = 'success';

			return $output;
		}else {
			$this->deactivate_token($uid);
			return $output;
		}
	}

	public function deactivate_token($uid){
		$query = $this->db->set('status', 0)
						  ->where('user_id', $uid)
						  ->update('user_otp');

		return true;
	}

	public function getUserData($user_id){
		$query = $this->db->select("a.user_id,a.password,a.email,UPPER(CONCAT(a.first_name,' ',LEFT(a.middle_name,1),' ',a.last_name)) AS fullname,UPPER(a.first_name) as first_name,UPPER(a.middle_name) as middle_name,UPPER(a.last_name) as last_name,b.OFFICE_CODE,b.INFO_SERVICE,b.INFO_DIVISION,b.SHORTNAME_REGION,b.ORIG_SHORTNAME,b.SHORTNAME_SERVICE,b.ID_REGION,b.ID_SERVICE,b.ID_DIVISION")
						  ->from('users as a')
						  ->join('lib_office as b','a.office_code = b.OFFICE_CODE','left')
						  ->where('a.user_id', $user_id)
						  ->get();

		$row = $query->row_array();

		if($query->num_rows() > 0) {
			$data = array(
				'user_id' 	  		=> trim($row['user_id']),
				'fullname'			=> trim($row['fullname']),
				'first_name'  		=> trim($row['first_name']),
				'middle_name'  		=> trim($row['middle_name']),
				'last_name'			=> trim($row['last_name']),
				'email'				=> trim($row['email']),
				'region_id'			=> trim($row['ID_REGION']),
				'service_id'		=> trim($row['ID_SERVICE']),
				'division_id'		=> trim($row['ID_DIVISION']),
				'office'			=> trim($row['OFFICE_CODE']),
				'service_short_name'=> trim($row['SHORTNAME_SERVICE']),
				'service_long_name' => trim($row['INFO_SERVICE']),
				'division_name'		=> trim($row['INFO_DIVISION']),
				'shortname_region'	=> trim($row['SHORTNAME_REGION']),
				'orig_shortname'	=> trim($row['ORIG_SHORTNAME']),
				'dts_logged_in' 	=> TRUE
			);

			return $data;
		}
	}

	public function insert_user_information($uid){
		$output['results'] = 'failed';
		$output['token']   = $this->security->get_csrf_hash();

		$first_name  = $this->input->post('first_name', true);
		$middle_name = $this->input->post('middle_name', true);
		$last_name 	 = $this->input->post('last_name', true);
		$office 	 = $this->input->post('office', true);
		$password    = $this->input->post('password', true);
		$password	 = $this->encPass($password);

		$data = array(
			'first_name'  => $first_name,
			'middle_name' => $middle_name,
			'last_name'   => $last_name,
			'office_code' => $office,
			'password' 	  => $password,
			'status'	  => '1'
		);

		$query = $this->db->where('user_id', trim($uid))
						  ->update('users', $data);

		if($query){
			$this->deactivate_token($uid);
			$output['results'] = 'success';
		}

		return $output;
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

	public function base64url_encode($data) { 
 	   return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	}  

	function encPass($input, $rounds = 10){
		$salt = "";
		$saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
		for($i=0; $i<22; $i++){
		$salt .= $saltChars[array_rand($saltChars)];
		}
		return crypt($input, sprintf('$2y$%02d$', $rounds) .$salt);
    }

}