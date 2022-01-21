<!-- <link rel="stylesheet" href="dashboard.css"> -->

<!-- ================== BEGIN ADDITIONALS STYLE ================== -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
<!-- ================== END ADDITIONALS STYLE ================== -->

<style>
    sup {
        top: -0.7em;
        left: -1em;
        position: relative;
        font-size: 100%;
        line-height: 0;
        vertical-align: baseline;
    }

    ul.timeline {
        list-style-type: none;
        position: relative;
        padding-left: 1.5rem;
    }

    /* Timeline vertical line */
    ul.timeline:before {
        content: ' ';
        background: #fff;
        display: inline-block;
        position: absolute;
        left: 16px;
        width: 4px;
        height: 100%;
        z-index: 400;
        border-radius: 1rem;
    }

    li.timeline-item {
        margin: 20px 0;
    }

    /* Timeline item arrow */
    .timeline-arrow {
        border-top: 0.5rem solid transparent;
        border-right: 0.5rem solid #fff;
        border-bottom: 0.5rem solid transparent;
        display: block;
        position: absolute;
        top: 20px;
        left: -8px;
    }

    /* Timeline item circle marker */
    li.timeline-item::before {
        content: ' ';
        background: #ddd;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #fff;
        top: 20px;
        left: -31px;
        width: 14px;
        height: 14px;
        z-index: 400;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }
</style>

<?php
// Initialize

// ================Received============================
$received_total_count =  $count_data['received_data']['received_total_count'];
$received_today_count =  $count_data['received_data']['received_today_count'];
$received_month_count =  $count_data['received_data']['received_month_count'];
$received_year_count =  $count_data['received_data']['received_year_count'];

// ================Released============================
$released_total_count =  $count_data['released_data']['released_total_count'];
$released_today_count =  $count_data['released_data']['released_today_count'];
$released_month_count =  $count_data['released_data']['released_month_count'];
$released_year_count =  $count_data['released_data']['released_year_count'];

// ================My Documents============================
$my_documents_count = $count_data['my_documents_data']['document_count'];
$my_documents = $count_data['my_documents_data']['document_details'];

// ================My Archives============================
$my_archives_count = $count_data['my_archives_data'];

// ================Recevied Documents============================
?>

