<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/meta.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

	<title>SystemTask | Add User</title>

	<!------------------------------- top_link start -------------------------------------->
	<?php include 'include/common/top_link.php'; ?>
	<!------------------------------- top_link end ---------------------------------------->

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/config.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

</head>

<body id="custom-scrollbar">

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
							<form class="form-horizontal" id="add-user" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="user_name">Full Name</label>
											<input name="user_name" id="user_name" type="text" class="form-control" placeholder="Full Name">
											<div class="invalid-feedback"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="user_email">Email Id</label>
											<input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email Id">
											<div class="invalid-feedback"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="user_mobile">Mobile No</label>
											<input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="Mobile No">
											<div class="invalid-feedback"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="user_dob">User DOB</label>
											<div class="input-group">
												<input name="user_dob" id="user_dob" type="text" class="form-control datepicker" placeholder="DD-MM-YYYY">
												<div class="input-group-append">
													<span class="input-group-text"><i class="fa fa-calendar"></i></span>
												</div>
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="user_gender">User Gender</label>
											<input name="user_gender" id="user_gender" type="text" class="form-control" placeholder="User Gender">
											<div class="invalid-feedback"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="user_address">User Address</label>
											<input name="user_address" id="user_address" type="text" class="form-control" placeholder="User Address">
											<div class="invalid-feedback"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>User Image</label>
											<div class="custom-file">
												<input name="user_image" id="user_image" type="file" accept="image/*" class="form-control custom-file-input">
												<label class="custom-file-label" for="user_image">Choose file...</label>
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>User Signature</label>
											<div class="custom-file">
												<input name="user_signature" id="user_signature" type="file" accept="image/*" class="form-control custom-file-input">
												<label class="custom-file-label" for="user_signature">Choose file...</label>
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="row el-element-overlay">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-3">
												<div class="card" style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 20px;">
													<div class="el-card-item" style="margin-bottom: 0px;padding-bottom: 0px;">
														<div class="el-card-avatar el-overlay-1"><img id="preview_image" src="data:image/jpeg;base64,<?php echo base64_encode($user_array[0]["user_image"]); ?>" onerror="this.onerror=null; this.src=''" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-3">
												<div class="card" style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 20px;">
													<div class="el-card-item" style="margin-bottom: 0px;padding-bottom: 0px;">
														<div class="el-card-avatar el-overlay-1"><img id="preview_signature" src="data:image/jpeg;base64,<?php echo base64_encode($user_array[0]["user_signature"]); ?>" onerror="this.onerror=null; this.src=''" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="border-top">
									<div class="card-body">
										<div class="form-group">
											<button name="add_button" id="add_button" type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp; Add User</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!------------------------------- product end ----------------------------------------->

	</div>

	<!------------------------------- bottom_link start ----------------------------------->
	<?php include 'include/common/bottom_link.php'; ?>
	<!------------------------------- bottom_link end ------------------------------------->


	<script type="text/javascript" src="assets/js/user.js"></script>

	<script type="text/javascript">
		$("#user_image").change(function() {
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#preview_image').attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
			} else {
				$('#preview_image').attr('src', '');
			}
		});

		$("#user_signature").change(function() {
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#preview_signature').attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
			} else {
				$('#preview_signature').attr('src', '');
			}
		});
	</script>

</body>

</html>