<?php
	include 'connect.php';
?>
<?php include("include/js.php"); ?>
<script type="text/javascript">

	var r=confirm('Are you sure you want to unsuscribe');
	if(r)
	{
		var del_id=<?php echo $_REQUEST['id']; ?>;
		$.ajax({
			type:"POST",
			url : "<?php echo SITEURL; ?>process_unsubscribe_ajax.php",
			data : { 
			    "id" : del_id,
			    //"action" : "delete"
			},

			success : function(response){
			  	window.location.href='<?php echo SITEURL; ?>';
			  
			  //location.reload(true);

			  
			}
			});

		}

</script>