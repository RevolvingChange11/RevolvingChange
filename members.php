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

    <section class="page-header-section members-hero-image pt-100">
        <div class="container">
            <div class="row">
                <div class="page-heading-section pt-120 pb-120">
                    <h2>Member Directory</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- page header section end  -->

    <!-- top link bar start -->
    <div class="top_link-bar">
        <div class="container">
            <div class="link-list__links">
                <a href="<?php echo SITEURL; ?>">Dashboard</a>
                <a href="<?php echo SITEURL; ?>members/">Member Directory</a>
                <a href="<?php echo SITEURL; ?>announcements">Announcements</a>
            </div>
        </div>
    </div>

    <!-- top link bar end -->

    <!-- member directory section start -->

    <section class="Member-directory pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="offset-lg-8 col-lg-4">
                    <div class="Member-directory-header">
                    <div  style="display:flex">
                        <div class="user-filter">
                             
                                <select class="filter__field" name="search-value" id="search-value" onchange="searchvalue()" style="padding-right:10%;">
                                        <option value="">Select</option>
                                        <option value="0">Verified</option>
                                        <option value="1">Not Verified</option>
                                </select>
                             
                            <div class="filter__icon"><i class="fa fa-caret-down"></i></div>
                        </div>
                        <div class="Member-search" style="display:flex">
                           
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchuser" id="searchuser">
                            <button class="btn btn-primary" onclick="searchuser()" name="Searchuserbtn"><i class="fa fa-search"></i></button>
                            <button class="btn btn-warning ml-2" name="refereshbtn" onclick="refreshdata()"><i class="fa fa-refresh"></i></button>   
                        </div>
                    </div>
                    </div>
                </div>
            </div>



            <div id="getuser"></div>
               
            

               

                
                
               
            </div>
        </div>
    </section>

    <!-- member directory section end -->
    <?php include "front_include/footer.php"; ?>
    <?php include "front_include/js.php"; ?>   
    <script type="text/javascript">
        $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_user.php",
               type: "post",
                  
               data: {
               },
               success: function(response)
               {
                  $(".siteloader").hide();
                  $("#getuser").html(response);
               }
            });

        function searchvalue()
        {
            var id=$("#search-value").val();
            $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_user.php",
               type: "post",
                  
               data: {
                val: id,
               },
               success: function(response)
               {
                  $(".siteloader").hide();
                  $("#getuser").html(response);
               }
            });
        }
        function searchuser()
        {
            var val=$("#searchuser").val();
            $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_user.php",
               type: "post",
                  
               data: {
                searchuser: val,
               },
               success: function(response)
               {
                  $(".siteloader").hide();
                  $("#getuser").html(response);
               }
            });
        }
        function refreshdata()
        {
             $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_user.php",
               type: "post",
                  
               data: {
               },
               success: function(response)
               {
                  $(".siteloader").hide();
                  $("#getuser").html(response);
               }
            });

        }
       

        
    </script>     
</body>

</html>