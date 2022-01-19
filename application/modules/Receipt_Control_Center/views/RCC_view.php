
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
            <div class="card mb-4">
                <!-- <div class="card-header">

                </div> -->
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-center pt-3">
                        <div class="col-lg-12 mx-auto my-3">
                            <h3 class="mx-auto text-center">Received Document </h3>
                            <form id="form_receive" class="form-horizontal" data-parsley-validate="true" name="demo-form" novalidate="">
                                <div class="col-md-6 form-group mx-auto my-3">
                                    <input class="form-control" type="text" name="document_number" id="document_number" placeholder="Document Number" data-parsley-required="true">
                                    <span class="error text-danger text-xxs text-center mx-auto"></span>
                                    <input name="office_code" id="office_code" type="text" class="form-control" value="<?php echo $this->session->userdata('office_code') ?>" hidden />
                                    <input name="full_name" id="full_name" type="text" class="form-control" value="<?php echo $this->session->userdata('full_name') ?>" hidden />
                                    <input name="service" id="service" type="text" class="form-control" value="<?php echo $this->session->userdata('info_service') ?>" hidden />
                                    <input name="division" id="division" type="text" class="form-control" value="<?php echo $this->session->userdata('info_division') ?>" hidden />
                                    <label id="document_number-error" class="error text-danger invalid-feedback" style="font-size: 12px;" for="document_number">This field is required.</label>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Receive</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <!-- <div class="card-header">

                </div> -->
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-center pt-3">
                        <form id="form_release" class="form-horizontal" data-parsley-validate="true" name="demo-form" novalidate="">
                            <div class="col-md-12 mx-auto my-3">
                                <h3 class="mx-auto text-center mb-4">Release Document</h3>
                                <div class="row mb-3">
                                    <h5 class="form-label col-md-3">Title</h5>
                                    <div class="col-md-6">
                                        <input name="title" id="title" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h5 class="form-label col-form-label col-md-3">Document Number</h5>
                                    <div class="col-md-6">
                                        <input name="document_no" id="document_no" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h5 class="form-label col-form-label col-md-3">Originating Office</h5>
                                    <div class="col-md-6">
                                        <input name="originating_office" id="originating_office" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h5 class="form-label col-form-label col-md-3">Current Office</h5>
                                    <div class="col-md-6">
                                        <input name="current_office" id="current_office" type="text" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h5 class="form-label col-form-label col-md-3">Action</h5>
                                    <div class="col-md-6">
                                        <select class="form-select">
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
                                    <h5 class="form-label col-form-label col-md-3">Files</h5>
                                    <div class="col-md-6">
                                        <div id="dropzone">
                                            <form action="/upload" class="dropzone needsclick" id="attachment">
                                                <div class="dz-message needsclick">
                                                    Drop files <b>here</b> or <b>click</b> to upload.<br />
                                                    <!-- <span class="dz-note needsclick">
                                                    (This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)
                                                </span> -->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h5 class="form-label col-form-label col-md-3">Attachments</h5>
                                    <div class="col-md-6">
                                        <div id="dropzone">
                                            <form action="/upload" class="dropzone needsclick" id="attachment">
                                                <div class="dz-message needsclick">
                                                    Drop files <b>here</b> or <b>click</b> to upload.<br />
                                                    <!-- <span class="dz-note needsclick">
                                                    (This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)
                                                </span> -->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6 mx-auto my-3">
                                        <button type="button" class="btn btn-primary btn-lg btn-block mt-3">Release</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>Receipt_Control_Center/RCC_js"></script>