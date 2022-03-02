<!-- Jquery js--->
<script type="text/javascript" src="assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script type="text/javascript" src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>

<!--widges js--->
<script type="text/javascript" src="assets/libs/toastr/build/toastr.min.js"></script>
<script type="text/javascript" src="assets/libs/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="assets/libs/pagination/dist/pagination.js"></script>

<!-- image js -->
<script type="text/javascript" src="assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/libs/magnific-popup/meg.init.js"></script>

<!--my js--->
<script type="text/javascript" src="assets/libs/jquery/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/libs/jquery/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="assets/js/custom.min.js"></script>

<script type="text/javascript">
	$("#logout_button").click(function() {
		swal({
			title: "Are you sure?",
			text: "You want to logout from this website!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: 'include/user/logout_user.php',
					success: function() {
						location.reload();
					}
				})
			}
		});
	});
</script>