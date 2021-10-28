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
<!-- ================== END PAGE LEVEL STYLE ================== -->
<div id="content" class="content">
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-9">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Profiling</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <form id="add_pras_form" autocomplete="off" enctype="multipart/form-data">
                        <fieldset>
                            <div class="row mt-3" style="display: none;">
                                <div class="form-group col-lg-6">
                                    <label for="reference_id">Reference Number</label>
                                    <input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="Enter Reference Number" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="mode">Mode of Procurement</label>
                                    <?php //echo $count_mode = count($proc_mode)+1; ?>
                                    <select class="form-control" name="mode" id="mode">
                                        <option value="">Select Mode of Procurement</option>
<!--                                         <?php 
                                            foreach($proc_mode as $row)
                                            {
                                                echo '<option value="'.$row->mode_id.'">'.$row->procurement_desc.'</option>';
                                            }
                                        ?> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="form-group col-lg-6">
                                    <label for="pras_num">PRAS Number</label>
                                    <input type="email" class="form-control" id="pras_num" name="pras_num" placeholder="Enter PRAS Number" />
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
                            <div class="row" style="display: none;">
                                <div class="form-group col-lg-4">
                                    <label for="date_start">Date start of submission</label>
                                    <input type="text" class="form-control datepicker" name="date_start" id="date_start">
                                </div>
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
                                <label class="col-lg-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <button type="submit" class="btn btn-info pull-right" id="add_pras">Create Document</button>
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
<!-- ================== END PAGE LEVEL JS ================== -->
<script type="text/javascript">
$(document).ready(function() {
    App.init();
    $('.datepicker').datepicker({
        todayHighlight: true
    });
    $('.selectpicker').selectpicker('render');
});
</script>

<script type="text/javascript">
var transparent = true;
var mobile_device = false;
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

$(document).ready(function(){

    $("#mode").change(function(){
        $('#abc').val('');
    });

    $(document.body).on('keyup', '#pras_num', function(){
        var params = $.trim(this.value);
            $.ajax({
                type:"GET",
                //async: false,
                url: base_url + 'Create_document/check_exists',
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
                    //Gross : true,
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
                     url:"<?php echo base_url(); ?>Create_document/Create_document_profile",   
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
        $.getJSON( 'Create_document/get_offices', {
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
        $.getJSON( 'Create_document/get_services', {
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
        $.getJSON( 'Create_document/get_divisions', {
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
        $.getJSON( 'Create_document/get_reference_id', {
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