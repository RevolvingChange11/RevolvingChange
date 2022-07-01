<?php
    include "connect.php";
    $get_data_Sql=$db->getData("announcements","*","isDelete=0");
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

    <section class="page-header-section Announcements-hero-image pt-100">
        <div class="container">
            <div class="row">
                <div class="page-heading-section pt-120 pb-120">
                    <h2>Announcements</h2>
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
                <a href="#">Announcements</a>
            </div>
        </div>
    </div>

    <!-- top link bar end -->

    <!-- Announcements section start -->

    <section class="Announcements-section  pt-100 pb-100">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-5">
                     <div class="announcements__title">
                          <h3>Course Announcements</h3>
                     </div>
                 </div>
                <div class="col-lg-7">
                    <div class="announcements__header">
                        <div class="user-filter">
                            <select class="filter__field" name="search-value" id="select-value" onChange="searchannouncementsselect()">
                                <option value="">Select</option>
                                <?php
                                    $get_data_Sql1=$db->getData("announcements","*","isDelete=0");
                                    while($get_data1=mysqli_fetch_assoc($get_data_Sql1))
                                    {
                                        //$get_course=$db->getData("course","*","id=".$get_data1['course_id']."");
                                        //$get_course_row=mysqli_fetch_assoc($get_course);
                                        ?>
                                            <option value="<?php echo $get_data1['id']; ?>"><?php echo $get_data1['title']; ?></option>

                                        <?php
                                    }

                                ?>
                             </select>
                            <div class="filter__icon"><i class="fa fa-caret-down"></i></div>
                        </div>
                        <div class="Member-search">
                            <form class="d-flex"  action="." method="post">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchbar1" id="searchbar1">
                            <button type="button" onclick="searchannouncements()" class="btn btn-primary float-right" name="btn_search" id="btn_search" ><i class="fa fa-search"></i></button>
                            <button class="btn btn-warning ml-2" name="refereshbtn"  type="button" onclick="refreshdata()"><i class="fa fa-refresh"></i></button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if(mysqli_num_rows($get_data_Sql)==0)
                { ?>
                    <div class="row">
                       <div class="col-lg-12">
                           <p class="announcements__no-results">No Results</p>
                       </div> 
                    </div>
                <?php } ?>

        </div>
    </section>

    <!-- Announcements section end -->

    <!-- site Announcements start -->
    <?php 

        if(mysqli_num_rows($get_data_Sql)>0)
        { ?>
            <section class="Site-announcements pt-120 pb-120">
                <div class="container">
                    <div class="section-header">
                        <!-- <h2>Site Announcements</h2> -->
                    </div>
                    
                    <div id="myDiv">
                    <?php
                        while($rows1=mysqli_fetch_assoc($get_data_Sql))
                        { ?>
                            <a href="<?php echo SITEURL; ?>courses-details/<?php echo $rows1['course_id']; ?>"
                                style="color: black;">
                            <div class="announcements-block">
                              <!-- <p>Site Announcement</p> -->
                              <h3><?php echo $rows1['title']; ?></h3>
                              <?php 
                            $get_course=$db->getData("course","*","id=".$rows1['course_id']."");
                            $get_course_row=mysqli_fetch_assoc($get_course);
                        ?>
                        <p>We are excited to announce the release of our new course, <?php echo $get_course_row['name']; ?>.</p>
                              <p><?php echo $rows1['des']; ?></p>
                            </div></a>
                            <div><br><br></div>

                  <?php  } ?>
                    </div>
                <div id="newdiv"></div>
                          
                </div>
            </section>
 <?php } ?>


    <!-- site Announcements end -->
    <?php include "front_include/footer.php"; ?>
    <?php include "front_include/js.php"; ?>     
    <script type="text/javascript">
        function searchannouncementsselect()
        {
            var id=$("#select-value").val();
            //alert(id);
            //console.log("dsh");
            var element = document.getElementById("myDiv");
            $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_announcements.php",
               type: "post",
                  
               data: {
                id : id
               },
               success: function(response)
               {
                    $("#newdiv").html(response);
                    element.style.display = "none";

               }
            });

        }
        function searchannouncements()
        {
            var title=$("#searchbar1").val();
            //alert(title);
            //console.log("dsh");
            var element = document.getElementById("myDiv");
            $.ajax({
               url: "<?php echo SITEURL; ?>ajax_get_announcements.php",
               type: "post",
                  
               data: {
                title : title
               },
               success: function(response)
               {
                    $("#newdiv").html(response);
                    element.style.display = "none";

               }
            });

        }
        function refreshdata()
        {
             location.reload();

        }
    </script>   
</body>

</html>