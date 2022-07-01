<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";

$re = "margin:0 auto; background-image:url(".$bg_img."); background-repeat:no-repeat;background-size:cover; padding:20px 20px; color:#404040; font-family:lato";
$body = '<table width="700px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom:50px; border:none; text-align:center;"><img src="'.SITEURL.'images/email-logo.png" style="width:150px; margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="font-size: 16px; padding:10px;">
				<tr>
					<td>
						Hello ' . $billing_first_name . ' ' . $billing_last_name . ', <br /><br />
					</td>
				</tr> 
				<tr>
					<td>
						Your order is successfully placed on ' . SITETITLE . '. <br /><br />
					</td>
				</tr> 
				<tr>
					<td>
						The details are as follows: <br />
					</td>
				</tr> 
				<tr>
					<td>
						<table width="100%" cellpadding="5" style="border: 1px solid #ccc; background-color: #e0e0e0;">
							<tr>
								<td><strong>Order #</strong></td>
								<td>' . $row_order['order_no'] . '</td>
								<td><strong>Order Date</strong></td>
								<td>' . $db->date($row_order['order_date'], 'm/d/Y') . '</td>
							</tr>
							<tr>
								<td><strong>Sub Total</strong></td>
								<td>' . CUR . $db->num($row_order['sub_total']) . '</td>
								<td><strong>Tax</strong></td>
								<td>' . CUR. $db->num($row_order['tax']) . '</td>
							</tr>
							<tr>
								<td><strong>Shipping</strong></td>
								<td>' . CUR . $db->num($row_order['shipping']) . '</td>
								<td><strong>Grand Total</strong></td>
								<td>' . CUR . $db->num($row_order['grand_total']) . '</td>
							</tr>
						</table>
					</td>
				</tr> 
				<tr>
					<td>
						<table width="100%" cellpadding="5" style="border: 1px solid #ccc; background-color: #f7f7f7;">
						<thead>
							<tr>
								<th width="50%" align="left">Billing Details</th>
								<th width="50%" align="left">Shipping Details</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>' . $billing_first_name . ' ' . $billing_last_name . '</td>
								<td>' . $shipping_first_name . ' ' . $shipping_last_name . '</td>
							</tr>
							<tr>
								<td>' . $billing_address;
							if( !empty($billing_address2) && !is_null($billing_address2) )
								$body .= '<br />' . $billing_address2;
							$body .= ' 
								</td>
								<td>' . $shipping_address;
							if( !empty($shipping_address2) && !is_null($shipping_address2) )
								$body .= '<br />' . $shipping_address2;
							$body .= ' 
								</td>
							</tr>
							<tr>
								<td>' . $billing_city . ', ' . $db->getValue('states', 'name', 'id=' .$billing_state) . '</td>
								<td>' . $shipping_city . ', ' . $db->getValue('states', 'name', 'id=' .$shipping_state) . '</td>
							</tr>
							<tr>
								<td>' . $billing_country . ', ' . $billing_zipcode . '</td>
								<td>' . $shipping_country . ', ' . $shipping_zipcode . '</td>
							</tr>
							<tr>
								<td>Email: <strong>' . $billing_email . '</strong></td>
								<td>Email: <strong>' . $shipping_email . '</strong></td>
							</tr>
							<tr>
								<td>Phone: <strong>' . $billing_phone . '</strong></td>
								<td>Phone: <strong>' . $shipping_phone . '</strong></td>
							</tr>
						</tbody>
						</table>
					</td>
				</tr> 
				<tr>
					<td>
						<table width="100%" cellpadding="5" cellspacing="0" style="border: 1px solid #ccc; padding:5px;">
							<thead>
								<tr style="background-color: #e0e0e0;">
									<th width="8%" align="left" style="border-bottom: 1px solid #ccc;">#</th>
									<th width="15%" align="left" style="border-bottom: 1px solid #ccc;">Image</th>
									<th width="30%" align="left" style="border-bottom: 1px solid #ccc;">Product Name</th>
									<th width="10%" align="right" style="border-bottom: 1px solid #ccc;">Price</th>
									<th width="10%" align="right" style="border-bottom: 1px solid #ccc;">Qty</th>
									<th width="10%" align="right" style="border-bottom: 1px solid #ccc;">Tax</th>
									<th width="10%" align="right" style="border-bottom: 1px solid #ccc;">Subtotal</th>
									<th width="15%" align="right" style="border-bottom: 1px solid #ccc;">Total</th>
								</tr>
							</thead>
							<tbody>';
						$n = count($ardetail);
						for( $i=0; $i<$n; $i++ )
						{										
							$tt = $db->num($ardetail[$i]['sub_total']);
							$tax = $db->num(($tt * TAX_RATE) / (100 + TAX_RATE) );
							$tt = $db->num($tt - $tax);

							$body .= '<tr>
								<td style="width: 100px; border-bottom: 1px solid #ccc;">' . ($i+1) . '</td>
								<td align="left" style="width: 100px; border-bottom: 1px solid #ccc;"><img src="' . SITEURL . PRODUCT . $ardetail[$i]['image_path'] . '" style="width:70px;" /></td>
								<td style="width: 200px; border-bottom: 1px solid #ccc;"><strong>' . $ardetail[$i]['product_name'] . '</strong><br /><span>Color: ' . $ardetail[$i]['color'] . '</span><br /><span>Size: ' . $ardetail[$i]['size'] . '</span></td>
								<td align="right" style="width: 75px; border-bottom: 1px solid #ccc;">' . CUR.$db->num($ardetail[$i]['price']) . '</td>
								<td align="right" style="width: 75px; border-bottom: 1px solid #ccc;">' . $ardetail[$i]['qty'] . '</td>
								<td align="right" style="width: 75px; border-bottom: 1px solid #ccc;">' . CUR.$db->num($tax) . '</td>
								<td align="right" style="width: 75px; border-bottom: 1px solid #ccc;">' . CUR.$db->num($tt) . '</td>
								<td align="right" style="width: 75px; border-bottom: 1px solid #ccc;">' . CUR.$db->num($ardetail[$i]['sub_total']) . '</td>
							</tr>';
						}
				$body .= '	</tbody>
						</table>
					</td>
				</tr> 
				<tr>
					<td>
						Kind Regards, <br />
						<strong>' . SITETITLE . '</strong> Team.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>