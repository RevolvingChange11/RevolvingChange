<?php
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
    if (empty($user_id) && $user_id =="") {
        // code...
    }
    else
    {
        $user_rs = $db->getData("user","*","isDelete=0 AND id=".$user_id);
        $user_d = mysqli_fetch_assoc($user_rs);
    }
   

?>

<div id="siteloader" class="siteloader">
    <div class="loader loader-inner">
        <div class="loader-box">
            <div class="dot dot1"></div>
            <div class="dot dot2"></div>
            <div class="dot dot3"></div>
             <div class="dot dot4"></div>
        </div>
    </div>
</div>


<!-- site header start -->

    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL ?>images/logo/main-logo.png" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo SITEURL; ?>about-us/">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>courses/">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>courses/free/">Free Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>contact/">Contact</a>
                        </li>
                        <?php if ( !empty($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] != "" ){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>library/">My Library</a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>blog/">Article</a>
                        </li>
                        <?php
                            if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] !="") { ?>
                            <li class="nav-item profile-menu">
                                <a class="nav-link" href="#"><span>Account</span> <!-- <img src=" --><?php //echo SITEURL; ?><!-- images/user_placeholder.png"> --></a>
                                <div class="profile-dropdown">
                                    <div class="profile-name">
                                        <img src="<?php echo SITEURL; ?>images/user_placeholder.png">
                                        <div class="profile-info">
                                            <h4><?=$user_d['name']?></h4>
                                        </div>
                                    </div>
                                    <div class="sign-out-btn">
                                        <a href="<?php echo SITEURL ?>profile/">Profile</a>
                                    </div>
                                    <div class="sign-out-btn">
                                        <a href="<?php echo SITEURL ?>your-orders/">Your Courses</a>
                                    </div>
                                    <div class="sign-out-btn">
                                        <a href="<?php echo SITEURL ?>logout/">Log Out</a>
                                    </div>
                                </div>
                            </li>
                        <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITEURL; ?>login/">Log In</a>
                        </li> 
                        <?php } ?>

                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- site header end -->