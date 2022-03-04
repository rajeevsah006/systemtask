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
								<table class="table table-striped table-bordered display nowrap" id="domain-table" width="100%">
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
										<?php
										$count = 0;
										$user_array = $systemTask->getAllUser();
										if (!empty($user_array))
										{
											foreach ($user_array as $key => $value)
											{
										?>
												<tr id="user_row_<?php echo $user_array[$key]["user_sno"]; ?>">
													<td><?php echo ++$count; ?></td>
													<td>
														<a class="image-popup-no-margins" href="data:image/jpeg;base64,<?php echo base64_encode($user_array[$key]["user_image"]); ?>"><img src="data:image/jpeg;base64,<?php echo base64_encode($user_array[$key]["user_image"]); ?>" onerror="this.onerror=null; this.parentNode.href=this.src='images/logo/user.png'" width=" 35" height="35" style="margin: -12px 0px -12px 0px;"></a>
													</td>
													<td><?php echo $user_array[$key]["user_name"]; ?></td>
													<td><?php echo $user_array[$key]["user_email"]; ?></td>
													<td><?php echo $user_array[$key]["user_mobile"]; ?></td>
													<td><?php echo $user_array[$key]["user_gender"]; ?></td>
													<td><?php echo $user_array[$key]["user_dob"]; ?></td>
													<td>
														<div class="onoffswitch">
															<input type="checkbox" class="onoffswitch-checkbox" id="verified_<?php echo $user_array[$key]["user_sno"]; ?>" onClick="javascript:changeToVerified('<?php echo stripslashes($user_array[$key]["user_sno"]); ?>');" <?php if ($user_array[$key]["user_verified"] == 'YES')
																																																																				{ ?> checked <?php } ?>>
															<label class="onoffswitch-label" for="verified_<?php echo $user_array[$key]["user_sno"]; ?>">
																<span class="onoffswitch-inner"></span>
																<span class="onoffswitch-switch"></span>
															</label>
														</div>
													</td>
													<td>
														<a class="btn btn-outline-success" href="update_user?user_sno=<?php echo base64_encode($user_array[$key]["user_sno"]); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Update"><span class="fas fa-pencil-alt"></span></a>
														<a class="btn btn-outline-danger" href="javascript:deleteFromUser('<?php echo stripslashes($user_array[$key]["user_sno"]); ?>');" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><span class="fas fa-trash-alt"></span></a>
													</td>
												</tr>
										<?php }
										} ?>
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
	</script>

</body>

</html>