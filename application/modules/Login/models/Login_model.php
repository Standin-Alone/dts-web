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
		
		$this->db->get_where('users', array('email' => $email, 'status' => '1'), 1);
		return $this->db->affected_rows();
	}

	public function insertOTP($user_id,$email){
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
			$this->send_email($user_id,$otp,$email);
		}

		return $otp.$user_id.$email;
	}

	public function send_email($user_id,$otp,$email){
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
		$config['smtp_pass'] = 'SysADDem@1L0721';
		$config['validate']	 = FALSE;
		$config['charset']  = 'iso-8859-1';
		$config['wordwrap'] = true;
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		$email_template = $this->load->view('Email_otp_view', $data, true);

		$this->email->from('support.sadd@da.gov.ph', 'no-reply');
		$this->email->to($email);
		$this->email->subject('User OTP | Document Tracking System');
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
			$this->session->set_userdata($user_data);
			$output['result'] = 'success';

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
		$query = $this->db->select("a.user_id,a.password,a.email,UPPER(CONCAT(a.first_name,' ',LEFT(a.middle_name,1),' ',a.last_name)) AS fullname,UPPER(a.first_name) as first_name,UPPER(a.middle_name) as middle_name,UPPER(a.last_name) as last_name,b.OFFICE_CODE,b.INFO_SERVICE,b.INFO_DIVISION,b.SHORTNAME_SERVICE,b.ID_REGION,b.ID_SERVICE,b.ID_DIVISION")
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
				'dts_logged_in' 	=> TRUE
			);

			#$this->session->set_userdata($data);
			#$output['result'] = 'success';

			#$this->deactivate_token($user_id);
			return $data;
		}
	}

	public function base64url_encode($data) { 
 	   return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	}  


}