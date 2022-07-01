<?php
    include("connect.php");
    $ctable     = "user";
    $ctable1    = "user";
    $page       = "user";

    $where="";
    $where.="isDelete=0";
    if(isset($_REQUEST['searchuser']) && $_REQUEST["searchuser"]!="")
    {
        $where.=" AND name like '".$_REQUEST['searchuser']."%'";
        
    }
    if(isset($_POST['val']) && $_POST["val"]!="")
    {
        $where.=" AND isActive=".$_REQUEST['val'];
        
    }

    $getusers=$db->getData("user","*",$where);

?>
<div class="row">
    <?php 
        while($user_row=mysqli_fetch_assoc($getusers))
        {
    ?>          
            <div class="col-lg-4 mb-4">
                <a href="<?php echo SITEURL; ?>members-details/<?php echo $user_row['id']; ?>/">
                    <div class="member-box-dir">
                        <img class="member__avatar" src="<?php echo SITEURL; ?>images/home/default_avatar.webp">
                            <h4 class="member__name"><?php echo $user_row['name']; ?></h4>
                      
                    </div>
                </a>
            </div>      
<?php   } ?>
</div>
