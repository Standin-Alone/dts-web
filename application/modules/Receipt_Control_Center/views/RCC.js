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

    function track_document(document_number) {

        // loading.show()
        setTimeout(() => {
            $('#modal_track').modal('show')
            var timeline = $(document).find('#timeline')
            $.ajax({
                url: base_url + "Receipt_Control_Center/get_history/" + document_number,
                data: document_number,
                dataType: "json",
                success: function (response) {
                    var message = response.Message
                    var document_details = response.document_details

                    console.log(response);
                    console.log(document_details);
                    if (message == 'true') {

                        $.map(document_details, function (val) {
                            $(document).find("#type").text(' ' + val.type)
                            $(document).find("#subject").text(' ' + val.subject)
                            $(document).find("#origin").text(' ' + val.INFO_SERVICE + '-' + val.INFO_DIVISION)
                        })

                        $(document).find("#text_document_number").text(document_number)

                        timeline.parent().addClass('scrollbar')
                        var html = $.map(response.history, function (val, i) {
                            var type = val.type
                            var status = val.status
                            var date = val.time
                            var remarks = val.remarks
                            var subject = val.subject
                            var action = val.action
                            var service = val.INFO_SERVICE
                            var division = val.INFO_DIVISION
                            var assign_p = val.transacting_user_fullname

                            function check_type(status, type) {
                                if (type == "Received" && status == 1) {
                                    return `
                                    <span class=" badge badge-lg badge-success mb-2">
                                        <h2 class="h5 mb-0">Received</h2>
                                    </span>
                                `
                                }
                                if (type == "Received" && status == 0) {
                                    return `
                                    <div class="d-flex flex-row align-items-center">
                                        <span class=" badge badge-lg badge-danger">
                                            <h2 class="h5 mb-0">Received</h2> 
                                        </span>
                                        <span class="mx-2">
                                            <h2 class="h6 text-danger my-auto"><i class="fa fa-exclamation-circle mr-1"></i>Unauthorized Recipient</h2> 
                                        </span>
                                    </div>
                                `
                                }
                                if (type == "Released" && status == 1) {
                                    return `
                                <span class="badge badge-lg badge-warning mb-2">
                                    <h2 class="h5 mb-0">Released</h2>
                                </span>
                            `
                                }
                                if (type == "Released" && status == 0) {
                                    return `
                                <div class="d-flex flex-row align-items-center">
                                    <span class=" badge badge-lg badge-danger">
                                        <h2 class="h5 mb-0">Released</h2> 
                                    </span>
                                    <span class="mx-2">
                                        <h2 class="h6 text-danger my-auto"><i class="fa fa-exclamation-circle mr-1"></i>Unauthorized Recipient</h2> 
                                    </span>
                                </div>
                            `
                                }
                            }

                            function check_status(status) {
                                if (status == '1') {
                                    return 'style="background-color: #ffffff"'
                                } else {

                                    return 'style="background-color: #f7ecec"'
                                }
                            }

                            function is_remarks(type, remarks) {

                                if (type == 'Released') {
                                    return `<span class="d-flex flex-row align-items-start">
                                            Remarks: 
                                            <h6 class="font-weight-normal ml-2"> ${remarks}</h6>
                                            </span>
                                `
                                } else {
                                    return ""
                                }
                            }
                            return `
                            <li class="timeline-item rounded ml-3 p-4 shadow-sm" `+ check_status(status) + `>
                                <div class="timeline-arrow"></div>
                                <div class="d-flex flex-column p-4">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start">
                                          ${check_type(status, type)}
                                          <span class="small text-gray"><i class="fas fa-clock mr-1"></i>${date}</span>
                                        </div>
                                    </div>
                                    <span class="d-flex flex-row align-items-start">
                                        Action: <h6 class="font-weight-normal ml-2 mt-1"> ${action}</h6>
                                    </span>
                                    <span class="d-flex flex-row mt-2 align-items-start">
                                        Office:
                                        <span class="d-flex flex-column">
                                            <h6 class="font-weight-normal ml-2 ">${division}</h5>
                                            <h6 class="font-weight-normal ml-2 ">${service}</h5>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-row align-items-start">
                                        Assigned Personnel: <h6 class="font-weight-normal ml-2 mt-1"> ${assign_p}</h6>
                                    </span>
                                    `+
                                is_remarks(type, remarks)
                                + `
                                </div>
                            </li>
                        `
                        });

                        timeline.html(html)
                    } else {
                        var html = `
                            <li class="timeline-item bg-white rounded ml-3 p-4 shadow-sm">
                                <div class="timeline-arrow"></div>
                                <div class="d-flex flex-column p-4">
                                    <span class="d-flex flex-row mt-2">
                                        <h5 class=" ml-2"> No Transactions Found</h5>
                                    </span>
                                </div>
                            </li>
                                    
                                    `
                        timeline.html(html)
                    }
                }
            });
        }, 200);
    }


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
                    if (result.error == "false") {
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'Well Done!',
                            text: result.message,
                        }).then((result) => {
                            setTimeout(function () {
                                $('#receive_btn').removeAttr('disabled')
                                track_document(input.val())
                            }, 200);
                        });
                    }
                    if (result.error == "true") {
                        Swal.fire({
                            icon: 'info',
                            type: 'warning',
                            title: 'Oops!',
                            text: result.message,
                        }).then((result) => {
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
                        icon: 'info',
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