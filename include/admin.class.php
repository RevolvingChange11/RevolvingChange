<?php

class Admin extends Functions
{
    public function getAddButton($ctable,$ctable1,$url=null)
    {
		if($ctable!="" && $ctable1!=""){
			if($url!=null){
				?>
				<a class="btn btn-info waves-effect w-md waves-light" href="<?php echo $url; ?>" title="Add <?php echo $ctable1; ?>"><i class="fa fa-plus"></i></a>
				<?php
			}else{
				?>
				<a class="btn btn-info waves-effect w-md waves-light" href="<?php echo ADMINURL; ?>add-<?php echo $ctable; ?>/add/" title="Add <?php echo $ctable1; ?>"><i class="fa fa-plus"></i></a>
				<?php
			}
		}	
    }

	public function getUpdateButton($title='Update', $func=null, $frmId=null)
    {
    	if( $func != null )
    	{
    	?>
    		<button class="btn btn-primary waves-effect w-md waves-light" onClick="<?php echo $func; ?>();" title="<?php echo $title; ?>" style="float:right;"><i class="fa fa-bars" aria-hidden="true"></i></button>
    	<?php
    	}
    	else
    	{
			if($frmId!=null){
				?>
				<button class="btn btn-primary waves-effect w-md waves-light" onClick="document.<?php echo $frmId; ?>.submit();" title="<?php echo $title; ?>"><i class="fa fa-bars" aria-hidden="true"></i></button>
				<?php
			}else{
				?>
				<button class="btn btn-primary waves-effect w-md waves-light" onClick="document.frm.submit();" title="<?php echo $title; ?>"><i class="fa fa-bars" aria-hidden="true"></i></button>
				<?php
			}
    	}
    }

	public function getDeleteButton()
    {
		?>
		<button type="button" class="btn btn-danger waves-effect w-md waves-light" onClick="return bulk_delete();" title="Delete"><i class="fa fa-times"></i></button>
		<?php
    }

	public function getTablePaginationBlock($pagiArr){
		?>
		<div class="tablePagination" style="margin-top: 10px;">
			<div class="row">
				<div class="col-md-2">
					<div class="dataTables_info dataTables_length"> Rows Limit:
						<select id="numRecords" class="form-control input-sm" onChange="changeDisplayRowCount(this.value);">
							<option value="10" <?php if ($_REQUEST["show"] == 10 || $_REQUEST["show"] == "" ) { echo ' selected="selected"'; }  ?> >10</option>
							<option value="25" <?php if ($_REQUEST["show"] == 25) { echo ' selected="selected"'; }  ?> >25</option>
							<option value="50" <?php if ($_REQUEST["show"] == 50) { echo ' selected="selected"'; }  ?> >50</option>
							<option value="100" <?php if ($_REQUEST["show"] == 100) { echo ' selected="selected"'; }  ?> >100</option>
						</select>
					</div>
				</div>
				<div class="col-md-10">
					<div class="dataTables_paginate paging_simple_numbers text-right">
						<ul class="pagination">
						<?php 
						echo $this->paginate_function($pagiArr[0],$pagiArr[1],$pagiArr[2],$pagiArr[3]); 
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	public function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; //previous link 
			$next           = $current_page + 1; //next link
			$first_link     = true; //boolean var to decide our first link

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

	public function get_admin_menu($parent_id=0)
	{
		//echo '=====' . $_SERVER['REQUEST_URI'] . '======';
		$current_page = $_SERVER['REQUEST_URI'];
		$current_page = str_replace('/RevolvingChange/apanel/', '', $current_page);
		$current_id = $this->getValue('menu', 'parent_id', 'url = "' . $current_page . '"');

		$str = '';
		$where = " isDelete = 0 AND parent_id = " . $parent_id;
		$rs = $this->getData("menu", "*", $where, "display_order");
		if(@mysqli_num_rows($rs)>0)
		{
			$arc = 0;
			while($row = @mysqli_fetch_assoc($rs))
			{
				$arc++;
				$open = 0;

				//echo '^^^^^' . $row['url'] . '===' . $current_page . '===' . $row['id'] . '===' . $current_id . '<br />';

				if( $row['url'] == $current_page || $row['id'] == $current_id )
					$open = 1;
				if( $parent_id == 0 )
				{
					$str .= '<li class="nav-item">';
					$str .= '	<a class="nav-link';
					if( !$open )
						$str .= ' collapsed';
					$str .= '" href="' . ADMINURL.$row['url'] . '" data-toggle="collapse" data-target="#collapse_' . $arc. '" aria-expanded="true" aria-controls="collapse_' . $arc . '">';
					$str .= '		<i class="mdi mdi-format-list-bulleted"></i><span> ' . $row["name"] . ' </span> <span class="menu-arrow"></span>';
					$str .= '	</a>';
					$str .= '	<div id="collapse_' . $arc . '" class="collapse';
					if( $open )
						$str .= ' show';
					$str .= '" aria-labelledby="headingTwo" data-parent="#accordionSidebar">';
					$str .= '		<div class="collapse-inner rounded">';  //bg-white py-2 
			
					$str .= $this->get_admin_menu($row['id']);
				}
				else
				{
					$str .= '	<a class="collapse-item" href="' . ADMINURL.$row['url'] . '">' . $row['name'] . '</a>';
				}
				if( $parent_id == 0 )
				{
					$str .= '		</div>';
					$str .= '	</div>';
					$str .= '</li>';
				}
			}
		}
		return $str;
	}
}
?>
