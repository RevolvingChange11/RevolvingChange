<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "contact";
	$ctable1 	= "Contact";
	$page 		= "contact";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = "";
	$email = "";
	$phone = "";
	$message = "";

	if(isset($_REQUEST['submit']))
	{
		$name = $db->clean($_REQUEST['name']);
		$email = $db->clean($_REQUEST['email']);
		$phone = $db->clean($_REQUEST['phone']);
		$message = $db->clean($_REQUEST['message']);

		if( empty($name) || empty($email) || empty($message) )
		{
			$db->location(ADMINURL."add-".$page."/add/");
			exit;
		}

		$rows 	= array(
			"name" => $name,
			"email" => $email,
			"phone" => $phone,
			"message" => $message,
		);				
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$check_user_r = $db->getData($ctable, "*", "email = '".$email."' AND isDelete=0");
		
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
			$check_user_r = $db->getData($ctable, "*", "id <> " . $contact_id . " AND email = '".$email."' AND isDelete=0");
		
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

		$name = stripslashes($ctable_d['name']);
		$email = stripslashes($ctable_d['email']);
		$phone = stripslashes($ctable_d['phone']);
		$message = htmlspecialchars_decode($ctable_d['message']);
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
													<label for="name"> Name <code>*</code></label>
													<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" maxlength="75">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="email"> Email <code>*</code></label>
													<input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>" maxlength="100">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="phone"> Phone <code>*</code></label>
													<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" maxlength="25">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Message <code>*</code></label>
													<textarea class="form-control" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
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
		//CKEDITOR.replace('message');

		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					name:{required:true}, 
					email:{required:true, email:true}, 
					phone:{required:true}, 
					//message:{required : function() { CKEDITOR.instances.message.updateElement(); } },
					message:{required:true},
				},
				messages: {
					name:{required:"Please enter name."},
					email:{required:"Please enter email.", email:"Please enter valid email address."},
					phone:{required:"Please enter contact number."},
					message:{required:"Please enter message."}, 
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
