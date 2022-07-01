<?php
	header('Content-Type: application/json');
	include("connect.php");

	if($_REQUEST['img'] == 'courseimg')
	{
		$IMAGENM_SLUG 	= "_course";
		$IMAGEPATH_T 	= COURSE_T;
		$IMAGEPATH_A 	= COURSE_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}
	
	else if($_REQUEST['img'] == 'moduleimg')
	{
		$IMAGENM_SLUG 	= "_module";
		$IMAGEPATH_T 	= MODULE_T;
		$IMAGEPATH_A 	= MODULE_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'testimonial')
	{
		$IMAGENM_SLUG 	= "_tml";
		$IMAGEPATH_T 	= TML_T;
		$IMAGEPATH_A 	= TML_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}
	else if($_REQUEST['img'] == 'blogimg')
	{
		$IMAGENM_SLUG 	= "_bl";
		$IMAGEPATH_T 	= BLOG_T;
		$IMAGEPATH_A 	= BLOG_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	print json_encode($response);
?>