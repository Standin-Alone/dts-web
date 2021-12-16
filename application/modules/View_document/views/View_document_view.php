<style type="text/css">
    .remove_sig {cursor: pointer;}
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

@page {
    size: A4;
    margin: 0.5cm;
/*    overflow-y:hidden !important;*/
}

@media print{
    .page {
/*      background-color:#FFFFFF;
        color:#000000;
        overflow-y:hidden !important;
        overflow-x:hidden !important;
        margin: 7mm 10mm 0mm !important;
        height: 100%;*/
        margin-top: 0; 
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
        <!-- begin col-8 -->
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" id="print" class="btn btn-sm btn-icon btn-success" data-content="Print"><i class="fas fa-print"></i></a>
                                <a href="javascript:;" class="btn btn-sm btn-icon btn-success release_btn"><i class="fas fa-share"></i></a>
                            </div>
                            <h4 class="panel-title">Document Information</h4>
                        </div>
                        <!-- end panel-heading -->

                        <!-- begin table-responsive -->
                        <div class="table-responsive"> 
                            <table id="user" class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30%">Document #</th>
                                        <th><?php echo $doc_number; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-silver-lighter">Date</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->date; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Document Type</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->type; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Document For</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->for; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-silver-lighter">Origin Type</td>
                                        <td><span class="text-black-lighter"><?php echo $document_information['document_details'][0]->origin_type; ?></span></td>
                                    </tr>
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
                                                    <div class="card-header bg-black text-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapseOne">
                                                        Click to show recipients.
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
                                                    <div class="card-header bg-black text-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapseTwo">
                                                        Click to show signatories.
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
                <div class="col-lg-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Attachments</h4>
                        </div>
                        <!-- end panel-heading -->

                        <!-- begin table-responsive -->
                        <div class="table-responsive"> 
                            <table id="user" class="table table-condensed table-bordered">
                                <?php if(isset($document_information['document_attachments'])){ ?>
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
                                            echo '<td><a href="javascript:;" class="btn btn-sm btn-success">View File <i class="far fa-eye"></i></a>';
                                            // echo '<td><a class="btn btn-success" href="'.base_url().'View_document/attachment/'.$row->file_name.'" target="_blank">VIEW FILE</a></td>'; 
                                            echo '<tr>';
                                        }
                                ?>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <!-- end panel -->
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
                    <h4 class="panel-title">Document file and attachment</h4>
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
                                        <th class="text-center" width="10%">Recipients</th>
                                        <th class="text-center" width="10%">Date</th>
                                        <th class="text-center" width="20%">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="recipients_list">
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="window.print()" id="print_qr" class="btn btn-primary">Print <i class="fas fa-qrcode"></i></button>
                <button type="button" class="btn btn-primary" class="release_btn">Release <i class="fas fa-share"></i></button>
            </div> 
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var path = '<?php echo base_url() .'Create_profile/qr_code/3/2/';?>';
    var doc_number = '<?php echo $doc_number; ?>';
    $('#print_area').css("display", "none");
    $(document).ready(function(){
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
                            tr +='<td class="text-center">'+((r[ie].SHORTNAME_REGION == 'OSEC' ? 'DA / ' : '')+r[ie].ORIG_SHORTNAME+' / '+(r[ie].INFO_DIVISION == '' ? r[ie].INFO_SERVICE : r[ie].INFO_SERVICE+' / '+r[ie].INFO_DIVISION))+'</td>';
                            tr +='<td class="text-center">'+r[ie].date_added+'</td>';
                            tr +='<td class="text-center"></td>';
                            tr +='</tr>';
                        }
                        $('#recipients_list').html('').append(tr);
                    }
            });
            $('#print_modal').modal('show');
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>View_document/View_document_js"></script>
