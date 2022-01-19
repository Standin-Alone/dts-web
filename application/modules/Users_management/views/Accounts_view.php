<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">




<div id="content" class="content">
	<!-- <ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">UI Elements</a></li>
		<li class="breadcrumb-item active">Unlimited Nav Tabs</li>
	</ol> -->
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Account Management</h1>
	<div class="row">
		<!-- <div class="col-lg-3">
	        <div class="m-b-10 text-inverse f-s-10"><b>MAIN FEATURES</b></div>
	        <table class="text-inverse m-b-20 width-full">
	            <tr>
	                <td>
	                    <i class="fa fa-laptop fa-lg pull-left fa-fw m-r-10 m-t-5 p-t-2"></i>
	                    <div class="m-t-4">Responsive in any screen size</div>
	                </td>
	            </tr>
	            <tr>
	                <td class="p-t-10">
	                    <i class="fa fa-crosshairs fa-lg pull-left fa-fw m-r-10 m-t-5 p-t-2"></i>
	                    <div class="m-t-4">Autofocus on Active Tabs</div>
	                </td>
	            </tr>
	            <tr>
	                <td class="p-t-10">
	                    <i class="fa fa-expand fa-lg pull-left fa-fw m-r-10 m-t-5 p-t-2"></i>
	                    <div class="m-t-4">Support Expand Features</div>
	                </td>
	            </tr>
	            <tr>
	                <td class="p-t-10">
	                    <i class="fa fa-wrench fa-lg pull-left fa-fw m-r-10 m-t-5 p-t-2"></i>
	                    <div class="m-t-4">Auto Show / Hide Next & Prev Button</div>
	                </td>
	            </tr>
	        </table>
	        <div class="alert alert-warning">
	            <i class="fa fa-info-circle fa-lg m-r-5 pull-left m-t-2"></i> Unlimited Navigation Tabs is <b class="text-inverse">not compatible</b> with the bootstrap dropdown menu.
	        </div>
	    </div> -->
		<div class="col-lg-12">
			<div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
				<div class="panel-heading p-0">
		            <div class="panel-heading-btn m-r-10 m-t-10">
		                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		            </div>
		            <div class="tab-overflow">
		            	<ul class="nav nav-tabs nav-tabs-inverse">
		            		<li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active">Active Users</a></li>
		            		<li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link">Add User</a></li>
		            	</ul>
		            </div>
		        </div>
		        <div class="tab-content">
		        	<!--Active Users-->
		        	<div class="tab-pane fade active show" id="nav-tab-1">
		        		<table id="data-table-responsive" class="table table-striped table-bordered">
		        			<thead>
                                <tr>
                                	<th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Fullname</th>
                                    <th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Agency</th>
                                    <th class="text-nowrap">Office</th>
                                    <th class="text-nowrap">Location</th>
                                    <th class="text-nowrap">Role</th>
                                    <th class="text-nowrap">Date Added</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<tr class="odd gradeX">
                                	<td width="1%" class="f-s-600 text-inverse">1</td>
                                	<td width="1%" class="with-img"><img src="../assets/img/user/user-1.jpg" class="img-rounded height-30" /></td>
                                    <td>Trident</td>
                                    <td>Internet Explorer 4.0</td>
                                    <td>Win 95+</td>
                                    <td>4</td>
                                    <td>X</td>
                                    <td>4</td>
                                    <td>
										<a href="#" class="btn btn-success">
											<i class="fas fa-paper-plane fa-2x pull-left m-r-10 text-black"></i>
											<b>Send Recovery Email</b><br />
										</a>
                                    </td>
                                </tr>
                                <tr class="even gradeC">
                                	<td width="1%" class="f-s-600 text-inverse">2</td>
                                	<td width="1%" class="with-img"><img src="../assets/img/user/user-2.jpg" class="img-rounded height-30" /></td>
                                    <td>Trident</td>
                                    <td>Internet Explorer 5.0</td>
                                    <td>Win 95+</td>
                                    <td>5</td>
                                    <td>C</td>
                                    <td>4</td>
                                    <td>
										<a href="#" class="btn btn-success">
											<i class="fas fa-paper-plane fa-2x pull-left m-r-10 text-black"></i>
											<b>Send Recovery Email</b><br />
										</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeA">
                                	<td width="1%" class="f-s-600 text-inverse">3</td>
                                	<td width="1%" class="with-img"><img src="../assets/img/user/user-3.jpg" class="img-rounded height-30" /></td>
                                    <td>Trident</td>
                                    <td>Internet Explorer 5.5</td>
                                    <td>Win 95+</td>
                                    <td>5.5</td>
                                    <td>A</td>
                                    <td>4</td>
                                    <td>
										<a href="#" class="btn btn-success">
											<i class="fas fa-paper-plane fa-2x pull-left m-r-10 text-black"></i>
											<b>Send Recovery Email</b><br />
										</a>
                                    </td>
                                </tr>
                            </tbody>
		        		</table> 	
		        	</div>
		        	<!--End Users-->
		        	<div class="tab-pane fade" id="nav-tab-2">
		        		<div class="row">
			        		<div class="col-lg-6">
				        		<form class="form-horizontal" id="register_user" data-parsley-validate="true">
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="email">Email:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="email" id="email" name="email" placeholder="Required" data-parsley-required="true" data-parsley-id="5" autocomplete="off">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="first_name">First Name:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="text" id="first_name" name="first_name" data-parsley-required="true" data-parsley-id="5">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="middle_name">Middle Name:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="text" id="middle_name" name="middle_name"  data-parsley-required="true" data-parsley-id="5">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="last_name">Last Name:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="text" id="last_name" name="last_name"  data-parsley-required="true" data-parsley-id="5">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="ext_name">Extension Name:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="text" id="ext_name" name="ext_name"  data-parsley-required="true" data-parsley-id="5">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15">
										<label class="col-md-4 col-sm-4 col-form-label" for="mobile">Mobile Number:</label>
										<div class="col-md-8 col-sm-8">
											<input class="form-control parsley-error" type="text" id="mobile" name="mobile"  data-parsley-required="true" data-parsley-id="5">
											<!-- <ul class="parsley-errors-list filled" id="parsley-id-5">
												<li class="parsley-required">This value is required.</li>
											</ul> -->
										</div>
									</div>
									<div class="form-group row m-b-15 ">
										<div class="col-md-12 col-sm-12">
											<button type="submit" id="submit_btn" class="btn btn-lime pull-right">
												<span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none;"></span>
												Submit
											</button>
										</div>
									</div>
				        		</form>
			        		</div>

			        		<div class="col-lg-6">
			        			<form id="fileupload" action="<?php echo base_url(); ?>Users_management/upload_users_csv" method="POST" enctype="multipart/form-data">
			        				<div class="note note-yellow m-b-15">
										<div class="note-icon f-s-20">
											<i class="fa fa-lightbulb fa-2x"></i>
										</div>
										<div class="note-content">
											<h4 class="m-t-5 m-b-5 p-b-2">Uploading Notes</h4>
											<ul class="m-b-5 p-l-25">
												<li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
												<li>Only <strong>CSV</strong> file are allowed in this demo (by default there is no file type restriction).</li>
												<li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
											</ul>
										</div>
									</div>
									<div class="row fileupload-buttonbar">
										<div class="col-md-7">
											<span class="btn btn-primary fileinput-button m-r-3">
												<i class="fa fa-plus"></i>
												<span>Add files...</span>
												<input type="file" name="files[]" multiple>
											</span>
											<button type="submit" class="btn btn-primary start m-r-3">
												<i class="fa fa-upload"></i>
												<span>Start upload</span>
											</button>
											<button type="reset" class="btn btn-default cancel m-r-3">
												<i class="fa fa-ban"></i>
												<span>Cancel upload</span>
											</button>
											<button type="button" class="btn btn-default delete m-r-3">
												<i class="glyphicon glyphicon-trash"></i>
												<span>Delete</span>
											</button>
											<!-- The global file processing state -->
											<span class="fileupload-process"></span>
										</div>
										<div class="col-md-5 fileupload-progress fade">
											<!-- The global progress bar -->
											<div class="progress progress-striped active m-b-0">
												<div class="progress-bar progress-bar-success" style="width:0%;"></div>
											</div>
											<!-- The extended global progress state -->
											<div class="progress-extended">&nbsp;</div>
										</div>
									</div>
									<table class="table table-striped table-condensed">
										<thead>
											<tr>
												<th width="10%">PREVIEW</th>
												<th>FILE INFO</th>
												<th>UPLOAD PROGRESS</th>
												<th width="1%"></th>
											</tr>
										</thead>
										<tbody class="files">
											<tr data-id="empty">
												<td colspan="4" class="text-center text-muted p-t-30 p-b-30">
													<div class="m-b-10"><i class="fa fa-file fa-3x"></i></div>
													<div>No file selected</div>
												</td>
											</tr>
										</tbody>
									</table>
			        			</form>
			        		</div>
			        	</div>
		        	</div>
		        </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	
	$(document.body).on('submit', '#register_user', function(){
		var form_data = $(this).serializeObject();
		
		$('#loader').show();
		$('#submit_btn').attr('disabled', true);
		$.ajax({
			url: base_url + 'Users_management/send_invite',
			type: 'POST',
			data: form_data,
			dataType: 'json',
			success: function(data){
				if(data.result == 'send'){
					Swal.fire({
		              title: 'Sent',
		              text: "An email has been sent to the user",
		              icon: 'success',
		              confirmButtonColor: '#3085d6',
		              cancelButtonColor: '#d33',
		              confirmButtonText: 'Ok',
		              allowOutsideClick: false
		            }).then((result) => {
		              if (result.isConfirmed) {
		                setTimeout(function() {
		                  	$('#loader').hide();
							$('#submit_btn').removeAttr('disabled');	
		                }, 200);
		              }

		            });
				}else {
					Swal.fire({
		              title: 'Failed Sending',
		              text: "Something went wrong upon sending email",
		              icon: 'danger',
		              confirmButtonColor: '#3085d6',
		              cancelButtonColor: '#d33',
		              confirmButtonText: 'Ok',
		              allowOutsideClick: false
		            }).then((result) => {
		              if (result.isConfirmed) {
		                setTimeout(function() {
		                  	$('#loader').hide();
							$('#submit_btn').removeAttr('disabled');
		                }, 200);
		              }
		            });
				}
				
			}
		});

		return false;
	});

