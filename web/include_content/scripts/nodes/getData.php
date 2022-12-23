<?php require_once("../../restrict.php"); ?>
<?php require_once("../../../cfg.php"); ?>
<?php require_once("../../../Connections/sql.php"); ?>
<?php 
if(!isset($_GET['id'])){echo"NO ID"; exit;}; ?>
<?php 
function formatSize($bytes,$decimals=2){
    $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1000,$factor)).@$size[$factor];
}
?>
<?php 
$id = $_GET['id'];
$nodes_query = "SELECT * FROM storj_dashboard.nodes where `node_id` = '$id' ;";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_total = mysqli_num_rows($nodes_result);
$nodes_row = mysqli_fetch_assoc($nodes_result);
?>
<?php 
// restart values 
$onlineCounter=0;
$offlineCounter=0;
$payout_total=0;
$payout_held=0;
$payout_overall=0;
$payout_overall_held=0;
//

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 5,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php ///////////////////////do { ?>
<?php // start work // 
$ip =$nodes_row['ip'];
$port = $nodes_row['port'];
// CURL check
/////////////////// GET NODE DATA
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/",false,$ctx);
$arr = json_decode($jsonobj, true);
$validCheck = @count($arr);
if($validCheck>0){

$capacity = formatSize($arr['diskSpace']['available']);
$storage = formatSize($arr['diskSpace']['used']+$arr['diskSpace']['trash']);
$bandwidth = formatSize($arr['bandwidth']['used']);
$node_ver = $arr['version'];

$LastPingToTime = explode(".",$arr['lastPinged']);
$LastPingToTime = strtotime($LastPingToTime[0]);
$onlineCalc = round(time()-$LastPingToTime);
if($onlineCalc<=30){$onlineResult = 1;}else{$onlineResult = 0;}
}else{
	$onlineResult = 0;
	$capacity = 0;
	$storage = 0;
	$bandwidth = 0;
	$node_ver = 0;
}

////////////// ESTIMATED PAYOUTS
if($onlineResult == 1){ // continue if working
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/estimated-payout", false, $ctx);
$arr = json_decode($jsonobj, true);

$payout_total = $arr['currentMonth']['egressBandwidthPayout']+$arr['currentMonth']['egressRepairAuditPayout']+$arr['currentMonth']['diskSpacePayout'];
$payout_held = $arr['currentMonth']['held'];

$payout_overall_held = $payout_overall_held+$payout_held;
$payout_overall = $payout_overall+$payout_total;


} // end online check 

// end work
?><!-- data -->
        <?php if($onlineResult == 1){ $onlineCounter = $onlineCounter+1;?>
<!-- online -->
<script>
$(document).ready(function(){
	$('#node_<?php echo $ip; ?>_status').html("	<span class='btn-success btn-icon-split btn-sm'>          <span class='icon text-white-50'>            <i class='fas fa-check'></i>            </span>          <span class='text'>ONLINE</span>          </span>  		  		  ");
});	
</script>
        <?php }elseif($onlineResult == 0){ $offlineCounter = $offlineCounter+1;?>
<!-- offline -->
<script>
$(document).ready(function(){
	$('#node_<?php echo $ip; ?>_status').html("        <span class='btn-danger btn-icon-split btn-sm'>          <span class='icon text-white-50'>            <i class='fas fa-times'></i>            </span>          <span class='text'>OFFLINE</span>          </span>   		  ");
});	
</script>       
        <?php } ?>
        
        <!---<?php echo $storage; ?> / <?php echo $capacity; ?>---->


<?php /////////////////////} while ($nodes_row = mysqli_fetch_assoc($nodes_result)); ?>    
<?php echo $ip; ?>