<div id="content" class="content">
    <!-- begin row -->
    <div class="row">

        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-success">
                <div class="stats-icon"><i class="fa fa-file-download"></i></div>
                <div class="stats-info">
                    <h4>Received (Today)</h4>
                    <p>
                        <?php
                        echo $received_today_count;
                        ?>
                    </p>
                </div>
                <div class="stats-link">
                    <!-- <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a> -->
                    <a href="#" type="button" data-toggle="modal" data-target="#modal_received">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-orange">
                <div class="stats-icon"><i class="fa fa-file-upload"></i></div>
                <div class="stats-info">
                    <h4>Released (Today)</h4>
                    <p>
                        <?php
                        echo $released_today_count;
                        ?>
                    </p>
                </div>
                <div class="stats-link">
                    <!-- <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a> -->
                    <a href="#" type="button" data-toggle="modal" data-target="#modal_released">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-grey-darker">
                <div class="stats-icon"><i class="fa fa-file-alt"></i></div>
                <div class="stats-info">
                    <h4>My Documents</h4>
                    <p>
                        <?php
                        echo $my_documents_count;
                        ?>
                    </p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-black-lighter">
                <div class="stats-icon"><i class="fa fa-folders"></i></div>
                <div class="stats-info">
                    <h4>My Archive</h4>
                    <p>
                        <?php
                        echo $my_archives_count;
                        ?>
                    </p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="background-image: linear-gradient(to bottom right, #ccf2ff , #379cf7);">
                <!-- <img class="img-fluid px-3 py-3 ml-5" src="assets/img/dashboard/dts-dashboard-banner.svg" alt="Card image"> -->
                <!-- <div class="card-img-overlay"> -->
                <div class="d-flex align-items-center justify-content-between">
                    <div class="col d-lg-block d-sm-none">
                        <img class="img-fluid px-3 py-3 ml-5" src="assets/img/dashboard/dts-dashboard-banner.svg" alt="Card image" style="max-width: 70%;">
                        <div class="card p-4 h-auto my-md-3 my-lg-3 bg-primary shadow d-flex " style="border-radius: 10px; background: rgba(9, 43, 150, 0.3); ">
                            <h3 class="mx-auto text-white mt-3"><i class="h3 fa fa-file-import mr-2 text-lg"></i>Quick Receive</h3>
                            <p class="h5 text-white mx-auto">
                                Enter Document Number to log document
                            </p>
                            <form id="form_receive">
                                <div class="input-group p-5">
                                    <input name="document_number" id="document_number" type="text" class="form-control" placeholder="Document Number">
                                    <button type="submit" id="receive_btn" name="receive_btn" class="btn btn-warning"><i class="fa fa-arrow-circle-right text-lg"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 my-3 d-flex flex-row mx-sm-auto">
                        <div class="col mh-400 mb-auto my-2 d-flex flex-column my-auto" style="border-radius: 10px; background: rgba(255, 255, 255, 0.2); ">
                            <div class="my-auto h-auto">
                                <!-- <div class="card p-lg-4 h-auto my-md-3 my-lg-3 shadow bg-warning d-flex " style="border-radius: 10px; background: rgba(255, 255, 255, 0.7); box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;">
                                    <a class="btn btn-lg wrap" href="<?php echo base_url() . 'Create_profile' ?>">
                                        <h3 class="text-white"><i class="fa fa-book mr-3"></i>Create Profile</h3>
                                        <p class="h5 text-white mx-auto my-0">
                                            Profile your document for a documented transaction
                                        </p>
                                    </a>
                                </div> -->
                                <!-- <div class="card p-4 h-auto my-md-3 my-lg-3 bg-primary shadow d-flex " style="border-radius: 10px; background: rgba(9, 43, 150, 0.3); ">
                                    <h3 class="mx-auto text-white mt-3"><i class="h3 fa fa-file-import mr-2 text-lg"></i>Quick Receive</h3>
                                    <p class="h5 text-white mx-auto">
                                        Enter Document Number to log document
                                    </p>
                                    <form id="form_receive">
                                        <div class="input-group p-5">
                                            <input name="document_number" id="document_number" type="text" class="form-control" placeholder="Document Number">
                                            <button type="submit" id="receive_btn" name="receive_btn" class="btn btn-warning"><i class="fa fa-arrow-circle-right text-lg"></i></button>
                                        </div>
                                    </form>
                                </div> -->


                                <div class="card p-4 h-auto my-md-3 my-md-1 my-lg-3 bg-primary shadow d-flex " style="border-radius: 10px; background: rgba(9, 43, 150, 0.3); ">
                                    <!--Carousel Wrapper-->
                                    <h3 class="mx-auto text-white mt-3">FOR DISSEMINATION DOCUMENTS</h3>
                                    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                                        <!--Indicators-->
                                        <ol class="carousel-indicators">
                                            <?php
                                            // print_r($get_dissemination_documents);
                                            // echo count($get_dissemination_documents);
                                            foreach ($get_dissemination_documents as $key => $row) {
                                            ?>
                                                <li data-target="#multi-item-example" data-slide-to="<?php echo $key ?>" class="<?php echo $active = $key == 0 ? 'active' : ""  ?>"></li>
                                            <?php } ?>
                                            <!-- <li data-target="#multi-item-example" data-slide-to="0"></li>
                                            <li data-target="#multi-item-example" data-slide-to="1"></li> -->
                                        </ol>
                                        <!--/.Indicators-->

                                        <!--Slides-->
                                        <div class="carousel-inner" role="listbox" style="height: 180px;">
                                            <?php
                                            // print_r($get_dissemination_documents);
                                            // echo count($get_dissemination_documents);
                                            foreach ($get_dissemination_documents as $key => $row) {
                                            ?>
                                                <!--First slide-->
                                                <div class="carousel-item <?php echo $active = $key == 0 ? 'active' : ""  ?>">
                                                    <div class="col-md-12" style="float:left">
                                                        <div class="card mb-2">
                                                            <div class="card-body">
                                                                <h4 class="card-title"><?php echo $row->doc_type ?></h4>
                                                                <p class="card-text"><?php echo $row->subject ?></p>
                                                                <a target="_blank" href="<?php echo base_url() . 'View_document/document/' . $row->document_number ?>" class="btn border">View</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.First slide-->
                                                <!--Second slide-->
                                                <!-- <div class="carousel-item">
                                                    <div class="col-md-12" style="float:left">
                                                        <div class="card mb-2">
                                                            <div class="card-body">
                                                                <h4 class="card-title">Memorandum of Agreement</h4>
                                                                <p class="card-text">Special Order for National Livestock and Poultry M</p>
                                                                <button class="btn btn-primary">View</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <?php } ?>
                                            <!--/.Second slide-->
                                        </div>
                                        <!--Controls-->
                                        <div class="controls-top col-md-12">
                                            <div class="col-2 mx-auto">
                                                <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
                                                <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fas fa-chevron-right"></i></a>
                                            </div>
                                        </div>
                                        <!--/.Controls-->
                                        <!--/.Slides-->
                                    </div>
                                    <!--/.Carousel Wrapper-->
                                    <div class="card">
                                        <ul class="list-group scrollbar" style="height: 100px;">
                                            <?php
                                            foreach ($get_dissemination_documents as $key => $row) {
                                            ?>
                                                <li class="list-group-item">
                                                    <span class="d-flex justify-content-between">
                                                        <span class="d-flex flex-column">
                                                            <span>
                                                                <?php echo $row->document_number ?>
                                                            </span>
                                                            <span>
                                                                Document Type: <?php echo $row->doc_type ?>
                                                            </span>
                                                            <span>
                                                                Subject: <?php echo $row->subject ?>
                                                            </span>
                                                        </span>
                                                        <a target="_blank" href="<?php echo base_url() . 'View_document/document/' . $row->document_number ?>" class="btn border">View</a>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <a href="<?php echo base_url() ?>Dashboard" class="btn btn-sm text-white fs-10px ps-2 pe-2 px-3">
                                        <i class="fa fa-th-list mr-1"></i>
                                        View All
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card rounded">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between">
                        <div class="col">
                            <h6 class="mb-3 text-white" style="opacity: 75%;"> <i class="mr-1 fa fa-arrow-down"></i>INCOMING DOCUMENTS</h6>
                            <h3 class="text-white">
                                <?php echo count($incoming_documents) ?>
                            </h3>
                        </div>
                        <!-- <img src="<?php echo base_url() ?>/assets/img/dashboard/outgoing.svg" height="80" class="d-none d-lg-block mx-auto"> -->
                        <span>
                            <a href="<?php echo base_url() ?>Dashboard/Incoming_documents_view" class="btn btn-sm btn-outline-secondary fs-10px ps-2 pe-2 px-3">
                                <i class="fa fa-th-list mr-1"></i>
                                View All
                            </a>
                            <?php if ($get_over_due_incoming) {
                                echo '<sup><span class="mx-0 badge badge-danger badge-pill">' . count($get_over_due_incoming) . '</span></sup>';
                            } ?>
                        </span>
                    </div>
                </div>
                <div class="p-2 <?php echo $class = !empty($incoming_documents) ? 'scrollbar' : ''; ?>" style="max-height: 350px;">
                    <div class="list-group list-group-flush rounded-bottom overflow-hidden panel-body p-0">
                        <?php
                        if ($incoming_documents) {
                            foreach ($incoming_documents as $row) {
                        ?>

                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex flex-column">
                                        <div class="row d-flex flex-row justify-content-between">
                                            <div class="col-md-8 d-flex flex-column">
                                                <a href="<?php echo base_url() . 'Receipt_Control_Center/Receive/' . $row->document_number ?>" target="_blank" class="fs-14px lh-12 mb-2px font-weight-bold text-secondary mb-1 incoming_document_number"><?php echo $row->document_number ?></a>
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1">From: <?php echo $row->from_office ?></span>
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1">Subject: <?php echo $row->subject ?></span>
                                            </div>
                                            <div class="col-md-4 d-flex flex-column justify-content-between align-items-end mx-0 px-0">
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1 align-self-end">Today at <?php echo date("g:i a", strtotime($row->date_created)) ?></span>
                                                <span class="d-flex flex-row justify-content-between align-self-end mx-0">
                                                    <button class="btn btn-sm btn-outline-secondary mx-1 logs"><i class="fa fa-search-location mr-1"></i> Logs</button>
                                                    <a href="<?php echo base_url() . 'View_document/document/' . $row->document_number ?>" target="_blank" class="btn btn-sm btn-secondary ml-1"><i class="fa fa-file-alt mr-1"></i> View</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        } else { ?>
                            <div class="text-center my-4">
                                <span class="h4 text-dark mb-2 text-center mx-auto my-3">No New Transaction</span>
                                <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card rounded">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between">
                        <div class="col">
                            <h6 class="mb-3 text-white" style="opacity: 75%;"> <i class="mr-1 fa fa-arrow-up"></i>OUTGOING DOCUMENTS</h6>
                            <h3 class="text-white">
                                <?php echo count($outgoing_documents) ?>
                            </h3>
                        </div>
                        <!-- <img src="<?php echo base_url() ?>/assets/img/dashboard/outgoing.svg" height="80" class="d-none d-lg-block mx-auto"> -->
                        <span>
                            <a href="<?php echo base_url() ?>Dashboard/Outgoing_Documents_view" class="btn btn-sm btn-outline-secondary fs-10px ps-2 pe-2 px-3"><i class="fa fa-th-list mr-1"></i> View All</a>
                        </span>
                    </div>
                </div>
                <div class="p-2 <?php echo $class = !empty($outgoing_documents) ? 'scrollbar' : ''; ?>" style="max-height: 350px;">
                    <div class="list-group list-group-flush rounded-bottom overflow-hidden panel-body p-0">
                        <?php
                        if ($outgoing_documents) {
                            foreach ($outgoing_documents as $row) {
                                $this->db
                                    ->where("document_number", $row->document_number)
                                    ->from("document_recipients");
                                $count_recipient = $this->db->get()->num_rows();


                                $this->db
                                    ->where("document_number", $row->document_number)
                                    ->where("active", "0")
                                    ->from("document_recipients");
                                $count_received_recipient = $this->db->get()->num_rows();
                        ?>
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex flex-column">
                                        <div class="row d-flex justify-content-between">
                                            <div class="d-flex flex-column">
                                                <label class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1 status_document_number"><?php echo $row->document_number ?></label>
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1">Subject: <?php echo $row->subject ?></span>
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1">Recipients: <?php echo $count_received_recipient . '/' . $count_recipient ?> Received</span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between">
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1 align-self-end">Today at <?php echo  $time = date('g:i a', strtotime($row->date_created));   ?></span>
                                                <span class="fs-14px lh-12 mb-2px fw-bold text-dark mb-1"><?php
                                                                                                            if ($count_received_recipient == $count_recipient) {
                                                                                                                echo '
                                                                                                                <button class="btn btn-outline-success btn-xs float-right check_status" data-toggle="tooltip" data-placement="top" title="Check Status">
                                                                                                                    <i class="fa fa-check-circle mr-1"></i> Done
                                                                                                                </button>
                                                                                                                ';
                                                                                                            } else {
                                                                                                                echo '
                                                                                                                <button class="btn btn-outline-secondary btn-xs float-right check_status" data-toggle="tooltip" data-placement="top" title="Check Status">
                                                                                                                    <i class="fa fa-hourglass-start mr-1"></i> Processing
                                                                                                                </button>
                                                                                                                ';
                                                                                                            }
                                                                                                            // if ($row->status == "Archived") {
                                                                                                            //     echo "
                                                                                                            //                 <span class = 'border-primary rounded float-right border text-primary p-1'>
                                                                                                            //                    <i class='fa fa-archive mr-1'></i> Archived
                                                                                                            //                 </span>
                                                                                                            //                 ";
                                                                                                            // }
                                                                                                            ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="text-center my-4">
                                <span class="h4 text-dark mb-2 text-center mx-auto my-3">No New Transaction</span>
                                <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <a href="#modal-dialog" class="btn btn-primary" data-bs-toggle="modal">Modal</a>

    <div class="modal fae" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Dialog</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                    <a href="javascript:;" class="btn btn-success">Action</a>
                </div>
            </div>
        </div>
    </div> -->



    <!-- ===========================MODAL Document History=========================== -->
    <div class="modal fae bd-example-modal-lg" id="modal_track" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container pt-3 pb-2">

                    <!-- For demo purpose -->
                    <div class="row text-center">
                        <div class="col-lg-8 mx-auto">
                            <h1 class="display-6">Document History</h1>
                            <span class="d-flex flex-row justify-content-center">
                                <!-- <p id="text_document_number" class="lead mb-0 text-dark"></p> -->

                            </span>
                        </div>
                    </div><!-- End -->
                    <div class="row p-4 d-flex flex-row justify-content-start align-items-end bg-light p-2">
                        <div class="col-md-9">
                            <h5><b id="text_document_number"></b>
                                <a href="#" class="btn-icon btn-sm copy link-secondary" style="text-decoration: none;" data-toggle="tooltip" data-placement="top" title="Click to copy">
                                    <i class="ml-2 fa fa-clone text-gray"></i>
                                </a>
                            </h5>
                            <span class="d-flex flex-row align-items-end">
                                Type: &nbsp;
                                <h6 id="type" class="mb-0 "></h6>
                            </span>
                            <span class="d-flex flex-row align-items-end">
                                Subject: &nbsp;
                                <h6 id="subject" class="mb-0"></h6>
                            </span>
                            <span class="d-flex flex-row align-items-end">
                                Document Origin: &nbsp;
                                <h6 id="origin" class="mb-0 "></h6>
                            </span>
                        </div>
                        <div class="col-xl-3 col-lg-3 align-items-center d-flex justify-content-end p-3">
                            <img src="<?php echo base_url() ?>/assets/img/dashboard/track_document.svg" height="100" class="d-none d-lg-block">
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col-lg-12 mx-auto m-3 rounded scrollbar" style="max-height: 500px; background-color: #d7dfe6;">
                            <!-- Timeline -->
                            <ul id="timeline" class="timeline">

                            </ul><!-- End -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- =====================================MODAL RECEIVED LIST========================================== -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_received">Large modal</button> -->

    <div class="modal fae bd-example-modal-lg" id="modal_received" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container pt-5 pb-2">
                    <!-- For demo purpose -->
                    <div class="row text-center text-white">
                        <div class="col-lg-8 mx-auto">
                            <h1 class="display-6">Received Documents</h1>
                            <div class="input-group mb-3">
                                <input name="search_received" id="search_received" type="text" class="form-control" placeholder="Enter keyword" aria-label="Recipient's username" aria-describedby="basic-addon2" style="border-radius: 50px 0 0 50px;">
                                <div class="input-group-append">
                                    <span id="received_btn" class="input-group-text" id="basic-addon2" style="border-radius: 0 50px 50px 0;"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                    <div class="row bg-light px-0">
                        <div class="col-xl-12 mx-auto mb-2 mt-2">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 align-items-center d-flex justify-content-center p-3">
                                    <img src="<?php echo base_url() ?>/assets/img/dashboard/received_modal.svg" height="130" class="d-none d-lg-block">
                                </div>
                                <div class="col-xl-9 col-lg-9">
                                    <div class="d-flex justify-content-between">
                                        <div class="row d-flex flex-column">
                                            <div class="">
                                                <b>TOTAL RECEIVED DOCUMENTS</b>
                                            </div>
                                            <div class="d-flex">
                                                <h2 class="mb-0"><span data-animation="number" data-value="64559.25"><?php echo $received_total_count ?></span></h2>
                                                <div class="ms-auto mt-n1 mb-n1v ">
                                                    <div class="bg-secondary" id="total-sales-sparkline" style="min-height: 36px;">
                                                    </div>
                                                    <!-- <hr> -->
                                                </div>
                                            </div>
                                        </div>
                                        <span>
                                            <a href="<?php echo base_url() ?>Dashboard/Received_Documents_view" class="btn btn-xs btn-light fs-10px ps-2 pe-2 px-3"><i class="fa fa-th-list mr-1"></i> See All</a>
                                        </span>
                                    </div>
                                    <!-- <div class="mb-3 ">
                                    <i class="fa fa-caret-up"></i> <span data-animation="number" data-value="33.21">33.21</span>% compare to last week
                                </div> -->
                                    <hr class="bg-secondary opacity-25" style="opacity: 25%;">
                                    <div class="row text-truncate">
                                        <div class="col-4">
                                            <div class=" ">Received This Year</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $received_year_count ?>"><?php echo $received_year_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                            <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                        </div> -->
                                        </div>
                                        <div class="col-4">
                                            <div class=" ">Received This Month</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $received_month_count ?>"><?php echo $received_month_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                            <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                        </div> -->
                                        </div>
                                        <div class="col-4">
                                            <div class=" ">Received Today</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $received_today_count ?>"><?php echo $received_today_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                            <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                        </div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div class="col-lg-12 mx-auto m-3 scrollbar rounded" style="height: 350px; background-color: #d7dfe6;">
                            <?php
                            // print_r($received_documents);
                            foreach ($received_documents as $row) { ?>
                                <div class="card mb-2 mt-2 bg-white">
                                    <!-- <div class="d-flex justify-content-between align-items-center p-2">
                                        <div class="d-flex flex-column">
                                            <label class="h4 mb-1">From: </label>
                                            <span class="h6 mb-0">Office: <label class="m-0"> <?php echo $row->from_office ?></label></span>
                                            <span class="h6 mb-0">Assigned Personel: <label class="m-0"><?php echo $row->from_user ?></label> </span>
                                        </div>
                                    </div>
                                    <hr class="bg-secondary opacity-25" style="opacity: 25%;"> -->
                                    <div class=" bg-light p-5 d-flex justify-content-between align-items-center">
                                        <!-- <div class="note-icon"><i class="fab fa-facebook-f"></i></div> -->
                                        <div class="note-content">
                                            <h4><b>From</b></h4>
                                            <div class="d-flex flex-column">
                                                <span class="h6 mb-1">Office: <label class="m-0"> <?php echo $row->from_office ?></label></span>
                                                <!-- <span class="h6 m-0">Assigned Personnel: <label class="m-0"><?php echo $row->from_user ?></label> </span> -->
                                            </div>
                                        </div>
                                        <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Received: <?php echo $row->log_date ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center p-5">
                                        <div class="d-flex flex-column">
                                            <h4><b>Details</b></h4>
                                            <span class="h6 m-0">Document No: <label> <?php echo $row->document_number ?></label></span>
                                            <span class="h6 m-0">Document Type: <label><?php echo $row->doc_type ?></label> </span>
                                            <span class="h6 m-0">Origin Type: <label><?php echo $row->origin_type ?></label> </span>
                                            <span class="h6 m-0">Subject: <label> <?php echo $row->subject ?></label></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ================================== Released Modal ============================================ -->
    <div class=" modal fae bd-example-modal-lg" id="modal_released" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container pt-5 pb-2">
                    <!-- For demo purpose -->
                    <div class="row text-center text-white">
                        <div class="col-lg-8 mx-auto">
                            <h1 class="display-6">Released Documents</h1>
                            <div class="input-group mb-3">
                                <input name="search_released" id="search_released" type="text" class="form-control" placeholder="Enter keyword" aria-label="Recipient's username" aria-describedby="basic-addon2" style="border-radius: 50px 0 0 50px;">
                                <div class="input-group-append">
                                    <span id="released_btn" class="input-group-text" id="basic-addon2" style="border-radius: 0 50px 50px 0;"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                    <div class="row bg-light px-0">
                        <div class="col-xl-12 mx-auto mb-2 mt-2">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 align-items-center d-flex justify-content-center p-3">
                                    <img src="<?php echo base_url() ?>/assets/img/dashboard/released_modal.svg" height="130" class="d-none d-lg-block">
                                </div>
                                <div class="col-xl-9 col-lg-9">
                                    <div class="d-flex justify-content-between">
                                        <div class="row d-flex flex-column">
                                            <div class="">
                                                <b>TOTAL RELEASED DOCUMENTS</b>
                                            </div>
                                            <div class="d-flex">
                                                <h2 class="mb-0"><span data-animation="number" data-value="64559.25"><?php echo $released_total_count ?></span></h2>
                                                <div class="ms-auto mt-n1 mb-n1v ">
                                                    <div class="bg-secondary" id="total-sales-sparkline" style="min-height: 36px;">
                                                    </div>
                                                    <!-- <hr> -->
                                                </div>
                                            </div>
                                        </div>
                                        <span>
                                            <a href="<?php echo base_url() ?>Dashboard/Released_Documents_view" class="btn btn-xs btn-light fs-10px ps-2 pe-2 px-3"><i class="fa fa-th-list mr-1"></i> See All</a>
                                        </span>
                                    </div>
                                    <hr class="bg-secondary opacity-25" style="opacity: 25%;">
                                    <div class="row text-truncate">
                                        <div class="col-4">
                                            <div class=" ">Released This Year</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $released_year_count ?>"><?php echo $released_year_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                                <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                            </div> -->
                                        </div>
                                        <div class="col-4">
                                            <div class=" ">Released This Month</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $released_month_count ?>"><?php echo $released_month_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                                <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                            </div> -->
                                        </div>
                                        <div class="col-4">
                                            <div class=" ">Released Today</div>
                                            <div class="fs-18px mb-5px font-weight-bold" data-animation="number" data-value="<?php echo $released_today_count ?>"><?php echo $released_today_count ?></div>
                                            <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                                                <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 55%;"></div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light">
                        <div id="released_div" class="col-lg-12 mx-auto m-3 scrollbar rounded" style="height: 350px; background-color: #d7dfe6;">
                            <?php foreach ($released_documents as $row) {
                                // echo $row;
                            ?>
                                <div class="card mb-0 mt-1 bg-white">
                                    <div class="bg-light d-flex justify-content-between align-items-center p-5">
                                        <div class="d-flex flex-column">
                                            <h4><b>Details</b></h4>
                                            <span class="h6 m-0">Document No: <label> <?php echo $row->document_number ?></label></span>
                                            <span class="h6 m-0">Document Type: <label><?php echo $row->doc_type ?></label> </span>
                                            <span class="h6 m-0">Origin Type: <label><?php echo $row->origin_type ?></label> </span>
                                            <span class="h6 m-0">Subject: <label> <?php echo $row->subject ?></label></span>
                                        </div>
                                        <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Released: <?php echo $row->log_date ?></span>
                                    </div>
                                    <!-- <div class="p-5 d-flex justify-content-between align-items-center">
                                        <div class="note-content">
                                            <h4><b>Recipient Office</b></h4>
                                            <div class="d-flex flex-column">
                                                <?php
                                                $get_recipients = $this->db->select("
                                                 CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as recipient_office
                                                 ")
                                                    ->from("document_recipients as dr")
                                                    ->where("added_by_user_id", $row->transacting_user_id)
                                                    ->where("document_number", $row->document_number)
                                                    ->join("lib_office as lo", "lo.OFFICE_CODE = dr.recipient_office_code")
                                                    ->get()->result();

                                                foreach ($get_recipients as $key => $val) {
                                                ?>
                                                    <span class="h6 m-0">• <?php echo $val->recipient_office ?></span>
                                                    <?php } ?>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ================================== Released Modal ============================================ -->
    <div class="modal fade bd-example-modal-lg" id="modal_check_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container pt-5 pb-2">
                    <!-- For demo purpose -->
                    <div class="row text-center text-white">
                        <div class="col-lg-8 mx-auto">
                            <h1 class="display-6">Document Status</h1>
                            <div class="input-group mb-3">

                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>Dashboard/Dashboard_js"></script>