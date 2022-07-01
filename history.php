<?php
    include "connect.php";
    $db->checkLogin();
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>
        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include "front_include/css.php"; ?>

        <!-- Data Table -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    </head>

    <body>
        <?php include "front_include/header.php"; ?>        

        <!-- Profile page section start -->

        <section class="Profile_page-section pt-100">
             <div class="container-fluid">
                  <div class="row">
                       <?php include 'front_include/left_menu.php' ?>
                       <div class="col-lg-9">
                        <div class="payment-section">
                       
                            <div class="table-responsive"> 
                                 <table id="payment-history" class="table">
                                <thead>
                                    <tr>
                                        <th>Course Image </th>
                                        <th>Course Name </th>
                                        <th>Amount </th>
                                        <th>Payment Method</th>
                                        <th>Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $purchase_hist_rs = $db->getData("purchase_history", "*", "isDelete=0 AND user_id=".$user_id);
                                        while($purchase_hist_d = mysqli_fetch_assoc($purchase_hist_rs)){
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user-name-table-fix">
                                                <p>02</p>  
                                                <img src="<?php echo SITEURL; ?>images/home/coures-1.jpg">
                                            </div>
                                        </td>
                                        <td><?php echo $purchase_hist_d['course_name']; ?></td>
                                        <td><?php echo CURR.$purchase_hist_d['amount']; ?> USD</td>
                                        <td>
                                            <?php 
                                                if ($purchase_hist_d['payment_method'] == '1') {
                                                    echo "Credit/Debit Card";
                                                }
                                                elseif($purchase_hist_d['payment_method'] == '2'){
                                                    echo "PayPal";
                                                }
                                            ?>
                                        </td>
                                        <td><div class="payment-received"><p>
                                        <?php 
                                            if ($purchase_hist_d['status'] == 1) {
                                                echo "Completed";
                                            }
                                            elseif ($purchase_hist_d['status'] == 2) {  
                                                echo "Failed";
                                            } 
                                        ?>
                                        <!-- </p><span class="share-dots"><a href="<?php echo SITEURL ?>online-module/<?php echo $purchase_hist_d['course_id'].'/'; ?>">Module</a></span></div></td> -->
                                    </tr>
                                    <?php } ?>
                                </tbody>
                               
                                </table>
                            </div>
                         </div> 
                       </div>
                  </div>
             </div>
        </section>

        <!-- Profile page section end -->
    
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>  

        <!-- Data Table js -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script>
            $('#payment-history').DataTable({ 
				select: false,
				"columnDefs": [{
					className: "Name", 
					
					"visible": false,
					"searchable":false
				}]
			});
          </script>
          
    </body>
</html>
