<?php
    include 'connect.php';
    include("include/notification.class.php");

    $name = '';
    $email = '';
    $password = '';


    if (isset($_POST['signup_submit'])) 
    {
        $name           = $db->clean($_REQUEST['name']);
        $email          = $db->clean($_REQUEST['email']);
        $password       = $db->clean($_REQUEST['password']);
        $confirmation_string = $db->generateRandomString(8);

        if (isset($name) && $name != "" && isset($email) && $email != "" && isset($password) && $password != "") 
        {
            $check_user_r = $db->dupCheck("user","email = '".$email."' AND isDelete=0");

            if($check_user_r)
            {
                $_SESSION['MSG'] = "Duplicate";
                $db->location(SITEURL.'sign-up/');
            }
            else
            {
                $user_arr = array(
                    "name"                 => $name,
                    "email"                 => $email,
                    "password"              => md5($password),
                    "confirmation_string"   => $confirmation_string,
                );
                $u_id = $db->insert("user", $user_arr);

                if($u_id != '')
                {
                    if( ISMAIL )
                    {
                        $subject = SITENAME." : Activate Account";
                        $nt = new Notification();
                        include("mailbody/signup_str.php");
                        // die($body);
                        $toemail = $email;
                        $nt->sendEmail($toemail, $subject, $body);
                    }
                    $_SESSION['MSG'] = "Success_Signup";
                    $db->location(SITEURL."login/");
                }   
                $_SESSION['MSG'] = "Inserted";
                $db->location(SITEURL.'login/');    
            }
        }
        else
        {
            $_SESSION['MSG'] = "FILL_ALL_DATA";
            $db->location(SITEURL.'sign-up/');
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
        <!-- login section start  -->

         <section class="login-section">
                <div class="container">
                    <div class="section-header text-center mb-2">
                        <h1>Sign Up</h1>
                    </div>
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8">
                            <form class="contact-form" name="sign_up_form" id="sign_up_form" method="post" action=".">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" name="name" id="name" >
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="email" id="email" >
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" id="password" minlength="6" maxlength="8">
                               </div>
                                <div class="form-group form-check login-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">I agree to the Terms & Conditions </label>
                                </div>
                                <div class="form-group">
                                    <button class="w-100 Sign_Up-btn" name="signup_submit" type="submit">Sign Up</button>
                                </div>
                                <div class="form-group">
                                    <div class="creat-account">
                                        <p>Already have an Account? <a href="<?php echo SITEURL; ?>login/">Sign In</a></p>
                                    </div>
                                 </div>
                            </form>
                        </div>
                    </div>
                </div>
         </section>


        <!-- login section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>

        <script type="text/javascript">
        
            $("#sign_up_form").validate({
                rules: {
                    name:{required : true},
                    email:{required : true, email: true},
                    password:{required : true},
                    flexCheckDefault:{required: true}
                },
                messages: {
                    name:{required:"Please enter name."},
                    email:{required:"Please enter email address.", email:"please enter valid email."},
                    password:{required:"Please enter password."},
                    flexCheckDefault:{required: "Please check terms & conditions."}
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script>
    </body>
</html>
