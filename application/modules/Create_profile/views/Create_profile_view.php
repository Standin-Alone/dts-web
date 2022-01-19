<link href="<?php echo base_url(); ?>assets/plugins/dropzone/min/dropzone.min.css" rel="stylesheet" />
<style type="text/css">
    .remove_sig {cursor: pointer;}
    .dz-remove{display:inline-block !important;width:1.2em;height:1.2em;position:absolute;top:5px;right:5px;z-index:1000;font-size:1.2em !important;line-height:1em;text-align:center;font-weight:bold;border:1px solid gray !important;border-radius:1.2em;color:gray;background-color:white;opacity:.5;}
    .dz-remove:hover{text-decoration:none !important;opacity:1;}
    #document_type-error{text-align:left;}
    #document_type-error{text-align:left;}
    #date-error{text-align:left;}
    #for-error{text-align:left;}
    #origin_type-error{text-align:left;}
    #sender_name-error{text-align:left;}
    #sender_position-error{text-align:left;}
    #sender_address-error{text-align:left;}
    #remarks-error{text-align:left;}
    #subject-error{text-align:left;}
/*    #add_file{display:none;}#print_area{display:none;}*/
    .qr_code {display:  inline !important;}
    .page {
        width: 210mm;
        min-height: 148.5mm;
        padding: 5mm;
        margin: 0 auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

@page {
    size: A4;
    margin: 0.5cm;
    overflow-y:hidden !important;
}

@media print{
    .page {
/*        background-color:#FFFFFF;
        color:#000000;
        overflow-y:hidden !important;
        overflow-x:hidden !important;
        margin: 7mm 10mm 0mm !important;
        height: 100%;*/
        margin-top: 300px;
        overflow-y:hidden !important;
        overflow-x:hidden !important;
        margin: 0 !important;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
    }
    .qr_code {
        display:  inline !important;
    }
    .sticker{
        display:  inline !important;
    }
    .print_btn {
        display: none;
    }
    .title {
        display: none;
    }
    .card-header-info{
        display: none;
    }
    .header-filter {
        display: none;
    }
    .panel-title {
        display: none;
    }
    #add_profile {
        display: none !important;
    }
    #add_file {
        display: none !important;
    }
    #sidebar{
        display: none;
    }
    #header {
        display: none;
    }
    .footer {
        display: none;
    }
    #print_note {
        display: none;
    }
    .release_btn {
        display: none;
    }
}
</style>
<div id="content" class="content">
    <div class="row pdddd">
        <!-- begin col-6 -->
        <div class="col-lg-12 pdddd">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-9">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Create Profile</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <form id="add_profile" autocomplete="off" enctype="multipart/form-data">
                        <fieldset id="document_details">
                            <div class="note note-info">
                                <div class="note-icon"><i class="fas fa-book"></i></div>
                                <div class="note-content">
                                    <h4><b>Profiling!</b></h4>
                                    <p> Enter the document information and details. </p>
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Date</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control datepicker col-md-5" name="date" id="date">
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Document Type</label>
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
                                <label class="col-md-3 col-form-label text-md-right">Action</label>
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
                                    <select class="form-control col-md-5" name="origin_type" id="origin_type">
                                        <option value="Internal">Internal</option>
                                        <option value="External">External</option>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <span id="sender_div">
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Sender Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control col-md-5" name="sender_name" id="sender_name">
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Sender Position</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control col-md-5" name="sender_position" id="sender_position">
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Sender Address</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control col-md-5" name="sender_address" id="sender_address">
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            </span>
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
<!--                             <span id="recipient_div">
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Recipient Type</label>
                                <div class="col-md-7">
                                    <select class="form-control col-md-5" name="in_transaction" id="in_transaction">
                                        <option value="0">All</option>
                                        <option value="1">Specific Recipient</option>
                                    </select>
                                </div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            </span> -->
                            <div class="form-group row m-b-15">
                                <label class="col-md-3 col-form-label text-md-right">Recipient</label>
                                <div class="col-md-7">
                                    <select class="multiple-select2 form-control" multiple="multiple" id="recipients" name="recipients[]">
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
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr id="tr_btn">
                                                <td colspan="5" class="text-center">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2 align-self-center">                                                    
                                    <button type="button" class="btn btn-success btn-icon-split" id="add_sig_modal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <span class="text">Add Signatory</span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row m-b-15 d-flex justify-content-center">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <button type="submit" class="btn btn-success btn-lg" id="add_profile_button">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-folder-plus fa-lg"></i>
                                    </span>
                                    <span class="text">Create Profile</span>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <fieldset id="add_file">
                        <div class="note note-info">
                            <div class="note-icon"><i class="fas fa-file-upload"></i></div>
                            <div class="note-content">
                                <h4><b>Uploading!</b></h4>
                                <p> Upload file and attachment. </p>
                            </div>
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
                            <div class="col-md-2 align-self-center"><button id="submit_upload_file" class="btn btn-success">Upload File</button></div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-3 col-form-label text-md-right">Attachments</label>
                            <div class="col-md-7">
                                <div class="dropzone" id="attachmentDropzone">
                                    <div class="dz-message needsclick">
                                        <small>Drop files <b>here</b> or <b>click</b> to upload.<br /></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center"><button id="submit_upload_attachment" class="btn btn-success">Upload Attachment</button></div>
                        </div>
                        <div class="form-group row m-b-15 d-flex justify-content-center">
                            <button type="button" class="btn btn-success btn-lg" id="save_all">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save fa-lg"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>
                        </div>
                    </fieldset>
                    <fieldset id="print_area">
                        <div class="note note-info" id="print_note">
                            <div class="note-icon"><i class="fas fa-print"></i></div>
                            <div class="note-content">
                                <h4><b>Printing!</b></h4>
                                <p> Print document routing slip. </p>
                            </div>
                        </div>
                        <!-- begin invoice -->
                        <div class="border border-secondary rounded page">
                            <div class="invoice">
                                <!-- begin invoice-company -->
                                <p class="text-center"><img class="text-center" style="margin:0px;height: 50px;width: 50px;" src="<?php echo base_url() .'assets/img/DA-Logo.png';?>"></p>
                                <h4 class="text-center">Department of Agriculture</h4>
                                <h5 class="text-center mb-4">Document Tracking System</h5>
                                <h3 class="text-center mb-3">Routing Slip</h3>
                                <div class="invoice-company text-inverse f-w-600">
                                    <span class="pull-right hidden-print">
                                    <!-- <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5 print_btn"><i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a> -->
                                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5 print_btn"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                                    <!-- <a href="<?php //echo base_url().'/View_document/document/'.$doc_number; ?>" class="btn btn-sm btn-icon btn-success release_btn" target="_blank"><i class="fas fa-share"></i></a> -->
                                    </span>
                                    <small>Document Number:</small>
                                </div>
                                <!-- end invoice-company -->
                                <!-- begin invoice-header -->
                                <div class="invoice-header">
                                    <div class="text-center">
                                        <img id="doc_num_qr" style="height: 150px;width: 150px;" src="">
                                    </div>
                                    <div class="text-center">
                                        <strong id="doc_num_text"></strong>
                                    </div>
                                </div>
                                <!-- end invoice-header -->
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 ml-3"><h5 class="">Action: <span id="action_text"></span></h5></div>
                                <div class="col-lg-6 ml-3"><h5 class="">Subject: <span id="subject_text"></span></h5></div>
                            </div>
                            <!-- begin invoice-content -->
                            <div class="invoice-content">
                                <!-- begin table-responsive -->
                                <div class="table-responsive">
                                    <table class="table table-invoice">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%">Recipients</th>
                                                <th class="text-center" width="10%">Date</th>
                                                <th class="text-center" width="20%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recipients_list">
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                        <div class="row m-b-15 d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-success release_btn">Release Document <i class="fas fa-share"></i></button>
                        </div>
                    </fieldset>
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
                <div class="note note-success m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h6 class="m-t-5 m-b-5 p-b-2">Signatory Information</h6>
                        <ul class="m-b-5 p-l-25">
                            <li>Search & Click <strong id="pras"></strong></li>
                        </ul>
                    </div>
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
                            <input type="text" name="sinatory_designation" class="form-control" placeholder="Enter Employee Current Position.">
                        </div>
                        <div class="form-group">
                            <label>Service/Division</label>
                            <input type="text" id="signatory_office" class="form-control" placeholder="Search Service/Division, Click & Select.">
                            <input type="hidden" id="modal_sig_office_code" name="modal_sig_office_code">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
