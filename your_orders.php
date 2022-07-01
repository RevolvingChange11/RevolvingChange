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
                        <h2>Your Courses</h2>
                    </div>
                </div>
            </div>
        </section>

        <!-- page header section end  -->

        <!-- top link bar start -->
        <div class="top_link-bar">
            <div class="container">
                <div class="link-list__links">
                    <a href="#">Dashboard</a>
                    <a href="<?php echo SITEURL; ?>members/">Member Directory</a>
                    <a href="#">Announcements</a>
                </div>
            </div>
        </div>

        <!-- top link bar end -->

        <!-- Courses heading section start -->

        <section class="Courses-heading-section pt-100 pb-100">
            <div class="container">
                <table class="table table-striped">
                    
                    <?php
                        $get_data=$db->getData("purchase_history","*","isDelete=0 AND user_id=".$user_id);
                        if(mysqli_num_rows($get_data)==0)
                        { ?>
                        <center><img src="<?php echo SITEURL; ?>images/home/no_data_found.png" /></center>
                    <?php }
                        else
                        { ?>
                            <tr>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Purchased Date</th>
                                <th>Completed</th>
                                <th>Payment Status</th>
                            </tr>

                            <?php 
                            while($row=mysqli_fetch_assoc($get_data))
                            {


                            ?>
                            <tr>
                                <td><?php echo $row['course_name']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($row['purchase_date'])); ?></td>
                                <td><?php echo $row['iscompleted']."%"; ?></td>
                                <?php
                                    if($row['status']==1)
                                    {
                                        $cls="fa fa-check";
                                    }
                                    else
                                    {
                                        $cls="fa fa-times";
                                    }
                                ?>

                                <td><i class="<?php echo $cls; ?>"></i></td>

                                
                            </tr>
                        <?php } } ?>
                    
                </table>
            </div>
        </section>
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>       
    </body>
</html>
