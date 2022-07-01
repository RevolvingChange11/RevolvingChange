<!-- JavaScript Library -->
<script src="<?php echo SITEURL; ?>js/jquery.min.js"></script>

<!-- Popper JS and Bootstrap JS -->
<script src="<?php echo SITEURL; ?>js/popper.min.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap.js"></script>
<script src="<?php echo SITEURL; ?>js/custom.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap-notify.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap-select.min.js"></script>
<script src="<?php echo SITEURL; ?>js/jquery.validate.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function(){

        <?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>

            $.notify({message: 'Something went wrong, Please try again !'},{ type: 'danger'})

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
            $.notify({ message: 'Invalid email or password.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Login') { ?>
            $.notify({ message: 'You have successfully logged in to the site.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Deleted') { ?>
            $.notify({message: 'Record deleted successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate') { ?>
            $.notify({message: 'The record already exists. Please try another.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Acc_Not_Verified') { ?>
            $.notify({ message: 'Sorry! your account is not verified. Please verify your account in order to login.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
            $.notify({ message: 'Invalid email or password.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Signup') { ?>
            $.notify({ message: 'You have successfully registered to <?php echo SITETITLE; ?>. Please check your email inbox (check spam as well) and verify your account.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'FILL_ALL_DATA') { ?>
            $.notify({ message: 'Fill all data.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Email_not_found') { ?>
            $.notify({ message: 'Email not found.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email') { ?>
            $.notify({ message: 'Invalid email.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
            $.notify({ message: 'Your password has been updated successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_NOT_MATCH') { ?>
            $.notify({ message: 'Your old password is not match.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_CHANGED') { ?>
            $.notify({ message: 'Your password is changed successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
            $.notify({ message: 'Invalid data.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account_success') { ?>
            $.notify({ message: 'Your account is activated successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Already_registred_email') { ?>
            $.notify({ message: 'Email is already registerd. Please use another email.'},{type: 'danger'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Change_password_success') { ?>
            $.notify({ message: 'Password changed successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Inserted') { ?>
             $.notify({message: 'Record added successfully.' },{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Updated') { ?>
             $.notify({message: 'Record updated successfully.' },{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'deleted') { ?>
            $.notify({message: 'Record deleted successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PAY_SUCCESS') { ?>
            $.notify({message: 'Payment completed successfully.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'SaveAns') { ?>
            $.notify({message: 'Your pre module submission successfully saved.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PostSaveAns') { ?>
            $.notify({message: 'Your post module submission successfully saved.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
            $.notify({ message: 'An email has been sent. Please click the link when you get it.'},{type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Mark_Complete') { ?>
            $.notify({ message: 'Successfully Completed This Lesson!'},{type: 'success'});

        <?php unset($_SESSION['MSG']); }  else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Complete_Lesson') { ?>
            $.notify({ message: 'Successfully Completed lesson'},{ type: 'success'});

        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'GET_NOTIFICATION') { ?>
            $.notify({ message: 'Congratulations ! Now you get information about new course .'},{type: 'success'});


        <?php unset($_SESSION['MSG']); } else if( isset($_SESSION['MSG']) && !empty($_SESSION['MSG']) ) { ?>
            $.notify({message: '<?php echo $_SESSION['MSG']; ?>'},{type: 'info'});

        

            

        <?php unset($_SESSION['MSG']); } 

        ?>

        },1000);

});
</script>