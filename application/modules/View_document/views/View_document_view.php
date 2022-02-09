<style type="text/css">
    .remove_sig {cursor: pointer;}
    .remove_rec {cursor: pointer;}
    .dz-remove{display:inline-block !important;width:1.2em;height:1.2em;position:absolute;top:5px;right:5px;z-index:1000;font-size:1.2em !important;line-height:1em;text-align:center;font-weight:bold;border:1px solid gray !important;border-radius:1.2em;color:gray;background-color:white;opacity:.5;}
    .dz-remove:hover{text-decoration:none !important;opacity:1;}
    #document_type-error { text-align: left; }
    .qr_code {
        display:  inline !important;
    }
    .page {
        width: 200mm;
        min-height: 148.5mm;
        padding: 5mm;
        margin: 0 auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .print_only {
        border: 1px #D3D3D3 solid;
        padding-top: 5px;
        padding-left: 5px;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

@page {
    size: A4;
    margin: 0.5cm;
/*    overflow-y:hidden !important;*/
}

@media print{
    .page {
/*        background-color:#FFFFFF;
        color:#000000;
        overflow-y:hidden !important;
        overflow-x:hidden !important;
        margin: 7mm 10mm 0mm !important;
        height: 100%;
        margin: 5; */
        background: red;
        width: 210mm;
        min-height: 148.5mm;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
    }
    .qr_code {
        display:  inline !important;
    }
    .sticker{
        display:  inline !important;
    }
    .print_btn {
        display: none;
    }
    .title {
        display: none;
    }
    .card-header-info{
        display: none;
    }
    .header-filter {
        display: none;
    }
    .panel-title {
        display: none;
    }
    #add_profile {
        display: none !important;
    }
    #add_file {
        display: none !important;
    }
    #sidebar{
        display: none;
    }
    #header {
        display: none;
    }
    .footer {
        display: none;
    }
    #print_note {
        display: none;
    }
    #content {
        display: none;
    }
    .print_class, .modal-footer{
        display: none;
    }
}

