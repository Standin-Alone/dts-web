<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="received_table" class="table table-bordered align-middle bg-light">
                        <thead class="bg-white">
                            <tr>
                                <th width="10%">Document Number</th>
                                <!-- <th width="5%">Document Type</th> -->
                                <!-- <th width="1%">Origin Type</th> -->
                                <!-- <th width="10%">Subject</th> -->
                                <th width="20%">From</th>
                                <th width="1%">Status</th>
                                <th width="5%">Date Received</th>
                                <th width="1%" data-orderable="false">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($get_incoming_documents as $key => $val) {

                            ?>
                                <tr>
                                    <td><?php echo $val->document_number ?></td>
                                    <!-- <td><?php echo $val->document_type ?></td> -->
                                    <!-- <td><?php echo $val->origin_type ?></td> -->
                                    <!-- <td><?php echo $val->subject ?></td> -->
                                    <td><?php echo $val->document_origin ?></td>
                                    <td class="text-center align-middle"><?php if ($val->status == "0") {
                                                                                echo "
                                        <h5>
                                        <span class=' badge badge-danger'>
                                        Invalid Log
                                        </span>
                                        </h5>
                                        ";
                                                                            } else {
                                                                                echo "
                                        <h5>
                                        <span class=' badge badge-success'>
                                        Valid Log
                                            </span>
                                            </h5>
                                            ";
                                                                            }
                                                                            ?></td>
                                    <td><?php echo $val->log_date ?></td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <a type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" caret="false">
                                                <i class="fa fa-sliders-h"></i> More
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a target="_blank" href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class=" dropdown-item d-flex justify-content-between align-items-center text-secondary"> <i class="fa fa-file-alt"></i> View Document</a>
                                                <button class="dropdown-item d-flex justify-content-between align-items-center text-secondary" type="button"><i class="fa fa-search-location"></i> Document Logs</button>
                                                <!-- <button class="dropdown-item" type="button">Another action</button>
                                                <button class="dropdown-item" type="button">Something else here</button> -->
                                            </div>
                                        </div>
                                        <!-- <a href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class="btn btn-success">Track</a>
                                        <a target="_blank" href="<?php echo base_url() ?>View_document/document/<?php echo $val->document_number ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>