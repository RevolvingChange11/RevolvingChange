<script src="<?php echo SITEURL; ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo SITEURL; ?>styles/bootstrap4/popper.js"></script>
<script src="<?php echo SITEURL; ?>styles/bootstrap4/bootstrap.min.js"></script>
<script src="<?php echo SITEURL; ?>plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="<?php echo SITEURL; ?>plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo SITEURL; ?>plugins/easing/easing.js"></script>

<script src="<?php echo ADMINURL; ?>js/jquery.validate.js"></script>
<script src="<?php echo ADMINURL; ?>js/bootstrap-notify.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){
		<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
		  	$.notify({message: 'Something went worng. Please try again.'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Login_success') { ?>
		  	$.notify({ message: 'Login successful !'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
		  	$.notify({ message: 'Invalid Email or password.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); }  else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success') { ?>
		  	$.notify({ message: 'Your forgot password reset link is successfully sent to your register email address.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Logout') { ?>
		  	$.notify( {message: 'You are successfully logged out.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Signup') { ?>
		  	$.notify({message: 'You have successfully registered to <?php echo SITETITLE; ?> !. Please Login.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'ACC_CODE_SUCCESS') { ?>
		  	$.notify( {message: 'Your account has been successfully verified. Please login to continue.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'CODE_LINK_EXPIRE') { ?>
		  	$.notify( {message: 'This link has already been used or expired.'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Acc_Not_Verified') { ?>
	      	$.notify( {message: 'Sorry! your account is not verified. Please verify your account in order to login.'},{ type: 'danger'});
	   	<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
	      	$.notify( {message: 'Your forgot password reset link is successfully sent to your register email address.'},{ type: 'success'}); 
	   	<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
	  	  	$.notify( {message: 'Your password has been updated successfully.'},{ type: 'success'});
	    <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired_Pass') { ?>
	  	  	$.notify( {message: 'Your reset password link has been expired.'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Data_Found') { ?>
			$.notify({message: 'Your email address is not registered with us.'},{ type: 'danger'});
	   	<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
	      	$.notify( {message: 'Your email verification link has been expired.'},{ type: 'danger'}); 
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Msent') { ?>
			$.notify({message: 'Mail send successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Both_pass_mismatch') { ?>
			$.notify({message: 'New password and confirm password did not match.'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Worng_Password_Old') { ?>
			$.notify( {message: 'Old password is wrong..!'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Update') { ?>
			$.notify( {message: 'Password updated successfully.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Test_not_set') { ?>
			$.notify({message: 'Please select a test from the list and then try again.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
			$.notify({message: 'Invalid data. Please enter valid data.' },{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'WrongAddress') { ?>
			$.notify({message: 'You have entered invalid shipping address. Please enter valid address and try again.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && !empty($_SESSION['MSG']) ) { ?>
			$.notify({message: $_SESSION['MSG'] },{type: 'danger'});
		<?php unset($_SESSION['MSG']); }  else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Complete_Lesson') { ?>
	  	$.notify({ message: 'Successfully Completed lesson'},{ type: 'success'});
		
		<?php unset($_SESSION['MSG']); }
		?>
		},1000);
	});

    $('.num').keypress(function(event) {
    	//alert(event.which);
	    if( (event.which < 48 || event.which > 57))
	        event.preventDefault();

	    if( $(this).val().length >= 6 )
	        event.preventDefault();
	    else if( $(this).val() <= 0 && event.which == 48)
	    {
	    	$(this).val(1);
	        alert("Quantity cannot be zero.");
	        return false;
	    }
	    else
	    {
	        if( (event.which < 48 || event.which > 57))
	           event.preventDefault();
	    }
  	});
	
</script>
