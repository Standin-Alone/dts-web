var requests = '';

$(function() {
	'use strict';

	var myTable = $('#logs_table').DataTable({
		dom: 'lfrtip',
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        ajax: {
            url: base_url + 'Home/get_rc_records',
            type: 'post'
        },
        columns: [
        	{
        		className: 'text-center align-middle',
        		render: function(data, type, row){
        			var link = '<a href="'+base_url+'View_document/document/'+row.document_number+'">'+row.document_number+'</a>';
        			return link;
        		}
        	},
        	{
        		data: 'docu_status',
        		className: 'text-center align-middle' 
        	},
            {
                data: 'reference_no',
                className: 'text-center align-middle'
            },
        	{
        		data: 'subject',
        		className: 'text-center align-middle' 
        	},
        	{
        		data: 'received_by',
        		className: 'text-center align-middle'
        	},
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                    var date = new Date(row.status_d_received);
                    var new_date = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
                    return new_date;
                }
            },
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                    var str = row.time_received;
                    var res = str.split(":");
                    var hours = res[0];
                    var minutes = res[1];
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    var strTime = hours + ':' + minutes + ' ' + ampm;
                    return strTime;
                }
            }
        ]
	});

    $('#all_document').on('click', function() {
        requests = '';
        $('#card_header').removeClass('text-primary');
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-info');
        $('#card_header').text('All Document');
        myTable.draw();
    });

    $('#receive_doc').on('click', function() {
        requests = 'Received';
        $('#card_header').removeClass('text-primary');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-success');
        $('#card_header').text('Received Document');
        myTable.draw();
    });

    $('#release_doc').on('click', function() {
        requests = 'Released';
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-danger');
        $('#card_header').addClass('text-primary');
        $('#card_header').text('Released Document');
        myTable.draw();
    });

    $('#return_doc').on('click', function() {
        requests = 'Returned';
        $('#card_header').removeClass('text-success');
        $('#card_header').removeClass('text-info');
        $('#card_header').removeClass('text-primary');
        $('#card_header').addClass('text-danger');
        $('#card_header').text('Returned Document');
        myTable.draw();
    });
});