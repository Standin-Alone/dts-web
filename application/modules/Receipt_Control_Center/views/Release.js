$(document).ready(function () {


    console.log('test');
    $('.multiple-select2').select2({
        placeholder: 'Select an option'
    });

    $(document).find('#document_no').on('keyup', function () {
        var document_number = $(this).val()

        var originating_office = $("#originating_office")
        var originating_office_code = $("#originating_office_code")
        var current_office = $("#current_office")
        var current_office_code = $("#current_office_code")

        console.log(document_number);
        $.ajax({
            type: "get",
            url: base_url + "Receipt_Control_Center/Get_origin_current_office/" + document_number,
            dataType: "json",
            success: function (response) {
                // console.log(response);

                $.map(response, function (val, indexOrKey) {
                    // console.log(val);
                    originating_office.val(val)
                    originating_office_code.val(val)
                    current_office.val(val)
                    current_office_code.val(val)
                });
            }
        });
    })


    function render_table(){
        var released_data =  $.ajax({
            async:false,
            url: base_url + 'Receipt_Control_Center/get_released_documents',
            dataType: "json",
        }).responseJSON;
   
        var table;
        if ($.fn.dataTable.isDataTable('#Released_table')) {
            table = $('#Released_table').DataTable();
            table.clear();
            table.rows.add(released_data).draw();
        }
        else {
            table = $('#Released_table').DataTable({
                "data": released_data,
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
                            { data: 'date' },
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

    $("#action").on("change", function(){
        if ($(this).val() == "Return to Sender"){
            $(".recipients").hide();
        }else{
            $(".recipients").show();
        }
    })

    $("#form_release").on('submit', function () {
        var form_data = $('#form_release').serializeArray();
        console.log(form_data);
        var doc_number = $("#document_no").val()
        $.ajax({
            type: "post",
            url: base_url + "Receipt_Control_Center/release_document",
            data: form_data,
            dataType: "json",
            success: function (result) {
                console.log(result);
                if (result.error == "false") {
                    var subject = result.recipient_details.subject
                    var from_office = result.recipient_details.from_office
                    var sender_office = result.sender_details.office_code
                    if(result.recipient_details){
                        $.map(result.recipient_details.recipients, function (recipient, indexOrKey) {
                            //incoming
                            var message = `You have an incoming document from ${from_office} with a subject of ${subject}`
                            socket().emit('push notification', {
                            subject: subject,
                            channel: [recipient],
                            message:
                                message,
                            document_number: result.sender_details.document_number
                            });
                            
                        });
                         //previous office
                         socket().emit('push notification', {
                            channel: [ sender_office ],
                            message:
                                `Your document with a subject of ${subject} has been released from ${from_office}`,
                            document_number: result.sender_details.document_number
                        });
                        
                    }else{
                        var message = `Your document with a subject of ${subject} has been released from ${from_office}`
    
                        socket().emit('push notification', {
                        subject: subject,
                        channel: [sender_office],
                        message:
                            message,
                        document_number: result.document_number
                        });
                    }
                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'Well Done!',
                        text: result.message,
                    }).then((result) => {
                        render_table()
                        setTimeout(function () {
                            track_document(doc_number)
                        }, 200);
                    })
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
                            track_document(doc_number)
                        }, 200);
                    });
                }
            }
        });
        return false
    })


});