<?php
include("connect.php");

if((isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) && $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']>0)){
	$db->location(ADMINURL."dashboard/");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Set New Password | <?php echo ADMINTITLE; ?></title>
	<?php include("include/css.php"); ?>
</head>

<body class="" style="background-color: #245c5f;">
	<div class="container">
		<!-- Outer Row -->
		<div class="row justify-content-center">
			<div class="col-xl-5 col-lg-7 col-md-4">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<img src="<?php echo SITEURL.'images/logo.png' ?>" class="img-fluid" title="<?php echo SITETITLE; ?>" alt="<?php echo SITETITLE; ?>">
									</div>
									<br>
									<form class="user" action="<?php echo ADMINURL."process-set-new-password/"; ?>" method="post" name="frm" id="frm">
				                      	<input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>" />
				                      	<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" />
										<div class="form-group">
											<input type="password" class="form-control form-control-user" id="newpass" name="newpass" placeholder="Enter New Password" autocomplete="off">
										</div>
										<div class="form-group">
											<input type="password" class="form-control form-control-user" id="cnewpass" name="cnewpass" placeholder="Confirm New Password" autocomplete="off">
										</div>
										<button class="btn btn-success btn-user btn-block" name="submit" id="submit" type="submit">Submit</button>
									</form>
									<hr>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include("include/js.php"); ?>
	<script type="text/javascript">
		$(function(){
			$("#frm").validate({
				rules: {
					newpass:{required: true},
					cnewpass:{required: true, equalTo: "#newpass"},
				},
				messages: {
					newpass:{required:"Please enter new password."},
					cnewpass:{required:"Please enter confirm password.", equalTo:"New password and Confirm password do not match."},
				}
			});
		});
	</script>
</body>

</html>
