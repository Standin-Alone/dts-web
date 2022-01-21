<div id="header" class="header navbar-default">
    <!-- begin navbar-header -->
    <div class="navbar-header">
        <a href="<?php echo base_url(); ?>" class="navbar-brand"> <img src="<?php echo base_url(); ?>assets/img/DA-Logo.png" width="30" height="30" style="display: inline-block"> <b> DOCUMENT TRACKING SYSTEM</b> </a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- end navbar-header -->

    <!-- begin header-nav -->

    <ul class="navbar-nav navbar-right">

        <li class="dropdown navbar-user">
            <div class="navbar-item navbar-form">
                <form id="track_document_number" name="track_document_number">
                    <div class="form-group">
                        <input name="document_number" id="search_document_number" type="text" class="form-control" placeholder="Enter Document Number">
                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </li>
        <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="https://devsysadd.da.gov.ph/evoucher/assets/img/images/profile/profile-user.png" alt="">
                <span class="d-none d-md-inline"><?php echo $this->session->userdata('username'); ?></span> <b class="caret"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(144px, 50px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a href="<?php echo base_url(); ?>Login/logout" class="dropdown-item">Log Out</a>
            </div>
        </li>
    </ul>
    <!-- end header navigation right -->
</div>

<!-- ===========================MODAL Document History=========================== -->
<div class="modal fae bd-example-modal-lg" id="modal_track" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container pt-3 pb-2">

                <!-- For demo purpose -->
                <div class="row text-center">
                    <div class="col-lg-8 mx-auto">
                        <h1 class="display-6">Document History</h1>
                        <span class="d-flex flex-row justify-content-center">
                            <!-- <p id="text_document_number" class="lead mb-0 text-dark"></p> -->

                        </span>
                    </div>
                </div><!-- End -->
                <div class="row p-4 d-flex flex-row justify-content-start align-items-end bg-light p-2">
                    <div class="col-md-9">
                        <h5><b id="text_document_number"></b>
                            <a href="#" class="btn-icon btn-sm copy link-secondary" style="text-decoration: none;" data-toggle="tooltip" data-placement="top" title="Click to copy">
                                <i class="ml-2 fa fa-clone text-gray"></i>
                            </a>
                        </h5>
                        <span class="d-flex flex-row align-items-end">
                            Type: &nbsp;
                            <h6 id="type" class="mb-0 "></h6>
                        </span>
                        <span class="d-flex flex-row align-items-end">
                            Subject: &nbsp;
                            <h6 id="subject" class="mb-0"></h6>
                        </span>
                        <span class="d-flex flex-row align-items-end">
                            Document Origin: &nbsp;
                            <h6 id="origin" class="mb-0 "></h6>
                        </span>
                    </div>
                    <div class="col-xl-3 col-lg-3 align-items-center d-flex justify-content-end p-3">
                        <img src="<?php echo base_url() ?>/assets/img/dashboard/track_document.svg" height="100" class="d-none d-lg-block">
                    </div>
                </div>
                <div class="row bg-light">
                    <div class="col-lg-12 mx-auto m-3 rounded scrollbar" style="max-height: 500px; background-color: #d7dfe6;">
                        <!-- Timeline -->
                        <ul id="timeline" class="timeline">

                        </ul><!-- End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>