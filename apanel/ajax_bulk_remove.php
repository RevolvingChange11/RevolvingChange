<?php
    include("connect.php");
    $ctable  = $_REQUEST['hdndb'];
    $hdnmode = $_REQUEST['hdnmode'];
    //print_r($_REQUEST);
    if( $hdnmode == 'delete')
    {
        $ids = implode(',', $_REQUEST['chkid']);
        $rows = array('isDelete' => 1);
        $db->update($ctable, $rows, 'id IN (' . $ids . ')');
        $_SESSION['MSG'] = "Deleted";
    }

?>