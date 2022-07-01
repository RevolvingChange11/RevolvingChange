<?php
	include("connect.php");
	unset($_SESSION[SESS_PRE.'_SESS_USER_ID']);
	unset($_SESSION[SESS_PRE.'_SESS_USER_NAME']);
	unset($_SESSION[SESS_PRE.'_SESS_USER_EMAIL']);

	unset($_SESSION['MSG']);

	$db->location(SITEURL.'login/');
	exit;
?>