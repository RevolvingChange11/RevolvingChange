<?php
    include "connect.php";
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
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

        <section class="page-header-section library-hero-image pt-100">
            <div class="container">
                <div class="row">
                    <div class="page-heading-section pt-120 pb-120">
                        <h2>Course Library</h2>
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

        <!-- Courses heading section start -->

        <section class="Courses-heading-section pt-100 pb-100">
            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-7">
                        <div class="products__header">
                            <h3>My Courses</h3>
                        </div>
                    </div>
                    <?php 
                    $total_lesson=0;
                    $purch_course_list_rs = $db->getData("purchase_history","*","isDelete=0 AND user_id=".$user_id);
                    if(mysqli_num_rows($purch_course_list_rs)>0)
                    { 
                        while($purch_course_list_d = mysqli_fetch_assoc($purch_course_list_rs))
                        {
                            $library_rs = $db->getData("course","*","isDelete=0 AND isPublish=1 AND id=".$purch_course_list_d['course_id']);
                            $module=$db->getData("module","*","isDelete=0 AND course_id=".$purch_course_list_d['course_id']);
                            while($module_row=mysqli_fetch_assoc($module))
                            {
                                $lesson=$db->getData("lesson","*","isDelete=0 AND isPublished=1 AND module_id=". $module_row['id']);
                                $total_lesson1=mysqli_num_rows($lesson);
                                $total_lesson=$total_lesson+$total_lesson1;
                            
                               
                                while($lesson_id_row=mysqli_fetch_assoc($lesson))
                                {
                                    $get_complte_lesson=$db->getData("stage","*","isDelete=0  AND lesson_id=".$lesson_id_row['id']." AND user_id=".$user_id."");
                                    $get_complte_lesson_row=mysqli_fetch_assoc($get_complte_lesson);
                                    if(mysqli_num_rows($get_complte_lesson)>0)
                                    {
                                        if($get_complte_lesson_row['submission_type']!=4)
                                        { 
                                            if($get_complte_lesson_row['submission_type']==0)
                                            {
                                                 echo '<a href='.SITEURL.'pre-module-form/'.$module_row['id'].'/'.$lesson_id_row['id'].'/>';
                                            }
                                            if($get_complte_lesson_row['submission_type']==1)
                                            {
                                                 echo '<a href='.SITEURL.'lesson-details/'.$lesson_id_row['id'].'/>';
                                            }
                                            if($get_complte_lesson_row['submission_type']==2)
                                            {
                                                 echo '<a href='.SITEURL.'post-module-form/'.$module_row['id'].'/'.$lesson_id_row['id'].'/>';
                                            }
                                            if($get_complte_lesson_row['submission_type']==3)
                                            {
                                                //echo '<a href='.SITEURL.'online-module/'.$course_id.'>';
                                                 echo '<a href='.SITEURL.'report/'.$lesson_id_row['id'].'/>';
                                            }
                                        
                                            ?>
                                            <div class="col-lg-5 " style="float:right; color: #000;">
                                                <div class="resume-course__positioner">
                                                    <div class="resume-course__text">
                                                        <h6>Resume Course</h6>
                                                        <p><?php echo $lesson_id_row['name']; ?></p>
                                                    </div>
                                                    <div class="resume-course__image">
                                                        <?php 
                                                            if(file_exists(MODULE.$module_row['image']) && $module_row['image']!="")
                                                            { 
                                                            ?>
                                                            <img src="<?php echo SITEURL; ?>images/module/<?php echo $module_row['image']; ?>" style="width: 927px;height: 100px;">

                                                        <?php } else { ?>
                                                            <img src="<?php echo SITEURL; ?>images/home/placeholder.png">
                                                        <?php } ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <?php echo "</a>";  break; 
                                        }
                                    }
                                } break; 
                            } break;
                        }
                    }
                    ?>
                    
                    
                    
                </div>


                <?php
                     $count=0;
                     $count1=0;
                     
                    $purch_course_list_rs = $db->getData("purchase_history","*","isDelete=0 AND user_id=".$user_id);
                    if(mysqli_num_rows($purch_course_list_rs)==0)
                    { ?>
                        <center><img src="<?php echo SITEURL; ?>images/home/no_data_found.png" /></center>
                    <?php }

                    while($purch_course_list_d = mysqli_fetch_assoc($purch_course_list_rs))
                    {
                        $library_rs = $db->getData("course","*","isDelete=0 AND isPublish=1 AND id=".$purch_course_list_d['course_id']);
                        $module=$db->getData("module","*","isDelete=0 AND course_id=".$purch_course_list_d['course_id']);
                        $total_lesson=0;
                        $total_lesson1=0;
                        $progress=0;
                        while($module_row=mysqli_fetch_assoc($module))
                        {
                            $lesson=$db->getData("lesson","*","isDelete=0  AND module_id=". $module_row['id']);
                            $total_lesson1=mysqli_num_rows($lesson);
                            $total_lesson=$total_lesson+$total_lesson1;
                        
                            
                            while($lesson_id_row=mysqli_fetch_assoc($lesson))
                            {
                                $get_complte_lesson=$db->getData("stage","*","isDelete=0  AND lesson_id=".$lesson_id_row['id']." AND user_id=".$user_id."",'');
                                $get_complte_lesson_row=mysqli_fetch_assoc($get_complte_lesson);
                                if(mysqli_num_rows($get_complte_lesson)>0)
                                {
                                if($get_complte_lesson_row['submission_type']==4)
                                {
                                    // echo "==2==";
                                    $count++;
                                    $progress=($count*100)/$total_lesson;

                                    $progress_row   = array(
                                     "iscompleted" => $progress,
                                    );
                                     $update_progerss=$db->update("purchase_history",$progress_row,"isDelete=0 AND user_id=".$user_id." AND course_id=".$purch_course_list_d['course_id']."");
                                }
                                }
                            }
                        }
                        
                        
                        while($library_d = mysqli_fetch_assoc($library_rs)){
                ?>
                <div class="row">
                    <div class="Courses-project-box">
                        <div class="product__image">
                            <?php

                                if(file_exists(COURSE.$library_d['image']) && $library_d['image']!="")
                                { 
                                    ?>
                                        <img src="<?php echo SITEURL; ?>images/course/<?php echo $library_d['image']; ?>">

                                    <?php } else { ?>
                                        <img src="<?php echo SITEURL; ?>images/home/placeholder.png">
                                    <?php } ?>
 
                        
                        </div>
                        <div class="product__content">
                            <div class="product__info">
                                <h4><?=$library_d['name']?></h4>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
                                </div>
                                <p><?$library_d['short_description']?></p>
                            </div>
                            <div class="product__button">
                                <a class="btn more-btn" href="<?php echo SITEURL ?>online-module/<?php echo $library_d['id'].'/'; ?>">VIEW Courses </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                        } 
                    }
                ?>
            </div>
        </section>

        <!-- Courses heading section end -->

        <!-- <div class="container pb-80">
            <div class="More-courses-sec">
                <h2>More Courses</h2>
            </div>
       </div>
 -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>       
    </body>
</html>
