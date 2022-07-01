<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "product";
	$ctable1 	= "Product";
	$page 		= "product";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$IMAGEPATH_T = PRODUCT_T;
	$IMAGEPATH_A = PRODUCT_A;
	$IMAGEPATH = PRODUCT;

	$name = '';
	$slug = '';
	$SKU = '';
	$price = '';
	$height = '';
	$width = '';
	$length = '';
	$weight = '';
	$fabric = '';
	$description = '';
	$additional_info = '';
	$image_path = '';
	$category_id = array();

	if(isset($_REQUEST['submit']))
	{
		$name = $db->clean($_REQUEST['name']);
		$slug = $db->createSlug($_REQUEST['name']);
		$SKU = $db->clean($_REQUEST['SKU']);
		$price = (float) $db->clean($_REQUEST['price']);
		$height = (float) $db->clean($_REQUEST['height']);
		$width = (float) $db->clean($_REQUEST['width']);
		$length = (float) $db->clean($_REQUEST['length']);
		$weight = (float) $db->clean($_REQUEST['weight']);
		$fabric = $db->clean($_REQUEST['fabric']);
		$description = $db->clean($_REQUEST['description']);
		$additional_info = $db->clean($_REQUEST['additional_info']);
		$image_path = $db->clean($_REQUEST['image_path']);
		$category_id = $_REQUEST['category_id'];

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
		{
			copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
			$image_path = $_SESSION['image_path'];
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
			unset($_SESSION['image_path']);
		}
		if($_REQUEST['old_image_path']!="" && $image_path!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_image_path']);
			}
		}else{
			if($image_path==""){
				$image_path = $_REQUEST['old_image_path'];
			}
		}

		$rows 	= array(
			"name" => $name,
			"slug" => $slug,
			"SKU" => $SKU,
			"price" => $price,
			"height" => $height,
			"width" => $width,
			"length" => $length,
			"weight" => $weight,
			"fabric" => $fabric,
			"description" => $description,
			"additional_info" => $additional_info,
			"image_path" => $image_path,
		);				

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$check_user_r = $db->getData($ctable, "*", "slug = '".$slug."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/");
				exit;
			}
			else
			{
				$product_id = $db->insert($ctable, $rows);

				if( $product_id )
				{
					// add categories
					$n = count($category_id);
					$db->delete('product_category', 'product_id='. (int) $product_id);
					for( $i=0; $i<$n; $i++ )
					{
						$rows = array(
							'product_id' => $product_id, 
							'category_id' => $category_id[$i], 
						);
						$db->insert('product_category', $rows);
					}
				}

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$product_id = $_REQUEST['id'];
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $product_id . " AND slug = '".$slug."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$product_id);

				// add categories
				$n = count($category_id);
				$db->delete('product_category', 'product_id='. (int) $product_id);
				for( $i=0; $i<$n; $i++ )
				{
					$rows = array(
						'product_id' => $product_id, 
						'category_id' => $category_id[$i], 
					);
					$db->insert('product_category', $rows);
				}

				$_SESSION['MSG'] = "Updated";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
	{
		$where 		= " id=".$_REQUEST['id']." AND isDelete=0";
		$ctable_r 	= $db->getData($ctable, "*", $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$name   = stripslashes($ctable_d['name']);
		$slug	= stripslashes($ctable_d['slug']);
		$SKU   = stripslashes($ctable_d['SKU']);
		$price   = stripslashes($ctable_d['price']);
		$height   = stripslashes($ctable_d['height']);
		$width   = stripslashes($ctable_d['width']);
		$length   = stripslashes($ctable_d['length']);
		$weight   = stripslashes($ctable_d['weight']);
		$fabric   = stripslashes($ctable_d['fabric']);
		$description   = stripslashes($ctable_d['description']);
		$additional_info   = stripslashes($ctable_d['additional_info']);
		$image_path	= stripslashes($ctable_d['image_path']);

		$rs_cat = $db->getData('product_category', 'category_id', 'product_id='. $_REQUEST['id'] . ' AND isDelete=0');
		while($row_cat = @mysqli_fetch_assoc($rs_cat) )
		{
			array_push($category_id, $row_cat['category_id']);
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id 	= $_REQUEST['id'];
		$rows 	= array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
		
		$_SESSION['MSG'] = "Deleted";
		$db->location(ADMINURL.'manage-'.$page.'/');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title . ' | ' .  ADMINTITLE; ?></title>
	<?php include("include/css.php"); ?>
	<link href="<?php echo ADMINURL; ?>assets/crop/css/demo.html5imageupload.css?v1.3" rel="stylesheet">
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<?php include("include/left.php"); ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php include('include/header.php'); ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h4 mb-0 text-gray-900"><?php echo $page_title; ?></h1>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4  border-left-info">
								<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
									<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Name <code>*</code></label>
													<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" maxlength="200">
												</div>
												<div class="form-group">
													<label for="SKU"> SKU <code>*</code></label>
													<input type="text" class="form-control" name="SKU" id="SKU" value="<?php echo $SKU; ?>" maxlength="100">
												</div>
												<div class="form-group">
													<label for="price"> Price (<?php echo CURR; ?>) <code>*</code></label>
													<input type="text" class="form-control" name="price" id="price" value="<?php echo $price; ?>" maxlength="10">
												</div>
												<div class="form-group">
													<label for="price"> Category <code>*</code></label>
													<select name="category_id[]" id="category_id" multiple="multiple" size="5" class="form-control">
													<?php
														$rs_cat = $db->getData('category', 'id, name', 'isDelete=0', 'name');
														while($row_cat = @mysqli_fetch_assoc($rs_cat) )
														{
															echo '<option value="' . $row_cat['id'] . '"';
															if( in_array($row_cat['id'], $category_id) )
																echo ' selected';
															echo '>' . $row_cat['name'] . '</option>';
														}
													?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="description"> Description <code>*</code></label>
													<textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="fabric"> Fabric <!-- <code>*</code> --></label>
													<textarea name="fabric" id="fabric" class="form-control"><?php echo $fabric; ?></textarea>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="additional_info"> Sizing Chart </label>
													<textarea name="additional_info" id="additional_info" class="form-control"><?php echo $additional_info; ?></textarea>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="height"> Height (cm) <code>*</code></label>
													<input type="text" class="form-control" name="height" id="height" value="<?php echo $height; ?>" maxlength="8">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="width"> Width (cm) <code>*</code></label>
													<input type="text" class="form-control" name="width" id="width" value="<?php echo $width; ?>" maxlength="8">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="length"> Length (cm) <code>*</code></label>
													<input type="text" class="form-control" name="length" id="length" value="<?php echo $length; ?>" maxlength="8">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="weight"> Weight (kg) <code>*</code></label>
													<input type="text" class="form-control" name="weight" id="weight" value="<?php echo $weight; ?>" maxlength="8">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="image_path">Image <code>*</code>
														<br />
														<small>minimum image size 454 x 527 px</small>
													</label>
													
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="454" data-height="527" data-ghost="false" data-cropwidth="454" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prodimg" style="width: 454px;height:527px;">
														<input type="file" id="image_path" name="image_path">
														<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<br /><br />
													<?php
													if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
													?>
														<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" width="454"><br /><br />
													<?php
													}
													?>
												</div>
											</div>
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" id="submit" class="btn btn-success" title="Submit"><i class="fa fa-save"></i></button>
											<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php include("include/footer.php"); ?>

			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->
	</div>
	<!-- End of Page Wrapper -->

	<!-- Bootstrap core JavaScript-->
	<?php include("include/js.php"); ?>
	<script src="<?php echo ADMINURL; ?>assets/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
	<script src="<?php echo ADMINURL; ?>js/ckeditor/ckeditor.js" type="text/javascript"></script>

	<script type="text/javascript">
		CKEDITOR.replace('description');
		CKEDITOR.replace('features');
		CKEDITOR.replace('fabric');
		CKEDITOR.replace('additional_info');

		var custom_img_width = '454';
		
		$('#dropzone_img').html5imageupload({
			onAfterProcessImage: function() {
				var imgName = $('#filename').val($(this.element).data('imageFileName'));
			},
			onAfterCancel: function() {
				$('#filename').val('');
			}
		});

		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					name:{required:true}, 
					SKU:{required:true}, 
					price:{required:true}, 
					//fabric:{required:function() { CKEDITOR.instances.fabric.updateElement(); }}, 
					description:{required:function() { CKEDITOR.instances.description.updateElement(); }}, 
					height:{required:true, min:1},
					width:{required:true, min:1},
					length:{required:true, min:1},
					weight:{required:true, min:0.1},
					image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }, 
				},
				messages: {
					name:{required:"Please enter name."}, 
					SKU:{required:"Please enter SKU."}, 
					price:{required:"Please enter price."}, 
					//fabric:{required:"Please enter fabric details."}, 
					description:{required:"Please enter description."}, 
					height:{required:"Please enter height.", min:"Height must be greater than or equal to 1."}, 
					width:{required:"Please enter width.", min:"Width must be greater than or equal to 1."}, 
					length:{required:"Please enter length.", min:"Length must be greater than or equal to 1."}, 
					weight:{required:"Please enter weight.", min:"Weight must be greater than 0 (zero)."}, 
					image_path:{required:"Please upload image."}, 
				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "filename") 
						error.insertAfter("#dropzone_img");
					else
						error.insertAfter(element);
				}
			});
		});
	</script>
</body>

</html>
