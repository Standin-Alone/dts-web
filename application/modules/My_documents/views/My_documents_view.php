<div id="content" class="content">
    <!-- begin row -->
    <div class="row">
<!--         <div class="col-lg-12 mb-1">
                <a href="javascript:void(0)" class="btn btn-sm btn-danger pull-right btn-lg" data-toggle="modal" id="add-user">Add User</a>
        </div> -->
        <div class="col-lg-12 mb-1">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <button type="submit" class="btn btn-success" id="add_profile_button">
                <span class="icon text-white-50">
                    <i class="fas fa-folder-plus fa-lg"></i>
                </span>
                <span class="text">Create Profile</span>
            </button>
        </div>
        <!-- begin col-8 -->
        <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                        <!-- begin panel-heading -->
                        <div class="panel-heading p-0">
                            <!-- begin nav-tabs -->
                            <div class="tab-overflow">
                                <ul class="nav nav-tabs nav-tabs-inverse">
                                    <li class="nav-item prev-button"><a href="javascript:;" data-click="prev-tab" class="nav-link text-success"><i class="fa fa-arrow-left"></i></a></li>
                                    <li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active">My Documents</a></li>
                                    <li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link">All Documents</a></li>
                                </ul>
                            </div>
                            <!-- end nav-tabs -->
                        </div>
                        <div class="alert alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Click tab <i class="fas fa-arrow-up"></i> to change table filter.
                        </div>
                        <!-- end panel-heading -->
                        <!-- begin tab-content -->
                        <div class="tab-content">
                            <!-- begin tab-pane -->
                            <div class="tab-pane fade active show" id="nav-tab-1">
                                <!-- <h3 class="m-t-10">Nav Tab 1</h3> -->
                                <table  id="my_docs" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">Document Number</th>
                                            <th class="text-nowrap">Type</th>
                                            <th class="text-nowrap">Subject</th>
                                            <th class="text-nowrap">Status</th>
                                            <th class="text-nowrap">Date Created</th>
                                            <th class="text-nowrap">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end tab-pane -->
                            <!-- begin tab-pane -->
                            <div class="tab-pane fade" id="nav-tab-2">
                                <table  id="all_docs" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">Document Number</th>
                                            <th class="text-nowrap">Type</th>
                                            <th class="text-nowrap">Subject</th>
                                            <th class="text-nowrap">Status</th>
                                            <th class="text-nowrap">Date Created</th>
                                            <th class="text-nowrap">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end tab-pane -->
                        </div>
                        <!-- end tab-content -->
                    </div>
            <!-- end panel -->
        </div>
        <!-- end col-10 -->
        <!-- begin col-6 -->
        <div class="col-lg-3" style="display: none;">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Options</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin alert -->
                <div class="alert alert-success fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Options
                </div>
                <!-- end alert -->
                <!-- begin panel-body -->
                <div class="panel-body">
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
    </div>
    <!-- end row -->
</div>
<!-- #modal-alert -->
<div class="modal fade" id="modal-add-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="add_useradmin" autocomplete="off">
            <div class="modal-body">
                <fieldset>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="add_username">Username</label>
                            <input type="text" class="form-control" name="add_username" id="add_username"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="add_email">Email</label>
                            <input type="text" class="form-control" name="add_email" id="add_email"/>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-lock"></i> Close</button>
                <button type="submit" class="btn btn-success" id="add_admin"><i class="fa fa-save"></i> Add User</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
var $add_useradmin = $('#add_useradmin');
var result_email;
var result_username;

$.validator.addMethod("email", function (value, element) {
    return this.optional(element) || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i.test(value);
}, "Invalid email address.");

$.validator.addMethod("lettersAndNumbersOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
}, "Please enter letters and numbers only.");

$(document).ready(function() {
    //App.init();
    // TableManageResponsive.init();

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
   $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust()
      .responsive.recalc();
});

    $('#my_docs').DataTable({
        //responsive: true,
        dom: 'lfrtip',
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        autoWidth: false,
        // deferRender:    true,
        // scrollY:        300,
        // scrollCollapse: true,
        // scroller:       true,
        //responsive: true,
        ajax: {
            url: base_url + 'My_documents/get_by_user',
            type: 'post'
        },
        columns: [

            {
                data: 'document_number',
                className: 'text-center align-middle' 
            },
            {
                data: 'docu_type',
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
                var link = '<a href="'+base_url + "View_document/document/"+row.document_number+'" target="_blank" id="view_users" data-id="'+row.document_id+'" data-toggle="tooltip" data-placement="top" title="View Document"><i class="fas fa-folder-open"></i></a>';
                    return link;
                }

            }
        ]
    });

