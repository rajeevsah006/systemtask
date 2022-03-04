<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/meta.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

	<title>SystemTask | Dashboard</title>

	<!------------------------------- top_link start -------------------------------------->
	<?php include 'include/common/top_link.php'; ?>
	<!------------------------------- top_link end ---------------------------------------->

	<!------------------------------- meta start ------------------------------------------>
	<?php include 'include/common/config.php'; ?>
	<!------------------------------- meta end -------------------------------------------->

	<style type="text/css">
		.card-user .image {
			height: 150px;
			position: relative;
			overflow: hidden;
			padding: 20px;
		}

		.card-user .image img {
			width: 100%;
		}

		.card-user .image-plain {
			height: 0;
			margin-top: 110px;
		}

		.card-user .author {
			text-align: center;
			text-transform: none;
			margin-top: -65px;
		}

		.card-user .author .title {
			color: #403D39;
		}

		.card-user .author .title small {
			color: #ccc5b9;
		}

		.card-user .avatar {
			width: 100px;
			height: 100px;
			border-radius: 50%;
			position: relative;
			margin-bottom: 15px;
		}

		.card-user .avatar.border-white {
			border: 5px solid #FFFFFF;
		}

		.card-user .avatar.border-gray {
			border: 5px solid #ccc5b9;
		}

		.card-user .title {
			font-weight: 600;
			line-height: 24px;
		}

		.card-user .description {
			margin-top: 10px;
		}

		.card-user .content {
			min-height: 150px;
		}

		.card-user.card-plain .avatar {
			height: 190px;
			width: 190px;
		}
	</style>

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

		<!------------------------------- dashboard start ------------------------------------->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 col-lg-4 col-xlg-4">
									<div class="card card-user" style="height: 100%;">
										<div class="image">
											<img src="images/background/user-page.jpeg" alt="undefined" />
										</div>
										<div class="content">
											<div class="author">
												<?php
												$employee_array = $systemTask->getEmployeeByEmployeeSno($_SESSION['session_employee_sno']);
												if (!empty($employee_array))
												{
												?>
													<a class="image-popup-no-margins" href="images/logo/user.png"><img class=" avatar" src="images/logo/user.png" /></a>
													<h4 class="title"><?php echo $employee_array[0]["employee_name"]; ?><br /><a href="javascript:void(0)"><small>@<?php echo $employee_array[0]["employee_role"]; ?></small></a></h4>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-8 col-xlg-8">
									<div class="card" style="height: 100%;">
										<form class="form-horizontal" id="change-password" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
											<div class="card-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label for="old_password">Old Password</label>
															<input name="old_password" id="old_password" type="password" class="form-control" placeholder="Old Password">
															<div class="invalid-feedback"></div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="new_password">New Password</label>
															<input name="new_password" id="new_password" type="password" class="form-control" placeholder="New Password">
															<div class="invalid-feedback"></div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="confirm_new_password">Confirm New Password</label>
															<input name="confirm_new_password" id="confirm_new_password" type="password" class="form-control" placeholder="Confirm New Password">
															<div class="invalid-feedback"></div>
														</div>
													</div>
												</div>
											</div>
											<div class="border-top">
												<div class="card-body">
													<div class="form-group">
														<button name="change_button" id="change_button" type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp; Change Password</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!------------------------------- dashboard end --------------------------------------->

	</div>

	<!------------------------------- bottom_link start ----------------------------------->
	<?php include 'include/common/bottom_link.php'; ?>
	<!------------------------------- bottom_link end ------------------------------------->

	<script type="text/javascript" src="assets/js/user.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.home_tab').addClass('active');
		});
	</script>

</body>

</html>