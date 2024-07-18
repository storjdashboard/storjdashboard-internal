<?php 
// Set to 0 to disable the time limit
set_time_limit(0);

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

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
function allValuesZero($array) {
    // Use array_filter() to remove non-zero values
    $filteredArray = array_filter($array, function($value) {
        return $value !== 0;
    });

    // If the count of non-zero values is zero, all values are zero
    return count($filteredArray) === 0;
} 
function allValuesLessThanThreshold($array, $threshold) {
    foreach ($array as $value) {
        if ($value >= $threshold) {
            return false;
        }
    }
    return true;
}
function allValuesHigherThanThreshold($array, $threshold) {
    foreach ($array as $value) {
        if ($value <= $threshold) {
            return false;
        }
    }
    return true;
}

function timeAgoHrM($unixTimestamp) {
    // Get the current time in the server's timezone
    $currentTime = time();
    
    // Get the server's timezone offset in seconds
    $timezoneOffset = date("Z");

    // Convert the current time to UTC
    $currentTimeUTC = $currentTime - $timezoneOffset;

    // Calculate the difference between the current UTC time and the given timestamp
    $timeDifference = $currentTimeUTC - $unixTimestamp;

    // Calculate the difference in hours and minutes
    $hours = floor($timeDifference / 3600);
    $minutes = floor(($timeDifference % 3600) / 60);

    // Format the result
    $result = sprintf("%d hrs %d mins", $hours, $minutes);
    return $result;
}
?>
<div class="container-fluid">

<script>
var myVar;
function LiveMbps(){
   $('#data_LiveMbps').load("include_content/scripts/bandwidthCalc/allNodes_bwCalc.php", function() {
  /* When load is done */
      myVar = setTimeout(LiveMbps, 500);
});

}
function stopFunction(){
    clearTimeout(myVar); // stop the timer
}
$(document).ready(function(){
	$('#data_LiveMbps').html("<div class='d-flex align-items-center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i></div>").delay(500);
    LiveMbps();

$('#online_audit_susp').load("include_content/scripts/nodes/nodes_Scores.php").delay(500);

$('#total_pay').load("include_content/scripts/nodes/paystubs_getData.php").delay(500);
});
</script>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="./?page=settingsFeatures" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i class="fas fa-fw fa-cog"></i> Customise</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Online</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<span id="nodes_online_count">
<i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i>
</span>
					</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-server fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Online / Audit / Suspension</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="online_audit_susp">
<i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i>
</span></div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-power-off fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Current / Expected Month</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">$
 <span id="current_month_payout">
<i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i>
</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Paid</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
$<span id="total_pay"><i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i></span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-university fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!---- second line -- server and mem config -->
	<?php if($config_row['show_server_info']){ ?>				
	<div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                CPU Load</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php include_once("include_content/scripts/server_info/cpu_load.php"); ?>
					</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fa-solid fa-microchip fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Memory</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php include_once("include_content/scripts/server_info/memory.php");?>
											</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fa-solid fa-memory fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Combined Bandwidth</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<span id="bw_all"><i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i></span>
					</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fa-solid fa-arrow-right-arrow-left fa-rotate-90 fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Combined Disk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<span id="disk_all"><i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size: 1em;'></i></span>
											</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fa-solid fa-hard-drive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        

                        <!-- Pending Requests Card Example -->
                        
                    </div>	
	<?php } ?>
                    <!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Nodes</h6>
<div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">NODES:</div>
                                            <a class="dropdown-item" href="./?page=nodeAdd">Add Node</a>
											<a class="dropdown-item" href="./include_content/scripts/nodes/paystubs.php?redirect">Update Total Paid</a>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="card-body pt-0">
                                <div class="table-responsive pt-0">
