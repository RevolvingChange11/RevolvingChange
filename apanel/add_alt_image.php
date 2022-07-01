<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "product_alt_image";
	$ctable1 	= "Product Alternate Images";
	$page 		= "alt-image";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$IMAGEPATH_T = PRODUCT_T;
	$IMAGEPATH_A = PRODUCT_A;
	$IMAGEPATH = PRODUCT;

	$image_path = '';

	$product_id = 0;
	if(isset($_REQUEST['product_id']) && $_REQUEST['product_id']!=""){
		$product_id = $_REQUEST['product_id'];
	}

	if(isset($_REQUEST['submit']))
	{
		$image_path = $db->clean($_REQUEST['image_path']);

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
			"product_id" => $product_id,
			"image_path" => $image_path,
		);				

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$image_id = $db->insert($ctable, $rows);

			$_SESSION['MSG'] = "Inserted";
			$db->location(ADMINURL.'manage-'.$page.'/'.$product_id.'/');
			exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$image_id = $_REQUEST['id'];		
			$db->update($ctable, $rows, "id=".$image_id);

			$_SESSION['MSG'] = "Updated";
			$db->location(ADMINURL.'manage-'.$page.'/'.$product_id.'/');
			exit;
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
	{
		$where 		= " id=".$_REQUEST['id']." AND isDelete=0";
		$ctable_r 	= $db->getData($ctable, "*", $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$product_id = stripslashes($ctable_d['product_id']);
		$image_path	= stripslashes($ctable_d['image_path']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id 	= $_REQUEST['id'];
		$rows 	= array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
		
		$_SESSION['MSG'] = "Deleted";
		$db->location(ADMINURL.'manage-'.$page.'/'.$product_id.'/');
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
									<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="image_path">Image <code>*</code>
														<br />
														<small>minimum image size 454 x 527 px</small>
													</label>
													
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="454" data-height="527" data-ghost="false" data-cropwidth="454" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prod_alt_img" style="width: 454px;height:527px;">
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
											<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'.$product_id.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
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

	<script type="text/javascript">
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
					image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }, 
				},
				messages: {
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
