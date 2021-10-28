<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Color Admin | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/default/theme/orange.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <script type="text/javascript">
        var base_url       = '<?php echo base_url(); ?>';
        var ci_module      = '<?php echo $this->uri->segment(1); ?>';
        var mS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // $.fn.serializeObject = function(){
        //     var o = {};
        //     var a = this.serializeArray();
        //     $.each(a, function() {
        //         if (o[this.name] !== undefined) {
        //             if (!o[this.name].push) {
        //                 o[this.name] = [o[this.name]];
        //             }
        //             o[this.name].push(this.value || '');
        //         } else {
        //             o[this.name] = this.value || '';
        //         }
        //     });
        //     return o;
        // };
    </script>
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- end #page-loader -->
        <!--<div class="wrapper"> -->
        <?php
            if($topbar) echo $topbar ;
        ?>
        <?php
            if($navbar) echo $navbar ;
        ?>
        <?php
            //if($middle) echo $banner ;
        ?>
        <?php
            if($middle) echo $middle ;
        ?>
        <?php
            if($footer) echo $footer ;
        ?>
        <?php
            //if($sidebar) echo $sidebar ;
        ?>
    </div>
        <?php
            if($assets) echo $assets ;
        ?>
</body>
</html>