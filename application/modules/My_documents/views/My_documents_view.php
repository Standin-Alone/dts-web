<style type="text/css">
    .nav.nav-tabs.nav-tabs-inverse>li>a {
        background: #00acac; 
    }
    .nav.nav-tabs.nav-tabs-inverse>li>a:hover {
        background: #00acac;
    }
</style>
<div id="content" class="content">
    <!-- begin row -->
    <div class="row">
<!--         <div class="col-lg-12 mb-1">
                <a href="javascript:void(0)" class="btn btn-sm btn-danger pull-right btn-lg" data-toggle="modal" id="add-user">Add User</a>
        </div> -->
<!--         <div class="col-lg-12 mb-1">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <button type="submit" class="btn btn-success" id="add_profile_button">
                <span class="icon text-white-50">
                    <i class="fas fa-folder-plus fa-lg"></i>
                </span>
                <span class="text">Create Profile</span>
            </button>
        </div> -->
        <!-- begin col-8 -->
        <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                        <!-- begin panel-heading -->
                        <div class="panel-heading p-0 bg-success">
                            <!-- begin nav-tabs -->
                            <div class="tab-overflow">
                                <ul class="nav nav-tabs nav-tabs-inverse bg-success">
                                    <li class="nav-item prev-button"><a href="javascript:;" data-click="prev-tab" class="nav-link text-success"><i class="fa fa-arrow-left"></i></a></li>
                                    <li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active">My Documents</a></li>
                                    <li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link">Received Documents</a></li>
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
                                            <th class="text-nowrap">Transaction Office Code</th>
                                            <th class="text-nowrap">Name</th>
                                            <th class="text-nowrap">Action</th>
                                            <th class="text-nowrap">Log Date</th>
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

<script type="text/javascript">
$(document).ready(function() {

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
                className: 'text-center align-middle',
                render: function(data, type, row){
                    var val = (row.status == 'Verified' ? 'Created' : (row.status == 'Archived' ? 'Completed' : row.status));
                    return val;
                }
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
                var link = '<a href="'+base_url + "View_document/document/"+row.document_number+'" target="_blank" data-id="'+row.document_id+'" data-toggle="tooltip" data-placement="top" title="View Document"><i class="fas fa-folder-open"></i></a>';
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
                data: 'transacting_office',
                className: 'text-center align-middle'
            },
            {
                data: 'transacting_user_fullname',
                className: 'text-center align-middle'
            },
            {
                data: 'action',
                className: 'text-center align-middle'
            },
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                    var date = new Date(row.log_date);
                    var new_date = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
                    return new_date;
                }
            }
            ,
            {
                className: 'text-center align-middle',
                render: function(data, type, row){
                var link = '<a href="'+base_url + "View_document/document/"+row.document_number+'" target="_blank" data-id="'+row.document_id+'" data-toggle="tooltip" data-placement="top" title="View Document"><i class="fas fa-folder-open"></i></a>';
                    return link;
                }
            }
        ]
    });

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );   

});
</script>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>Accounts/Accounts_js"></script>