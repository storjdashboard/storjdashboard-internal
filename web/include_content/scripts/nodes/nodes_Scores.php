<?php if(!isset($single_node_id)){ ?>
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
<?php }
if(isset($single_node_id)){
$nodes_scores_query = "SELECT * FROM $database_sql.nodes where `node_id` = '$single_node_id';";
	}else{
$nodes_scores_query = "SELECT * FROM $database_sql.nodes order by ip asc;";
	}
$nodes_scores_result = mysqli_query($sql, $nodes_scores_query);
$nodes_scores_total = mysqli_num_rows($nodes_scores_result);
$nodes_scores_row = mysqli_fetch_assoc($nodes_scores_result);

$totalNodes = $nodes_scores_total;

if($totalNodes<1){
	echo "N/A"; exit;
}
?>

  <?php
	$audit_online_total_percent = 0;
	$audit_audit_total_percent = 0;
	$audit_susp_total_percent = 0;
   do {

$ip =$nodes_scores_row['ip'];
$port = $nodes_scores_row['port'];  
  ?>
<?php 
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 20,  //1200 Seconds is 20 Minutes	
    )
));


$jsonobj = @file_get_contents("http://$ip:$port/api/sno/satellites",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
$IsArray = 1;
}else{
$IsArray = 0;
$totalNodes  = $totalNodes-1;
}

if($IsArray == 1){
if(strtotime(substr($arr['earliestJoinedAt'],0,19))>1){

$audit_count = count($arr['audits']);
	$counter = 0;
	$audit_online_total = 0;
	$audit_audit_total = 0;
	$audit_susp_total = 0;
	do{
		$audit_online_total= $audit_online_total+$arr['audits'][$counter]['onlineScore'];
		$audit_audit_total = $audit_audit_total+$arr['audits'][$counter]['auditScore'];
		$audit_susp_total = $audit_susp_total+$arr['audits'][$counter]['suspensionScore'];
$counter = $counter+1;		
	}while($counter<$audit_count);

$audit_online_total_percent = $audit_online_total_percent+$audit_online_total/6*100;
$audit_audit_total_percent = $audit_audit_total_percent+$audit_audit_total/6*100;
$audit_susp_total_percent = $audit_susp_total_percent+$audit_susp_total/6*100;

?>  

  <?php } } } while ($nodes_scores_row = mysqli_fetch_assoc($nodes_scores_result)); ?>    



<?php // online // ?>
<?php 
$result = number_format($audit_online_total_percent/$totalNodes,2); 
if($result == "100.00"){ echo number_format($result,0); }else{ echo $result; } 
?>% /
<?php // audit // ?>
<?php $result = number_format($audit_audit_total_percent/$totalNodes,2); 
if($result == "100.00"){ echo number_format($result,0); }else{ echo $result; } ?>% /
<?php // suspension // ?>
<?php $result = number_format($audit_susp_total_percent/$totalNodes,2); 
if($result == "100.00"){ echo number_format($result,0); }else{ echo $result; } ?>%
