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
    var input = $('#document_number')

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
            var form_data = $(this).serializeArray();

            console.log(form_data);

            $.ajax({
                type: "post",
                url: base_url + "Receipt_Control_Center/receive_document",
                data: form_data,
                dataType: "json",
                success: function (result) {

                    if (result.error == "false" && result.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Well Done!',
                            text: result.message,
                        }).then((result) => {
                            setTimeout(function () {

                            }, 200);
                        });
                    }

                    if (result.error == "true" && result.status == "success") {
                        Swal.fire({
                            type: 'danger',
                            title: 'Oops!',
                            text: result.message,
                        }).then((result) => {
                            setTimeout(function () {

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
            success: function (response) {
                console.log(response);
            }
        });

        return false;
    });

});