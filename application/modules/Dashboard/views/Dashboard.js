$(function () {
    'use strict';

    $('.copy').on('click', function () {
        var document_no = $(document).find('#text_document_number').text()

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(document_no).select();
        document.execCommand("copy");
        $temp.remove();

        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Copied To Clipboard',
            text: document_no,
            showConfirmButton: false,
            timer: 1500
        })
    })

    // var myTable = $('#logs_table').DataTable({
    //     dom: 'lfrtip',
    //     processing: true,
    //     ordering: false,
    //     serverSide: true,
    //     paging: true,
    //     ajax: {
    //         url: base_url + 'Home/get_rc_records',
    //         type: 'post'
    //     },
    //     columns: [
    //         {
    //             className: 'text-center align-middle',
    //             render: function (data, type, row) {
    //                 var link = '<a href="' + base_url + 'View_document/document/' + row.document_number + '">' + row.document_number + '</a>';
    //                 return link;
    //             }
    //         },
    //         {
    //             data: 'docu_status',
    //             className: 'text-center align-middle'
    //         },
    //         {
    //             data: 'reference_no',
    //             className: 'text-center align-middle'
    //         },
    //         {
    //             data: 'subject',
    //             className: 'text-center align-middle'
    //         },
    //         {
    //             data: 'received_by',
    //             className: 'text-center align-middle'
    //         },
    //         {
    //             className: 'text-center align-middle',
    //             render: function (data, type, row) {
    //                 var date = new Date(row.status_d_received);
    //                 var new_date = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
    //                 return new_date;
    //             }
    //         },
    //         {
    //             className: 'text-center align-middle',
    //             render: function (data, type, row) {
    //                 var str = row.time_received;
    //                 var res = str.split(":");
    //                 var hours = res[0];
    //                 var minutes = res[1];
    //                 var ampm = hours >= 12 ? 'PM' : 'AM';
    //                 hours = hours % 12;
    //                 hours = hours ? hours : 12; // the hour '0' should be '12'
    //                 var strTime = hours + ':' + minutes + ' ' + ampm;
    //                 return strTime;
    //             }
    //         }
    //     ]
    // });

    $('#all_document').on('click', function () {
        requests = '';
        $('#card_header').removeClass('text-primary');
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-info');
        $('#card_header').text('All Document');
        myTable.draw();
    });

    $('#receive_doc').on('click', function () {
        requests = 'Received';
        $('#card_header').removeClass('text-primary');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-success');
        $('#card_header').text('Received Document');
        myTable.draw();
    });

    $('#release_doc').on('click', function () {
        requests = 'Released';
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-primary');
        $('#card_header').text('Released Document');
        myTable.draw();
    });

    $('#return_doc').on('click', function () {
        requests = 'Returned';
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-primary');
        $('#card_header').addClass('text-danger');
        $('#card_header').text('Returned Document');
        myTable.draw();
    });

    function search_received(key_word) {
        console.log(key_word);
        var div = $(document).find('#released_div')

        if (key_word) {
            div.html(
                `
            <svg class="spinner my-auto mx-auto" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        `
            )
        }
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: base_url + "Dashboard/Received_documents/" + key_word,
                data: key_word,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response) {
                        // var filtered = response.fil


                        var append_html = $.map(response, function (value) {
                            var document_number = value.document_number
                            var type = value.type
                            var subject = value.subject
                            var date = value.date

                            console.log(document_number);
                            console.log(type);
                            console.log(subject);
                            console.log(date);
                            var html = `
                            <div class="card mb-0 mt-1 p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex flex-column mt-1">
                                        <span class="h6 m-0">Document No: <label> ${document_number}</label></span>
                                        <span class="h6 m-0">Document Type: <label>${type}</label> </span>
                                        <span class="h6 m-0">Subject: <label> ${subject}</label></span>
                                    </div>
                                    <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Released: ${date}</span>
                                </div>
                            </div>
                            `
                            return html
                        });

                        div.html(append_html)
                    } else {
                        var append_html = `
                                            No Records Found
                                          `

                        div.html(append_html)
                    }
                }
            });
        }, 1500);
    }


    function search_released(key_word) {
        console.log(key_word);
        var div = $(document).find('#released_div')

        if (key_word) {
            div.html(
                `
            <svg class="spinner my-auto mx-auto" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        `
            )
        }
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: base_url + "Dashboard/Released_documents/" + key_word,
                data: key_word,
                dataType: "json",
                success: function (response) {
                    if (response) {
                        var append_html = $.map(response, function (value) {
                            var document_number = value.document_number
                            var type = value.type
                            var subject = value.subject
                            var date = value.date

                            console.log(document_number);
                            console.log(type);
                            console.log(subject);
                            console.log(date);
                            var html = `
                            <div class="card mb-0 mt-1 p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex flex-column mt-1">
                                        <span class="h6 m-0">Document No: <label> ${document_number}</label></span>
                                        <span class="h6 m-0">Document Type: <label>${type}</label> </span>
                                        <span class="h6 m-0">Subject: <label> ${subject}</label></span>
                                    </div>
                                    <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Released: ${date}</span>
                                </div>
                            </div>
                            `
                            return html
                        });

                        div.html(append_html)
                    }
                }
            });
        }, 1500);
    }

    $(document).find('#search_released').on('keyup', function () {
        var data = $(this).val()
        search_released(data)
    })
    $(document).find('#released_btn').on('click', function () {
        var data = $(document).find('#search_released').val()
        search_released(data)
    })


    $(document).find('#track_document_btn').on('click', function () {
        var document_number = $(document).find('#track_document').val()

        $(document).find("#type").text('')
        $(document).find("#subject").text('')
        $(document).find("#origin").text('')
        if (document_number) {
            var timeline = $(document).find('#timeline')
            $.ajax({
                url: base_url + "Dashboard/get_history/" + document_number,
                data: document_number,
                dataType: "json",
                success: function (response) {
                    var message = response.Message
                    var document_details = response.document_details

                    console.log(response);
                    console.log(document_details);
                    if (message == "no records") {
                        Swal.fire({
                            icon: 'error',
                            type: 'danger',
                            title: 'Invalid Document Number',
                            text: "No records found",
                        }).then((result) => {
                            setTimeout(function () {

                            }, 200);
                        });
                    } else {
                        if (message == 'true') {
                            $('#modal_track').modal('show');
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
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                type: 'danger',
                title: 'Oops!',
                text: 'Please Input Document Number',
            })
        }
    })

    $(document.body).on('submit', '#received_document', function (e) {
        e.preventDefault();
        var input = $(document).find("#received_document_btn")

        if (input.val()) {

            console.log(form_data);

            $.ajax({
                type: "post",
                url: base_url + "Dashboard/receive_document",
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

    // ====================================UPLOADING====================================

    $(document).find(".check_status").each(function (i) {
        var check_status_btn = $(this)

        check_status_btn.on('click', function () {
            $(document).find("#modal_check_status").modal('show');

            var document_number = $(this).parents(".row").find(".status_document_number").text()

            $.ajax({
                type: "post",
                url: base_url+'Dashboard',
                data: document_number,
                dataType: "dataType",
                success: function (response) {

                }
            });
        })
    })
});