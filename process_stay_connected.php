<?php 
	include 'connect.php';
    include("include/notification.class.php");

    $name = '';
    $email = '';
    $flexCheckDefault=0;
    $flexCheckChecked=0;
    
	if (isset($_POST['stay_connected_submit'])) 
    {
        $name           = $db->clean($_REQUEST['name']);
        $email          = $db->clean($_REQUEST['email']);
        if(isset($_POST['flexCheckDefault'])) 
        {
        	$flexCheckDefault = $db->clean($_REQUEST['flexCheckDefault']);
        }
        if(isset($_POST['flexCheckChecked'])) 
        {
        	$flexCheckChecked  = $db->clean($_REQUEST['flexCheckChecked']);
        }

        if (isset($name) && $name != "" && isset($email) && $email != "") 
        {
            $check_stay_connected_r = $db->dupCheck("stay_connected","email = '".$email."' AND isDelete=0");

            if($check_stay_connected_r)
            {
                $_SESSION['MSG'] = "Duplicate";
                $db->location(SITEURL);
            }
            else
            {
                $stay_connected_arr = array(
                    "name"                 => $name,
                    "email"                => $email,
                    "opt_out"              => 0,
                    "is_communications	"  => $flexCheckDefault,
                    "is_terms"             => $flexCheckChecked,
                    
                );
                $stay_connected_id = $db->insert("stay_connected", $stay_connected_arr);
                if($stay_connected_id)
                {
                	$_SESSION['MSG'] = "GET_NOTIFICATION";
                	$db->location(SITEURL);
                }
            }

                
        }
        else
        {
            $_SESSION['MSG'] = "FILL_ALL_DATA";
            $db->location(SITEURL);
        }
    }
?>