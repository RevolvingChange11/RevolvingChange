<?php
	include("connect.php");
	$ctable 	= "pre_module_form";
	$ctable1 	= "Questions";
	$page 		= "user_question";

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
					lesson_id like '%".$_REQUEST['searchName']."%'
					
		) AND "; } 

		//print_r($_REQUEST); exit;

	$ctable_where .= "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$_REQUEST['user_id']. " AND submission_type=1";
	$ctable_where1 = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$_REQUEST['user_id']. " AND submission_type=3";
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
	$ctable_r1      = $db->getData($ctable,"*",$ctable_where1,"id DESC limit $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			//$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
		?>
		<b>Pre Answer</b>
		<table id="example" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					
					<th>No.</th>
					<th>Question</th>
					<th>Answer</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$count=0;
					if(@mysqli_num_rows($ctable_r)>0)
					{

						$ctable_d = @mysqli_fetch_assoc($ctable_r);
						$question_id=explode(",",$ctable_d['quetion_id']);
						$ans_id=explode(",",$ctable_d['answer_id']);
						$no_que=count($question_id);
						for($i=0;$i<$no_que;$i++)
						{	
							$count++;
							$question_res=$db->getData("question","*","id=".$question_id[$i]."");
							$que_data=mysqli_fetch_assoc($question_res);
							$answer_res=$db->getData("question_option","*","id=".$ans_id[$i]."");
							$ans_data=mysqli_fetch_assoc($answer_res);
						?>
							<tr>
								<td><?php echo $count+$page_position; ?></td>
								<td><?php echo $que_data['name']; ?></td>
								<td><?php echo $ans_data['option_value']; ?></td>
							</tr>
						<?php
						}
					}
				?>
			</tbody>
		</table>
		<b>Post Answer</b>
		<table id="example1" class="table table-striped table-bordered table-colored">
			<thead>
				<tr>
					
					<th>No.</th>
					<th>Name</th>
					<th>Answer</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$count=0;
					if(@mysqli_num_rows($ctable_r1)>0)
					{

						$ctable_d = @mysqli_fetch_assoc($ctable_r1);
						$question_id=explode(",",$ctable_d['quetion_id']);
						$ans_id=explode(",",$ctable_d['answer_id']);
						$no_que=count($question_id);
						for($i=0;$i<$no_que;$i++)
						{	
							$count++;
							$question_res=$db->getData("question","*","id=".$question_id[$i]."");
							$que_data=mysqli_fetch_assoc($question_res);
							$answer_res=$db->getData("question_option","*","id=".$ans_id[$i]."");
							$ans_data=mysqli_fetch_assoc($answer_res);
						?>
							<tr>
								<td><?php echo $count+$page_position; ?></td>
								<td><?php echo $que_data['name']; ?></td>
								<td><?php echo $ans_data['option_value']; ?></td>
							</tr>
						<?php
						}
					}
				?>
			</tbody>
		</table>
		
		<?php 
			//$db->getDeleteButton();
			//$db->getAddButton($page, $ctable1);
			//$db->getTablePaginationBlock($pagiArr);			
		?>
</form>
