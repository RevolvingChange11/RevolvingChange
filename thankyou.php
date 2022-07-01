<?php
    include 'connect.php';
    $db->checkLogin();


    $course_id = $db->clean($_REQUEST['item_name']);
    $getCourse_rs = $db->getData("course", "*", "isDelete=0 AND id=".$course_id);
    $getCourse_d = mysqli_fetch_assoc($getCourse_rs);

    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $amount = $db->clean($_REQUEST['amt']);
    $transaction_id = $db->clean($_REQUEST['txn_id']);
    
    $status_check = $db->clean($_REQUEST['payment_status']);
    if($status_check == 'Completed' )
        $status = "1";

    $purc_arr = array(
        "user_id"       => $user_id,
        "course_name"   => $getCourse_d['name'],
        "amount"        => $amount,
        "payment_method"=> 2,
        "transaction_id"=> $transaction_id,
        "status"        => $status,
        "purchase_date" => date("Y-m-d H:i:s"),
        "course_id"     => $getCourse_d['id'],
    );

    $check_transaction = $db->getValue("purchase_history","transaction_id","isDelete=0 AND user_id=".$user_id);
    if( !empty($check_transaction) && $check_transaction != "" )
    {
        $db->insert("purchase_history",$purc_arr);
    }

    $_SESSION['MSG'] = "PAY_SUCCESS";
    $db->location(SITEURL.'payment/'.$course_id.'/');
    exit;
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include "front_include/css.php"; ?>
    </head>

    <body>
        <?php include "front_include/header.php"; ?>        
        <!-- login section start  -->

        <section class="login-section">
            <div class="container">
                <div class="section-header text-center mb-2">
                    <h1>Thank you for your payment.</h1>
                </div>
            </div>
        </section>

        <!-- login section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>

    </body>
</html>
