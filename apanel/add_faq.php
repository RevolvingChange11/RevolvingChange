<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "faq";
	$ctable1 	= "FAQ";
	$page 		= "faq";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$question = "";
	$answer	= "";

	if(isset($_REQUEST['submit']))
	{
		$question = $db->clean($_REQUEST['question']);
		$answer = $db->clean($_REQUEST['answer']);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$max_order = (int) $db->getValue($ctable, 'MAX(display_order)', 'isDelete=0');

			$rows 	= array(
				"question" => $question,
				"answer" => $answer,
				"display_order" => $max_order+1, 
			);				

			$check_user_r = $db->getData($ctable, "*", "question = '".$question."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/");
				exit;
			}
			else
			{
				$faq_id = $db->insert($ctable, $rows);

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$faq_id = $_REQUEST['id'];

			$rows 	= array(
				"question" => $question,
				"answer" => $answer,
			);				
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $faq_id . " AND question = '".$question."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$faq_id);

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

		$question = stripslashes($ctable_d['question']);
		$answer = htmlspecialchars_decode($ctable_d['answer']);
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
													<label for="name"> Question <code>*</code></label>
													<input type="text" class="form-control" name="question" id="question" value="<?php echo $question; ?>" maxlength="255">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Answer <code>*</code></label>
													<textarea class="form-control" id="answer" name="answer" rows="3"><?php echo $answer; ?></textarea>
													<div class="desc_error"></div>
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
	<script src="<?php echo ADMINURL; ?>js/ckeditor/ckeditor.js" type="text/javascript"></script>

	<script type="text/javascript">
		CKEDITOR.replace('answer');

		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					question:{required:true}, 
					answer:{required : function() { CKEDITOR.instances.answer.updateElement(); } },
				},
				messages: {
					question:{required:"Please enter question."},
					answer:{required:"Please enter answer."}, 
				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "answer") 
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
