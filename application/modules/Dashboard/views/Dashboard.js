$(function () {
	"use strict";

	$(".copy").on("click", function () {
		var document_no = $(document).find("#text_document_number").text();

		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val(document_no).select();
		document.execCommand("copy");
		$temp.remove();

		Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Copied To Clipboard",
			text: document_no,
			showConfirmButton: false,
			timer: 1500,
		});
	});

	$(document)
		.find(".check_status")
		.each(function (i) {
			var check_status_btn = $(this);
			check_status_btn.on("click", function () {
				var document_number = check_status_btn
					.parents(".list-group-item")
					.find(".status_document_number")
					.text();
				var result = document_number.split(" ").join("");
				console.log(result);
				track_document(result);
			});
		});

	function promp_toast(count) {
		// storage sample
		// localStorage.setItem('date-registered', '07/12/2020')
		var date_registered = localStorage.getItem("date-registered");
		// get current date
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, "0");
		var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
		var yyyy = today.getFullYear();
		today = mm + "/" + dd + "/" + yyyy;

		if (today != date_registered) {
			localStorage.setItem("date-registered", today);

			var notif_message = `
            <span class="col d-flex flex-column">
                <span>You have <span class="text-danger font-weight-bold">${count.count_total}</span> <span class="text-danger">overdue</span> documents</span><br>
            </span>
            `;

			iziToast.show({
				timeout: 200000,
				theme: "dark",
				backgroundColor: "#212529",
				// icon: 'error',
				image: base_url + "assets/img/web_icon.png",
				overlayClose: true,
				overlay: true,
				icon: "user",
				closeOnEscape: true,
				closeOnClick: true,
				close: false,
				title: "Welcome!",
				message: notif_message,
				// closeOnClick: 'false',
				position: "center", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
				progressBarColor: "#f59c1a",
				buttons: [
					[
						`<button><i class="fa fa-arrow-down mr-2 text-success"></i><b>Incoming </b>${count.count_incoming}</button>`,
						function (instance, toast) {
							location.href =
								base_url +
								"Dashboard/Incoming_documents_view/?target='over_due'";
						},
					],
					[
						`<button><i class="fa fa-arrow-up mr-2 text-warning"></i><b>Outgoing </b>${count.count_outgoing}</button>`,
						function (instance, toast) {
							location.href =
								base_url +
								"Dashboard/Outgoing_documents_view/?target='over_due'";
							instance.hide({ transitionOut: "fadeOut" }, toast, "button");
						},
					],
					[
						`<button><b>Later</b></button>`,
						function (instance, toast) {
							instance.hide({ transitionOut: "fadeOut" }, toast, "button");
						},
					],
				],
				// onClosing: function(instance, toast, closedBy){
				//     console.info('Closing | closedBy: ' + closedBy);
				// },
				// onClosed: function(instance, toast, closedBy){
				//     console.info('Closed | closedBy: ' + closedBy);
				// }
			});
		}

		console.log(today);
		console.log(date_registered);
	}

	$.ajax({
		type: "get",
		url: base_url + "/Dashboard/count_overdue",
		dataType: "json",
		success: function (response) {
			// console.log(response.count_incoming);
			if (response.count_total > 0) {
				promp_toast(response);
			}
		},
	});

	// promp_toast(1)

	// var myTable = $('#logs_table').DataTable({
	//     dom: 'lfrtip',
	//     processing: true,
	//     ordering: false,
	//     serverSide: true,
	//     paging: true,
	//     ajax: {
	//         url: base_url + 'Home/get_rc_records',
	//         type: 'post'
	//     },
	//     columns: [
	//         {
	//             className: 'text-center align-middle',
	//             render: function (data, type, row) {
	//                 var link = '<a href="' + base_url + 'View_document/document/' + row.document_number + '">' + row.document_number + '</a>';
	//                 return link;
	//             }
	//         },
	//         {
	//             data: 'docu_status',
	//             className: 'text-center align-middle'
	//         },
	//         {
	//             data: 'reference_no',
	//             className: 'text-center align-middle'
	//         },
	//         {
	//             data: 'subject',
	//             className: 'text-center align-middle'
	//         },
	//         {
	//             data: 'received_by',
	//             className: 'text-center align-middle'
	//         },
	//         {
	//             className: 'text-center align-middle',
	//             render: function (data, type, row) {
	//                 var date = new Date(row.status_d_received);
	//                 var new_date = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
	//                 return new_date;
	//             }
	//         },
	//         {
	//             className: 'text-center align-middle',
	//             render: function (data, type, row) {
	//                 var str = row.time_received;
	//                 var res = str.split(":");
	//                 var hours = res[0];
	//                 var minutes = res[1];
	//                 var ampm = hours >= 12 ? 'PM' : 'AM';
	//                 hours = hours % 12;
	//                 hours = hours ? hours : 12; // the hour '0' should be '12'
	//                 var strTime = hours + ':' + minutes + ' ' + ampm;
	//                 return strTime;
	//             }
	//         }
	//     ]
	// });

	$("#all_document").on("click", function () {
		requests = "";
		$("#card_header").removeClass("text-primary");
		$("#card_header").removeClass("text-success");
		$("#card_header").removeClass("text-danger");
		$("#card_header").addClass("text-info");
		$("#card_header").text("All Document");
		myTable.draw();
	});

	$("#receive_doc").on("click", function () {
		requests = "Received";
		$("#card_header").removeClass("text-primary");
		$("#card_header").removeClass("text-info");
		$("#card_header").removeClass("text-danger");
		$("#card_header").addClass("text-success");
		$("#card_header").text("Received Document");
		myTable.draw();
	});

	$("#release_doc").on("click", function () {
		requests = "Released";
		$("#card_header").removeClass("text-success");
		$("#card_header").removeClass("text-info");
		$("#card_header").removeClass("text-danger");
		$("#card_header").addClass("text-primary");
		$("#card_header").text("Released Document");
		myTable.draw();
	});

	$("#return_doc").on("click", function () {
		requests = "Returned";
		$("#card_header").removeClass("text-success");
		$("#card_header").removeClass("text-info");
		$("#card_header").removeClass("text-primary");
		$("#card_header").addClass("text-danger");
		$("#card_header").text("Returned Document");
		myTable.draw();
	});

	function search_received(key_word) {
		console.log(key_word);
		var div = $(document).find("#released_div");

		if (key_word) {
			div.html(
				`
            <svg class="spinner my-auto mx-auto" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        `
			);
		}
		setTimeout(() => {
			$.ajax({
				type: "post",
				url: base_url + "Dashboard/Received_documents/" + key_word,
				data: key_word,
				dataType: "json",
				success: function (response) {
					console.log(response);
					if (response) {
						// var filtered = response.fil

						var append_html = $.map(response, function (value) {
							var document_number = value.document_number;
							var type = value.type;
							var subject = value.subject;
							var date = value.date;

							console.log(document_number);
							console.log(type);
							console.log(subject);
							console.log(date);
							var html = `
                            <div class="card mb-0 mt-1 p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex flex-column mt-1">
                                        <span class="h6 m-0">Document No: <label> ${document_number}</label></span>
                                        <span class="h6 m-0">Document Type: <label>${type}</label> </span>
                                        <span class="h6 m-0">Subject: <label> ${subject}</label></span>
                                    </div>
                                    <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Released: ${date}</span>
                                </div>
                            </div>
                            `;
							return html;
						});

						div.html(append_html);
					} else {
						var append_html = `
                                            No Records Found
                                          `;

						div.html(append_html);
					}
				},
			});
		}, 1500);
	}

	function search_released(key_word) {
		console.log(key_word);
		var div = $(document).find("#released_div");

		if (key_word) {
			div.html(
				`
            <svg class="spinner my-auto mx-auto" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        `
			);
		}
		setTimeout(() => {
			$.ajax({
				type: "post",
				url: base_url + "Dashboard/Released_documents/" + key_word,
				data: key_word,
				dataType: "json",
				success: function (response) {
					if (response) {
						var append_html = $.map(response, function (value) {
							var document_number = value.document_number;
							var type = value.type;
							var subject = value.subject;
							var date = value.date;

							console.log(document_number);
							console.log(type);
							console.log(subject);
							console.log(date);
							var html = `
                            <div class="card mb-0 mt-1 p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="d-flex flex-column mt-1">
                                        <span class="h6 m-0">Document No: <label> ${document_number}</label></span>
                                        <span class="h6 m-0">Document Type: <label>${type}</label> </span>
                                        <span class="h6 m-0">Subject: <label> ${subject}</label></span>
                                    </div>
                                    <span class="small text-gray align-self-start mt-1"><i class="fa fa-clock-o mr-1"></i>Date Released: ${date}</span>
                                </div>
                            </div>
                            `;
							return html;
						});

						div.html(append_html);
					}
				},
			});
		}, 1500);
	}

	$(document)
		.find("#search_released")
		.on("keyup", function () {
			var data = $(this).val();
			search_released(data);
		});
	$(document)
		.find("#released_btn")
		.on("click", function () {
			var data = $(document).find("#search_released").val();
			search_released(data);
		});

	$(document.body).on("submit", "#received_document", function (e) {
		e.preventDefault();
		var input = $(document).find("#received_document_btn");

		if (input.val()) {
			$("#receive_btn").attr("disabled", true);
			var form_data = $(this).serializeArray();
			console.log(form_data);
			$.ajax({
				type: "post",
				url: base_url + "Receipt_Control_Center/receive_document",
				data: form_data,
				dataType: "json",
				success: function (result) {
					var office = result.office;
					var office_code = result.office_code;
					if (result.error == "false") {
						Swal.fire({
							icon: "success",
							type: "success",
							title: "Well Done!",
							text: result.message,
						}).then((result) => {
							var message = `Your document has been received by ${office}`;

							socket().emit("push notification", {
								channel: office_code,
								message: message,
							});
							setTimeout(function () {
								$("#receive_btn").removeAttr("disabled");
								track_document(input.val());
							}, 200);
						});
					}
					if (result.error == "true") {
						Swal.fire({
							icon: "info",
							type: "warning",
							title: "Oops!",
							text: result.message,
						}).then((result) => {
							setTimeout(function () {
								$("#receive_btn").removeAttr("disabled");
								track_document(input.val());
							}, 200);
						});
					}
					// console.log(result);
					// if (result.Message == 'true') {
					//     console.log(result);
					//     Swal.fire({
					//         type: 'success',
					//         title: 'Well Done!',
					//         text: 'You have successfully received the document',
					//     }).then((result) => {
					//         setTimeout(function () {

					//         }, 200);
					//     });
					// } else if (result.Message == 'false') {
					//     console.log(result);
					//     Swal.fire({
					//         type: 'danger',
					//         title: 'Oops!',
					//         text: 'Unauthorized Recepient',
					//     }).then((result) => {
					//         setTimeout(function () {

					//         }, 200);
					//     });
					// }
				},
			});
		} else {
			input.addClass("parsley-error");
			var text_error = `
           

            `;
			input.parents("form").find(".error").text("This field is required");
		}

		return false;
	});

	// ====================================UPLOADING====================================

	$(document)
		.find(".logs")
		.each(function (i) {
			var check_status_btn = $(this);

			check_status_btn.on("click", function () {
				var document_number = check_status_btn
					.parents(".list-group-item")
					.find(".incoming_document_number")
					.text();
				var result = document_number.split(" ").join("");

				console.log(result);
				track_document(result);
			});
		});

	$(document.body).on("submit", "#form_receive", function (e) {
		e.preventDefault();

		var input = $("#document_number");
		if (input.val()) {
			$("#receive_btn").attr("disabled", true);
			var form_data = $(this).serializeArray();
			console.log(form_data);
			$.ajax({
				type: "post",
				url: base_url + "Receipt_Control_Center/receive_document",
				data: form_data,
				dataType: "json",
				success: function (result) {
					if (result.error == "false") {
						var office = result.sender_details.office;
						var office_code = result.sender_details.office_code;
						Swal.fire({
							icon: "success",
							type: "success",
							title: "Well Done!",
							text: result.message,
						}).then((result) => {
							var message = `Your document has been received by ${office}`;

							socket().emit("push notification", {
								channel: [office_code],
								message: message,
								document_number: result.document_number,
							});
							setTimeout(function () {
								$("#receive_btn").removeAttr("disabled");
								track_document(input.val());
							}, 200);
						});
					}

					if (result.error == "true") {
						Swal.fire({
							icon: "info",
							type: "warning",
							title: "Oops!",
							text: result.message,
						}).then((result) => {
							setTimeout(function () {
								$("#receive_btn").removeAttr("disabled");
								track_document(input.val());
							}, 200);
						});
					}
				},
			});
		} else {
			Swal.fire({
				icon: "info",
				type: "warning",
				title: "Oops!",
				text: "Please Input Document Number",
			});
		}

		return false;
	});
});
