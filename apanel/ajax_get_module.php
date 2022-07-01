<?php
	include("connect.php");
	$ctable 	= "module";
	$ctable1 	= "Module";
	$page 		= "module";

	$course_id = 0;
	if( isset($_REQUEST['course_id']) && $_REQUEST['course_id'] > 0 )
		$course_id = (int) $_REQUEST['course_id'];

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
					m.name like '%".$_REQUEST['searchName']."%' OR
					m.short_desc like '%".$_REQUEST['searchName']."%'
		) AND ";
	}

	$ctable_where .= "m.isDelete=0";
	if( $course_id > 0 )
		$ctable_where .= " AND m.course_id = " . $course_id;
	$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
		$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$join = ' LEFT JOIN course c ON c.id = m.course_id';
	$fields = 'm.*, c.name AS course_name';

	$get_total_rows = $db->getTotalRecord_JoinData2($ctable . ' m', $join, $ctable_where); //hold total records in variable

	//break records into pages
	$total_pages   = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr       = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r      = $db->getJoinData2($ctable . ' m', $join, $fields, $ctable_where, "m.id DESC limit $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1);
		?>
		<table id="example" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
					<th>No.</th>
					<th>Name</th>
					<th>Course</th>
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
						<td><?php echo $ctable_d['name']; ?></td>
						<td><?php echo $ctable_d['course_name']; ?></td>
						<td>
	                		<a class="text-success" href="<?php echo ADMINURL; ?>manage-lesson/<?php echo $ctable_d['id']; ?>/" title="Lessons"><i class="fa fa-list"></i></a>
	                		<a class="text-info" href="<?php echo ADMINURL; ?>add-<?php echo $page; ?>/edit/<?php echo $ctable_d['id']; ?>/" title="Edit"><i class="fa fa-edit"></i></a>
                    		<a class="text-danger" onClick="del_conf('<?php echo $ctable_d['id']; ?>');" title="Delete"><i class="fa fa-times"></i></a>
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
			$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);			
		?>
</form>
