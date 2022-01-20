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