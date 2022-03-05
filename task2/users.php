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
		<?php
		if (isset($_REQUEST["keyword"]))
		{
			$keyword  = $_REQUEST["keyword"];
		}
		else
		{
			$keyword = "";
		};
		if (isset($_REQUEST["page_number"]))
		{
			$page_number  = $_REQUEST["page_number"];
		}
		else
		{
			$page_number = 1;
		};
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="table-wrapper">
								<div class="table-title mb-2">
									<div class="row">
										<div class="col-sm-6">
											<h2>Manage <b>Employee</b></h2>
										</div>
										<div class="col-sm-6">
											<form method="GET" action="">
												<input type="hidden" name="page_number" id="page_number" value="<?php echo $page_number; ?>" />
												<div class="input-group col-md-4 float-right">
													<input type="text" class="form-control" placeholder="Search here..." name="keyword" value="<?php echo $keyword; ?>" />
													<span class="input-group-btn">
														<button class="btn btn-primary" id="user_search" name="user_search" style="height: 100%;">
															<i class="fa fa-search" aria-hidden="true"></i>
														</button>
													</span>
												</div>
											</form>
										</div>
									</div>
								</div>
								<table class="table table-striped table-bordered display nowrap" id="domain-table" width="100%">
									<thead>
										<tr>
											<th>S. No</th>
											<th>Employee Name</th>
											<th>Employee Email</th>
											<th>Employee Mobile</th>
											<th>Designation</th>
											<th>Employee DOJ</th>
											<th>Identity</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$employee_limit = 3;
										$start_from = ($page_number - 1) * $employee_limit;
										$count = $start_from;
										$employee_array = $systemTask->getAllEmployee($start_from, $employee_limit, $keyword);
										if (!empty($employee_array))
										{
											foreach ($employee_array as $key => $value)
											{
										?>
												<tr id="user_row_<?php echo $employee_array[$key]["employee_sno"]; ?>">
													<td><?php echo ++$count; ?></td>
													<td><?php echo $employee_array[$key]["employee_name"]; ?></td>
													<td><?php echo $employee_array[$key]["employee_email"]; ?></td>
													<td><?php echo $employee_array[$key]["employee_mobile"]; ?></td>
													<td><?php echo $employee_array[$key]["employee_designation"]; ?></td>
													<td><?php echo $employee_array[$key]["employee_doj"]; ?></td>
													<td>
														<a class="image-popup-no-margins" href="<?php echo $employee_array[$key]["employee_identify"]; ?>"><img src="<?php echo $employee_array[$key]["employee_identify"]; ?>" onerror="this.onerror=null; this.parentNode.href=this.src='images/logo/user.png'" width=" 35" height="35" style="margin: -12px 0px -12px 0px;"></a>
													</td>
												</tr>
										<?php }
										} ?>
									</tbody>
								</table>
								<?php
								if (!empty($employee_array))
								{
									for ($page_number = 1; $page_number <= ceil($employee_array[0]["employee_count"] / $employee_limit); $page_number++)
									{
										echo '<a href = "users.php?' . 'keyword=' . $keyword . '&page_number=' . $page_number . '">' . $page_number . ' </a>';
									}
								}
								?>
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
		/*
				function load_data() {
					$.ajax({
						url: "include/user/get_user.php",
						method: "GET",
						data: {
							keyword: $("#keyword").val(),
							page_number: $("#page_number").val()
						},
						beforeSend: function() {
							$('#result').html('<div style="text-align:center;"><img src="images/loader/bolt.gif" style="max-width:100%;"/></div>');
						},
						success: function(data) {
							$('#result').html(data);
						}
					});
				}
		*/
		$("#user_search").click(function() {
			$("#page_number").val(1);
		});
	</script>

</body>

</html>