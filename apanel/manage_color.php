<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "color";
	$ctable1 	= "Color";
	$page 		= "color";
	$page_title = "Manage ".$ctable1;

	if(isset($_REQUEST['submit']))
	{
	    $id = $_REQUEST['id'];
	    $name = $_REQUEST['name'];

	    $n = count($id);
	    for( $i=0; $i<$n; $i++ )
	    {
	        $rows = array(
	            "name" => $name[$i]
	        );
			if( (int)$id[$i] > 0 )
			{
				$db->update($ctable, $rows, 'id='.$id[$i]);
			}
			else
			{
				$color_id = $db->insert($ctable, $rows);
			}
	    }

	    $_SESSION['MSG'] = "Updated";
	    $db->location(ADMINURL."manage-$page/");
	    exit;
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title . ' | ' .  ADMINTITLE; ?></title>
	<?php include("include/css.php"); ?>
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<?php include("include/left.php"); ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php include('include/header.php'); ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h4 mb-0 text-gray-900"><?php echo $page_title; ?></h1>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4  border-left-info">
								<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
									<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<p class="btn-success p-2">NOTE: Please click on <strong>SUBMIT</strong> button to save the changes or new rows.</p>
										<div id="divcontent">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label> Name </label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label> Remove </label>
													</div>
												</div>
											</div>
											<?php
												$count = 0;
												$rs = $db->getData($ctable, '*', 'isDelete=0');
												while( $row = @mysqli_fetch_assoc($rs) )
												{
													$count++;
											?>
											<div class="row" id="row_<?php echo $count; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<input type="hidden" name="id[]" id="id<?php echo $count; ?>" value="<?php echo $row['id']; ?>">
														<input type="text" class="form-control" name="name[]" id="name<?php echo $count; ?>" value="<?php echo $row['name']; ?>" maxlength="100" required>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<a href="javascript:void(0);" class="btn btn-danger" onclick="remove_block(<?php echo $row['id']; ?>, <?php echo $count; ?>);" title="Remove"><i class="fa fa-trash"></i></a>
													</div>
												</div>
											</div>
											<?php
												}
											?>
										</div>
										<div class="row mb-2">
											<div class="col-md-6">
												<button type="button" name="btnadd" id="btnadd" class="btn btn-primary" title="Add More"><i class="fa fa-plus"></i></button>
												<input type="hidden" name="hdncount" id="hdncount" value="<?php echo $count; ?>">
											</div>
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" id="submit" class="btn btn-success" title="Submit"><i class="fa fa-save"></i></button>
											<button type="button" class="btn btn-secondary waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'; ?>'" title="Back"><i class="fa fa-reply" aria-hidden="true"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php include("include/footer.php"); ?>

			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->
	</div>
	<!-- End of Page Wrapper -->

	<!-- Bootstrap core JavaScript-->
	<?php include("include/js.php"); ?>

	<script type="text/javascript">

		$('#btnadd').click(function(){
		    val = $("#hdncount").val();
		    val++;
		    $("#hdncount").val(val);
		    $("#divcontent").append('<div class="row" id="row_'+val+'"> <div class="col-md-6"> <div class="form-group"> <input type="hidden" name="id[]" id="id'+val+'" value="0"> <input type="text" class="form-control" name="name[]" id="name'+val+'" value="" maxlength="100" required> </div> </div> <div class="col-md-6"> <div class="form-group"> <a href="javascript:void(0);" class="btn btn-danger" onclick="remove_block(0, '+val+');" title="Remove"><i class="fa fa-trash"></i></a> </div> </div> </div>');
	  	});

		function remove_block(id, ctrlid)
		{
			if( confirm('Are you sure you want to delete the record?') )
			{
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/",
					data: 'mode=delete&id='+id,
					success: function(res) {
						$("#row_"+ctrlid).remove();
						$.notify({message: "Record deleted successfully."}, {type: "success"});
					}
				}); 
			}
		}
	</script>
</body>

</html>
