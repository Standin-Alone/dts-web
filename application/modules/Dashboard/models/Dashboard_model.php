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
                                dp.for,
                                dp.subject,
                                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                                dp.date_created
        ")
            ->from("document_profile as dp")
            ->where("recipient_office_code", $office_code)
            ->like('date_created', $date_now)
            ->where("dr.received", "1")
            ->where("dp.status", "Verified")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        return $get_assign_doc;
    }

    public function get_latest_incoming()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("
                                dp.document_number,
                                dp.subject,
                                dp.status,
                                dp.for,
                                dp.type,
                                dt.type as document_type,
                                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                                dp.date_created as date,
                                dr.received
        ")
            ->from("document_profile as dp")
            ->where("recipient_office_code", $office_code)
            ->like('dp.date_created', $date_now)
            // ->where("dr.active", "1")
            ->where("dp.status", "Verified")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
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
        // return $get_assign_doc;

        $get_assign_doc = $this->db->select("
                            document_number,
                            date_added
                            ")
            ->from("document_recipients")
            ->where("recipient_office_code", $office_code)
            // ->where("owner", "N")
            ->where("date_added !=", $date_now)
            ->order_by("date_added", "desc")
            ->group_by("document_number")
            ->get()
            ->result();

        "<pre>";
        // print_r($get_assign_doc);
        "<pre>";
        $document_data = [];
        foreach ($get_assign_doc as $data) {
            $date = date("Y-m-d", strtotime($data->date_added));
            $split_date = (explode("-", $date));
            $date = $split_date[0] . "-" . $split_date[1] . "-" . $split_date[2];
            $document_number = $data->document_number;
            $document_details = $this->db->select("
                        dp.status,
                        dp.for,
                        dp.document_number,
                        dp.subject,
                        dt.type as document_type,
                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                        ")
                ->from("document_profile as dp")
                ->join("doc_type as dt", "dp.document_type = dt.type_id")
                ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
                ->where("document_number", $document_number)
                ->where("(status='Verified' OR status='Archived')")
                ->get()->result();
            $document_data[] = [
                "date" => $date,
                "details" => $document_details
            ];

            // "<pre>";
            // print_r($document_data);
            // "<pre>";
        }
        return $document_data;
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

    public function get_latest_outgoing()
    {
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_outgoing = $this->db->select("
        dp.document_number,
        dp.subject,
        dp.for,
        dp.status,
        dt.type as document_type,
        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
        dp.date_created as date
        ")
            ->from("document_profile as dp")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("dp.office_code", $office_code)
            ->like("dp.date_created", $date_now)
            ->where("status", "Verified")
            ->order_by("dp.date_created", "desc")
            ->get()->result();

        // print_r($get_outgoing);

        return $get_outgoing;
    }

    public function get_outgoing_documents()
    {
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_outgoing = $this->db->select("
        dp.document_number,
        dp.subject,
        dp.for,
        dt.type as document_type,
        dp.status,
        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
        dp.date_created as date
        ")
            ->from("document_profile as dp")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("dp.office_code", $office_code)
            // ->where("dp.date_created !=", $date_now)
            ->where("(status='Verified' OR status='Archived')")
            ->group_by("dp.document_number")
            ->order_by("dp.date_created", "desc")
            ->get()->result();

        // $dates = [];
        // $date = "";
        // foreach ($get_outgoing as $data) {
        //     if ($date != date("Y-m-d", strtotime($data->date_created))) {
        //         $dates[] = $date;
        //         $date = date("Y-m-d", strtotime($data->date_created));
        //     }
        // }

        // $outgoing_data = [
        //     'date' => $dates,
        //     'details' => $get_outgoing
        // ];

        // "<pre>";
        // print_r($outgoing_data);
        // "<pre>";

        return $get_outgoing;
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
            ->order_by("rcl.log_date", "desc")
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';
        return $query;
    }

    // public function get_by_user()
    // {
    //     $draw   = $this->input->post('draw', true);
    //     $start  = $this->input->post('start', true);
    //     $length = $this->input->post('length', true);
    //     $search = $this->input->post('search', true);
    //     $user_id = $this->session->userdata('user_id', true);


    //     $this->db->select('*')
    //         ->from('vw_document_profile_info')
    //         ->where('office_code', $this->session->userdata('office'));

    //     if ($search != '') {
    //         $this->db->group_start()
    //             ->like('document_number', $search['value'])
    //             ->or_like('date', $search['value'])
    //             ->or_like('sender_name', $search['value'])
    //             ->or_like('sender_address', $search['value'])
    //             ->or_like('subject', $search['value'])
    //             ->or_like('remarks', $search['value'])
    //             ->or_like('type', $search['value'])
    //             ->group_end();
    //     }

    //     // $this->db->group_by('pras_num')
    //     $this->db->order_by('date_created', 'DESC')
    //         ->limit($length, $start);

    //     $query = $this->db->get();

    //     //echo $this->db->last_query();

    //     $data = array(
    //         'draw'               => $draw,
    //         'recordsTotal'       => $this->get_total_records($search['value'], $user_id),
    //         'recordsFiltered' => $this->get_total_records($search['value'], $user_id),
    //         'data'               => $query->result()
    //     );

    //     return $data;
    // }


    // public function received_doc_table(){
    //     $this->db->select('*')
    //     ->from('vw_document_profile_info')
    //     ->where('office_code', $this->session->userdata('office'));

    //     if($search != ''){
    //         $this->db->group_start()
    //                     ->like('document_number', $search)
    //                     ->or_like('date', $search)
    //                     ->or_like('sender_name',$search)
    //                     ->or_like('sender_address', $search)
    //                     ->or_like('subject',$search)
    //                     ->or_like('remarks', $search)
    //                     ->or_like('type',$search)
    //                     ->group_end();
    //         }

    //     // $this->db->group_by('document_number')
    //     $this->db->order_by('date_created', 'DESC');

    //     $query = $this->db->get();

    //     return $query->num_rows();
    // }


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
            ->group_by('rcl.document_number')
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
        $document_number = trim($document_number);
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

                $get_binded_documents = $this->db
                    ->select("
                    db.binded_doc_number,
                    db.date_created,
                    dp.subject,
                    dt.type,
                    dt.code,
                    CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as origin_office,
                    ")
                    ->from("document_bind as db")
                    ->join("document_profile as dp", "db.binded_doc_number = dp.document_number")
                    ->join('lib_office as lo',  ' dp.office_code = lo.OFFICE_CODE')
                    ->join('doc_type as dt', 'dt.type_id = dp.document_type')
                    ->where("orig_doc_number", $document_number)
                    ->get()->result();
                // $get_binded_documents = $this->db->select("*")->from("document_bind")->where("doc")

                if ($get_records) {
                    $result = ["Message" => "true", "document_details" => $document_details, "history" => $get_records, "binded_documents" => $get_binded_documents];
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
                        dp.status,
                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin,
                        rcl.status,
                        max(log_date) log_date
                         ")
            ->from("receipt_control_logs as rcl")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->where("rcl.type", "Received")
            ->order_by("rcl.log_date", "desc")
            ->group_by('dp.document_number')
            ->get()->result();
         /*echo '<pre>'; 
         echo $this->db->last_query(); 
         echo '</pre>';*/
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
                        rcl.log_date
                         ")
            ->from("receipt_control_logs as rcl")
            ->join("document_profile as dp", "dp.document_number = rcl.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->where("rcl.type", "Released")
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

    public function get_document_type_data_incoming()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $doc_type_data = $this
            ->db
            ->select("
            type,
            count(type) as type_count,
            type_desc
            ")
            ->from("
            ( 
                SELECT 
                dp.`type`, 
                dt.`type` as type_desc 
                FROM document_profile as dp 
                JOIN document_recipients as dr 
                ON dp.`document_number` = dr.`document_number` 
                JOIN doc_type as dt ON dp.`document_type` = dt.`type_id` 
                WHERE dr.`recipient_office_code` = '$office_code' 
                GROUP BY dp.`document_number` 
                )  as document
            ")
            ->group_by("document.type")
            ->order_by("type_count", "desc")
            ->get()->result();


        return $doc_type_data;
    }

    public function get_document_type_data_outgoing()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $doc_type_data = $this
            ->db
            ->select("
            type,
            count(type) as type_count,
            type_desc
            ")
            ->from("
            ( 
                SELECT 
                dp.`type`, 
                dt.`type` as type_desc 
                FROM document_profile as dp 
                JOIN doc_type as dt ON dp.`document_type` = dt.`type_id` 
                WHERE dp.`office_code` = '$office_code'
                AND (dp.`status` = 'Verified' || dp.`status` = 'Archived') 
                )  as document
            ")
            ->group_by("document.type")
            ->order_by("type_count", "desc")
            ->get()->result();


        return $doc_type_data;
    }
    public function get_origin_type_data()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db
            ->select("
                origin_type,
                COUNT(origin_type) AS origin_type_count
            ")
            ->from("
            (SELECT 
                `rcl`.`document_number`, 
                `dt`.`type` as `document_type`, 
                `dp`.`origin_type`, `dp`.`subject`, 
                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin, 
                `rcl`.`status`, `rcl`.`log_date` 
                FROM `receipt_control_logs` as `rcl` 
                JOIN `document_profile` as `dp` ON `dp`.`document_number` = `rcl`.`document_number` 
                JOIN `lib_office` as `lo` ON `dp`.`office_code` = `lo`.`OFFICE_CODE` 
                JOIN `doc_type` as `dt` ON `dp`.`document_type` = `dt`.`type_id` 
                WHERE `transacting_office` = '$office_code' 
                AND `origin_type` IS NOT NULL
                AND `rcl`.`type` = 'Received' 
                GROUP BY `rcl`.`document_number`)
                AS
                docuement
            ")
            ->group_by('origin_type')
            ->order_by('origin_type_count', "desc")
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';
        return $query;
    }

    public function get_origin_type_data_release()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db
            ->select("
                origin_type,
                COUNT(origin_type) AS origin_type_count
            ")
            ->from("
            (SELECT 
                `rcl`.`document_number`, 
                `dt`.`type` as `document_type`, 
                `dp`.`origin_type`, `dp`.`subject`, 
                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as document_origin, 
                `rcl`.`status`, `rcl`.`log_date` 
                FROM `receipt_control_logs` as `rcl` 
                JOIN `document_profile` as `dp` ON `dp`.`document_number` = `rcl`.`document_number` 
                JOIN `lib_office` as `lo` ON `dp`.`office_code` = `lo`.`OFFICE_CODE` 
                JOIN `doc_type` as `dt` ON `dp`.`document_type` = `dt`.`type_id` 
                WHERE `transacting_office` = '$office_code' 
                AND `origin_type` IS NOT NULL
                AND `rcl`.`type` = 'Released' 
                GROUP BY `rcl`.`document_number`)
                AS
                docuement
            ")
            ->group_by('origin_type')
            ->order_by('origin_type_count', "desc")
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';
        return $query;
    }

    function array_orderby()
        {
            $args = func_get_args();
            $data = array_shift($args);
            foreach ($args as $n => $field) {
                if (is_string($field)) {
                    $tmp = array();
                    foreach ($data as $key => $row)
                        $tmp[$key] = $row[$field];
                    $args[$n] = $tmp;
                }
            }
            $args[] = &$data;
            call_user_func_array('array_multisort', $args);
            return array_pop($args);
        }

    public function get_over_due_incoming()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $query = $this->db->select("
                        rcl.document_number,
                        dt.type as doc_type,
                        dp.origin_type,
                        dp.for,
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
            ->where("rcl.status", "1")
            ->where("dp.status", "Verified")
            // ->like("rcl.log_date", $date_now)
            ->group_by('rcl.document_number')
            ->order_by("rcl.log_date", "desc")
            ->get()->result();

        $overdue = [];
        if ($query) {
            foreach ($query as $row) {
                $last_transaction = $this->db
                    ->select("
                rcl.document_number,
                rcl.type,
                dt.type as doc_type,
                dp.subject,
                dp.for,
                rcl.log_date
                ")
                    ->from("receipt_control_logs as rcl")
                    ->join("document_profile as dp", "rcl.document_number = dp.document_number")
                    ->join("doc_type as dt", "dp.document_type = dt.type_id")
                    ->where("rcl.document_number", $row->document_number)
                    ->where("rcl.status", "1")
                    ->where("dp.status", "Verified")
                    ->where("rcl.transacting_office", $office_code)
                    ->limit(1)
                    ->order_by("rcl.log_date", "desc")
                    ->get()
                    ->row();
                if ($last_transaction) {
                    if ($last_transaction->type == 'Received') {
                        $log_date = $last_transaction->log_date;

                        $datetime1 = strtotime($log_date);
                        $datetime2 = strtotime(date("Y-m-d h:i:s"));
                        $secs = $datetime2 - $datetime1; // == <seconds between the two times>
                        $days = $secs / 86400;

                        $from_office = $this->db
                            ->select("
                        CONCAT(lo.INFO_SERVICE, ' - ', lo.INFO_DIVISION) as from_office,
                        ")
                            ->from("document_recipients as dr")
                            ->join("lib_office as lo", "dr.added_by_user_office = lo.OFFICE_CODE")
                            ->where("document_number", $last_transaction->document_number)
                            ->where("recipient_office_code", $office_code)
                            ->limit(1)
                            ->get()->row();

                        if ($days > 3) {
                            $overdue[] = [
                                'interval' => $days,
                                'details' => [
                                    'document_number' =>   $row->document_number,
                                    'doc_type' => $row->doc_type,
                                    'subject' => $row->subject,
                                    'for' => $row->for,
                                    'from_office' => $row->from_office,
                                    'log_date' => $row->log_date,
                                ]
                            ];
                        }
                    }
                }
            }
        }

        

        $sorted = $this->array_orderby($overdue, 'interval', SORT_ASC);

        return $sorted;
    }


    public function get_over_due_outgoing()
    {
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        //get all profiled documents
        $query = $this->db->select("
                        dp.document_number,
                        dt.type as doc_type,
                        dp.origin_type,
                        dp.subject,
                        dp.for,
                        CONCAT(lo.INFO_SERVICE, ' - ', lo.INFO_DIVISION) as from_office,
                        dp.status,
                        dp.date_created
                         ")
            ->from("document_profile as dp")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("dp.office_code", $office_code)
            ->where("dp.status", "Verified")
            // ->like("rcl.log_date", $date_now)
            ->order_by("dp.date_created", "desc")
            ->get()->result();
      
    //   print_r($query);
        $overdue = [];
        if ($query) {
            foreach ($query as $row) {
                //get the last transaction
                $last_transaction = $this->db
                    ->select("
                rcl.document_number,
                CONCAT(lo.INFO_SERVICE, ' - ', lo.INFO_DIVISION) as current_office,
                rcl.type,
                dt.type as doc_type,
                dp.subject,
                dp.for,
                rcl.log_date
                ")
                    ->from("receipt_control_logs as rcl")
                    ->join("document_profile as dp", "rcl.document_number = dp.document_number")
                    ->join("doc_type as dt", "dp.document_type = dt.type_id")
                    ->join("lib_office as lo", "rcl.transacting_office = lo.OFFICE_CODE")
                    ->where("rcl.document_number", $row->document_number)
                    ->where("rcl.status", "1")
                    ->where("dp.status", "Verified")
                    // ->where("rcl.transacting_office", $office_code)
                    ->limit(1)
                    ->order_by("rcl.log_date", "desc")
                    ->get()
                    ->row();

              
                if ($last_transaction) {
                    if ($last_transaction->type == 'Received') {
                        $log_date = $last_transaction->log_date;

                        $datetime1 = strtotime($log_date);
                        $datetime2 = strtotime(date("Y-m-d h:i:s"));
                        $secs = $datetime2 - $datetime1; // == <seconds between the two times>
                        $days = $secs / 86400;

                        $from_office = $this->db
                            ->select("
                        CONCAT(lo.INFO_SERVICE, ' - ', lo.INFO_DIVISION) as from_office,
                        ")
                            ->from("document_recipients as dr")
                            ->join("lib_office as lo", "dr.added_by_user_office = lo.OFFICE_CODE")
                            ->where("document_number", $last_transaction->document_number)
                            ->where("recipient_office_code", $office_code)
                            ->limit(1)
                            ->get()->row();

                        if ($days > 3) {
                            $overdue[] = [
                                'interval' => $days,
                                'details' => [
                                    'document_number' =>   $row->document_number,
                                    'doc_type' => $row->doc_type,
                                    'for' => $row->for,
                                    'subject' => $row->subject,
                                    'current_office' => $last_transaction->current_office,
                                    'log_date' => $last_transaction->log_date,
                                ]
                            ];
                        }
                    }
                }
            }
        }
        // print_r($overdue);
        
        $sorted = $this->array_orderby($overdue, 'interval', SORT_ASC);

        return $sorted;
    }

    public function count_overdue(){
        $incoming = count($this->get_over_due_incoming());
        $outgoing = count($this->get_over_due_outgoing());


        return [
            'count_incoming' => $incoming,
            'count_outgoing' => $outgoing,
            'count_total' => $incoming + $outgoing
        ];
        
    }

    public function get_dissemination_documents()
    {
        $query = $this->db
            ->select("
            a.document_number,UPPER(a.subject) 
            AS subject,
            a.date_created,
            b.type_id AS doc_type_id,
            b.type AS doc_type,
            b.code AS doc_code,
            c.OFFICE_CODE AS office_code,
            c.INFO_SERVICE AS origin_service,
            c.ORIG_SHORTNAME AS origin_orig_shortname,
            c.INFO_DIVISION AS origin_division
        ")
            ->from("document_profile as a")
            ->join("doc_type as b", "a.document_type = b.type_id", "left")
            ->join("lib_office as c", "a.office_code = c.OFFICE_CODE", "left")
            ->where("a.for", 3);

        return $query->get()->result();
    }
    public function get_recent_incoming()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $first_date = date("Y-m-d", strtotime($date_now . '-2 days'));
        $second_date = date("Y-m-d", strtotime($date_now . '-1 day'));

        $get_assign_doc = $this->db->select("
                                dp.document_number,
                                dp.subject,
                                dp.for,
                                dp.status,
                                dt.type as document_type,
                                CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as from_office,
                                dp.date_created as date,
                                dr.received
        ")
            ->from("document_profile as dp")
            ->where("recipient_office_code", $office_code)
            ->where("dp.date >=", $first_date)
            ->where("dp.date <=", $second_date)
            // ->like('dp.date_created', $date_now)
            // ->where("dr.active", "1")
            ->where("dp.status", "Verified")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        // print_r($get_assign_doc);

        return $get_assign_doc;
    }

    public function get_recent_outgoing()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $first_date = date("Y-m-d", strtotime($date_now . '-2 days'));
        $second_date = date("Y-m-d", strtotime($date_now . '-1 day'));

        $get_assign_doc = $this->db->select("
                                dp.document_number,
                                dp.subject,
                                dp.for,
                                dp.status,
                                dt.type as document_type,
                                dp.date_created as date,
                                dr.received
        ")
            ->from("document_profile as dp")
            ->where("dp.office_code", $office_code)
            ->where("dp.date >=", $first_date)
            ->where("dp.date <=", $second_date)
            // ->like('dp.date_created', $date_now)
            // ->where("dr.active", "1")
            // ->where("dp.status", "Verified")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        // print_r($get_assign_doc);

        return $get_assign_doc;
    }

    public function get_documents(){
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $draw   = $this->input->post('draw', true);
        $start  = $this->input->post('start', true);
        $length = $this->input->post('length', true);
        $search = $this->input->post('search', true);
        $type   = $this->input->post('type', true);

        $date_start    = $this->input->post('date_start', true);
        $date_end      = $this->input->post('date_end', true);
        $status        = $this->input->post('status', true);
        $origin_type   = $this->input->post('origin_type', true);
        $document_type = $this->input->post('document_type', true);

        $this->db->select('*')
                 ->from('vw_latest_rnc')
                # ->where("action != 'Profiled'")
                 ->where('transacting_office', $office_code)
                 ->where('type', $type);

        if($date_start != ''){
            $this->db->where("DATE(log_date) BETWEEN '$date_start' AND '$date_end'");
        }

        if($status != ''){
            $this->db->where('status', $status);
        }

        if($origin_type != ''){
            $this->db->where('origin_type', $origin_type);
        }

        if($document_type != ''){
            $this->db->where('document_type', $document_type);
        }

        if($search['value'] != ''){
            $this->db->group_start()
                     ->like('document_number', $search['value'])
                     ->or_like('document_type', $search['value'])
                     ->or_like('origin_type', $search['value'])
                     ->or_like('subject', $search['value'])
                     ->or_like('document_origin', $search['value'])
                     ->group_end();
        }

        $this->db->order_by('log_date', 'DESC')
                 ->limit($length, $start);

        $query = $this->db->get();

        #echo $this->db->last_query();

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $this->get_total_documents($search['value'], $type, $date_start, $date_end, $status, $origin_type, $document_type),
            'recordsFiltered' => $this->get_total_documents($search['value'], $type, $date_start, $date_end, $status, $origin_type, $document_type),
            'data'            => $query->result()
        );

        return $data;
    }

    public function get_total_documents($search, $type,  $date_start, $date_end, $status, $origin_type, $document_type){
        $transacting_user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $this->db->select('*')
                 ->from('vw_latest_rnc')
                 ->where('transacting_office', $office_code)
                 ->where('type', $type);

        if($date_start != ''){
            $this->db->where("DATE(log_date) BETWEEN '$date_start' AND '$date_end'");
        }

        if($status != ''){
            $this->db->where('status', $status);
        }

        if($origin_type != ''){
            $this->db->where('origin_type', $origin_type);
        }

        if($document_type != ''){
            $this->db->where('document_type', $document_type);
        }

        if($search != ''){
            $this->db->group_start()
                     ->like('document_number', $search)
                     ->or_like('document_type', $search)
                     ->or_like('origin_type', $search)
                     ->or_like('subject', $search)
                     ->or_like('document_origin', $search)
                     ->group_end();
        }

        $query = $this->db->get();

        return $query->num_rows();
    }
}
