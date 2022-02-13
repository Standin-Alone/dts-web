<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js" charset="utf-8"></script>
<link href="<?php echo base_url() ?>assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/plugins/nvd3/build/nv.d3.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/nvd3/examples/lib/stream_layers.js"></script>
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
<style>
    svg {
        display: block;
    }

    #test2 {
        height: 290px !important;
        width: 290px !important;
    }

    #test1 {
        height: 280px !important;
        width: 100% !important;
        /* position: relative; */
    }

    .nvd3.nv-pie.nv-chart-donut2 .nv-pie-title {
        fill: rgba(70, 107, 168, 0.78);
    }

    .nvd3.nv-pie.nv-chart-donut1 .nv-pie-title {
        opacity: 1;
        fill: "#707478";
    }
</style>
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
                                <b class="text-success">LATEST TRANSACTIONS</b>
                                <span class="ms-2 "><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Outgoing documents for today"></i></span>
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
                                                    <?php
                                                    if ($data->status == 'Archived') {
                                                        echo '
                                                        <span>
                                                           <i class="fa fa-check-circle text-lime mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="Completed"></i>
                                                        </span>
                                                        ';
                                                    } else if ($data->status == 'Verified') {
                                                        echo '
                                                    <span>
                                                        <i class="fa fa-hourglass-half text-gray mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="In Process"></i>
                                                    </span>
                                                    ';
                                                    }
                                                    ?>
                                                        <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                            <a href="<?php echo base_url() ?>View_document/document/<?php echo $data->document_number ?>" target="_blank">
                                                                <h5><?php echo '<span class="document_number">' . $data->document_number . '</span>';
                                                                    if ($data->for == 2) {
                                                                        echo '
                                                                <span>
                                                                    <span class="badge badge-lg badge-danger">Urgent Action</span>
                                                                </span>
                                                                ';
                                                                    } ?>
                                                                </h5>
                                                            </a>
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
                                                        <div class="mx-0 px-0 d-flex flex-column col align-items-end justify-content-between">
                                                            <span><label class="my-0 text-secondary"></label>
                                                                <?php
                                                                $date_sent = $this->db->select("log_date")
                                                                    ->from("receipt_control_logs")
                                                                    ->where("document_number", $data->document_number)
                                                                    ->where("status", "1")
                                                                    ->where("type", "Released")
                                                                    ->order_by("log_date", "asc")
                                                                    ->limit(1)
                                                                    ->get()->result();
                                                                $logdate =  $date_sent ? $date_sent[0]->log_date : "";

                                                                echo 'Today at ' . date("h:i a", strtotime($logdate));
                                                                ?>
                                                            </span>
                                                            <span class="d-flex flex-column align-self-end">
                                                                <button class="btn btn-sm btn-white log"><i class="fa fa-search-location"></i> Transaction Logs</button>
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


                            <div class="mb-3 text-gray-500">
                                <b class="text-warning">RECENT TRANSACTIONS</b>
                                <span class="ms-2 "><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Documents processed with in 2 days"></i></span>
                                <!-- <span class="ms-2 "><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Top products with units sold" data-bs-placement="top" data-bs-content="Products with the most individual units sold. Includes orders from all sales channels." data-bs-original-title="" title=""></i></span> -->
                                <ul class="list-group my-0 mt-3">
                                    <?php
                                    // print_r($get_latest_outgoing);
                                    if ($get_recent_outgoing) {
                                        foreach ($get_recent_outgoing as $data) {
                                    ?>
                                            <li class="list-group-item ">
                                                <div class="col-md-12 d-flex flex-column justify-content-between mx-0 px-0">
                                                    <div class="mx-0 px-0 d-flex flex-row col-md-12">
                                                    <?php
                                                    if ($data->status == 'Archived') {
                                                        echo '
                                                        <span>
                                                           <i class="fa fa-check-circle text-lime mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="Completed"></i>
                                                        </span>
                                                        ';
                                                    } else if ($data->status == 'Verified') {
                                                        echo '
                                                    <span>
                                                        <i class="fa fa-hourglass-half text-gray mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="In Process"></i>
                                                    </span>
                                                    ';
                                                    }
                                                    ?>
                                                        <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                        <a href="<?php echo base_url() ?>View_document/document/<?php echo $data->document_number ?>" target="_blank">
                                                                <h5><?php echo '<span class="document_number">' . $data->document_number . '</span>';
                                                                    if ($data->for == 2) {
                                                                        echo '
                                                                <span>
                                                                    <span class="badge badge-lg badge-danger">Urgent Action</span>
                                                                </span>
                                                                ';
                                                                    } ?>
                                                                </h5>
                                                            </a>
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
                                                        <div class="mx-0 px-0 d-flex flex-column col align-items-end justify-content-between">
                                                            <!-- <span><label class="my-0 text-secondary">Date released: </label> -->
                                                            <?php
                                                            $date_sent = $this->db->select("log_date")
                                                                ->from("receipt_control_logs")
                                                                ->where("document_number", $data->document_number)
                                                                ->where("status", "1")
                                                                ->where("type", "Released")
                                                                ->order_by("log_date", "asc")
                                                                ->limit(1)
                                                                ->get()->result();
                                                            $logdate =  $date_sent ? $date_sent[0]->log_date : "";

                                                            $datetime1 = strtotime($logdate);
                                                            $datetime2 = strtotime(date("Y-m-d h:i:s"));
                                                            $secs = $datetime2 - $datetime1; // == <seconds between the two times>
                                                            $days = $secs / 86400;

                                                            if (floor($days) < 1) {
                                                                echo 'Yesterday  at ' . date("h:i a", strtotime($logdate));
                                                            } else {
                                                                echo 'Released ' . floor($days) . ' days ago';
                                                            }
                                                            ?>
                                                            </span>
                                                            <span class="d-flex flex-column align-self-end">
                                                                <button class="btn btn-sm btn-white log"><i class="fa fa-search-location"></i> Transaction Logs</button>
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
                                <?php
                                if ($get_outgoing_documents) {
                                    $completed = [];
                                    $inprocess = [];
                                    $date = "";
                                    $total = count($get_outgoing_documents);
                                    foreach ($get_outgoing_documents as $data) {
                                        if ($date != date("Y-m-d", strtotime($data->date))) {
                                            if ($data->status == 'Archived') {
                                                $completed[] = $data->document_number;
                                            } else if ($data->status == 'Verified') {
                                                $inprocess[] = $data->document_number;
                                            }
                                        }
                                    }
                                    $completed_percent = floor(count($completed) / $total * 100);
                                    $inprocess_percent = floor(count($inprocess) / $total * 100);
                                }
                                ?>
                                <div class="row text-truncate my-2 rounded bg-light py-2">
                                    <div class="col-6 d-flex flex-row align-items-center">
                                        <span>
                                           
                                        </span>
                                        <span class="col">
                                            <div class=" text-gray-500"> <i class="fa fa-hourglass-half text-gray mr-2 mt-1"></i> Total Documents In Process</div>
                                            <div class="h5 mb-5px fw-bold my-2" data-animation="number" data-value="<?php echo count($inprocess) ? count($inprocess) :  "0"; ?>"><?php echo count($inprocess) ? count($inprocess) : "0" ?></div>
                                            <div class="progress h-5px rounded-3 bg-gray-900 mb-5px" data-toggle="tooltip" data-placement="top" title="<?php echo $inprocess_percent ? $inprocess_percent : "0" ?>% In Process">
                                                <div class="progress-bar progress-bar-striped rounded-right bg-secondary" data-animation="width" data-value="<?php echo $inprocess_percent ? $inprocess_percent : "0" ?>%" style="width: <?php echo $inprocess_percent ? $inprocess_percent : "0" ?>%;"></div>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="col-6 d-flex flex-row align-items-center">
                                        <span>
                                            
                                        </span>
                                        <span class="col">
                                            <div class=" text-gray-500"><i class="fa fa-check-circle text-lime mr-2 mt-1"></i>Total Documents Comlpeted</div>
                                            <div class="h5 mb-5px fw-bold my-2" data-animation="number" data-value="<?php echo count($completed) ? count($completed) : "0" ?>"><?php echo count($completed) ? count($completed) : "0" ?></div>
                                            <div class="progress h-5px rounded-3 bg-gray-900 mb-5px" data-toggle="tooltip" data-placement="top" title="<?php echo $completed_percent ? $completed_percent : "0" ?>% Completed">
                                                <div class="progress-bar progress-bar-striped rounded-right bg-lime" data-animation="width" data-value="<?php echo $completed_percent ? $completed_percent : "0" ?>%" style="width: <?php echo $completed_percent ? $completed_percent : "0" ?>%;"></div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2">
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
                                        <div class="list-group-item col-md-12 d-flex flex-column justify-content-between border py-2">
                                            <div class="mx-0 px-0 d-flex flex-row col-md-12 justify-content-between">

                                            </div>
                                            <div class="mx-0 px-0 d-flex flex-row col-md-12">
                                                <?php

                                                if ($data->status == 'Archived') {
                                                    echo '
                                                        <span>
                                                           <i class="fa fa-check-circle text-lime mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="Completed"></i>
                                                        </span>
                                                        ';
                                                } else if ($data->status == 'Verified') {
                                                    echo '
                                                    <span>
                                                        <i class="fa fa-hourglass-half text-gray mr-2 mt-1" data-toggle="tooltip" data-placement="top" title="In Process"></i>
                                                    </span>
                                                    ';
                                                }
                                                ?>

                                                <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                    <!-- <h5><?php echo $data->document_number ?></h5> -->
                                                    <a href="<?php echo base_url() ?>View_document/document/<?php echo $data->document_number ?>" target="_blank">
                                                                <h5><?php echo '<span class="document_number">' . $data->document_number . '</span>';
                                                                    if ($data->for == 2) {
                                                                        echo '
                                                                <span>
                                                                    <span class="badge badge-lg badge-danger">Urgent Action</span>
                                                                </span>
                                                                ';
                                                                    } ?>
                                                                </h5>
                                                            </a>
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
                                                <div class="mx-0 d-flex flex-column col-md-4 align-items-end justify-content-between">
                                                    <span><label class="my-0 text-secondary">Date released: </label>
                                                        <?php
                                                        $date_sent = $this->db->select("log_date")
                                                            ->from("receipt_control_logs")
                                                            ->where("document_number", $data->document_number)
                                                            ->where("status", "1")
                                                            ->where("type", "Released")
                                                            ->order_by("log_date", "asc")
                                                            ->limit(1)
                                                            ->get()->row();
                                                        $logdate =  $date_sent ? $date_sent->log_date : "";

                                                        echo $logdate ? date("F d, Y", strtotime($logdate)) : "no data";
                                                        ?>
                                                    </span>
                                                    <span class="d-flex flex-column align-self-end">
                                                        <button class="btn btn-sm btn-white log"><i class="fa fa-search-location"></i> Transaction Logs</button>
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
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <!-- <div>
                                <b>TYPE OF INCOMING DOCUMENTS</b>
                                <span class="ms-2">
                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Count of documents received by your office"></i>
                                </span>
                            </div> -->
                            <div class="d-flex flex-row justify-content-between">
                                <span class="col">
                                    Total Outgoing Documents
                                    <h1 class="mr-2 font-weight-bold text-secondary">
                                        <?php
                                        $total = null;
                                        foreach ($get_document_type_data_outgoing as $row) {
                                            $total = intval($total) + intval($row->type_count);
                                        }
                                        echo $total;
                                        ?>
                                    </h1>
                                    <!-- <span class="row d-flex flex-column col-md-12">
                                        <span class="mx-0 px-0 d-flex justify-content-between">
                                            Today <b>25</b>
                                        </span>
                                        <span class="mx-0 px-0 d-flex justify-content-between">
                                            This Month <b>100</b>
                                        </span>
                                        <span class="mx-0 px-0 d-flex justify-content-between">
                                            This year <b>1000</b>
                                        </span>
                                    </span> -->
                                </span>
                                <!-- <span>
                                    Last 30 days
                                </span> -->
                            </div>
                            <svg id="test1" width="60%" class="mypiechart mx-auto px-0 py-0 my-0"></svg>

                        </li>
                        <div class="scrollbar" style="max-height: 200px;">
                            <?php
                            $color = [
                                "#727cb6",
                                "#8753de",
                                "#348fe2",
                                "#49b6d6",
                                "#ffd900",
                                "#f59c1a",
                                "#ff5b57",
                                "#fb5597",
                                "#00acac",
                                "#32a932",
                                "#90ca4b",
                                "#727cb6",
                                "#8753de",
                                "#348fe2",
                                "#49b6d6",
                                "#ffd900",
                                "#f59c1a",
                                "#ff5b57",
                                "#fb5597",
                                "#00acac",
                                "#32a932",
                                "#90ca4b"
                            ];
                            foreach ($get_document_type_data_outgoing as $key => $row) {
                            ?>
                                <li class="list-group-item pie bg-light <?php echo 'slice_desc' . $key ?>">
                                    <div class="d-flex justify-content-between">
                                        <span><i style="color: <?php echo $color[$key] ?>;" class="fa fa-square mr-2"></i> <?php echo $row->type_desc . ' (' . $row->type . ')' ?></span>
                                        <span class="h5 font-weight-bold"><?php echo $row->type_count ?></span>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </div>
                    </ul>

                    <ul class="list-group mt-2" id="over_due">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>
                                <b class="text-danger mb-2 mt-3">
                                    OVERDUE DOCUMENTS
                                </b>
                                <span class="ms-2 "><i class="fa fa-info-circle text-danger" data-toggle="tooltip" data-placement="top" title="Received documents by your recipients without action for more than 3 days"></i></span>
                            </span>
                            <?php if ($get_over_due_outgoing) {
                                echo '<span class="badge badge-danger">' . count($get_over_due_outgoing) . '</span>';
                            } ?>
                        </li>
                        <?php
                        // print_r($get_over_due_incoming);
                        if ($get_over_due_outgoing) {
                            foreach ($get_over_due_outgoing as $key => $data) {
                                // print_r($data);
                        ?>
                                <li class="list-group-item">
                                    <div class="col-md-12 d-flex flex-column justify-content-between p-0 m-0">
                                        <div class="mx-0 px-0 d-flex flex-row col-md-12 justify-content-between">

                                        </div>
                                        <div class="mx-0 px-0 d-flex flex-row col-md-12">
                                            <div class="mx-0 px-0 d-flex flex-column col-md-8">
                                                <a href="<?php echo base_url() ?>View_document/document/<?php echo $data['details']['document_number'] ?>" target="_blank">
                                                                <h5><?php echo '<span class="document_number">' . $data['details']['document_number'] . '</span>';
                                                                    if ($data['details']['for'] == 2) {
                                                                        echo '
                                                                <span>
                                                                    <span class="badge badge-lg badge-danger">Urgent Action</span>
                                                                </span>
                                                                ';
                                                                    } ?>
                                                                </h5>
                                                            </a>
                                                <span><label class="my-0 text-secondary">Document Type: </label> <?php echo $data['details']['doc_type'] ?> </span>
                                                <span><label class="my-0 text-secondary">Subject: </label> <?php echo $data['details']['subject'] ?> </span>
                                                <span><label class="my-0 text-secondary">Current Office: </label> <?php echo $data['details']['current_office'] ?></span>
                                            </div>
                                            <div class="mx-0 px-0 d-flex flex-column col-md-4 align-items-end justify-content-between"">
                                            <!-- <span><label class=" my-0 text-secondary">Date sent: </label>

                                                </span> -->
                                                <span><label class="my-0 text-secondary"> </label> Received <?php echo floor($data['interval']) ?> days ago</span>
                                                <span class="d-flex flex-column mt-3">
                                                    <button class="btn btn-sm border mb-1" disabled>Remind</button>
                                                    <!-- <a href="<?php echo base_url() ?>View_document/document/<?php echo $data['details']['document_number'] ?>" target="_blank" class="btn btn-sm text-danger border mb-1">Mark As Completed</a> -->
                                                    <!-- <a class="btn border btn-sm" data-toggle="collapse" href="#collapseExample<?php echo $key ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                    Details
                                                </a> -->
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mx-0 px-0 d-flex flex-row col-md-12 ">
                                            <div class="collapse row col-md-12 mx-0 my-1 px-0 py-1 bg-light rounded" id="collapseExample<?php echo $key ?>">
                                                <div class="card card-body mx-0 my-0 py-0 px-1 bg-light d-flex flex-column">
                                                    <div class="col-md-12 px-0 mx-0 d-flex">
                                                        <span><label class="my-0 text-secondary">From: </label> <?php echo $data['details']['from_office'] ?></span>
                                                    </div>
                                                    <div class="col-md-12 px-0 mx-0 d-flex">
                                                        <span><label class="my-0 text-secondary"> </label> Received <?php echo $data['interval'] ?> days ago</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 px-0 mx-0 mt-2 mb-0 pb-0">
                                                    <a href="" target="_blank" class="btn btn-block btn-sm mb-0 pb-0">See All Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php
                            }
                        } else {
                            ?>
                            <li class="list-group-item">
                                <div class="text-center">
                                    <span class="h4 text-dark mb-2 text-center mx-auto my-3">No New Transaction</span>
                                    <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        <?php
        if ($this->input->get('target')) {
            // echo 'console.logs('.$_REQUEST['target'].')'
        ?>
            $('html, body').animate({
                scrollTop: $("#over_due").offset().top - 70
            }, 1500);
            $(document).find("#over_due").focus()
        <?php
        }
        ?>
    });
    let doc_type_data = [];
    var retVal;
    $.ajax({
        type: "get",
        url: base_url + "Dashboard/get_document_type_data_outgoing",
        dataType: "json",
        async: false,
        success: function(response) {
            doc_type_data = response
        }
    });

    console.log('====================================');
    console.log(doc_type_data);
    console.log('====================================');

    var color = [
        "#727cb6",
        "#8753de",
        "#348fe2",
        "#49b6d6",
        "#ffd900",
        "#f59c1a",
        "#ff5b57",
        "#fb5597",
        "#00acac",
        "#32a932",
        "#90ca4b",
        "#727cb6",
        "#8753de",
        "#348fe2",
        "#49b6d6",
        "#ffd900",
        "#f59c1a",
        "#ff5b57",
        "#fb5597",
        "#00acac",
        "#32a932",
        "#90ca4b"
    ]

    // #ff5b57
    // #fb5597

    let total = [];
    $.map(doc_type_data, function(data, i) {
        total.push({
            type: data.type,
            type_desc: data.type_desc,
            type_count: data.type_count,
            color: color[i]
        })
    });

    // console.log('====================================');
    // console.log('total', total);
    // console.log('====================================');

    // var slice = $(".nv-slice")

    let slices = []
    $(".pie").each(function(i) {
        $(this).hover(function() {
            $(".slice_" + i).toggleClass("hover")
        })
        console.log('====================================');
        console.log($(this));
        console.log('====================================');
    });


    var height = 320;
    var width = 350;

    var chart1;
    nv.addGraph(function() {
        var chart1 = nv.models.pieChart()
            .x(function(d) {
                return d.type
            })
            .y(function(d) {
                return d.type_count
            })
            .donut(true)
            // .width(width)
            .height(height)
            .padAngle(.015)
            .cornerRadius(3.5)
            .showLabels(true)
            .labelThreshold(.04)
            // .labelType("percent")
            .labelsOutside(false)
            .growOnHover(true)
            .donutRatio(0.35)
            .id('donut1') // allow custom CSS for this one svg
            .color(color)
            // chart1.title(total);
            // chart1.legendPosition("bottom")
            .growOnHover(true)
        chart1.labelType("percent")
        chart1.pie.donut(true);

        d3.select("#test1")
            .datum(doc_type_data)
            .transition().duration(1200)
            .call(chart1);

        // d3.select(".nv-legendWrap")
        //     .attr("transform", "translate(0,350)")

        d3.selectAll('.nv-label text')
            .each(function(d, i) {
                d3.select(this).style('fill', '#ffff')
                // d3.select(this).style('font-weight', 700)
                d3.select(this).style('font-size', 9)
            })




        var positionX = 0;
        var positionY = 0;
        var verticalOffset = 25;


        // d3.selectAll('.nv-legend .nv-series')[0].forEach(function(d) {
        //     positionY += verticalOffset;
        //     d3.select(d).attr('transform', 'translate(' + positionX + ',' + positionY + ')')
        // });

        d3.selectAll('.nv-legend .nv-series text')
            .each(function(d, i) {
                d3.select(this).style('fill', '#6c757d')
                d3.select(this).style('font-weight', 100)
                // d3.select(this).style('font-size', 16)
            });

        $('.nv-slice').each(function(i) {
            $(this).addClass("slice_" + i)

            $(this).hover(function() {
                $(".slice_desc" + i).toggleClass("bg-white")
                $(".slice_desc" + i).focus()
            })
            // d3.select(this).style('font-size', 16)
        });

        // LISTEN TO WINDOW RESIZE
        // nv.utils.windowResize(chart1.update);

        // LISTEN TO CLICK EVENTS ON SLICES OF THE PIE/DONUT
        // chart.pie.dispatch.on('elementClick', function() {
        //     code...
        // });

        // chart.pie.dispatch.on('chartClick', function() {
        //     code...
        // });

        // LISTEN TO DOUBLECLICK EVENTS ON SLICES OF THE PIE/DONUT
        // chart.pie.dispatch.on('elementDblClick', function() {
        //     code...
        // });

        // LISTEN TO THE renderEnd EVENT OF THE PIE/DONUT
        // chart.pie.dispatch.on('renderEnd', function() {
        //     code...
        // });

        // OTHER EVENTS DISPATCHED BY THE PIE INCLUDE: elementMouseover, elementMouseout, elementMousemove
        // @see nv.models.pie

        return chart1;

    });

    $(document).find(".log").each(function(i) {
        var check_status_btn = $(this)

        check_status_btn.on('click', function() {
            var document_number = check_status_btn.parents(".list-group-item").find(".document_number").text()
            var result = document_number.split(' ').join('')

            console.log(result);
            track_document(result)
        })
    })
</script>