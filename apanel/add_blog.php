<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "blog";
	$ctable1 	= "Blog";
	$page 		= "blog";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$IMAGEPATH_T = BLOG_T;
	$IMAGEPATH_A = BLOG_A;
	$IMAGEPATH = BLOG;

	$blog='';
	$blog_category='';
	$image_path = '';
	$blog_title='';
	
	if(isset($_REQUEST['submit']))
	{
		$blog_category 		= $db->clean($_REQUEST['blog_category']);
		$blog_title 		= $db->clean($_REQUEST['blog_title']);
		$blog 				= $db->clean($_REQUEST['blog']);
		$image_path 		= $_REQUEST['image_path'];
		
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
			"blog" 				=> $blog,
			"blog_img" 			=> $image_path,
			"blog_title"        => $blog_title,
			"category_id"		=> $blog_category,
		);			
		
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$course_id = $db->insert($ctable, $rows);

			$_SESSION['MSG'] = "Inserted";
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;

		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$blog_id = $_REQUEST['id'];
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $blog_id . " AND isDelete=0");
			
			
				$db->update($ctable, $rows, "id=".$blog_id);

				$_SESSION['MSG'] = "Updated";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
	{
		$where 		= " id=".$_REQUEST['id']." AND isdelete=0";
		$ctable_r 	= $db->getData($ctable, "*", $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);
		$blog_title	= stripslashes($ctable_d['blog_title']);
		$blog	= stripslashes($ctable_d['blog']);
		$image_path	= stripslashes($ctable_d['blog_img']);
		$blog_category	= stripslashes($ctable_d['category_id']);

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

										<div class="col-md-12">
											<div class="form-group">
												<label for="blog"> Article Category <code>*</code></label>
												<select class="form-control" name="blog_category" id="blog_category">
													<option value="">Select Category</option>
													<?php 
													$str='';
														$ctable_res=$db->getData("blog_category","*","isdelete=0");
														while($ctable_row=mysqli_fetch_assoc($ctable_res))
														{
															$str .= '<option value="';
															$str .= $ctable_row['id'].'"';
															if($ctable_row['id']==$blog_category)
															{
																$str.='selected=selected';
															}
															$str.= '>';
															$str .= $ctable_row['title'];
															$str.='</option>';
															
														} 
														echo $str;
													?>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="blog title"> Article Title <code>*</code></label>
												<input type="text"class="form-control" name="blog_title" id="blog_title" value="<?php echo $blog_title; ?>">
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label for="blog"> Article <code>*</code></label>
												<textarea name="blog" id="blog" class="form-control"><?php echo $blog; ?></textarea>
											</div>
										</div>
										
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="image_path">Image <code>*</code>
															<br />
															<small>minimum image size 823 x 500 px</small>
														</label>
														<br />
														<input type="hidden" name="filename" id="filename" class="form-control" />
														<div id="dropzone_img" class="dropzone" data-width="823" data-height="500" data-ghost="false" data-cropwidth="823" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=blogimg" style="width: 823px;height:500px;">
															<input type="file" id="image_path" name="image_path" >
															<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<br /><br />
														<?php
														
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" width="823"><br /><br />
														<?php
														}
														?>
													</div>
												</div>
											</div>
										</div>

										
																
										<div class="col-md-6">
											<div class="box-footer">
												<button type="submit" name="submit" id="submit" class="btn btn-success" title="Submit"><i class="fa fa-save"></i></button>
												<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
											</div>
										</div>
										<!-- </div> -->
									
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
		CKEDITOR.replace('blog');

		var custom_img_width = '823';
		
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
					blog_category:{required : true},
					blog_title:{required : true},
					blog:{required:function() { CKEDITOR.instances.blog.updateElement(); }},
				    image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }
				},
				messages: {
					blog_title:{required:"Please add title for article"},
					blog_category:{required:"Please select category"},
					blog:{required:"Please enter article."},
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
