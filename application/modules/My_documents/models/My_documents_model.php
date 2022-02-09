<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class My_documents_model extends CI_Model {

	public function generate_uuid(){
		return Uuid::uuid4();
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

}
