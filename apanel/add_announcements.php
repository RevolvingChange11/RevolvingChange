<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "announcements";
	$ctable1 	= "Announcements";
	$page 		= "announcements";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	
	$name = '';
	$course_id = '';
	$long_desc = '';
	//$isPublished = '';

	if(isset($_REQUEST['submit']))
	{
		
		$title = $db->clean($_REQUEST['title']);
		$course_id = $db->clean($_REQUEST['course_id']);
		//$isPublished = (int) $_REQUEST['isPublished'];
		$long_desc = $db->clean($_REQUEST['longDesc']);


		$rows 	= array(
			"title" => $title,
			"course_id" => $course_id,
			"des" => $long_desc,
		);			

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			
				$module_id = $db->insert($ctable, $rows);

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$module_id = $_REQUEST['id'];
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $module_id . " AND slug = '".$slug."' AND isDelete=0");
			
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$module_id);

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

		$title   = stripslashes($ctable_d['title']);
		$course_id   = stripslashes($ctable_d['course_id']);
		$long_desc	= stripslashes($ctable_d['des']);
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

									<div class="card-body row">
										<div class="col-md-10">	
											<div class="form-group">
												<label for="title"> Title <code>*</code></label>
												<input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" maxlength="200">
											</div>
										</div>
										
										<div class="col-md-6">	
											<div class="form-group">
												<label for="course_id"> Course <code>*</code></label>
												<select name="course_id" id="course_id" class="form-control">
													<option value="">Select Course</option>
													<?php 
														$rs_c = $db->getData('course', 'id, name', 'isDelete=0 AND isPublish=1', 'name');
														while( $row_c = @mysqli_fetch_assoc($rs_c) )
														{
															echo '<option value="'.$row_c['id'].'"';
															if( $course_id == $row_c['id'] )
																echo ' selected';
															echo '>'.$row_c['name'].'</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">	
										</div>
										<div class="col-md-12">	
											<div class="form-group">
												<label for="description"> Long Description <code>*</code></label>
												<textarea name="longDesc" id="longDesc" class="form-control"><?php echo $long_desc; ?></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<div class="box-footer">
												<button type="submit" name="submit" id="submit" class="btn btn-success" title="Submit"><i class="fa fa-save"></i></button>
												<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
											</div>
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
		CKEDITOR.replace('longDesc');

		var custom_img_width = '200';
		
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
					title:{required:true}, 
					course_id:{required:true},
					longDesc:{required:function() { CKEDITOR.instances.longDesc.updateElement(); }},
					//isPublished:{required:true},
					
				},
				messages: {
					name:{required:"Please enter title."}, 
					course_id:{required:"Please select course."},
					longDesc:{required:"Please enter containt."},
					//isPublished:{required:"Please enter date of publish."},
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
