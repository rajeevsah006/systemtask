<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/meta.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

	<title>SystemTask | Update User</title>

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
							<?php
							$employee_array = $systemTask->getemployeeByemployeeSno($_SESSION['session_employee_sno']);
							if (!empty($employee_array))
							{
							?>
								<form class="form-horizontal" id="update-user" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="employee_name">Full Name</label>
												<input name="employee_name" id="employee_name" type="text" class="form-control" value="<?php echo $employee_array[0]["employee_name"]; ?>" placeholder="Full Name">
												<div class="invalid-feedback"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="employee_mobile">Mobile No</label>
												<input name="employee_mobile" id="employee_mobile" type="text" class="form-control" value="<?php echo $employee_array[0]["employee_mobile"]; ?>" placeholder="Mobile No">
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="employee_dob">Employee DOB</label>
												<div class="input-group">
													<input name="employee_dob" id="employee_dob" type="text" class="form-control datepicker" value="<?php echo $employee_array[0]["employee_dob"]; ?>" placeholder="DD-MM-YYYY">
													<div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-calendar"></i></span>
													</div>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="employee_bg">Employee Blood Group</label>
												<input name="employee_bg" id="employee_bg" type="text" class="form-control" value="<?php echo $employee_array[0]["employee_bg"]; ?>" placeholder="Employee Blood Group">
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="employee_address">Employee Address</label>
												<input name="employee_address" id="employee_address" type="text" class="form-control" value="<?php echo $employee_array[0]["employee_address"]; ?>" placeholder="Employee Address">
												<div class="invalid-feedback"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Employee Identity</label>
												<div class="custom-file">
													<input name="employee_identify" id="employee_identify" type="file" accept="image/*" class="form-control custom-file-input">
													<label class="custom-file-label" for="employee_identify">Choose file...</label>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row el-element-overlay">
										<div class="col-md-3">
											<div class="card" style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 20px;">
												<div class="el-card-item" style="margin-bottom: 0px;padding-bottom: 0px;">
													<div class="el-card-avatar el-overlay-1"><img id="preview_image" src="<?php echo $employee_array[0]["employee_identify"]; ?>" onerror="this.onerror=null; this.src=''" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<input name="employee_sno" id="employee_sno" type="hidden" value="<?php echo $_SESSION['session_employee_sno']; ?>">
									<div class="border-top">
										<div class="card-body">
											<div class="form-group">
												<button name="update_button" id="update_button" type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp; Update User</button>
											</div>
										</div>
									</div>
								</form>
							<?php }
							else
							{ ?>
								<div class="col-md-12">
									<div class="card"><br /><br />
										<div class="empty-result" id="empty_result" style="text-align:center;">
											<img src="images/logo/empty_area.png" style="max-width:100%;" />
											<h2 style="font-weight: 900;">Sad No User!</h2>
											<br />
											<p style="font-family: Montserrat;color: gray;">We cannot find the user you are searching for, something wrong !!</p>
											<br />
										</div><br /><br />
									</div>
								</div>
							<?php } ?>
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
		$(document).ready(function() {
			$('.profile_tab').addClass('active');
		});

		$("#employee_identify").change(function() {
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
	</script>

</body>

</html>