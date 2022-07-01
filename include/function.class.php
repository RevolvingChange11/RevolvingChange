<?php
class Functions 
{
	/** Local Database Detail **/
  
	protected $db_l_host = "localhost";
	protected $db_l_user = "root";
	protected $db_l_pass = "";
	protected $db_l_name = "jrr2401";
	
	/** Live Database Detail **/
	
	protected $db_host = "localhost";
	protected $db_user = "finityco_revolvingchange";
	protected $db_pass = 'mgG$46P]E!hx';
	protected $db_name = "finityco_revolvingchange"; 
	
	protected $con = false; 
	public $myconn; 
	
	function __construct() {
		global $myconn;

		if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'pc-54' || $_SERVER['HTTP_HOST'] == 'pc-50' || $_SERVER['HTTP_HOST'] == '192.168.0.111'){ 

			$myconn = @mysqli_connect($this->db_l_host, $this->db_l_user, $this->db_l_pass, $this->db_l_name);
		} else {
			$myconn = @mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		}
		
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();die;
		}
	}

	public function getData($table, $rows = '*', $where = null, $order = null,$die=0) // Select Query, $die==1 will print query
	{		
		$results = array();
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($order != null)
			$q .= ' ORDER BY '.$order;
		 //echo $q;
		if($die==1){ echo $q;die; }

		$results = @mysqli_query($GLOBALS['myconn'],$q);
		return $results;
	}
	
	public function getValue($table, $row=null, $where=null,$die=0) // single records ref HB function
	{
		if($row!=null && $where!=null)
		{
			$q = 'SELECT '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){ echo $q;die; }
			if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	public function getMaxVal($table, $row=null, $where=null,$die=0)
	{
		if($row!=null && $where!=null)
		{
			$q = 'SELECT MAX('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	public function getMinVal($table, $row=null, $where=null,$die=0)
	{
		if($row!=null && $where!=null)
		{
			$q = 'SELECT MIN('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	
	public function getSumVal($table, $row=null, $where=null,$die=0)
	{
		if($row!=null && $where!=null)
		{
			$q = 'SELECT SUM('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	
	public function getAvgVal($table, $row=null, $where=null,$die=0)
	{
		if($row!=null && $where!=null)
		{
			$q = 'SELECT AVG('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	
	public function getTotalRecord($table, $where = null,$die=0) // return number of records
	{
		$q = 'SELECT * FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
		return mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))+0;
	}
	
	public function getTotalRecord_JoinData2($table, $join, $where = null, $die=0) // return number of records
	{
		$q = 'SELECT * FROM '.$table . $join;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
		return mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))+0;
	}

	public function insert($table,$rows,$die=0) // insert - Insert and Die Values 
    {	
        $insert = 'INSERT INTO '.$table.' SET ';
        $keys = array_keys($rows);

        for($i = 0; $i < count($rows); $i++)
       	{
            if(is_string($rows[$keys[$i]]))
            {
                $insert .= $keys[$i].'="'.$rows[$keys[$i]].'"';
            }
            else
            {
                $insert .= $keys[$i].'='.$rows[$keys[$i]];
            }
            if($i != count($rows)-1)
            {
                $insert .= ',';
            }
        }
       // echo $insert . '<br /><br />';

		if($die==1){
			echo $insert;die;
		}
        $ins = @mysqli_query($GLOBALS['myconn'],$insert);           
        if($ins)
        {
			$last_id = mysqli_insert_id($GLOBALS['myconn']);
            return $last_id;
        }
        else
        {
           return false;
		}
    }
    public function update($table,$rows,$where,$die=0) //update query
	{
		// Parse the where values
		// even values (including 0) contain the where rows
		// odd values contain the clauses for the row
		//print_r($where);die;
		
		$update = 'UPDATE '.$table.' SET ';
		$keys = array_keys($rows);
		for($i = 0; $i < count($rows); $i++)
		{
			if(is_string($rows[$keys[$i]]))
			{
				$update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
			}
			else
			{
				$update .= $keys[$i].'='.$rows[$keys[$i]];
			}
			 
			// Parse to add commas
			if($i != count($rows)-1)
			{
				$update .= ',';
			}
		}
		$update .= ' WHERE '.$where;
		if($die==1){
			echo $update;die;
		}
		//$update = trim($update," AND");
		$query = @mysqli_query($GLOBALS['myconn'],$update);
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function delete($table,$where = null,$die=0)
	{
		if($where != null)
		{
			$delete = 'DELETE FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $delete;die;
			}
			$del = @mysqli_query($GLOBALS['myconn'],$delete);
		}
		if($del)
		{
			return true;
		}
		else
		{
		   return false;
		}
	}
	
	public function limitChar($content,$limit,$url="javascript:void(0);",$txt="&hellip;")
	{
		if(strlen($content)<=$limit){
			return $content;
		}else{
			$ans = substr($content,0,$limit);
			if($url!=""){
				$ans .= "<a href='$url' class='desc'>$txt</a>";
			}else{
				$ans .= "&hellip;";
			}
			return $ans;
		}
	}
	
	public function dupCheck($table, $where = null,$die=0) // Duplication Check
	{
		$q = 'SELECT id FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){ echo $q;die; }
		$results = @mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q));
		if($results>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function location($redirectPageName=null) // Location
	{
		if($redirectPageName==null){
			header("Location:".$this->SITEURL);
			exit;
		}else{
			header("Location:".$redirectPageName);
			exit;
		}
	}
	
	public function getDisplayOrder($table,$where=null,$die=0) // Display Order
	{
		$q = 'SELECT MAX(display_order) as display_order FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
		$results = @mysqli_query($GLOBALS['myconn'],$q);
		if(@mysqli_num_rows($results)>0){
			$disp_d = mysqli_fetch_assoc($results);
			return intval($disp_d['display_order'])+1;
		}else{
			return 1;
		}
	}
	
	public function createSlug($string)    // Slug
	{   
		$slug = strtolower(trim(preg_replace('/-{2,}/','-',preg_replace('/[^a-zA-Z0-9-]/', '-', $string)),"-"));
		return $slug;
	}
	
	public function num($val,$deci="2",$sep=".",$thousand_sep="", $trim_float_zero="true"){
		if( $trim_float_zero )
			return str_replace( $sep.'00', '', number_format($val,$deci,$sep,$thousand_sep) );
		else
			return number_format($val,$deci,$sep,$thousand_sep);
	}
	
	public function get_client_ip(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		  
		return $ipaddress;
	}
	
	public function clean($string)
	{
		$string = trim($string);			// Trim empty space before and after

		// Remove for version 8.1
		
		// if(get_magic_quotes_gpc()) {
		// 	$string = stripslashes($string);	// Stripslashes
		// }
		$string = stripslashes($string);	// Stripslashes
		$string = mysqli_real_escape_string($GLOBALS['myconn'],$string);	// mysql_real_escape_string
		return $string;
	}

	function convertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe width=\"100%\" height=\"250\" src=\"//www.youtube.com/embed/$2\" allowfullscreen frameborder=\"0\"></iframe>",
			$string
		);
	}
	
	public function checkLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) || $_SESSION[SESS_PRE.'_SESS_USER_ID']==""){
			$_SESSION[SESS_PRE.'_FAIL_LOG'] = "1";
			if($url==""){
				$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(SITEURL.'login/');
			}else{
				$this->location($url);
			}
		}
	}
	
	public function checkAdminLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) || $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']==""){
			if($url==""){
				$_SESSION['adminbackUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(ADMINURL);
			}else{
				$this->location($url);
			}
		}
    }
	
	public function printr($val,$isDie=1){
		echo "<pre>";
		print_r($val);
		if($isDie){die;}
	}

	public function CheckRemember(){
		if(isset($_COOKIE['SESS_COOKIE']) && $_COOKIE['SESS_COOKIE']>0){
			$_SESSION[SESS_PRE.'_SESS_USER_ID']=$_COOKIE['SESS_COOKIE'];
		}
	}

	public function Date($date, $format="m/d/Y H:i A"){
		return date_format(date_create($date),$format);
	}

	public function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$pagination .= '<div class="gallery-pagination">';
			$pagination .= '<div class="gallery-pagination-inner">';
			$pagination .= '<ul class="all_pages_list">';
			
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; //previous link 
			$next           = $current_page + 1; //next link
			$previous_new   = $current_page - 1; //next link
			$first_link     = true; //boolean var to decide our first link
			
			if($current_page > 1){
				$previous_link = ($previous_new==0 || $previous_new==-1)? 1: $previous_new;
				$pagination .= '<li class="first"><a class="pagination-prev" href="#" data-page="1" title="First"><<</a></li>'; //first link
				$pagination .= '<li><a class="pagination-prev" href="#" data-page="'.$previous_link.'" title="Previous"><</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="first active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="last active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}
					
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}
			if($current_page < $total_pages){ 
					$next_link = ($i > $total_pages) ? $total_pages : $i;
					$pagination .= '<li><a class="pagination-next" href="#" data-page="'.$next.'" title="Next">></a></li>'; //next link
					$pagination .= '<li class="last"><a class="pagination-next" href="#" data-page="'.$total_pages.'" title="Last">>></a></li>'; //last link
			}
			
			$pagination .= '</ul>'; 
			$pagination .= '</div>'; 
			$pagination .= '</div>';
		}
		return $pagination; //return pagination links
	}
	public function paginate_function_front($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; 
			$next           = $current_page + 1; 
			$first_link     = true; 

			if($current_page > 1){
				$previous_link = ($previous<=0)?1:$previous;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li class="paginate_button "><a href="#"  data-page="'.$i.'" aria-controls="datatable1" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}
			
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}

			if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages)? $total_pages : $i;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
			}
		}
		return $pagination; //return pagination links
	}
	
	public function getJoinData($table1,$table2,$join_on,$rows = '*',$where = null, $order = null,$die=0) // Select Query, $die==1 will print query
	{
		$results = array();
		$q = 'SELECT '.$rows.' FROM '.$table1." JOIN ".$table2." ON ".$join_on;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($order != null)
			$q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }

		if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			return $results;
		}else{
			return false;
		}
	}
	
	public function getJoinData2($table, $join, $rows = '*', $where = null, $order = null,$die=0) // Select Query, $die==1 will print query
	{
		$results = array();
		$q = 'SELECT '.$rows.' FROM '.$table. $join;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($order != null)
			$q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }
		if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			return $results;
		}else{
			return false;
		}
	}
	
	public function GetNotificationTxt($ntype1,$ntype){
		return constant($ntype);
	}
	public function GetJobNotificationLink($ntype,$jid,$prop_id=0){
		$url = "javascript:void(0);";
		switch ($ntype) {
			case "JOB_APPLY":
				return SITEURL."buyer/my-jobs/proposals/".$jid."/";
				break;
			case "JOB_AWARD":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			case "JOB_DECLINE":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			case "JOB_QUERY_ASK":
				return SITEURL."job/".$jid."/#queryMain";
				break;
			case "JOB_QUERY_REPLY":
				return SITEURL."job/".$jid."/#queryMain";
				break;
			case "JOB_INVOICE":
				return SITEURL."buyer/my-jobs/proposals/".$jid."/view/".$prop_id."/";
				break;
			case "JOB_PAYMENT_RELEASE":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			default:
				return "javascript:void(0);";
				break;
		}
	}
	public function GetServiceNotificationLink($ntype,$sid=0,$oid=0){
		$url = "javascript:void(0);";
		switch ($ntype) {
			case "SERVICE_PURCHASE":
				return SITEURL."seller/work-queue/".$oid."/view/";
				break;
			case "SERVICE_STATUS":
				return SITEURL."buyer/orders/".$oid."/view/";
				break;
			case "SERVICE_CONFIRM":
				return SITEURL."seller/work-queue/".$oid."/view/";
				break;
			default:
				return "javascript:void(0);";
				break;
		}
	}
	public function generateRandomString($length = 10, $include_date = true) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		if( $include_date )
		{
			//$randomString .= '-'.date('YmdHis');
			$randomString .= '-'.time();
		}
		return $randomString;
	}
	
	public function getStar($star)
	{
		if($star=='0.5')
		{
			return 'detail-rating-half';
		} else if($star=='1')
		{
			return 'detail-rating-1';
		} else if($star=='1.5')
		{
			return 'detail-rating-half-1';

		} else if($star=='2')
		{
			return 'detail-rating-2';

		} else if($star=='2.5')
		{
			return 'detail-rating-half-2';

		} else if($star=='3')
		{
			return 'detail-rating-3';

		} else if($star=='3.5')
		{
			return 'detail-rating-half-3';

		} else if($star=='4')
		{
			return 'detail-rating-4';

		} else if($star=='4.5')
		{
			return 'detail-rating-half-4';

		} else if($star=='5')
		{
			return 'detail-rating-5';
		}
	}

	public function get_lat_long($address){

		$address = str_replace(" ", "+", $address);

		$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyAUQcF7ZrTLD1IUQ9UQErTGhpxQjz_x6ys");
		$json = json_decode($json);
		print_r($json);die();
		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		return $lat.','.$long;
	}


	public function custom_echo($x, $length)
	{
	  	if(strlen($x)<=$length)
	  	{
	    	echo $x;
	  	}
	  	else
	  	{
	    	$y=substr($x,0,$length) . '...';
	    	echo $y;
	  	}	
	}

}

include("admin.class.php");
include("cart.class.php");
?>