<?php
    include "connect.php";
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
                        <h2>Blogs Details</h2>
                    </div>
                </div>
            </div>
        </section>

        <!-- page header section end  -->

        <!-- blog section start  -->

        <section class="blogs-details-section pb-100 pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="blog-article">
                            <div class="blogs-info">
                                <h4><a href="#">THE SECRET OF CAREER SUCCESS: Ace Your Feedback Game & Avoid These Pitfalls!</a></h4>
                                <p class="date"><i class="fa-solid fa-calendar-days"></i> Oct 14, 2021</p>
                            </div>
                            <div class="blogs-image">
                                <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-1.jpg" /></a>
                            </div>

                            <div class="blog-post-body__content">
                                <blockquote class="wp-block-quote">
                                    <p>
                                        <strong>
                                            <em>
                                                “When people rely on surface appearances and false racial stereotypes, rather than in-depth knowledge of others at the level of the heart, mind, and spirit, their ability to assess and
                                                understand people accurately is compromised.”
                                            </em>
                                        </strong>
                                    </p>
                                    <cite>
                                        <strong><em>– Ken Blanchard</em></strong>
                                    </cite>
                                </blockquote>
                            </div>
                            <div class="blogs-info">
                                <p>
                                    <strong>Feedback </strong> has always been a key component for success in any area of life, especially in business. With technological advancement rapidly changing industrial landscapes globally, we
                                    strive to navigate and adapt to our ever-changing work environment by utilizing one of the vital competencies needed in our <strong>pursuit of excellence and survival- our feedback skill.</strong> Today,
                                    we invite you to walk with us, as we venture into the world of business, utilizing the most proven and highly successful management trends and other critical success tools that are sure to create a
                                    difference in your everyday living.
                                </p>
                                <p><strong>1. STEREOTYPING &amp; PREJUDICE</strong></p>
                                <p><strong> A Stereotype </strong> is a fixed assumption or belief about an individual built solely on their membership in a group, regardless of their individual characteristics.</p>
                                <p>
                                    <strong>Prejudice</strong> is an opinion that is most often an unfavorable one. These opinions are formed not based on reason or experience, and it often originates from a certain stereotype or belief
                                    system. It is rooted in the idea that certain people
                                </p>
                                <p><strong>How can we avoid this pitfall?</strong></p>
                                <ul>
                                    <li>Be accepting and respect differences</li>
                                    <li>Strive to know more about others who appear different from you or your beliefs</li>
                                    <li>Avoid making judgments about others</li>
                                    <li>Try to educate yourself about your own culture and the culture of others</li>
                                    <li>Try walking in someone else’ shoes (Develop empathy)</li>
                                </ul>

                                <div class="blogs-image">
                                    <a href="#"><img src="<?php echo SITEURL; ?>images/home/article-1.jpg" /></a>
                                </div>

                                <div class="blog-post-body__content">
                                    <blockquote class="wp-block-quote">
                                        <p>
                                            <strong>
                                                <em>
                                                    “When people rely on surface appearances and false racial stereotypes, rather than in-depth knowledge of others at the level of the heart, mind, and spirit, their ability to assess and
                                                    understand people accurately is compromised.”
                                                </em>
                                            </strong>
                                        </p>
                                        <cite>
                                            <strong><em>– Ken Blanchard</em></strong>
                                        </cite>
                                    </blockquote>
                                </div>
                                <div class="blogs-info">
                                    <p>
                                        <strong>Feedback </strong> has always been a key component for success in any area of life, especially in business. With technological advancement rapidly changing industrial landscapes globally, we
                                        strive to navigate and adapt to our ever-changing work environment by utilizing one of the vital competencies needed in our
                                        <strong>pursuit of excellence and survival- our feedback skill.</strong> Today, we invite you to walk with us, as we venture into the world of business, utilizing the most proven and highly successful
                                        management trends and other critical success tools that are sure to create a difference in your everyday living.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <aside class="blog-sidebar">
                            <form class="search__form" action="" role="search">
                                <span class="sidebar-search__icon"><i class="fa fa-search"></i></span>
                                <input class="form-control sidebar-search__input" type="search" name="q" placeholder="Search..." />
                            </form>
                            <h3>Categories</h3>
                            <ul class="list-inline recent-list">
                                <li><a href="#">All Categories</a></li>
                                <li><a href="#">feedback</a></li>
                                <li><a href="#">revolvingchange</a></li>
                            </ul>
                            <h3>Follow us on social media:</h3>
                            <ul class="list-inline social-list">
                                <li class="list-inline-item">
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
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
