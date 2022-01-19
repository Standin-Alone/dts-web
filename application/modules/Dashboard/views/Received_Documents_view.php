<!-- <link href="<?php echo base_url() ?>assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />

<script src="<?php echo base_url() ?>assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jszip/dist/jszip.min.js"></script> -->
<!-- html -->

<?php
// ================Received============================
$received_total_count =  $count_data['received_data']['received_total_count'];
$received_today_count =  $count_data['received_data']['received_today_count'];
$received_month_count =  $count_data['received_data']['received_month_count'];
$received_year_count =  $count_data['received_data']['received_year_count'];

$invalid_receive_count = $invalid_data['invalid_receive_count'];

?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
<div id="content" class="content">
    <div class="d-flex justify-content-between">
        <h1 class="page-header mb-3">Received Documents</h1>
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Received Document</li>
        </ol>
    </div>
    <div class="row my-4">
        <div class="col-md-8">
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

        </div>

        <div class="col-sm-4">


        </div>
        <div class="col-md-12">
            <div class="card border-0 text-truncate mb-3 bg-gray-800 text-gray">
                <div class="card-body">
                    <div class="mb-3 text-gray-500">
                        <b class="mb-3">Reports</b>
                        <!-- <span class="ms-2">
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of received unauthorized documents"></i>
                        </span> -->
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="btn-group ml-3" role="group" aria-label="Basic example">
                            <button class="btn btn-danger"><i class="fa fa-file-pdf mr-1"></i> PDF</button>
                            <button class="btn btn-success"><i class="fa fa-file-csv mr-1"></i> CSV</button>
                            <button class="btn btn-primary"><i class="fa fa-file-word mr-1"></i> WORD</button>
                        </div>
                        <button class="btn btn-warning"><i class="fa fa-print mr-1"></i> Generate Report</button>
                    </div>
                    <hr class="bg-secondary opacity-25" style="opacity: 25%;">
                    <div class="mb-3 text-gray-500">
                        <b class="mb-3">Filters</b>
                        <!-- <span class="ms-2">
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of received unauthorized documents"></i>
                        </span> -->
                    </div>
                    <div class="d-flex flex-row align-items-end mb-1">
                        <div class="col d-sm-flex flex-row align-items-end">
                            <a href="#" class="btn btn-dark me-2 text-truncate" id="daterange-filter">
                                <i class="fa fa-calendar fa-fw text-white text-opacity-50 ms-n1"></i>
                                <span>22 November 2021 - 21 December 2021</span>
                                <b class="caret ms-1 opacity-5"></b>
                            </a>
                        </div>
                        <div class="d-flex flex-row align-items-end">
                            <span class="d-flex flex-row mx-2">
                                <label for="">Status</label>
                                <select class="form-control ml-2" aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="1">Valid Logs</option>
                                    <option value="0">Invalid Logs</option>
                                </select>
                            </span>
                            <span class="d-flex flex-row mx-2">
                                <label for="">Origin Type</label>
                                <select class="form-control ml-2" aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                </select>
                            </span>
                            <span class="d-flex flex-row mx-2">
                                <label for="">Document Type</label>
                                <select class="form-control ml-2" aria-label="Default select example">
                                    <option value="" selected>All</option>
                                    <?php
                                    foreach ($document_type as $val) {
                                    ?>
                                        <option value="<?php echo $val->type_id ?>"> <?php echo $val->type ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                            <!-- <div class="text-gray-600 fw-bold mt-2 mt-sm-0">compared to <span id="daterange-prev-date">24 October - 21 November 2021</span></div> -->
                        </div>
                    </div>
                </div>
                <!-- <div class="mb-4 text-gray-500 ">
                        <i class="fa fa-caret-down"></i> <span data-animation="number" data-value="0.50">0.50</span>% compare to last week
                    </div> -->
                <!-- <div class="d-flex mb-2">
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
                    </div> -->
            </div>
        </div>
    </div>

    <table id="received_table" class="table table-bordered align-middle bg-light">
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
                                <button class="dropdown-item d-flex justify-content-between align-items-center text-secondary" type="button"><i class="fa fa-search-location"></i> Document Logs</button>
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
<script src="<?php echo base_url() ?>Dashboard/Received_js"></script>
<!-- script -->

<script>
    $(document).ready(function() {
        $('#received_table').DataTable();
    });
</script>