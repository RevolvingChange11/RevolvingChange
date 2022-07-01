<?php
	include("connect.php");
	$ctable = "cart";
	$ctable1 = "Order";
	$page = "order";

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
					name like '%".$_REQUEST['searchName']."%' OR
					order_no like '%".$_REQUEST['searchName']."%' OR
					order_date like '%".$_REQUEST['searchName']."%' OR
					grand_total like '%".$_REQUEST['searchName']."%'
		) AND ";
	}

	$ctable_where .= "cart.isDelete=0";
	$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
		$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$get_total_rows = $db->getTotalRecord($ctable,$ctable_where); //hold total records in variable

	//break records into pages
	$total_pages = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r = $db->getJoinData($ctable, 'employee', 'employee.id='.$ctable.'.employee_id', $ctable.'.*, employee.name', $ctable_where, $ctable.".id DESC LIMIT $page_position, $item_per_page");
	//$ctable_r = $db->getJoinData($ctable, 'employee', 'employee.id='.$ctable.'.employee_id', '*', $ctable_where, $ctable.".id DESC LIMIT $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
		?>
		<table id="example" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
					<th>No.</th>
					<th>Order #</th>
					<th>Employee</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(@mysqli_num_rows($ctable_r)>0){
					$count = 0;
					while($ctable_d = @mysqli_fetch_assoc($ctable_r)){
					$count++;
					?>
					<tr>
						<td><input type="checkbox" name="chkid[]" value="<?php echo $ctable_d['id']; ?>"></td>
						<td><?php echo $count+$page_position; ?></td>
						<td><?php echo $ctable_d['order_no']; ?></td>
						<td><?php echo $ctable_d['name']; ?></td>
						<td class="text-right"><?php echo CUR.$db->num($ctable_d['grand_total']); ?></td>
						<td><?php 
							switch( $ctable_d['order_status'] )
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
						<td><?php echo (!is_null($ctable_d['order_date']))?$db->date($ctable_d['order_date'], 'm/d/Y'):$db->date($ctable_d['adate'], 'm/d/Y'); ?></td>
						<td>
	                		<a style="color: #36b9cc;" href="<?php echo ADMINURL; ?>view-<?php echo $page; ?>/<?php echo $ctable_d['id']; ?>/" title="View"><i class="fa fa-eye"></i></a>
                    		<a style="color: #e74a3b;"  onClick="del_conf('<?php echo $ctable_d['id']; ?>');" title="Delete"><i class="fa fa-times"></i></a>
    					</td>
					</tr>
					<?php
					}
				}
				?>
			</tbody>
		</table>
		<?php 
			$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);			
		?>
</form>
