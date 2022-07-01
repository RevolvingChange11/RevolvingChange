<?php
	include("connect.php");
	$ctable 	= "product_alt_image";
	$ctable1 	= "Product Alternate Images";
	$page 		= "alt-image";

	$product_id = 0;
	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['product_id']) && $_REQUEST['product_id']!=""){
		$ctable_where .= "product_id=".$_REQUEST['product_id']." AND ";
		$product_id = $_REQUEST['product_id'];
	}

	$ctable_where .= "isDelete=0";
	$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
		$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$get_total_rows = $db->getTotalRecord($ctable, $ctable_where); //hold total records in variable

	//break records into pages
	$total_pages   = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr       = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r      = $db->getData($ctable, "*", $ctable_where, "id DESC limit $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1, ADMINURL.'add-'.$page.'/add/'.$product_id.'/');
		?>
		<table id="example" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
					<th>No.</th>
					<th>Image</th>
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
						<td><img src="<?php echo SITEURL . PRODUCT . $ctable_d['image_path']; ?>" style="width:100px; height:100px;"></td>
						<td>
	                		<a style="color: #36b9cc;" href="<?php echo ADMINURL; ?>add-<?php echo $page; ?>/edit/<?php echo $product_id; ?>/<?php echo $ctable_d['id']; ?>/" title="Edit"><i class="fa fa-edit"></i></a>
                    		<a style="color: #e74a3b;" onClick="del_conf('<?php echo $ctable_d['id']; ?>');" title="Delete"><i class="fa fa-times"></i></a>
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
			$db->getAddButton($page, $ctable1, ADMINURL.'add-'.$page.'/add/'.$product_id.'/');
			$db->getTablePaginationBlock($pagiArr);			
		?>
</form>
