<?php require_once("../../../cfg.php"); ?>
<?php require_once("../../../Connections/sql.php"); ?>
<?php require_once("../../../include_content/restrict.php"); ?>
<?php 

$nodes_query = "SELECT * FROM $database_sql.nodes order by ip asc;";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_total = mysqli_num_rows($nodes_result);
$nodes_row = mysqli_fetch_assoc($nodes_result);
?>
<?php 
function formatSize($bytes,$decimals=2){
    $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1000,$factor)).@$size[$factor];
}
?>

  <?php
  $diskSpace= 0;
$totalSpeed = 0; 
$bw_used_1= 0; 
   do { 
$total_bw_used =0;
$total_time =0;  
$speed_calc = 0;
$ip =$nodes_row['ip'];
$port = $nodes_row['port'];  
  ?>
<?php 
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 20,  //1200 Seconds is 20 Minutes	
    )
));


$jsonobj = @file_get_contents("http://$ip:$port/api/sno/",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
$IsArray = 1;
}else{
$IsArray = 0;
}

if($IsArray == 1){
if($arr['lastPinged']>1){

$LastPingToTime = explode(".",$arr['lastPinged']);
$LastPingToTime_1 = strtotime($LastPingToTime[0]);
$bw_used_1 = $bw_used_1+$arr['bandwidth']['used'];

$diskSpace = $diskSpace+$arr['diskSpace']['used']+$arr['diskSpace']['trash'];

do{ // waiting for second data set
	usleep(500000);
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/",false,$ctx);
$arr = json_decode($jsonobj, true);

$LastPingToTime = explode(".",$arr['lastPinged']);
$LastPingToTime_2 = strtotime($LastPingToTime[0]);
$bw_used_2 = $arr['bandwidth']['used'];



}while($LastPingToTime_2==$LastPingToTime_1);
}
/// CALCS

$total_time = round($LastPingToTime_2-$LastPingToTime_1);
$total_bw_used = round($bw_used_2-$bw_used_1);

if($total_time==0 && $total_bw_used>0){
//$speed_calc = formatSize(round($total_bw_used));
$totalSpeed = $totalSpeed + round($total_bw_used);
}elseif($total_time>0 && $total_bw_used>0){
//$speed_calc = formatSize(round($total_bw_used/$total_time));
$totalSpeed = $totalSpeed + round($total_bw_used/$total_time);	
}else{
//$speed_calc = formatSize(0);
}
?>  

  <?php } } while ($nodes_row = mysqli_fetch_assoc($nodes_result)); ?>    

<?php 
// speed calc
$totalBW_GB = $totalSpeed/1000000000;
$MbitSpeed = $totalBW_GB*8000;
echo "<h5>Speed</h5>";
echo $MbitSpeed = number_format($MbitSpeed,2)." Mbit/s";
echo "<br>";
echo "<h5>Disk</h5>";
echo number_format(round($diskSpace/1000000,0))."MB"; 
echo "<br>";
echo "<h5>Bandwidth</h5>";
echo number_format(round($bw_used_1/1000000,0))."MB"; 

?>
