$('document').ready(function () {
	// valid name pattern
	var nregex = /^[a-zA-Z ]+$/;
	$.validator.addMethod("validuser_name", function (value, element) {
		return this.optional(element) || nregex.test(value);
	});

	// valid email id pattern
	var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	$.validator.addMethod("validemail_id", function (value, element) {
		return this.optional(element) || eregex.test(value);
	});

	// valid mobile no pattern
	var mregex = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
	$.validator.addMethod("validmobile_no", function (value, element) {
		return this.optional(element) || mregex.test(value);
	});

	$('#login-user').validate({
		rules: {
			employee_email: {
				required: true,
				validemail_id: true
			},
			employee_password: {
				required: true,
				minlength: 6
			}
		},
		messages: {
			employee_email: {
				required: "Email Id is required",
				validemail_id: "Please enter valid email address"
			},
			employee_password: {
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

	$('#update-user').validate({
		rules: {
			employee_name: {
				required: true,
				validuser_name: true
			},
			employee_mobile: {
				required: true,
				validmobile_no: true
			}
		},
		messages: {
			employee_name: {
				required: "Full name is required",
				validuser_name: "Name must contain only alphabets and space",
			},
			employee_mobile: {
				required: "Mobiile number is required",
				validmobile_no: "Please enter valid mobile number"
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
		submitHandler: updateUser
	});

	function updateUser() {
		$.ajax({
			url: 'include/user/update_user.php',
			type: "POST",
			data: new FormData($('#update-user')[0]),
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'json',
			beforeSend: function () {
				$('#update-user #update_button').html('<img src="images/loader/ajax-loader.gif" />&nbsp; Updating...').prop('disabled', true);
				$('input[type=text],input[type=email],input[type=password],input[type=date],input[type=file],select').prop('disabled', true);
			},
			success: function (data) {
				setTimeout(function () {
					if (data.status == 'success') {
						toastr.success(data.message);
						$('#update-user #update_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Update User').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password],input[type=date],input[type=file],select').prop('disabled', false);
					} else {
						toastr.error(data.message);
						$('#update-user #update_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Update User').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password],input[type=date],input[type=file],select').prop('disabled', false);
					}
				}, 3000);
			},
			error: function (xhr, status, error) {
				toastr.error(xhr.responseText);
				$('#update-user #update_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Update User').prop('disabled', false);
				$('input[type=text],input[type=email],input[type=password],input[type=date],input[type=file],select').prop('disabled', false);
			}
		})
	}

	$('#change-password').validate({
		rules: {
			old_password: {
				required: true,
				minlength: 6
			},
			new_password: {
				required: true,
				minlength: 6
			},
			confirm_new_password: {
				required: true,
				equalTo: '#change-password #new_password'
			}
		},
		messages: {
			old_password: {
				required: "Old password is required",
				minlength: "Password at least have 6 characters"
			},
			new_password: {
				required: "Password is required",
				minlength: "Password at least have 6 characters"
			},
			confirm_new_password: {
				required: "Retype your password",
				equalTo: "Password did not match !"
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
		submitHandler: changePassword
	});

	function changePassword() {
		$.ajax({
			url: 'include/user/change_password.php',
			type: 'POST',
			data: $('#change-password').serialize(),
			dataType: 'json',
			beforeSend: function () {
				$('#change-password #change_button').html('<img src="images/loader/ajax-loader.gif" />&nbsp; Changing...').prop('disabled', true);
				$('input[type=text],input[type=email],input[type=password]').prop('disabled', true);
			},
			success: function (data) {
				setTimeout(function () {
					if (data.status == 'success') {
						$('#change-password').trigger('reset');
						toastr.success(data.message);
						$('#change-password #change_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Change Password').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
					} else {
						toastr.error(data.message);
						$('#change-password #change_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Change Password').prop('disabled', false);
						$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
					}
				}, 3000);
			},
			error: function (xhr, status, error) {
				toastr.error(xhr.responseText);
				$('#change-password #change_button').html('<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp; Change Password').prop('disabled', false);
				$('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
			}
		})
	}
});