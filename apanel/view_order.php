<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable = "cart";
	$ctable1 = "Order";
	$page = "order";
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$cart_id = $_REQUEST['id'];

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id 	= $_REQUEST['id'];
		$rows 	= array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
		
		$_SESSION['MSG'] = "Deleted";
		$db->location(ADMINURL.'manage-'.$page.'/');
		exit;
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="update")
	{
		//print_r($_REQUEST); //exit;

		$id = $_REQUEST['id'];
		$tracking_id = $_REQUEST['tracking_id'];
		$order_status = $_REQUEST['order_status'];
		$rows 	= array("order_status" => $order_status, "shipping_tracking_id" => $tracking_id);
		
		$db->update($ctable, $rows, "id=".$id);
		
		$_SESSION['MSG'] = "Updated";
		//$db->location(ADMINURL.'manage-'.$page.'/');
		//exit;
	}

	$rs_cart = $db->getData($ctable, '*', 'id=' . (int) $cart_id . ' AND isDelete=0');
	$row_cart = @mysqli_fetch_assoc($rs_cart);

	$rs_bs 	= $db->getData('billing_shipping', "*", 'cart_id='.(int) $cart_id . ' AND isDelete=0');
	$row_bs 	= @mysqli_fetch_assoc($rs_bs);

	$billing_first_name			=	stripslashes($row_bs['billing_first_name']);
	$billing_last_name			=	stripslashes($row_bs['billing_last_name']);
	$billing_email				=	stripslashes($row_bs['billing_email']);
	$billing_phone				= 	stripslashes($row_bs['billing_phone']);
	$billing_address			= 	stripslashes($row_bs['billing_address']);
	$billing_address2			= 	stripslashes($row_bs['billing_address2']);
	$billing_city				=	stripslashes($row_bs['billing_city']);
	$billing_state				=	stripslashes($row_bs['billing_state']);
	$billing_country			=	stripslashes($row_bs['billing_country']);
	$billing_zipcode			=	stripslashes($row_bs['billing_zipcode']);
	
	$shipping_first_name		=	stripslashes($row_bs['shipping_first_name']);
	$shipping_last_name			=	stripslashes($row_bs['shipping_last_name']);
	$shipping_email				=	stripslashes($row_bs['shipping_email']);
	$shipping_phone				= 	stripslashes($row_bs['shipping_phone']);
	$shipping_address			= 	stripslashes($row_bs['shipping_address']);
	$shipping_address2			= 	stripslashes($row_bs['shipping_address2']);
	$shipping_city				=	stripslashes($row_bs['shipping_city']);
	$shipping_state				=	stripslashes($row_bs['shipping_state']);
	$shipping_country			=	stripslashes($row_bs['shipping_country']);
	$shipping_zipcode			=	stripslashes($row_bs['shipping_zipcode']);

	$rs_user = $db->getData('employee', 'name, email', 'id='. (int) $row_cart['employee_id']);
	$row_user = @mysqli_fetch_assoc($rs_user);
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
						<?php
							if( !empty($row_cart['shipping_tracking_id']) && !is_null($row_cart['shipping_tracking_id']) )
							{
						?>
						<div style="float: right;"><a href="<?php echo ADMINURL; ?>track-order/<?php echo $row_cart['id']; ?>/" target="_blank">Track Order</a></div>
						<?php
							}
						?>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4  border-left-info">
								<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
									<input type="hidden" name="mode" id="mode" value="update">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<div class="row mb-3">
											<!-- <div class="col-md-1"></div> -->
											<div class="col-md-3" style="text-align: right;"><label for="tracking_id">Shipment Tracking ID: </label></div>
											<div class="col-md-3">
												<input type="text" name="tracking_id" id="tracking_id" value="<?php echo $row_cart['shipping_tracking_id']; ?>" placeholder="Tracking ID" class="form-control">
											</div>
											<div class="col-md-2" style="text-align: right;"><label for="order_status">Order Status: </label></div>
											<div class="col-md-3">
												<select name="order_status" id="order_status" class="form-control inline">
													<option value="0" <?php if($row_cart['order_status'] == 0) echo ' selected'; ?>>Cancelled</option>
													<option value="1" <?php if($row_cart['order_status'] == 1) echo ' selected'; ?>>In Progress</option>
													<option value="2" <?php if($row_cart['order_status'] == 2) echo ' selected'; ?>>Completed</option>
													<option value="3" <?php if($row_cart['order_status'] == 3) echo ' selected'; ?>>Shipped</option>
													<option value="4" <?php if($row_cart['order_status'] == 4) echo ' selected'; ?>>Delivered</option>
												</select>
											</div>
											<div class="col-md-1">
												<button type="submit" name="btnsubmit" class="btn btn-success waves-effect w-md waves-light" title="Update"><i class="fa fa-save" aria-hidden="true"></i></button>
											</div>
										</div>
										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<td><strong>Employee Name</strong></td>
													<td><?php echo $row_user['name']; ?></td>
													<td colspan="2"></td>
												</tr>
												<tr>
													<td><strong>Employee Email</strong></td>
													<td><?php echo $row_user['email']; ?></td>
													<td colspan="2"></td>
												</tr>
												<tr>
													<td><strong>Order Number</strong></td>
													<td><?php echo $row_cart['order_no']; ?></td>
													<td><strong>Sub Total</strong></td>
													<td><?php echo CUR.$db->num($row_cart['sub_total']); ?></td>
												</tr>
												<tr>
													<td><strong>Order Date</strong></td>
													<td><?php echo (!is_null($row_cart['order_date']))?$db->date($row_cart['order_date'], 'm/d/Y'):$db->date($row_cart['adate'], 'm/d/Y'); ?></td>
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
												
										<table id="user" class="table table-bordered table-striped">
											<tbody>
												<tr>
													<th>Details</th>
													<th>Billing Details</th>
													<th>Shipping Details</th>
												</tr>

												<tr>
													<td>Name</td>
													<td><span class="text-muted"> <?php echo $billing_first_name.' '.$billing_last_name; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_first_name.' '.$shipping_last_name; ?></span></td>
												</tr>
												<tr>
													<td>E-Mail</td>
													<td><span class="text-muted"> <?php echo $billing_email; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_email; ?></span></td>
												</tr>
												<tr>
													<td>Phone</td>
													<td><span class="text-muted"> <?php echo $billing_phone; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_phone; ?></span></td>
												</tr>
												<tr>
													<td>Address1</td>
													<td><span class="text-muted"> <?php echo $billing_address; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_address; ?></span></td>
												</tr>
												<tr>
													<td>Address2</td>
													<td><span class="text-muted"> <?php echo $billing_address2; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_address2; ?></span></td>
												</tr>
												<tr>
													<td>City</td>
													<td><span class="text-muted"> <?php echo $billing_city; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_city; ?></span></td>
												</tr>
												<tr>
													<td>State</td>
													<td><span class="text-muted"> <?php echo $db->getValue('states', 'name', 'id=' .$billing_state); ?></span></td>
													<td><span class="text-muted"> <?php echo $db->getValue('states', 'name', 'id=' .$shipping_state); ?></span></td>
												</tr>
												<tr>
													<td>Country</td>
													<td><span class="text-muted"> <?php echo $billing_country; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_country; ?></span></td>
												</tr>
												<tr>
													<td>Zipcode</td>
													<td><span class="text-muted"> <?php echo $billing_zipcode; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_zipcode; ?></span></td>
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
													<th class="text-center">Tax</th>
													<th class="text-center">Subtotal</th>
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
										
													$tt = $db->num($row_detail['sub_total']);
													$tax = $db->num(($tt * TAX_RATE) / (100 + TAX_RATE) );
													$tt = $db->num($tt - $tax);
				    						?>
												<tr>
													<td class="text-center"><?php echo $counter; ?></td>
													<td class="text-center"><img src="<?php echo SITEURL.PRODUCT.$row_detail['image_path']; ?>" class="img-fluid" width="70"></td>
													<td><?php echo $row_detail['product_name']; ?>
								                        <span class="text-muted font-weight-normal font-italic d-block">Color: <?php echo $row_detail['color']; ?></span>
								                        <span class="text-muted font-weight-normal font-italic d-block">Size: <?php echo $row_detail['size']; ?></span>
													</td>
													<td class="text-center"><?php echo $row_detail['qty']; ?></td>
													<td class="text-center"><?php echo CUR.$db->num($tax); ?></td>
													<td class="text-center"><?php echo CUR.$db->num($tt); ?></td>
													<td class="text-center"><?php echo CUR.$db->num($row_detail['sub_total']); ?></td>
												</tr>
				    						<?php
				    							}
											?>
											</tbody>
										</table>
										
										<div class="box-footer">
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
</body>

</html>
