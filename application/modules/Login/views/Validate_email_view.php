<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Document Tracking | Recover Password</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="viewport" content="width=device-width" />

	<!-- <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/icon.png"> -->

	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/default/style.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-4.0.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fontawesome5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sb-admin-2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.css">
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.js"></script> -->
	<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>';
	</script>
	<style type="text/css">
        @keyframes spinner-border {
          to { transform: rotate(360deg); }
        } 
        .spinner-border{
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: .25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border .75s linear infinite;
            animation: spinner-border .75s linear infinite;
        }
        .spinner-border-sm{
            height: 1rem;
            border-width: .2em;
        }
    </style>
</head>
<body class="pace-top bg-white">
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(../assets/img/login-bg/login-bg-10.jpg)"></div>
                <div class="news-caption">
                    <!-- <h4 class="caption-title"><b>Document Tracking System</b></h4> -->
                    <p>
                        Download the mobile application <a href='#'>here</a>.
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                        <img src="<?php echo base_url(); ?>assets/img/logo/DA-Logo.png" width="30" height="30" style="display: inline-block">
                        <b>Document Tracking</b>
                        <small>Keep in touch with your document.</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <div id="error_msg">
                    </div>
                    <form id="reset_form" class="margin-bottom-0">
                        <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" name="email" placeholder="Enter your email here" required />
                        </div>
                        <div class="login-buttons">
                            <button type="submit" id="resend_otp" class="btn btn-outline-success btn-block btn-lg">
                        		<span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none;"></span>
                        		Reset Password
                        	</button>
                        </div>
                        <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                            Click <a href="<?php echo base_url(); ?>Login" class="text-success">here</a> to return to login.
                        </div>
                        <hr />
                        <p class="text-center text-grey-darker">
                            &copy; Department of Agriculture 2021
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
	</div>

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<!--[if lt IE 9]>
		<script src="../assets/crossbrowserjs/html5shiv.js"></script>
		<script src="../assets/crossbrowserjs/respond.min.js"></script>
		<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/js-cookie/js.cookie.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/theme/default.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
<script type="text/javascript">
	$(function() {
		'use strict';

		$('#reset_form').on('submit', function() {
			var form_data = $(this).serializeArray();

			console.log(form_data);
			$.ajax({
				url: base_url + 'Login/check_email',
				type: 'post',
				data: form_data,
				dataType: 'json',
				success: function(results){
					console.log(results)
				}
			});

			return false;
		});
	});
</script>
</html>
