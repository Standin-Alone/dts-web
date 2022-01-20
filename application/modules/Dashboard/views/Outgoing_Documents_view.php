<?php
$office_code = $this->session->userdata('office');
?>
<div id="content" class="content">
    <h1 class="page-header mb-3">Outgoing Documents</h1>
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Outgoing Documents</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="row">

            </div>
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <div class="mb-3 text-gray-500">
                                <b>LATEST TRANSACTIONS</b>
                                <!-- <span class="ms-2 "><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels." data-bs-original-title="" title=""></i></span> -->
                                <ul class="list-group my-0 mt-3">
                                    <?php
                                    // print_r($get_latest_outgoing);
                                    if ($get_latest_outgoing) {
                                        foreach ($get_latest_outgoing as $data) {
                                    ?>
                                            <li class="list-group-item ">
                                                <div class="col-md-12 d-flex flex-column justify-content-between mx-0 px-0">
                                                    <div class="mx-0 px-0 d-flex flex-row col-md-12">
                                                        <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                            <h5><?php echo $data->document_number ?></h5>
                                                            <span><label class="my-0 text-secondary">Document Type: </label> <?php echo $data->document_type ?></span>
                                                            <span><label class="my-0 text-secondary">Subject: </label> <?php echo $data->subject ?></span>
                                                            <span><label class="my-0 text-secondary">Recipient Office(s): </label>
                                                                <ul class="my-0">
                                                                    <?php
                                                                    $recipients = $this->db->select("
                                                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as recipient_office,
                                                        added_by_user_office as sender_office
                                                        ")
                                                                        ->from("document_recipients as dr")
                                                                        ->join("lib_office as lo", "dr.recipient_office_code = lo.OFFICE_CODE")
                                                                        ->where("document_number", $data->document_number)
                                                                        ->order_by("date_added", "asc")
                                                                        ->get()->result();

                                                                    foreach ($recipients as $row) {

                                                                        $get_added_by_office = $this->db->select("CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as added_by_office")->from("lib_office")->where("OFFICE_CODE", $row->sender_office)->get()->result();
                                                                        // print_r($get_added_by_office->added_by_office);

                                                                        // print_r();
                                                                        if ($get_added_by_office) {
                                                                            $added_by_office = $get_added_by_office[0]->added_by_office == $office_code ? "You" : $get_added_by_office[0]->added_by_office;
                                                                            echo '<li data-toggle="tooltip" data-placement="top" title="Added by ' . $added_by_office . '">' . $row->recipient_office . '</li>';
                                                                        }
                                                                    }
                                                                    ?>


                                                                </ul>
                                                            </span>
                                                        </div>
                                                        <div class="mx-0 px-0 d-flex flex-column col-md-4 align-items-end">
                                                            <span><label class="my-0 text-secondary">Date released: </label>
                                                                <?php
                                                                $date_sent = $this->db->select("log_date")
                                                                    ->from("receipt_control_logs")
                                                                    ->where("document_number", $data->document_number)
                                                                    ->where("status", "1")
                                                                    ->where("type", "Released")
                                                                    ->order_by("log_date", "asc")
                                                                    ->limit(1)
                                                                    ->get()->result();
                                                                echo $logdate =  $date_sent ? $date_sent[0]->log_date : "";
                                                                ?>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="text-center">
                                            <span class="h4 text-dark mb-2 text-center mx-auto my-3">No New Transaction</span>
                                            <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                                        </div>
                                    <?php  } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <div class="mb-3 text-gray-500">
                                <b>ALL OUTGOING DOCUMENTS</b>
                                <span class="ms-2 "><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels." data-bs-original-title="" title=""></i></span>
                                <div class="mt-4">
                                    <?php
                                    // print_r($get_incoming_documents);
                                    $date = "";
                                    foreach ($get_outgoing_documents as $data) {
                                        if ($date != date("Y-m-d", strtotime($data->date))) {
                                            $date_word = date('F d, Y', strtotime(date("Y-m-d", strtotime($data->date))));
                                            echo "<h5 class='mt-3 pt-4 pb-2 text-secondary font-weight-normal'>" . $date_word . "</h5>";
                                            $date = date("Y-m-d", strtotime($data->date));
                                        }
                                        if ($date != $data->date) {
                                        }
                                    ?>
                                        <div class="col-md-12 d-flex flex-column justify-content-between border py-2">
                                            <div class="mx-0 px-0 d-flex flex-row col-md-12 justify-content-between">

                                            </div>
                                            <div class="mx-0 px-0 d-flex flex-row col-md-12">
                                                <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                    <h5><?php echo $data->document_number ?></h5>
                                                    <span><label class="my-0 text-secondary">Document Type: </label> <?php echo $data->document_type ?></span>
                                                    <span><label class="my-0 text-secondary">Subject: </label> <?php echo $data->subject ?></span>
                                                    <span><label class="my-0 text-secondary">Recipient Office(s): </label>
                                                        <ul class="my-0">
                                                            <?php
                                                            $recipients = $this->db->select("
                                                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as recipient_office,
                                                        added_by_user_office as sender_office
                                                        ")
                                                                ->from("document_recipients as dr")
                                                                ->join("lib_office as lo", "dr.recipient_office_code = lo.OFFICE_CODE")
                                                                ->where("document_number", $data->document_number)
                                                                ->order_by("date_added", "asc")
                                                                ->get()->result();

                                                            foreach ($recipients as $row) {

                                                                $get_added_by_office = $this->db->select("CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as added_by_office")->from("lib_office")->where("OFFICE_CODE", $row->sender_office)->get()->result();
                                                                // print_r($get_added_by_office->added_by_office);

                                                                // print_r();
                                                                if ($get_added_by_office) {
                                                                    $added_by_office = $get_added_by_office[0]->added_by_office == $office_code ? "You" : $get_added_by_office[0]->added_by_office;
                                                                    echo '<li data-toggle="tooltip" data-placement="top" title="Added by ' . $added_by_office . '">' . $row->recipient_office . '</li>';
                                                                }
                                                            }
                                                            ?>


                                                        </ul>
                                                    </span>
                                                </div>
                                                <div class="mx-0 px-0 d-flex flex-column col-md-4 align-items-end">
                                                    <span><label class="my-0 text-secondary">Date released: </label>
                                                        <?php
                                                        $date_sent = $this->db->select("log_date")
                                                            ->from("receipt_control_logs")
                                                            ->where("document_number", $data->document_number)
                                                            ->where("status", "1")
                                                            ->where("type", "Released")
                                                            ->order_by("log_date", "asc")
                                                            ->limit(1)
                                                            ->get()->result();
                                                        echo $logdate =  $date_sent ? $date_sent[0]->log_date : "";
                                                        ?>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 ">
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <div class="mb-3 text-gray-500">
                                <b>PROCESSED DOCUMENTS</b>
                                <span class="ms-2 "><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels." data-bs-original-title="" title=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <div class="mb-3 text-gray-500">
                                <b class="text-danger">OVER DUE DOCUMENTS</b>
                                <span class="ms-2 "><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels." data-bs-original-title="" title=""></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>