<?php 	if($nodes_total>0){ // more than 1 node ?>	

									
<table class="table table-hover display" id="NodesTable">
  <thead>
    <tr>
      <th scope="col">IP</th>
      <th scope="col">Status</th>
      <th scope="col">QUIC</th>
      <th scope="col">Bandwidth</th>
      <th scope="col">Storage</th>
    </tr>
  </thead>
  <tbody>
<?php 
// restart values 
$onlineCounter=0;
$offlineCounter=0;
$payout_total=0;
$payout_held=0;
$payout_overall=0;
$payout_overall_held=0;
$payout_expected_overall=0;
$payout_expected=0;
	
$capacity = 0;
$capacity_all = 0;
$storage = 0;
$storage_all = 0;
$bandwidth = 0;
$bandwidth_all = 0;
//

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 20,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php do { ?>
<?php // start work // 
$ip =$nodes_row['ip'];
$port = $nodes_row['port'];
$node_name = $nodes_row['name'];
$id = $nodes_row['node_id'];
// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
	$validCheck = count($arr);
}else{
	$validCheck = 0;
	$node_quic = null;
	$node_ver = null;
	
}
if($validCheck>0){

$capacity = formatSize($arr['diskSpace']['available']);
$storage = formatSize($arr['diskSpace']['used']+$arr['diskSpace']['trash']);
$bandwidth = formatSize($arr['bandwidth']['used']);
$capacity_all = $capacity_all+$arr['diskSpace']['available'];
$storage_all = $storage_all+$arr['diskSpace']['used']+$arr['diskSpace']['trash'];
$bandwidth_all = $bandwidth_all+$arr['bandwidth']['used'];	
	
$node_ver = $arr['version'];
$node_quic = $arr['quicStatus'];
$node_startedAt = explode(".",$arr['startedAt']);
$node_startedAt = strtotime($node_startedAt[0]);

$LastPingToTime = explode(".",$arr['lastPinged']);
$LastPingToTime = strtotime($LastPingToTime[0]);
$onlineCalc = round(time()-$LastPingToTime);   
    
    // satellite disquali check 
        $satellites_count = count($arr['satellites']);
        $counter=0;
        $sat_url=[];
        $sat_disq=[];
        $sat_susp=[];
        $sat_status=[];
            do{
                $sat_url[$counter] = $arr['satellites'][$counter]['url'];
                $sat_disq[$counter] = $arr['satellites'][$counter]['disqualified'];
                $sat_susp[$counter] = $arr['satellites'][$counter]['suspended'];
                
                if($sat_disq[$counter]==null && $sat_susp[$counter]==null){
                    $sat_status[$counter] = 0;
                }else{
                    $sat_status[$counter] = 1;
                }
                
                $counter=$counter+1;
            }while($counter!=$satellites_count);
    
    
    
    
    //////// disquali check end
//if($onlineCalc<=30){$onlineResult = 1;}else{$onlineResult = 0;}
if($validCheck>0){$onlineResult = 1;}else{$onlineResult = 0;}	
}else{
	$onlineResult = 0;
	$capacity = "";
	$storage = "";
	$bandwidth = "";
	$node_ver = "";
}

//////////////
if($onlineResult == 1){ // continue if working
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/estimated-payout", false, $ctx);
$arr = json_decode($jsonobj, true);

$payout_total = $arr['currentMonth']['egressBandwidthPayout']+$arr['currentMonth']['egressRepairAuditPayout']+$arr['currentMonth']['diskSpacePayout']; 		// issue
$payout_held = $arr['currentMonth']['held']; 																												// issue
$payout_expected = $arr['currentMonthExpectations'];
	
$payout_overall_held = $payout_overall_held+$payout_held;
$payout_overall = $payout_overall+$payout_total;
$payout_expected_overall = $payout_expected_overall+$payout_expected;
///////////////
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/satellites", false, $ctx);
$arr = json_decode($jsonobj, true);

//if (count($arr['bandwidthDaily']) !== null && (is_array(count($arr['bandwidthDaily'])) || is_countable(count($arr['bandwidthDaily'])))) {
//    $total_bwDaily_count = count($arr['bandwidthDaily']);
//} else {
//   $total_bwDaily_count = 0; // Handle the case when $your_variable is null or not countable
//}

if(is_countable($arr['bandwidthDaily'])){
    $total_bwDaily_count = count($arr['bandwidthDaily']);
}else{
    echo "<h5>Bandwidth Issue : $ip : $port</h5>";
continue;
    //print_r($arr['bandwidthDaily']);
} 

//////////////////////
$earliestJoinedAt = $arr['earliestJoinedAt'];
// Given date string
$givenDateStr = $earliestJoinedAt;

// Create a DateTime object from the given date string
$givenDate = new DateTime($givenDateStr);

// Get the current date and time
$currentDate = new DateTime();

// Calculate the difference between the given date and the current date
$interval = $currentDate->diff($givenDate);

// Get the difference in months
$monthsAgo = $interval->y * 12 + $interval->m;

// Display the result
//echo $monthsAgo . ' months ago';
/////////////////////    
    



$arr_counter = 0;
do{ 
$egress = $arr['bandwidthDaily'][$arr_counter]['egress'];
$ingress = $arr['bandwidthDaily'][$arr_counter]['ingress'];
$datetime = $arr['bandwidthDaily'][$arr_counter]['intervalStart'];
$summarytable_date[$arr_counter] = $datetime;	
$summarytable_str_date = strtotime($summarytable_date[$arr_counter]); 
	
if(!isset($summarytable_egress_total)){
$summarytable_egress_total[$summarytable_str_date] = $egress['repair']+$egress['usage']+$egress['audit'];
$summarytable_ingress_total[$summarytable_str_date] = $ingress['repair']+$ingress['usage'];
}else{
$summarytable_egress_total[$summarytable_str_date] = $summarytable_egress_total[$summarytable_str_date]+$egress['repair']+$egress['usage']+$egress['audit'];
$summarytable_ingress_total[$summarytable_str_date] = $summarytable_ingress_total[$summarytable_str_date]+$ingress['repair']+$ingress['usage'];
}


$total_bwDaily_count=$total_bwDaily_count-1;
$arr_counter = $arr_counter+1;
}while($total_bwDaily_count>0);
///////////////

$sat_audit_total = count($arr['audits']);
$sat_audit_count = 0;
    $sat_audit_auditScore=[];
    $sat_audit_suspensionScore=[];
    $sat_audit_onlineScore=[];
    $sat_audit_name=[];
    $sat_audit_status=[];
    do{ 
        $sat_audit_auditScore = $arr['audits'][$sat_audit_count]['auditScore'];
        $sat_audit_suspensionScore = $arr['audits'][$sat_audit_count]['suspensionScore'];
        $sat_audit_onlineScore = $arr['audits'][$sat_audit_count]['onlineScore'];
        $sat_audit_name = $arr['audits'][$sat_audit_count]['satelliteName'];

        if($sat_audit_auditScore>0.99 && $sat_audit_suspensionScore>0.99 && $sat_audit_onlineScore>0.99){
                $sat_audit_status[$sat_audit_count] = 0.99;
            }elseif($sat_audit_auditScore>0.98 && $sat_audit_suspensionScore>0.98 && $sat_audit_onlineScore>0.98){
                $sat_audit_status[$sat_audit_count] = 0.98;
            }elseif($sat_audit_auditScore>0.97 && $sat_audit_suspensionScore>0.97 && $sat_audit_onlineScore>0.97){
                $sat_audit_status[$sat_audit_count] = 0.97;
            }elseif($sat_audit_auditScore>0.96 && $sat_audit_suspensionScore>0.96 && $sat_audit_onlineScore>0.96){
                $sat_audit_status[$sat_audit_count] = 0.96;            
            }else{$sat_audit_status[$sat_audit_count] = 0.95;}
        //$sat_audit_status[$sat_audit_count]['name']=$sat_audit_name; // SET NAME 
        
        $sat_audit_count = $sat_audit_count+1;
    }while($sat_audit_count!=$sat_audit_total);
    
    
} // end online check 

	// summary table keys
	if(isset($summarytable_egress_total)){
	$summarytable_keys = array_keys($summarytable_egress_total);
}
	
// end work
	
	
#	echo "<pre>";
#	ksort($summarytable_egress_total);
#	print_r($summarytable_egress_total);
	
#	ksort($summarytable_ingress_total);
#	print_r($summarytable_ingress_total);	
	
#$summarytable_ingress_total[array_keys($summarytable_ingress_total)[1]];

?>   
    <tr>
      <th nowrap="nowrap" scope="row">
<?php if($node_ver>0){ ?>
<a href="./?page=nodeView&id=<?php echo $id; ?>"><?php echo $node_name; ?></a> <small>v<?php echo $node_ver;?></small>
<?php }else{ echo $ip.":".$port; }?>
&nbsp;<?php if (allValuesZero($sat_status)) { ?>
      <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #63E6BE;"></i>
      <?php }else{ ?>
    <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #e02929;"></i>
    <?php } ?>
      &nbsp;
      <?php 
    if (allValuesHigherThanThreshold($sat_audit_status, 0.989)) { ?>
      <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #63E6BE;"></i>
    <?php }elseif(allValuesHigherThanThreshold($sat_audit_status, 0.979)) {  ?>
           <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #ffb070;"></i>
     <?php }elseif(allValuesHigherThanThreshold($sat_audit_status, 0.959)) {  ?>
           <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #F56D00;"></i>
    <?php }else{ ?>
            <i class="fa-solid fa-circle fa-fade fa-2xs" style="color: #e02929;"></i>
    <?php } ?>     
      <?php //print_r($sat_status); echo " | "; print_r($sat_audit_status); // DEBUG ?>

          
          &nbsp;
          <?php echo "<small>". $monthsAgo ." months </small>"; ?>
          
          &nbsp;&nbsp;&nbsp;<a href="./?page=nodeEdit&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>
</th>
      <td nowrap="nowrap">
        <?php if($onlineResult == 1){ $onlineCounter = $onlineCounter+1;?>
        <span class="btn-success btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
          <span class="text">ONLINE</span>
          </span>  
        <?php }elseif($onlineResult == 0){ $offlineCounter = $offlineCounter+1;?>
        <span class="btn-danger btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-times"></i>
            </span>
          <span class="text">OFFLINE</span>
          </span>
        <?php } ?>
		  <small><?php echo timeAgoHrM($node_startedAt); ?></small>		  
      </td>
      <td nowrap="nowrap">
        <?php if($node_quic == 'OK'){ ?>
        <span class="btn-success btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
          <span class="text">OK</span>
          </span>  
        <?php }else{?>
        <span class="btn-danger btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-times"></i>
            </span>
          <span class="text">ERROR</span>
          </span>                
        <?php } ?>		
		</td>
      <td nowrap="nowrap"><?php echo $bandwidth; ?></td>
      <td nowrap="nowrap"><?php echo $storage; ?> / <?php echo $capacity; ?></td>
    
    </tr>
    
<?php } while ($nodes_row = mysqli_fetch_assoc($nodes_result)); ?>    
    </tbody>
