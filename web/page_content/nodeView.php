<?php 
if(!isset($_GET['id'])){ ?>
<script>window.location.replace("./");</script>
<?php
}
$id = $_GET['id'];
$nodes_query = "SELECT * FROM $database_sql.nodes where node_id = '$id' order by ip asc;";
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

<div class="container-fluid">

<script>
var myVar;
function LiveMbps(){
   $('#data_LiveMbps').load("include_content/scripts/bandwidthCalc/specificNodes_bwCalc.php?id=<?php echo $id; ?>", function() {
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
});
</script>

<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Viewing [<?php echo $nodes_row['name']; ?>]</h1>
                        <a href="./?page=nodeEdit&id=<?php echo $id; ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-edit"></i> Edit Node</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Online / Audit / Suspension</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
												
<?php $single_node_id=$id; include_once("include_content/scripts/nodes/nodes_Scores.php"); ?>
											</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Current Month</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">$<span id="current_month_payout"></span></div>
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
                        
                    </div>

                    <!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Stats</h6>
                                    
                                </div>
                                <div class="card-body pt-0">
                                <div class="table-responsive pt-0">
<table class="table table-hover display" id="NodesTable">
  <thead>
    <tr>
      <th scope="col">IP</th>
      <th scope="col">Status</th>
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
//

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 10,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php do { ?>
<?php
$ip = $nodes_row['ip'];
$port = $nodes_row['port'];

$jsonobj = @file_get_contents("http://$ip:$port/api/sno/", false, $ctx);
$arr = json_decode($jsonobj, true);
$validCheck = @count($arr);

$vetted_url[1] = $arr['satellites'][0]['url'];
$vetted_url[2] = $arr['satellites'][1]['url'];
$vetted_url[3] = $arr['satellites'][2]['url'];
$vetted_url[4] = $arr['satellites'][3]['url'];

$vetted_status[1] = $arr['satellites'][0]['vettedAt'];
$vetted_status[2] = $arr['satellites'][1]['vettedAt'];
$vetted_status[3] = $arr['satellites'][2]['vettedAt'];
$vetted_status[4] = $arr['satellites'][3]['vettedAt'];

if ($validCheck > 0) {
    $capacity = formatSize($arr['diskSpace']['available']);
    $storage = formatSize($arr['diskSpace']['used'] + $arr['diskSpace']['trash']);
    $bandwidth = formatSize($arr['bandwidth']['used']);
    $node_ver = $arr['version'];

    $LastPingToTime = explode(".", $arr['lastPinged']);
    $LastPingToTime = strtotime($LastPingToTime[0]);
    $onlineCalc = round(time() - $LastPingToTime);

    $onlineResult = 1;


} else {
    $onlineResult = 0;
    $capacity = 0;
    $storage = 0;
    $bandwidth = 0;
    $node_ver = 0;
}


//////////////
if($onlineResult == 1){ // continue if working
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/estimated-payout", false, $ctx);
$arr = json_decode($jsonobj, true);

$payout_total = $arr['currentMonth']['egressBandwidthPayout']+$arr['currentMonth']['egressRepairAuditPayout']+$arr['currentMonth']['diskSpacePayout'];
$payout_held = $arr['currentMonth']['held'];
$payout_expected = $arr['currentMonthExpectations'];

$payout_overall_held = $payout_overall_held+$payout_held;
$payout_overall = $payout_overall+$payout_total;
$payout_expected_overall = $payout_expected_overall+$payout_expected;	
///////////////
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/satellites", false, $ctx);
$arr = json_decode($jsonobj, true);
	
	//echo "http://$ip:$port/api/sno/satellites";  DEBUG
	
$total_bwDaily_count = count($arr['bandwidthDaily']);
$arr_counter = 0;
do{ 
$egress = $arr['bandwidthDaily'][$arr_counter]['egress'];
$ingress = $arr['bandwidthDaily'][$arr_counter]['ingress'];
$datetime = $arr['bandwidthDaily'][$arr_counter]['intervalStart'];

if(!isset($summarytable_egress_total[$arr_counter])){
$summarytable_egress_total[$arr_counter] = $egress['repair']+$egress['usage']+$egress['audit'];
$summarytable_ingress_total[$arr_counter] = $ingress['repair']+$ingress['usage'];
}else{
$summarytable_egress_total[$arr_counter] = $summarytable_egress_total[$arr_counter]+$egress['repair']+$egress['usage']+$egress['audit'];
$summarytable_ingress_total[$arr_counter] = $summarytable_ingress_total[$arr_counter]+$ingress['repair']+$ingress['usage'];
}
$summarytable_date[$arr_counter] = $datetime;

$total_bwDaily_count=$total_bwDaily_count-1;
$arr_counter = $arr_counter+1;
}while($total_bwDaily_count>0);
///////////////

} // end online check 

// end work
?>   
    <tr>
      <th nowrap="nowrap" scope="row"><a href="#"><?php echo $ip.":".$port; ?></a> <small>v<?php echo $node_ver;?></small></th>
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
      </td>
      <td nowrap="nowrap"><?php echo $bandwidth; ?></td>
      <td nowrap="nowrap"><?php echo $storage; ?> / <?php echo $capacity; ?></td>
    
    </tr>
    
<?php } while ($nodes_row = mysqli_fetch_assoc($nodes_result)); ?>    
    </tbody>
</table>         

<script type='text/javascript'>
    $(function(){  
        $('#nodes_online_count').html('<?php echo $onlineCounter; ?>');
    });
</script>

<script type='text/javascript'>
    $(function(){  
        $('#current_month_payout').html('<?php echo number_format(($payout_overall-$payout_overall_held)/100,2)." / $ ".number_format($payout_expected_overall/100,2);?>');
    });
</script>



                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
                    </div>                    

<div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo explode('.', $vetted_url[1])[0]; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php 
$status = trim($vetted_status[1]); // Remove whitespace
if (empty($status) || strtolower($status) === 'null') {
    echo "Not Vetted";
} else {
    echo "Vetted";
}											?></div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-server fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo explode('.', $vetted_url[2])[0]; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php 
$status = trim($vetted_status[2]); // Remove whitespace
if (empty($status) || strtolower($status) === 'null') {
    echo "Not Vetted";
} else {
    echo "Vetted";
}											?>
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
                        <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo explode('.', $vetted_url[3])[0]; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php 
$status = trim($vetted_status[3]); // Remove whitespace
if (empty($status) || strtolower($status) === 'null') {
    echo "Not Vetted";
} else {
    echo "Vetted";
}											?>											
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
                        <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo explode('.', $vetted_url[4])[0]; ?></div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
<?php 
$status = trim($vetted_status[4]); // Remove whitespace
if (empty($status) || strtolower($status) === 'null') {
    echo "Not Vetted";
} else {
    echo "Vetted";
}											?>											
											</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-server fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        
                    </div>


					<!--- ROW -->

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
<?php  } ?>

                        <!-- Area Chart -->
	<?php if($config_row['show_live_bw']){ ?>	
     <div class="col-xl-8 col-lg-12">
<?php  }else{ ?>
		 <div class="col-xl-12 col-lg-12">
		 <?php }		 ?>
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
$count = count($summarytable_date)-1;

