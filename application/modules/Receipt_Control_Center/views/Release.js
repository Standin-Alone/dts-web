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
});