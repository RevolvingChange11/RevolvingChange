<?php 
	include 'connect.php';
	require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

	
	$order = " id DESC"; 
$html='';
   	$course_rs = $db->getData("course","*","isDelete=0 AND isPublish=1",$order);
   	$html.='<img src="'.SITEURL.'images/logo/main-logo.png" style="width: 445px;height:192px; padding-left:100px" />';
   	$html.='<h1><center>Our Exclusive Courses</center></h1>';
   	while ($course_d=mysqli_fetch_assoc($course_rs))
   	{




$html.='<div class="Courses_list-box">
       <div class="row">

          <div class="col-lg-6">
             <div class="Courses_images">';
  
                if($course_d['image']!=="")
                {
                  if(file_exists(COURSE.$course_d['image']))
                  { 
                     
                    // $html.=$mpdf->Image(SITEURL.COURSE.$course_d['image'], 0, 0, 210, 297, 'jpg', '', true, false);
                     $html.='<img src="'.SITEURL.COURSE.$course_d["image"].'">';
       		      } 
                  else
                  { 
                     $html.='<img src="'.SITEURL.COURSE.'placeholder.png" style="width: 645px;height:392px;">';
               }
                  }
               else
                { 
                  
                  //$html.=$mpdf->Image(SITEURL.COURSE.'placeholder.png', 0, 0, 210, 297, 'jpg', '', true, false);
                	$html.='<img src="'.SITEURL.COURSE.'placeholder.png" style="width: 645px;height:392px;">';
               }
             $html.='</div>
          </div>
          <div class="col-lg-6">
             <div class="Courses_details">
                <h4 class="line-bottom">'.$course_d['name'].'</h4>
                <p class="price-title"><span class="theme-color">Price</span> : <b>$</b> '.$course_d['price'].'</p>
                <p>'.$course_d['short_description'].'</p>';
            
                $html.='
               
             </div>
          </div>
       </div>
    </div>';
}
mkdir("upload");
$filenm="upload/course_".time().".pdf";
$mpdf->WriteHTML($html);

$mpdf->Output($filenm,'F');
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.basename($filenm).'"');

header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');/*

header('Content-Length: ' . filesize($filenm));
*/
flush(); // Flush system output buffer
readfile($filenm);
exit;

?>