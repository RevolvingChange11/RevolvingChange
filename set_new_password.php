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
        <header class="site-header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#"><img src="<?php echo SITEURL ?>images/logo/main-logo.png" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </nav>
            </div>
        </header>
         <section class="login-section">
                <div class="container">
                    <div class="section-header text-center mb-2">
                        <h1>Set New Password</h1>
                    </div>
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8">
                            <form class="contact-form" method="post" name="login_form" id="login_form" action="<?php echo SITEURL; ?>process-set-new-password/">
                                <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                                <input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>">

                                <div class="form-group">
                                    <label>New Password <code>*</code></label>
                                    <input class="form-control" type="password" name="new_password" id="new_password" minlength="6" maxlength="8">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password <code>*</code></label>
                                    <input class="form-control" type="password" name="cnew_password" id="cnew_password" minlength="6" maxlength="8">
                                </div>
                                <div class="form-group">
                                    <button class="w-100 Sign_Up-btn" type="submit" name="reset_submit" id="reset_submit">Reset Password</button>
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
                    new_password:{required : true},
                    cnew_password:{required : true, equalTo:"#new_password"},
                },
                messages: {
                    new_password:{required:"Enter new password.",},
                    cnew_password:{required:"Enter confirm password.", equalTo:"Password not match."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script> 
    </body>
</html>
