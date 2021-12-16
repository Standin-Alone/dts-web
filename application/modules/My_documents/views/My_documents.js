$(function() {
    'use strict';

    var usersTable = $('#logs_table').DataTable({
        dom: 'lfrtip',
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        scrollY: 200,
        scrollCollapse: true,
        ajax: {
            url: base_url + 'My_documents/get_users',
            type: 'post'
        },
        columns: [

            {
                data: 'document_number',
                className: 'text-center align-middle' 
            },
            {
                data: 'type',
                className: 'text-center align-middle'
            },
            {
                data: 'subject',
                className: 'text-center align-middle'
            },
            {
                data: 'status',
                className: 'text-center align-middle'
            },
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                    var date = new Date(row.date_created);
                    var new_date = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
                    return new_date;
                }
            },
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                var link = '<a href="javascript:void(0)" id="view_users" data-id="'+row.user_id+'" data-toggle="tooltip" data-placement="top" title="View User"><i class="material-icons azure600">preview</i></a>';
                    return link;
                }
            }
        ]
    });

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );   

    $(document.body).on('click', '#view_users', function(){
        var user_id = $(this).data('id');
            $.ajax({
                type:"POST",
                //async: false,
                url: base_url + 'My_documents/get_users_update',
                dataType: 'json',
                data: { user_id: user_id},
                success:function(results) {
                    $.each(results, function(k,v){
                        $('#update_view').css('display','');
                        $('#name').val(v.name);
                        $('#email').val(v.email);
                        $('#user_id').val(v.user_id);
                        $('#username').val(v.username);
                        if(v.active == 'active'){ 
                            $('input:radio[name="status"][value="active"]').attr('checked', true);
                        } else {
                            $('input:radio[name="status"][value="inactive"]').attr('checked', true);
                        }
                    });
                }
            });
    });
});