</table>         
<br>First = Susp/Disq Satellites<br>Second = Audit/Susp/Online Satellites
<?php 
}else{
?>
					<div class="card-body pt-3">
						<a href="./?page=nodeAdd">Add a Node</a>
					</div>
<?php } ?>	

<script type='text/javascript'>
    $(function(){  
        $('#nodes_online_count').html('<?php echo $onlineCounter; ?>/<?php echo $nodes_total ;?>');
    });
</script>
<script type='text/javascript'>
    $(function(){  
        $('#current_month_payout').html('<?php echo number_format(($payout_overall-$payout_overall_held)/100,2)." / $ ".number_format($payout_expected_overall/100,2);?>');
    });
</script>

<script type='text/javascript'>
    $(function(){  
        $('#bw_all').html('<?php echo formatSize($bandwidth_all); ?>');
    });
</script>
<script type='text/javascript'>
    $(function(){  
        $('#disk_all').html('<?php echo formatSize($storage_all) . " / " . formatSize($capacity_all); ?>');
    });
</script>


                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
                    </div>
                    
		
					<!--- ROW -->
<?php if($nodes_total>0){ // more than 1 node ?>	
<div class="row">
<?php if($config_row['show_live_bw']){ ?>
<div class="col-xl-4 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Live Bandwidth</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
<h1 class="clearfix" id="data_LiveMbps"></h1>
                                </div>
                            </div>
                        </div>
<?php } ?>

                        <!-- Area Chart -->
<?php if($config_row['show_live_bw']){ ?>
	<div class="col-xl-8 col-lg-12">
<?php }else{  ?>
	<div class="col-xl-12 col-lg-12">
<?php } ?>
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Daily Summary</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-0">
                                <div class="table-responsive pt-0">
<table class="table table-hover display" id="DailySummaryTable">
  <thead>
    <tr>
      <th nowrap="nowrap" scope="col">Date</th>
      <th nowrap="nowrap" scope="col">Ingress</th>
      <th nowrap="nowrap" scope="col">Egress</th>
      <th nowrap="nowrap" scope="col"> Total Bandwidth</th>
      </tr>
  </thead>
  <tbody>
<?php 
$count = count($summarytable_keys)-1;

do{
	$ThisKey = array_keys($summarytable_ingress_total)[$count];
$MbitSpeed_up = 1;   
date_default_timezone_set("UTC");
$totalBW_up = $summarytable_egress_total[$ThisKey];
$totalBW_GB_up = $totalBW_up/1000000000;
$MbitSpeed_up = $totalBW_GB_up*8000;
   if(date("jS M",$ThisKey) == date("jS M",time())){
	   $TimeToday = time() - strtotime("today");
   }else{
	   $TimeToday = "86400";
   }
$MbitSpeed_up = $MbitSpeed_up/$TimeToday;
$MbitSpeed_up = number_format($MbitSpeed_up,2)."Mbit/s";
date_default_timezone_set("Europe/London");
////////////////////////
$MbitSpeed_down = 1;   
date_default_timezone_set("UTC");
$totalBW_down = $summarytable_ingress_total[$ThisKey];
$totalBW_GB_down = $totalBW_down/1000000000;
$MbitSpeed_down = $totalBW_GB_down*8000;
   if(date("jS M",$ThisKey) == date("jS M",time())){
	   $TimeToday = time() - strtotime("today");
   }else{
	   $TimeToday = "86400";
   }
$MbitSpeed_down = $MbitSpeed_down/$TimeToday;
$MbitSpeed_down = number_format($MbitSpeed_down,2)."Mbit/s";
date_default_timezone_set("Europe/London");    

$up_cs = str_replace("Mbit/s",'',$MbitSpeed_up);
$down_cs = str_replace("Mbit/s",'',$MbitSpeed_down);
$total_cs = $up_cs+$down_cs;
	  ?>
    <tr>
      <th valign="middle" scope="row" class="text-nowrap"><?php echo date("jS M",$ThisKey); ?></th>
      <td valign="middle"><?php echo formatSize($summarytable_ingress_total[$ThisKey]); ?> </td>
      <td valign="middle"><?php echo formatSize($summarytable_egress_total[$ThisKey]); ?> </td>
<?php 
  
?>
		<td valign="middle"><?php echo $total_cs."Mbit/s";?><br><small class="text-nowrap"><i class="fa fa-download" aria-hidden="true"></i> <?php echo $MbitSpeed_down ;?><i class="fa fa-upload" aria-hidden="true"></i> <?php echo $MbitSpeed_up ;?></small></td>
      </tr>
<?php $count=$count-1; }while($count>=0); ?>
  </tbody>
</table>
<br>
<small>*Bandwidth is measured on average of the last update time of a node.</small>


                                </div>
                            </div>
                            </div>
                        </div>

                 
                        
                    </div>                                        
                    
                    

                    

            </div>
<?php } ?>

