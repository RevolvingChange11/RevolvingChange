<?php
    include "connect.php";

    if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] !="")
        $db->location(SITEURL);
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
                        <h1>Log In</h1>
                    </div>
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8">
                            <form class="contact-form" method="post" name="login_form" id="login_form" action="<?php echo SITEURL; ?>process-login/">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="email" id="email" >
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" id="password" minlength="6" maxlength="8">
                               </div>
                                <div class="form-group form-check login-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Remember Me </label>
                                </div>
                                <div class="form-group">
                                    <button class="w-100 Sign_Up-btn" type="submit" name="login_submit" id="login_submit">SUBMIT</button>
                                </div>
                                <div class="form-group login-below-link">
                                     <!-- <a href="<?php echo SITEURL; ?>forgot-password/">Forgot Password ?</a> -->
                                    <p class=" mt-3 mb-0">Don't have an account? <a href="<?php echo SITEURL ?>sign-up/">Sign Up</a></p>
                                    <p class=" mt-3 mb-0 ml-auto text-sm-right"><a href="<?php echo SITEURL ?>forgot-password/">Forgot Password</a></p>
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
            $("#login_form").validate({
                rules: {
                    email:{required : true, email: true},
                    password:{required : true},
                },
                messages: {
                    email:{required:"Please enter email address.", email:"please enter valid email."},
                    password:{required:"Please enter password."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script> 
    </body>
</html>
