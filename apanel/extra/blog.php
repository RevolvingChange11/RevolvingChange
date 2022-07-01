<?php
    include "connect.php";
    $blog=$db->getData("blog","*","isdelete=0");
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
                            Revolving Change  Blogs</h2>
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
                            <div class="blog-article">
                                <div class="blogs-image">
                                   <a href="#"><img src="<?php echo SITEURL; ?>images/blog/<?php echo ; ?>"></a>   
                                </div>
                                 <div class="blogs-info">
                                    <h4><a href="#">Change</a></h4>
                                     <p class="date"><i class="fa-solid fa-calendar-days"></i> Oct 14, 2021</p>
                                     <a class="btn view-btn" href="#">View More</a>
                                 </div>
                           </div>
                            <!-- blog one end -->

                            <!-- blog two start -->
                            <div class="blog-article">
                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-2.png"></a>
                                </div>
                                 <div class="blogs-info">
                                    <h4><a href="#">THE SECRET OF CAREER SUCCESS: Ace Your Feedback Game & Avoid These Pitfalls!</a></h4>
                                     <p class="date"><i class="fa-solid fa-calendar-days"></i> Oct 11, 2021</p>
                                     <a class="btn view-btn" href="#">View More</a>
                                 </div>
                           </div>
                            <!-- blog two end -->

                           <!-- blog third start -->
                            <div class="blog-article">
                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-3.jpg"></a>
                                </div>
                                <div class="blogs-info">
                                    <h4><a href="#">FEAR OF CHANGE</a></h4>
                                    <p class="date"><i class="fa-solid fa-calendar-days"></i> Sep 19, 2021</p>
                                    <a class="btn view-btn" href="#">View More</a>
                                </div>
                            </div>
                            <!-- blog third end -->

                            <!-- blog four start -->
                               <div class="blog-article">
                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-4.jpg"></a>
                                </div>
                                <div class="blogs-info">
                                    <h4><a href="#">EXPECTATIONS</a></h4>
                                    <p class="date"><i class="fa-solid fa-calendar-days"></i> Sep 15, 2021</p>
                                    <a class="btn view-btn" href="#">View More</a>
                                </div>
                            </div>
                            <!-- blog four end -->

                            <!-- blog five start -->
                            <div class="blog-article">
                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-5.jpg"></a>
                                </div>
                                <div class="blogs-info">
                                    <h4><a href="#">PERFECTING THE ART & SCIENCE OF FEEDBACK</a></h4>
                                    <p class="date"><i class="fa-solid fa-calendar-days"></i> Sep 08, 2021</p>
                                    <a class="btn view-btn" href="#">View More</a>
                                </div>
                            </div>
                            <!-- blog five end -->

                             <!-- blog six start -->
                             <div class="blog-article">
                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-6.png"></a>
                                </div>
                                <div class="blogs-info">
                                    <h4><a href="#">DECIDE TO CHANGE YOUR LIFE</a></h4>
                                    <div class="blog-listing__tags">
                                        <a class="tag" href="#">feedback</a>
                                        <a class="tag" href="#">revolvingchange</a>
                                    </div>
                                    <p class="date"><i class="fa-solid fa-calendar-days"></i> Aug 18, 2021</p>
                                    <a class="btn view-btn" href="#">View More</a>
                                </div>
                            </div>
                            <!-- blog six end -->

                         </div>


                         <div class="col-lg-3">
                              <aside class="blog-sidebar">
                                   <form class="search__form" action="" role="search">
                                        <span class="sidebar-search__icon"><i class="fa fa-search"></i></span>
                                        <input class="form-control sidebar-search__input" type="search" name="q" placeholder="Search...">
                                   </form>
                                   <h3>Categories</h3>
                                   <ul class="list-inline recent-list">
                                        <li><a href="#">All Categories</a></li>
                                        <li><a href="#">feedback</a></li>
                                        <li><a href="#">revolvingchange</a></li>
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
              </div>
         </section>

         <!-- blog section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>   
    </body>
</html>
