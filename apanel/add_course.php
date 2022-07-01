<?php
	include("connect.php");
	include("../include/notification.class.php");
	$db->checkAdminLogin();

	$ctable 	= "course";
	$ctable1 	= "Course";
	$page 		= "course";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$IMAGEPATH_T = COURSE_T;
	$IMAGEPATH_A = COURSE_A;
	$IMAGEPATH = COURSE;

	$name 			= '';
	$short_description = '';
	$price 			= '';
	$long_description = '';
	$publish_date 	= '';
	$image_path 	= '';
	$isPublish  	= '';

	if(isset($_REQUEST['submit']))
	{
		$name 				= $db->clean($_REQUEST['name']);
		$slug 				= $db->createSlug($_REQUEST['name']);
		$short_description 	= $db->clean($_REQUEST['shortDesc']);
		$price 				= (float) $db->clean($_REQUEST['price']);
		$publish_date 		= date("Y-m-d");
		$long_description 	= $db->clean($_REQUEST['longDesc']);
		$image_path 		= $_REQUEST['image_path'];

		$isPublish 			= $_REQUEST['isPublished'];
		if ( empty($isPublish) && $isPublish=="" ) 
			$isPublish =0;


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
			"slug" 			=> $slug,
			"short_description" => $short_description,
			"price" 		=> $price,
			"publish_date" 	=> $publish_date,
			"long_description" => $long_description,
			"image" 		=> $image_path,
			"isPublish"		=> $isPublish
		);			

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$check_user_r = $db->getData($ctable, "*", "slug = '".$slug."' AND isDelete=0");
			//echo $check_user_r;
			//die();
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/");
				exit;
			}
			else
			{
				$course_id = $db->insert($ctable, $rows);
				if(!empty($course_id))
				{	echo "klasl";

					$get_ispublished=$db->getData($ctable,"*","id=".$course_id);
					$isPublish_r=mysqli_fetch_assoc($get_ispublished);
					if($isPublish_r['isPublish']==1)
					{
						//die("5555");
						$get_name=$db->getData("stay_connected","*","isDelete=0 AND opt_out=0");
						while($name_row=mysqli_fetch_assoc($get_name))
						{
							if( ISMAIL )
		                    {

								$subject = SITENAME." : New Course Added";
		                        $nt = new Notification();
		                       
		                        include("../mailbody/new_course_added.php");
		                       	die($body);
		                        $toemail = $name_row['email'];
		                        $nt->sendEmail($toemail, $subject, $body);
		                    }
		                }
					}
					
				}

				$_SESSION['MSG'] = "Inserted";
				//$db->location(ADMINURL.'manage-'.$page.'/');
				$db->location(ADMINURL.'add-module/add/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			//$ispublish=0;
			$course_id = $_REQUEST['id'];

			/*$check_ispublish = $db->getData($ctable, "*", "id <> " . $course_id . " AND isDelete=0");
			$row_ispublish=mysqli_fetch_assoc($check_ispublish);
			if($row_ispublish['isPublish']==0)
			{
				$ispublish++;
			}*/
			
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $course_id . " AND slug = '".$slug."' AND isDelete=0");

			
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$course_id);
				/*if($ispublish>0)
				{
					$get_course=$db->getData($ctable,"*","id=".$course_id);
					$isPublish_r=mysqli_fetch_assoc($get_course);
					if($isPublish_r['isPublish']==1)
					{
							$get_name=$db->getData("stay_connected","*","isDelete=0 AND opt_out=0");
							while($name_row=mysqli_fetch_assoc($get_name))
							{
						
			                    if( ISMAIL )
			                    {
			                    	
			                        $subject = SITENAME." : New Course Added";
			                        $nt = new Notification();
			                        include("../mailbody/new_course_added.php");
			                       	//die($body);
			                        $toemail = "hedaci6203@duetube.com";//name_row['$email'];
			                        $nt->sendEmail($toemail, $subject, $body);
			                    }
			                }
					}
				}*/

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
		$short_description	= stripslashes($ctable_d['short_description']);
		$price	= stripslashes($ctable_d['price']);
		$publish_date	= stripslashes($ctable_d['publish_date']);
		$long_description	= stripslashes($ctable_d['long_description']);
		$image_path	= stripslashes($ctable_d['image']);
		$isPublished	= stripslashes($ctable_d['isPublish']);

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
												<label for="name"> Name <code>*</code></label>
												<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" maxlength="200">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group float-right">
												<label for="name"> &nbsp;</label>
												<div class="button-list">	
													<div class="btn-switch btn-switch-info">
														<input type="checkbox" name="isPublished" id="isPublished" value="1" <?php if($isPublished=="1"){ echo "checked";}?>/>
														<label for="isPublished" class="btn btn-rounded btn-info waves-effect waves-light">
															<em class="fa fa-check"></em>
															<strong> Is Published? </strong>
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="name"> Short Description <code>*</code></label>
												 <textarea name="shortDesc" id="shortDesc" class="form-control"><?php echo $short_description; ?></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="price"> Price (<?php echo CURR; ?>) <code>*</code></label>
												<input type="text" class="form-control" name="price" id="price" value="<?php echo $price; ?>" maxlength="10">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="description"> Long Description <code>*</code></label>
												<textarea name="longDesc" id="longDesc" class="form-control"><?php echo $long_description; ?></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="image_path">Image <code>*</code>
															<br />
															<small>minimum image size 1308 x 784 px</small>
														</label>
														<br />
														<input type="hidden" name="filename" id="filename" class="form-control" />
														<div id="dropzone_img" class="dropzone" data-width="1308" data-height="784" data-ghost="false" data-cropwidth="1308" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=courseimg" style="width: 645px;height:392px;">
															<input type="file" id="image_path" name="image_path">
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
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" width="645"><br /><br />
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

		var custom_img_width = '1308';
		
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
					shortDesc:{required:true},
					price:{required:true}, 
					longDesc:{required:function() { CKEDITOR.instances.longDesc.updateElement(); }},
					publishDate:{required:true},
					image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }
				},
				messages: {
					name:{required:"Please enter name."}, 
					shortDesc:{required:"Please Enter short description of course."},
					price:{required:"Please enter course price."},
					longDesc:{required:"Please enter long description of course."},
					publishDate:{required:"Please enter date of publish."},
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
		function del_conf(id){
		var r = confirm("Are you sure you want to delete?");
		if(r)
		{
			
			$.ajax({
			type:"POST",
			url : "<?php echo SITEURL; ?>process-unsubscibe/process_unsubscribe.php",
			data : { 
			    "id" : del_id,
			    "action" : "delete"
			},

			success : function(response){
			  console.log(response);
			  if(response=="success")
			  {
			  	alert("Successfully Unsubscribe")
			  }
			  //location.reload(true);

			  
			}
			});

		}
	}
	
	</script>
</body>

</html>
