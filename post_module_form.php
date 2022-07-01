<?php
    include "connect.php";
    $lesson_id = $db->clean($_REQUEST['lesson_id']);
    $module_id = $db->clean($_REQUEST['module_id']);

    $lesson_rs = $db->getData("lesson","*","isDelete=0 AND id=".$lesson_id);
    $lesson_d = mysqli_fetch_assoc($lesson_rs);
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_module_name = $db->getValue("module","name","isDelete=0 AND id=".$lesson_d['module_id']);
    $course_id = $db->getValue("module","course_id","isDelete=0 AND id=".$lesson_d['module_id']);

    $first_name = '';
    $last_name = '';

    if (isset($_REQUEST['post_module_submit'])) 
    {
        $first_name = $db->clean($_REQUEST['first_name']);
        $last_name = $db->clean($_REQUEST['last_name']);
        
        $question_id = $_REQUEST['question_id'];
        $answer_id = $_REQUEST['answer_id'];

        $post_moduel_arr = array(
            "user_id"       => $user_id,  
            "lesson_id"    => $lesson_id,
            "first_name"    => $first_name,
            "last_name"     => $last_name,
            "quetion_id"    => implode(',', $question_id),
            "answer_id"     => implode(',',$answer_id),
            "submission_type"=> 3
        );

        $post_module_save = $db->insert("pre_module_form",$post_moduel_arr);

         $update_stage = array(
            "submission_type"=> 3
        );
         $update_stage_res=$db->update("stage",$update_stage,"isDelete=0 AND user_id=".$user_id." AND lesson_id=".$lesson_id."");

        if ($post_module_save != "") 
        {
            $pros_arr = array(
                "user_id"   => $user_id,
                "module_id" => $lesson_id,
                "lession_id"=> $lesson_d['module_id']
            );
            $pros_save = $db->insert("module_process", $pros_arr);
            $_SESSION['MSG'] = "PostSaveAns";
            $db->location(SITEURL."report/".$lesson_id."");
        }
        else
        {
            $_SESSION['MSG'] = "Something_Wrong";
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
        <!-- post module form section start  -->
        <section class="Post_module-form-section pt-100 pb-100">
            <div class="container">
                <div class="ps-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Online Module (Demo) </a></li>
                        <li class="breadcrumb-item"><a href="<?php echo SITEURL ?>online-module/<?=$course_id?>/"><?=$get_module_name;?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=$lesson_d['name']?></li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Module 1 section start -->
                        <div class="Pre-list-sec">
                            <h3><?=$lesson_d['name']?></h3>
                            <p><a href="#"><?=$get_module_name;?></a></p>
                            <div class="module-logo">
                                <img src="<?php echo SITEURL; ?>images/logo/main-logo.png">
                            </div>
                            <div class="Module-question">
                                <form class="gform_fields" name="post_module_form" id="post_module_form" method="post" action=".">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name" required oninvalid="this.setCustomValidity('Please enter your first name.')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name" required oninvalid="this.setCustomValidity('Please enter your last name.')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <?php
                                        $no='';
                                        $lesson_rs = $db->getData("question","*", "isDelete=0 AND lesson_id=".$lesson_id);
                                        while($lesson_d = mysqli_fetch_assoc($lesson_rs)){
                                            $no++;
                                    ?>
                                    <div class="control-group">
                                        <h4><?=$lesson_d['name']?></h4>
                                        <input type="hidden" name="question_id[]" id="question_id" value="<?=$lesson_d['id']?>">
                                        <?php
                                            $option_val_rs = $db->getData("question_option","*", "isDelete=0");
                                            while($option_val_d = mysqli_fetch_assoc($option_val_rs)){
                                        ?>
                                        <div class="form-group">
                                            <label class="control control--radio">
                                                <?=$option_val_d['option_value']?>
                                                <input type="radio" name="answer_id[<?=$lesson_d['id']?>]" id="<?=$no?>" value="<?=$option_val_d['id']?>" class="validate_class" required oninvalid="this.setCustomValidity('Please select any one.')" oninput="this.setCustomValidity('')" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                
                                    <div class="form-group">
                                        <button class="w-100 Sign_Up-btn" name="post_module_submit" id="post_module_submit" type="submit">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Module 1 section end -->
                    </div>
                    <div class="col-lg-4">
                        <div class="Module_sidebar">
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
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.js"></script>
        <script type="text/javascript">

        </script>

    </body>
</html>