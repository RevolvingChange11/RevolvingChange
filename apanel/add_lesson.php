
<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "lesson";
	$ctable1 	= "Lesson";
	$page 		= "lesson";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$IMAGEPATH_T = LESSON_T;
	$IMAGEPATH_A = LESSON_A;
	$IMAGEPATH = LESSON;

	$name = '';
	$course_id = '';
	$module_id = '';
	$long_desc = '';
	$isPublished = '';
	$video_url = '';

	$question_id = '';
	$question = '';

	$artype = array('video/mp4', 'video/webm', 'video/m4v', 'video/mkv', 'video/x-matroska', 'video/ogg');

	if(isset($_REQUEST['submit']))
	{
		//print_r($_REQUEST); exit;
		$name = $db->clean($_REQUEST['name']);
		$course_id = $db->clean($_REQUEST['course_id']);
		$slug = $db->createSlug($_REQUEST['name']);
		$module_id = $db->clean($_REQUEST['module_id']);
		$isPublished = (int) $_REQUEST['isPublished'];
		$long_desc = $db->clean($_REQUEST['longDesc']);
		$video_url = $db->clean($_REQUEST['video_url']);
		$question_id = $_REQUEST['question_id'];
		$question = $_REQUEST['question'];

		//print_r($_FILES['video_url']);
		//die();

		if(isset($_FILES['video_url']) && $_FILES['video_url']!="")
		{
			if( file_exists($_FILES['video_url']['tmp_name']) && is_uploaded_file($_FILES['video_url']['tmp_name'])) 
			{
				$file_type = $_FILES['video_url']['type'];
				if ( in_array($file_type, $artype) ) 
				{
					$imageFileType = strtolower(pathinfo($_FILES['video_url']['name'], PATHINFO_EXTENSION));
					$video_url = time()."_".rand(1,9999999).".".$imageFileType;
					if(!move_uploaded_file($_FILES['video_url']['tmp_name'], LESSON_A.$video_url))
				 	{

				 		$_SESSION['MSG'] = "Problem uploading .webm, .mp4, .mkv, .m4v or .ogv File";
						$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
						exit;
				 	}
				}
				else
				{
				 	$_SESSION['MSG'] = "You may only upload .webm, .mp4, .mkv, .m4v or .ogv File";
					$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
					exit;
				}
			}
		}
		else{
			$video_url = $_REQUEST['old_video_url'];
			echo $video_url;
			exit; 
		}

		$rows 	= array(
			"name" => $name,
			//"course_id" => $course_id,
			"module_id" => $module_id,
			"slug" => $slug,
			//"name" => $name,
			"isPublished" => $isPublished,
			"long_desc" => $long_desc,
			"video_url" => $video_url,
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
				$lesson_id = $db->insert($ctable, $rows);
				

				$n = count($question);
				if($n!=0)
				{
					for( $i=0; $i<$n; $i++ ) 
					{
						$row_q = array(
							'name' => $question[$i], 
							'lesson_id' => (int) $lesson_id, 
						);
						if( $question_id[$i] > 0 )
							$db->update('question', $row_q, 'id='.(int) $question_id[$i]);	
						else
							$db->insert('question', $row_q);
					}
				}
				
				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
			// die('111');
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			// die('11');
			$lesson_id = $_REQUEST['id'];
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $lesson_id . " AND slug = '".$slug."' AND isDelete=0");
			
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$lesson_id);

				$n = count($question);
				for( $i=0; $i<$n; $i++ ) 
				{
					$row_q = array(
						'name' => $question[$i], 
						'lesson_id' => (int) $lesson_id, 
					);
					if( $question_id[$i] > 0 )
						$db->update('question', $row_q, 'id='.(int) $question_id[$i]);	
					else
						$db->insert('question', $row_q);
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
		$module_id	= stripslashes($ctable_d['module_id']);
		$isPublished	= stripslashes($ctable_d['isPublished']);
		$long_desc	= stripslashes($ctable_d['long_desc']);
		$video_url	= stripslashes($ctable_d['video_url']);
		$course_id_r=$db->getData("module","course_id","id=".$module_id."");
		$course_id_row=mysqli_fetch_assoc($course_id_r);
		$course_id=$course_id_row['course_id'];
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
												<label for="course_id"> Course <code>*</code></label>
												<select name="course_id" id="course_id" class="form-control">
													<option value="">Select Course</option>
													
													<?php 
													echo $course_id;

														$rs_c = $db->getData('course', 'id, name', 'isDelete=0', 'name');
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
											<div class="form-group">
												<label for="name"> Module <code>*</code></label>
												<div id="mod_content">
												<select name="module_id" id="module_id" class="form-control">
													<option value="">Select Module</option>
													<?php 
														$where = 'isDelete=0';
														if( $course_id > 0 )
															$where .= ' AND course_id=' . (int) $course_id;
														$rs_c = $db->getData('module', 'id, name', $where, 'name');
														while( $row_c = @mysqli_fetch_assoc($rs_c) )
														{
															echo '<option value="'.$row_c['id'].'"';
															if( $module_id == $row_c['id'] )
																echo ' selected';
															echo '>'.$row_c['name'].'</option>';
														}
													?>
												</select>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="description"> Long Description <code>*</code></label>
												<textarea name="longDesc" id="longDesc" class="form-control"><?php echo $long_desc; ?></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="video_url">Video <code>*</code></label>
														<input maxlength="255" type="file" name="video_url" id="video_url" placeholder="Upload Video" value="<?php echo $video_url; ?>" accept="video/mp4,video/x-m4v,video/*">
														<input type="hidden" name="old_video_url" value="<?php echo $video_url; ?>" id="old_video_url">
													</div>
												</div>
												<div class="col-md-6">
													<?php if($_REQUEST['mode'] == 'edit' && $video_url!=""){ ?>
													<div class="form-group">
														<video width="250" height="250" controls>
															<source src="<?php echo SITEURL.LESSON.$video_url; ?>" type="video/mp4">
														</video>
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<fieldset>
												<legend>Questions</legend>
												<div class="row">
													<div class="col-md-10">
														<label>Question</label>
													</div>
													<div class="col-md-2 text-center">
														<label>Action</label>
													</div>
												</div>
												<div id="q_row">
												<?php
													$counter = 0;
													$rs_q = $db->getData('question', '*', 'lesson_id = ' . (int) $_REQUEST['id'] . ' AND isDelete=0');
													while( $row_q = @mysqli_fetch_assoc($rs_q) )
													{
														$counter++;
												?>
													<div class="row" id="row_<?php echo $counter; ?>">
														<input type="hidden" name="question_id[]" id="question_id_<?php echo $counter; ?>" value="<?php echo $row_q['id']; ?>">
														<div class="col-md-10">
															<div class="form-group">
																<input type="text" name="question[]" id="question_<?php echo $counter; ?>" value="<?php echo $row_q['name']; ?>" class="form-control" maxlength="255" placeholder="Question">
															</div>
														</div>
														<div class="col-md-2 text-center">
															<a class="text-danger" onClick="remove_option('<?php echo $counter; ?>', '<?php echo $row_q['id']; ?>');" title="Delete"><i class="fa fa-times"></i></a>
														</div>
													</div>
												<?php
													}
												?>
												</div>
												<div class="row">
													<div class="col-md-12">
														<input type="hidden" name="hdncount" id="hdncount" value="<?php echo $counter; ?>">
														<a class="btn btn-info text-white" onClick="add_option();" title="Delete"><i class="fa fa-plus"></i></a>
													</div>
												</div>
											</fieldset>
										</div>
										<div class="col-md-6">
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

		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					name:{required:true}, 
					shortDesc:{required:true},
					course_id:{required:true},
					module_id:{required:true},
					longDesc:{required:function() { CKEDITOR.instances.longDesc.updateElement(); }},
					//isPublished:{required:true},
					video_url:{ required: $("#mode").val()=="add" && $("#old_video_url").val()=="" }
				},
				messages: {
					name:{required:"Please enter name."},
					course_id:{required:"Please select course."},
					module_id:{required:"Please select module."}, 
					shortDesc:{required:"Please Enter short description of module."},
					longDesc:{required:"Please enter long description of module."},
					//isPublished:{required:"Please enter date of publish."},
					video_url:{required:"Please upload video."}, 
				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "filename") 
						error.insertAfter("#dropzone_img");
					else
						error.insertAfter(element);
				}
			});

			$('#course_id').on('change', function() {
				val = $(this).val();

		      	$.ajax({
		            url: "<?php echo ADMINURL; ?>ajax_data.php",
		            data: {mode:'get_module',course_id:val},
		            type: "POST",
		            beforeSend: function() {
		            	$('.loader').show();
		            }, 
		            success: function (response) {
		            	$('#mod_content').html(response);
		            	$('.loader').hide();
		            }
		      	});
				
			});
		});

		function add_option()
		{
			var val = $('#hdncount').val();
			val++;

			$('#q_row').append(`<div class="row" id="row_`+val+`">
							<input type="hidden" name="question_id[]" id="question_id_`+val+`" value="0">
							<div class="col-md-10">
								<div class="form-group">
									<input type="text" name="question[]" id="question_`+val+`" value="" class="form-control" maxlength="255" placeholder="Question">
								</div>
							</div>
							<div class="col-md-2 text-center">
								<a class="text-danger" onClick="remove_option('`+val+`', '0');" title="Delete"><i class="fa fa-times"></i></a>
							</div>
						</div>
						`);
			$('#hdncount').val(val);
		}

	   	function remove_option(counter, id)
	   	{
	   		if( confirm('Are you sure you want to delete?') )
	   		{
		      	$.ajax({
		            url: "<?php echo ADMINURL; ?>ajax_data.php",
		            data: {mode:'remove_question',question_id:id},
		            type: "POST",
		            beforeSend: function() {
		            	$('.loader').show();
		            }, 
		            success: function (response) {
	   					$("#row_"+counter).remove();
		            	$('.loader').hide();
		            }
		      	});	   			
	   		}
	   	}
	</script>
</body>

</html>
