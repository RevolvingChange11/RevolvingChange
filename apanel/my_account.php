<?php
include("connect.php");

$db->checkAdminLogin();
$ctable 		= "admin";
$ctable1 		= "My Account";
$main_page 		= "Definition";
$page 			= "add_".$ctable;
$page_title 	= ucwords($_REQUEST['mode'])." ".$ctable1;

$name 			= "";
$email		= "";

if(isset($_REQUEST['submit']))
{
	
	$name	= $db->clean($_REQUEST['name']);
	$email 	= $db->clean($_REQUEST['email']);

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$rows 	= array(
			"name"	=> $name,
			"email"	=> $email
		);

		$where	= "id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'];
		$db->update($ctable,$rows,$where);

		$_SESSION['MSG'] = "Updated";
		$db->location(ADMINURL."my-account/");
		exit;
	}
}
if(isset($_REQUEST['submit1']))
{
	
	$password	= $db->clean($_REQUEST['password']);

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$rows 	= array(
			"password"	=> md5($password)
		);

		$where	= "id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'];
		$db->update($ctable,$rows,$where);

		$_SESSION['MSG'] = "Updated";
		$db->location(ADMINURL."my-account/");
		exit;
	}
}
if(isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) && $_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] > 0)
{
	$where 		= " id='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']."' AND isDelete=0";
	$ctable_r 	= $db->getData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);
	
	$name   	= stripslashes($ctable_d['name']);
	$email		= stripslashes($ctable_d['email']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title?> | <?php echo ADMINTITLE; ?></title>
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
						<div class="col-lg-6">
							<div class="card mb-4  border-left-info">
								<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
									<input type="hidden" name="mode" id="mode" value="edit">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
									<div class="card-body col-lg-12">
									<p><b>Update Account Info</b></p>

										<div class="form-group">
											<label for="name"> Name <code>*</code></label>
											<input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
										</div>
										<div class="form-group">
											<label for="email"> Email <code>*</code></label>
											<input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" id="submit" class="btn btn-success" title="Save Changes"><i class="fa fa-save"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card mb-4  border-left-info">
								<form name="change-password-form" id="change-password-form" method="post" enctype="multipart/form-data" action=".">
									<input type="hidden" name="mode" id="mode" value="edit">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
									<div class="card-body col-lg-12">
									<p><b>Change Password</b></p>

										<div class="form-group">
											<label for="oldpassword"> Current Password <code>*</code></label>
											<input type="password" class="form-control" id="oldpassword" name="oldpassword" value="<?php echo $oldpassword; ?>">
										</div>
										<div class="form-group">
											<label for="password"> New Password <code>*</code></label>
											<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
										</div>
										<div class="form-group">
											<label for="cpassword"> Confirm New Password <code>*</code></label>
											<input type="password" class="form-control" id="cpassword" name="cpassword" value="<?php echo $cpassword; ?>">
										</div>
										<div class="box-footer">
											<button type="submit" name="submit1" id="submit1" class="btn btn-success" title="Save Changes"><i class="fa fa-save"></i></button>
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
	<script>
		$(function(){
			$("#frm").validate({
				ignore: "",
				rules: 
				{
					name:{required:true},
					email:{required:true}
				},
				messages: 
				{
					name:{required:"Please enter name."},
					email:{required:"Please enter email"}
				}
			});
		});
		$(function(){
			$("#change-password-form").validate({
				ignore: "",
				rules: 
				{
					oldpassword:{required : true,
						remote: {
							url: "<?php echo ADMINURL.'ajax_check_oldpassword.php' ?>",
							type: "post",
							dataType: 'json',
							data: {
							  	oldpassword: function() {
									return $( "#oldpassword" ).val();
							  	}
							}
						}
					},
					password:{required : true},
					cpassword:{required : true,equalTo: "#password"}
				},
				messages: 
				{
					oldpassword:{required:"Please enter old password.",remote:"Please enter currect oldpassword."},
					password:{required:"Please enter password."},
					cpassword:{required:"Please enter confirm password."}
				}
			});
		});
	</script>
</body>

</html>
