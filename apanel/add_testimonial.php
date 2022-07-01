<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "testimonial";
	$ctable1 	= "Testimonial";
	$page 		= "testimonial";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = "";
	$designation = "";
	$description = "";
	$image_path = "";
	$IMAGEPATH_T = TML_T;
	$IMAGEPATH_A= TML_A;
	$IMAGEPATH= TML;
	if(isset($_REQUEST['submit']))
	{
		$name 		 = $db->clean($_REQUEST['name']);
		$designation = $db->clean($_REQUEST['designation']);
		$description = $db->clean($_REQUEST['description']);
		$image_path  = $_REQUEST['image_path'];


		if( empty($name) || empty($designation) || empty($description) )
		{
			$db->location(ADMINURL."add-".$page."/add/");
			exit;
		}

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
			"name" 			=> $name,
			"designation" 	=> $designation,
			"description" 	=> $description,
			"image" 		=> $image_path,
		);				
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$check_user_r = $db->getData($ctable, "*", "name = '".$name."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/");
				exit;
			}
			else
			{
				$contact_id = $db->insert($ctable, $rows);

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$contact_id = $_REQUEST['id'];
			$check_user_r = $db->getData($ctable, "*", "id <> " . $contact_id . " AND name = '".$name."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$contact_id);

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

		$name 		 = stripslashes($ctable_d['name']);
		$designation = stripslashes($ctable_d['designation']);
		$description = stripslashes($ctable_d['description']);
		$image_path  = htmlspecialchars_decode($ctable_d['image']);
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
													<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" maxlength="75">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="designation"> Designation <code>*</code></label>
													<input type="text" class="form-control" name="designation" id="designation" value="<?php echo $designation; ?>" >
												</div>
											</div>
										</div>
										<div class="row">
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
													<label for="image_path">Image <code>*</code>
														<br />
														<small>minimum image size 100 x 100 px</small>
													</label>
													<br />
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="100" data-height="100" data-ghost="false" data-cropwidth="100" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=testimonial" style="width: 200px;height:200px;">
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
														<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" width="200"><br /><br />
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
		var custom_img_width = '100';
		
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
					designation:{required:true}, 
					//message:{required : function() { CKEDITOR.instances.message.updateElement(); } },
					description:{required:true},
					image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }
				},
				messages: {
					name:{required:"Please enter name."},
					designation:{required:"Please enter designation."},
					description:{required:"Please enter description."},
					image_path:{required:"Please upload image."},
					//message:{required:"Please enter message."}, 
				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "message") 
					{
						error.insertAfter(".desc_error");
					}
					else
					{
						error.insertAfter(element);
					}
				}
			});
		});
	</script>
</body>

</html>
