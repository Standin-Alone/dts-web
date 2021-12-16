$(function() {
    'use strict';

    $('#date_received').mask("99/99/9999");

    $('#receive_button').on('click', function() {
        $('#status').val('Received');
        $('#modal_release_btn').text('Receive');
        $('#status_modal_title').text('Receive Document');
        $('#modal_release_btn').removeClass('btn-danger');
        $('#modal_release_btn').removeClass('btn-primary');
        $('#modal_release_btn').addClass('btn-success');
        $('#status_modal').modal('show');
    });

    $('#release_button').on('click', function() {
        $('#status').val('Released');
        $('#modal_release_btn').text('Release');
        $('#status_modal_title').text('Release Document');
        $('#modal_release_btn').removeClass('btn-danger');
        $('#modal_release_btn').removeClass('btn-success');
        $('#modal_release_btn').addClass('btn-primary');
        $('#status_modal').modal('show');
    });

    $('#return_button').on('click', function() {
        $('#status').val('Returned');
        $('#modal_release_btn').text('Return');
        $('#status_modal_title').text('Return Document');
        $('#modal_release_btn').removeClass('btn-primary');
        $('#modal_release_btn').removeClass('btn-success');
        $('#modal_release_btn').addClass('btn-danger');
        $('#status_modal').modal('show');
    });

    $('#status_modal').on('hidden.bs.modal', function (e) {
        $('#status').val('');
        $('#modal_release_btn').text('');
    });

    $('#edit_document').on('click', function() {
        $.ajax({
            type:'post',
            url: base_url + 'View_document/edit_document_info',
            dataType: 'json',
            data:  { document_number: document_number},
                success:function(r) {
                    $.each(r, function(k,v) {
                        $('#reference_no').val(v.reference_no);
                        $('#doc_type').val(v.doc_type_id);
                        $('#subject').val(v.subject);
                        $('#document_year').val(v.document_year);
                        $('#remarks').val(v.remarks);
                    });
                }
        });
        $('#edit_document_modal').modal('show');
    });

    $('#edit_sender').on('click', function() {
        $.ajax({
            type:'post',
            url: base_url + 'View_document/edit_document_info',
            dataType: 'json',
            data:  { document_number: document_number},
                success:function(r) {
                    $.each(r, function(k,v) {
                        // if(v.company == 'DA'){
                        //  $('#da_selection').css('display' , '');
                        //  $('#other_selection').css('display' , 'none');
                        //  $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
                        //  $('[name="company_name"],[name="company_code"],[name="sender_name"],[name="sender_office"]').attr('required', true);
                        // } else {
                        //  $('#other_selection').css('display' , '');
                        //  $('#da_selection').css('display' , 'none');
                        //  $('[name="company_name"],[name="company_code"],[name="sender_name"],[name="sender_office"]').attr('required', true);
                        //  $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
                        // }

                        if(v.company == 'DA'){
                            $('#da_selection').css('display' , '');
                            $('#other_selection').css('display' , 'none');
                            $('[name="offices"],[name="services"],[name="divisions"]').attr('required', true);
                            $('[name="company_name"],[name="company_code"]').attr('required', false);
                        } else {
                            $('#other_selection').css('display' , '');
                            $('#da_selection').css('display' , 'none');
                            $('[name="company_name"],[name="company_code"]').attr('required', true);
                            $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
                        }
                        $('#company').val(v.company);
                        $('#company_name').val(v.comp_name);
                        $('#company_code').val(v.company_code);
                        $('#tracking_no').val(v.tracking_no);
                        $('#sender_name').val(v.sender_name);
                        $('#sender_office').val(v.sender_office);
                        s_code = v.service_code;
                        o_code = v.office_code;
                        d_code = v.division_code;
                        $('#offices').val(v.office_code).change();
                    });
                }
        });
        $('#edit_sender_modal').modal('show');
    });

    $('#offices').on('change', function() {
        var office_code = $(this).val();
        $.ajax({
            url: base_url + 'View_document/get_da_services',
            type: 'POST',
            data: {'office_code': office_code},
            dataType: 'json',
            success: function(data){
                var options = '';

                $.each(data, function(k,v) {
                    options += '<option value="'+v.ID_SERVICE+'">'+v.INFO_SERVICE+'</option>';
                });

                $('#services').html(options);
                //$('#divisions').html('<option value="">Divisions</option>');
                $('#services').val(s_code).change();
            }
        });
    });

    $('#services').on('change', function(){
        var service_code = $(this).val();
        var office_code = $('#offices').val();
        $.ajax({
            url: base_url + 'View_document/get_da_divisions',
            type: 'POST',
            dataType: 'json',
            data: {'service_code': service_code, 'office_code': office_code},
            success: function(data) {
                var options='';

                $.each(data, function(k, v) {
                    options+='<option value="'+v.ID_DIVISION+'">'+v.INFO_DIVISION+'</option>';
                });

                $('#divisions').html(options);
                $('#divisions').val(d_code).change();
            }
        });
    });


    $('[name="company"]').on('change', function(){
        var value = $(this).val();

        if(value == 'DA'){
            $('#da_selection').css('display' , '');
            $('#other_selection').css('display' , 'none');
            $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
            $('[name="company_name"],[name="company_code"],[name="sender_name"],[name="sender_office"]').attr('required', true);
        } else {
            if(value == 'OA'){
                $('#da_selection').css('display' , '');
                $('#other_selection').css('display' , 'none');
                $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
                $('[name="company_name"],[name="company_code"],[name="sender_name"],[name="sender_office"]').attr('required', true);
            } else {
                $('#other_selection').css('display' , '');
                $('#da_selection').css('display' , 'none');
                $('[name="company_name"],[name="company_code"],[name="sender_name"],[name="sender_office"]').attr('required', true);
                $('[name="offices"],[name="services"],[name="divisions"]').attr('required', false);
            }
        }
    });

    $("#company_name").autocomplete({
        source: function( request, response ) {
            var company = $('#company').val();
            //var comp = company == 'CR' ? "get_courier" : company == 'PT' ? "get_phlpost" : "get_agency";
            var comp = company == 'CR' ? "get_courier" : "get_agency";
            $.getJSON( base_url+'View_document/'+comp, {
                'term': request.term
            }, response );
        },
        appendTo: $("#edit_sender_modal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#company_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#company_code').val("");
            }
        }
    });

    $('#add_sig_modal').on('click', function() {
        $('#addEmpModal').modal('show');
    });

    $("#signatory_emp").autocomplete({
        source: function( request, response ) {
            var sig_emp_code = $('#signatory_emp').val();
            $.getJSON( '../../View_document/get_signature_da_name', {
                'agency_id': '9304df8f-a323-453d-a458-ab728e1bc419',
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
            $.getJSON( '../../View_document/get_signature_div_da', {
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

    $("#oth_name").autocomplete({
        source: function( request, response ) {
            var sig_emp_code = $('#oth_name').val();
            $.getJSON( '../../View_document/get_signature_notda_name', {
                'agency_id': '9304df8f-a323-453d-a458-ab728e1bc419',
                'term': request.term
            }, response );
        },
        appendTo: $("#addEmpModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#modal_oth_name_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#modal_oth_name_code').val("");
            }
        }
    });

    $("#oth_office").autocomplete({
        source: function( request, response ) {
            var sig_emp_code = $('#oth_office').val();
            $.getJSON( '../../View_document/get_signature_office_other', {
                'agency_id': '9304df8f-a323-453d-a458-ab728e1bc419',
                'term': request.term
            }, response );
        },
        appendTo: $("#addEmpModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#modal_oth_office_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#modal_oth_office_code').val("");
            }
        }
    });

 // $(document.body).on('submit', '#signatories_details', function() {
 //        var form_data = $(this).serializeObject();
 //        $('#finish').attr('disabled', true);
 //        $('#finish').attr('type', 'button');
 //        $.ajax({
 //            url: base_url + 'Insert_document/insert_signatories', 
 //            type: 'post',
 //            data: form_data,
 //            dataType: 'json',
 //            success: function(result){
 //                if(result == 'success'){
 //                    var doc_number  = form_data['doc_number'];
 //                        Swal.fire({
 //                            type: 'success',
 //                            title: 'Well Done!',
 //                            text: 'You have successfully profiled the document',
 //                        }).then((result) => {
 //                            setTimeout(function() {
 //                                var doc_number  = form_data['doc_number'];
 //                                window.location = base_url + 'View_document/document/' + doc_number;
 //                            }, 200);
 //                        });

 //                }
 //            }
 //        });
        
 //        return false;
 //    });

    $(document.body).on('click', '#modal_sig_add_btn', function() {
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

        if(signatory_office_code == ''){xa
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please select and click in the list of Office',
            });
            return false;
        }

        // var tr = '<tr>'+
        //             '<td class="text-center td_emp">'+signatory_emp+'</td>'+
        //             '<td class="text-center td_desig">'+designation+'</td>'+
        //             '<td class="text-center"><span class="td_office">'+signatory_office+'</span>'+
        //                 '<input type="hidden" name="signatory_emp_code[]" value="'+signatory_emp_code+'">'+
        //                 '<input type="hidden" name="signatory_designation_desc[]" value="'+designation+'">'+
        //                 '<input type="hidden" name="signatory_office_code[]" value="'+signatory_office_code+'">'+
        //                 '<input type="hidden" name="signatory_type[]" value="1">'+
        //             '</td>'+
        //             '<td>Employee</td>'+
        //             '<td class="text-center">'+
        //                 '<i data-sigemp="'+signatory_emp+'" data-sigpos="'+designation+'" data-sigoffice="'+signatory_office+'" data-sigempcode="'+signatory_emp_code+'" data-sigoffcode="'+signatory_office_code+'" class="fas fa-edit cursor edit_sig" title="Edit"></i>&nbsp;'+
        //                 '<i class="fas fa-trash-alt cursor remove_sig" title="Remove"></i>'+
        //             '</td>'+
        //          '</tr>';

        // $('#tr_btn').before(tr);

        // $('#signatory_emp').val('');
        // $('[name="sinatory_designation"]').val('');
        // $('#signatory_office').val('');

        // $('#addEmpModal').modal('hide');
    });

    $(document.body).on('click', '.modal_sig_add_oth_btn', function() {
        var oth_name   = $('#oth_name');
        var oth_desig  = $('#oth_desig');
        var oth_office = $('#oth_office');
        var oth_name_code   = $('#modal_oth_name_code');
        var oth_office_code = $('#modal_oth_office_code');

        var tr = '<tr>'+
                    '<td class="text-center td_emp">'+oth_name.val()+'</td>'+
                    '<td class="text-center td_desig">'+oth_desig.val()+'</td>'+
                    '<td class="text-center"><span class="td_office">'+oth_office.val()+'</span>'+
                        '<input type="hidden" name="signatory_emp_code[]" value="'+oth_name_code.val()+'">'+
                        '<input type="hidden" name="signatory_designation_desc[]" value="'+oth_desig.val()+'">'+
                        '<input type="hidden" name="signatory_office_code[]" value="'+oth_office_code.val()+'">'+
                        '<input type="hidden" name="signatory_type[]" value="0">'+
                    '</td>'+
                    '<td class="text-center">Others</td>'+
                    '<td class="text-center">'+
                        '<i data-sigemp="'+oth_name.val()+'" data-sigpos="'+oth_desig.val()+'" data-sigoffice="'+oth_office.val()+'" data-sigempcode="'+oth_name.val()+'" data-sigoffcode="'+oth_office.val()+'" class="fas fa-edit cursor"></i>&nbsp;'+
                        '<i class="fas fa-trash-alt cursor remove_sig"></i>'+
                    '</td>'+
                 '</tr>';

        $('#tr_btn').before(tr);

        oth_name.val('');
        oth_desig.val('');
        oth_office.val('');

        $('#addEmpModal').modal('hide');
    });

    $('#addEmpModal').on('hidden.bs.modal', function (e) {
        $('#signatory_emp').val('');
        $('[name="sinatory_designation"]').val('');
        $('#signatory_office').val('');
        $('[name="modal_sig_emp_code"]').val('');
        $('[name="modal_sig_office_code"]').val('');

        $('#v-pills-profile-tab').removeClass('active');
        $('#v-pills-home-tab').addClass('active');
        $('#v-pills-profile').removeClass('show active');
        $('#v-pills-home').addClass('show active');

        $('#modal_add_sig_btn').removeClass('modal_sig_edit_btn');
        $('#modal_add_sig_btn').removeClass('modal_sig_add_oth_btn');
        $('#modal_add_sig_btn').addClass('modal_sig_add_btn');
        $('#modal_add_sig_btn').text('Add');
    });

    $('#v-pills-home-tab').click(function() {
        $('#modal_add_sig_btn').removeClass('modal_sig_add_oth_btn');
        $('#modal_add_sig_btn').addClass('modal_sig_add_btn');
        $('#signatory_emp,#modal_sig_emp_code,#sinatory_designation,#signatory_office,#modal_sig_office_code').val('');
    });

    $('#v-pills-profile-tab').click(function() {
        $('#modal_add_sig_btn').removeClass('modal_sig_add_btn');
        $('#modal_add_sig_btn').addClass('modal_sig_add_oth_btn');
        $('#oth_name,#modal_oth_name_code,#oth_desig,#oth_office,#modal_oth_office_code').val('');
    });

    $(document.body).on('click', '.remove_sig', function() {
        var id_sig = $(this).data('id_sig');

        Swal.fire({
            type: 'warning',
            title: 'Wait!',
            text: 'Are you sure you want to remove this?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: base_url + 'View_document/remove_signature',
                    method:"POST",  
                    data: { id_sig: id_sig },
                    dataType: 'json', 
                    success:function(r)  
                    {
                        if(r == 'success'){
                            console.log(r);
                            Swal.fire({
                                type: 'success',
                                title: 'Remove Completed',
                                text: 'Document signatory has been removed.'
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

    $(document.body).on('click', '.release_btn', function() {
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
                        type: 'success',
                        title: 'Completed',
                        text: 'Document Released.'
                    }).then((result) => {
                        if(result.value){
                            //location.reload();
                        }
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }

        });
    });

});
