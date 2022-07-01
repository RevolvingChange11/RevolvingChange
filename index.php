<?php
    include "connect.php";
    $db->checkLogin();
    
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
        <!-- hero banner section start -->

        <section class="Hero_banner-section pt-100 pb-100">
               <div class="container">
                    <div class="banner-caption">
                         <h2>{revolving<span>change}</span></h2>
                         <h1><span>TRANSFORMATIONAL</span><br>
                             HUMAN ENGINEERING </h1>
                           <h1><em>FOR MEASURABLE LASTING CHANGE</em></h1>
                           <a class="btn more-btn" href="<?php echo SITEURL; ?>about-us/">TELL ME MORE</a>
                    </div>
               </div> 
        </section>

        <!-- hero banner section end -->

        <!-- About us section start -->

        <section class="AboutUs-section pt-100 pb-100">
            <div class="container">
                <div class="AboutUs-Heading pb-80">
                    <div class="section-header text-center">
                        <h1>What is Transformational Human Engineering for measurable Eating Change?</h1>
                        <p>Whether you're new to a management role, want to pursue such a role or have already successfully advanced your career BUT you are looking to advance your skills, get to the next level we have a set of our comprehensive courses for you. THE (Transformational Human Engineering) means that you go through a tested, quality controlled succession of learning steps to achieve a better understanding of the knowledge needed to advance your career.</p>
                    </div>
                </div>
                <div class="row">
                     <div class="col-lg-4 col-md-6">
                         <div class="feature-box">
                             <img class="feature__image" src="<?php echo SITEURL ?>images/home/icon_1.png">
                             <div class="feature__text">
                                <h4>Launch Your&nbsp;Career Improvement</h4>
                                <p>Our Courses can be previewed through the DEMISTIFIED series which gives you initial tips & tricks and talks about about our course architecture.</p>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-6">
                        <div class="feature-box">
                            <img class="feature__image" src="<?php echo SITEURL ?>images/home/icon_2.png">
                            <div class="feature__text">
                               <h4>Self Improvement through our Discover Courses
                            </h4>
                               <p>Learn and or improve your skills. Focused on Key Topics of management topics, we have put together a series of courses that will lead you to a better understanding based on a clear path.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-box">
                            <img class="feature__image" src="<?php echo SITEURL ?>images/home/icon_3.png">
                            <div class="feature__text">
                               <h4>Comprehensive Coaching</h4>
                               <p>Once you have mastered and build the fundamental  knowledge we offer live courses all the way to in person coaching session on the relevant topics. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About us section end -->



        <!-- Course Architecture section start -->

        <section class="Course_Architecture-section pt-100 pb-100">
             <div class="container">
                  <div class="row pb-80">
                       <div class="col-lg-5">
                            <div class="Course_Arc-left-sec">
                                <p style="color: #0b0088">Course Architecture</p>
                                <h3>Your THE Journey</h3>
                                <p>An easy to follow course sequence that will give you a concrete understanding of how to improve your management skills.</p>
                                <a class="btn more-btn mt-3" href="<?php echo SITEURL; ?>courses/">GET THE COURSES</a>
                            </div>
                       </div>

                       <div class="col-lg-6">
                           <div class="Course_Arc-right-sec">
                                <img src="<?php echo SITEURL ?>images/home/Products_1.png">
                           </div>
                        </div>
                  </div>

                  <div class="row pt-100">
                      <div class="col-lg-4">
                             <div class="Left_Images">
                                  <img src="<?php echo SITEURL ?>images/home/Products_2.png">
                             </div>
                       </div>

                       <div class="offset-lg-1 col-lg-6">
                        <div class="Course_Arc-left-sec">
                            <p style="color: #0b0088">The Master Mind </p>
                            <h3>THE was developed on a long lasting successful consulting carrier
                            </h3>
                            <p>Hello, I’m Jorge! the <strong> Founder of Revolving Change </strong> </p>
                            <p>I am a self-made, self-taught entrepreneur, doer, and implementer. I made a career in what I cornered as <strong> HUMAN ENGINEERIN</strong> serving managers and leaders around the world anchoring, implementing, and perpetuating the mindset, attitudes, and behaviours that are the foundation for excellence. Revolving Change is the never-ending process of self-discovery, of evolution. It demands relentless curiosity and the willingness to question oneself aspiring to always find a better way to serve. If we serve we grow.</p>
                            <a class="btn more-btn mt-5" href="<?php echo SITEURL; ?>about-us/">Learn more about me</a>
                        </div>
                       </div>
                  </div>

             </div>
        </section>

        <!-- Course Architecture section end -->


        <!-- Testimonial section start -->

        <section class="Testimonial-section pb-100 pt-100">
            <div class="section-header text-center mb-5">
                <h1>What People Are Saying</h1>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                        $testimo_rs = $db->getData("testimonial","*","isDelete=0");
                        while($testimo_d = mysqli_fetch_assoc($testimo_rs)){
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="client-box-sec">
                            <img class="Client_image" src="<?php echo SITEURL.TML.$testimo_d['image']; ?>">
                            <div class="Client_say-text">
                                <p><?=$testimo_d['description']?> </p>
                                <h5><?=$testimo_d['name']?></h5>
                                <p><em><?=$testimo_d['designation']?></em></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                 </div>
            </div>
        </section>

        <!-- Testimonial section end -->


        <!-- Stay Connected section Start  -->

        <section class="Stay_Connected-section pt-100 pb-100">
             <div class="container">
                <div class="section-header text-center mb-4 mt-5">
                    <h1>Stay Connected</h1>
                    <p>Get course updates and discounts delivered to your inbox.</p>
                </div>
                <form class="contact-form" method="post" id="stay_connected" name="stay_connected"action="<?php echo SITEURL; ?>process-stay-connected/">
                     <div class="form-group">
                         <input class="form-control" type="text" name="name" id="name" placeholder="First Name">
                     </div>
                     <div class="form-group">
                        <input class="form-control" type="text" name="email" id="email" placeholder="Email">
                    </div>
                    <!-- <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="flexCheckDefault" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault">I would like to receive future communications </label>
                    </div> -->
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="flexCheckChecked" id="flexCheckChecked" />
                        <label class="form-check-label" for="flexCheckChecked">I agree to the GDPR Terms & Conditions </label>
                    </div>
                    <div class="form-group">
                        <button class="w-100 Sign_Up-btn" type="submit" name="stay_connected_submit">Submit</button>
                    </div>
                </form>
             </div>
        </section>

        <!-- Stay Connected section End -->


        <!-- Need help section start -->

        <section class="Need_help-section pb-100 pt-100">
            <div class="container">
                 <div class="row">
                      <div class="offset-lg-2 col-lg-8">
                        <div class="section-header text-center mb-4">
                            <h1>Need help?</h1>
                            <p>We want you to take advantage of the lessons that can start your journey on developing and overcoming the daily struggles and pain in your day-to-day lives.</p>
                            <p>Join me, and many others succeed in their everyday life.</p>
                            <p><strong>Click on the link and start changing your life.</strong></p>
                            <a href="<?php echo SITEURL; ?>courses/" class="btn outline-btn mt-5">EXPLORE MORE</a>
                        </div>
                      </div>
                 </div>
            </div>
        </section>

        <!-- Need help section end -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>   

        <script type="text/javascript">
            $("#stay_connected").validate({
                rules: {
                    email:{required : true, email: true},
                    name:{required : true},
                },
                messages: {
                    email:{required:"Please enter email address.", email:"please enter valid email."},
                    name:{required:"Please enter name."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
        </script>      

    </body>
</html>
