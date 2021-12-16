$(function() {
	'use strict';

	var $login_form = $('#login_form');

	$login_form.on('submit', function() {
		var form_data = $(this).serializeArray();

		$('#loader').show();
		$('#login_btn').attr('disabled', true);

		$.ajax({
			url: base_url + 'Login/check',
			type: 'post',
			data: form_data,
			dataType: 'json',
			success: function(results){
				//console.log(results)
				if(results.result == 'success'){
					Swal.fire({
						title: 'Welcome!',
						text: "The OTP has been sent to your email",
						icon: 'success',
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ok',
						allowOutsideClick: false
					}).then((result) => {
						if (result.isConfirmed) {
							setTimeout(function() {
								window.location = base_url + 'Login/otp/' + results.token;
							}, 200);
						}
					});
	            }
	            if(results.result == 'failed') {
	            	var error_msg = '<div id="error_login" class="alert alert-danger alert-dismissible fade show" role="alert">'+
	            						'The<strong> email and/or password</strong> is incorrect.'+
	            						'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
	            							'<span aria-hidden="true">&times;</span>'+
	            						'</button>'+
	            					'</div>';
	            	//console.log(results)
	            	$('#token').val(results.token);
					$('#error_msg').html(error_msg);

					$('#loader').hide();
					$('#login_btn').removeAttr('disabled');;
	            }
			}
		});
		return false;
	});
});