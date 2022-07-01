<?php
    include "connect.php";
    $lesson_id = $db->clean($_REQUEST['lesson_id']);
    
    $module_id = $db->getValue("lesson","module_id", "isDelete=0 AND id=".$lesson_id);
    
    $module_rs = $db->getData("module", "*", "isDelete=0 AND id=".$module_id);
    $module_d = mysqli_fetch_assoc($module_rs);
    
    $lesson_rs = $db->getData("lesson", "*", "isDelete=0 AND id=".$lesson_id);
    $lesson_d = mysqli_fetch_assoc($lesson_rs);

    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $lesson=[];

    $sql=$db->getData("pre_module_form","*","user_id=".$user_id." AND isdelete=0");
    while($row=mysqli_fetch_assoc($sql))
    {
        array_push($lesson,$row['lesson_id']);
    }

    $lesson_id_array=[];

    $mark_as_complete_sql=$db->getData("pre_module_form","*","user_id=".$user_id." AND isdelete=0 AND iscompleted=1");
    while($rows=mysqli_fetch_assoc($mark_as_complete_sql))
    {
        array_push($lesson_id_array,$rows['lesson_id']);
    }

    $mark_as_complete_btnval=$db->getData("pre_module_form","*","lesson_id=".$lesson_id." AND isdelete=0 AND iscompleted=1");
    if(mysqli_num_rows($mark_as_complete_btnval)>0)
    {
        $btnval="Completed";
    }
    else
    {
        $btnval="Mark As Complete";
    }

    if (isset($_REQUEST['mark_as_complete'])) 
    {   
        $mark_as_complete_btnval_chk=$db->getData("pre_module_form","iscompleted","lesson_id=".$lesson_id." AND isdelete=0");
        $iscomplete_row=mysqli_fetch_assoc($mark_as_complete_btnval_chk);
        if($iscomplete_row['iscompleted']==0)
        {
            $update_iscomplete_lesson = array(
            "iscompleted"    => 1,
            );
        }
        else
        {
            $update_iscomplete_lesson = array(
            "iscompleted"    => 0,
            );
        }

        
        $update_iscomplete=$db->update("pre_module_form", $update_iscomplete_lesson, "lesson_id=".$lesson_id);
        if($update_iscomplete != "")
        {
            $_SESSION['MSG'] = "Mark_Complete";
            //$db->location(SITEURL."lesson-details/".$lesson_id."/");
             $update_stage = array(
            "submission_type"=> 2
            );
            $update_stage_res=$db->update("stage",$update_stage,"isDelete=0 AND user_id=".$user_id." AND lesson_id=".$lesson_id."");
            $db->location(SITEURL."post-module-form/".$module_id."/".$lesson_id."/");
           
        }
    }

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
        <!-- pre module form section start  -->
        <section class="Pre_module-form-section pt-100 pb-100">
            <div class="container">
                <div class="ps-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Online Module (Demo) </a></li>
                        <li class="breadcrumb-item"><a href="<?= SITEURL."online-module/".$module_d['course_id']."/" ?>"><?=$module_d['name']?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$lesson_d['name']?></li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="lesson-details-section">
                            <div class="video-section">
                                <video playsinline="playsinline" autoplay="" muted="muted" controls loop="">
                                    <source width="100%" height="600px" src="<?php echo SITEURL; ?>images/video/videoplayback.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="lesson-content-sec">
                                <h2><?=$lesson_d['name']?></h2>
                                <p><a href="<?php echo SITEURL ?>"><?=$module_d['name']?></a></p>
                                <?=$lesson_d['long_desc']?>
                                <div class="mark-as-complete">
                                   <!--  <a href="#" class="btn btn--completion w-100" name="mark_as_complete" id="mark_as_complete">Mark As Complete</a> -->

                                <form action="." method="post">
                                    <button class="btn btn--completion w-100" name="mark_as_complete" id="mark_as_complete" ><?php echo $btnval; ?></button>
                                </form>
                                </div>
                            </div>
                            <div class="Comments-sec">
                                <h4>Comments<sup>0</sup></h4>
                                <div class="Comments-Input">
                                    <textarea rows="4" class="custom-textarea" placeholder="Say Something..."></textarea>
                                </div>
                                <div class="">
                                    <a class="btn btn--comment" href="#"> Post Comment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="Module_sidebar">
                            <div class="player__playlist">
                                <?php
                                    $tot_lesson = $db->getValue("lesson", "COUNT(id)", "isDelete=0 AND module_id=".$module_id);
                                ?>
                                <div class="playlist__title">
                                    <h2><?=$module_d['name']?></h2>
                                    <h4><?=$tot_lesson;?> Lessons</h4>
                                </div>
                                <div class="playlist__body">
                                    <?php
                                        $le_no = '';
                                        $lesson_detail_rs = $db->getData("lesson", "*", "isDelete=0 AND module_id=".$module_id);
                                        while($lesson_detail_d = mysqli_fetch_assoc($lesson_detail_rs)){
                                            $le_no++;
                                            if(in_array($lesson_detail_d['id'], $lesson))
                                            {
                                                $link=SITEURL."lesson-details/".$lesson_detail_d['id']."/";
                                            }
                                            else
                                            {
                                                $link=SITEURL."pre-module-form/".$lesson_detail_d['module_id']."/".$lesson_detail_d['id']."/";
                                            }
                                    ?>
                                    <a href="<?php echo $link; ?>" class="media track <?php if($lesson_detail_d['id'] == $lesson_id){ echo "track--active"; } ?>">
                                        <div class="media-left media-middle">
                                            <p class="track__count"><?=$le_no;?><?=$lesson_detail_d['id'];?></p>
                                        </div>
                                        <div class="media-left media-middle">
                                            <img src="<?php echo SITEURL; ?>images/home/placeholder.png" class="track__thumb">
                                        </div>
                                        <div class="media-body media-middle">
                                            <p class="track__title"><?=$lesson_detail_d['name']?></p>
                                        </div>
                                        <?php
                                        
                                        ?>
                                        <div class="media-right media-middle"><?php if(in_array($lesson_detail_d['id'], $lesson_id_array))
                                        { echo '<i class="fa fa-check" style="color:blue" ></i>'; } ?></div>
                                    </a>
                                    <?php } ?>
                                    
                                    <a class="media track track--more" href="#">
                                        <div class="media-body media-middle">
                                            <p class="track__more">Next Category </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="Downloads-section">
                                <h4>Downloads </h4>
                                <a class="downloads__download" href="#">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img class="downloads__icon" src="<?php echo SITEURL; ?>images/home/acrobat.png">
                                        </div>
                                        <div class="media-body media-middle">
                                            sample.pdf
                                        </div>
                                    </div>
                                </a>
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