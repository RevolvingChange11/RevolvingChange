<?php
include("connect.php");
$db->checkAdminLogin();
$main_page  = "home";
$page_title = "Dashboard";
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
						<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
					</div>

					<!-- Content Row -->
					<div class="row">

						<!-- User -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">User(s)</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $db->getTotalRecord("user","isDelete=0"); ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-user-alt fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div> 
						<!-- Course -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-info shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Course(s)</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $db->getTotalRecord("course","isDelete=0"); ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-book-open fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div> 
						
						
						<!-- Orders -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Order(s)</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $db->getTotalRecord("purchase_history","isDelete=0"); ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-table fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div> 

						<!-- blog -->
						 <div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Blog(s)</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $db->getTotalRecord("blog","isDelete=0"); ?></div>
										</div>
										<div class="col-auto">
											<i class="fab fa-blogger-b fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
					<!-- Content Row -->
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

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-secondary" href="login.html">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<?php include("include/js.php"); ?>

</body>

</html>
