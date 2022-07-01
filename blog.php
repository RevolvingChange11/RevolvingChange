<?php
    include "connect.php";
    error_reporting(0);
    $blog_id_array=[];
    $ctable_where = "";

    if($_REQUEST['category_id']!="" && !empty($_REQUEST['category_id']))
    {
        $blog=$db->getData("blog","*","isdelete=0 AND category_id=".$_REQUEST['category_id']);
    }
    else
    {
        $blog=$db->getData("blog","*","isdelete=0");
        
    }
    $blog_cat=$db->getData("blog","*","isdelete=0");
    while($blog_cat_row=mysqli_fetch_assoc($blog_cat))
    {
        array_push($blog_id_array,$blog_cat_row['category_id']);
    }

    if(isset($_POST['btn_search']) && $_POST['btn_search']!=""){
        // die('11');
        $ctable_where .= " (
                    title like '%".$db->clean($_REQUEST['blog_search'])."%' 
        ) AND ";   
        $ctable_where .= "isdelete=0";    
        $ctable_r      = $db->getData("blog_category","*",$ctable_where);
        if(mysqli_num_rows($ctable_r)>0)
        {
            $blog_cat_row=mysqli_fetch_assoc($ctable_r);
            $blog=$db->getData("blog","*","isdelete=0 AND category_id=".$blog_cat_row['id']);
        }
        
    // $db->location(SITEURL."blog/");
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
        <!-- page header section start  -->
        <section class="page-header-section blog-hero-image pt-100">
            <div class="container">
                <div class="row">
                    <div class="page-heading-section pt-120 pb-120">
                        <h2>The
                            Revolving Change  Blogs
                        </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section end  -->
        <!-- blog section start  -->
        <section class="blogs-section pb-100 pt-100">
            <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <!-- blog one start -->
                    <?php 
                        while($blog_row=mysqli_fetch_assoc($blog))
                        {
                            
                        ?>
                    <div class="blog-article block">
                        <div class="blogs-image">
                            <a href="#"><img src="<?php echo SITEURL; ?>images/blog/<?php echo $blog_row['blog_img']; ?>"></a>   
                        </div>
                        <div class="blogs-info">
                            <h4><a href="#"><?php echo $blog_row['blog_title']; ?></a></h4>
                            <?php 
                               $get_cat_name=$db->getData("blog_category","*","isDelete=0 AND id=".$blog_row['category_id']."");
                               $get_cat_name_row=mysqli_fetch_assoc($get_cat_name);
                            ?>
                            <p><small><?php echo $get_cat_name_row['title']; ?></small></p>
                            <p class="date">
                                <i class="fa-solid fa-calendar-days"></i><?php $new_date = date('M d, Y ', strtotime($blog_row['adate'])); echo $new_date; ?>
                             
                         </p>

                            <a class="btn view-btn" href="<?php echo SITEURL."blog-details/".$blog_row['id']."/"; ?>">View More</a>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- <div id="load"> <b> Load More </b></div> -->
                    <!-- blog one end -->
                    <!-- </div> -->
                </div>
                <div class="col-lg-3">
                    <aside class="blog-sidebar">
                        <form class="search__form" action="." method="post" >
                            <input class="form-control sidebar-search__input"  type="search" name="blog_search" id="blog_search" placeholder="Search Category..." style="padding: 0;">&nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary float-right" name="btn_search" id="btn_search" value="btn_search"><i class="fa fa-search"></i></button>
                        </form>
                        <h3>Categories</h3>
                        <ul class="list-inline recent-list">
                            <li><a href="<?php echo SITEURL."blog"; ?>">All Categories</a></li>
                            <?php
                                $blog_category=$db->getData("blog_category","*","isdelete=0","id DESC limit 5");
                                while($blog_category_row=mysqli_fetch_assoc($blog_category))
                                {
                                     if (in_array($blog_category_row['id'], $blog_id_array))
                                    {
                                        echo '<li><a href="'.SITEURL.'blog/'.$blog_category_row['id'].'/">'.$blog_category_row['title'].'</a></li>';
                                    }
                                }
                                ?>
                        </ul>
                        <h3>Follow us on social media: </h3>
                        <ul class="list-inline social-list">
                            <li class="list-inline-item"><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>
        <!-- blog section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>  
    </body>
</html>