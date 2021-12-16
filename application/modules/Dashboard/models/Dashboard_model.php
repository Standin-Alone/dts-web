<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function incoming_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');

        $get_assign_doc = $this->db->select("*")
            ->from("document_recipients")
            ->where("recipient_office_code", $office_code)
            ->order_by("date_added", "desc")
            ->get()->result();

        $incoming = [];
        foreach ($get_assign_doc as $key => $val) {
            $sequence = $val->sequence - 1;
            $check_if_released = $this->check_if_released($sequence, $val->document_number);

            if ($check_if_released == 0) {
                $incoming[] = $get_assign_doc;
            }
        }

        // echo '<pre>', print_r($incoming), '</pre>';

        return $incoming;
    }

    public function check_if_released($sequence, $document_number)
    {

        $check_prev_office = $this->db->select("active")
            ->from("document_recipients")
            ->where("document_number", $document_number)
            ->where("sequence", $sequence)
            ->get()->result();

        return $check_prev_office;
    }

    public function outgoing_documents()
    {
        $data = [];

        $incoming_documents = [
            'id' => 'DA-CO-ICTS-AO20211025-00001',
            'type' => 'DA-CO-ICTS-AO20211025-00001',
            'document_number' => 'DA-CO-ICTS-AO20211025-00001',
            'Subject'
        ];

        $data = [
            // 'incoming_count' => $this->count_incoming(),
            'incoming_documents' => $incoming_documents
        ];
    }


    // count total number of received documents
    public function count_received()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $year_now = date("Y");
        $month_now = $year_now . '-' . date("m");
        $date_now = date("Y-m-d");

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id);
        $received_total_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $date_now);
        $received_today_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $month_now);
        $received_month_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $year_now);
        $received_year_count = $this->db->get('receipt_control_logs');

        // $this->db->where('type', 'Released')
        //     ->where('transacting_office', $office_code)
        //     ->where('transacting_user_id', $transacting_user_id);
        // $received_total_count = $this->db->get('receipt_control_logs');

        $data = [
            'received_total_count' => $received_total_count->num_rows(),
            'received_today_count' => $received_today_count->num_rows(),
            'received_month_count' => $received_month_count->num_rows(),
            'received_year_count' =>  $received_year_count->num_rows()
        ];

        return $data;
    }

    // count total number of released documents
    public function count_released()
    {

        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $year_now = date("Y");
        $month_now = $year_now . '-' . date("m");
        $date_now = date("Y-m-d");

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id);
        $released_total_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $date_now);
        $released_today_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $month_now);
        $released_month_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            ->where('transacting_user_id', $transacting_user_id)
            ->like('log_date', $year_now);
        $released_year_count = $this->db->get('receipt_control_logs');


        $data = [
            'released_total_count' => $released_total_count->num_rows(),
            'released_today_count' => $released_today_count->num_rows(),
            'released_month_count' => $released_month_count->num_rows(),
            'released_year_count' =>  $released_year_count->num_rows()
        ];

        return $data;
    }

    // count total number of documents
    public function count_my_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');

        $query = $this->db->select("*")->from("document_file")->where("uploaded_by_user_id", $user_id)->get();

        $data = [
            'document_details' => $query->result(),
            'document_count' => $query->num_rows()
        ];
        return $data;
    }

    // count total number of document archived
    public function count_archive()
    {
        return 90;
    }

    public function get_count()
    {
        $data = [
            'received_data' => $this->count_received(),
            'released_data' => $this->count_released(),
            'my_documents_data' => $this->count_my_documents(),
            'my_archives_data' => $this->count_archive()
        ];

        return $data;
    }

    public function received_documents()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db->select("
                            rcl.log_date,
                            rcl.document_number,
                            dr.added_by_user_id as from_user_id,
                            dr.added_by_user_fullname as from_user,
                            CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                            dp.subject,
                            dp.status,
                            dp.origin_type,
                            dt.type as doc_type
                            ")
            ->from("receipt_control_logs as rcl")
            ->where("rcl.type", "Received")
            ->join("document_recipients as dr", "dr.document_number = rcl.document_number")
            ->join("users as u", "u.employee_id = dr.added_by_user_id")
            ->join("lib_office as lo", "lo.OFFICE_CODE = u.office_code", "right")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("doc_type as dt", "dt.type_id = dp.document_type")
            ->where("transacting_office", $office_code)
            ->where("transacting_user_id", $transacting_user_id)
            ->like("transacting_user_id", $transacting_user_id)
            ->like('log_date', $date_now)
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';

        return $query;
    }

    public function released_documents()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db->select("
                            rcl.log_date,
                            rcl.document_number,
                            dr.added_by_user_id as from_user_id,
                            dr.added_by_user_fullname as from_user,
                            CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                            dp.subject,
                            dp.status,
                            dp.origin_type,
                            dt.type as doc_type
                            ")
            ->from("receipt_control_logs as rcl")
            ->where("rcl.type", "Released")
            ->join("document_recipients as dr", "dr.document_number = rcl.document_number", "left")
            ->join("users as u", "u.employee_id = dr.added_by_user_id", "left")
            ->join("lib_office as lo", "lo.OFFICE_CODE = u.office_code", "left")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number", "left")
            ->join("doc_type as dt", "dt.type_id = dp.document_type", "left")
            ->where("rcl.transacting_office", $office_code)
            ->where("rcl.transacting_user_id", $transacting_user_id)
            ->like('rcl.log_date', $date_now)
            ->order_by('rcl.log_date', "desc")
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';

        return $query;
    }


    public function tract_document($document_number)
    {
        $result = '';
        try {
            $get_records = $this->db
                ->select('dp.document_number,
										recipient_office_code,
										subject,dp.remarks,
										INFO_SERVICE,
										INFO_DIVISION,
										rcl.type,
										rcl.transacting_user_fullname,  
										CONCAT( DATE_FORMAT(dr.date_added,"%M %d, %Y"),"\n", TIME_FORMAT(dr.date_added,"%r")) as time')
                ->from('document_profile as dp')
                ->join('document_recipients as dr', 'dp.document_number = dr.document_number')
                ->join('receipt_control_logs as rcl', 'dr.document_number = rcl.document_number', 'left')
                ->join('lib_office as lo', 'lo.office_code = dr.recipient_office_code')
                ->where('dp.document_number', $document_number)
                ->order_by("dr.sequence", "desc")
                ->get()->result();
            if ($get_records) {
                $result = ["Message" => "true", "history" => $get_records];
            }
        } catch (\Exception $e) {
            $result = ["Message" => "false", "error" => $e->getMessage()];
        }
        return $result;
    }

    public function get_history($document_number)
    {
        $result = '';
        try {
            $document_details = $this->db->select('
                            dp.subject,
                            dt.type,
                            dp.office_code,
                            dp.created_by_user_fullname, 
               INFO_SERVICE, INFO_DIVISION')
                ->from('document_profile as dp')
                ->join('lib_office as lo', 'lo.office_code = dp.office_code')
                ->join('doc_type as dt', 'dt.type_id = dp.document_type')
                ->where('dp.document_number', $document_number)
                ->get()->result();

            $get_records = $this->db
                ->select('dp.document_number,
                                            recipient_office_code,
                                            subject,dp.remarks,
                                            INFO_SERVICE,
                                            INFO_DIVISION,
                                            rcl.type,
                                            rcl.action,
                                            rcl.transacting_user_fullname,  
                                            CONCAT( DATE_FORMAT(rcl.log_date,"%M %d, %Y"),"\n", TIME_FORMAT(rcl.log_date,"%r")) as time')
                ->from('document_profile as dp')
                ->join('document_recipients as dr', 'dp.document_number = dr.document_number')
                ->join('receipt_control_logs as rcl', 'dr.document_number = rcl.document_number', 'left')
                ->join('lib_office as lo', 'lo.office_code = dr.recipient_office_code')
                ->where('dp.document_number', $document_number)
                ->order_by("rcl.log_date", "desc")
                ->get()->result();
            if ($get_records) {
                $result = ["Message" => "true", "document_details" => $document_details, "history" => $get_records];
            }
        } catch (\Exception $e) {
            $result = ["Message" => "false", "error" => $e->getMessage()];
        }
        return $result;
    }
}
