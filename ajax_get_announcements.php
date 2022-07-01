<?php
include "connect.php";
error_reporting(0);
if($_REQUEST['id']!="" && !empty($_REQUEST['id']))
{
	$get_data_Sql=$db->getData("announcements","*","isDelete=0 AND id=".$_REQUEST['id']."");
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
  <?php }
}

		if($_REQUEST['title']!="" && !empty($_REQUEST['title']))
		{
			$ctable_where="";
			$ctable_where .= " (
			title like '%".$db->clean($_REQUEST['title'])."%' 
		) AND ";   
		$ctable_where .= "isDelete=0";    

		$get_data_Sql=$db->getData("announcements","*",$ctable_where);
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
				<?php }
			}
		?>