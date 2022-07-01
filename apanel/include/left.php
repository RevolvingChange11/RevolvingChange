<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #ffffff;" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo ADMINURL; ?>">
		<div class="sidebar-brand-icon">
			<img src="<?php echo SITEURL.'images/logo.png'; ?>" title="<?php echo SITETITLE; ?>" alt="<?php echo SITETITLE; ?>" style="max-width: 160px; max-height: 40px;">
		</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<!-- <div class="sidebar-heading">
		MAIN NAVIGATION
	</div> -->
	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="<?php echo ADMINURL.'dashboard/' ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>
	<!-- Nav Item - Pages Collapse Menu -->
	<?php
		echo $db->get_admin_menu();
	?>
	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>