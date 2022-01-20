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
            'document_number' => isset($data['document_number']) ? $data['document_number'] : NULL,
            'office_code' => isset($data['office_code']) ? $data['office_code'] : NULL,
            'action' => isset($data['action']) ? $data['action'] : NULL,
            'remarks' => isset($data['remarks']) ? $data['remarks'] : NULL,
            'file' => isset($data['file']) ? $data['file'] : NULL,
            'attachment' => isset($data['attachment']) ? $data['attachment'] : NULL,
            'transacting_user_id' => isset($data['transacting_user_id']) ? $data['transacting_user_id'] : NULL,
            'transacting_user_fullname' => isset($data['transacting_user_fullname']) ? $data['transacting_user_fullname'] : NULL,
            'transacting_office' => isset($data['transacting_office']) ? $data['transacting_office'] : NULL,
            'status' => isset($data['status']) ? $data['status'] : NULL
        ]);

        if ($insert) {
            return 'success';
        } else {
            return 'fail';
        }
    }

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
            ->where("dr.active", "1")
            ->where("dp.status", "Verified")
            ->join("document_recipients as dr", "dp.document_number = dr.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->where("recipient_office_code", $office_code)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        return $get_assign_doc;
    }


    // public function receive_document()
    // {
    //     $result = '';

    //     $uuid = $this->generate_uuid();

    //     $document_number = $this->input->post('document_number', TRUE);
    //     $office_code = $this->session->userdata('office');
    //     $user_id = $this->session->userdata('user_id');
    //     $fullname = $this->session->userdata('fullname');


    //     try {

    //         $check_if_exist = $this->db->where("document_number", $document_number)->get("document_profile");

    //         if ($check_if_exist->num_rows() == 0) {
    //             //document does not exist
    //             $result = ["status" => "", "error" => "true", "message" => "No records found"];
    //         } else {
    //             $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();

    //             if ($check_if_verified[0]->status == "Archived") {
    //                 $result = ["status" => "", "error" => "true", "message" => "Document process is already finished"];
    //             } else if ($check_if_verified[0]->status == "Draft") {
    //                 $result = ["status" => "", "error" => "true", "message" => "Document is not yet released"];
    //             } else {
    //                 //else exist, if exist, check if receiver is owner
    //                 $check_if_owner =  $this->db->select("*")
    //                     ->from("document_profile")
    //                     ->where("document_number", "$document_number")
    //                     ->where("office_code", $office_code)
    //                     ->where("created_by_user_id", $user_id)
    //                     ->get()
    //                     ->result();

    //                 if ($check_if_owner) {
    //                     //if owner, check if recevied
    //                     $check_last_transaction = $this->db->select("*")
    //                         ->from("receipt_control_logs")
    //                         ->where("document_number", $document_number)
    //                         ->where("transacting_office", $check_if_owner[0]->office_code)
    //                         ->where("status", 1)
    //                         ->order_by("log_date", "desc")
    //                         ->limit(1)->get()->result();
    //                     if ($check_last_transaction[0]->type == "Received") {
    //                         //promp error
    //                         $result = ["status" => "", "error" => "true", "message" => "Document already received by origin"];
    //                     } else if ($check_last_transaction[0]->type == "Released") {
    //                         //received document
    //                         $received_data = [
    //                             'type' => 'Received',
    //                             'document_number' => $document_number,
    //                             'office_code' => $office_code,
    //                             'action' => 'Received',
    //                             'remarks' => '',
    //                             'file' => '',
    //                             'attachment' => '',
    //                             'transacting_user_id' => $user_id,
    //                             'transacting_user_fullname' => $fullname,
    //                             'transacting_office' => $office_code,
    //                             'status' => "1"
    //                         ];
    //                         $insert_data = $this->insert_logs($received_data);
    //                         if ($insert_data) {
    //                             $data = ['active' => '0'];
    //                             $this->db->set($data);
    //                             $this->db->where('document_number', $document_number)->where('recipient_office_code', $office_code);
    //                             $this->db->update('document_recipients');
    //                         }
    //                         $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];
    //                     }
    //                 } else {
    //                     //if not owner, check if valid recipient
    //                     $check_if_recipient = $this->db
    //                         ->select("dp.office_code")
    //                         ->from("document_recipients as dr")
    //                         ->join("document_profile as dp", "dp.document_number = dr.document_number")
    //                         ->where("dr.document_number", "$document_number")
    //                         ->where("recipient_office_code", $office_code)
    //                         #->order_by("sequence", "desc")
    //                         ->limit(1)
    //                         ->get()
    //                         ->result();

    //                     if (empty($check_if_recipient)) {
    //                         //unautorized recipient
    //                         $received_data = [
    //                             'type' => 'Received',
    //                             'document_number' => $document_number,
    //                             'office_code' => $office_code,
    //                             'action' => 'Received',
    //                             'remarks' => '',
    //                             'file' => '',
    //                             'attachment' => '',
    //                             'transacting_user_id' => $user_id,
    //                             'transacting_user_fullname' => $fullname,
    //                             'transacting_office' => $office_code,
    //                             'status' => "0"
    //                         ];
    //                         $insert_data = $this->insert_logs($received_data);
    //                         $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];

    //                         $result = ["status" => "", "error" => "true", "message" => "Unauthorized Recipient"];
    //                     } else {
    //                         //then valid recipient
    //                         //if valid recipient, check if already received
    //                         $check_if_received = $this->db->select("*")
    //                             ->from("receipt_control_logs")
    //                             ->where("document_number", $document_number)
    //                             ->where("transacting_office", $office_code)
    //                             ->where("status", 1)
    //                             ->where("type", "Received")
    //                             ->order_by("log_date", "desc")
    //                             ->limit(1)->get()->result();

    //                         if ($check_if_received) {
    //                             //promp error
    //                             $result = ["status" => "", "error" => "true", "message" => "Document already received"];
    //                         } else {
    //                             //received document
    //                             $received_data = [
    //                                 'type' => 'Received',
    //                                 'document_number' => $document_number,
    //                                 'office_code' => $office_code,
    //                                 'action' => 'Received',
    //                                 'remarks' => '',
    //                                 'file' => '',
    //                                 'attachment' => '',
    //                                 'transacting_user_id' => $user_id,
    //                                 'transacting_user_fullname' => $fullname,
    //                                 'transacting_office' => $office_code,
    //                                 'status' => "1"
    //                             ];
    //                             $insert_data = $this->insert_logs($received_data);
    //                             if ($insert_data) {
    //                                 $data = ['active' => '0'];
    //                                 $this->db->set($data);
    //                                 $this->db->where('document_number', $document_number)->where('recipient_office_code', $office_code);
    //                                 $this->db->update('document_recipients');
    //                             }
    //                             $result = ["status" => $insert_data, "error" => "false", "message" => "Document has been received successfully"];
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         $result = ["status" => "fail", "error" => $e->getMessage()];
    //     }

    //     return $result;
    // }

    public function receive_document()
    {
        try {
            $result = '';
            $document_number = $this->input->post('document_number', TRUE);
            $office_code = $this->session->userdata('office');
            $user_id = $this->session->userdata('user_id');
            $fullname = $this->session->userdata('fullname');

            $check_status = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();

            $check_if_exist = $this->db->where("document_number", $document_number)->get("document_profile");
            $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();
            $check_if_owner =  $this->db->select("*")
                ->from("document_profile")
                ->where("document_number", "$document_number")
                ->where("office_code", $office_code)
                ->get()
                ->result();
            //check last transaction if received
            //check if exist
            if ($check_if_exist->num_rows() == 0) {
                //document does not exist
                $result = ["status" => "", "error" => "true", "message" => "No records found"];
            } else {
                //check if verified
                if ($check_if_verified[0]->status == "Archived") {
                    $result = ["status" => "", "error" => "true", "message" => "Document process is already finished"];
                } else if ($check_if_verified[0]->status == "Draft") {
                    $result = ["status" => "", "error" => "true", "message" => "Document is not yet released"];
                } else if ($check_if_verified[0]->status == "" || $check_if_verified[0]->status == null) {
                    $result = ["status" => "", "error" => "true", "message" => "Document is unverified by the system, Please reprofile the document"];
                } else {
                    // if verified check if owner
                    if ($check_if_owner) {
                        $check_if_latest_transaction = $this->db->select("*")
                            ->from("receipt_control_logs")
                            ->where("document_number", $document_number)
                            ->where("status", '1')
                            ->order_by("log_date", "desc")
                            ->limit(1)
                            ->get()->result();

                        if ($check_if_latest_transaction[0]->transacting_office == $office_code) {
                            //
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("transacting_office", $office_code)
                                ->where("status", "1")
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            if ($check_latest_transaction[0]->type == "Received") {
                                //received
                                $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                            } else {
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
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("status", "1")
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            // "<pre>";
                            // print_r($check_if_latest_transaction);
                            // "<pre>";
                            if ($check_latest_transaction[0]->type == "Released") {
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
                            } else {
                                $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                            }
                        }
                    } else {
                        //check if recipient
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
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            if ($check_latest_transaction[0]->type == "Received") {
                                //received
                                $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                            } else {
                                //unautorized recipient
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
                                    'status' => "0"
                                ];
                                $insert_data = $this->insert_logs($received_data);

                                $result = ["status" => "", "error" => "true", "message" => "Unauthorized Recipient"];
                            }
                        } else {
                            //then valid recipient
                            //if valid recipient, check if already received
                            $check_if_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("status", '1')
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            if ($check_if_latest_transaction) {
                                if ($check_if_latest_transaction[0]->transacting_office == $office_code) {
                                    //
                                    $check_latest_transaction = $this->db->select("*")
                                        ->from("receipt_control_logs")
                                        ->where("document_number", $document_number)
                                        ->where("transacting_office", $office_code)
                                        ->where("status", "1")
                                        ->order_by("log_date", "desc")
                                        ->limit(1)
                                        ->get()->result();
                                    if ($check_latest_transaction[0]->type == "Received") {
                                        //received
                                        $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                                    } else {
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
                                    $check_latest_transaction = $this->db->select("*")
                                        ->from("receipt_control_logs")
                                        ->where("document_number", $document_number)
                                        ->where("status", '1')
                                        ->order_by("log_date", "desc")
                                        ->limit(1)
                                        ->get()->result();
                                    // "<pre>";
                                    // print_r($check_if_latest_transaction);
                                    // "<pre>";
                                    if ($check_latest_transaction[0]->type == "Released") {
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
                                    } elseif ($check_latest_transaction[0]->type == "Received") {
                                        $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                                    } else {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                                    }
                                }
                            } else {
                                $check_latest_transaction = $this->db->select("*")
                                    ->from("receipt_control_logs")
                                    ->where("document_number", $document_number)
                                    ->where("status", '1')
                                    ->order_by("log_date", "desc")
                                    ->limit(1)
                                    ->get()->result();
                                // "<pre>";
                                // print_r($check_if_latest_transaction);
                                // "<pre>";
                                if ($check_latest_transaction) {
                                    if ($check_latest_transaction[0]->type == "Released") {
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
                                    } elseif ($check_latest_transaction[0]->type == "Received") {
                                        $result = ["status" => "", "error" => "true", "message" => "Document already received"];
                                    } else {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                                    }
                                } else {
                                    $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                                }
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


    // Receive Document Screen
    public function release_document()
    {
        try {
            $result = '';
            $uuid = $this->generate_uuid();

            $document_number = $this->input->post('document_no', true);
            $office_code = $this->session->userdata('office');
            $user_id = $this->session->userdata('user_id');
            $fullname = $this->session->userdata('fullname');

            $remarks = $this->input->post('remarks', true);
            $action = $this->input->post('action', true);
            $recipients = $this->input->post('recipients', true);

            // "<pre>";
            // print_r($recipients);
            // "<pre>";

            //check if document_number exist
            $check_if_document = $this->db->where("document_number", $document_number)->get("document_profile");
            $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();

            if ($check_if_document->num_rows() == 0) {
                //if document does not exist -> promp error
                $result = ["status" => "", "error" => "true", "message" => "No Records Found"];
            } else {
                //check if verified
                if ($check_if_verified[0]->status == "Archived") {
                    $result = ["status" => "", "error" => "true", "message" => "Document process is already finished"];
                } else if ($check_if_verified[0]->status == "Draft") {
                    $result = ["status" => "", "error" => "true", "message" => "Document is not yet released"];
                } else if ($check_if_verified[0]->status == "" || $check_if_verified[0]->status == null) {
                    $result = ["status" => "", "error" => "true", "message" => "This Document is unverified by the system, please reprofile the document"];
                } else {
                    //if exist, check if owner
                    $check_if_owner =  $this->db->select("*")
                        ->from("document_profile")
                        ->where("document_number", "$document_number")
                        ->where("office_code", $office_code)
                        ->get()
                        ->result();

                    if ($check_if_owner) {
                        $check_if_latest_transaction = $this->db->select("*")
                            ->from("receipt_control_logs")
                            ->where("document_number", $document_number)
                            ->where("status", '1')
                            ->order_by("log_date", "desc")
                            ->limit(1)
                            ->get()->result();

                        if ($check_if_latest_transaction[0]->transacting_office == $office_code) {
                            //
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("transacting_office", $office_code)
                                ->where("status", "1")
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            if ($check_latest_transaction[0]->type == "Released") {
                                //received
                                $result = ["status" => "", "error" => "true", "message" => "Document already released"];
                            } else {
                                //released the document
                                $released_data = [
                                    'type' => 'Released',
                                    'document_number' => $document_number,
                                    'office_code' => $office_code,
                                    'action' => $action,
                                    'remarks' => $remarks,
                                    'file' => '',
                                    'attachment' => '',
                                    'transacting_user_id' => $user_id,
                                    'transacting_user_fullname' => $fullname,
                                    'transacting_office' => $office_code,
                                    'status' => "1"
                                ];
                                $insert_data = $this->insert_logs($released_data);

                                if ($insert_data == "success") {
                                    if (!empty($recipients)) {
                                        foreach ($recipients as $key => $value) {
                                            $this->db->insert('document_recipients', [
                                                'document_number' => $document_number,
                                                'recipient_office_code' => $value,
                                                'sequence' => $key,
                                                'added_by_user_id' => $user_id,
                                                'added_by_user_fullname' => $fullname
                                            ]);
                                        }
                                    }
                                }
                                $result = ["status" => "", "error" => "false", "message" => "Document has been released succesfully"];
                            }
                        } else {
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("status", "1")
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            // "<pre>";
                            // print_r($check_if_latest_transaction);
                            // "<pre>";
                            if ($check_latest_transaction[0]->type == "Received") {
                                $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                            } else {
                                $result = ["status" => "", "error" => "true", "message" => "Document is not yet received by your office"];
                            }
                        }
                    } else {
                        //if not owner, check if recipient
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
                            $check_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("transacting_office", $office_code)
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();
                            if ($check_latest_transaction) {
                                if ($check_latest_transaction[0]->type == "Released") {
                                    //received
                                    $result = ["status" => "", "error" => "true", "message" => "Document already released"];
                                } else {
                                    //Unauthorized recipient
                                    $received_data = [
                                        'type' => 'Released',
                                        'document_number' => $document_number,
                                        'office_code' => $office_code,
                                        'action' => $action,
                                        'remarks' => $remarks,
                                        'file' => '',
                                        'attachment' => '',
                                        'transacting_user_id' => $user_id,
                                        'transacting_user_fullname' => $fullname,
                                        'transacting_office' => $office_code,
                                        'status' => "0"
                                    ];
                                    $insert_data = $this->insert_logs($received_data);
                                    $result = ["status" => "", "error" => "true", "message" => "Unauthorized Recipient"];
                                }
                            } else {
                                //Unauthorized recipient
                                $received_data = [
                                    'type' => 'Released',
                                    'document_number' => $document_number,
                                    'office_code' => $office_code,
                                    'action' => $action,
                                    'remarks' => $remarks,
                                    'file' => '',
                                    'attachment' => '',
                                    'transacting_user_id' => $user_id,
                                    'transacting_user_fullname' => $fullname,
                                    'transacting_office' => $office_code,
                                    'status' => "0"
                                ];
                                $insert_data = $this->insert_logs($received_data);
                                $result = ["status" => "", "error" => "true", "message" => "Unauthorized Recipient"];
                            }
                        } else {
                            // else if recipient, check if released
                            $check_if_latest_transaction = $this->db->select("*")
                                ->from("receipt_control_logs")
                                ->where("document_number", $document_number)
                                ->where("status", '1')
                                ->order_by("log_date", "desc")
                                ->limit(1)
                                ->get()->result();

                            if ($check_if_latest_transaction) {


                                if ($check_if_latest_transaction[0]->transacting_office == $office_code) {
                                    //
                                    $check_latest_transaction = $this->db->select("*")
                                        ->from("receipt_control_logs")
                                        ->where("document_number", $document_number)
                                        ->where("transacting_office", $office_code)
                                        ->where("status", '1')
                                        ->order_by("log_date", "desc")
                                        ->limit(1)
                                        ->get()->result();
                                    if ($check_latest_transaction[0]->type == "Released") {
                                        //received
                                        $result = ["status" => "", "error" => "true", "message" => "Document already released"];
                                    } else {
                                        //released the document
                                        $released_data = [
                                            'type' => 'Released',
                                            'document_number' => $document_number,
                                            'office_code' => $office_code,
                                            'action' => $action,
                                            'remarks' => $remarks,
                                            'file' => '',
                                            'attachment' => '',
                                            'transacting_user_id' => $user_id,
                                            'transacting_user_fullname' => $fullname,
                                            'transacting_office' => $office_code,
                                            'status' => "1"
                                        ];
                                        $insert_data = $this->insert_logs($released_data);

                                        if ($insert_data == "success") {
                                            if (!empty($recipients)) {
                                                foreach ($recipients as $key => $value) {
                                                    $this->db->insert('document_recipients', [
                                                        'document_number' => $document_number,
                                                        'recipient_office_code' => $value,
                                                        'sequence' => $key,
                                                        'added_by_user_id' => $user_id,
                                                        'added_by_user_fullname' => $fullname,
                                                        'added_by_user_office' => $office_code
                                                    ]);
                                                }
                                            }
                                        }
                                        $result = ["status" => "", "error" => "false", "message" => "Document has been released succesfully"];
                                    }
                                } else {
                                    $check_latest_transaction = $this->db->select("*")
                                        ->from("receipt_control_logs")
                                        ->where("document_number", $document_number)
                                        ->where("status", '1')
                                        ->order_by("log_date", "desc")
                                        ->limit(1)
                                        ->get()->result();
                                    // "<pre>";
                                    // print_r($check_if_latest_transaction);
                                    // "<pre>";
                                    if ($check_latest_transaction[0]->type == "Received") {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                                    } else {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet received by your office"];
                                    }
                                }
                            } else {
                                $check_latest_transaction = $this->db->select("*")
                                    ->from("receipt_control_logs")
                                    ->where("document_number", $document_number)
                                    ->where("status", '1')
                                    ->order_by("log_date", "desc")
                                    ->limit(1)
                                    ->get()->result();
                                // "<pre>";
                                // print_r($check_if_latest_transaction);
                                // "<pre>";
                                if ($check_latest_transaction) {
                                    if ($check_latest_transaction[0]->type == "Received") {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet released from previous office"];
                                    } else {
                                        $result = ["status" => "", "error" => "true", "message" => "Document is not yet received by your office"];
                                    }
                                } else {
                                    $result = ["status" => "", "error" => "true", "message" => "Document is not yet received by your office"];
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $result = ["status" => "fail", "error" => "true", "message" =>  $e->getMessage()];
        }

        return $result;
    }

    // public function release_document()
    // {
    //     try {
    //         $result = '';
    //         $uuid = $this->generate_uuid();

    //         $document_number = $this->input->post('document_no', true);
    //         $office_code = $this->session->userdata('office');
    //         $user_id = $this->session->userdata('user_id');
    //         $fullname = $this->session->userdata('fullname');

    //         $remarks = $this->input->post('remarks', true);
    //         $action = $this->input->post('action', true);
    //         $recipients = $this->input->post('recipients', true);
    //         //check if document exist
    //         $check_if_document = $this->db->where("document_number", $document_number)->get("document_profile");
    //         $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();
    //         $check_if_owner =  $this->db->select("*")
    //             ->from("document_profile")
    //             ->where("document_number", "$document_number")
    //             ->where("office_code", $office_code)
    //             ->where("created_by_user_id", $user_id)
    //             ->get()
    //             ->result();

    //         $check_if_exist = $this->db->where("document_number", $document_number)->get("document_profile");
    //         $check_if_verified = $this->db->select("*")->from("document_profile")->where("document_number", $document_number)->get()->result();
    //         $check_if_owner =  $this->db->select("*")
    //             ->from("document_profile")
    //             ->where("document_number", "$document_number")
    //             ->where("office_code", $office_code)
    //             ->where("created_by_user_id", $user_id)
    //             ->get()
    //             ->result();
    //         //check last transaction if received
    //         //check if exist
    //         if ($check_if_exist->num_rows() == 0) {
    //             //document does not exist
    //             $result = ["status" => "", "error" => "true", "message" => "No records found"];
    //         } else {
    //             //check if verified
    //             if ($check_if_verified[0]->status == "Archived") {
    //                 $result = ["status" => "", "error" => "true", "message" => "Document process is already finished"];
    //             } else if ($check_if_verified[0]->status == "Draft") {
    //                 $result = ["status" => "", "error" => "true", "message" => "Document is not yet released"];
    //             } else {
    //                 if ($check_if_owner) {
    //                     $check_if_latest_transaction = $this->db->select("*")
    //                         ->from("receipt_control_logs")
    //                         ->where("document_number", $document_number)
    //                         ->order_by("log_date", "desc")
    //                         ->limit(1)
    //                         ->get()->result();

    //                     if ($check_if_latest_transaction[0]->transacting_office == $office_code) {
    //                         //
    //                         $check_latest_transaction = $this->db->select("*")
    //                             ->from("receipt_control_logs")
    //                             ->where("document_number", $document_number)
    //                             ->where("transacting_office", $office_code)
    //                             ->order_by("log_date", "desc")
    //                             ->limit(1)
    //                             ->get()->result();
    //                         if ($check_latest_transaction[0]->type == "Released") {
    //                         }else{


    //                         }
    //                     }
    //                 } else {
    //                     //recipient
    //                 }
    //             }
    //         }

    //         //check if valid
    //         //check if owner
    //         //if owner, check last transaction
    //         //if released, promp error, else release
    //         //check if recipient
    //         //if recipient check last transaction
    //         //if released, promp error, else release
    //     } catch (\Exception $e) {
    //         $result = ["status" => "fail", "error" => "true", "message" =>  $e->getMessage()];
    //     }
    // }



    // public function incoming_documents()
    // {
    // }

    public function received_documents()
    {
        $user_id = $this->session->userdata('user_id');
        $office_code = $this->session->userdata('office');
        $date_now = date("Y-m-d");

        $get_assign_doc = $this->db->select("
                            dp.document_number,
                            CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as office,
                            rcl.action
            ")
            ->from("document_recipients as dr")
            ->where("recipient_office_code", $office_code)
            ->join("document_profile as dp", "dp.document_number = dr.document_number")
            ->join("receipt_control_logs as rcl", "dr.document_number = rcl.document_number")
            ->join("lib_office as lo", "lo.OFFICE_CODE = dp.office_code")
            ->where("dr.active", "0")
            ->like('date_created', $date_now)
            ->group_by("dp.document_number")
            ->order_by("date_added", "desc")
            ->get()->result();

        // "<pre>";
        // print_r($get_assign_doc);
        // "<pre>";

        return $get_assign_doc;
    }

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
            ->group_by('document_number')
            ->where('status', "1");

        $received_total_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $date_now);
        $received_today_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            ->where('status', "1")
            ->group_by('document_number')
            ->like('log_date', $month_now);
        $received_month_count = $this->db->get('receipt_control_logs');

        $this->db->where('type', 'Received')
            ->where('transacting_office', $office_code)
            // ->where('transacting_user_id', $transacting_user_id)
            ->where('status', "1")
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

    public function get_count()
    {
        $data = [
            'received_data' => $this->count_received(),
            'released_data' => $this->count_released(),
            // 'my_documents_data' => $this->count_my_documents(),
            // 'my_archives_data' => $this->count_archive()
        ];

        return $data;
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
            ->join("document_profile as dp", "rcl.document_number = dp.document_number")
            ->join("lib_office as lo", "dp.office_code = lo.OFFICE_CODE")
            ->join("doc_type as dt", "dp.document_type = dt.type_id")
            ->where("transacting_office", $office_code)
            ->order_by("rcl.log_date", "desc")
            ->where("rcl.type", "Received")
            ->group_by('rcl.document_number')
            ->get()->result();
        // echo '<pre>', print_r($query), '</pre>';
        return $query;
    }

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
        $office_code = $this->session->userdata('office');

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
        } catch (\Exception $e) {
            $result = ["Message" => "false", "error" => $e->getMessage()];
        }
        return $result;
    }
}
