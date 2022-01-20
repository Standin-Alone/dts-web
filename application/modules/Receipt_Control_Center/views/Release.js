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