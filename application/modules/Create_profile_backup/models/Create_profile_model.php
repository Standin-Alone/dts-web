<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Create_profile_model extends CI_Model {

	public function generate_uuid(){
		return Uuid::uuid4();
	}

	public function add_pras_profile(){
		//$result = 'fail';
		$result['event'] = 'success';
		$pras_id = Uuid::Uuid4()->toString();
		$pras_num = $this->input->post('pras_num', true);
		$pras_desc = $this->input->post('pras_desc', true);
		$abc = $this->input->post('abc', true);
		$office_code = $this->input->post('office_code', true);
		$service_code = $this->input->post('service_code', true);
		$division_code = $this->input->post('division_code', true);
		$mode = $this->input->post('mode', true);
		$reference_id = $this->input->post('reference_id', true);


		$pras_data = array(
			'pras_id'   => $pras_id,
			'reference_id'   => $reference_id,
			'pras_num'   => $pras_num,
			'pras_desc'   => $pras_desc,
			'abc'   => $abc,
			'office_code'   => $office_code,
			'service_code'   => $service_code,
			'division_code'   => $division_code,
			'mode'   => $mode,
			'date_start'   => date("Y-m-d", strtotime($this->input->post('date_start', true))),
			'date_end'   => date("Y-m-d", strtotime($this->input->post('date_end', true))),
			'date_opening'   => date("Y-m-d", strtotime($this->input->post('date_opening', true)))
		);

		//$pras = $this->db->insert('pras_table', $pras_data);

		echo '<pre>';
		print_r($pras_data);
		echo '</pre>';

		if($pras){
			$last_query 	= $this->db->get_where('pras_table', array('pras_id' => $pras_id));
			$result['data'] = $last_query->result();
			$result['data'][0]->pras_num;
			$id_status   = Uuid::uuid4()->toString();
			$data_status = array(
				'id_status'				=> $id_status,
				'pras_id' => $result['data'][0]->pras_id,
				'modified_by' => $this->session->userdata('user_id')
			);

			$query_status = $this->db->insert('pras_status', $data_status);

			if($query_status){
				$this->insert_logs($result['data'][0]->pras_id);
				return $result;
			}
			//$result = 'success';
			//$result['event'] = 'success';

		}
		$result['event'] = 'fail';
		return $result;
	}

	public function insert_logs($pras_id){
		
		//$check = $this->check_logs($doc_number);

		//if($check == 0){
		$log = array(
			'log_id'   			   => Uuid::uuid4(),
			'pras_id'  => $pras_id,
			'encoder_id'	   => $this->session->userdata('user_id')
		);

		$query = $this->db->insert('pras_logs_insert', $log);

		if($query){
			return 'success';
		} else {
			return 'fail';
		}
		//}
	}

	public function check_exists($params){
		$query = $this->db->where('pras_num', $params)
						  ->get('pras_table');
		$output['dedup'] = $query->num_rows();

		if($query){
			return $output;
		}
	}

	public function get_offices($office_name){
		$this->db->select('ID_REGION, INFO_REGION')
				 ->like('INFO_REGION', $office_name)
				 ->group_by("ID_REGION")
				 ->order_by("INFO_REGION", "asc");
		$query = $this->db->get('office');
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
				$new_row['label']=stripslashes($row['INFO_REGION']);
				$new_row['value']=htmlentities(stripslashes($row['ID_REGION']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function get_services($service_name, $office_code){
		$this->db->select('ID_SERVICE, INFO_SERVICE')
				 ->like('INFO_SERVICE', $service_name)
				 ->where('ID_REGION', $office_code)
				 ->group_by("ID_SERVICE")
				 ->order_by("INFO_SERVICE", "asc");
		$query = $this->db->get('office');
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
				$new_row['label']=stripslashes($row['INFO_SERVICE']);
				$new_row['value']=htmlentities(stripslashes($row['ID_SERVICE']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function get_divisions($division_name, $service_code, $office_code){
		$this->db->select('ID_DIVISION, INFO_DIVISION')
				 ->like('INFO_DIVISION', $division_name)
				 ->where('ID_SERVICE', $service_code)
				 ->where('ID_REGION', $office_code)
				 ->group_by("ID_DIVISION")
				 ->order_by("INFO_DIVISION", "asc");
		$query = $this->db->get('office');
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['office_name']));  //build an array
				$new_row['label']=stripslashes($row['INFO_DIVISION']);
				$new_row['value']=htmlentities(stripslashes($row['ID_DIVISION']));
				$row_set[] = $new_row;
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

	public function remove_uploaded_file($rm_id, $db){
		$query = $this->db->where('id', $rm_id)
						  ->delete($db);

		if($query){
			return true;
		}else {
			return false;
		}
	}

	public function document_type(){
		$query = $this->db->get('doc_type');
		return $query->result();
	}

	public function document_for(){
		$query = $this->db->get('document_for');
		return $query->result();
	}

	public function get_recipients($q){
		$this->db->select('ID_DIVISION, INFO_DIVISION')
				 ->from('lib_office')
				 ->like('INFO_DIVISION', $q);
				//->limit('50');
		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['INFO_DIVISION']));
					//$new_row['value']=htmlentities(stripslashes($row['ID_DIVISION']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

	public function recipients(){
		$this->db->select('ID_AGENCY, INFO_SERVICE, ORIG_SHORTNAME, SHORTNAME_REGION, OFFICE_CODE, INFO_DIVISION')
				 ->from('lib_office')
				 ->where('STATUS_CODE', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_signature_da_name($q){
		$this->db->select('Name_F, Name_L, Name_M, Name_EXT, EMP_NO')
				 ->from('employee')
				 //->where('agency_id', $w)
				 ->like('Name_L', $q)
				 ->limit('50');

		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$name_ext = $row['Name_EXT'] == '' ? '' : ' '.$row['Name_EXT'];
					$new_row['label']=stripslashes(stripslashes($row['Name_F'].' '.$row['Name_M'].' '.$row['Name_L'].$name_ext));
					$new_row['value']=htmlentities(stripslashes($row['EMP_NO']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}
	
	public function get_signature_div_da($q){
		$this->db->select('INFO_SERVICE, INFO_DIVISION, ID')
				 ->from('lib_office')
				 //->where('agency_id', $w)
				 ->like('INFO_DIVISION', $q)
				 ->or_like('INFO_SERVICE', $q)
				 ->limit('50');

		$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=stripslashes(stripslashes($row['INFO_SERVICE'].' / '.$row['INFO_DIVISION']));
					$new_row['value']=htmlentities(stripslashes($row['ID']));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set); //format the array into json data
			}
	}

}