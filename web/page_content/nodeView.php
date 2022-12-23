<?php 
$id = $_GET['id'];
$nodes_query = "SELECT * FROM storj_dashboard.nodes where node_id = '$id' order by ip asc;";
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
                        <h1 class="h3 mb-0 text-gray-800">Viewing [<?php echo $nodes_row['ip'].":".$nodes_row['port']; ?>]</h1>
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
//

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 10,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php do { ?>
<?php // start work // 
$ip =$nodes_row['ip'];
$port = $nodes_row['port'];
// CURL check
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
//if($onlineCalc<=300){$onlineResult = 1;}else{$onlineResult = 0;}
if($validCheck>0){$onlineResult = 1;}else{$onlineResult = 0;}	
}else{
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

$payout_overall_held = $payout_overall_held+$payout_held;
$payout_overall = $payout_overall+$payout_total;
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

<?php 

?>

<script type='text/javascript'>
    $(function(){  
        $('#nodes_online_count').html('<?php echo $onlineCounter; ?>');
    });
</script>

<script type='text/javascript'>
    $(function(){  
        $('#current_month_payout').html('<?php echo number_format(($payout_overall-$payout_overall_held)/100,2); ?>');
    });
</script>



                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
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
      </tr>
  </thead>
  <tbody>
<?php 
$count = count($summarytable_date)-1;
do{ ?>
    <tr>
      <th scope="row"><?php echo date("jS M",strtotime($summarytable_date[$count])); ?></th>
      <td><?php echo formatSize($summarytable_ingress_total[$count]); ?></td>
      <td><?php echo formatSize($summarytable_egress_total[$count]); ?></td>
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
