$(document).ready(function () {
    console.log('test');
    var table = $('#received_table').DataTable({
        // responsive: true,
        dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [{
            extend: 'copy',
            className: 'btn-sm btn-secondary border-0'
        },
        {
            extend: 'csv',
            className: 'btn-sm btn-warning border-0'
        },
        {
            extend: 'excel',
            className: 'btn-sm btn-success border-0'
        },
        {
            extend: 'pdf',
            className: 'btn-sm btn-danger border-0'
        },
        {
            extend: 'print',
            className: 'btn-sm btn-primary border-0'
        }
        ],
    });

    // table.columns().every(function () {
    //     var that = this;

    //     $('input', this.footer()).on('keyup change', function () {
    //         if (that.search() !== this.value) {
    //             that
    //                 .search(this.value)
    //                 .draw();
    //         }
    //     });

    //     $('select', this.footer()).on('keyup change', function () {
    //         if (that.search() !== this.value) {
    //             that
    //                 .search(this.value)
    //                 .draw();
    //         }
    //     });
    // });
});