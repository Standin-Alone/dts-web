<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" />
<style>
    @charset "UTF-8";

    .rating {
        font-size: 0;
    }

    .rating:after {
        content: " ";
        clear: both;
        display: block;
    }

    .rating input {
        display: none;
    }

    .rating-label {
        height: 16px;
        width: 16px;
        color: #ccc;
        font-size: 24px;
        line-height: 16px;
        margin-right: 4px;
        text-align: center;
        display: inline-block;
    }

    .rating[dir=rtl] {
        unicode-bidi: bidi-override;
    }

    .rating[dir=rtl]>input:checked~.rating-label {
        font-size: 0;
    }

    .rating[dir=rtl]>input:checked~.rating-label:before {
        content: "★";
        color: #feca02;
    }

    .rating-label.is-active {
        color: #feca02;
    }

    .rating-large .rating-label {
        height: 24px;
        width: 24px;
        font-size: 32px;
        margin-right: 8px;
    }

    .rating-large .rating-label:before {
        font-size: 32px;
    }

    .rating-small .rating-label {
        height: 12px;
        width: 12px;
        font-size: 16px;
        margin-right: 2px;
    }

    .rating-small .rating-label:before {
        font-size: 16px;
    }


    .wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .rating {
        margin: 15px auto;
    }
</style>
<div id="content" class="content">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Support">Support</a></li>
            <li class="breadcrumb-item active">User Feedback</li>
        </ol>
        <h1 class="page-header mb-3">User Feedback</h1>
        <!-- <h1 class="page-header mb-0">Scrum Board</h1> -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 mx-auto">
                <div class="card">
                    <form id="frm_user_feedback">
                        <div class="card-body">
                            <span class="d-flex flex-column align-items-center mb-5">
                                <img class="img-fluid" src="<?php echo base_url() ?>assets/img/support/user-feedback-banner.svg" alt="" width="60%">
                                <h2 class="content-title mt-2 text-center mt-5"><i class="fa fa-user-edit"></i> Users Feedback Form</h2>
                                <p class="card-text m-0 col-10 text-center">Thank you for using our system. Your feedbacks will help us improve and enhance the systems functionalities and user experience.</p>
                            </span>
                            <div class="form-group">
                                <label for="">How was your experience using the system?</label>
                                <textarea name="user_feedback" id="user_experience" class="form-control" id="exampleFormControlTextarea1" placeholder="Write your feedback here..." rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">What would you suggest to improve it?</label>
                                <textarea name="user_suggestion" class="form-control" id="exampleFormControlTextarea1" placeholder="Write your feedback here..." rows="5"></textarea>
                            </div>
                            <small class="mx-auto text-center mt-5">
                                <h3>Rate Us</h3>
                            </small>
                            <div class="col mx-auto d-flex justify-content-center">
                                <div class="rating rating-large" dir="rtl">
                                    <input type="radio" name="rate" id="5" value="5" />
                                    <label class="rating-label" for="5">&#9734</label>
                                    <input type="radio" name="rate" id="4" value="4" />
                                    <label class="rating-label" for="4">&#9734</label>
                                    <input type="radio" name="rate" id="3" value="3" />
                                    <label class="rating-label" for="3">&#9734</label>
                                    <input type="radio" name="rate" id="2" value="2" />
                                    <label class="rating-label" for="2">&#9734</label>
                                    <input type="radio" name="rate" id="1" value="1" />
                                    <label class="rating-label" for="1">&#9734</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>