</script>

<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade show">
            <td>
                <span class="preview"></span>
            </td>
            <td>
            	<div class="alert alert-secondary p-10 m-b-0">
					<dl class="m-b-0">
						<dt class="text-inverse">File Name:</dt>
						<dd class="name">{%=file.name%}</dd>
						<dt class="text-inverse m-t-10">File Size:</dt>
						<dd class="size">Processing...</dd>
					</dl>
				</div>
                <strong class="error text-danger"></strong>
            </td>
            <td>
            	<dl>
					<dt class="text-inverse m-t-3">Progress:</dt>
					<dd class="m-t-5">
						<div class="progress progress-sm progress-striped active rounded-corner"><div class="progress-bar progress-bar-primary" style="width:0%; min-width: 40px;">0%</div></div>
					</dd>
				</dl>
            </td>
            <td nowrap>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start width-100 p-r-20 m-r-3" disabled>
                        <i class="fa fa-upload fa-fw pull-left m-t-2 m-r-5 text-inverse"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-default cancel width-100 p-r-20">
                        <i class="fa fa-trash fa-fw pull-left m-t-2 m-r-5 text-muted"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade show">
            <td width="1%">
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } else { %}
                    	<div class="bg-silver text-center f-s-20" style="width: 80px; height: 80px; line-height: 80px; border-radius: 6px;">
                    		<i class="fa fa-file-image fa-lg text-muted"></i>
                    	</div>
                    {% } %}
                </span>
            </td>
            <td>
            	<div class="alert alert-secondary p-10 m-b-0">
					<dl class="m-b-0">
						<dt class="text-inverse">File Name:</dt>
						<dd class="name">
							{% if (file.url) { %}
								<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
							{% } else { %}
								<span>{%=file.name%}</span>
							{% } %}
						</dd>
						<dt class="text-inverse m-t-10">File Size:</dt>
						<dd class="size">{%=o.formatFileSize(file.size)%}</dd>
					</dl>
					{% if (file.error) { %}
						<div><span class="label label-danger">Error</span> {%=file.error%}</div>
					{% } %}
				</div>
            </td>
            <td></td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete width-100 m-r-3 p-r-20" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash pull-left fa-fw text-inverse m-t-2"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-default cancel width-100 m-r-3 p-r-20">
                        <i class="fa fa-trash pull-left fa-fw text-muted m-t-2"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>


<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<!--[if (gte IE 8)&(lt IE 10)]>
    <script src="../assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/js/demo/form-multiple-upload.demo.min.js"></script>
