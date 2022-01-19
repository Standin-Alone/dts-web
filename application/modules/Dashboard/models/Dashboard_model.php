<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{


    public function incoming_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("
                                dp.document_number,
                                dp.subject,
                                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                                date_created
        ")
            ->from("document_profile as dp")
            ->where("recipient_office_code", $office_code)
            ->like('date_created', $date_now)
            // ->where("dr.active", "1")
            ->where("dp.status", "Verified")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        return $get_assign_doc;
    }

    public function get_incoming_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("
                                dp.document_number,
                                dp.subject,
                                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,

        ")
            ->from("document_profile as dp")
            ->where("recipient_office_code", $office_code)
            ->where("dr.active", "1")
            ->where("dp.status", "Verified")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        // $get_assign_doc = $this->db->select("
        //                 rcl.document_number,
        //                 dt.type as document_type,
        //                 dp.origin_type,
        //                 dp.subject,
        //                 CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin,
        //                 rcl.status,
        //                 rcl.log_date
        //                  ")
        //     ->from("receipt_control_logs as rcl")
        //     ->join("document_profile as dp", "dp.document_number = rcl.document_number")
        //     ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
        //     ->join("doc_type as dt", "dp.document_type = dt.type_id")
        //     ->where("transacting_office", $office_code)
        //     ->where("rcl.type", "Received")
        //     ->group_by('rcl.document_number')
        //     ->get()->result();

        // "<pre>";
        // print_r($get_assign_doc);
        // "<pre>";

        return $get_assign_doc;
    }

    public function outgoing_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("*")
            ->from("document_profile")
            ->where("office_code", $office_code)
            // ->where("created_by_user_id", $user_id)
            ->where("status", "Verified")
            ->like('date_created', $date_now)
            // ->join("document_profile as dp", "dp.document_number = dr.document_number")
            ->group_by("document_number")
            ->order_by("date_created", "desc")
            ->get()->result();

        // "<pre>";
        // print_r($get_assign_doc);
        // "<pre>";


        return $get_assign_doc;
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
            // ->where('transacting_user_id', $transacting_user_id)
            ->group_by('document_number');
        // ->where('status', "1");

        $received_total_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $date_now);
        $received_today_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $month_now);
        $received_month_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
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
            // ->where('transacting_user_id', $transacting_user_id)
            ->group_by('document_number');
        // ->where('status', "1");
        $released_total_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $date_now);
        $released_today_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $month_now);
        $released_month_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Released')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            // ->where('status', "1")
            ->group_by('document_number')
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
                        rcl.document_number,
                        dt.type as doc_type,
                        dp.origin_type,
                        dp.subject,
                        CONCAT(lo.INFO_SERVICE, ' - ', lo.INFO_DIVISION) as from_office,
                        rcl.status,
                        rcl.log_date
                         ")
            ->from("receipt_control_logs as rcl")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->where("rcl.type", "Received")
            // ->where("rcl.status", "1")
            ->like("rcl.log_date", $date_now)
            ->where("transacting_user_id", $transacting_user_id)
            ->group_by('rcl.document_number')
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
                            rcl.transacting_user_id,
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
            ->group_by('rcl.log_date')
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
            $check_if_exist = $this->db->where("document_number", $document_number)->get("document_profile");
            if ($check_if_exist->num_rows() > 0) {
                //has record
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

                $get_first_log_id = $this->db->select("MIN(log_id) as first_log_id")->from('receipt_control_logs')->where('document_number', $document_number)->get()->row()->first_log_id;

                $get_records = $this->db
                    ->select('dp.document_number,
                                            recipient_office_code,
                                            subject,
                                            rcl.remarks,
                                            INFO_SERVICE,
                                            INFO_DIVISION,
                                            rcl.type,
                                            rcl.action,
                                            rcl.transacting_user_fullname,  
                                            rcl.status,  
                                            CONCAT( DATE_FORMAT(rcl.log_date,"%M %d, %Y"),"\n", TIME_FORMAT(rcl.log_date,"%r")) as time')
                    ->from('document_profile as dp')
                    ->join('document_recipients as dr', 'dp.document_number = dr.document_number')
                    ->join('receipt_control_logs as rcl', 'dr.document_number = rcl.document_number')
                    ->join('lib_office as lo',  ' rcl.transacting_office = lo.office_code')
                    ->where('log_id !=', $get_first_log_id)
                    ->where('dp.document_number', $document_number)
                    // ->group_by('rcl.type, rcl.transacting_user_id, rcl.status')
                    ->group_by('rcl.log_date')
                    ->order_by("rcl.log_date", "desc")
                    ->get()->result();
                if ($get_records) {
                    $result = ["Message" => "true", "document_details" => $document_details, "history" => $get_records];
                }
            } else {
                //no record
                $result = ["Message" => "no records", "document_details" => ""];
            }
        } catch (\Exception $e) {
            $result = ["Message" => "false", "error" => $e->getMessage()];
        }
        return $result;
    }

    public function get_invalid_count()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');

        $this->db->where("transacting_office", $office_code)
            ->where("status", "0")
            ->group_by("document_number");
        $invalid_receive_count = $this->db->where("type", "Received")->get("receipt_control_logs");

        $this->db->where("transacting_office", $office_code)
            ->where("status", "0")
            ->group_by("document_number");
        $invalid_release_count = $this->db->where("type", "Released")->get("receipt_control_logs");
        // "<pre>";
        // print_r($query->num_rows());
        // "<pre>";
        $data = [
            'invalid_receive_count' => $invalid_receive_count->num_rows(),
            'invalid_release_count' => $invalid_release_count->num_rows()
        ];
        return $data;
    }

    public function get_received_documents()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db->select("
                        rcl.document_number,
                        dt.type as document_type,
                        dp.origin_type,
                        dp.subject,
                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin,
                        rcl.status,
                        rcl.log_date
                         ")
            ->from("receipt_control_logs as rcl")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->where("rcl.type", "Received")
            ->group_by('rcl.document_number')
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';

        return $query;
    }

    public function get_released_documents()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db->select("
                        rcl.document_number,
                        dt.type as document_type,
                        dp.origin_type,
                        dp.subject,
                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin,
                        rcl.status,
                        rcl.log_date as date
                         ")
            ->from("receipt_control_logs as rcl")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->where("rcl.type", "Released")
            ->where("transacting_user_id", $transacting_user_id)
            ->group_by('rcl.document_number')
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';

        return $query;
    }

    public function insert_logs($data)
    {
        // "<pre>";
        // print_r($data);
        // "<pre>";

        $insert =  $this->db->insert('receipt_control_logs', [
            'type' => $data['type'],
            'document_number' => isset($data['document_number']) ? $data['document_number'] : "",
            'office_code' => isset($data['office_code']) ? $data['office_code'] : "",
            'action' => isset($data['action']) ? $data['action'] : "",
            'remarks' => isset($data['remarks']) ? $data['remarks'] : "",
            'file' => isset($data['file']) ? $data['file'] : "",
            'attachment' => isset($data['attachment']) ? $data['attachment'] : "",
            'transacting_user_id' => isset($data['transacting_user_id']) ? $data['transacting_user_id'] : "",
            'transacting_user_fullname' => isset($data['transacting_user_fullname']) ? $data['transacting_user_fullname'] : "",
            'transacting_office' => isset($data['transacting_office']) ? $data['transacting_office'] : "",
            'status' => isset($data['status']) ? $data['status'] : ""
        ]);

        if ($insert) {
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function receive_document()
    {
        $result = '';

        $document_number = $this->input->post('document_number', TRUE);
        $office_code = $this->session->userdata('office');
        $user_id = $this->session->userdata('user_id');
        $fullname = $this->session->userdata('fullname');


        try {

            $check_if_exist = $this->db->where("document_number", $document_number)->get("document_profile");

            if ($check_if_exist->num_rows() == 0) {
                //document does not exist
                $result = ["status" => "", "error" => "true", "message" => "No records found"];
            } else {
                $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();

                if ($check_if_verified[0]->status == "Archived") {
                    $result = ["status" => "", "error" => "true", "message" => "Document process is already finished"];
                } else if ($check_if_verified[0]->status == "Draft") {
                    $result = ["status" => "", "error" => "true", "message" => "Document is not yet released"];
                } else {
                    //else exist, if exist, check if receiver is owner
                    $check_if_owner =  $this->db->select("*")
                        ->from("document_profile")
                        ->where("document_number", "$document_number")
                        ->where("office_code", $office_code)
                        ->where("created_by_user_id", $user_id)
                        ->get()
                        ->result();

                    if ($check_if_owner) {
                        //if owner, check if recevied
                        $check_last_transaction = $this->db->select("*")
                            ->from("receipt_control_logs")
                            ->where("document_number", $document_number)
                            ->where("transacting_office", $check_if_owner[0]->office_code)
                            ->where("status", 1)
                            ->order_by("log_date", "desc")
                            ->limit(1)->get()->result();
                        if ($check_last_transaction[0]->type == "Received") {
                            //promp error
                            $result = ["status" => "", "error" => "true", "message" => "Document already received by origin"];
                        } else if ($check_last_transaction[0]->type == "Released") {
                            //received document
                            $received_data = [
                                'type' => 'Received',
                                'document_number' => $document_number,
                                'office_code' => $office_code,
                                'action' => 'Received',
                                'remarks' => '',
                                'file' => '',
                                'attachment' => '',
                                'transacting_user_id' => $user_id,
                                'transacting_user_fullname' => $fullname,
                                'transacting_office' => $office_code,
                                'status' => "1"
                            ];
                            $insert_data = $this->insert_logs($received_data);
                            if ($insert_data) {
                                $data = ['active' => '0'];
                                $this->db->set($data);
                                $this->db->where('document_number', $document_number)->where('recipient_office_code', $office_code);
                                $this->db->update('document_recipients');
                            }
                            $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];
                        }
                    } else {
                        //if not owner, check if valid recipient
                        $check_if_recipient = $this->db
                            ->select("dp.office_code")
                            ->from("document_recipients as dr")
                            ->join("document_profile as dp", "dp.document_number = dr.document_number")
                            ->where("dr.document_number", "$document_number")
                            ->where("recipient_office_code", $office_code)
                            #->order_by("sequence", "desc")
                            ->limit(1)
                            ->get()
                            ->result();

                        if (empty($check_if_recipient)) {
                            //unautorized recipient
                            $result = ["status" => "", "error" => "true", "message" => "Unauthorized Recipient"];
                        } else {
                            //then valid recipient
                            //if valid recipient, check if already received
                            $check_if_received = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("transacting_office", $office_code)
                                ->where("status", 1)
                                ->where("type", "Received")
                                ->order_by("log_date", "desc")
                                ->limit(1)->get()->result();

                            if ($check_if_received) {
                                //promp error
                                $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                            } else {
                                //received document
                                $received_data = [
                                    'type' => 'Received',
                                    'document_number' => $document_number,
                                    'office_code' => $office_code,
                                    'action' => 'Received',
                                    'remarks' => '',
                                    'file' => '',
                                    'attachment' => '',
                                    'transacting_user_id' => $user_id,
                                    'transacting_user_fullname' => $fullname,
                                    'transacting_office' => $office_code,
                                    'status' => "1"
                                ];
                                $insert_data = $this->insert_logs($received_data);
                                if ($insert_data) {
                                    $data = ['active' => '0'];
                                    $this->db->set($data);
                                    $this->db->where('document_number', $document_number)->where('recipient_office_code', $office_code);
                                    $this->db->update('document_recipients');
                                }
                                $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $result = ["status" => "fail", "error" => $e->getMessage()];
        }

        return $result;
    }

    public function check_status($document_number)
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("*")
            ->from("document_profile")
            ->where("document_number", $document_number)
            ->where("office_code", $office_code)
            ->where("status", "Verified")
            ->like('date_created', $date_now)
            // ->join("document_profile as dp", "dp.document_number = dr.document_number")
            ->group_by("date_created")
            ->order_by("date_created", "desc")
            ->get()->result();

        $get_doc_recipient = $this->db->select("*")
            ->from("document_recipients")
            ->where("document_number", $document_number);

        // "<pre>";
        // print_r($get_assign_doc);
        // "<pre>";

        $data = [
            'document_details' => $get_assign_doc,
            'document_recipients' => $get_doc_recipient

        ];
    }

    public function get_document_type()
    {
        $get_document_type = $this->db->select("*")->from("doc_type")->get()->result();

        // "<pre>";
        // print_r($get_document_type);
        // "<pre>";
        return $get_document_type;
    }
}
