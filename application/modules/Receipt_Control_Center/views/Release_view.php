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
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <!-- <div class="card-header">
                </div> -->
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-md-8 mx-auto mb-3">
                            <div class="col mb-2">
                                <img src="<?php echo base_url() ?>assets/img/released_banner.svg" alt="receive document" width="50%" class="mx-auto d-block">
                            </div>
                            <h3 class="mx-auto text-center mb-4">Release Document</h3>
                            <form id="form_release" class="form-horizontal" data-parsley-validate="true" name="demo-form" novalidate="">
                                <!-- <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Title</label>
                                        <input name="title" id="title" type="text" class="form-control" placeholder="Title" />
                                    </div>
                                </div> -->
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Document Number</label>
                                        <input name="document_no" id="document_no" type="text" class="form-control" placeholder="Document Number" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Originating Office</label>
                                        <input name="originating_office" id="originating_office" type="text" class="form-control" placeholder="Originating Office" />
                                        <input hidden name="originating_office_code" id="originating_office_code" type="text" class="form-control" placeholder="Originating Office" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="text-center">Current Office</label>
                                        <input name="current_office" id="current_office" type="text" class="form-control" placeholder="" />
                                        <input hidden name="current_office_code" id="current_office_code" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="text-center">Current Office</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Action</label>
                                        <select class="form-control">
                                            <option selected disabled>Select</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Disapproved">Disapproved</option>
                                            <option value="Endorse">Endorse</option>
                                            <option value="Received">Received</option>
                                            <option value="Return to Sender">Return to Sender</option>
                                            <option value="No Action">No Action</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <label class="">Recipients</label>
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
                            <div class="row mb-3">
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
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-12 mx-auto my-3">
                                    <button type="button" class="btn btn-primary btn-lg btn-block mt-3">Release</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>Receipt_Control_Center/Release_js"></script>