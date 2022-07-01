<?php
    include "connect.php";
    $getcourse=$db->getData("purchase_history","*","isDelete=0 AND user_id=".$_REQUEST['id']."");
    $get_course_id=mysqli_fetch_assoc($getcourse);
    $course_id=$get_course_id['course_id'];
    $course_details=$db->getData("course","*","isDelete=0 AND id=".$course_id."");

?>
<!DOCTYPE html>
<html lang="en" class="">

<head>
    <!-- Site Title -->
    <title>Matthias Grossmann's First Site</title>
    <?php include "front_include/css.php"; ?>
</head>

<body>
    <?php include "front_include/header.php"; ?>       
    <!-- page header section start  -->

    <section class="page-header-section members-hero-image pt-100">
        <div class="container">
            <div class="row">
                <div class="page-heading-section pt-120 pb-120">
                    <h2>Member Directory</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- page header section end  -->

    <!-- top link bar start -->
    <div class="top_link-bar">
        <div class="container">
            <div class="link-list__links">
                <a href="<?php echo SITEURL; ?>">Dashboard</a>
                <a href="<?php echo SITEURL; ?>members/">Member Directory</a>
                <a href="<?php echo SITEURL; ?>announcements/">Announcements</a>
            </div>
        </div>
    </div>

    <!-- top link bar end -->

    <!-- member directory section start -->

    <section class="Member-directory pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="offset-lg-8 col-lg-4">
                    <div class="Member-directory-header">
                        <div class="user-filter">
                           
                            
                        </div>
                        <div class="Member-search">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php 
                	if(mysqli_num_rows($course_details)>0)
                	{

                		while($course_details_row=mysqli_fetch_assoc($course_details))
                        {
                ?>
                            <div class="col-lg-4 mb-4">
                                <div class="member-box-dir">
                                    <img class="member__avatar" src="<?php echo SITEURL; ?>images/home/book.png">
                                    <h4 class="member__name"><?php echo $course_details_row['name']; ?>
                                    </h4>
                                        

                                </div>
                            </div>
                <?php   }
                	}
                	else
                	{ ?>
                		<img  src="<?php echo SITEURL; ?>images/home/no_data_found.png" style="padding-left: 40%;">
                <?php	} 


                ?>
            </div>

               
            

               

                
                
               
            </div>
        </div>
    </section>

    <!-- member directory section end -->
    <?php include "front_include/footer.php"; ?>
    <?php include "front_include/js.php"; ?>        
</body>

</html>