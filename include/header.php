	<!-- Header -->

	<header class="header trans_300">
		<!-- Top Navigation -->

		<div class="top_nav">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-right">
						
						<div class="top_nav_right">
							<ul class="top_nav_menu">
								<li class="account">
									<a href="<?php echo SITEURL; ?>my-account/">
										My Account
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="account_selection">
									<?php
										if( isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0 )
										{
									?>
										<li><a href="<?php echo SITEURL; ?>logout/"><i class="fa fa-sign-in" aria-hidden="true"></i>Logout</a></li>
									<?php
										}
										else
										{
									?>
										<li><a href="<?php echo SITEURL; ?>login/"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
									<?php
										}
									?>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="<?php echo SITEURL; ?>">Fox<span>Tel</span></a>
						</div>
						<nav class="navbar">
							<ul class="navbar_menu">
								<li><a href="<?php echo SITEURL; ?>">Home</a></li>
								<li><a href="<?php echo SITEURL; ?>categories/">Shop</a></li>
								<li><a href="<?php echo SITEURL; ?>faq/">FAQ</a></li>
								<li><a href="<?php echo SITEURL; ?>contact/">Contact</a></li>
							</ul>
							<ul class="navbar_user">
								<li><a href="<?php echo SITEURL; ?>categories/"><i class="fa fa-search" aria-hidden="true"></i></a></li>
								<!-- <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li> -->
								<li class="checkout">
									<a href="<?php echo SITEURL; ?>cart/">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										<span id="checkout_items" class="checkout_items"><?php echo $db->items_in_cart($_SESSION[SESS_PRE.'_SESS_CART_ID']); ?></span>
									</a>
								</li>
							</ul>
							<div class="hamburger_container">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item has-children">
					<a href="<?php echo SITEURL; ?>my-account/">
						My Account
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
					<?php
						if( isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0 )
						{
					?>
						<li><a href="<?php echo SITEURL; ?>logout/"><i class="fa fa-sign-in" aria-hidden="true"></i>Logout</a></li>
					<?php
						}
						else
						{
					?>
						<li><a href="<?php echo SITEURL; ?>login/"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
					<?php
						}
					?>
					</ul>
				</li>
				<li class="menu_item"><a href="<?php echo SITEURL; ?>">Home</a></li>
				<li class="menu_item"><a href="<?php echo SITEURL; ?>categories/">Shop</a></li>
				<li class="menu_item"><a href="<?php echo SITEURL; ?>faq/">FAQ</a></li>
				<li class="menu_item"><a href="<?php echo SITEURL; ?>contact/">Contact</a></li>
			</ul>
		</div>
	</div>
