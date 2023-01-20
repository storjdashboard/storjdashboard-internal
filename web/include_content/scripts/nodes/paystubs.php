<?php require_once("../../../cfg.php"); ?>
<?php require_once("../../../Connections/sql.php"); ?>
<?php require_once("../../restrict.php"); ?>
<?php 

$nodes_query = "SELECT * FROM $database_sql.nodes order by ip asc;";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_total = mysqli_num_rows($nodes_result);
$nodes_row = mysqli_fetch_assoc($nodes_result);

if($nodes_total>0){
			//TRUNCATE `paystubs`;
$truncate_paystubs_query = "TRUNCATE `$database_sql`.`paystubs`;";
$truncate_paystubs_result = mysqli_query($sql, $truncate_paystubs_query);

}else{
$truncate_paystubs_query = "TRUNCATE `$database_sql`.`paystubs`;";
$truncate_paystubs_result = mysqli_query($sql, $truncate_paystubs_query);	
	echo "no data"; header("location: ../../../"); exit;
}
?>

<?php 

// timeout 
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 10,  //1200 Seconds is 20 Minutes	
    )
));
//////////////////////
?>
<?php do { // start nodes repeat 
// repeat variables
	// variables
$ip = $nodes_row['ip'];
$port = $nodes_row['port'];

$lastMonth = date("Y-m",strtotime("-1 month"));
// get api data 
$jsonobj = file_get_contents("http://$ip:$port/api/heldamount/paystubs/2000-01/$lastMonth", false, $ctx);
$arr = json_decode($jsonobj, true);
	
// table variables
	$table_total = count($arr);
	//echo "<pre>";
	//print_r($arr);
	//echo "</pre>";
?>

<?php 
	echo $ip.":".$port; ?>
<br>
<table width="90%" border="1" cellpadding="5" cellspacing="0">
  <tbody>
    <tr>
      <td>result</td>
    </tr>
<?php 
	$current_TableCount = 0;
	do { 
		  $month = $arr["$current_TableCount"]['period'];
		  $created = $arr["$current_TableCount"]['created'];
		  $sat = $arr["$current_TableCount"]['satelliteId'];
		  $owed = $arr["$current_TableCount"]['owed'];
		  $held = $arr["$current_TableCount"]['held'];
		  $paid = $arr["$current_TableCount"]['paid'];
		  $dist = $arr["$current_TableCount"]['distributed'];
		  $disposed = $arr["$current_TableCount"]['disposed'];
		
		// insert sql
		
		//INSERT INTO `$database_sql`.`paystubs` (`satelliteId`, `period`, `created`, `held`, `owed`, `disposed`, `paid`, `distributed`) VALUES ('$sat', '$month', '$created', '$held', '$owed', '$disposed', '$paid', '$dist');
		
$insert_query = "INSERT INTO `$database_sql`.`paystubs` (`satelliteId`, `period`, `created`, `held`, `owed`, `disposed`, `paid`, `distributed`) VALUES ('$sat', '$month', '$created', '$held', '$owed', '$disposed', '$paid', '$dist');";
$insert_result = mysqli_query($sql, $insert_query);
	  ?>	  

<?php $current_TableCount = $current_TableCount+1; 
	}while($current_TableCount<$table_total); ?>
    <tr>
      <td>Total Rows Added:<?php echo $table_total; ?><br>
		  Last Created:<?php echo $created; ?>
</td>
    </tr>
  </tbody>
</table>
<?php } while ($nodes_row = mysqli_fetch_assoc($nodes_result)); ?>
<?php if(isset($_GET['redirect'])){
if($_GET['redirect']=='nodePayments'){
?>
<script>window.location.replace("../../../?page=nodePayments");</script>
<?php 
}else{ ?>
<script>window.location.replace("../../../");</script>
<?php } 
}?>