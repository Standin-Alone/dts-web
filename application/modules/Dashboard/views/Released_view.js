
// $.fn.dataTable.ext.search.push(
//     function (settings, data, dataIndex) {
//     var dateRange = $("#date_range").text()
//     var splitDate = dateRange.split(" - ")
//     var date1 =  new Date(splitDate[0])
//     var date2 =  new Date(splitDate[1])
//     var d = new Date(dateRange);
//     var minDate = $.datepicker.formatDate('y-m-d', date1);
//     var maxDate = $.datepicker.formatDate('y-m-d', date2);

//     var min = minDate
//     var max = maxDate
//     let startDate = new Date(data[6]).setHours(0,0,0,0);
//      startDate = $.datepicker.formatDate('y-m-d', startDate);
    
//     if (min == null && max == null) { return true; }
//     if (min == null && startDate <= max) { return true; }
//     if (max == null && startDate >= min) { return true; }
//     if (startDate <= max && startDate >= min) { return true; }                    
//     return false;
//     }
// );





$(document).ready(function () {
    console.log("Received_view js");

    var picked_start = '';
    var picked_end   = '';
    var type         = 'Released';
    var status       = '';
    var origin_type  = '';
    var document_type= '';

    // $.fn.dataTable.ext.search.push(
    //     function (settings, data, dataIndex) {
    //        var min = $('#startdate').datepicker("getDate");
    //        var max = $('#enddate').datepicker("getDate");
    //        var hireDate = new Date(data[3]);
    //        if (min == null && max == null) { return true; }
    //        if (min == null && hireDate <= max) { return true;}
    //        if(max == null && hireDate >= min) {return true;}
    //        if (hireDate <= max && hireDate >= min) { return true; }
    //        return false;
    //    }
    // );
    
    
   
/*      var received_data =  $.ajax({
            async: false,
            url: `${base_url}Dashboard/get_received_documents`,
            dataType: 'json',
        }).responseJSON;
    */
  var table =  $('#release_table').DataTable({
        //data: received_data,
        dom: 'Blfrtip',
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        search: {
            return: true
        },
        ajax: {
            url: base_url + 'Dashboard/get_documents',
            type: 'post',
            data: function(d){
                d.type        = type;
                d.date_start  = picked_start;
                d.date_end    = picked_end;
                d.status      = status;
                d.origin_type = origin_type;
                d.document_type = document_type;
            }
        },
        columns: [
            { data: 'document_number' },
            { data: 'document_type' },
            { data: 'origin_type' },
            { data: 'subject' },
            { data: 'document_origin' },
            { data: 'status', render: function (data) {
                  return  data == '0' ? "<h5><span class='badge badge-danger'>Invalid Log</span></h5>" : "<h5><span class='badge badge-success'>Valid Log</span></h5>"
            } },
            { data: 'log_date', type:"date"},
            { data: 'document_number', render: function(data){
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
            },
            { data: 'status' },
        ],
        order: [[ 6, "desc" ]],
        columnDefs: [
            {
                "targets": [ 8 ],
                "visible": false,
            }
           
        ]
    });
// datatables custom buttons
$('#btn_print').on('click', function(){
    $(".buttons-print")[0].click();
});


$('#btn_pdf').on('click', function(){
    $(".buttons-pdf")[0].click();
});

$('#btn_csv').on('click', function(){
    $(".buttons-csv")[0].click();
});

$('#btn_excel').on('click', function(){
    $(".buttons-excel")[0].click();
});

$('.filter-select').on('change', function(){
    if($(this).attr("id") == 'status'){
        status = $(this).val();
    }

    if($(this).attr("id") == 'origin_type'){
        origin_type = $(this).val();
    }

    if($(this).attr("id") == 'document_type'){
        document_type = $(this).val();
    }

    table.draw();
     /*if ($(this).attr("id") == "date_range"){
        table.draw();
     }else if($(this).attr("id") == "status"){
        table.column($(this).data('column')).search($(this).val()).draw();
     }
     else{
        table.column($(this).data('column')).search($(this).val()).draw();
     }*/
});

$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    picked_start = picker.startDate.format('YYYY-MM-DD');
    picked_end   = picker.endDate.format('YYYY-MM-DD');

    table.draw();
});


// $('#reportrange span').on("change", function(){
//     var dateRange = $('#reportrange span').text()
//     var splitDate = dateRange.split(" - ")
//     var date1 =  new Date(splitDate[0])
//     var date2 =  new Date(splitDate[1])
//     var d = new Date(dateRange);
//     var str = $.datepicker.formatDate('y-m-d', date1);
//     // console.log(date1);
//     // console.log(date2);
//     console.log(str);
//     // console.log(dateRange);
// })

// view
// <input type="date" data-column="5" class="form-control filter-select" name="period_date" id="period_date" placeholder="Period Date" 
//  min="1862-05-15"/>



});