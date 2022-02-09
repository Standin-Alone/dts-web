$(document).ready(function () {
    console.log('test');
    // $('#form_receive').on('submit', function (e) {
    //     e.preventDefault();
    //     var form_data = $(this).serializeArray();
    //     console.log(form_data);
    // })

    // // $('#form_receive').on('submit', function () {
    // //     var data = $(this).serializeObject()
    // //     console.log(data);

    // //     return false
    // // })

    function render_table(){
        var received_data =  $.ajax({
            async:false,
            url: base_url + 'Dashboard/get_received_documents',
            dataType: "json",
        }).responseJSON;
   
        var table;
        if ($.fn.dataTable.isDataTable('#received_table2')) {
            table = $('#received_table2').DataTable();
            table.clear();
            table.rows.add(received_data).draw();
        }
        else {
            table = $('#received_table2').DataTable({
                "data": received_data,
                "deferRender": true,
                "pageLength": 10,
                "retrieve": true,
                columns: [
                            { data: 'document_number' },
                            { data: 'document_type' },
                            { data: 'origin_type' },
                            { data: 'subject' },
                            { data: 'document_origin' },
                            {
                                data: 'status', render: function (data) {
                                    return data == '0' ? "<h5><span class='badge badge-danger'>Invalid Log</span></h5>" : "<h5><span class='badge badge-success'>Valid Log</span></h5>"
                                }
                            },
                            { data: 'log_date' },
                            {
                                data: 'document_number', render: function (data) {
                                    return `
                                    <div class="btn-group">
                                        <a type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" caret="false">
                                            <i class="fa fa-sliders-h"></i> More
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a target="_blank" href="${base_url}View_document/document/${data}" class=" dropdown-item d-flex justify-content-between align-items-center text-secondary"> <i class="fa fa-file-alt"></i> View Document</a>
                                            <button class="dropdown-item d-flex justify-content-between align-items-center text-secondary" type="button"><i class="fa fa-search-location"></i> Document Logs</button>
                                        </div>
                                    </div>
                                    `
                                }
                            }
                        ],
                        columnDefs: [
                            { orderable: false, targets: 7 }
                        ],
                        order: [[6, "desc"]]
        // console.log(released_data);
            })
        }
    }
    render_table()



    var doc_history = $(document).find("#doc_history")
    var loading = $(document).find("#loading_modal")
    var input = $('#document_number')
    // loading.hide()


    input.on('keyup', function () {
        if ($(this).val() != null || $(this).val() != '') {
            $(this).removeClass('parsley-error')
            $(this).addClass('is-valid')
        } else {
            $(this).addClass('is-invalid')
        }
    })

    $(document.body).on('submit', '#form_receive', function (e) {
        e.preventDefault();

        if (input.val()) {
            $('#receive_btn').attr('disabled', true);
            var form_data = $(this).serializeArray();
            console.log(form_data);
            $.ajax({
                type: "post",
                url: base_url + "Receipt_Control_Center/receive_document",
                data: form_data,
                dataType: "json",
                success: function (result) {
                    console.log(result);


                    if (result.error == "false") {
                        var office = result.sender_details.office
                        var office_code = result.sender_details.office_code
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'Well Done!',
                            text: result.message,
                        }).then((result) => {
                            var message = `Your document has been received by ${office}`

                            socket().emit('push notification', {
                                channel: [office_code],
                                message:
                                    message,
                                document_number: result.document_number
                            });
                            render_table()
                            setTimeout(function () {
                                $('#receive_btn').removeAttr('disabled')
                                track_document(input.val())
                            }, 200);
                        });
                    }
                    if (result.error == "true") {
                        Swal.fire({
                            icon: 'error',
                            type: 'warning',
                            title: 'Oops!',
                            text: result.message,
                        }).then((result) => {
                            render_table()
                            setTimeout(function () {
                                $('#receive_btn').removeAttr('disabled')
                                track_document(input.val())
                            }, 200);
                        });
                    }
                    // console.log(result);
                    // if (result.Message == 'true') {
                    //     console.log(result);
                    //     Swal.fire({
                    //         type: 'success',
                    //         title: 'Well Done!',
                    //         text: 'You have successfully received the document',
                    //     }).then((result) => {
                    //         setTimeout(function () {

                    //         }, 200);
                    //     });
                    // } else if (result.Message == 'false') {
                    //     console.log(result);
                    //     Swal.fire({
                    //         type: 'danger',
                    //         title: 'Oops!',
                    //         text: 'Unauthorized Recepient',
                    //     }).then((result) => {
                    //         setTimeout(function () {

                    //         }, 200);
                    //     });
                    // }
                }
            });

        } else {
            input.addClass('parsley-error')
            var text_error = `
            `
            input.parents('form').find('.error').text('This field is required')
        }

        return false;
    });


    $(document.body).on('submit', '#form_release', function (e) {
        e.preventDefault();
        var form_data = $(this).serializeArray();

        console.log(form_data);

        $.ajax({
            type: "post",
            url: base_url + "Receipt_Control_Center/receive_document",
            data: form_data,
            dataType: "json",
            success: function (result) {
                console.log(result);
                if (result.error == "false") {
                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'Well Done!',
                        text: result.message,
                    }).then((result) => {
                        setTimeout(function () {
                            track_document(input.val())
                        }, 200);
                    });
                }

                if (result.error == "true") {
                    Swal.fire({
                        icon: 'error',
                        type: 'warning',
                        title: 'Oops!',
                        text: result.message,
                    }).then((result) => {
                        setTimeout(function () {

                        }, 200);
                    });
                }
            }
        });

        return false;
    });

    $(document).find(".track_btn").on('click', function () {
        var document_number = $(this).parents('tr').find('td').first().text()
        console.log(document_number);
        track_document(document_number)
    })
});