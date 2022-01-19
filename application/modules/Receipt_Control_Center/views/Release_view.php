<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- ================== BEGIN ADDITIONALS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ================== END ADDITIONALS STYLE ================== -->


<!-- ================== BEGIN ADDITIONALS JS ================== -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<!-- ================== END ADDITIONALS JS ================== -->

<?php
$released_total_count =  $count_data['released_data']['released_total_count'];
$released_today_count =  $count_data['released_data']['released_today_count'];
$released_month_count =  $count_data['released_data']['released_month_count'];
$released_year_count =  $count_data['released_data']['released_year_count'];

$invalid_release_count = $invalid_data['invalid_release_count'];

?>
<div id="content" class="content">

    <!-- <div class="d-flex justify-content-between">
        <h1 class="page-header">Timeline <small>header small text goes here...</small></h1>
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">Extra</a></li>
            <li class="breadcrumb-item active">Timeline</li>
        </ol>
    </div> -->
    <div class="row">
        <div class="col-md-9">
            <div class=" card border-0 mb-3 overflow-hidden bg-white text-gray">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <div class="row d-flex flex-row justify-content-between">
                                <span>
                                    <div class="mb-3 text-gray-500">
                                        <b>TOTAL RELEASED DOCUMENT</b>
                                        <span class="ms-2">
                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of documents released by your office"></i>
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
                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Count of released unauthorized documents"></i>
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
                            <img src="<?php echo base_url() ?>assets/img/dashboard/received_modal.svg" height="150px" class="d-none d-lg-block">
                        </div>
                    </div>
                </div>
            </div>
            <table id="Released_table" class="table table-bordered align-middle bg-light">
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
        <div class="col-md-3 mx-auto">
            <div class="card">
                <!-- <div class="card-header">
                </div> -->
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 mx-auto mb-3">
                            <div class="col mb-2">
                                <img src="<?php echo base_url() ?>assets/img/released_banner.svg" alt="receive document" width="50%" class="mx-auto d-block">
                            </div>
                            <h3 class="mx-auto text-center mb-2">Release Document</h3>
                            <form id="form_release" class="form-horizontal" data-parsley-validate="true" name="demo-form" novalidate="">
                                <!-- <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Title</label>
                                        <input name="title" id="title" type="text" class="form-control" placeholder="Title" />
                                    </div>
                                </div> -->
                                <div class="row">
                                    <?php if ($this->uri->segment('3')) {
                                        $document_number = $this->uri->segment('3');
                                        $document_details = $this->db->select("
                                                        dp.subject,
                                                        dt.type,
                                                        dp.office_code,
                                                        dp.created_by_user_fullname, 
                                                        CONCAT(INFO_SERVICE, ' - ', INFO_DIVISION) as office,
                                                        dp.date_created
                                                        ")
                                            ->from('document_profile as dp')
                                            ->join('lib_office as lo', 'lo.office_code = dp.office_code')
                                            ->join('doc_type as dt', 'dt.type_id = dp.document_type')
                                            ->where('dp.document_number', $document_number)
                                            ->get()->result();
                                    ?>
                                        <div class="col note note-secondary mb-2">
                                            <div class="note-icon"><i class="fa fa-file-alt"></i></div>
                                            <div class="note-content">
                                                <h4><b>Document Details</b></h4>
                                                <span class="d-flex flex-row align-items-end justify-content-between">
                                                    <span class="d-flex flex-row">
                                                        Type: &nbsp;
                                                        <h6 id="type" class="mb-0 align-self-end"><?php echo $document_details[0]->type; ?></h6>
                                                    </span>
                                                    <!-- <span class="d-flex flex-row">Date Profiled: <h6 class="ml-2"><?php echo $document_details[0]->date_created ?></h6></span> -->
                                                </span>
                                                <span class="d-flex flex-row align-items-end">
                                                    Subject: &nbsp;
                                                    <h6 id="subject" class="mb-0"><?php echo $document_details[0]->subject; ?></h6>
                                                </span>
                                                <span class="d-flex flex-row align-items-end">
                                                    Document Origin: &nbsp;
                                                    <h6 id="origin" class="mb-0 align-self-end"> <?php echo $document_details[0]->office; ?></h6>
                                                </span>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 text-center">
                                        <label class="">Document Number</label>
                                        <input name="document_no" id="document_no" type="text" class="form-control" value="<?php if ($this->uri->segment('3')) {
                                                                                                                                echo $this->uri->segment('3');
                                                                                                                            } ?>" placeholder="Document Number" />
                                    </div>
                                </div>
                                <div hidden class="row mb-2">
                                    <div class="col-md-12 text-center">
                                        <label class="">Originating Office</label>
                                        <input name="originating_office" id="originating_office" type="text" class="form-control" placeholder="Originating Office" />
                                        <input hidden name="originating_office_code" id="originating_office_code" type="text" class="form-control" placeholder="Originating Office" />
                                    </div>
                                </div>
                                <div hidden class="row mb-2">
                                    <div class="col-md-12 text-center">
                                        <label class="text-center">Current Office</label>
                                        <input name="current_office" id="current_office" type="text" class="form-control" placeholder="" />
                                        <input hidden name="current_office_code" id="current_office_code" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 text-center">
                                        <label class="text-center">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 text-center">
                                        <label class="">Action</label>
                                        <select name="action" id="action" class="form-control">
                                            <option selected value="No Action">No Action</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Disapproved">Disapproved</option>
                                            <option value="Endorse">Endorse</option>
                                            <option value="Received">Received</option>
                                            <option value="Return to Sender">Return to Sender</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 col-lg-11">
                                        <div class="col text-center">
                                            <label class="">Recipients</label>
                                        </div>
                                        <select class="multiple-select2 form-control" multiple="multiple" id="recipients" name="recipients[]">
                                            <?php
                                            foreach ($recipients as $row) {
                                                echo '<option value="' . $row->OFFICE_CODE . '">' . strtoupper(($row->SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '') . $row->ORIG_SHORTNAME . ' / ' . ($row->INFO_DIVISION == '' ? $row->INFO_SERVICE : $row->INFO_SERVICE . ' / ' . $row->INFO_DIVISION)) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <!-- <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <label class="">Files</label>
                                    <form action="<?php echo base_url() ?>/Receipt_Control_Center/upload_file" class="dropzone">
                                        <div class="fallback">
                                            <input name="attachment" type="file" multiple />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <label class="">Attachments</label>

                                    <form action="<?php echo base_url() ?>/Receipt_Control_Center/upload_file" class="dropzone">
                                        <div class="fallback">
                                            <input name="attachment" type="file" multiple />
                                        </div>
                                    </form>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12 mx-auto ">
                                    <button id="release_btn" type="button" class="btn btn-primary btn btn-block">Release</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col bg-light rounded-top border-bottom">
                <h4 class="page-header mt-4 d-flex flex-column text-center">
                    <i class="fa fa-mail-bulk fa-2x mt-2"></i>
                    <span>
                        For Releasing Documents
                    </span>
                    <small>Select a document you want to release</small>
                </h4>
            </div>
            <div class="col-md-12 <?php echo $class = !empty($received_documents) ? 'scrollbar' : ''; ?>" style="height: 400px; background-color: #c6ced5;">
                <div class="list-group list-group-flush rounded-bottom overflow-hidden panel-body p-0">
                    <?php

                    if ($received_documents) {
                        foreach ($received_documents as $row) {
                    ?>
                            <a href="<?php echo base_url() . "/Receipt_Control_Center/Release/" . $row->document_number ?>" style="text-decoration: none;" <?php echo $disabled = $row->action == "Released" ? "disabled" : ""; ?>>
                                <div class="col list-group-item list-group-item-action border-bottom bg-white">
                                    <div class="d-flex flex-column">
                                        <div>
                                            <div class="d-flex flex-column">
                                                <h5 class="mb-1 <?php if (isset($document_number)) {
                                                                    echo $class = $document_number ==  $row->document_number ? "text-primary" : "";
                                                                } ?>">
                                                    <?php echo $row->document_number ?>
                                                </h5>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <hr class="m-0">
                                                From:
                                                <h4 class="ml-0">
                                                    <small class="m-0"><?php echo $row->office ?></small>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php }
                    } else { ?>
                        <div class="text-center mt-5">
                            <span class="h4 text-dark mb-2 text-center mx-auto">No new transaction</span>
                            <img src="<?php echo base_url() ?>/assets/img/dashboard/no_records.svg" height="100" class="d-none d-lg-block mx-auto">
                        </div>
                </div>
            <?php } ?>
            </div>
            <button class="btn btn-primary btn-block">View All</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>Receipt_Control_Center/Release_js"></script>
<script>
    $(document).ready(function() {
        $('#Released_table').DataTable();
    });
</script>