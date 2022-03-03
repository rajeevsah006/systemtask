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

		<div class="page-wrapper">

			<!------------------------------- product start --------------------------------------->
			<div class="container-fluid">
				<div class="row">
					<?php
					$product_array = $shiatoshiAdmin->getProductByProductId(base64_decode($_REQUEST["product_id"]));
					if (!empty($product_array))
					{
					?>
						<div class="col-md-12">
							<div class="card">
								<form class="form-horizontal" id="update-product" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="product_title">Product Title</label>
													<input name="product_title" id="product_title" type="text" class="form-control" value="<?php echo $product_array[0]["product_title"]; ?>" placeholder="Product Title">
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="product_price">Product Price</label>
													<input name="product_price" id="product_price" type="text" class="form-control" value="<?php echo $product_array[0]["product_price"]; ?>" placeholder="Product Price">
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="size_id">Product Size</label>
													<select class="form-control select2" name="size_id" id="size_id">
														<option value disabled selected>Select Size</option>
														<?php
														$size_array = $shiatoshiAdmin->getAllSize();
														if (!empty($size_array))
														{
															foreach ($size_array as $size)
															{
														?>
																<option value="<?php echo $size["size_id"]; ?>" <?php if ($product_array[0]["size_id"] == $size["size_id"])
																												{ ?> selected="selected" <?php } ?>><?php echo $size["product_size"]; ?></option>
														<?php }
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="free_shipping">Chosse Free Shipping</label>
													<select class="form-control select2" name="free_shipping" id="free_shipping">
														<option value disabled selected>Choose Free Shipping</option>
														<option value="YES" <?php if ($product_array[0]["free_shipping"] == "YES")
																			{ ?> selected="selected" <?php } ?>>YES</option>
														<option value="NO" <?php if ($product_array[0]["free_shipping"] == "NO")
																			{ ?> selected="selected" <?php } ?>>NO</option>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="category_name">Category Name</label>
													<select class="form-control select2" name="category_name" id="category_name">
														<option value disabled selected>Select Category</option>
														<?php
														$category_array = $shiatoshiAdmin->getAllCategory();
														if (!empty($category_array))
														{
															foreach ($category_array as $category)
															{
														?>
																<option value="<?php echo $category["category_name"]; ?>" <?php if ($product_array[0]["category_name"] == $category["category_name"])
																															{ ?> selected="selected" <?php } ?>><?php echo $category["category_name"]; ?></option>
														<?php }
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="sub_category">Sub Category</label>
													<select class="form-control select2" name="sub_category" id="sub_category">
														<option value disabled selected>Select Sub Category</option>
														<?php
														$sub_array = $shiatoshiAdmin->getSubByCategory($product_array[0]["category_name"]);
														if (!empty($sub_array))
														{
															foreach ($sub_array as $sub)
															{
																if ($sub["sub_category"] != '')
																{
														?>
																	<option value="<?php echo $sub["sub_category"]; ?>" <?php if ($product_array[0]["sub_category"] == $sub["sub_category"])
																														{ ?> selected="selected" <?php } ?>><?php echo $sub["sub_category"]; ?></option>
																<?php }
																else
																{ ?>
																	<option value="nothing" selected="selected">No Sub Category</option>
														<?php }
															}
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="item_name">Item Name</label>
													<select class="form-control select2" name="item_name" id="item_name">
														<option value disabled selected>Select Item</option>
														<?php
														$item_array = $shiatoshiAdmin->getItemByCategory($product_array[0]["category_name"], $product_array[0]["sub_category"]);
														if (!empty($item_array))
														{
															foreach ($item_array as $item)
															{
														?>
																<option value="<?php echo $item["item_name"]; ?>" <?php if ($product_array[0]["item_name"] == $item["item_name"])
																													{ ?> selected="selected" <?php } ?>><?php echo $item["item_name"]; ?></option>
														<?php }
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="type_id">Product Type</label>
													<select name="type_id[]" id="type_id" class="form-control select2" multiple="multiple">
														<?php
														$type_array = $shiatoshiAdmin->getAllType();
														if (!empty($type_array))
														{
															foreach ($type_array as $type)
															{
														?>
																<option value="<?php echo $type["type_id"]; ?>" <?php if (in_array($type["type_id"], explode(',', $product_array[0]["type_id"])))
																												{ ?> selected="selected" <?php } ?>><?php echo $type["product_type"]; ?></option>
														<?php }
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="tag_id">Product Tag</label>
													<select class="form-control select2" name="tag_id" id="tag_id">
														<option value disabled selected>Select Tag</option>
														<?php
														$tag_array = $shiatoshiAdmin->getAllTag();
														if (!empty($tag_array))
														{
															foreach ($tag_array as $tag)
															{
														?>
																<option value="<?php echo $tag["tag_id"]; ?>" <?php if ($product_array[0]["tag_id"] == $tag["tag_id"])
																												{ ?> selected="selected" <?php } ?>><?php echo $tag["product_tag"]; ?></option>
														<?php }
														} ?>
													</select>
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="product_stock">Product Stock</label>
													<input name="product_stock" id="product_stock" type="text" class="form-control" value="<?php echo $product_array[0]["product_stock"]; ?>" placeholder="Product Stock">
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="product_rating">Product Rating</label>
													<input name="product_rating" id="product_rating" type="text" class="form-control" value="<?php echo number_format($product_array[0]["product_rating"], 1, '.', ''); ?>" placeholder="Product Rating">
													<div class="invalid-feedback"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="product_description">Product Description</label>
													<input name="product_description" id="product_description" type="hidden" class="form-control">
													<div id="editor1" style="height: 500px;"><?php echo $product_array[0]["product_description"]; ?></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Product Image</label>
													<div class="custom-file">
														<input name="image_select" id="image_select" type="file" accept="image/*" class="form-control custom-file-input" multiple>
														<label class="custom-file-label" for="image_select">Choose file...</label>
														<div class="invalid-feedback"></div>
													</div>
												</div>
											</div>
										</div>
										<div class="row el-element-overlay" id="preview_image">
											<?php
											$count = 0;
											$image_array = explode(',', $product_array[0]["product_image"]);
											foreach ($image_array as $product_image)
											{
											?>
												<div class="col-md-3" id="file_row_<?php echo ++$count; ?>">
													<div class="card" style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 20px;">
														<div class="el-card-item" style="margin-bottom: 0px;padding-bottom: 0px;">
															<div class="el-card-avatar el-overlay-1"> <img src="<?php echo (file_exists("../images/product/" . $product_image) ? "../images/product/" . $product_image : "images/logo/product-placeholder.jpg"); ?>" alt="undefined" />
															</div>
															<a class="upper_right remove-file" targetDiv="file_row_<?php echo $count; ?>"><img src="images/logo/close.png" alt="undefined" style="width:25px;height:25px;" /></a>
														</div>
													</div>
													<input name="uploaded_image[]" id="uploaded_image_<?php echo $count; ?>" type="hidden" value="<?php echo $product_image; ?>">
												</div>
											<?php } ?>
										</div>
									</div>
									<input name="uploaded_image[]" id="uploaded_image_<?php echo $count + 1; ?>" type="hidden" value="">
									<input name="product_id" id="product_id" type="hidden" value="<?php echo base64_decode($_REQUEST["product_id"]); ?>">
									<div class="border-top">
										<div class="card-body">
											<div class="form-group">
												<button name="update_button" id="update_button" type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp; Update Product</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php }
					else
					{ ?>
						<div class="col-md-12">
							<div class="card"><br /><br />
								<div class="empty-result" id="empty_result" style="text-align:center;">
									<img src="images/logo/empty_area.png" style="max-width:100%;" />
									<h2 style="font-weight: 900;">Sad No Product!</h2>
									<br />
									<p style="font-family: Montserrat;color: gray;">We cannot find the item you are searching for, something wrong !!</p>
									<br />
								</div><br /><br />
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<!------------------------------- product end ----------------------------------------->

			<!------------------------------- footer start ---------------------------------------->
			<?php include 'include/common/footer.php'; ?>
			<!------------------------------- footer end ------------------------------------------>

		</div>
	</div>

	<!------------------------------- bottom_link start ----------------------------------->
	<?php include 'include/common/bottom_link.php'; ?>
	<!------------------------------- bottom_link end ------------------------------------->


	<script type="text/javascript" src="assets/js/product.js"></script>

	<script type="text/javascript">
		var toolbarOptions = [
			['bold', 'italic', 'underline', 'strike'],
			[{
				'list': 'ordered'
			}, {
				'list': 'bullet'
			}],
			[{
				'script': 'sub'
			}, {
				'script': 'super'
			}],
			[{
				'indent': '-1'
			}, {
				'indent': '+1'
			}],
			[{
				'direction': 'rtl'
			}],
			[{
				'header': [1, 2, 3, 4, 5, 6, false]
			}],
			[{
				'color': []
			}, {
				'background': []
			}],
			[{
				'font': []
			}],
			[{
				'align': []
			}],
			['link', 'image'],
			['clean']
		];
		var editor1 = new Quill('#editor1', {
			modules: {
				imageResize: true,
				imageDrop: true,
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});

		var filesToUpload = [];
		var fileIdCounter1 = <?php echo $count; ?>;
		var fileIdCounter2 = <?php echo $count; ?>;

		$("#image_select").change(function() {
			showimagepreview(this);
		});

		function showimagepreview(input) {
			if (input.files) {
				var filesAmount = input.files.length;
				for (i = 0; i < filesAmount; i++) {
					var filerdr = new FileReader();
					fileIdCounter2++;
					filerdr.onload = function(e) {
						var img = new Image();
						img.onload = function() {
							fileIdCounter1++;
							var canvas = document.createElement('canvas');
							var ctx = canvas.getContext('2d');
							var width = 560;
							var height = 560;
							canvas.width = width;
							canvas.height = height;
							ctx.drawImage(img, 0, 0, width, height);
							var data = canvas.toDataURL('image/png');
							var html = '<div class="col-md-3" id="file_row_' + fileIdCounter1 + '">' +
								'<div class="card" style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 20px;">' +
								'<div class="el-card-item"  style="margin-bottom: 0px;padding-bottom: 0px;">' +
								'<div class="el-card-avatar el-overlay-1"> <img src="' + data + '" alt="undefined" />' +
								'</div>' +
								'<a class="upper_right remove-file" targetDiv="file_row_' + fileIdCounter1 + '" ><img src="images/logo/close.png" alt="undefined" style="width:25px;height:25px;" /></a>' +
								'</div>' +
								'</div>' +
								'</div>';
							$("#preview_image").append(html);
						}
						img.src = e.target.result;
					}
					filesToUpload.push({
						id: 'file_row_' + fileIdCounter2,
						file: input.files[i]
					});
					filerdr.readAsDataURL(input.files[i]);
				}
				input.value = null;
			}
		}

		$(document).on("click", ".remove-file", function(e) {
			var targetDiv = jQuery(this).attr('targetDiv');
			for (var i = 0; i < filesToUpload.length; ++i) {
				if (filesToUpload[i].id === targetDiv)
					filesToUpload.splice(i, 1);
			}
			var targetDiv = jQuery(this).attr('targetDiv');
			jQuery('#' + targetDiv).remove();
		});

		$('#category_name').on('change.select2', function() {
			$.ajax({
				type: "POST",
				url: "include/fetch/get_sub_category.php",
				data: {
					category_name: $('#category_name').find(":selected").val()
				},
				success: function(data) {
					$("#sub_category").html(data);
					$("#sub_category").trigger('change.select2');
				}
			});
		});

		$('#sub_category').on('change.select2', function() {
			$.ajax({
				type: "POST",
				url: "include/fetch/get_item.php",
				data: {
					category_name: $('#category_name').find(":selected").val(),
					sub_category: $('#sub_category').find(":selected").val()
				},
				success: function(data) {
					$("#item_name").html(data);
				}
			});
		});

		$("#size_id").select2({
			minimumResultsForSearch: -1,
			placeholder: "Select Size"
		});

		$("#free_shipping").select2({
			minimumResultsForSearch: -1,
			placeholder: "Chooose Free Shipping"
		});

		$("#category_name").select2({
			minimumResultsForSearch: -1,
			placeholder: "Select Category"
		});

		$("#sub_category").select2({
			minimumResultsForSearch: -1,
			placeholder: "Select Sub Category"
		});

		$("#item_name").select2({
			minimumResultsForSearch: -1,
			placeholder: "Select Item"
		});

		$("#type_id").select2({
			placeholder: "Select Product Type"
		});

		$("#tag_id").select2({
			minimumResultsForSearch: -1,
			allowClear: true,
			placeholder: "Select Tag"
		});
	</script>

</body>

</html>