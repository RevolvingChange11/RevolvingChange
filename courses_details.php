<?php
    include "connect.php";

    $course_id = $_REQUEST['id'];
    $course_detail_rs = $db->getData("course","*","isDelete=0 AND id=".$course_id);
    $course_detail_d = mysqli_fetch_assoc($course_detail_rs);
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

        <section class="page-header-section courses-hero-image pt-100">
             <div class="container">
                 <div class="row">
                    <div class="page-heading-section pt-120 pb-120">
                        <h2><?=$course_detail_d['name']?></h2>
                    </div>
                </div>
             </div>
        </section>

        <!-- page header section end  -->

        <!-- Courses details section start  -->

        <section class="Courses_details-section pt-120 pb-120">
             <div class="container">

                 <div class="Courses_details-box">
                      <div class="row">
                           <div class="col-lg-12">
                                <div class="Courses_images-details">
                                    <?php
                                    if($course_detail_d['image']!=="")
                                        {
                                          if(file_exists(COURSE.$course_detail_d['image']))
                                          { ?>
                                             <img src="<?php echo SITEURL.COURSE.$course_detail_d['image']; ?>">
                               <?php      } 
                                          else
                                          { ?>
                                             <img src="<?php echo SITEURL.COURSE."placeholder.png"; ?>">
                                          <?php }
                                       }
                                       else
                                        { ?>
                                          <img src="<?php echo SITEURL.COURSE."placeholder.png"; ?>">
                                        <?php } ?>
                                </div>    
                          
                                <div class="Courses_details info-section">
                                    <h4 class="line-bottom"><?=$course_detail_d['name']?></h4>
                                    <p class="price-title"><span class="theme-color">Price</span> : <?=CURR.$course_detail_d['price']?></p>

                                    <?=$course_detail_d['long_description']?>
                                    <?php
                                        $purchase_course_check = $db->getValue("purchase_history","course_id","isDelete=0 AND user_id=".$user_id." AND course_id=".$course_detail_d['id']);
                                        if (empty($purchase_course_check)) {
                                    ?>
                                    <div class="course-btn mt-4">
                                        <a class="btn purchase-btn" href="<?php echo SITEURL.'payment/'.$course_id; ?>">Purchase</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                      </div>
                 </div>

            </div>
        </section>

        <!-- Courses details section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>    
    </body>
</html>
