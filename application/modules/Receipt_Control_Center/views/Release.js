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

    $("#release_btn").on('click', function () {
        var form_data = $('#form_release').serializeArray();
        console.log(form_data);

        $.ajax({
            type: "post",
            url: base_url + "Receipt_Control_Center/release_document",
            data: form_data,
            dataType: "json",
            success: function (result) {
                console.log(result);
                if (result.error == "false") {
                    if(result.recipient_details){
                        var subject = result.recipient_details.subject
                        var from_office = result.recipient_details.from_office
                        $.map(result.recipient_details.recipients, function (recipient, indexOrKey) {
                           
                            //incoming
                            var message = `Your have an incoming document from ${from_office} with a subject of ${subject}`
                            socket().emit('push notification', {
                            channel: recipient,
                            message:
                                message,
                            });
                        });

                         //previous office
                        var sender_office = result.sender_details.office_code
                         socket().emit('push notification', {
                            channel: { sender_office },
                            message:
                                `Your document with a subject of ${subject} has been released from ${from_office}`,
                        });
                        
                    }else{
                        var subject = result.recipient_details.subject
                        var from_office = result.recipient_details.from_office
                        var message = `Your document with a subject of ${subject} has been released from ${from_office}`
    
                        socket().emit('push notification', {
                        channel: result.sender_details.office_code,
                        message:
                            message,
                        });
                    }
                    

                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'Well Done!',
                        text: result.message,
                    }).then((result) => {
                        setTimeout(function () {
                            track_document(input.val())
                        }, 200);
                        location.reload();
                    })
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
        return false
    })


});