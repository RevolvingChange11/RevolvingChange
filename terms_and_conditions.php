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

        <!-- terms-and-conditions section start  -->

        <section class="terms-conditions pt-100 pb-100">
               <div class="container">
                    <div class="ps-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="#">Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Terms and Conditions</li>
                        </ol>
                    </div>
                    <div class="terms-condition-box">
                        <?php echo $db->getValue("static_page","descr","title='Terms & Conditions'"); ?>
                    </div>
               </div>
        </section>

        <!-- terms-and-conditions section end  -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>        
    </body>
</html>
