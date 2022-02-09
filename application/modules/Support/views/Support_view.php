<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" />
<div id="content" class="content">

    <!-- <div class="col-md-12">
        <div class="card bg-info text-white mb-2" style="background: rgb(87,199,232); background: linear-gradient(90deg, rgba(87,199,232,1) 0%, rgba(73,182,214,1) 100%); height: 200px;">
            <span class="col-md-12 d-flex flex-row align-items-end">
                <span class="col"></span>
                <img class="img-fluid d-flex align-self-end" src="<?php echo base_url() ?>assets/img/support/support-banner.svg" alt="Card image" style="max-width: 16%;">
            </span>
            <div class="card-img-overlay text-center">

            </div>
        </div>
    </div> -->

    <div class="f-flex flex-column justify-content-center align-items-center mb-5">
        <span class="d-flex flex-column align-items-center">
            <img class="img-fluid" src="<?php echo base_url() ?>assets/img/support/support-banner.svg" alt="Card image" style="max-width: 13%;">
            <h2 class="content-title mt-2"><i class="fa fa-cog"></i> Support Services</h2>
            <p class="card-text m-0">Help us help you help them help me lets help together each other</p>
        </span>
    </div>

    <div class="col-md-12 d-flex flex-row align-items-center justify-content-center my-3">
        <a class="d-flex align-items-center mx-1 p-0 col-3 " href="<?php echo base_url() ?>Support/Report_bugs" style="text-decoration: none;">
            <div class=" card d-flex align-items-center menu" style="min-height: 250px;">
                <img src="<?php echo base_url() ?>assets/img/support/bug-report.svg" alt="" class="img-fluid mt-3" style="max-width: 35%">
                <div class="mt-2 text-center">
                    <h4 class="title">Send A Bug Report</h4>
                    <p class="text-secondary col-12 mx-auto">In case you encounter any bug/s or error/s in our system, you can take a screenshot and send us a brief explanation. We will gladly fix it.</p>
                </div>
            </div>
        </a>
        <a class="d-flex align-items-center mx-1 p-0 col-3 " href="<?php echo base_url() ?>Support/Assistance" style="text-decoration: none;">
            <div class=" card d-flex align-items-center menu" style="min-height: 250px;">
                <img src="<?php echo base_url() ?>assets/img/support/assistance.svg" alt="" class="img-fluid mt-3" style="max-width: 35%">
                <div class="mt-2 text-center">
                    <h4 class="title">Assistance</h4>
                    <p class="text-secondary col-12 mx-auto">Are you having a hard time using the system? You can ask questions directly from us. We are happy to assist you</p>
                </div>
            </div>
        </a>
        <a class="d-flex align-items-center mx-1 p-0 col-3 " href="<?php echo base_url() ?>Support/User_feedback" style="text-decoration: none;">
            <div class="card d-flex align-items-center menu" style="min-height: 250px;">
                <img src="<?php echo base_url() ?>assets/img/support/user-feedback.svg" alt="" class="img-fluid mt-3" style="max-width: 35%">
                <div class="mt-2 text-center">
                    <h4 class="title">User Feedback</h4>
                    <p class="text-secondary col-12 mx-auto">How was your experience using the system? Do you have a creative idea that will help us improve the system? Let us know.</p>
                </div>
            </div>
        </a>
    </div>
    <span class="d-flex flex-column align-items-center text-center mt-5">
        <h5 class=" title">Contact Us</h4>
            <span class="rounded col-1 bg-info pt-1 my-2"> </span>
            <span><i class="fa fa-envelope mr-2"></i> Email : sadd.da.gov.ph</span>
            <span><i class="fa fa-phone-alt mr-2"></i> Local Number : 2540</span>
    </span>
</div>


<script>
    $(document).ready(function() {

        $(".menu").each(function(index, element) {
            $(this).hover(
                function() {
                    $(this).filter(':not(:animated)').animate({
                        marginLeft: '9px'
                    }, 'fast');
                    // This only fires if the row is not undergoing an animation when you mouseover it
                },
                function() {
                    $(this).animate({
                        marginLeft: '0px'
                    }, 'fast');
                    // This only fires if the row is not undergoing an animation when you mouseover it
                },
            )
        });
    });
</script>