<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Users_management_model extends CI_Model {

	public function check_email($email){
		$query = $this->db->where('email', $email)
				 		  ->get('users');

		return $query->result();
	}

	public function pre_register($email){
		$user_id = Uuid::uuid4()->toString();
		$data = array(
			'user_id' => $user_id,
			'email'	  => $email,
			'status'  => '0'
		);

		$temp_user = $this->db->insert('users', $data);

		if($temp_user){
			$user_token = $this->insertOTP($user_id, $email);
			return $user_token;
		}
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

		return $otp.$user_id.$email;
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

}