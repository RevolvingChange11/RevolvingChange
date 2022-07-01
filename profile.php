<?php
    include 'connect.php';
    include("include/notification.class.php");
    $db->checkLogin();

    $user_rs = $db->getData("user","*","isDelete=0 AND id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
    $user_d = mysqli_fetch_assoc($user_rs);
    if($user_d['phone']==0)
    {
        $phone="";
    }
    else
    {
        $phone=$user_d['phone'];
    }
    if (isset($_POST['update_submit'])) 
    {
        //print_r($_REQUEST);
        //die();
        $confirmation_string = $db->generateRandomString(8);
        $name           = $db->clean($_REQUEST['name']);
        $email          = $db->clean($_REQUEST['email']);
        if($_REQUEST['phone']!="")
        {
          $phone       = $db->clean($_REQUEST['phone']);  
        }
        else
        {
            $phone="";
        }
        
        if (isset($name) && $name != "" && isset($email) && $email != "") 
        {
            $uid=$_SESSION[SESS_PRE.'_SESS_USER_ID'];
            $check_user_r = $db->getData("user","*","email = '".$email."' AND isDelete=0");
            if(empty($check_user_r) || mysqli_num_rows($check_user_r)==0)
            {
                $user_arr1 = array(
                    "name"                 => $name,
                    "phone"                => $phone ,
                    "email"                => $email,
                    "isActive"             =>0, 
                    "confirmation_string"   => $confirmation_string,
                );
             $db->update("user", $user_arr1,"id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
                    if( ISMAIL )
                    {   
                        $subject = SITENAME." : Update Email";
                        $nt = new Notification();
                        include("mailbody/signup_str.php");
                        //die($body);
                        $toemail = $email;
                        $nt->sendEmail($toemail, $subject, $body);
                    }
                    
                $_SESSION['MSG'] = "Updated";
                $db->location(SITEURL.'profile/');
            }
            else
            {
                $user_arr = array(
                    "name"                 => $name,
                    "phone"                 => $phone ,
                );
                $u_id = $db->update("user", $user_arr,"id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);

                   
                $_SESSION['MSG'] = "Updated";
                $db->location(SITEURL.'profile/');    
            }
        }
        else
        {
            $_SESSION['MSG'] = "FILL_ALL_DATA";
            $db->location(SITEURL.'profile/');
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>
        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include 'front_include/css.php'; ?>
    </head>

    <body>
        <?php include 'front_include/header.php'; ?>

        <!-- Profile page section start -->

        <section class="Profile_page-section pt-100">
             <div class="container-fluid">
                  <div class="row">
                        <?php include 'front_include/left_menu.php' ?>
                        <div class="offset-lg-1 col-lg-7">
                            <div class="profile_page-form-sec">
                                 <div class="dashboard-title show-for-large">Profile </div>
                                 <hr>
                                 <form id="update_profile_form" name="update_profile_form" method="post" action=".">
                                    <div class="contact-form">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input class="form-control" type="text" name="name" id="name" value="<?php echo $user_d['name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="email" id="email" value="<?php echo $user_d['email']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $phone; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-success" type="submit" name="update_submit" id="update_submit" value="Update">
                                        </div>
                                    </div>
                                </form>
                            </div>
                       </div>
                  </div>
             </div>
        </section>

        <!-- Profile page section end -->
    
      
      
       
        <!-- site footer section start -->

        
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script type="text/javascript">
        
            $("#update_profile_form").validate({
                rules: {
                    name:{required : true},
                    email:{required : true, email: true},
                    },
                messages: {
                    name:{required:"Please enter name."},
                    email:{required:"Please enter email address.", email:"please enter valid email."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script>


    </body>
</html>
