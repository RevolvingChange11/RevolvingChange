<?php
    include "connect.php";
    require_once('stripe/init.php');
    $db->checkLogin();

    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $stripe = new \Stripe\StripeClient(STRIPE_TEST_PRIVATE_KEY);     
    if( strtolower(STRIPE_TEST_MODE) == 'off' ) 
        $stripe = new \Stripe\StripeClient(STRIPE_LIVE_PRIVATE_KEY);

    $course_id = $db->clean($_REQUEST['id']);
    // print_r($_REQUEST); exit;
    // course
    $course_rs = $db->getData("course","*","isDelete=0 AND id=".$course_id);
    $course_d = mysqli_fetch_assoc($course_rs);

    $card_name = '';
    $card_number = '';
    $card_month = '';
    $card_year = '';
    $card_cvv = '';

    if (isset($_REQUEST['payment_submit'])) 
    {

        $card_name = $db->clean($_REQUEST['card_name']);
        $card_number = $db->clean($_REQUEST['card_number']);
        $card_month = $_REQUEST['card_month'];
        $card_year = $_REQUEST['card_year'];
        $card_cvv = $_REQUEST['card_cvv'];
        
        try 
        {
            // CREATING TOKENS
            $card_token = $stripe->tokens->create([
                'card' => [
                    'number' => $card_number,
                    'exp_month' => $card_month,
                    'exp_year' => $card_year,
                    'cvc' => $card_cvv,
                ],
            ]);
            $card_token_id = $card_token->id; 

            $result     =   "success";
        
        } catch(\Stripe\CardError $e) {  
            $error = $e->getMessage();
            $result = $error;

        } catch (\Stripe\InvalidRequestError $e) {
            $error = $e->getMessage();
            $result = $error;  
        } catch (\Stripe\AuthenticationError $e) {
            $error = $e->getMessage();
            $result = $error;
        } catch (\Stripe\ApiConnectionError $e) {
            $error = $e->getMessage();
            $result = $error;
        } catch (\Stripe\Error $e) {
            $error = $e->getMessage();
            $result = $error;
        } catch (Exception $e) {
          

            if ($e->getMessage() == "zip_check_invalid") {
              $result = "declined1";
            } else if ($e->getMessage() == "address_check_invalid") {
              $result = "decline2d";
            } else if ($e->getMessage() == "cvc_check_invalid") {
              $result = "declined3";
            } else {
              $result = $e->getMessage();
            }
        }   

        $result = preg_replace("/'/", '', $result); 

        if($result == 'success')
        {
            $cut_charge = $stripe->charges->create([
                'amount' => (int)$course_d['price'] * 100,
                'currency' => 'usd',
                'source' => $card_token_id,
                'description' => 'My First Test Charge (created for API docs)',
            ]);

            $amount = $cut_charge->amount/100;
            $transaction_id = $cut_charge->balance_transaction;
            
            $status_check = $cut_charge->status;
            if ($status_check) 
                $status = "1";

            $purc_arr = array(
                "user_id"       => $user_id,
                "course_name"   => $course_d['name'],
                "amount"        => $amount,
                "payment_method"=> 1,
                "transaction_id"=> $transaction_id,
                "status"        => $status,
                "purchase_date" => date("Y-m-d H:i:s"),
                "course_id"     => $course_d['id'],
            );

            $db->insert("purchase_history",$purc_arr);

            $_SESSION['MSG'] = "PAY_SUCCESS";
            $db->location(SITEURL.'payment/'.$course_id.'/');
            exit;
        }
        else
        {
            $_SESSION['MSG'] = $result;
            $db->location(SITEURL.'payment/'.$course_id.'/');
            exit;
        }
    }

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

        <!-- payment section start  -->

        <section class="payment-section pt-100 pb-100">
             <div class="container">
                 <div class="row">
                       <div class="offset-lg-2 col-lg-8">
                        <div class="payment-box-sec">
                            <ul class="parentClass">
                                <li>
                                    <label>
                                        <input type="radio" value="" name="anything" class="radioCls" id="yes" checked>Stripe
                                    </label>
                                    <label>
                                        <input type="radio" value="" name="anything" class="radioCls" id="no">PayPal
                                    </label>
                                </li>
                            </ul>
                            <div class="paymentData" id="stripe">
                                <input type="hidden" name="course_id" id="course_id" value="<?=$course_d['id']?>">
                                <form class="payment-form" name="payment_form" id="payment_form" method="post" action="."> 
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Card Name *</label>
                                                <input class="form-control" type="text" name="card_name" id="card_name" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Card Number *</label>
                                                <input class="form-control" type="text" name="card_number" id="card_number" placeholder="Number" maxlength="16">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>EXPIRY (MM/YY) *</label>
                                                <div class="date-select">
                                                    <select name="card_month" id="card_month" class="">
                                                        <?php for ($mon=1; $mon <=12 ; $mon++) { ?>
                                                        <option value="<?=str_pad($mon,2,0,STR_PAD_LEFT)?>"><?=str_pad($mon,2,0,STR_PAD_LEFT)?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <select name="card_year" id="card_year" class="">
                                                        <?php
                                                            $cur_yer = date('Y');
                                                            $end_yer = date('Y', strtotime('+10 year'));
                                                            for ($yr=$cur_yer; $yr <$end_yer ; $yr++) { 
                                                        ?>
                                                            <option value="<?=$yr?>"><?=$yr?></option>
                                                        <?php } ?>
                                                    </select>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>CARD CODE *</label>
                                                <input class="form-control" type="number" name="card_cvv" id="card_cvv" placeholder="CVC/CVV">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="submit">
                                                 <button class="submit-btn" name="payment_submit" type="submit" value="submit">SUBMIT</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="paymentData " id="paypal" onclick="paypal_payment()">
                                 <div class="paypal-box">
                                      <a href="javascript:void(0);"><img src="<?php echo SITEURL; ?>images/home/paypal_checkout.jpg"></a>
                                 </div>
                            </div>
                    </div>
                </div>
                </div>
             </div>
        </section>

        <!-- payment section end  -->

        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>     
        <div id="paypal_frm_submit"></div>


        <script>
            $(document).ready(function(){
                //after load will check the checkbox is checked or not
                var check = $("#yes").prop("checked");
                if(check){
                    $("#stripe").addClass("activeTab");
                }
                
                //click on yes
                $("#yes").on("click", function(){
                    check = $(this).prop("checked");
                    $("#paypal").removeClass("activeTab");
                    $("#stripe").addClass("activeTab");
                    
                })
                //click on No
                $("#no").on("click", function(){
                    check = $(this).prop("checked");
                    $("#stripe").removeClass("activeTab");
                    $("#paypal").addClass("activeTab");
                    console.log(check);
                })
            });


            $("#payment_form").validate({
                rules:{
                    card_name:{required:true},   
                    card_number:{required:true},   
                    card_month:{required:true},   
                    card_year:{required:true},   
                    card_cvv:{required:true},   
                },
                messages:{
                    card_name:{required:"Please enter card holder name."},   
                    card_number:{required:"Please enter card number."},   
                    card_month:{required:"Please enter card month."},   
                    card_year:{required:"Please enter card year."},   
                    card_cvv:{required:"Please enter CVV number."}, 
                },
                errorPlacement: function(error, element)
                {
                    error.insertAfter(element);
                },
            })

            function paypal_payment()
            {
                var course_id = $("#course_id").val();

                $.ajax({
                    url     : "<?php echo SITEURL; ?>paypal_checkout.php",
                    type    : "post",
                    dataType: 'json',
                    data : {
                        course_id:course_id
                    },
                    success: function(res)
                    {
                        // $(".loading-div").addClass("hide");
                        $("#paypal_frm_submit").html(res);
                        setTimeout(function(){ 
                            document.frmPayPal.submit();
                        }, 1000);
                    }
                });
            }
        </script>

    </body>
</html>
