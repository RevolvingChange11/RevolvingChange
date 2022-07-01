<?php
	class Cart extends Functions
	{
		public function generateOrderNumber($cart_id = 0 )
		{
			$max = 0;
			if( $cart_id <= 0 )
			{
				$max = $this->getValue('cart', 'MAX(id)', 'isDelete=0');
				$max++;
			}
			else
			{
				$max = $cart_id;
			}
			$n = 7 - strlen($max);
			for($i=0; $i<$n; $i++)
				$max = '0' . $max;
			return 'FXTL-'.$max;
		}

		public function items_in_cart( $cart_id )
		{
			return (int) $this->getValue('cart_detail', 'COUNT(*)', 'cart_id=' . (int) $cart_id . ' AND isDelete=0');
		}

		public function add_to_cart($user_id, $product_id, $color_id, $size_id, $qty)
		{
			$cart_id = 0;
			$cart_detail_id = 0;

			if( isset($_SESSION[SESS_PRE.'_SESS_CART_ID']) && $_SESSION[SESS_PRE.'_SESS_CART_ID'] > 0 )
			{
				$cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
			}
			else
			{
				//New cart
				/* Order Status : 0=Cancelled, 1=In Progress, 2=Completed, 3=Shipped, 4=Delivered */
				$order_no = $this->generateOrderNumber();
				$rows = array(
							  'employee_id' => $user_id,
							  'order_status' => 1, 
							  'order_no' => $order_no, 
						);
				$cart_id = $this->insert('cart', $rows);
				$_SESSION[SESS_PRE.'_SESS_CART_ID'] = $cart_id;
			}

			// check existing cart for similar product
			$cart_detail_id = $this->getValue('cart_detail', 'id', 'cart_id='. (int) $cart_id . ' AND product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id . ' AND isDelete=0');
			if( $cart_detail_id > 0 )
			{
				// edit qty for existing product on the cart
				$existing_qty = (int) $this->getValue('cart_detail', 'qty', 'id=' . (int) $cart_detail_id);
				$qty += $existing_qty;

				$price = $this->getValue('product_price', 'price', 'product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id . ' AND isDelete=0');
				$product_total = $this->num($price * $qty);

				$rows = array(
					'cart_id' => $cart_id, 
					'product_id' => $product_id, 
					'color_id' => $color_id, 
					'size_id' => $size_id, 
					'qty' => $qty, 
					'price' => $price, 
					'sub_total' => $product_total, 
				);
				$this->update('cart_detail', $rows, 'id=' . (int) $cart_detail_id);
			}
			else
			{
				$price = $this->getValue('product_price', 'price', 'product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id . ' AND isDelete=0');
				$product_total = $this->num($price * $qty);

				// add product to the cart
				$rows = array(
					'cart_id' => $cart_id, 
					'product_id' => $product_id, 
					'color_id' => $color_id, 
					'size_id' => $size_id, 
					'qty' => $qty, 
					'price' => $price, 
					'sub_total' => $product_total, 
				);
				$cart_detail_id = $this->insert('cart_detail', $rows);
			}

			// update cart master table
			$this->update_cart_total($cart_id);
		}

		public function remove_from_cart($cart_id, $product_id, $color_id, $size_id)
		{
			$rows = array('isDelete' => 1);
			$this->update('cart_detail', $rows, 'cart_id=' . (int) $cart_id . ' AND product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id);

			// update cart master table
			$this->update_cart_total($cart_id);
		}

		public function update_quantity($cart_id, $product_id, $color_id, $size_id, $qty)
		{
			$price = $this->getValue('product_price', 'price', 'product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id . ' AND isDelete=0');
			$product_total = $this->num($price * $qty);

			$rows = array(
					'qty' => $qty, 
					'sub_total' => $product_total, 
				);
			$this->update('cart_detail', $rows, 'cart_id=' . (int) $cart_id . ' AND product_id=' . (int) $product_id . ' AND color_id=' . (int) $color_id . ' AND size_id=' . (int) $size_id);

			// update cart master table
			$this->update_cart_total($cart_id);
		}

		public function update_cart_total($cart_id)
		{
			/*$subtotal = $this->getValue('cart_detail', 'SUM(sub_total)', 'cart_id=' . (int)$cart_id . ' AND isDelete=0');
			$subtotal = $this->num($subtotal);
			$tax = $this->num(($subtotal * TAX_RATE) / 100);
			$grandtotal = $this->num($subtotal + $tax);*/

			$grandtotal = $this->getValue('cart_detail', 'SUM(sub_total)', 'cart_id=' . (int)$cart_id . ' AND isDelete=0');
			$grandtotal = $this->num($grandtotal);
			$tax = $this->num(($grandtotal * TAX_RATE) / (100 + TAX_RATE) );
			$subtotal = $this->num($grandtotal - $tax);

			$rows = array(
					'sub_total' => $subtotal, 
					'tax_rate' => TAX_RATE, 
					'tax' => $tax, 
					'grand_total' => $grandtotal, 
				);
			$this->update('cart', $rows, 'id=' . (int) $cart_id);
		}

		public function MultiSort($data, $sortCriteria, $caseInSensitive = true)
		{
		  if( !is_array($data) || !is_array($sortCriteria))
		    return false;      
		  $args = array();
		  $i = 0;
		  foreach($sortCriteria as $sortColumn => $sortAttributes) 
		  {
		    $colList = array();
		    foreach ($data as $key => $row)
		    {
		      $convertToLower = $caseInSensitive && (in_array(SORT_STRING, $sortAttributes) || in_array(SORT_REGULAR, $sortAttributes));
		      $rowData = $convertToLower ? strtolower($row[$sortColumn]) : $row[$sortColumn];
		      $colLists[$sortColumn][$key] = $rowData;
		    }
		    $args[] = &$colLists[$sortColumn];
		     
		    foreach($sortAttributes as $sortAttribute)
		    {     
		      $tmp[$i] = $sortAttribute;
		      $args[] = &$tmp[$i];
		      $i++;     
		     }
		  }
		  $args[] = &$data;
		  call_user_func_array('array_multisort', $args);
		  return end($args);
		}

		public function getAustraliaPostAccountInfo()
		{
			global $url, $headers;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				  CURLOPT_URL => $url."accounts/".ACNO_EPARCEL_INTERNATIONAL, 
				  CURLOPT_HTTPHEADER => $headers,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_CUSTOMREQUEST => "GET",
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;
			$response = json_decode($response);
			//print '<pre>'; print_r($response);

			$products = $response->postage_products;
			$arprod = array();
			foreach ($products as $product) {
				/* 
					3K55, 7E55 - TestBed ids
					3J85, 3D85 - Production ids
				*/
				if( $product->product_id == '3K55' || $product->product_id == '7E55' || $product->product_id == '3J85' || $product->product_id == '3D85' )
				{
					$row = array(
							'product_id' => $product->product_id, 
							'name' => $product->type, 
							'rate' => $product->features->TRANSIT_COVER->attributes->rate, 
							'included_cover' => $product->features->TRANSIT_COVER->attributes->included_cover, 
							'maximum_cover' => $product->features->TRANSIT_COVER->attributes->maximum_cover, 
							'calculated_gst' => $product->features->TRANSIT_COVER->price->calculated_gst, 
							'calculated_price' => $product->features->TRANSIT_COVER->price->calculated_price, 
							'calculated_price_ex_gst' => $product->features->TRANSIT_COVER->price->calculated_price_ex_gst, 
							'valid_from' => $product->contract->valid_from, 
							'valid_to' => $product->contract->valid_to, 
							'expired' => $product->contract->expired, 
						);
					array_push($arprod, $row);
				}
			}
			//$arprod = asort($arprod);
			//$arprod = array_multisort(array_column($arprod, 'key'), SORT_DESC, $arprod);
 
			//Set the sort criteria (add as many fields as you want)
			$sortCriteria =
			  array('name' => array(SORT_ASC),
			       'rate' => array(SORT_DESC, SORT_NUMERIC)
			  );
			$arprod = $this->MultiSort($arprod, $sortCriteria, true);
			//print '<pre>'; print_r($arprod);	
			return $arprod;
		}

		public function getItemPrice($cart_id, $method)
		{
			global $url, $headers;

			$from_zipcode = COMPANY_ZIPCODE;
			$to_zipcode = $this->getValue('billing_shipping', 'shipping_zipcode', 'cart_id='.$cart_id);

			$arfrom = array('postcode' => $from_zipcode);
			$arto = array('postcode' => $to_zipcode);
			$aritems = array();

			$join = ' LEFT JOIN product p ON p.id = cd.product_id';
			$rows = 'cd.qty, p.name, p.height, p.width, p.length, p.weight';
			$where = 'cd.cart_id = 1 AND cd.isDelete=0';
			$rs = $this->getJoinData2('cart_detail cd', $join, $rows, $where);
			while( $row = @mysqli_fetch_assoc($rs) )
			{
				$item = array(
					'length' => $row['length'],
					'height' => $row['height'], 
					'width' => $row['width'], 
					'weight' => $row['weight'], 
					'item_reference' => $row['name'], 
			        'features' => array('TRANSIT_COVER' => array('attributes' => array('cover_amount' => $row['qty']))),
				);
				array_push($aritems, $item);
			}

			$arjson = array('from' => $arfrom, 'to' => $arto, 'items' => $aritems);
			$json = json_encode($arjson);
			//echo $json;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				  CURLOPT_URL => $url."prices/items", 
				  CURLOPT_HTTPHEADER => $headers,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_SSL_VERIFYHOST => false,
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_POST => count($arjson),
				  CURLOPT_POSTFIELDS => $json,
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;
			$response = json_decode($response);
			//print '<pre>'; print_r($response);

			//echo '====' . $method . '====';
			$arprice = array();
			foreach ($response->items as $item) 
			{
				$arprice = $item->prices;
				foreach ($arprice as $price) 
				{
					//echo $price->product_type . '<br />';
					if( $price->product_id == $method )
					{
						$feature = $price->features->TRANSIT_COVER;
						$arp = array(
								'calculated_gst' => $price->calculated_gst, 
								'calculated_price' => $price->calculated_price, 
								'calculated_price_ex_gst' => $price->calculated_price_ex_gst, 
								'bundled_price' => $price->bundled_price, 
								'bundled_price_ex_gst' => $price->bundled_price_ex_gst, 
								'bundled_gst' => $price->bundled_gst, 
								'cover_rate' => $feature->attributes->rate, 
								'cover_amount' => $feature->attributes->cover_amount, 
								'cover_gst' => $feature->price->calculated_gst, 
								'cover_price' => $feature->price->calculated_price, 
								'cover_price_ex_gst' => $feature->price->calculated_price_ex_gst, 
							);
						array_push($arprice, $arp);
					}
				}
			}
			return $arprice;
		}

		public function getShipmentPrice($cart_id, $method)
		{
			global $url, $headers;

			$from_zipcode = COMPANY_ZIPCODE;
			$rs_to = $this->getData('billing_shipping', 'shipping_city, shipping_state, shipping_zipcode', 'cart_id='.$cart_id);
			$row_to = @mysqli_fetch_assoc($rs_to);
			//$to_city = $this->getValue('city', 'name', 'id='.$row_to['shipping_city']);
			$to_city = $row_to['shipping_city'];
			$to_state = $this->getValue('states', 'code', 'id='.$row_to['shipping_state']);
			$to_zipcode = $row_to['shipping_zipcode'];

			$arfrom = array('suburb' => COMPANY_CITY, 'state' => COMPANY_STATE, 'postcode' => COMPANY_ZIPCODE);
			$arto = array('suburb' => $to_city, 'state' => $to_state, 'postcode' => $to_zipcode);

			//print '<pre>'; print_r($arfrom); print_r($arto);

			$aritems = array();

			$join = ' LEFT JOIN product p ON p.id = cd.product_id';
			$rows = 'cd.qty, p.name, p.height, p.width, p.length, p.weight';
			$where = 'cd.cart_id = 1 AND cd.isDelete=0';
			$rs = $this->getJoinData2('cart_detail cd', $join, $rows, $where);
			while( $row = @mysqli_fetch_assoc($rs) )
			{
				$item = array(
					'product_id' => $method, 
					'length' => $row['length'],
					'height' => $row['height'], 
					'width' => $row['width'], 
					'weight' => $row['weight'], 
				);
				array_push($aritems, $item);
			}

			$shipment = array();
			$shipments = array('from' => $arfrom, 'to' => $arto, 'items' => $aritems);
			
			array_push($shipment, $shipments);
			$arjson = array('shipments' => $shipment);
			
			//print '<pre>'; print_r($shipments);
			$json = json_encode($arjson);
			//echo $json;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				  CURLOPT_URL => $url."prices/shipments", 
				  CURLOPT_HTTPHEADER => $headers,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_SSL_VERIFYHOST => false,
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_POST => count($arjson),
				  CURLOPT_POSTFIELDS => $json,
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;
			$response = json_decode($response);
			//print '<pre>'; print_r($response);

			//echo '====' . $method . '====';
			$price = $response->shipments[0]->shipment_summary;
			$row = array(
					'total_cost' => $price->total_cost, 
					'total_cost_ex_gst' => $price->total_cost_ex_gst, 
					'shipping_cost' => $price->shipping_cost, 
					'fuel_surcharge' => $price->fuel_surcharge, 
					'total_gst' => $price->total_gst, 
				);
			return $row;
		}

		public function validate_address($city, $state, $zipcode)
		{
			global $url, $headers;

			// sample
			// "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=Greensborough&state=VIC&postcode=3088"

			$state = $this->getValue('states', 'code', 'id='.$state);
			//$city = $this->getValue('city', 'name', 'id='.$city);
			$city = urlencode($city);

			$curl = curl_init();
			curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=".$city."&state=".$state."&postcode=".$zipcode, 
				  CURLOPT_HTTPHEADER => $headers,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_CUSTOMREQUEST => "GET",
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;
			$response = json_decode($response);
			//print '<pre>'; print_r($response);
			return $response->found;
		}

		public function getTrackingDetails($track_id)
		{
			global $url, $headers;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				  //CURLOPT_URL => "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=Greensborough&state=VIC&postcode=3088", 
				CURLOPT_URL => $url."track?tracking_ids=".$track_id, 
				  CURLOPT_HTTPHEADER => $headers,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_CUSTOMREQUEST => "GET",
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;

			$response = json_decode($response);
			//print '<pre>'; print_r($response);
			return $response;
		}
	}
	
?>