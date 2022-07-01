<?php

    include "connect.php";
	if($_REQUEST['userid'] && $_REQUEST['lesson_id'])
	{

        $update_stage = array(
            "submission_type"=> 4
        );
         $update_stage_res=$db->update("stage",$update_stage,"isDelete=0 AND user_id=".$_REQUEST['userid']." AND lesson_id=".$_REQUEST['lesson_id']."");

        $_SESSION['MSG'] = "Complete_Lesson";
        $db->location(SITEURL."library/");
    }
	
?>