</style>
<div id="content" class="content">
    <!-- begin row -->
    <div class="row">
        <?php 
        //echo $owner;
        //array_push($valid_recipients, array('recipient_office_code' => $owner));
        //echo '</br>';
        echo '<pre>';
        //print_r($valid_recipients);
        echo '</pre>';
        //echo '</br>';
        ?>
        <!-- begin col-8 -->
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <?php if($document_information['document_details'][0]->office_code == $this->session->userdata('office')){ ?>
                                <a href="javascript:;" class="btn btn-sm btn-icon btn-success update_information" title="Edit Document"><i class="fas fa-pen-alt"></i></a>
                                <?php } ?>
                                <a href="javascript:;" id="print" class="btn btn-sm btn-icon btn-success" data-content="Print" title="Print"><i class="fas fa-print"></i></a>
                                <?php if($document_information['document_status'] == '1'){ ?>
                                <a href="javascript:;" class="btn btn-sm btn-icon btn-success release_btn" title="Release"><i class="fas fa-share"></i></a>
                                <?php } ?>
                                <?php
                                    if($document_information['document_current_status'][0]->action == 'Received' && $document_information['document_current_status'][0]->transacting_office == $this->session->userdata('office')){
                                        echo '<a href="javascript:;" class="btn btn-sm btn-danger archive_btn" title="Archived">Mark as Completed</a>';
                                    }
                                ?>
                            </div>
                            <h4 class="panel-title">Document Information</h4>
                        </div>
                        <!-- end panel-heading -->

                        <!-- begin table-responsive -->
                        <div class="table-responsive"> 
                            <table id="user" class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30%" class="bg-silver-lighter">Document #</th>
                                        <th><?php echo $doc_number; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-silver-lighter">Status</td>
                                        <td>
                                            <span class="text-black-lighter label label-success text-white">
                                            <?php
                                                $action_val = $document_information['document_current_status'][0]->action;
                                                if($action_val == 'Marked as Completed'){ echo 'Completed'; } else { echo $action_val; } 
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Date</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->date; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Document Type</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->docu_type; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Document For</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->for_name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Origin Type</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->origin_type; ?></span></td>
                                    </tr>
                                    <?php if($document_information['document_details'][0]->origin_type == 'External'){ ?>
                                    <tr>
                                        <td class="bg-silver-lighter">Sender Name</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->sender_name; ?> </span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Sender Position</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->sender_position; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Sender Address</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->sender_address; ?></span></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="bg-silver-lighter">Subject</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->subject; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Remakrs</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->remarks; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Recipients</td>
                                        <td>
                                            <!-- begin #accordion -->
                                            <div id="accordion" class="card-accordion">
                                                <!-- begin card -->
                                                <div class="card">
                                                    <div class="card-header bg-black text-white pointer-cursor collapsed">
                                                        <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Click to show recipients.
                                                        </a>
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-success float-right update_recipients ml-1"><i class="fas fa-pen-alt"></i></a>
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-danger float-right" id="remove_rec_modal"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                    <div id="collapseOne" class="collapse border" data-parent="#accordion">
                                                        <div class="card-body pl-0 pr-0">
                                                            <?php 
                                                                if(isset($document_information['document_recipients'])){
                                                                    echo '<ul>';
                                                                        foreach($document_information['document_recipients'] as $row)
                                                                        {
                                                                            echo '<li>'.strtoupper(($row->SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '').$row->ORIG_SHORTNAME.' / '.($row->INFO_DIVISION == '' ? $row->INFO_SERVICE : $row->INFO_SERVICE.' / '.$row->INFO_DIVISION)).'</li>';
                                                                        }
                                                                    echo '</ul>';
                                                                }
                                                                //print_r($document_information['document_recipients']);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card -->
                                            </div>
                                            <!-- end #accordion -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Signatories</td>
                                        <td>
                                            <!-- begin #accordion -->
                                            <div id="accordion" class="card-accordion">
                                                <!-- begin card -->
                                                <div class="card">
                                                    <div class="card-header bg-black text-white pointer-cursor collapsed">
                                                        <a data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                            Click to show signatories.
                                                        </a>
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-success float-right ml-1" id="add_sig_modal"><i class="fas fa-pen-alt"></i></a>
                                                        <a href="javascript:;" class="btn btn-sm btn-icon btn-danger float-right" id="remove_sig_modal"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse border" data-parent="#accordion">
                                                        <div class="card-body pl-0 pr-0">
                                                            <?php 
                                                                if(isset($document_information['document_signatories'])){
                                                                    echo '<ul>';
                                                                        foreach($document_information['document_signatories'] as $row)
                                                                        {
                                                                            echo '<li><strong>'.$row->signatory_user_fullname.'</strong></li>';
                                                                            echo '<p><i>'.$row->designation.'</i></br>';
                                                                            echo '<small>'.strtoupper(($row->SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '').$row->ORIG_SHORTNAME.' / '.($row->INFO_DIVISION == '' ? $row->INFO_SERVICE : $row->INFO_SERVICE.' / '.$row->INFO_DIVISION)).'</small></p>';
                                                                        }
                                                                    echo '</ul>';
                                                                }
                                                                //print_r($document_information['document_recipients']);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card -->
                                            </div>
                                            <!-- end #accordion -->
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <!-- end panel -->
                </div>                
                <div class="col-lg-12 card-accordion" id="accordion">
                    <!-- begin #accordion -->
                    <div id="accordion" class="card-accordion">
                        <!-- begin card -->
                        <div class="card">
                            <div class="card-header bg-black text-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapseThree">
                                Show Attachment
                            </div>
                            <div id="collapseThree" class="collapse border" data-parent="#accordion">
                                <div class="card-body m-0">
                                    <table id="user" class="table table-condensed table-bordered">
                                        <?php if(count($document_information['document_attachments']) > 0){ ?>
                                            <thead>
                                                <tr>
                                                    <th>Uploaded By</th>
                                                    <th width="30%">Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            foreach($document_information['document_attachments'] as $row)
                                            {
                                                echo '<tr>';
                                                echo '<td>'.$row->uploaded_by_user_fullname.'</td>'; 
                                                echo '<td><a href="javascript:;" class="btn btn-sm btn-success show_attachment" data-id="'.$row->file_name.'" data-type="'.$row->doc_type.'">View File <i class="far fa-eye"></i></a>';
                                                // echo '<td><a class="btn btn-success" href="'.base_url().'View_document/attachment/'.$row->file_name.'" target="_blank">VIEW FILE</a></td>'; 
                                                echo '<tr>';
                                            }
                                        ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <thead>
                                                <tr>
                                                    <th>No Attachment.</th>
                                                </tr>
                                            </thead>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end #accordion -->

                </div>                
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-lg-8">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <h4 class="panel-title">Document</h4>
                </div>
                <!-- end panel-heading -->
                <!-- begin alert -->
<!--                 <div class="alert alert-success fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Options
                </div> -->
                <!-- end alert -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php
                        $doc_no = explode('-', $doc_number);
                        $file_path = base_url().'uploads/';
                        $folder_name = '';
                            for ($i=0; $i < count($document_information['document_file']) ; $i++) {
                                //if($document_information['document_file'][$i]->type == 'base_file'){
                                    echo '<center><object data="'.$file_path.'files/'.$document_information['document_file'][$i]->doc_type.'/'.$document_information['document_file'][$i]->file_name.'" class="col-lg-12" width="auto" height="800" draggable="false"></object></center>';
                                //} 
                                // else {
                                //     echo '<center><object data="'.$file_path.'attachments/'.$document_information['document_attachments'][$i]->doc_type.'/'.$document_information['document_attachments'][$i]->file_name.'" class="col-lg-12" width="auto" height="800" draggable="false"></object></center>';
                                // }
                            }
                            //print_r($document_information['document_attachments']);
                    ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-8 -->
    </div>
    <!-- end row -->
</div>
<div class="modal fade" id="print_modal" tabindex="-1" role="">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header print_class">
                <h4 class="modal-title" id="exampleModalLongTitle">Printing <i class="fas fa-print"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="insert_signatories" novalidate>
            <input type="hidden" name="add_signatory_doc_number" value="<?php echo $doc_number; ?>">
            <div class="modal-body">
                <!-- begin invoice -->
                <div class="border border-secondary rounded page">
                    <div class="note note-info" id="print_note">
                        <div class="note-icon"><i class="fas fa-qrcode"></i></div>
                        <div class="note-content">
                            <h4><b>QR Code</b></h4>
                            <p> Print document routing slip. </p>
                        </div>
                    </div>
                    <div class="print_only p-1">
                    <div class="invoice">
                        <!-- begin invoice-company -->
                        <p class="text-center"><img class="text-center" style="margin:0px;height: 50px;width: 50px;" src="<?php echo base_url() .'assets/img/DA-Logo.png';?>"></p>
                        <h4 class="text-center">Department of Agriculture</h4>
                        <h5 class="text-center mb-4">Document Tracking System</h5>
                        <h3 class="text-center mb-3">Routing Slip</h3>
                        <div class="invoice-company text-inverse f-w-600">
                            <small>Document Number:</small>
                        </div>
                        <!-- end invoice-company -->
                        <!-- begin invoice-header -->
                        <div class="invoice-header">
                            <div class="text-center">
                                <img id="doc_num_qr" style="height: 150px;width: 150px;" src="">
                            </div>
                            <div class="text-center">
                                <strong id="doc_num_text"></strong>
                            </div>
                        </div>
                        <!-- end invoice-header -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 ml-3"><h5 class="">Action: <?php echo $document_information['document_details'][0]->for; ?><span id="action_text"></span></h5></div>
                        <div class="col-lg-6 ml-3"><h5 class="">Subject: <?php echo $document_information['document_details'][0]->subject; ?><span id="subject_text"></span></h5></div>
                    </div>
                    <!-- begin invoice-content -->
                    <div class="invoice-content">
                        <!-- begin table-responsive -->
                        <div class="table-responsive">
                            <table class="table table-invoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="30%">Recipients</th>
                                        <th class="text-center" width="20%">Date</th>
                                        <th class="text-center" width="50%">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="recipients_list">
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="row text-center ml-0 pr-1" style="width: 100%;height: 100px;border: 1px solid black;box-sizing: border-box;"></div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="print_qr" class="btn btn-primary">Print <i class="fas fa-qrcode"></i></button>
                <?php if($document_information['document_status'] == '1'){ ?>
                <button type="button" class="btn btn-primary" class="release_btn">Release <i class="fas fa-share"></i></button>
                <?php } ?>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_received" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 100%;height: 100%;">
        <div class="modal-content" style="height: auto;min-height: 100%;border-radius: 0;">
            <center>
            <embed class="object_file" data="" width="100%" height="900" draggable="false">
<!--             <object class="object_file" data="<?php echo base_url().'/uploads/attachments/DO/f703127570a717a0f4eab657d9eaac48.pdf'?>" width="100%" height="900" draggable="false"></object> -->
            </center>
        </div>
    </div>
</div>
<div class="modal fade" id="update_info_modal" tabindex="-1" role="">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <form id="edit_profile" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="document_number" value="<?php echo $doc_number; ?>">
            <div class="modal-body">
                <!-- begin invoice -->
                    <div class="note note-info">
                        <div class="note-icon"><i class="fas fa-book"></i></div>
                        <div class="note-content">
                            <h4><b>Edit Document Information</b></h4>
                            <p> Enter the document information and details. </p>
                        </div>
                    </div>
                <div class="border border-secondary rounded page">
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Date</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control col-md-12" name="date" id="date" readonly>
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Document Type</label>
                        <div class="col-md-7">
                                <input type="text" class="form-control col-md-12" id="document_type" readonly>
<!--                             <select class="form-control col-md-12" name="document_type" id="document_type" readonly>
                                <option value="">Select Document Type</option>
                                <?php 
                                    foreach($document_type as $row)
                                    {
                                        echo '<option value="'.$row->type_id.'">'.$row->type.'</option>';
                                    }
                                ?>
                            </select> -->
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Action</label>
                        <div class="col-md-7">
                            <select class="form-control col-md-12" name="for" id="for" >
                                <option value="">Select For</option>
                                <?php 
                                    foreach($document_for as $row)
                                    {
                                        echo '<option value="'.$row->for_id.'">'.$row->for.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Origin Type</label>
                        <div class="col-md-7">
                            <select class="form-control col-md-12" name="origin_type" id="origin_type">
                                <option value="Internal">Internal</option>
                                <option value="External">External</option>
                            </select>
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <span id="sender_div">
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Sender Name</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control col-md-12" name="sender_name" id="sender_name">
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Sender Position</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control col-md-12" name="sender_position" id="sender_position">
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Sender Address</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control col-md-12" name="sender_address" id="sender_address">
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    </span>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Subject</label>
                        <div class="col-md-7">
                            <textarea class="textarea form-control" name="subject" id="subject_update" placeholder="Enter text ..." rows="10"></textarea>
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-3 col-form-label text-md-right">Remarks</label>
                        <div class="col-md-7">
                            <textarea class="textarea form-control" name="remarks" id="remarks_update" placeholder="Enter text ..." rows="10"></textarea>
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-window-close"></i></button>
                <button type="submit" id="save_update_info" class="btn btn-primary">Save Changes <i class="fas fa-save"></i></button>
            </div> 
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addEmpModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="edit_signatories" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="document_number" value="<?php echo $doc_number; ?>">
            <div class="modal-body">
                <div class="note note-success m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h6 class="m-t-5 m-b-5 p-b-2">Signatory Information</h6>
                        <ul class="m-b-5 p-l-25">
                            <li>Search & Click <strong id="pras"></strong></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="form-group">
                            <label>Employee Name:</label>
                            <input type="text"  id="signatory_emp" name="signatory_emp" class="form-control" placeholder="Search by Employee Lastname, Click & Select.">
                            <input type="hidden"  id="signatory_user_id" name="signatory_user_id" class="form-control" placeholder="Search by Employee Lastname, Click & Select.">
                        </div>
                        <div class="form-group">
                            <label>Position/Designation:</label>
                            <input type="text" name="signatory_designation" class="form-control" placeholder="Enter Employee Current Position.">
                        </div>
                        <div class="form-group">
                            <label>Service/Division</label>
                            <input type="text" id="signatory_office" name="signatory_office" class="form-control" placeholder="Search Service/Division, Click & Select.">
                            <input type="hidden" id="modal_sig_office_code" name="modal_sig_office_code">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="submit" id="modal_add_sig_btn" class="btn btn-success modal_sig_add_btn"><i class="fas fa-user-plus"></i> Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addRecModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="edit_recipient" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="document_number" value="<?php echo $doc_number; ?>">
            <div class="modal-body">
                <div class="note note-success m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h6 class="m-t-5 m-b-5 p-b-2">Document Recipient</h6>
                        <ul class="m-b-5 p-l-25">
                            <li>Search & Click to add Recipient.</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="form-group">
                            <label>Recipient</label>
<!--                             <input type="text" id="add_recipients" name="add_recipients" class="form-control" placeholder="Search Service/Division, Click & Select.">
                            <input type="hidden" id="recipients_office_code" name="recipients_office_code"> -->
                            <select class="js-example-basic-single form-control-lg" multiple="multiple" id="recipients_office_code" name="recipients_office_code[]" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="submit" id="modal_add_rec_btn" class="btn btn-success modal_add_rec_btn"><i class="fas fa-user-plus"></i> Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="removeEmpModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="note note-success m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h6 class="m-t-5 m-b-5 p-b-2">Remove Signatory</h6>
                        <ul class="m-b-5 p-l-25">
                            <li>Click <i class="fas fa-trash-alt"></i> to remove specific signatory.</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th class="text-center">Fullname</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Office</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="body_signature">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
<!--                 <button type="submit" id="modal_add_sig_btn" class="btn btn-success modal_sig_add_btn"><i class="fas fa-user-plus"></i> Add</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="removeRecModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="note note-success m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h6 class="m-t-5 m-b-5 p-b-2">Remove Recipients</h6>
                        <ul class="m-b-5 p-l-25">
                            <li>Click <i class="fas fa-trash-alt"></i> to remove specific recipients.</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th class="text-center">Office</th>
                                <th class="text-center">Added By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="body_recipients">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
<!--                 <button type="submit" id="modal_add_sig_btn" class="btn btn-success modal_sig_add_btn"><i class="fas fa-user-plus"></i> Add</button> -->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var path = '<?php echo base_url() .'Create_profile/qr_code/3/2/';?>';
    var upload_path = '<?php echo base_url() .'uploads/attachments/';?>';
    var doc_number = '<?php echo $doc_number; ?>';
    var office_code = '<?php echo $this->session->userdata('office'); ?>';
    $('#print_area').css("display", "none");
    $(document).ready(function(){
        $('.datepicker').datepicker({
            todayHighlight: true,
            autoclose: true
        });
        $(document.body).on('click', '#print', function() {
            $("#doc_num_qr").attr('src', path+doc_number);
            $("#doc_num_text").text(doc_number);
            $.ajax({
                url: base_url + 'Create_profile/document_recipients', 
                type: 'post',
                data: { 'doc_number': doc_number },
                dataType: 'json',
                success: function(r){
                    var tr='';
                        var commo_count = r.length;
                        for (ie = 0; ie < commo_count; ie++) {
                            tr +='<tr>';
                            // tr +='<td class="text-center">'+((r[ie].SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '')+r[ie].ORIG_SHORTNAME+' / '+(r[ie].INFO_DIVISION == '' ? r[ie].INFO_SERVICE : r[ie].INFO_SERVICE+' / '+r[ie].INFO_DIVISION))+'</td>';
                            tr +='<td class="text-center pb-0">'+(r[ie].INFO_DIVISION == '' ? r[ie].INFO_SERVICE : r[ie].INFO_DIVISION)+'</td>';
                            tr +='<td class="text-center pb-0">'+r[ie].date_added+'</td>';
                            tr +='<td class="text-center pb-0"></td>';
                            tr +='</tr>';
                        }
                        $('#recipients_list').html('').append(tr);
                    }
            });
            $('#print_modal').modal('show');
        });

        $('#print_qr').on("click", function () {
            $('.print_only').css('border', "1px #D3D3D3 solid");
            $('.print_only').css('padding-top', '5px');
            $('.print_only').css('padding-left', '5px');
            $('.print_only').css('border-radius', '5px');
            $('.print_only').css('background', 'white');
            $('.print_only').css('box-shadow', '0 0 5px rgba(0, 0, 0, 0.1)');
            $('.print_only').printThis({
                //base: "https://jasonday.github.io/printThis/"
            });
        });

        $('.show_attachment').on("click", function () {
            var file_name = $(this).data('id');
            var type = $(this).data('type');

            var value = upload_path+type+'/'+$(this).attr('data-id');
            //alert(upload_path+type+'/'+file_name);
            $(".object_file").prop('src', value);
            $('#modal_received').modal('show');
        });

        $('#modal_received').on('hidden.bs.modal', function (e) {
            $(".object_file").attr('data', '');
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>View_document/View_document_js"></script>
