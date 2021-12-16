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
            <div class="card mb-4">
                <!-- <div class="card-header">

                </div> -->
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-center pt-3">
                        <div class="col-lg-12 mx-auto mb-3">
                            <div class="col mb-2">
                                <img src="<?php echo base_url() ?>assets/img/received_banner.svg" alt="receive document" width="50%" class="mx-auto d-block">
                            </div>
                            <h3 class="mx-auto text-center">Receive Document </h3>
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
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>Receipt_Control_Center/RCC_js"></script>