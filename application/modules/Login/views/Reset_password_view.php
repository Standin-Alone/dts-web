<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Document Tracking | Login</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <meta name="viewport" content="width=device-width" />

  <!-- <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/icon.png"> -->

  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
  <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/default/style.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/select2-develop/dist/css/select2.min.css">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>

  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fontawesome5.11.2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sb-admin-2.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.css">
  
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.js"></script> -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
  </script>

</head>
<body class="pace-top bg-white">
  <div id="page-loader" class="fade show"><span class="spinner"></span></div>
  <!-- end #page-loader -->
  
  <!-- begin #page-container -->
  <div id="page-container" class="fade">
    <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(../../../assets/img/login-bg/login-bg-10.jpg)"></div>
                <div class="news-caption">
                    <!-- <h4 class="caption-title"><b>Document Tracking System</b></h4> -->
                    <p>
                        Download the mobile application <a href='<?php echo base_url(); ?>DTSMobile.apk'>here</a>.
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
                <?php

                /*echo '<pre>';
                print_r($user_data);
                echo '</pre>';*/
                ?>
                <!-- begin login-content -->
                <div class="login-content">
                    <div id="error_msg">
                    </div>
                    <form id="create_account" class="margin-bottom-0">
                      <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email Address" disabled />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="First Name" required />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="middle_name" name="middle_name" placeholder="Middle Name (Atleast Initial)" required />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Last Name" required />
                        </div>
                        <div class="form-group m-b-15">
                          <select class="js-example-basic-single form-control-lg" id="office" name="office" required>
                            <option></option>
                          </select>
                        </div><!-- 
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="mobile" name="mobile" placeholder="Mobile" required />
                        </div> -->
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control form-control-lg" id="password" name="password" placeholder="New Password" required />
                        </div>
                        <!-- <div class="checkbox checkbox-css m-b-30">
              <input type="checkbox" id="remember_me_checkbox" value="" />
              <label for="remember_me_checkbox">
                Remember Me
              </label>
            </div> -->
                        <div class="login-buttons">
                            <button type="submit" id="create_btn" class="btn btn-success btn-block btn-lg">
                                <span class="spinner-border spinner-border-sm" id="loader" role="status" aria-hidden="true" style="display: none;"></span>
                                Reset
                            </button>
                        </div>

                        <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                            Forgot your password? Click <a href="<?php echo base_url(); ?>Login/recover" class="text-success">here</a> to reset.
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
  <script type="text/javascript">
    $.fn.serializeObject = function(){
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
  </script>
  <script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/js-cookie/js.cookie.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/theme/default.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/apps.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2-develop/dist/js/select2.full.min.js"></script>

  <script type="text/javascript">
    var user_data = <?php echo json_encode($user_data); ?>;
    var token     = "<?php echo $this->security->get_csrf_hash(); ?>";
    var utoken    = "<?php echo $utoken; ?>";

    $('#email').val(user_data.email);
    $('#first_name').val(user_data.first_name);
    $('#middle_name').val(user_data.middle_name);
    $('#last_name').val(user_data.last_name);
    $('#office').append('<option selected value="'+user_data.office+'">'+user_data.division_name+'</option>');


    $('#office').select2({
      placeholder: "Office / Place of Assignment",
      allowClear: true,
      minimumResultsForSearch: 10,
      width: '100%',
      ajax: {
        url: base_url + 'Login/get_offices',
        type: 'get',
        dataType: 'json',
        data: function(params){
          var queryParameters = {
                    term: params.term
                }
                return queryParameters;
        },
        processResults: function(data){
          return {
                results: data
            };
        }
      }
    });

    $(document.body).on('submit', '#create_account', function(){
      var form_data       = $(this).serializeObject();
      form_data['utoken'] = utoken;
      console.log(form_data);

      $('#loader').show();
      $('#create_btn').attr('disabled', true);

      $.ajax({
        url: base_url + 'Login/insert_user_information',
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function(data){
          if(data.results == 'success'){
            Swal.fire({
              title: 'Horaay!',
              text: "Your account has been reset the password, you may now login.",
              icon: 'success',
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok',
              allowOutsideClick: false
            }).then((result) => {
              if (result.isConfirmed) {
                setTimeout(function() {
                  window.location = base_url + 'Login';
                }, 200);
              }
            });
          }
        }
      });
      return false;
    }); 
  </script>
  <!-- ================== END BASE JS ================== -->

  <script>
    $(document).ready(function() {
      App.init();
    });
  </script>
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>Login/Login_js"></script>
</html>
