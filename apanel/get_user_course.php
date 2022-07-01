<?php
	include("connect.php");
	$ctable 	= "purchase_history";
	$ctable1 	= "Course";
	$page 		= "user_course";

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
					course_name like '%".$_REQUEST['searchName']."%'
					
		) AND ";
	}

	$ctable_where .= "isDelete=0 AND user_id=".$_REQUEST['user_id']."";
	$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
		$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$get_total_rows = $db->getTotalRecord($ctable,$ctable_where); //hold total records in variable

	//break records into pages
	$total_pages   = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr       = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r      = $db->getData($ctable,"*",$ctable_where,"id DESC limit $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			//$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
		?>
		<table id="example" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					<th>No.</th>
					<th>Course</th>
					<th>Module</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(@mysqli_num_rows($ctable_r)>0){
					$count = 0;
					while($ctable_d = @mysqli_fetch_assoc($ctable_r)){
					
					$get_module=$db->getData("module","*","course_id=".$ctable_d['course_id']." AND isdelete=0");
						while($module_row=mysqli_fetch_assoc($get_module))
						{$count++;
							?>
							<tr>
								<td><?php echo $count+$page_position; ?></td>
								<td><?php echo $ctable_d['course_name']; ?></td>
								<td><?php echo $module_row['name']; ?></td>
								
								
								<td>
									<a style="color: #36b9cc;" href="<?php echo ADMINURL; ?>Manage-User-Lesson/<?php echo $module_row['id']; ?>/<?php echo $_REQUEST['user_id']?>" title="Lesson"><i class="fa fa-list"></i></a>
			                		
		    					</td>
							</tr>
							<?php
						}
					}
				}
				?>
			</tbody>
		</table>
		<?php 
			//$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);			
		?>
</form>
