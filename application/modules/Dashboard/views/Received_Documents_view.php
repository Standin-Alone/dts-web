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

    .dt-buttons{
        display: none;
    }

    .dt-button{
            background-color: #00c3ff !important;
            color: #fff !important;
            font-size: 14px !important;
            border-radius: 5px !important;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            padding-left: 20px !important;
            padding-right: 20px !important;
            width: 107px;
            height: 32px;
        }

        .buttons-print{
            background-color: #12abda !important;
            color: #fff !important;
        }
        .buttons-excel{
            background-color: #0cb458 !important;
            color: #fff !important;
        }
        .buttons-csv{
            background-color: #0cb458 !important;
            color: #fff !important;
        }
        .buttons-pdf{
            background-color: #e42535 !important;
            color: #fff !important;
        }
</style>

<div id="content" class="content">
    <div class="d-flex justify-content-between">
    </div>
    <h1 class="page-header mb-3">Received Documents</h1>
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Received Document</li>
    </ol>
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
                            <button class="btn btn-warning" id="btn_print"><i class="fas fa-print mr-1"></i> Print</button>
                            <button class="btn btn-danger" id="btn_pdf"><i class="fa fa-file-pdf mr-1"></i> PDF</button>
                            <button class="btn btn-success" id="btn_csv"><i class="fa fa-file-csv mr-1"></i> CSV</button>
                            <button class="btn btn-primary" id="btn_excel"><i class="fa fa-file-excel mr-1"></i> Excel</button>
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
                            <!-- <a href="#" class="btn btn-dark text-truncate" id="daterange-filter">
                                <i class="fa fa-calendar fa-fw text-white text-opacity-50 ms-n1"></i>
                                <span>22 November 2021 - 21 December 2021</span>
                                <b class="caret ms-1 opacity-5"></b>
                            </a> -->
                            <div id="reportrange" class="rounded border form-control ml-2" style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span data-column="6" id="date_range"></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        
                        <div class="col-lg-8 col-md-12 d-lg-flex flex-row align-items-end">
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
                                <label for="">Status</label>
                                <select name="status" id="status" data-column="8" class="form-control ml-2 filter-select" aria-label="Default select example">
                                    <option value="" selected>All</option>
                                    <option value="1">Valid Logs</option>
                                    <option value="0">Invalid Logs</option>
                                </select>
                            </span>
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
                                <label for="">Origin Type</label>
                                <select name="origin_type" id="origin_type" data-column="2" class="form-control ml-2 filter-select" aria-label="Default select example">
                                    <option value="" selected>All</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                </select>
                            </span>
                            <span class="d-lg-flex flex-lg-row mx-sm-2 my-sm-2">
                                <label for="">Document Type</label>
                                <select name="document_type" id="document_type" data-column="1" class="form-control ml-2 filter-select" aria-label="Default select example">
                                    <option value="" selected>All</option>
                                    <?php
                                    foreach ($document_type as $val) {
                                    ?>
                                        <option value="<?php echo $val->type ?>"> <?php echo $val->type ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                            <!-- <div class="text-gray-600 fw-bold mt-2 mt-sm-0">compared to <span id="daterange-prev-date">24 October - 21 November 2021</span></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-0 col-sm-4">
            <ul class="mx-0 list-group">
                <li class="list-group-item ">
                    <b class="mt-3">TYPE OF DOCUMENT RECEIVED</b>
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
                    if ($get_origin_type_data) {
                    ?>
                        <div class="d-flex mb-1 mt-0">
                            <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Documents received inside DA"><i style="color: #348fe2;" class="fa fa-square mr-2"></i> <?php echo $get_origin_type_data[0]->origin_type ?></span>
                            <span class="h5 my-0 font-weight-bold"><?php echo $get_origin_type_data[0]->origin_type_count ?></span>
                        </div>
                    <?php }
                    if (count($get_origin_type_data) > 1) {
                    ?>
                        <!-- <hr class="bg-secondary my-1 opacity-25" style="opacity: 25%;"> -->
                        <div class="d-flex mt-1">
                            <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Documents received outside DA"><i style="color: #f59c1a;" class="fa fa-square mr-2"></i> <?php echo $get_origin_type_data[1]->origin_type ?></span>
                            <span class="h5 my-0 font-weight-bold"><?php echo $get_origin_type_data[1]->origin_type_count ?></span>
                        </div>
                    <?php } ?>
                </li>
            </ul>

        </div>
    </div>
    <table id="received_table" class="table table-bordered align-middle bg-light table-responsive">
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
        </tbody>
    </table>
<!-- ========================================================== -->
    

<script type="text/javascript">
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')).trigger('change');
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
</script>
<!-- ============================================================================ -->
</div>
<script src="<?php echo base_url() ?>Dashboard/Received_js"></script>
<script>
    $(document).ready(function() {
        let doc_type_data = [];

        $.ajax({
            type: "get",
            url: base_url + "Dashboard/get_origin_type_data",
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