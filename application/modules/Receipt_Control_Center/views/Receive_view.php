<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

<!-- ================== BEGIN ADDITIONALS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ================== END ADDITIONALS STYLE ================== -->


<!-- ================== BEGIN ADDITIONALS JS ================== -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<!-- ================== END ADDITIONALS JS ================== -->
<style>
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
// ================Received============================
$received_total_count =  $count_data['received_data']['received_total_count'];
$received_today_count =  $count_data['received_data']['received_today_count'];
$received_month_count =  $count_data['received_data']['received_month_count'];
$received_year_count =  $count_data['received_data']['received_year_count'];

$invalid_receive_count = $invalid_data['invalid_receive_count'];
?>
<!-- <div class="d-flex justify-content-between">
        <h1 class="page-header">Timeline <small>header small text goes here...</small></h1>
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">Extra</a></li>
            <li class="breadcrumb-item active">Timeline</li>
        </ol>
    </div> -->
<div id="content" class="content">
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
                                <!-- <li class="timeline-item bg-white rounded ml-3 p-4 shadow-sm">
                                    <div class="timeline-arrow"></div>
                                    <div class="d-flex flex-column p-4">
                                        <div class="d-flex flex-column">
                                            <div>
                                                <span class=" badge badge-lg badge-success">
                                                    <h2 class="h5 mb-0">Received</h2>
                                                </span>
                                            </div>
                                            <span class="small text-gray mt-2"><i class="fa fa-clock-o mr-1"></i>21 March, 2019</span>
                                        </div>
                                        <span class="d-flex flex-row mt-2">
                                            Received By: <h5 class=" ml-2"> Information Communications Technology Service</h5>
                                        </span>
                                        <span class="d-flex flex-row">
                                            Assigned Personnel: <h5 class=" ml-2"> Ling Hayabusa</h5>
                                        </span>
                                    </div>
                                    <div class="p-4">
                                        <label>Remarks</label>
                                        <p class="text-small mt-2 font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, et elementum lorem ornare. Maecenas placerat facilisis mollis. Duis sagittis ligula in sodales vehicula....</p>
                                    </div>
                                </li> -->
                            </ul><!-- End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <h1 class="page-header mb-3">Received Documents</h1>
        <!-- <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Received Document</li>
        </ol> -->
    </div>
    <div class="row my-4">
        <div class="col-md-9" style="max-height: 200px;">
            <div class=" card border-0 mb-3 overflow-hidden bg-white text-gray">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <div class="row d-flex flex-row justify-content-between">
                                <span>
                                    <div class="mb-3 text-gray-500">
                                        <b>TOTAL RECEIVED DOCUMENT</b>
                                        <span class="ms-2">
                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of documents received by your office"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex mb-1">
                                        <h2 class="mb-0"><span data-animation="number" data-value="<?php echo $received_total_count ?>"><?php echo $received_total_count ?></span></h2>
                                        <div class="ms-auto mt-n1 mb-n1">
                                        </div>
                                    </div>
                                </span>
                                <span>
                                    <div class="mb-3 text-gray-500">
                                        <b class="mb-3">Invalid Logs</b>
                                        <span class="ms-2">
                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of received unauthorized documents"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <h2 class="text-danger mb-0">
                                            <span data-animation="number" data-value=" <?php echo $invalid_receive_count ?>">
                                                <?php echo $invalid_receive_count ?>
                                            </span>
                                        </h2>
                                    </div>
                                </span>
                            </div>
                            <!-- <div class="mb-3 text-gray-500">
                                <i class="fa fa-caret-up"></i> <span data-animation="number" data-value="<?php echo $received_year_count ?>"><?php echo $received_year_count ?></span>
                            </div> -->
                            <hr class="bg-secondary opacity-25" style="opacity: 25%;">
                            <div class="row text-truncate">
                                <div class="col-4">
                                    <div class=" text-gray-500">Received This Year</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $received_year_count ?>"><?php echo $received_year_count ?></div>
                                </div>
                                <div class="col-4">
                                    <div class=" text-gray-500">Received This Month</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $received_month_count ?>"><?php echo $received_month_count ?></div>
                                </div>
                                <div class="col-4">
                                    <div class=" text-gray-500">Received Today</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $received_today_count ?>"><?php echo $received_today_count ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 align-items-center d-flex justify-content-center">
                            <img src="<?php echo base_url() ?>assets/img/dashboard/received_modal.svg" height="150px" class="d-none d-lg-block">
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card border-0 text-truncate mb-3 bg-gray-800 text-gray" style="max-height: 200px;">
                <div class="card-body">
                    <div class="mb-3 text-gray-500">
                        <b class="mb-3">Invalid Logs</b>
                        <span class="ms-2">
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of received unauthorized documents"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-1">
                        <h2 class="text-gray mb-0">
                            <span data-animation="number" data-value=" <?php echo $invalid_receive_count ?>">
                                <?php echo $invalid_receive_count ?>
                            </span>
                        </h2>
                    </div>
                    <div class="mb-4 text-gray-500 ">
                        <i class="fa fa-caret-down"></i> <span data-animation="number" data-value="0.50">0.50</span>% compare to last week
                    </div>
                    <div class="d-flex mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-circle text-red fs-8px me-2"></i>
                            Added to cart
                        </div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="text-gray-500 small"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="262">262</span>%</div>
                            <div class="w-50px text-end ps-2 fw-bold"><span data-animation="number" data-value="3.79">3.79</span>%</div>
                        </div>
                    </div>
                    <div class="d-flex mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-circle text-warning fs-8px me-2"></i>
                            Reached checkout
                        </div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="text-gray-500 small"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="11">11</span>%</div>
                            <div class="w-50px text-end ps-2 fw-bold"><span data-animation="number" data-value="3.85">3.85</span>%</div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-circle text-lime fs-8px me-2"></i>
                            Sessions converted
                        </div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="text-gray-500 small"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="57">57</span>%</div>
                            <div class="w-50px text-end ps-2 fw-bold"><span data-animation="number" data-value="2.19">2.19</span>%</div>
                        </div>
                    </div>
                </div>
            </div> -->


            <table id="received_table" class="table table-responsive-sm table-bordered align-middle bg-light mx-auto">
                <thead class="bg-white">
                    <tr>
                        <th width="10%">Document Number</th>
                        <th width="5%">Document Type</th>
                        <th width="1%">Origin Type</th>
                        <th width="10%">Subject</th>
                        <th width="20%">From</th>
                        <th width="1%">Status</th>
                        <th width="5%">Date Received</th>
                        <th width="1%" data-orderable="false">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($get_received_documents as $key => $val) {
                    ?>
                        <tr>
                            <td><?php echo $val->document_number ?></td>
                            <td><?php echo $val->document_type ?></td>
                            <td><?php echo $val->origin_type ?></td>
                            <td><?php echo $val->subject ?></td>
                            <td><?php echo $val->document_origin ?></td>
                            <td class="text-center align-middle"><?php if ($val->status == "0") {
                                                                        echo "
                                        <h5>
                                        <span class=' badge badge-danger'>
                                        Invalid Log
                                        </span>
                                        </h5>
                                        ";
                                                                    } else {
                                                                        echo "
                                        <h5>
                                        <span class=' badge badge-success'>
                                        Valid Log
                                            </span>
                                            </h5>
                                            ";
                                                                    }
                                                                    ?></td>
                            <td><?php echo $val->log_date ?></td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" caret="false">
                                        <i class="fa fa-sliders-h"></i> More
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a target="_blank" href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class=" dropdown-item d-flex justify-content-between align-items-center text-secondary"> <i class="fa fa-file-alt"></i> View Document</a>
                                        <button class="dropdown-item d-flex justify-content-between align-items-center text-secondary track_btn" type="button"><i class="fa fa-search-location"></i> Track Document</button>
                                        <!-- <button class="dropdown-item" type="button">Another action</button>
                                                <button class="dropdown-item" type="button">Something else here</button> -->
                                    </div>
                                </div>
                                <!-- <a href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class="btn btn-success">Track</a>
                                        <a target="_blank" href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class="btn btn-primary">View</a> -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-center pt-3">
                        <div class="col-lg-12 mx-auto mb-3">
                            <div class="col mb-2">
                                <img src="<?php echo base_url() ?>assets/img/received_banner.svg" alt="receive document" width="50%" class="mx-auto d-block">
                            </div>
                            <h3 class="mx-auto text-center">Receive Document </h3>
                            <form id="form_receive" class="form-horizontal" data-parsley-validate="true" name="demo-form" novalidate="">
                                <input class="form-control" type="text" name="document_number" id="document_number" placeholder="Document Number" value="<?php if ($this->uri->segment('3')) {
                                                                                                                                                                echo $this->uri->segment('3');
                                                                                                                                                            } ?>" data-parsley-required="true">
                                <span class="error text-danger text-xxs text-center mx-auto"></span>
                                <input name="office_code" id="office_code" type="text" class="form-control" value="<?php echo $this->session->userdata('office_code') ?>" hidden />
                                <input name="full_name" id="full_name" type="text" class="form-control" value="<?php echo $this->session->userdata('full_name') ?>" hidden />
                                <input name="service" id="service" type="text" class="form-control" value="<?php echo $this->session->userdata('info_service') ?>" hidden />
                                <input name="division" id="division" type="text" class="form-control" value="<?php echo $this->session->userdata('info_division') ?>" hidden />
                                <label id="document_number-error" class="error text-danger invalid-feedback" style="font-size: 12px;" for="document_number">This field is required.</label>
                                <button id="receive_btn" type="submit" class="btn btn-primary btn btn-block mt-3">
                                    Receive
                                </button>
                                <div class="spinner-border" role="status">
                                    <span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none;"></span>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col rounded border-1 border-dark">
                    <div class="row">
                        <div class="col bg-light rounded-top border-bottom">
                            <h4 class="page-header mt-4 d-flex flex-column text-center">
                                <i class="fa fa-mail-bulk fa-2x"></i>
                                <span>
                                    To Receive
                                </span>
                                <small>Select a document you want to received</small>
                            </h4>
                        </div>
                        <div class="col-md-12 scrollbar" style="height: 400px; background-color: #c6ced5;">
                            <div class="list-group list-group-flush rounded-bottom overflow-hidden panel-body p-0">
                                <?php
                                // print_r($incoming_documents);
                                if ($incoming_documents) {
                                    foreach ($incoming_documents as $value) {
                                ?>
                                        <a href="<?php echo base_url() . "/Receipt_Control_Center/Receive/" . $value->document_number ?>" style="text-decoration: none;">
                                            <div class="col list-group-item list-group-item-action border-bottom bg-white">
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <div class="d-flex flex-column">
                                                            <h5 class="mb-1 <?php if (isset($document_number)) {
                                                                                echo $class = $document_number ==  $value->document_number ? "text-primary" : "";
                                                                            } ?>">
                                                                <?php echo $value->document_number ?>
                                                            </h5>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <hr class="m-0">
                                                            From:
                                                            <h4 class="ml-0">
                                                                <small class="m-0"><?php echo $value->from_office ?></small>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php }
                                } else { ?>
                                    <div class="col-md-12 d-flex flex-column justify-content-between">
                                        <div class="text-center mt-5">
                                            <span class="h4 text-dark mb-2 text-center mx-auto">No new transaction found</span>
                                            <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                                        </div>
                                    </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block">View All</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fae bd-example-modal-lg show" id="loading_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="spin-wrapper">
                    <div class="spinner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url() ?>Dashboard/Received_js"></script>
<!-- script -->

<script>
    document.body.style.zoom = "90%"
    $(document).ready(function() {
        $('#received_table').DataTable();

        $("input, textarea").focusout(function() {
            $('meta[name=viewport]').remove();
            $('head').append('<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=0">');

            $('meta[name=viewport]').remove();
            $('head').append('<meta name="viewport" content="width=device-width, initial-scale=yes">');
        });
    });
</script>


<script src="<?php echo base_url() ?>Receipt_Control_Center/RCC_js"></script>