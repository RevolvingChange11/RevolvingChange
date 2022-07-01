<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="<?php echo ADMINURL; ?>vendor/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- <script src="<?php echo ADMINURL; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="<?php echo ADMINURL; ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo ADMINURL; ?>js/sb-admin-2.min.js"></script>
<script src="<?php echo ADMINURL; ?>js/jquery.validate.js"></script>
<script src="<?php echo ADMINURL; ?>js/bootstrap-notify.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ADMINURL; ?>js/demo/datatables-demo.js"></script>
<script type="text/javascript" src="<?php echo ADMINURL; ?>js/bootstrap-datepicker.js"></script>

<script>
	$(document).ready(function(){
		setTimeout(function(){
		<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
			$.notify({message: 'Something went wrong, Please try again !' },{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Data_Found') { ?>
			$.notify({message: 'Your email address is not registered with us.'},{ type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
			$.notify({message: 'Your link to reset the password is expired.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
			$.notify({message: 'Email with link to reset the password has been sent to registered email.'},{ type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
			 $.notify({message: 'Invalid Data. Please enter valid data.' },{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
			 $.notify({message: 'Password reset successfully.' },{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Inserted') { ?>
			$.notify({message: 'Record added successfully.' },{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Updated') { ?>
			$.notify({message: 'Record updated successfully.' },{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Deleted') { ?>
			$.notify({message: 'Record deleted successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate') { ?>
			$.notify({message: 'The record already exists. Please try another.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
			$.notify({message: 'Invalid email or password.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account_success') { ?>
			$.notify({message: 'Account activated successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Not_approved') { ?>
			$.notify({message: 'You cannot access your account utill it is approved by admin. Please try again letter.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account') { ?>
			$.notify({message: 'Please activate your account.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'login_success') { ?>
			$.notify({message: 'Logged in successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'OrderUpdated') { ?>
			$.notify({message: 'Display order is updated successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } 
		?>
		},1000);
	});

	function check_all()
	{
		var chk = $("#chkall").prop("checked");
		if( chk )
		{
			$(document).find('input[name="chkid[]"]').each(function() {
			    $(this).prop('checked', true);
			});			
		}
		else
		{
			$(document).find('input[name="chkid[]"]').each(function() {
			    $(this).prop('checked', false);
			});			
		}
	}

	function bulk_delete()
	{
		var flg = 0;
		$('input[name="chkid[]"]').each(function () {
           if (this.checked) {
               flg = 1;
               //break; 
           }
		});

		if( flg )
		{
			if( confirm("Are you sure to delete all the selected records?") )
			{
				$('#hdnmode').val('delete');
				$.ajax({
		            url: "<?php echo ADMINURL; ?>ajax_bulk_remove.php",
		            type: "post",
		            data : $('#frm').serialize(),
		            success: function(response) {
		            	displayRecords(10,1);
		            }
	       		});
			}
		}
		else
		{
			$.notify({message: "Please select at least one record and try again."}, {type: "danger"});
			return false;
		}
		return false;
	}
</script>