do{
$MbitSpeed_up = 1;   
date_default_timezone_set("UTC");
$totalBW_up = $summarytable_egress_total[$count];
$totalBW_GB_up = $totalBW_up/1000000000;
$MbitSpeed_up = $totalBW_GB_up*8000;
   if(date("jS M",strtotime($summarytable_date[$count])) == date("jS M",time())){
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
$totalBW_down = $summarytable_ingress_total[$count];
$totalBW_GB_down = $totalBW_down/1000000000;
$MbitSpeed_down = $totalBW_GB_down*8000;
   if(date("jS M",strtotime($summarytable_date[$count])) == date("jS M",time())){
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
                                        <th valign="middle" scope="row" class="text-nowrap"><?php echo date("jS M",strtotime($summarytable_date[$count])); ?></th>
                                        <td valign="middle"><?php echo formatSize($summarytable_ingress_total[$count]); ?></td>
                                        <td valign="middle"><?php echo formatSize($summarytable_egress_total[$count]); ?></td>
                                        <?php 
  
?>
                                        <td valign="middle"><?php echo $total_cs."Mbit/s";?><br>
                                          <small class="text-nowrap"><i class="fa fa-download" aria-hidden="true"></i> <?php echo $MbitSpeed_down ;?><i class="fa fa-upload" aria-hidden="true"></i> <?php echo $MbitSpeed_up ;?></small></td>
                                      </tr>
                                      <?php $count=$count-1; }while($count>=0); ?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                            </div>
                        </div>

                    <!-- Pie Chart --></div>                                        
                    
                       <!-- Content Row -->
