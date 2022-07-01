<?php 
	include('connect.php');
	$db->checkAdminLogin();

	$ctable = "cart";
	$page = "order";
	$page_title = "Shipment Detail";

    $cart_id = 0;
    if( isset($_REQUEST['id']) && $_REQUEST['id'] > 0 )
    	$cart_id = $_REQUEST['id'];

    $rs_cart = $db->getData($ctable, '*', 'id=' . (int) $cart_id . ' AND isDelete=0');
    $row_cart = @mysqli_fetch_assoc($rs_cart);
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
									<input type="hidden" name="mode" id="mode" value="update">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<td><strong>Order Number</strong></td>
													<td><?php echo $row_cart['order_no']; ?></td>
													<td><strong>Sub Total</strong></td>
													<td><?php echo CUR.$db->num($row_cart['sub_total']); ?></td>
												</tr>
												<tr>
													<td><strong>Order Date</strong></td>
													<td><?php echo $db->date($row_cart['order_date'], 'm/d/Y'); ?></td>
													<td><strong>Tax</strong></td>
													<td><?php echo CUR.$db->num($row_cart['tax']); ?></td>
												</tr>
												<tr>
													<td><strong>Order Status</strong></td>
													<td><?php 
																switch( $row_cart['order_status'] )
																{
																	case 0:
																		echo 'Cancelled';
																		break; 
																	case 2:
																		echo 'Completed';
																		break; 
																	case 3:
																		echo 'Shipped';
																		break; 
																	case 4:
																		echo 'Delivered';
																		break; 
																	default:
																		echo 'In Progress';
																		break; 
																}
															?>
													</td>
													<td><strong>Shipping</strong></td>
													<td><?php echo CUR.$db->num($row_cart['shipping']); ?></td>
												</tr>
												<tr>
													<td><strong>Shipping Method</strong></td>
													<td><?php echo $row_cart['shipping_method'] . ' : ' . $row_cart['shipping_method_name']; ?></td>
													<td><strong>Order Amount</strong></td>
													<td><?php echo CUR.$db->num($row_cart['grand_total']); ?></td>
												</tr>
											</tbody>
										</table>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th class="text-center">Image</th>
													<th>Product Name</th>
													<th class="text-center">Quantity</th>
													<th class="text-center">Total</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$counter = 0;
											    $strquery = 'SELECT ct.*, p.name AS product_name, p.image_path, c.name AS color, s.name AS size 
											                 FROM cart_detail ct 
											                 LEFT JOIN product p ON p.id = ct.product_id 
											                 LEFT JOIN color c ON c.id = ct.color_id 
											                 LEFT JOIN size s ON s.id = ct.size_id 
											                 WHERE ct.cart_id = ' . (int) $cart_id . ' AND ct.isDelete=0 AND p.isDelete=0';
											    //print $strquery;
											    $rs_detail = @mysqli_query($myconn, $strquery);
				    							while( $row_detail = @mysqli_fetch_assoc($rs_detail) )
				    							{
				    								$counter++;
				    						?>
												<tr>
													<td class="text-center"><?php echo $counter; ?></td>
													<td class="text-center"><img src="<?php echo SITEURL.PRODUCT.$row_detail['image_path']; ?>" class="img-fluid" width="70"></td>
													<td><?php echo $row_detail['product_name']; ?>
								                        <span class="text-muted font-weight-normal font-italic d-block">Color: <?php echo $row_detail['color']; ?></span>
								                        <span class="text-muted font-weight-normal font-italic d-block">Size: <?php echo $row_detail['size']; ?></span>
													</td>
													<td class="text-center"><?php echo $row_detail['qty']; ?></td>
													<td class="text-center"><?php echo CUR.$db->num($row_detail['sub_total']); ?></td>
												</tr>
				    						<?php
				    							}
											?>
											</tbody>
										</table>

										<?php
											$result = $dbcart->getTrackingDetails($row_cart['shipping_tracking_id']);
											foreach ($result->tracking_results as $tracking) 
											{
												foreach ($tracking->errors as $error) 
												{
													if( !empty($error->code) )
													{
												?>
														<div class="error"><?php echo $error->code . ' : ' . $error->message; ?></div>
												<?php
													}
												}

												foreach ($tracking->trackable_items->events as $event) {
													echo '<div class="row mb-1">
														<div class="col-md-3">'.$event->location.'</div>
														<div class="col-md-3">'.$event->date.'</div>
														<div class="col-md-6">'.$event->description.'</div>
													</div>';
												}
											}
										?>
										
										<div class="box-footer mt-4">
											<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'view-'.$page.'/'.$cart_id.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
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
</body>

</html>
