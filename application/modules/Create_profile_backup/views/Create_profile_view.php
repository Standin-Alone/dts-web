<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/dropzone/min/dropzone.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
<div id="content" class="content">
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-9">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Create Profile</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <form id="add_pras_form" autocomplete="off" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right text-md-right">Date</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control datepicker col-md-5" name="date" id="date">
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right text-md-right">Document Type</label>
                                <div class="col-md-7">
                                    <select class="form-control col-md-5" name="document_type" id="document_type">
                                        <option value="">Select Document Type</option>
                                        <?php 
                                            foreach($document_type as $row)
                                            {
                                                echo '<option value="'.$row->type_id.'">'.$row->type.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">For</label>
                                <div class="col-md-7">
                                    <select class="form-control col-md-5" name="for" id="for">
                                        <option value="">Select For</option>
                                        <?php 
                                            foreach($document_for as $row)
                                            {
                                                echo '<option value="'.$row->for_id.'">'.$row->for.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Origin Type</label>
                                <div class="col-md-7">
                                    <select class="form-control col-md-5" name="for" id="for">
                                        <option value="Internal">Internal</option>
                                        <option value="External">External</option>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Subject</label>
                                <div class="col-md-7">
                                    <textarea class="textarea form-control" name="subject" id="subject" placeholder="Enter text ..." rows="10"></textarea>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Remarks</label>
                                <div class="col-md-7">
                                    <textarea class="textarea form-control" name="remarks" id="remarks" placeholder="Enter text ..." rows="10"></textarea>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Recipient</label>
                                <div class="col-md-7">
                                    <select class="multiple-select2 form-control" multiple="multiple" id="recipients">
                                        <?php 
                                        foreach($recipients as $row)
                                        {
                                            echo '<option value="'.$row->OFFICE_CODE.'">'.strtoupper(($row->SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '').$row->ORIG_SHORTNAME.' / '.($row->INFO_DIVISION == '' ? $row->INFO_SERVICE : $row->INFO_SERVICE.' / '.$row->INFO_DIVISION)).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Signatories</label>
                                <div class="col-md-7">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Fullname</th>
                                                <th class="text-center">Designation</th>
                                                <th class="text-center">Office</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr id="tr_btn">
                                                <td colspan="5" class="text-center">
                                                    <button type="button" class="btn btn-success btn-icon-split" id="add_sig_modal">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-users"></i>
                                                        </span>
                                                        <span class="text">Add Signatory</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Upload File</label>
                                <div class="col-md-7">
                                    <div class="dropzone" id="myAwesomeDropzone">
                                        <div class="dz-message needsclick">
                                            <small>Drop files <b>here</b> or <b>click</b> to upload.<br /></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Attachments</label>
                                <div class="col-md-7">
                                    <div class="dropzone" id="myAwesomeDropzone">
                                        <div class="dz-message needsclick">
                                            <small>Drop files <b>here</b> or <b>click</b> to upload.<br /></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Remarks</label>
                                <div class="col-md-7">
                                    <input type="text" name="" id="jquery-autocomplete" class="form-control" placeholder="Try typing 'a' or 'b'." />
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Subject</label>
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Default Tags Input with Autocomplete</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-default">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                            <p>Try to enter "c++, java, php" </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Inverse Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-inverse" class="inverse">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">White Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-white" class="white">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Primary Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-primary" class="primary">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Info Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-info" class="info">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Success Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-success" class="success">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Warning Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-warning" class="warning">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">Danger Theme</label>
                                        <div class="col-md-8">
                                            <ul id="jquery-tagIt-danger" class="danger">
                                                <li>Tag1</li>
                                                <li>Tag2</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-lg-6">
                                    <label for="reference_id">Reference Number</label>
                                    <input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="Enter Reference Number" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="pras_num">PRAS Number</label>
                                    <input type="text" class="form-control" id="pras_num" name="pras_num" placeholder="Enter PRAS Number" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="abc">ABC</label>
                                    <input type="text" class="form-control" id="abc" name="abc" placeholder="Enter ABC" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="pras_num">End User Office</label>
                                    <input type="text" class="form-control" name="offices" id="offices">
                                    <input type="hidden" class="form-control" name="office_code" id="office_code">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="abc">End User Service</label>
                                    <input type="text" class="form-control" name="services" id="services">
                                    <input type="hidden" class="form-control" name="service_code" id="service_code">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="abc">End User Division</label>
                                    <input type="text" class="form-control" name="divisions" id="divisions">
                                    <input type="hidden" class="form-control" name="division_code" id="division_code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="date_end">Date end of submission</label>
                                    <input type="text" class="form-control datepicker" name="date_end" id="date_end">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="date_opening">Date of opening bids</label>
                                    <input type="text" class="form-control datepicker" name="date_opening" id="date_opening">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="pras_desc">Date start of submission</label>
                                    <textarea class="textarea form-control" name="pras_desc" id="pras_desc" placeholder="Enter text ..." rows="10"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <button type="submit" class="btn btn-info pull-right" id="add_pras">Add PRAS Profile</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
</div>
<div class="modal fade" id="addEmpModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Signatory Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success m-b-0">
                    <h5><i class="fa fa-info-circle"></i> Add Signatory</h5>
<!--                     <p>Search and Select</p> -->
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="form-group">
                            <label>Employee Name:</label>
                            <input type="text"  id="signatory_emp" class="form-control" placeholder="Search by Employee Lastname, Click & Select.">
                            <input type="hidden" id="modal_sig_emp_code" name="modal_sig_emp_code">
                        </div>
                        <div class="form-group">
                            <label>Position/Designation:</label>
                            <input type="text" name="sinatory_designation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Servince/Division</label>
                            <input type="text" id="signatory_office" class="form-control" placeholder="Search Service/Division, Click & Select.">
                            <input type="hidden" id="modal_sig_office_code" name="modal_sig_office_code">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
<!--                 <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="modal_add_sig_btn" class="btn btn-primary modal_sig_add_btn">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- ================== BEGIN BASE JS ================== -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/crossbrowserjs/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/crossbrowserjs/respond.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/js-cookie/js.cookie.js"></script>
<script src="<?php echo base_url(); ?>assets/js/theme/default.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/masked-input/masked-input.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/clipboard/clipboard.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url(); ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script type="text/javascript">
$(document).ready(function() {
    App.init();
    $('.datepicker').datepicker({
        todayHighlight: true
    });
    $('.selectpicker').selectpicker('render');
    $(".multiple-select2").select2({ placeholder: "Select a state" });
});
</script>

<script type="text/javascript">
var office_code;
var service_code;
var accept = ".pdf";
var result_if_exists;
var pras_id;
$('#services').attr('disabled',true);
$('#divisions').attr('disabled',true);

$.validator.addMethod("Gross", function (value, element) {
    return this.optional(element) || /^(?:\d+)((\d{1,3})*([\,\ ]\d{3})*)(\.\d+)?$/i.test(value);
}, "Not allowed.");

$.validator.addMethod("bidding", function (value, element) {
    //Get the date from the TextBox.
    var mode = document.getElementById("mode").value;
    var abc = document.getElementById("abc").value;
    var abc_val = parseInt(abc.replace(',', ''));
    var bid_range = parseInt(1000000);
    var aa_range = parseInt(500000);
    var sv_range = parseInt(50000);

        if(mode == 'PB'){
            if(abc_val < bid_range){
                return false;
            }
        }

        if(mode == 'AA'){
            if(abc_val < aa_range){
                return false;
            }
        }

        if(mode == 'AA'){
            if(abc_val >= bid_range){
                return false;
            }
        }

        if(mode == 'SV'){
            if(abc_val < sv_range){
                return false;
            }
        }

        if(mode == 'SV'){
            if(abc_val >= aa_range){
                return false;
            }
        }

        return true;
}, "Change the mode of procument."); 

$.validator.addMethod("datestart", function (value, element) {
    //Get the date from the TextBox.

    var startDate = $('#date_start').val();
    var endDate = $('#date_end').val();

        if(Date.parse(startDate) >= Date.parse(endDate)){
            // Do something
            return false;
        }
    return true;
}, "Not valid!");

$.validator.addMethod("dateend", function (value, element) {
    //Get the date from the TextBox.

    var startDate = $('#date_start').val();
    var endDate = $('#date_end').val();

        if(Date.parse(endDate) <= Date.parse(startDate)){
            // Do something
            return false;
        }
    return true;
}, "Not valid!");

$.validator.addMethod("dateopen", function (value, element) {
    //Get the date from the TextBox.

    var openDate = $('#date_opening').val();
    var endDate = $('#date_end').val();

        if(Date.parse(openDate) < Date.parse(endDate)){
            // Do something
            return false;
        }
    return true;
}, "Not valid!");

$.validator.addMethod("checkExists", 
    function(value, element) {
        return result_if_exists;
    },
    "Already Exist."
);

Dropzone.autoDiscover = false;
Dropzone.options.myAwesomeDropzone = {
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictDefaultMessage: "<span>Click to upload</span>",
    paramName: "doc_file",
    autoProcessQueue: false,
    acceptedFiles: accept,
    init: function () {

        myDropzone = this;

        this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
        this.on("removedfile", function (file) {
            file.previewElement.remove();
        });

        this.on('sending', function(file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var mode = $('#mode').val();
            formData.append('mode', mode);
            formData.append('pras_id', pras_id);
        });

        this.on("success", function (file) {
            //check_upload = true;
            //location.reload();
        });
    }
};

var myDropzone = new Dropzone("div#myAwesomeDropzone", { url: base_url + "Create_profile/upload_file" });

$(document).ready(function(){

    $("#mode").change(function(){
        $('#abc').val('');
    });

    $(document.body).on('keyup', '#pras_num', function(){
        var params = $.trim(this.value);
            $.ajax({
                type:"GET",
                //async: false,
                url: base_url + 'Add_pras/check_exists',
                dataType: 'json',
                data: { params: params},
                success:function(results) {
                    if(results.dedup > 0){
                        result_if_exists = false;
                    } else {
                        result_if_exists = true;
                    }
                }
            });
    });

    // Data Picker Initialization
    $('.datepicker').datepicker({
        inline: true
    });
    // $('#date_start').change(function() {
    //     alert('1');
    //     if((this).val() != ''){
    //         $("input").parent().addClass("is-filled");
    //     } else {
    //         $("input").parent().removeClass("is-filled");
    //     }
    // });

    // Code for the Validator
    $('#add_pras_form').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                reference_id: {
                    //checkExists: true,
                    required: true
                },
                pras_num: {
                    checkExists: true,
                    required: true
                },
                pras_desc: {
                    required: true
                },
                abc: {
                    //bidding: true,
                    Gross : true,
                    required: true
                },
                offices: {
                    required: true
                },
                services: {
                    required: true
                },
                divisions: {
                    required: true
                },
                mode: {
                    required: true
                },
                date_start: {
                    datestart: true,
                    required: true
                },
                date_end: {
                    dateend: true,
                    required: true
                },
                date_opening: {
                    dateopen: true,
                    required: true
                }
        },
        errorPlacement: function ( error, element ) {
            error.css({"font-size": "12px"});
            error.addClass( "text-danger" );
            error.addClass( "invalid-feedback" );

            if( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            console.log(element);
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            console.log(element);
        },
        submitHandler: function() {

            //if(myDropzone.files.length > 0){
                var formData = $('#add_pras_form').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>Add_pras/add_pras_profile",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            pras_id = results.data[0].pras_id;
                            $("#submit_upload").click();
                            Swal.fire({
                                type: 'success',
                                title: 'Success!',
                                text: 'PRAS profile has been successfully added.'
                            }).then((result) => {
                                //$("#submit_upload").click();
                                if(result.value){
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error updating data');
                    }

                });
            // } else {
            //     Swal.fire({
            //         allowOutsideClick: false,
            //         type: 'warning',
            //         title: 'Required to upload.',
            //         text: 'Please attach document'
            //     });
            // }
        }
    });
    

$('#offices').autocomplete({
    source: function( request, response ) {
        $.getJSON( 'Add_pras/get_offices', {
            'office_name': request.term
        }, response );
    },
    select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field
        $('#services').attr('disabled',false);
        $(this).val(ui.item.label);
        $('#office_code').val(ui.item.value);
        office_code = $('#office_code').val();
    },
    change: function (event, ui) {
        if (!ui.item) {
            $('#services').attr('disabled',true);
            $('#divisions').attr('disabled',true);
            $(this).val("");
            $('#office_code').val("");
            $('#services,#service_code').val("");
            $('#divisions,#division_code').val("");
        }
    }
}).on('change', function() {
        //$('#services').val("");
        //$('#divisions').val("");
});

$('#services').autocomplete({
    source: function( request, response ) {
        $.getJSON( 'Add_pras/get_services', {
            'office_code' : office_code,
            'service_name': request.term
        }, response );
    },
    select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field
        $('#divisions').attr('disabled',false);
        $(this).val(ui.item.label);
        $('#service_code').val(ui.item.value);
        service_code = $('#service_code').val();
    },
    change: function (event, ui) {
        if (!ui.item) {
            $('#divisions').attr('disabled',true);
            $(this).val("");
            $('#service_code').val("");
            $('#divisions,#division_code').val("");
        }
    }
    }).on('change keyup', function() {
        // $('[name="barangay_append[0]"]').val("");
        // $('[name="barangay_append_copy[0]"]').val("");
});

$('#divisions').autocomplete({
    source: function( request, response ) {
        $.getJSON( 'Add_pras/get_divisions', {
            'office_code' : office_code,
            'service_code' : service_code,
            'division_name': request.term
        }, response );
    },
    select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field
        $(this).val(ui.item.label);
        $('#division_code').val(ui.item.value);
    },
    change: function (event, ui) {
        if (!ui.item) {
            $(this).val("");
            $('#division_code').val("");
        }
    }
});

