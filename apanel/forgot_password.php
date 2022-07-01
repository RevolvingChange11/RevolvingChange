<?php
include("connect.php");

if((isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) && $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']>0)){
	$db->location(ADMINURL."dashboard/");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Forgot Password | <?php echo ADMINTITLE; ?></title>
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
										<!-- <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1> -->
										<img src="<?php echo SITEURL.'images/logo.png' ?>" class="img-fluid" title="<?php echo SITETITLE; ?>" alt="<?php echo SITETITLE; ?>">
									</div>
									<br><br>
									<p>Enter your email address and we'll send you an email with instructions to reset your password.  </p>
									<form class="user" action="<?php echo ADMINURL."process-forget-pass/"; ?>" method="post" name="frm" id="frm">
										<div class="form-group">
											<input type="email" name="email" id="email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Enter Email Address..." maxlength="100">
										</div>
										<button class="btn btn-success btn-user btn-block" type="submit">Send Email</button>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="<?php echo ADMINURL; ?>">Already have an account?</a>
									</div>
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
				email:{required : true,email:true},
			},
			messages: {
				email:{required:"Please enter your email.",email:"Please enter valid email address."},
			}
		});
	});
	</script>
</body>

</html>
