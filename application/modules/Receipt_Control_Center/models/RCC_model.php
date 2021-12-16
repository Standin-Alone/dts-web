<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';
// require 'application/config/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class RCC_model extends CI_Model
{

    public function generate_uuid()
    {
        return Uuid::uuid4();
    }
    public function insert_logs($data)
    {
        // "<pre>";
        // print_r($data);
        // "<pre>";

        $insert =  $this->db->insert('receipt_control_logs', [
            'type' => $data['type'],
            'document_number' => $data['document_number'],
            'office_code' => $data['office_code'],
            'action' => $data['action'],
            'remarks' => $data['remarks'],
            'file' => $data['file'],
            'attachment' => $data['attachment'],
            'transacting_user_id' => $data['transacting_user_id'],
            'transacting_user_fullname' => $data['transacting_fullname'],
            'transacting_office' => $data['office_code']
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

        $uuid = $this->generate_uuid();

        $document_number = $this->input->post('document_number', TRUE);
        $office_code = $this->session->userdata('office');
        $user_id = $this->session->userdata('user_id');
        $fullname = $this->session->userdata('fullname');


        try {
            //check if recipient of document
            $check_if_recipient = $this->db
                ->select("dp.office_code")
                ->from("document_recipients as dr")
                ->join("document_profile as dp", "dp.document_number = dr.document_number")
                ->where("dr.document_number", "$document_number")
                ->where("recipient_office_code", $office_code)
                ->order_by("sequence", "desc")
                ->limit(1)
                ->get();

            if ($check_if_recipient->result()) {
                //if has result->check if released

                //get origin office
                $origin_office = isset($check_if_recipient->office_code) ? $check_if_recipient->office_code : "";

                $check_latest_transaction = $this->db->select("type")
                    ->from("receipt_control_logs")
                    ->where("document_number", $document_number)
                    ->where("office_code", $origin_office)
                    ->order_by("log_date", "desc")
                    ->limit(1)->get()->result();

                //if prev office is released
                //prompt not yet released
                if (isset($check_latest_transaction->type)) {
                    if ($check_latest_transaction->type == "Recieved") {
                        //release in previous
                        $release_data = [
                            'type' => 'Released',
                            'document_number' => $document_number,
                            'office_code' => $office_code,
                            'action' => 'No Action',
                            'remarks' => '',
                            'file' => '',
                            'attachment' => '',
                            'transacting_user_id' => $user_id,
                            'transacting_fullname' => $fullname,
                            'transacting_office' => $fullname,
                        ];
                        //after released, received
                        $insert_data = $this->insert_logs($release_data);
                        if ($insert_data) {
                            $received_data = [
                                'type' => 'Received',
                                'document_number' => $document_number,
                                'office_code' => $office_code,
                                'action' => 'Received',
                                'remarks' => '',
                                'file' => '',
                                'attachment' => '',
                                'transacting_user_id' => $user_id,
                                'transacting_fullname' => $fullname,
                            ];
                            $insert_data = $this->insert_logs($received_data);
                            //if status = success and error = true -> 
                            $result = ["status" => $insert_data, "error" => "true", "message" => "Document has been received successfully"];
                        }
                    }

                    if ($check_latest_transaction->type == "Released") {
                        $received_data = [
                            'type' => 'Released',
                            'document_number' => $document_number,
                            'office_code' => $office_code,
                            'action' => 'No Action',
                            'remarks' => '',
                            'file' => '',
                            'attachment' => '',
                            'transacting_user_id' => $user_id,
                            'transacting_fullname' => $fullname,
                        ];
                        $insert_data = $this->insert_logs($received_data);

                        if ($insert_data) {
                            $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];
                        }
                    }
                } else {
                    //No data
                    $received_data = [
                        'type' => 'Received',
                        'document_number' => $document_number,
                        'office_code' => $office_code,
                        'action' => 'Received',
                        'remarks' => '',
                        'file' => '',
                        'attachment' => '',
                        'transacting_user_id' => $user_id,
                        'transacting_fullname' => $fullname,
                    ];
                    $insert_data = $this->insert_logs($received_data);

                    if ($insert_data) {
                        $result = ["status" => $insert_data, "error" => "true", "message" => "No transactions found"];
                    }
                }
            } else {
                $data = [
                    'type' => 'Received',
                    'document_number' => $document_number,
                    'office_code' => $office_code,
                    'action' => 'No Action',
                    'remarks' => '',
                    'file' => '',
                    'attachment' => '',
                    'transacting_user_id' => $user_id,
                    'transacting_fullname' => $fullname,
                ];
                $insert_data = $this->insert_logs($data);

                $result = ["status" => $insert_data, "error" => "true", "message" => "Unauthorized Recipient"];
            }

            // $check_document = $this->check_document($document_number, $office_code);
        } catch (\Exception $e) {
            $result = ["status" => "fail", "error" => $e->getMessage()];
        }

        return $result;
    }




    // Receive Document Screen
    public function release_document()
    {

        $result = '';
        $uuid = $this->generate_uuid();

        $document_number = $this->input->post('document_number', TRUE);
        $office_code = $this->session->userdata('office_code');
        $user_id = $this->session->userdata('user_id');
        $fullname = $this->session->userdata('fullname');

        $data = [];
        $insert_data = $this->insert_logs($data);

        $data = [
            'type' => 'Received',
            'document_number' => $document_number,
            'office_code' => $office_code,
            'action' => 'No Action',
            'remarks' => '',
            'file' => '',
            'attachment' => '',
            'transacting_user_id' => $user_id,
            'transacting_fullname' => $fullname,
        ];
        $insert_data = $this->insert_logs($data);

        $result = ["status" => $insert_data, "error" => "true", "message" => "Unauthorized Recipient"];

        try {
            //code...
        } catch (\Exception $e) {
            $result = ["status" => "fail", "error" => $e->getMessage()];
        }


        // try {

        //     $request = json_decode(file_get_contents('php://input'));

        //     $document_number = $request->document_number;
        //     $office_code = $request->office_code;
        //     $recipients_office_code = $request->recipients_office_code;
        //     $user_id = $request->user_id;
        //     $full_name = $request->full_name;
        //     $info_division = $request->info_division;
        //     $info_service = $request->info_service;


        //     echo $check_if_release = $this->check_if_release($document_number, $office_code);


        //     if ($check_if_release) {

        //         foreach ($check_if_release as $release_doc) {
        //             $this->db->insert('receipt_control_logs', [
        //                 'type' => 'Released',
        //                 'document_number' => $document_number,
        //                 'office_code' => $office_code,
        //                 'action' => 'No Action',
        //                 'remarks' => $release_doc->remarks,
        //                 'file' => '',
        //                 'attachment' => '',
        //                 'transacting_user_id' => $user_id,
        //                 'transacting_user_fullname' => $full_name,
        //                 'transacting_office' => $office_code
        //             ]);
        //         }

        //         $get_last_sequence = $this->db
        //             ->select('sequence')
        //             ->from('document_recipients')
        //             ->where('document_number', $document_number)
        //             ->where('status', '0')
        //             ->where('recipient_office_code', $office_code)
        //             ->order_by('sequence', 'DESC')
        //             ->limit(1)
        //             ->get()->result();

        //         foreach ($recipients_office_code as $value) {
        //             $this->db->insert('document_recipients', [
        //                 'document_number' => $document_number,
        //                 'recipient_office_code' => $value,
        //                 'sequence' => $get_last_sequence[0]->sequence + 1,
        //                 'added_by_user_id' => $user_id,
        //                 'added_by_user_fullname' => $full_name
        //             ]);
        //         }
        //         $result = ["Message" => "true"];
        //     } else {
        //         $result = ["Message" => "false"];
        //     };

        //     return $result;
        // } catch (\Exception $e) {
        //     $result = ["Message" => "false", "error" => $e->getMessage()];
        // }
    }

    // public function check_document($document_number, $office_code)
    // {
    //     $query = $this->db
    //         ->select("*")
    //         ->from("document_recipients")
    //         ->where("document_number", $document_number)
    //         ->where("recipient_office_code", $office_code)
    //         ->get();

    //     $result = $query->result();
    //     $sequence = $result->sequence;

    //     $status = "";

    //     if ($sequence == 1) {
    //         $status = $this->db
    //             ->select("*")
    //             ->from("document_recipients")
    //             ->where("document_number", $document_number)
    //             ->where("active", 1)
    //             ->limit(1)
    //             ->get()->result();
    //     }else{
    //         $status = $this->db
    //         ->select("*")
    //         ->from("document_recipients")
    //         ->where("document_number", $document_number)
    //         ->where("sequence", $sequence-1)
    //         ->where("active", 0)
    //         ->limit(1)
    //         ->get()->result();
    //     }

    //     return $status
    // }








    // check document if the recipient is valid to receive
    public function check_document($document_number, $office_code)
    {
        $result = "";
        $check_if_recipient = $this->db
            ->select("*")
            ->from("document_recipients")
            ->where("document_number", "$document_number")
            ->where("recipient_office_code", $office_code)
            ->limit(1)
            ->get();

        if ($check_if_recipient) {
            $prev_office = $check_if_recipient->result();

            if ($prev_office == 1) {
                $get_records = $this->db
                    ->limit(1)
                    ->select('dp.document_number,recipient_office_code,subject,dp.remarks,INFO_SERVICE,INFO_DIVISION')
                    ->from('document_profile as dp')
                    ->join('document_recipients as dr', 'dp.document_number = dr.document_number')
                    ->join('lib_office as lo', 'lo.office_code = dr.recipient_office_code')
                    ->join('receipt_control_logs as rcl', 'dr.document_number = rcl.document_number')
                    ->where('dp.document_number', $document_number)
                    ->where('dr.recipient_office_code', $office_code)
                    ->where('rcl.type', 'Released')
                    ->order_by("dr.log_date", "desc")
                    ->get()->result();
                if ($get_records) {
                    return $get_records;
                }
            } else {
            }
        } else {
            $result = [
                'status' => 'failed',
                'message' => 'Unauthorized Recipient'
            ];
        }
    }



    // check document if the recipient is valid to release
    public function check_if_release($document_number, $office_code)
    {

        $get_records = $this->db
            ->select('*')
            ->from('document_profile as dp')
            ->join('receipt_control_logs as rcl', 'dp.document_number = rcl.document_number')
            ->join('lib_office as lo', 'lo.office_code = rcl.office_code')
            ->where('dp.document_number', $document_number)
            ->where('lo.office_code', $office_code)
            ->where('rcl.type', 'Received')
            ->get()->result();

        if ($get_records) {
            return $get_records;
        }
    }

    public function recipients()
    {
        $this->db->select('ID_AGENCY, INFO_SERVICE, ORIG_SHORTNAME, SHORTNAME_REGION, OFFICE_CODE, INFO_DIVISION')
            ->from('lib_office')
            ->where('STATUS_CODE', '1');
        $query = $this->db->get();

        // echo '<pre>', print_r($query->result()), '</pre>';

        return $query->result();
    }

    public function get_origin_current_office($document_number)
    {
        // $transacting_user_id = '001399e9-fbb8-479a-ba84-b9b0dadbe894';
        $office_code = '0100110100';

        // $query = $this->db->select("
        // dr.document_number as dp_doc_number,
        // dp.

        // ")
        //     ->from("document_recipients as dr")
        //     ->join("document_profile as dp", "dp.document_number = dr.document_number")
        //     ->join("lib_office as lo", "lo.OFFICE_CODE = dp.office_code")
        //     ->where("document_number", $document_number)
        //     ->where("recipient_office_code", $office_code)
        //     ->get()->result();

        $get_origin_office = $this->db->select("
            dp.office_code,
            CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as office
            ")
            ->from("document_profile as dp")
            ->where('document_number', $document_number)
            ->join("lib_office as lo", "lo.OFFICE_CODE = dp.office_code")
            ->get()->result();
        $get_current_office = $this->db->select("
            dr.recipient_office_code as office_code,
            CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as office
            ")
            ->from("document_recipients as dr")
            ->where('document_number', $document_number)
            ->where("recipient_office_code", $office_code)
            ->join("lib_office as lo", "lo.OFFICE_CODE = dr.recipient_office_code")
            ->get()->result();

        // echo '<pre>', print_r($query), '</pre>';
        // echo '<pre>', print_r($get_current_office), '</pre>';

        $data = [
            'origin_office_code' => $get_origin_office[0]->office_code,
            'origin_office' => $get_origin_office[0]->office,
            'current_office_code' => $get_current_office[0]->office_code,
            'current_office' => $get_current_office[0]->office

        ];

        return $data;
    }
}
