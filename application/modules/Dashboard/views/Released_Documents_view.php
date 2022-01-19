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
// ================Released============================
$released_total_count =  $count_data['released_data']['released_total_count'];
$released_today_count =  $count_data['released_data']['released_today_count'];
$released_month_count =  $count_data['released_data']['released_month_count'];
$released_year_count =  $count_data['released_data']['released_year_count'];

$invalid_release_count = $invalid_data['invalid_release_count'];
?>
<div id="content" class="content">
    <div class="d-flex justify-content-between">
        <h1 class="page-header mb-3">Released Documents</h1>
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Released Document</li>
        </ol>
    </div>
    <div class="row my-4">
        <div class="col-md-8" style="max-height: 200px;">
            <div class=" card border-0 mb-3 overflow-hidden bg-white text-gray">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <div class="mb-3 text-gray-500">
                                <b>TOTAL RELEASED DOCUMENTS</b>
                                <span class="ms-2">
                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of documents Released by your office"></i>
                                </span>
                            </div>
                            <div class="d-flex mb-1">
                                <h2 class="mb-0"><span data-animation="number" data-value="<?php echo $released_total_count ?>"><?php echo $released_total_count ?></span></h2>
                                <div class="ms-auto mt-n1 mb-n1">
                                </div>
                            </div>
                            <!-- <div class="mb-3 text-gray-500">
                                <i class="fa fa-caret-up"></i> <span data-animation="number" data-value="<?php echo $released_year_count ?>"><?php echo $released_year_count ?></span>
                            </div> -->
                            <hr class="bg-secondary opacity-25" style="opacity: 25%;">
                            <div class="row text-truncate">
                                <div class="col-4">
                                    <div class=" text-gray-500">Released This Year</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $released_year_count ?>"><?php echo $released_year_count ?></div>
                                </div>
                                <div class="col-4">
                                    <div class=" text-gray-500">Released This Month</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $released_month_count ?>"><?php echo $released_month_count ?></div>
                                </div>
                                <div class="col-4">
                                    <div class=" text-gray-500">Released Today</div>
                                    <div class="h4 font-weight-bold" data-animation="number" data-value="<?php echo $released_today_count ?>"><?php echo $released_today_count ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 align-items-center d-flex justify-content-center">
                            <img src="<?php echo base_url() ?>assets/img/dashboard/released_modal.svg" height="150px" class="d-none d-lg-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-0 text-truncate mb-3 bg-gray-800 text-gray" style="max-height: 200px;">
                <div class="card-body">
                    <div class="mb-3 text-gray-500">
                        <b class="mb-3">Invalid Logs</b>
                        <span class="ms-2">
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of Released unauthorized documents"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-1">
                        <h2 class="text-gray mb-0">
                            <span data-animation="number" data-value=" <?php echo $invalid_release_count ?>">
                                <?php echo $invalid_release_count ?>
                            </span>
                        </h2>
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
    </div>

    <table id="Released_table" class="table table-bordered align-middle bg-light">
        <thead class="bg-white">
            <tr>
                <th width="1%">Document Number</th>
                <th width="1%">Document Type</th>
                <th width="1%">Origin Type</th>
                <th width="1%">Subject</th>
                <th width="1%">From</th>
                <th width="1%" class="text-center">Status</th>
                <th width="1%">Date Released</th>
                <th width="1%" data-orderable="false">

                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($get_released_documents as $key => $val) {

            ?>
                <tr>
                    <td><?php echo $val->document_number ?></td>
                    <td><?php echo $val->document_type ?></td>
                    <td><?php echo $val->origin_type ?></td>
                    <td><?php echo $val->subject ?></td>
                    <td><?php echo $val->document_origin ?></td>
                    <td class="text-center"><?php if ($val->status == "0") {
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
                    <td><?php echo $val->date ?></td>
                    <td>
                        <a target="_blank" href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class="btn btn-primary">View</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?php echo base_url() ?>Dashboard/Released_js"></script>
<!-- script -->

<script>
    $(document).ready(function() {
        $('#Released_table').DataTable();
    });
</script>