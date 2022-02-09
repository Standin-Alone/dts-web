


<div id="content" class="content">
 <table class="bg-white table table-bordered table-striped">
     <thead>
        <tr>
            <td>Type</td>
            <td>Office</td>
            <td>Assigned Personnel</td>
            <td>Action</td>
            <td>Status</td>
            <td>Remarks</td>
            <td>Log Date</td>
        </tr>
     </thead>
     <tbody>
    <?php 
    // print_r($document_logs);
    ?>
    <?php
    foreach($document_logs['history'] as $row){
    ?>
        <tr>
            <td>  <?php echo $row->type ?> </td>
            <td>  <?php echo $row->INFO_SERVICE.'-'.$row->INFO_DIVISION ?> </td>
            <td>  <?php echo $row->transacting_user_fullname ?> </td>
            <td>  <?php echo $row->action ?> </td>
            <td >  <?php echo $row->status == '0' ? "<span class='text-danger'> Invalid </span> " : "<span class='text-success'> Valid </span> " ?> </td>
            <td>  <?php echo $row->remarks ?> </td>
            <td>  <?php echo $row->time ?> </td>
        </tr>
    <?php } 
    ?>
     </tbody>
 </table>
</div>