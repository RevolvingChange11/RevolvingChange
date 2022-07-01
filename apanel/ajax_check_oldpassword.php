<?php 
include("connect.php");

$oldpassword = $db->clean($_POST['oldpassword']);

if($oldpassword!="")
{
	$check_dup = $db->getData("admin",'id'," password = '".md5($oldpassword)."' AND id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']);

	if(@mysqli_num_rows($check_dup) > 0)
	{
		echo json_encode(true);
	}
	else
	{
		echo json_encode(false);
	}
}
else
{
	echo json_encode(false);
}

?>