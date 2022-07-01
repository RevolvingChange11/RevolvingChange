<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "static_page";
	$ctable1 	= "Static Page";
	$main_page 	= "manage-static-page"; //for sidebar active menu
	$page 		= "static-page";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$title 	= "";
	$descr 	= "";

	if(isset($_REQUEST['submit']))
	{
		$title 	= $db->clean($_REQUEST['title']);
		$descr 	= $db->clean($_REQUEST['descr']);

		$rows 	= array(
			"title" => $title,
			"descr"	=> $descr,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$check = $db->getData($ctable, "*", "slug = '".$slug."' AND isDelete=0");
		
			if(@mysqli_num_rows($check)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL.$main_page);
				exit;
			}
			else
			{	
				$static_page_id = $db->insert($ctable, $rows);

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.$main_page);
				exit;
			}
		}

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$check = $db->getData($ctable, "*", "id <> " . $_REQUEST['id'] . " AND title = '".$title."' AND isDelete=0");
		
			if(@mysqli_num_rows($check)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL.$main_page);
				exit;
			}
			else
			{	
				$db->update($ctable, $rows, "id=".$_REQUEST['id']);

				$_SESSION['MSG'] = "Updated";
				$db->location(ADMINURL.$main_page);
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
		$descr   = stripslashes($ctable_d['descr']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id 	= $_REQUEST['id'];
		$rows 	= array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
		
		$_SESSION['MSG'] = "Deleted";
		$db->location(ADMINURL.$main_page);
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

									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Title <code>*</code></label>
													<input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" maxlength="255">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="descr"> Description <code>*</code></label>
													<textarea name="descr" id="descr" class="form-control"><?php echo $descr; ?></textarea>
												</div>
											</div>
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" id="submit" class="btn btn-success" title="Submit"><i class="fa fa-save"></i></button>
											<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL . $main_page; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
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
		CKEDITOR.replace('descr');
		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					title:{required:true}, 
					descr:{required : function() { CKEDITOR.instances.descr.updateElement(); } },
				},
				messages: {
					title:{required:"Please enter title."}, 
					descr:{required:"Please enter description."},
				}
			});
		});
	</script>
</body>

</html>
