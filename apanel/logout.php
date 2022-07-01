<?php
include("connect.php");
unset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']);
unset($_SESSION[SESS_PRE.'_ADMIN_SESS_NAME']);

$db->location(ADMINURL);
exit;	
?>