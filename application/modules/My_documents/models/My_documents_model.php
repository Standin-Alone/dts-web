<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class My_documents_model extends CI_Model {

	public function generate_uuid(){
		return Uuid::uuid4();
	}

	public function update_user(){
		//$result = 'fail';
		$result['event'] = 'success';
		$user_id = $this->input->post('user_id', true);
		// $name = $this->input->post('name', true);
		//$email = $this->input->post('email', true);
		$status = $this->input->post('status', true);

		$pras_data = array(

			// 'name'   => trim(strtoupper($name)),
			//'email'   => trim(strtoupper($email)),
			'active'   => trim(strtoupper($status)),
		);

		$pras = $this->db->where('user_id', $user_id)->update('users', $pras_data);

		if($pras){
			// $last_query 	= $this->db->get_where('pras_table', array('pras_id' => $pras_id));
			// $result['data'] = $last_query->result();
			// $result['data'][0]->pras_id;
			return $result;
		}
		$result['event'] = 'fail';
		return $result;
	}

	public function check_exists($params){
		$query = $this->db->where('pras_num', $params)
						  ->get('pras_table');
		$output['dedup'] = $query->num_rows();

		if($query){
			return $output;
		}
	}

	public function get_by_user(){
		$draw   = $this->input->post('draw', true);
		$start  = $this->input->post('start', true);
		$length = $this->input->post('length', true);
		$search = $this->input->post('search', true);
		$user_id = $this->session->userdata('user_id', true);


		$this->db->select('*')
				 ->from('vw_document_profile_info')
				 ->where('office_code', $this->session->userdata('office'));

		if($search != ''){
			$this->db->group_start()
					 ->like('document_number', $search['value'])
					 ->or_like('date', $search['value'])
					 ->or_like('sender_name', $search['value'])
					 ->or_like('sender_address', $search['value'])
					 ->or_like('subject', $search['value'])
					 ->or_like('remarks', $search['value'])
					 ->or_like('type', $search['value'])
					 ->group_end();
		}

		// $this->db->group_by('pras_num')
		$this->db->order_by('date_created', 'DESC')
				 ->limit($length, $start);

		$query = $this->db->get();

		//echo $this->db->last_query();

		$data = array(
			'draw' 			  => $draw,
			'recordsTotal' 	  => $this->get_total_records($search['value'], $user_id),
			'recordsFiltered' => $this->get_total_records($search['value'], $user_id),
			'data' 			  => $query->result()
		);

		return $data;
	}

	public function get_total_records($search = null, $user_id = null){
		$this->db->select('*')
				 ->from('vw_document_profile_info')
				 ->where('office_code', $this->session->userdata('office'));

		if($search != ''){
			$this->db->group_start()
					 ->like('document_number', $search)
					 ->or_like('date', $search)
					 ->or_like('sender_name',$search)
					 ->or_like('sender_address', $search)
					 ->or_like('subject',$search)
					 ->or_like('remarks', $search)
					 ->or_like('type',$search)
					 ->group_end();
		}
		
		// $this->db->group_by('document_number')
		$this->db->order_by('date_created', 'DESC');
				 
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_all(){
		$draw   = $this->input->post('draw', true);
		$start  = $this->input->post('start', true);
		$length = $this->input->post('length', true);
		$search = $this->input->post('search', true);
		$user_id = $this->session->userdata('user_id', true);


		$this->db->select('*')
				 ->from('receipt_control_logs')
				 //->where('EXISTS (SELECT * FROM lib_office WHERE document_profile.office_code = lib_office.OFFICE_CODE)', '', FALSE);
			   	 //->where('EXISTS (SELECT * FROM lib_office WHERE document_profile.office_code = lib_office.OFFICE_CODE )', '', FALSE); 
			   	 ->where('action', 'Received')
				 ->where('transacting_office !=', $this->session->userdata('office') );

		if($search != ''){
			$this->db->group_start()
					 ->like('document_number', $search['value'])
					 ->or_like('log_date', $search['value'])
					 ->or_like('transacting_user_fullname', $search['value'])
					 ->or_like('action', $search['value'])
					 ->or_like('type', $search['value'])
					 ->group_end();
		}

		// $this->db->group_by('pras_num')
		$this->db->order_by('log_date', 'DESC')
				 ->limit($length, $start);

		$query = $this->db->get();

		//echo $this->db->last_query();

		$data = array(
			'draw' 			  => $draw,
			'recordsTotal' 	  => $this->get_total_all($search['value'], $user_id),
			'recordsFiltered' => $this->get_total_all($search['value'], $user_id),
			'data' 			  => $query->result()
		);

		return $data;
	}

	public function get_total_all($search = null, $user_id = null){
		$this->db->select('*')
				 ->from('receipt_control_logs')
				 //->where('EXISTS (SELECT * FROM lib_office WHERE document_profile.office_code = lib_office.OFFICE_CODE )', '', FALSE); 
				 ->where('action', 'Received')
				 ->where('transacting_office', $this->session->userdata('office') );

		if($search != ''){
			$this->db->group_start()
					 ->like('document_number', $search)
					 ->or_like('log_date', $search)
					 ->or_like('transacting_user_fullname',$search)
					 ->or_like('action', $search)
					 ->or_like('type',$search)
					 ->group_end();
		}
		
		// $this->db->group_by('document_number')
		$this->db->order_by('log_date', 'DESC');
				 
		$query = $this->db->get();

		return $query->num_rows();
	}


	public function get_users_update(){
		$user_id = $this->input->post('user_id', true);
		$query = $this->db->where('user_id', $user_id)
						  ->get('users');
		if($query){
			return $query->result_array();
		}
	}

  	public function register($pw_update_data){
		$result = 'fail';

		$register_id = Uuid::Uuid4()->toString();
        $register_data = array(
            'user_id' => $register_id,
            "email" => trim(strtoupper($pw_update_data['email'])),
            "name" => trim(strtoupper($pw_update_data['fullname'])),
            "username" => trim(strtoupper($pw_update_data['username'])),
            "password" => $pw_update_data['password'],
            "type" => 'admin'
        );

		$query = $this->db->insert('users', $register_data);

		if($query){
			$create_token = $this->insertToken($register_id);
			if($create_token){
				$result = 'success';
			}
		}
		return $result;
	}

    public function insertToken($register_id){
		$token = substr(sha1(rand()), 0, 30);
		$date  = date('Y-m-d');
		$string = array(
			'token'   => $token,
			'user_id' => $register_id,
			'date' 	  => $date
		);

		$query = $this->db->insert('users_token', $string);
		return $token.$register_id;
	}

}
