<?php require_once("../../../cfg.php"); ?>
<?php require_once("../../../Connections/sql.php"); ?>
<?php if($config_row['allow-ip-list']!=null){
	require_once("../../../include_content/allow-ip-range.php");
	if($in_range!=1){
		if($config_row['restrict']==1){ require_once($resitrct_file); } 
	}
}else{
	if($config_row['restrict']==1){ require_once($resitrct_file); } 
} ?>
<?php 
// first month 
//SELECT * FROM `$database_sql`.`paystubs` ORDER BY `period` ASC LIMIT 1;
$stubs_query = "SELECT * FROM `$database_sql`.`paystubs` ORDER BY `period` ASC LIMIT 1;";
$stubs_result = mysqli_query($sql, $stubs_query);
$stubs_total = mysqli_num_rows($stubs_result);
$stubs_row = mysqli_fetch_assoc($stubs_result);

if($stubs_total<1){
	echo "0.00"; exit;
}

$FirstMonth = $stubs_row['period'];
$stubs_query = "SELECT * FROM `$database_sql`.`paystubs` ORDER BY `period` DESC LIMIT 1;";
$stubs_result = mysqli_query($sql, $stubs_query);
$stubs_row = mysqli_fetch_assoc($stubs_result);
$LastMonth = $stubs_row['period'];



$count = 0;
$Total_Paid_Val = 0;
$Total_Held_Val = 0;
$Total_Distributed_Val = 0;

do{
	
$Total_paid = 0;
$Total_distributed = 0;
$Total_held = 0;

$nextMonth_Unix = strtotime("+$count month",strtotime($FirstMonth));
$nextMonth = date("Y-m",$nextMonth_Unix);
$count = $count+1;

//echo "<br>";
//echo $FirstMonth;

$stubs_query = "SELECT * FROM `$database_sql`.`paystubs` WHERE `period` = '$nextMonth';";
$stubs_result = mysqli_query($sql, $stubs_query);
$stubs_total = mysqli_num_rows($stubs_result);
$stubs_row = mysqli_fetch_assoc($stubs_result);
	
	
	// repeat for each row found 
	do{
		//echo "Sat> ".$stubs_row['satelliteId']." | Paid> ".$stubs_row['paid']."<br>"; //DEBUG INFO
		
	$Total_held = $Total_held+$stubs_row['held'];	
	$Total_paid = $Total_paid+$stubs_row['paid'];
	$Total_distributed = $Total_distributed+$stubs_row['distributed'];
	
	} while ($stubs_row = mysqli_fetch_assoc($stubs_result));
	
	//DEBUG DATA	
	//
	//echo $nextMonth;echo "<br>";echo "Nodes: ".($stubs_total/6)." | Rows: ".$stubs_total." | Paid: $".number_format($Total_paid/1000000,3)." | Distributed: $".number_format($Total_distributed/1000000,3)." | Held: ".number_format($Total_held/1000000,3);echo "<br>";
	
	//set variables 
	$Data_Month = $nextMonth;
	$Total_Nodes = $stubs_total/6;
	$Total_Rows = $stubs_total;
	
	$Total_Paid_Month = number_format($Total_paid/1000000,3);
	$Total_Distributed_Month = number_format($Total_distributed/1000000,3);
	$Total_Held_Month = number_format($Total_held/1000000,3);
	
	$Total_Paid_Val = $Total_Paid_Val+number_format($Total_paid/1000000,2);
	$Total_Distributed_Val = $Total_Distributed_Val+number_format($Total_distributed/1000000,3);
	$Total_Held_Val = $Total_Held_Val+number_format($Total_held/1000000,3);
	
	
}while($nextMonth!==$LastMonth);
echo $Total_Paid_Val;

////////////////END 