$('#all_docs').DataTable({
        dom: 'lfrtip',
        processing: true,
        ordering: false,
        serverSide: true,
        paging: true,
        // deferRender:    true,
        // scrollY:        300,
        // scrollCollapse: true,
        // scroller:       true,
        //responsive: true,
        autoWidth: false,
        ajax: {
            url: base_url + 'My_documents/get_all',
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
            }
            ,
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                var link = '<a href="javascript:void(0)" id="view_users" data-id="'+row.user_id+'" data-toggle="tooltip" data-placement="top" title="View Document"><i class="fas fa-folder-open"></i></a>';
                    return link;
                }
            }
        ]
    });

    $(document.body).on('click', '#add-user', function(){
        $('#submit_btn').attr('disabled', true);
        pras_id = $(this).data('id');
        $('#modal-add-user').modal('show');
    });

    // Code for the Validator
    $('#edit_useradmin').submit(function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                name: {
                lettersDashonly: true,
                required: true
                },
                email: {
                email: true,
                required: true
                }
        },
        errorPlacement: function ( error, element ) {
            error.css({"font-size": "12px"});
            error.addClass( "text-danger" );
            error.addClass( "invalid-feedback" );

            if( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            console.log(element);
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            console.log(element);
        },
        submitHandler: function() {

                var formData = $('#edit_useradmin').serializeArray();

                $.ajax({
                     url:"<?php echo base_url(); ?>My_documents/update_user",   
                     method:"POST",  
                     data: formData,
                     dataType: 'json', 
                     success:function(results)  
                     {
                        if(results.event == 'success'){
                            // pras_id = results.data[0].pras_id;
                            //$("#submit_upload").click();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'User account has been successfully updated.'
                            }).then((result) => {
                                //$("#submit_upload").click();
                                if(result.value){
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        Swal.fire({
                            allowOutsideClick: false,
                            icon: 'warning',
                            title: 'Something went wrong.',
                            text: 'Please try again.'
                        });
                    }

                });
        }
    });

   $(document.body).on('keyup', '#add_email', function(){
        var email_value = $.trim(this.value);
            $.ajax({
                type:"GET",
                //async: false,
                url: base_url + 'Login/check_email_exists',
                dataType: 'json',
                data: { email_value: email_value },
                success:function(results) {
                console.log(results);
                    //if(results.result == 'success'){
                        if(results.dedup > 0){
                            result_email = false;
                        } else {
                            result_email = true;
                        }
                    //}
                }
            });
    });

    $.validator.addMethod("email_check", 
        function(value, element) {
            return result_email;
        },
        "Email already exist."
    );

    $(document.body).on('keyup', '#add_username', function(){
        var username_value = $.trim(this.value);
            $.ajax({
                type:"GET",
                //async: false,
                url: base_url + 'Login/check_username_exists',
                dataType: 'json',
                data: { username_value: username_value },
                success:function(results) {
                console.log(results);
                    //if(results.result == 'success'){
                        if(results.dedup > 0){
                            result_username = false;
                        } else {
                            result_username = true;
                        }
                    //}
                }
            });
    });

    $.validator.addMethod("username_check", 
        function(value, element) {
            return result_username;
        },
        "Username already exist."
    );
    
    $add_useradmin.on('submit', function(e) {
        e.preventDefault();
        }).validate({
            rules: {
                add_email: {
                    required: true,
                    minlength: 10,
                    email: true,
                    email_check: true
                },
                add_username: {
                    required: true,
                    minlength: 5,
                    lettersAndNumbersOnly: true,
                    username_check: true
                }
        },
        errorPlacement: function ( error, element ) {
            error.css({"font-size": "12px"});
            error.addClass( "text-danger" );
            error.addClass( "invalid-feedback" );

            if( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            console.log(element);
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            console.log(element);
        },
        submitHandler: function() {

                var formData = $('#add_useradmin').serializeArray();

                $.ajax({
                    url:"<?php echo base_url(); ?>My_documents/register",   
                    method:"POST",  
                    data: formData,
                    dataType: 'json', 
                    success:function(r)  
                    {
                        if(r == 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Added New User',
                                text: 'New user has been added successfully.'
                            }).then((result) => {
                                if(result.value){
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Something went wrong.',
                            text: 'Please try again.'
                        }).then((result) => {
                            if(result.value){
                                location.reload();
                            }
                        });
                    }
                });
        }
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
</script>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>Accounts/Accounts_js"></script>