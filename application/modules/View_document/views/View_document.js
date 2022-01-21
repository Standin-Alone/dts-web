$(function() {
    'use strict';

    $('#recipients_office_code').select2({
      dropdownParent: $("#addRecModal"),
      placeholder: "Office / Division",
      allowClear: true,
      minimumResultsForSearch: 10,
      width: '100%',
      ajax: {
        url: base_url + 'View_document/get_offices',
        type: 'get',
        dataType: 'json',
        data: function(params){
          var queryParameters = {
                    'document_number': doc_number,
                    term: params.term
                }
                return queryParameters;
        },
        processResults: function(data){
          return {
                results: data
            };
        }
      }
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

    $("#signatory_emp").autocomplete({
        source: function( request, response ) {
            //var sig_emp_code = $('#signatory_emp').val();
            $.getJSON( base_url+'View_document/get_signature_da_name', {
            //$.getJSON( 'View_document/../get_signature_da_name', {
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
            //var sig_emp_code = $('#signatory_office').val();
            $.getJSON( base_url+'View_document/get_signature_div_da', {
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

    $("#add_recipients").autocomplete({
        source: function( request, response ) {
            $.getJSON( base_url+'View_document/get_recipients_autocomplete', {
                //'document_number': doc_number,
                'term': request.term
            }, response );
        },
        appendTo: $("#addRecModal"), // path to the get_birds method
        select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            $('#recipients_office_code').val(ui.item.value);
        },
        change: function (event, ui) {
            if (!ui.item) {
                $(this).val("");
                $('#recipients_office_code').val("");
            }
        }
    });

    $('.update_information').on('click', function() {
        $.ajax({
            type:'post',
            url: base_url + 'View_document/edit_document_info',
            dataType: 'json',
            data:  { document_number: doc_number},
                success:function(r) {
                    console.log(r);
                    $.each(r, function(k,v) {
                        $('#date').val(v.date);
                        $('#document_type').val(v.type);
                        $('#for').val(v.for);
                        $('#origin_type').val(v.origin_type);
                        if(v.origin_type == 'External'){
                            $('#origin_type').trigger('change');
                            $('#sender_name').val(v.sender_name);
                            $('#sender_position').val(v.sender_position);
                            $('#sender_address').val(v.sender_address);
                        } else {
                            $('#origin_type').trigger('change');
                            $('#sender_name,#sender_position,#sender_address').val('');
                        }
                        $('#subject').val(v.subject);
                        $('#remarks').val(v.remarks);
                    });
                }
        });
        $('#update_info_modal').modal('show');
    });

    $('#edit_profile').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                // date: {
                //     required: true
                // },
                // document_type: {
                //     required: true
                // },
                for: {
                    required: true
                },
                origin_type: {
                    required: true
                },
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

                $('#save_update_info').attr('disabled', false);
                var formData = $('#edit_profile').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>View_document/update_document_info",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed',
                                text: 'Document Information Successfully Updated.'
                            }).then((result) => {
                                if(result.value){
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
        }
    });

$('#edit_recipient').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                add_recipients: {
                    required: true
                },
                recipients_office_code: {
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

                $('#modal_add_rec_btn').attr('disabled', false);
                var formData = $('#edit_recipient').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>View_document/add_document_recipient",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed',
                                text: 'Document Information Successfully Updated.'
                            }).then((result) => {
                                if(result.value){
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
        }
    });

    $('#add_sig_modal').on('click', function() {
        $('#addEmpModal').modal('show');
    });

    $('.update_recipients ').on('click', function() {
        $('#addRecModal').modal('show');
    });

    $('#edit_signatories').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                signatory_emp: {
                    required: true
                },
                sinatory_designation: {
                    required: true
                },
                signatory_office: {
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

                $('#modal_add_sig_btn').attr('disabled', false);
                var formData = $('#edit_signatories').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>View_document/insert_signatories",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed',
                                text: 'Document Information Successfully Updated.'
                            }).then((result) => {
                                if(result.value){
                                    //$('#addEmpModal').modal('hide');
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
        }
    });

    $(document.body).on('click', '#remove_sig_modal', function(){
        //alert('1');
        $('#body_signature').html('');
        $.ajax({
            url: base_url + 'View_document/get_signature_list',
            type: 'post',                                                                                                                                  
            data: {'document_number': doc_number},
            dataType: 'json',
            success: function(results){
                var ie;
                var table_row = '';
                var count = results.length;
                console.log(count);
                for (ie = 0; ie < count; ie++) {
                    table_row += '<tr>';
                    table_row += '<td class="text-center td_emp">'+results[ie].signatory_user_fullname+'</td>';
                    table_row += '<td class="text-center td_desig">'+results[ie].designation+'</td>';
                    table_row += '<td class="text-center"><span class="td_office">'+results[ie].INFO_DIVISION+'</span>'+
                        '</td>';
                    table_row += '<td class="text-center">'+
                            '<i data-id_sig="'+results[ie].signatory_id+'" class="fas fa-trash remove_sig" style="color: #f59c1a;border-color:#f59c1a;" title="Remove"></i>'+
                        '</td>';
                    table_row += '</tr>';
                }
                $('#body_signature').append(table_row);
                $('#removeEmpModal').modal('show'); 
            }

        });
        $('#removeEmpModal').modal('show');                        
    });

    $(document.body).on('click', '#remove_rec_modal', function(){
        //alert('1');
        $('#body_recipients').html('');
        $.ajax({
            url: base_url + 'View_document/get_recipients_list',
            type: 'post',                                                                                                                                  
            data: {'document_number': doc_number},
            dataType: 'json',
            success: function(r){
                var ie;
                var table_row = '';
                var count = r.length;
                console.log(r);
                for (ie = 0; ie < count; ie++) {
                    table_row += '<tr>';
                    table_row += '<td class="text-center"><span class="td_office">'+(r[ie].SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '')+r[ie].ORIG_SHORTNAME+' / '+(r[ie].INFO_DIVISION == '' ? r[ie].INFO_SERVICE : r[ie].INFO_SERVICE+' / '+r[ie].INFO_DIVISION).toUpperCase()+'</span>'+
                        '</td>';
                    table_row += '<td class="text-center">'+r[ie].added_by_user_fullname+
                        '</td>';
                    if(r[ie].added_by_user_office == office_code){
                        if(r[ie].active == '0'){
                            table_row += '<td class="text-center">'+
                                '<i class="fas fa-trash" style="color: #808080;border-color:#f59c1a;" title="Remove Disabled"></i>'+
                            '</td>';
                        } else {
                            table_row += '<td class="text-center">'+
                            '<i data-id_rec="'+r[ie].recipient_id+'" class="fas fa-trash remove_rec" style="color: #f59c1a;border-color:#f59c1a;" title="Remove"></i>'+
                            '</td>';
                        }
                    } else {
                        table_row += '<td class="text-center">'+
                            '<i class="fas fa-trash" style="color: #808080;border-color:#f59c1a;" title="Remove Disabled"></i>'+
                        '</td>';
                    }
                    table_row += '</tr>';
                }



                $('#body_recipients').append(table_row);
                $('#removeRecModal').modal('show'); 
            }

        });
                       
    });


    $(document.body).on('click', '.remove_sig', function() {
        var id_sig = $(this).data('id_sig');

        Swal.fire({
            icon: 'warning',
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
                                icon: 'success',
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

    $(document.body).on('click', '.remove_rec', function() {
        var id_rec = $(this).data('id_rec');

        Swal.fire({
            icon: 'warning',
            title: 'Wait!',
            text: 'Are you sure you want to remove this?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: base_url + 'View_document/remove_recipient',
                    method:"POST",  
                    data: { id_rec: id_rec },
                    dataType: 'json', 
                    success:function(r)  
                    {
                        if(r == 'success'){
                            console.log(r);
                            Swal.fire({
                                icon: 'success',
                                title: 'Remove Completed',
                                text: 'Document Recipient has been removed.'
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
                                icon: 'success',
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
            }
        });
    });

    $(document.body).on('click', '.archive_btn', function() {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: 'Archive this document?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: base_url + 'View_document/archive_document',
                    method:"POST",  
                    data: { doc_number: doc_number },
                    dataType: 'json', 
                    success:function(r)  
                    {
                        if(r == 'success'){
                            console.log(r);
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed',
                                text: 'Document Archived.'
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
