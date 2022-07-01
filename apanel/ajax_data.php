<?php
	include_once('connect.php');

	$mode = $_REQUEST['mode'];

	if( $mode == 'get_module' )
	{
		$course_id = $_REQUEST['course_id'];
		$where = 'isDelete=0';
		if( $course_id > 0 )
			$where .= ' AND course_id=' . (int) $course_id;
		$rs_c = $db->getData('module', 'id, name', $where, 'name');

		$str = '';
		$str .= '<select name="module_id" id="module_id" class="form-control">';
		$rs_c = $db->getData('module', 'id, name', $where, 'name');
		while( $row_c = @mysqli_fetch_assoc($rs_c) )
		{
			$str .= '<option value="'.$row_c['id'].'"';
			//if( $module_id == $row_c['id'] )
				$str .= ' selected';
			$str .= '>'.$row_c['name'].'</option>';
		}
		$str .= '</select>';
		echo $str;
		exit;
	}
	else if( $mode == 'remove_question' )
	{
		$question_id = (int) $_REQUEST['question_id'];

		$rows = array('isDelete' => 1);
		$db->update('question', $rows, 'id='.$question_id);
		exit;
	}
?>