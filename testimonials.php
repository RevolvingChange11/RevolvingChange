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
      <section class="page-header-section about-hero-image pt-100">
         <div class="container">
            <div class="row">
               <div class="page-heading-section pt-120 pb-120">
                  <h2>Testimonials</h2>
               </div>
            </div>
         </div>
      </section>
      <!-- page header section end  -->
      <section class="Testimonial-section page pb-100 pt-100 my-5">
         <div class="section-header text-center mb-5">
            <h1>What People Are Saying</h1>
         </div>
         <div class="container">
            <div class="row">
               <?php
                  $testimonial_rs = $db->getData("testimonial","*","isDelete=0");
                  while($testimonial_d = mysqli_fetch_assoc($testimonial_rs)){
               ?>
               <div class="col-lg-4 col-md-6">
                  <div class="client-box-sec box-gray">
                     <img class="Client_image" src="<?php echo SITEURL; ?>images/testimonial/tempImg/<?=$testimonial_d['image']?>">
                     <div class="Client_say-text">
                        <p><?=$testimonial_d['description']?> </p>
                        <h5><?=$testimonial_d['name']?></h5>
                        <p><em><?=$testimonial_d['designation']?></em></p>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </section>
      <?php include "front_include/footer.php"; ?>
      <?php include "front_include/js.php"; ?>  
   </body>
</html>