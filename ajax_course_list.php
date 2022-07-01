<?php
	include 'connect.php';
	$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

   	$num_show = 5;

   if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
	{
		$current_page = $_REQUEST['page'];
	}

	$row_fetch = $db->getTotalRecord("course","isDelete=0 AND isPublish=1");

   $total_pages = ceil($row_fetch / $num_show); 
	$start_from = ($current_page - 1) * $num_show;
	$limit = " LIMIT $start_from , $num_show";
	$order = " id DESC".$limit; 

   	$course_rs = $db->getData("course","*","isDelete=0 AND isPublish=1",$order);
   	foreach($course_rs as $course_d){

?>
    <div class="Courses_list-box">
       <div class="row">
          <div class="col-lg-6">
             <div class="Courses_images">
                <?php 
                if($course_d['image']!=="")
                {
                  if(file_exists(COURSE.$course_d['image']))
                  { ?>
                     <img src="<?php echo SITEURL.COURSE.$course_d['image']; ?>">
       <?php      } 
                  else
                  { ?>
                     <img src="<?php echo SITEURL.COURSE."placeholder.png"; ?>">
                  <?php }
               }
               else
                { ?>
                  <img src="<?php echo SITEURL.COURSE."placeholder.png"; ?>">
                <?php } ?>
             </div>
          </div>
          <div class="col-lg-6">
             <div class="Courses_details">
                <h4 class="line-bottom"><?=$course_d['name']?></h4>
                <p class="price-title"><span class="theme-color">Price</span> : <?=CURR.$course_d['price']?></p>
                <p><?=$course_d['short_description']?></p>
                <div class="course-btn mt-4">
                  <?php 
                  if($_REQUEST['mode']!="free")
                  {
                     ?>
    
                   <a class="btn view-btn" href="<?php echo SITEURL.'courses-details/'.$course_d['id'].'/'; ?>">View More</a>
                   <?php
                      $purchase_course_check = $db->getValue("purchase_history","course_id","isDelete=0 AND user_id=".$user_id." AND course_id=".$course_d['id']);
                      if (empty($purchase_course_check)) {
                   ?>
                   <a class="btn purchase-btn" href="<?php echo SITEURL.'payment/'.$course_d['id'].'/'; ?>">Purchase</a>
             		<?php } } ?>
                </div>
             </div>
          </div>
       </div>
    </div>
    <?php 
	}

	if ($total_pages>1) {
    ?>
    <!-- pagination start -->
    <div class="ps-pagination mt-5">
       <ul class="pagination">
       		<?php
       			if ($current_page>1) {
       		?>
		          	<li onclick="paginate(<?= $current_page-1; ?>);"><a href="#"><i class="fas fa-arrow-left"></i></a></li>
		    <?php
		    	}
       			for($i=1; $i<=$total_pages; $i++){
       		?>
					<li class="<?php if($current_page==$i){ echo "active"; } ?>" onclick="paginate(<?=  $i; ?>);"><a href="#"><?=$i?></a></li>
	        <?php 
	    		}
	        	if($current_page < $total_pages)
	        	{
	        ?>	
	          	<li onclick="paginate(<?= $current_page+1; ?>);"><a href="#"><i class="fas fa-arrow-right"></i></a></li>
	        <?php
	    		}
	        ?>
       </ul>
    </div>
    <?php } ?>