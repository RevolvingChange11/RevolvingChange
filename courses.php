<?php
   include "connect.php";
   if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="free")
   {
      $mode=$_REQUEST['mode'];
   }
   else
   {
      $mode="";
   }
?>
<!DOCTYPE html>
<html lang="en" class="">
   <head>
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
                  <h2>Online Courses</h2>
               </div>
            </div>
         </div>
      </section>
      <!-- page header section end  -->
      <!-- Courses list section start  -->
      <section class="Courses_list-section pt-120 pb-120">
         <div class="container">
            <div class="section-header text-center mb-3">
               <h1>Our Exclusive Courses 
                  <?php
                        if($mode=="free")
                        {
                           ?>
                           <a href="<?php echo SITEURL; ?>course_pdf.php"><button class="btn btn-primary float-right">Download</button></a>
                           <?php   
                        }
                  ?>
               </h1>
            </div>
            
            <div id="course_list_html"></div>
         </div>
      </section>
      <!-- Courses list section end  -->
      <?php include "front_include/footer.php"; ?>        
      <?php include "front_include/js.php"; ?>        

      <script type="text/javascript">
         
    
         function paginate(p_id)
         {  
            $(".siteloader").show();
            $.ajax({
               url: "<?php echo SITEURL; ?>ajax_course_list.php?mode=<?php echo $mode; ?>",
               type: "post",
               data: {
                  page: p_id,
               },
               success: function(course_response)
               {
                  $(".siteloader").hide();
                  $("#course_list_html").html(course_response);
               }
            });
         }
         paginate(1);

      </script>

   </body>
</html>


