<?php
    include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>
        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include 'front_include/css.php'; ?>
    </head>

    <body>
        <?php include 'front_include/header.php'; ?>


        <!-- Profile page section start -->

        <section class="Profile_page-section pt-100">
             <div class="container-fluid">
                  <div class="row">
                       <?php include 'front_include/left_menu.php' ?>
                       <div class="offset-lg-1 col-lg-7">
                            <div class="profile_page-form-sec">
                                 <div class="dashboard-title show-for-large">Change Password </div>
                                 <hr>
                                 <form id="change-password-form" method="post" action="<?php echo SITEURL; ?>process-change-password/">
                                 <div class="contact-form">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input class="form-control" type="text" name="cpsw" id="cpsw">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input class="form-control" type="text" name="npsw" id="npsw">
                                    </div>
                                    <div class="form-group">
                                        <label>Conform Password</label>
                                        <input class="form-control" type="text" name="confirmpsw" id="confirmpsw">
                                    </div>
                                    <div class="form-group">
                                        <button class="w-100 Sign_Up-btn mt-4" type="submit">Submit</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                       </div>
                  </div>
             </div>
        </section>

        <!-- Profile page section end -->
    
      
      
       
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>

        <script type="text/javascript">
            $("#change-password-form").validate({
                rules: {
                    cpsw:{required : true},
                    npsw:{required : true},
                    confirmpsw:{required : true, equalTo:"#npsw"},

                },
                messages: {
                    cpsw:{required:"Please enter current password."},
                    npsw:{required:"Please enter new password."},
                    confirmpsw:{required:"Please enter conform password.",equalTo:"New and Confirm passwords do not match."},
                }, 
                
            });
        </script> 

    </body>
</html>
