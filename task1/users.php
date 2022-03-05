<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/meta.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

	<title>SystemTask | Users</title>

	<!------------------------------- top_link start -------------------------------------->
	<?php include 'include/common/top_link.php'; ?>
	<!------------------------------- top_link end ---------------------------------------->

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/config.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

</head>

<body class="custom-scrollbar">

	<!------------------------------- loder start ----------------------------------------->
	<div class="preloader">
		<div class="lds-ripple">
			<div class="lds-pos"></div>
			<div class="lds-pos"></div>
		</div>
	</div>
	<!------------------------------- loder end ------------------------------------------->

	<div id="main-wrapper">

		<!------------------------------- header start ---------------------------------------->
		<?php include 'include/common/header.php'; ?>
		<!------------------------------- header end ------------------------------------------>

		<!------------------------------- user start ------------------------------------------>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="table-wrapper">
								<div class="table-title mb-2">
									<div class="row">
										<div class="col-sm-6">
											<h2>Manage <b>Users</b></h2>
										</div>
										<div class="col-sm-6">
											<a href="add_user" class="btn btn-primary float-right"><i class="mdi mdi-plus"></i> <span>Add New User</span></a>
										</div>
									</div>
								</div>
								<table class="table table-striped table-bordered display nowrap" id="user-table" width="100%">
									<thead>
										<tr>
											<th>S. No</th>
											<th>Image</th>
											<th>User Name</th>
											<th>User Email</th>
											<th>User Mobile</th>
											<th>User Gender</th>
											<th>User DOB</th>
											<th>User Verified</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!------------------------------- user end ---------------------------------------->

	</div>

	<!------------------------------- bottom_link start ----------------------------------->
	<?php include 'include/common/bottom_link.php'; ?>
	<!------------------------------- bottom_link end ------------------------------------->

	<script type="text/javascript" src="assets/js/user.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.user_tab').addClass('active');
		});

		function initMagnificPopup() {
			$(".image-popup-no-margins").magnificPopup({
				type: "image",
				closeOnContentClick: true,
				closeBtnInside: false,
				fixedContentPos: true,
				mainClass: "mfp-no-margins mfp-with-zoom",
				image: {
					verticalFit: true
				},
				zoom: {
					enabled: true,
					duration: 300
				}
			});
		}

		$(document).ready(function() {
			$.ajax({
				url: "include/user/get_user.php",
				type: 'GET',
				dataType: 'json',
				cache: false,
				beforeSend: function() {
					$("#user-table").addClass("loading");
				},
				success: function(data) {
					console.log(data)
					$("#user-table").removeClass("loading");
					if (data.status == 'success') {
						var event_data = '';
						var count = 0
						$.each(data.details, function(index, value) {
							event_data += `
							<tr id="user_row_${value.user_sno}">
							<td>${++count}</td>
							<td>
								<a class="image-popup-no-margins" href="${value.user_image}"><img src="${value.user_image}" onerror="this.onerror=null; this.parentNode.href=this.src='images/logo/user.png'" width=" 35" height="35" style="margin: -12px 0px -12px 0px;"></a>
							</td>
							<td>${value.user_name}</td>
							<td>${value.user_email}</td>
							<td>${value.user_mobile}</td>
							<td>${value.user_gender}</td>
							<td>${value.user_dob}</td>
							<td>
								<div class="onoffswitch">
									<input type="checkbox" class="onoffswitch-checkbox" id="verified_${value.user_sno}" onClick="javascript:changeToVerified(${value.user_sno});" ${value.user_verified == "YES" ? "checked" : ""}>
									<label class="onoffswitch-label" for="verified_${value.user_sno}">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</td>
							<td>
								<a class="btn btn-outline-success" href="update_user?user_sno=${btoa(value.user_sno)}" data-toggle="tooltip" data-placement="top" data-original-title="Update"><span class="fas fa-pencil-alt"></span></a>
								<a class="btn btn-outline-danger" href="javascript:deleteFromUser(${value.user_sno});" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><span class="fas fa-trash-alt"></span></a>
							</td>
						</tr>`
						});
						$("#user-table tbody").append(event_data);
						initMagnificPopup();
					} else {
						toastr.error(data.message);
					}
				},
				error: function(xhr, status, error) {
					$("#user-table").removeClass("loading");
					toastr.error(xhr.responseText);
				}
			})
		});
	</script>

</body>

</html>