$('#reference_id').autocomplete({
    source: function( request, response ) {
        $.getJSON( 'Add_pras/get_reference_id', {
            'ref_id': request.term
        }, response );
    },
    select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field
        $(this).val(ui.item.label);
        $('#reference_code').val(ui.item.value);
    },
    change: function (event, ui) {
        if (!ui.item) {
            $(this).val("");
            $('#reference_code').val("");
        }
    }
});

        var availableTags = [
            'ActionScript',
            'AppleScript',
            'Asp',
            'BASIC',
            'C',
            'C++',
            'Clojure',
            'COBOL',
            'ColdFusion',
            'Erlang',
            'Fortran',
            'Groovy',
            'Haskell',
            'Java',
            'JavaScript',
            'Lisp',
            'Perl',
            'PHP',
            'Python',
            'Ruby',
            'Scala',
            'Scheme'
        ];
        $('#jquery-autocomplete').autocomplete({
            source: availableTags
        });

    $('.bootstrap-tagsinput input').focus(function() {
        $(this).closest('.bootstrap-tagsinput').addClass('bootstrap-tagsinput-focus');
    });
    $('.bootstrap-tagsinput input').focusout(function() {
        $(this).closest('.bootstrap-tagsinput').removeClass('bootstrap-tagsinput-focus');
    });
    // $('#jquery-tagIt-inverse').tagit({
    //     availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    // });

    $('#add_sig_modal').on('click', function() {
        $('#addEmpModal').modal('show');
    });

    $('#jquery-tagIt-inverse').tagit({
        'autocomplete': {
            source: function( request, response ) {
                $.getJSON( 'Create_profile/get_recipients', {
                    'term': request.term
                }, response );
            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                if (ui.item.label) {
                    $(this).val(ui.item.label);
                }
            }
        } 
    });


    $("#signatory_emp").autocomplete({
        source: function( request, response ) {
            var sig_emp_code = $('#signatory_emp').val();
            $.getJSON( 'Create_profile/get_signature_da_name', {
                // 'agency_id': '9304df8f-a323-453d-a458-ab728e1bc419',
                'term': request.term
            }, response );
        },
        appendTo: $("#addEmpModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#modal_sig_emp_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#modal_sig_emp_code').val("");
            }
        }
    });

    $("#signatory_office").autocomplete({
        source: function( request, response ) {
            var sig_emp_code = $('#signatory_office').val();
            $.getJSON( 'Create_profile/get_signature_div_da', {
                //'agency_id': '9304df8f-a323-453d-a458-ab728e1bc419',
                'term': request.term
            }, response );
        },
        appendTo: $("#addEmpModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#modal_sig_office_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#modal_sig_office_code').val("");
            }
        }
    });

    $(document.body).on('click', '.modal_sig_add_btn', function() {
        var signatory_emp    = $('#signatory_emp').val();
        var designation      = $('[name="sinatory_designation"]').val();
        var signatory_office = $('#signatory_office').val();
        var signatory_emp_code    = $('[name="modal_sig_emp_code"]').val();
        var signatory_office_code = $('[name="modal_sig_office_code"]').val();

        if(signatory_emp_code == ''){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please select and click in the list of Employee',
            });
            return false;
        }

        if(signatory_office_code == ''){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please select and click in the list of Office',
            });
            return false;
        }

        var tr = '<tr>'+
                    '<td class="text-center td_emp">'+signatory_emp+'</td>'+
                    '<td class="text-center td_desig">'+designation+'</td>'+
                    '<td class="text-center"><span class="td_office">'+signatory_office+'</span>'+
                        '<input type="text" name="signatory_emp_code[]" value="'+signatory_emp_code+'">'+
                        '<input type="text" name="signatory_designation_desc[]" value="'+designation+'">'+
                        '<input type="text" name="signatory_office_code[]" value="'+signatory_office_code+'">'+
                        // '<input type="text" name="signatory_type[]" value="1">'+
                    '</td>'+
                    '<td>Employee</td>'+
                    '<td class="text-center">'+
                        // '<i data-sigemp="'+signatory_emp+'" data-sigpos="'+designation+'" data-sigoffice="'+signatory_office+'" data-sigempcode="'+signatory_emp_code+'" data-sigoffcode="'+signatory_office_code+'" class="fas fa-edit cursor edit_sig" title="Edit"></i>&nbsp;'+
                        '<i class="fas fa-trash-alt cursor remove_sig" title="Remove"></i>'+
                    '</td>'+
                 '</tr>';

        $('#tr_btn').before(tr);

        $('#signatory_emp').val('');
        $('[name="sinatory_designation"]').val('');
        $('#signatory_office').val('');

        $('#addEmpModal').modal('hide');
    });

    $(document.body).on('click', '.remove_sig', function() {
        var closest_tr = $(this).closest('tr');

        Swal.fire({
            type: 'warning',
            title: 'Wait!',
            text: 'Are you sure you want to remove this?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.value) {
                setTimeout(function() {
                    closest_tr.remove();
                }, 200);
            }
        });

    });

    
    // Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });
});

 //Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>