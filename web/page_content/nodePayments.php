<?php 
$cur = "$";
$paystub_query = "SELECT * FROM `$database_sql`.`paystubs` ORDER BY `period` ASC;";
$paystub_result = mysqli_query($sql, $paystub_query);
$paystub_total = mysqli_num_rows($paystub_result);
$paystub_row = mysqli_fetch_assoc($paystub_result);

do {
	$array[] = $paystub_row['period'];	
} while ($paystub_row = mysqli_fetch_assoc($paystub_result));  

$array_unique = array_unique($array);
$array_unique = array_values($array_unique);
$array_unique_count = count($array_unique);
?>


<?php 
function formatSize($bytes,$decimals=2){
    $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1000,$factor)).@$size[$factor];
}
?>

<div class="container-fluid">
<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Payment History</h1>
                        <a href="./?page=dockerView" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
                    </div>

                    <!-- Content Row --><!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Payment History</h6>
                                  <a href="include_content/scripts/nodes/paystubs.php?redirect=nodePayments" class="d-none d-sm-inline-block ">Refresh Data</a>
                              </div>
                                <div class="card-body py-3">

									<table width="100%" border="0" cellspacing="0" cellpadding="8">
  <tbody>
    <tr>
      <th scope="col">Month</th>
      <th scope="col">Owed</th>
      <th scope="col">Held</th>
      <th scope="col">Paid</th>
      <th scope="col">Distributed</th>
    </tr>
	  <tr>
<?php $count = 0;
	  $total_distro = 0;
	  do { 
$month = $array_unique[$count];
$monthly_query = "SELECT * FROM `$database_sql`.`paystubs` where period = '$month';";
$monthly_result = mysqli_query($sql, $monthly_query);
$monthly_total = mysqli_num_rows($monthly_result);
$monthly_row = mysqli_fetch_assoc($monthly_result);
$monthly_held = 0;
$monthly_owed = 0;
$monthly_disposed = 0;
$monthly_paid = 0;
$monthly_distro = 0;

	do{		
		
		$monthly_held = $monthly_held+$monthly_row['held'];
		$monthly_owed = $monthly_owed+$monthly_row['owed'];
		$monthly_disposed = $monthly_disposed+$monthly_row['disposed'];
		$monthly_paid = $monthly_paid+$monthly_row['paid'];
		$monthly_distro = $monthly_distro+$monthly_row['distributed'];
		$total_distro = $total_distro+$monthly_row['distributed'];
		
	} while ($monthly_row = mysqli_fetch_assoc($monthly_result));  
	  ?>

      <td nowrap="nowrap"><strong><?php echo date("M Y",strtotime($month."-01")); ?></strong></td>
      <td><?php echo $cur.number_format($monthly_owed/1000000,2); ?></td>
      <td><?php echo $cur.number_format($monthly_held/1000000,2); ?></td>
      <td><?php echo $cur.number_format($monthly_paid/1000000,2); ?></td>
      <td><?php echo $cur.number_format($monthly_distro/1000000,2); ?></td>
      </tr>
<?php $count = $count+1; }while($array_unique_count!=$count); ?>
	  <tr>
	    <td nowrap="nowrap">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td><strong><?PHP echo $cur.number_format($total_distro/1000000,2); ?></strong></td>
	    </tr>    
	  <tr>
      <td colspan="5">&nbsp;</td>
      </tr>
  </tbody>
</table> 
                              </div>
                        </div>     
                    </div>
                    </div>
                    
					<!--- ROW --><!-- Content Row -->
	
	
	
