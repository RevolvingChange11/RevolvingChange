<?php
    include "connect.php";
    $course_id = $db->clean($_REQUEST['id']);
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
        <section class="page-header-section courses-hero-image pt-100">
            <div class="container">
                <div class="row">
                    <div class="page-heading-section pt-120 pb-120">
                        <h2>Online Module</h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section end  -->
        <!-- Module list section start  -->
        <section class="Module-section pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <!-- Module 1 section start -->
                        <?php
                            $module_rs = $db->getData("module","*", "isDelete=0 AND isPublished=1 AND course_id=".$course_id);
                            while ($module_d = mysqli_fetch_assoc($module_rs)) {
                        ?>
                            <div class="Module-list-sec">
                                <h3><?= $module_d['name']; ?></h3>
                                <?php
                                    $lession_rs = $db->getData("lesson","*", "isDelete=0 AND  module_id=".$module_d['id']);
                                    while ($lession_d = mysqli_fetch_assoc($lession_rs)) {
                                        $get_stage=$db->getData("stage","*","isDelete=0 AND lesson_id=".$lession_d['id']." AND user_id=".$user_id."");
                                        $stage_row=mysqli_fetch_assoc($get_stage);
                                        if(mysqli_num_rows($get_stage)>0)
                                        {
                                            if($stage_row['submission_type']==0)
                                            {
                                                 echo '<a href='.SITEURL.'pre-module-form/'.$module_d['id'].'/'.$lession_d['id'].'/>';
                                            }
                                            if($stage_row['submission_type']==1)
                                            {
                                                 echo '<a href='.SITEURL.'lesson-details/'.$lession_d['id'].'/>';
                                            }
                                            if($stage_row['submission_type']==2)
                                            {
                                                 echo '<a href='.SITEURL.'post-module-form/'.$module_d['id'].'/'.$lession_d['id'].'/>';
                                            }
                                            if($stage_row['submission_type']==3)
                                            {
                                                //echo '<a href='.SITEURL.'online-module/'.$course_id.'>';
                                                 echo '<a href='.SITEURL.'report/'.$lession_d['id'].'/>';
                                            }
                                            if($stage_row['submission_type']==4)
                                            {
                                                //echo '<a href='.SITEURL.'online-module/'.$course_id.'>';
                                                 echo '<a href="javascript:void(0)">';
                                            }
                                        }
                                        else
                                        {
                                            echo '<a href='.SITEURL.'pre-module-form/'.$module_d['id'].'/'.$lession_d['id'].'/>';
                                        }
                                        

                                        
                                ?>
                                    <div class="lesson-box-sec">
                                        <div class="lesson-left-image">
                                            <?php 
                                            if(file_exists(MODULE.$module_d['image']) && $module_d['image']!="")
                                            { 
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/module/<?php echo $module_d['image']; ?>">

                                        <?php } else { ?>
                                            <img src="<?php echo SITEURL; ?>images/home/placeholder.png">


                                        <?php } ?>
                                        </div>
                                        <div class="lesson-right-info">
                                            <h4><?= $lession_d['name']; 
                                            if(mysqli_num_rows($get_stage)>0)
                                            {
                                             if($stage_row['submission_type']==4) 
                                             {
                                                echo '<div class="float-right"><i class="fa fa-check-circle" style="color:green"></i></div>';
                                             } } ?></h4>
                                            <p><?php echo $db->custom_echo($lession_d['long_desc'], 250); ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php } ?>
                              
                            </div>
                        <?php } ?>
                        <!-- Module 1 section end -->
                    </div>
                    <div class="col-lg-3">
                        <div class="Module_sidebar">
                            <div class="Lessons-completed">
                                <?php
                                     $count=0;
                                     
                                     $total_lesson=0;
                                    /*$purch_course_list_rs = $db->getData("purchase_history","*","isDelete=0 AND user_id=".$user_id);
                                    while($purch_course_list_d = mysqli_fetch_assoc($purch_course_list_rs))
                                    {
                                        $library_rs = $db->getData("course","*","isDelete=0 AND isPublish=1 AND id=".$purch_course_list_d['course_id']);*/
                                        $module=$db->getData("module","*","isDelete=0 AND course_id=".$course_id);
                                        while($module_row=mysqli_fetch_assoc($module))
                                        {
                                            $lesson=$db->getData("lesson","*","isDelete=0 AND  module_id=". $module_row['id']);
                                            $total_lesson1=mysqli_num_rows($lesson);
                                            $total_lesson=$total_lesson+$total_lesson1;
                                        
                                           
                                            while($lesson_id_row=mysqli_fetch_assoc($lesson))
                                            {
                                                $get_complte_lesson=$db->getData("stage","*","isDelete=0  AND lesson_id=".$lesson_id_row['id']." AND user_id=".$user_id."");
                                                $get_complte_lesson_row=mysqli_fetch_assoc($get_complte_lesson);
                                                if(mysqli_num_rows($get_stage)>0)
                                                {
                                                if(@$get_complte_lesson_row['submission_type']==4)
                                                {
                                                   
                                                    $count++;
                                                }
                                                }
                                            }
                                        }
                                        $progress=($count*100)/$total_lesson;

                                     // break; 
                                    /*}*/
                                ?>
                                <h5><?php echo $count; ?> of <?php echo $total_lesson; ?> Lessons Completed</h5>
                               <!--  <h5>1 of 5 Lessons Completed</h5> -->
                                <div class="progress__bar">
                                    <div class="progress__fill" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%"></div>
                                </div>
                            </div>
                            <div class="instructor-section">
                                <h4>Instructor</h4>
                                <div class="profile">
                                    <div class="user-avtar">
                                        <img src="<?php echo SITEURL; ?>images/home/avatar.png">
                                    </div>
                                    <div class="user-info">
                                        <h5>John Doe</h5>
                                        <p>Instructor</p>
                                    </div>
                                </div>
                                <div class="profile-desc">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Module list section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>    
    </body>
</html>