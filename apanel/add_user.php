<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "user";
	$ctable1 	= "User";
	$page 		= "user";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = '';
	// $lname = '';
	$email = '';
	// $phone = '';
	$password = '';
	$isActive = "";

	if(isset($_REQUEST['submit']))
	{
		$name = $db->clean($_REQUEST['name']);
		// $lname = $db->clean($_REQUEST['lname']);
		$email = $db->clean($_REQUEST['email']);
		$phone = $db->clean($_REQUEST['phone']);
		$password = $db->clean($_REQUEST['password']);
        $confirmation_string = $db->generateRandomString(8);

		if(isset($_REQUEST['isActive']) && $_REQUEST['isActive'] == "1"){
			$isActive = $db->clean($_REQUEST['isActive']);
		}else{
			$isActive = 0;
		}

		$rows 	= array(
			"name"=> $name,
			// "last_name" => $lname,
			"email"		=> $email,
			"phone"		=> $phone,
			"password"	=> md5($password),
			"isActive"  => $isActive,	
            "confirmation_string"   => $confirmation_string,
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
				$employee_id = $db->insert($ctable, $rows);
				
				if($employee_id > 0)
				{
					$rows = array('password' => md5($password));
					$db->update($ctable, $rows, 'id='.$employee_id);

					if( ISMAIL )
					{
						include("../include/notification.class.php");
						$subject = SITETITLE.": Account Created";
						$nt = new Notification();
						include("../mailbody/admin_employee_create.php");
						$toemail = $email;
						//die($body);
						$nt->sendEmail($toemail, $subject, $body);
					}
				}

				$_SESSION['MSG'] = "Inserted";
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
		{
			$employee_id = $_REQUEST['id'];
			
			$check_user_r = $db->getData($ctable, "*", "id <> " . $employee_id . " AND email = '".$email."' AND isDelete=0");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$_SESSION['MSG'] = "Duplicate";
				$db->location(ADMINURL."add-".$page."/".$_REQUEST['mode']."/".$_REQUEST['id']."/");
				exit;
			}
			else
			{
				$db->update($ctable, $rows, "id=".$employee_id);

				if( !empty($password) )
				{
					$rows = array('password' => md5($password));
					$db->update($ctable, $rows, 'id='.$employee_id);
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

		$fname   = stripslashes($ctable_d['name']);
		$email	= stripslashes($ctable_d['email']);
		// $lname   = stripslashes($ctable_d['last_name']);
		$phone   = stripslashes($ctable_d['phone']);
		$isActive   = stripslashes($ctable_d['isActive']);
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
													<input type="text" class="form-control" name="name" id="name" value="<?php echo $fname; ?>" maxlength="100">
												</div>
											</div>
											<!-- <div class="col-md-6">
												<div class="form-group">
													<label for="lname"> Last name <code>*</code></label>
													<input type="text" class="form-control" name="lname" id="lname" value="<?php echo $lname; ?>" maxlength="100">
												</div>
											</div> -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="email"> Email <code>*</code></label>
													<input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>" maxlength="100">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="phone"> Phone <code>*</code></label>
													<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" maxlength="100">
												</div>
											</div> 											<div class="col-md-6">
												<div class="form-group">
													<label for="password"> password <small>(Keep blank if no change)</small> <code>*</code></label>
													<input type="password" class="form-control" name="password" id="password" value="" maxlength="20">
												</div>
											</div>
										
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> &nbsp;</label>
													<div class="button-list">	
														<div class="btn-switch btn-switch-info">
															<input type="checkbox" name="isActive" id="isActive" value="1" <?php if($isActive=="1"){ echo "checked";}?>/>
															<label for="isActive" class="btn btn-rounded btn-info waves-effect waves-light">
																<em class="fa fa-check"></em>
																<strong> Is Account Verified? </strong>
															</label>
														</div>
													</div>
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

	<script type="text/javascript">
		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: {
					name:{required:true},
					//lname:{required:true}, 
					email:{required:true, email:true}, 
					phone:{required:true},
					password:{required: <?php echo ($_REQUEST['mode']=="add")?'true':'false'; ?> }, 
				},
				messages: {
					name:{required:"Please enter firstname."}, 
					//lname:{required:"Please enter lastname."}, 
					email:{required:"Please enter email address.", email:"Please enter valid email address."}, 
					phone:{required:"Please enter phone number."}, 
					password:{required:"Please enter password."}, 
				}
			});
		});
	</script>
</body>

</html>
