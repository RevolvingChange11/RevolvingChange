<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable = "purchase_history";
	$ctable1 = "Orders";
	$page = "orders";
	$page_title = $ctable1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title . ' | ' .  ADMINTITLE; ?></title>
	<?php include("include/css.php"); ?>
</head>
<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php include("include/left.php"); ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<?php include('include/header.php'); ?>
				<div class="container-fluid">
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h4 mb-0 text-gray-900"><?php echo $page_title; ?></h1>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box border-top-info">
								<div class="card">
									<div class="card-body">
										<!-- For Table 1 -->
										<div class="box-header with-border">
											<div class="col-md-12 ">
												<form action="#" onSubmit="return searchByName();">
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" value="" name="searchName" class="form-control" placeholder="Search Here..." id="searchName" value="">
															</div>
														</div>
														<div class="col-md-3">
															<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
															<button type="submit" class="btn btn-danger" title="Clear Search Result" value="clear" onClick="clearSearchByName();"><i class="fa fa-times"></i></button>
															<a onClick="window.location.reload()" class="btn btn-warning" title="Reload Page"><i class="fa fa-sync"></i></a>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="box-body no-padding">
											<div class="col-md-12 table-responsive">
												<div class="loading-div" style="display:none;">
													<div><img style="width:10%;margin-left:440px;" src="<?php echo SITEURL?>images/loader.svg"></div>
												</div>
												<div id="results"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("include/footer.php"); ?>
		</div>

	</div>

	<!-- Bootstrap core JavaScript-->
	<?php include("include/js.php"); ?>
	<script type="text/javascript">
	/*Table 1 */
	var searchName="";
	function searchByName(){
		searchName = $("#searchName").val();
		displayRecords(10);
		return false;
	}
	function clearSearchByName(){
		searchName = "";
		$("#searchName").val("");
		displayRecords(10);
	}
	$("#searchName").keyup(function(event){
		if(event.keyCode == 13){
			$("#searchByName").click();
		}
	});
	function loadDataTable(data_url,page=""){
		setTimeout(function(){
			$("#results" ).load( data_url,{"page":page},function(){
				$('#example').DataTable({
					"bPaginate": false,
					"bFilter": false,
					"bInfo": false,
					"bAutoWidth": false, 
					"aoColumns": [
						{ "sWidth": "10%" }, 
						{ "sWidth": "10%" ,"bSortable": false }, 
						{ "sWidth": "10%" ,"bSortable": false },
						{ "sWidth": "10%" ,"bSortable": false },
						{ "sWidth": "15%" ,"bSortable": false },
						{ "sWidth": "20%" ,"bSortable": false },
						{ "sWidth": "20%" ,"bSortable": false },
						{ "sWidth": "5%"  ,"bSortable": false },
						]
				});
				$(".loading-div").fadeOut(500);
				$("#results").fadeIn();
			}); //load initial records
		},1500);
	}
	
	function displayRecords(numRecords) {
		var searchName 	= $("#searchName").val();
		searchName 	    = encodeURIComponent(searchName.trim());
		var data_url    = "<?php echo ADMINURL; ?>ajax_get_<?php echo $page; ?>.php?show=" + numRecords + "&searchName=" + searchName;
		$("#results").html("");
		$(".loading-div").show();
		loadDataTable(data_url);
		
		//executes code below when user click on pagination links
		$("#results").on("click",".paging_simple_numbers a", function (e){
			e.preventDefault();
			var numRecords  = $("#numRecords").val();
			$(".loading-div").show(); //show loading element
			var page = $(this).attr("data-page"); //get page number from link
			loadDataTable(data_url,page);
		});
		$("#results").on( "change", "#numRecords", function (e){
			e.preventDefault();
			var numRecords  = $("#numRecords").val();
			$(".loading-div").show(); //show loading element
			var page = $(this).attr("data-page"); //get page number from link
			loadDataTable(data_url,page);
		});
	}

	// used when user change row limit
	function changeDisplayRowCount(numRecords) {
		displayRecords(numRecords);
	}

	$(document).ready(function() {
		displayRecords(10);
	});

	function del_conf(id){
		var r = confirm("Are you sure you want to delete?");
		if(r){
			window.location.href='<?php echo ADMINURL; ?>add-<?php echo $page; ?>/delete/'+id+'/';
		}
	}

	

</script>
</body>

</html>
