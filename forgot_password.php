<?php
    include "connect.php";
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
                        <h1>Forgot Password</h1>
                    </div>
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8">
                            <form class="contact-form" method="post" name="forgot_pass_form" id="forgot_pass_form" action="<?php echo SITEURL ?>process-forgot-password/">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="email" id="email" >
                                </div>
                                <div class="form-group">
                                    <button class="w-100 Sign_Up-btn" type="submit" name="forgot_submit" id="forgot_submit">SEND LINK</button>
                                </div>
                                <div class="form-group">
                                    <!-- Already have logins? Click<a href="#">Forgot Password ?</a> -->
                                    <p class="mb-0">Already have logins? Click <a href="<?php echo SITEURL ?>login/">here.</a></p>
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
                },
                messages: {
                    email:{required:"Please enter email address.", email:"please enter valid email."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script> 
    </body>
</html>
