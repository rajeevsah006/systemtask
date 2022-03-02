$('document').ready(function () {
	// valid name pattern
	var nameregex = /^[a-zA-Z ]+$/;
	$.validator.addMethod("validfirst_name", function (value, element) {
		return this.optional(element) || nameregex.test(value);
	});

	// valid email id pattern
	var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	$.validator.addMethod("validemail_id", function (value, element) {
		return this.optional(element) || eregex.test(value);
	});

	// valid mobile no pattern
	$.validator.addMethod("intlTelNumber", function (value, element) {
		return this.optional(element) || $(element).intlTelInput("isValidNumber");
	});
	$('#login-user').validate({
		rules: {
			user_email: {
				required: true,
				validemail_id: true
			},
			user_password: {
				required: true,
				minlength: 6
			}
		},
		messages: {
			user_email: {
				required: "Email Id is required",
				validemail_id: "Please enter valid email address"
			},
			user_password: {
				required: "Password is required",
				minlength: "Password at least have 6 characters"
			}
		},
		errorPlacement: function (error, element) {
			$(element).closest('.form-group').find('.invalid-feedback').html(error.html());
		},
		highlight: function (element) {
			$(element).closest('.form-group').addClass('is-invalid').find('.form-control').addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).closest('.form-group').removeClass('is-invalid').find('.form-control').removeClass('is-invalid');
			$(element).closest('.form-group').find('.invalid-feedback').html('');
		},
		submitHandler: loginUser
	});

	function loginUser() {
		$.ajax({
			url: 'include/user/login_user.php',
			type: 'POST',
			data: $('#login-user').serialize(),
			dataType: 'json',
			beforeSend: function () {
				$('#login-user #login_button').html('<img src="images/loader/ajax-loader.gif" />&nbsp; Login You...').prop('disabled', true);
				$('input[type=text],input[type=email],input[type=password]').prop('disabled', true);
			},
			success: function (data) {
				setTimeout(function () {
					if (data.status == 'success') {
						toastr.success(data.message);
						$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
						$('#login-user #login_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Login Me').prop('disabled', false);
						window.location.href = "dashboard";
					} else {
						toastr.error(data.message);
						$('#login-user #login_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Login Me').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
					}
				}, 3000);
			},
			error: function (xhr, status, error) {
				toastr.error(xhr.responseText);
				$('#login-user #login_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Login Me').prop('disabled', false);
				$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
			}
		})
	}
	$('#add-faculty').validate({
		rules: {
			first_name: {
				required: true
			},
			last_name: {
				required: true
			},
			user_id: {
				required: true,
				remote: {
					url: 'include/check/check_employee.php',
					type: 'POST',
					data: {
						user_id: function () {
							return $('#add-faculty #user_id').val();
						}
					}
				}
			},
			user_name: {
				required: true,
				remote: {
					url: 'include/check/check_user.php',
					type: 'POST',
					data: {
						user_name: function () {
							return $('#add-faculty #user_name').val();
						}
					}
				}
			},
			domain_sno: {
				required: true
			},
			user_type: {
				required: true
			},
			mobile_no: {
				required: true
			},
			email_id: {
				required: true
			}
		},
		messages: {
			first_name: {
				required: "First name is required"
			},
			last_name: {
				required: "Last name is required"
			},
			user_id: {
				required: "Employee Id is required",
				remote: "Employee id allready exists , Please Try another one"
			},
			user_name: {
				required: "User name is required",
				remote: "User name allready exists , Please Try another one"
			},
			domain_sno: {
				required: "Domain Id is required"
			},
			user_type: {
				required: "User type is required"
			},
			mobile_no: {
				required: "Mobile no is required"
			},
			email_id: {
				required: "Email id is required"
			}
		},
		errorPlacement: function (error, element) {
			$(element).closest('.form-group').find('.invalid-feedback').html(error.html());
		},
		highlight: function (element) {
			$(element).closest('.form-group').addClass('is-invalid').find('.form-control').addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).closest('.form-group').removeClass('is-invalid').find('.form-control').removeClass('is-invalid');
			$(element).closest('.form-group').find('.invalid-feedback').html('');
		},
		submitHandler: addFaculty
	});

	function addFaculty() {
		$.ajax({
			url: 'include/user/add_faculty.php',
			type: 'POST',
			data: $('#add-faculty').serialize(),
			dataType: 'json',
			beforeSend: function () {
				$('#add-faculty #add_button').html('<img src="images/loader/ajax-loader.gif" />&nbsp; Adding...').prop('disabled', true);
				$('input[type=text],input[type=email],input[type=password],input[type=date],select').prop('disabled', true);
			},
			success: function (data) {
				setTimeout(function () {
					if (data.status == 'success') {
						$('.select2').val(null).trigger('change.select2');
						$('#add-faculty').trigger('reset');
						toastr.success(data.message);
						$('#add-faculty #add_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Add Faculty').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password],input[type=date],select').prop('disabled', false);
					} else {
						toastr.error(data.message);
						$('#add-faculty #add_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Add Faculty').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password],input[type=date],select').prop('disabled', false);
					}
				}, 3000);
			},
			error: function (xhr, status, error) {
				toastr.error(xhr.responseText);
				$('#add-faculty #add_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Add Faculty').prop('disabled', false);
				$('input[type=text],input[type=email],input[type=password],input[type=date],select').prop('disabled', false);
			}
		})
	}
});