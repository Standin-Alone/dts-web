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
<link href="<?php echo base_url() ?>assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js" charset="utf-8"></script>
<script src="<?php echo base_url() ?>assets/plugins/nvd3/build/nv.d3.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/nvd3/examples/lib/stream_layers.js"></script>

<style>
    svg {
        display: block;
    }

    #test1 {
        height: 343px !important;
        width: 343px !important;
    }


    .nvd3.nv-pie.nv-chart-donut2 .nv-pie-title {
        fill: rgba(70, 107, 168, 0.78);
    }

    .nvd3.nv-pie.nv-chart-donut1 .nv-pie-title {
        opacity: 0.4;
        fill: rgba(224, 116, 76, 0.91);
    }
</style>
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
    <div class="row mb-4">
        <div class="col-md-8" style="max-height: 200px;">
            <div class=" card border-0 mb-3 overflow-hidden bg-white text-gray">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <div class="row d-flex flex-row justify-content-between">
                                <span>
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
                                            <span data-animation="number" data-value=" <?php echo $invalid_release_count ?>">
                                                <?php echo $invalid_release_count ?>
                                            </span>
                                        </h2>
                                    </div>
                                </span>
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
                    <div class="d-lg-flex flex-sm-row align-items-end mb-1 justify-content-between">
                        <div class="col-lg-4 col-md-12 d-lg-flex flex-row align-items-end mb-2">
                            <a href="#" class="btn btn-dark text-truncate" id="daterange-filter">
                                <i class="fa fa-calendar fa-fw text-white text-opacity-50 ms-n1"></i>
                                <span>22 November 2021 - 21 December 2021</span>
                                <b class="caret ms-1 opacity-5"></b>
                            </a>
                        </div>
                        <div class="col-lg-8 col-md-12 d-lg-flex flex-row align-items-end">
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
                                <label for="">Status</label>
                                <select class="form-control ml-2" aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="1">Valid Logs</option>
                                    <option value="0">Invalid Logs</option>
                                </select>
                            </span>
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
                                <label for="">Origin Type</label>
                                <select class="form-control ml-2" aria-label="Default select example">
                                    <option selected>All</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                </select>
                            </span>
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
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
            </div>
        </div>
        <div class="col-sm-4">
            <ul class="mx-0 list-group">
                <li class="list-group-item ">
                    <b class="mt-3">TYPE OF DOCUMENT RELEASED</b>
                    <span class="ms-2">
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Count of documents received by your office"></i>
                    </span>
                    <svg id="test1" width="60%" class="mypiechart mx-auto mt-3"></svg>
                    <?php
                    $color = [
                        "#348fe2",
                        "#f59c1a",
                        "#727cb6",
                        "#ffd900",
                        "#ff5b57",
                        "#fb5597",
                        "#00acac",
                        "#32a932",
                        "#90ca4b",
                        "#8753de",
                        "#49b6d6",
                    ];
                    if ($get_origin_type_data_release) {
                    ?>

                        <div class="d-flex mb-1 mt-0">
                            <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Documents released inside DA"><i style="color: #348fe2;" class="fa fa-square mr-2"></i> <?php echo $get_origin_type_data_release[0]->origin_type ?></span>
                            <span class="h5 my-0 font-weight-bold"><?php echo $get_origin_type_data_release[0]->origin_type_count ?></span>
                        </div>
                    <?php }
                    if (count($get_origin_type_data_release) > 1) {
                    ?>
                        <!-- <hr class="bg-secondary my-1 opacity-25" style="opacity: 25%;"> -->
                        <div class="d-flex mt-1">
                            <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Documents released outside DA"><i style="color: #f59c1a;" class="fa fa-square mr-2"></i> <?php echo $get_origin_type_data_release[1]->origin_type ?></span>
                            <span class="h5 my-0 font-weight-bold"><?php echo $get_origin_type_data_release[1]->origin_type_count ?></span>
                        </div>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
    <span class="my-5">&nbsp;</span>
    <table id="release_table" class="table table-bordered align-middle bg-light table-responsive mt-2">
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
            <?php foreach ($get_released_documents as $key => $val) {

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
<script src="<?php echo base_url() ?>Dashboard/Released_js"></script>
<!-- script -->

<script>
    $(document).ready(function() {
        $('#release_table').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        let doc_type_data = [];

        $.ajax({
            type: "get",
            url: base_url + "Dashboard/get_origin_type_data_release",
            dataType: "json",
            async: false,
            success: function(response) {
                doc_type_data = response
            }
        });

        var color = [
            "#348fe2",
            "#f59c1a",
            "#727cb6",
            "#ffd900",
            "#ff5b57",
            "#fb5597",
            "#00acac",
            "#32a932",
            "#90ca4b",
            "#8753de",
            "#49b6d6",
        ]


        let total = [];
        $.map(doc_type_data, function(data, i) {
            total.push({
                type: data.origin_type,
                type_count: data.type_count,
                color: color[i]
            })
        });

        var height = 320;
        var width = 320;

        var chart1;
        nv.addGraph(function() {
            var chart1 = nv.models.pieChart()
                .x(function(d) {
                    return d.origin_type
                })
                .y(function(d) {
                    return d.origin_type_count
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
                .donutRatio(0.5)
                .id('donut1') // allow custom CSS for this one svg
                .color(color)
                // chart1.legendPosition("down")
                .growOnHover(true)
                .labelType("percent")
            chart1.pie.donut(true);

            d3.select("#test1")
                .datum(doc_type_data)
                .transition().duration(1200)
                .call(chart1);



            d3.selectAll('.nv-label text')
                .each(function(d, i) {
                    d3.select(this).style('fill', '#ffff')
                    // d3.select(this).style('font-weight', 700)
                    d3.select(this).style('font-size', 9)
                })


            d3.selectAll('.nv-legend .nv-series text')
                .each(function(d, i) {
                    d3.select(this).style('fill', '#6c757d')
                    d3.select(this).style('font-weight', 100)
                    // d3.select(this).style('font-size', 16)
                });
            return chart1;

        });
    });
</script>