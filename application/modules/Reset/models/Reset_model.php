<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_model extends CI_Model {

	public function check_email(){
		$email = $this->input->post('email', true);

		$this->db->get_where('users', array('email' => $email, 'status' => '1'), 1);

		return $this->db->affected_rows();
	}
}