<!--                 <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="button" id="modal_add_sig_btn" class="btn btn-success modal_sig_add_btn"><i class="fas fa-user-plus"></i> Add</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
<script type="text/javascript">
var path = '<?php echo base_url() .'Create_profile/qr_code/3/2/';?>';
var accept = ".pdf";
var result_if_exists;
var doc_number;
var doc_type;
var action_for;
var subj_text;
$('#add_file,#print_area').css("display", "none");
$('#sender_div,#recipient_div').css('display' , 'none');
$('#sender_name,#sender_position,#sender_address').attr('disabled', true);

$.validator.addMethod("checkExists", 
    function(value, element) {
        return result_if_exists;
    },
    "Already Exist."
);

$(document).ready(function(){
    $('.datepicker').datepicker({
        todayHighlight: true,
        autoclose: true
    });
    $('.selectpicker').selectpicker('render');
    $(".multiple-select2").select2({ placeholder: "Select Office/Service/Division" });

    // Code for the Validator
    $('#add_profile').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                date: {
                    required: true
                },
                document_type: {
                    required: true
                },
                for: {
                    required: true
                },
                origin_type: {
                    required: true
                },
                // sender_name: {
                //     required_this: true
                // },
                // sender_position: {
                //     required_this: true
                // },
                // sender_address: {
                //     required_this: true
                // },
                remarks: {
                    //required: true
                },
                subject: {
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
                // var recipients_val = $('#recipients').val();
                // if(count(recipients_val == 0)){
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'warning',
                //         title: 'Wait!',
                //         text: 'Are you sure you want to remove this?',
                //         showCancelButton: true,
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Yes, remove it!'
                //     }).then((result) => {
                //         if (result.value) {
                //             alert('Ok');
                //         }
                //     });
                // }

                $('#add_profile_button').attr('disabled', false);
                var formData = $('#add_profile').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>Create_profile/add_profile",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            doc_number = results.data[0].document_number;
                            doc_type = results.data[0].type;
                            action_for = results.data[0].for;
                            console.log(doc_type);
                            $('#doc_number_sig').val(doc_number);
                            $("#doc_num_qr").attr('src', path+doc_number);
                            $("#doc_num_text").text(doc_number);
                            $("#action_text").text(action_for);
                            $("#subject_text").text(results.data[0].subject);
                            //$("#submit_upload_file").click();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Profile Created!',
                                text: 'Do you want to upload file/attachment?',
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#42ba96',
                                cancelButtonText: `Saved as Draft`,
                                confirmButtonText: 'Yes'
                            }).then((result) => {
                                if(result.value){
                                    $('#add_file').css("display", "");
                                    $('#document_details').css("display", "none");
                                } else {
                                    location.reload();
                                }
                            });

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        //alert('Error updating data');
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

    $('#add_sig_modal').on('click', function() {
        $('#addEmpModal').modal('show');
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
            //$('#modal_sig_emp_code').val(ui.item.value);
        }
        // ,
        // change: function (event, ui) {
        //     if (!ui.item) {
        //         $(this).val("");
        //         $('#modal_sig_emp_code').val("");
        //     }
        // }
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

    $("#sender_name").autocomplete({
        source: function( request, response ) {
            $.getJSON( 'Create_profile/get_sender_name', {
                'term': request.term
            }, response );
        },
        //appendTo: $("#addEmpModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            //$('#modal_sig_emp_code').val(ui.item.value);
        }
        // ,
        // change: function (event, ui) {
        //     if (!ui.item) {
        //         $(this).val("");
        //         $('#modal_sig_emp_code').val("");
        //     }
        // }
    });


    $(document.body).on('click', '.modal_sig_add_btn', function() {
        var signatory_emp    = $('#signatory_emp').val();
        var designation      = $('[name="sinatory_designation"]').val();
        var signatory_office = $('#signatory_office').val();
        //var signatory_emp_code    = $('[name="modal_sig_emp_code"]').val();
        var signatory_office_code = $('[name="modal_sig_office_code"]').val();

        if(signatory_emp == ''){
            Swal.fire({
                icon: 'error',
                title: 'Required Field!',
                text: 'Please select and click in the list of Employee',
            });
            return false;
        }

        if(designation == ''){
            Swal.fire({
                icon: 'error',
                title: 'Required Field!',
                text: 'Please enter employee position.',
            });
            return false;
        }

        if(signatory_office_code == ''){
            Swal.fire({
                icon: 'error',
                title: 'Required Field!',
                text: 'Please select and click in the list of Office',
            });
            return false;
        }

        var tr = '<tr>'+
                    '<td class="text-center td_emp">'+signatory_emp+'</td>'+
                    '<td class="text-center td_desig">'+designation+'</td>'+
                    '<td class="text-center"><span class="td_office">'+signatory_office+'</span>'+
                        //'<input type="hidden" name="signatory_emp_code[]" value="'+signatory_emp_code+'">'+
                        '<input type="hidden" name="signatory_designation_desc[]" value="'+designation+'">'+
                        '<input type="hidden" name="signatory_office_code[]" value="'+signatory_office_code+'">'+
                        '<input type="hidden" name="signatory_user_fullname[]" value="'+signatory_emp+'">'+
                    '</td>'+
                    // '<td>Employee</td>'+
                    '<td class="text-center">'+
                        // '<i data-sigemp="'+signatory_emp+'" data-sigpos="'+designation+'" data-sigoffice="'+signatory_office+'" data-sigempcode="'+signatory_emp_code+'" data-sigoffcode="'+signatory_office_code+'" class="fas fa-edit cursor edit_sig" title="Edit"></i>&nbsp;'+
                        // '<i class="fas fa-trash-alt cursor remove_sig" title="Remove"></i>'+
                        '<i class="fas fa-trash remove_sig" style="color: #f59c1a;border-color:#f59c1a;" title="Remove"></i>'+
                    '</td>'+
                 '</tr>';

        $('#tr_btn').before(tr);

        $('#signatory_emp').val('');
        $('[name="sinatory_designation"]').val('');
        $('#signatory_office').val('');

        $('#addEmpModal').modal('hide');
    });

    $(document.body).on('submit', '#signatories_details', function() {
        var form_data = $(this).serializeObject();
        $('#finish').attr('disabled', true);
        $('#finish').attr('type', 'button');
        $.ajax({
            url: base_url + 'Create_profile/insert_signatories', 
            type: 'post',
            data: form_data,
            dataType: 'json',
            success: function(result){
                if(result == 'success'){
                    var doc_number_sign  = form_data['doc_number'];
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Upload Completed',
                            text: 'You have successfully uploaded the document file.',
                            showConfirmButton: true
                        }).then((result) => {
                            setTimeout(function() {
                                var doc_number_sign  = form_data['doc_number'];
                                window.location = base_url + 'View_document/document/' + doc_number_sign;
                            }, 200);
                        });

                }
            }
        });
        
        return false;
    });

    $(document.body).on('click', '#save_all', function() {
        // Swal.fire({
        //     position: 'center',
        //     icon: 'success',
        //     title: 'Profile Completed!',
        //     text: 'Profile has been saved.',
        //     showConfirmButton: false,
        //     timer: 2500
        // }).then(function(){ 
        //     location.reload();
        // });

        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'File Uploaded!',
            text: 'Profile has been saved.',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#42ba96',
            cancelButtonText: `Save as Draft?`,
            confirmButtonText: 'Print routing slip?'
        }).then((result) => {
            if(result.value){
                $('#print_area').css("display", "");
                $('#add_file').css("display", "none");
                $.ajax({
                    url: base_url + 'Create_profile/document_recipients', 
                    type: 'post',
                    data: { 'doc_number': doc_number },
                    dataType: 'json',
                    success: function(result){
                        var tr='';
                            var commo_count = result.length;
                            for (ie = 0; ie < commo_count; ie++) {
                                tr +='<tr>';
                                //tr +='<td class="text-center">'+result[ie].added_by_user_fullname+'</td>';
                                tr +='<td class="text-center pb-0">'+(result[ie].INFO_DIVISION == '' ? result[ie].INFO_SERVICE : result[ie].INFO_DIVISION)+'</td>';
                                tr +='<td class="text-center">'+result[ie].date_added+'</td>';
                                tr +='<td class="text-center"></td>';
                                tr +='</tr>';
                            }
                            $('#recipients_list').html('').append(tr);
                        }
                });
            } else {
                location.reload();
            }
        });
    });

    $(document.body).on('click', '.remove_sig', function() {
        var closest_tr = $(this).closest('tr');

        Swal.fire({
            position: 'center',
            icon: 'warning',
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
    

    $(document.body).on('change', '#origin_type', function(){
        var this_val = $(this).val();
        if (this_val == 'External') {
            //alert('1');
            $('#sender_div').css('display' , '');
            $('#sender_name,#sender_address,#sender_position').attr('required' , true);
            $('#sender_name,#sender_position,#sender_address').attr('disabled', false);
        } else {
            $('#sender_div').css('display' , 'none');
            $('#sender_name,#sender_position,#sender_address').attr('required' , false);
            $('#sender_name,#sender_position,#sender_address').attr('disabled', true);
        }
    });

    // $(document.body).on('change', '#in_transaction', function(){
    //     var this_val = $(this).val();
    //     if (this_val == '0') {
    //         $('#recipients').attr('disabled' , true);
    //     } else {
    //         $('#recipients').attr('disabled' , false);
    //     }
    // });

    // $(document.body).on('change', '#for', function(){
    //     var this_val = $(this).val();
    //     if (this_val == '3') {
    //         $('#recipient_div').css('display' , '');
    //         $('#recipients').attr('disabled' , true);
    //     } else {
    //         $('#recipient_div').css('display' , 'none');
    //         $('#recipients').attr('disabled' , false);
    //     }
    // });

    $(document.body).on('click', '.release_btn', function() {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: 'Release this document.',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, release it!'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: base_url + 'View_document/release_document1',
                    method:"POST",  
                    data: { doc_number: doc_number },
                    dataType: 'json', 
                    success:function(r)  
                    {
                        if(r == 'success'){
                            console.log(r);
                            Swal.fire({
                                type: 'question',
                                title: 'Completed',
                                text: 'Document Released.'
                            }).then((result) => {
                                if(result.value){
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {

                    }

                });
            }
        });
    });


});

    $('#submit_upload_file').click(function(){
        var myDropzone_status   = [];

        if(myDropzone.files.length == 0){
            Swal.fire({
                allowOutsideClick: false,
                position: 'center',
                icon: 'error',
                title: 'Required to upload.',
                text: 'Please attach file'
            });
            return false; //if an error happened stop here kaya return false hnd na dapat mag tuloy sa baba.
        } else {
            myDropzone.processQueue();
        }

        $.each(myDropzone.files, function(k,v){
            myDropzone_status.push(v.status);
        });

       console.log(myDropzone.files);
       console.log(doc_number);
    });

    Dropzone.autoDiscover = false;
    Dropzone.options.myAwesomeDropzone = {
        addRemoveLinks: true,
        dictRemoveFile: 'x',
        dictDefaultMessage: "<span>Drop files here or click to upload</span>",
        paramName: "doc_file",
        autoProcessQueue: false,
        acceptedFiles: '.pdf',
        processing: function(file) {
            $('#submit_upload_file').attr('disabled', true);
            check_upload = false;
        },
        success: function(file, response){
           var data = response.split('-');
           file.rm_id        = data[0];
           file.rm_file_name = data[1];
        },
        sending: function(file, xhr, formData){
            formData.append('doc_number', doc_number);
            formData.append('doc_type', doc_type);
            formData.append('mode', 'file');
            console.log(doc_number);
            console.log(doc_type);
        },
        removedfile: function(file) {
            var rm_id        = file.rm_id;
            var rm_file_name = file.rm_file_name;
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Wait!',
                text: 'Are you sure you want to remove this?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {
                    setTimeout(function() {
                        $.ajax({
                            url: base_url + 'Create_profile/remove_uploaded_file',
                            type: 'post',
                            data: {'rm_id': rm_id, 'rm_file_name': rm_file_name, 'doc_number': doc_number, 'doc_type': doc_type, 'mode': 'file'},
                            dataType: 'json',
                            success: function(result){
                                console.log(result);
                            }
                        })
                        file.previewElement.remove();
                    }, 200);
                }
            });
        },
        queuecomplete: function(file){
            check_upload = true;
            $('#submit_upload_file').removeAttr('disabled');
                if(check_upload != false){
                    Swal.fire({
                        allowOutsideClick: false,
                        type: 'success',
                        title: 'Success!',
                        text: 'Document Uploaded: '+doc_number,
                    }).then((result) => {
                        if(result.value){
                            //location.reload();
                        }
                    });
                }
        }
    };

    var myDropzone = new Dropzone("div#myAwesomeDropzone", { url: base_url + "Create_profile/upload_file" });

    $('#submit_upload_attachment').click(function(){
        var aDropzone_status   = [];

        if(aDropzone.files.length == 0){
            Swal.fire({
                allowOutsideClick: false,
                position: 'center',
                icon: 'error',
                title: 'Required to upload.',
                text: 'Please attach document'
            });
            return false; //if an error happened stop here kaya return false hnd na dapat mag tuloy sa baba.
        } else {
            aDropzone.processQueue();
        }

        $.each(aDropzone.files, function(k,v){
            aDropzone_status.push(v.status);
        });

       console.log(aDropzone.files);
       console.log(doc_number);
    });

    Dropzone.autoDiscover = false;
    Dropzone.options.attachmentDropzone = {
        addRemoveLinks: true,
        dictRemoveFile: 'x',
        dictDefaultMessage: "<span>Drop files here or click to upload</span>",
        paramName: "doc_file",
        autoProcessQueue: false,
        acceptedFiles: '.pdf',
        processing: function(file) {
            $('#submit_upload_attachment').attr('disabled', true);
            check_upload = false;
        },
        success: function(file, response){
           var data = response.split('-');
           file.rm_id        = data[0];
           file.rm_file_name = data[1];
        },
        sending: function(file, xhr, formData){
            formData.append('doc_number', doc_number);
            formData.append('doc_type', doc_type);
            formData.append('mode', 'attachment');
            console.log(doc_number);
            console.log(doc_type);
        },
        removedfile: function(file) {
            var rm_id        = file.rm_id;
            var rm_file_name = file.rm_file_name;
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Wait!',
                text: 'Are you sure you want to remove this?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {
                    setTimeout(function() {
                        $.ajax({
                            url: base_url + 'Create_profile/remove_uploaded_file',
                            type: 'post',
                            data: {'rm_id': rm_id, 'rm_file_name': rm_file_name, 'doc_number': doc_number, 'doc_type': doc_type, 'mode': 'attachment'},
                            dataType: 'json',
                            success: function(result){
                                console.log(result);
                            }
                        })
                        file.previewElement.remove();
                    }, 200);
                }
            });
        },
        queuecomplete: function(file){
            check_upload = true;
            $('#submit_upload_attachment').removeAttr('disabled');
                if(check_upload != false){
                    Swal.fire({
                        allowOutsideClick: false,
                        type: 'success',
                        title: 'Success!',
                        text: 'Document Uploaded: '+doc_number,
                    }).then((result) => {
                        if(result.value){
                            //location.reload();
                        }
                    });
                }
        }
    };

    var aDropzone = new Dropzone("div#attachmentDropzone", { url: base_url + "Create_profile/upload_file" });
</script>
