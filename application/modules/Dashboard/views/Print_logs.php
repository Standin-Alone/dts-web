<?php

if (!empty($document_logs)) {
?>
    <!DOCTYPE html>
    <!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>DTS | Print Logs</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/style.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->
    </head>

    <body class="pace-top">
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade show"><span class="spinner"></span></div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->

        <!-- begin error -->
        <table class="bg-white table table-bordered table-striped" width="100%">
            <tbody>
                <tr>
                    <td colspan="7" class="h3 text-center border-0">
                        <label>Document Tracking System<br>
                            <h5 class="mt-2">(Document Tracking Logs)</h5>
                        </label>
                    </td>
                </tr>
                <?php


                ?>
                <!-- dp.subject,
                            dt.type,
                            dp.office_code,
                            dp.created_by_user_fullname, 
                            INFO_SERVICE, INFO_DIVISION') -->
                <tr>
                    <td colspan="6" class="border-0" style="border: 0;">
                        Document Number: <?php if ($this->uri->segment('3')) {
                                                echo $this->uri->segment('3');
                                            } ?><br>
                        Subject: <?php echo $document_logs['document_details'][0]->subject; ?><br>
                        Type: <?php echo $document_logs['document_details'][0]->type; ?> <br>
                        Profiled By: <?php echo $document_logs['document_details'][0]->created_by_user_fullname; ?> <br>
                        Origin Office: <?php echo $document_logs['document_details'][0]->INFO_SERVICE . ' - ' . $document_logs['document_details'][0]->INFO_DIVISION; ?>
                    </td>
                    <td colspan="1" class="border-0 text-right" >Date: <?php echo      date("Y-m-d") ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr class="font-weight-bold">
                    <td>Type</td>
                    <td>Office</td>
                    <td>Assigned Personnel</td>
                    <td>Action</td>
                    <td>Status</td>
                    <td>Remarks</td>
                    <td>Log Date</td>
                </tr>
            </tbody>
            <tbody>
                <?php
                // print_r($document_logs);
                ?>
                <?php
                foreach ($document_logs['history'] as $row) {
                ?>
                    <tr>
                        <td> <?php echo $row->type ?></td>
                        <td> <?php echo $row->INFO_SERVICE . '-' . $row->INFO_DIVISION ?> </td>
                        <td> <?php echo $row->transacting_user_fullname ?> </td>
                        <td> <?php echo $row->action ?> </td>
                        <td> <?php echo $row->status == '0' ? "<span> Invalid </span> " : "<span> Valid </span> " ?> </td>
                        <td> <?php echo $row->remarks ?> </td>
                        <td> <?php echo $row->time ?> </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>

        <!-- end error -->

        <!-- begin scroll to top btn -->
        <!-- <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a> -->
        <!-- end scroll to top btn -->

        <!-- end page container -->

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
        <script type="text/javascript">
            setTimeout(() => {
                window.print();
            }, 1500);
        </script>
    </body>

    </html>

<?php } else {
?>
    <!DOCTYPE html>
    <!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Color Admin | 404 Error Page</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/style.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->
    </head>

    <body class="pace-top">
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade show"><span class="spinner"></span></div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->
        <div id="page-container" class="fade">
            <!-- begin error -->
            <div class="error">
                <div class="error-code m-b-10">PAGE NOT FOUND!</div>
                <div class="error-content">
                    <div class="error-message">We couldn't find it...</div>
                    <div class="error-desc m-b-30">
                        The page you're looking for doesn't exist. <br />
                        Perhaps, there pages will help find what you're looking for.
                    </div>
                    <div>
                        <a href="<?php echo base_url(); ?>Dashboard" class="btn btn-success p-l-20 p-r-20">Go to Dashboard</a>
                    </div>
                </div>
            </div>
            <!-- end error -->

            <!-- begin scroll to top btn -->
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
            <!-- end scroll to top btn -->
        </div>
        <!-- end page container -->

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

    </html>
<?php } ?>