<?php 
$nodes_query = "SELECT * FROM storj_dashboard.nodes order by ip asc;";
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
});
</script>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i class="fas fa-fw fa-cog"></i> Customise</a>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="nodes_online_count"></span>/<?php echo $nodes_total ;?></div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-globe fa-2x text-gray-300"></i>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">100% / 100% / 100%</div>
                                        </div>
                                        <div class="col-auto">
                                          <i class="fas fa-check fa-2x text-gray-300"></i>
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
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                DATA</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">TEXT</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"> </div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>                                    
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
        'timeout' => 2,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php do { ?>
<?php // start work // 
$ip =$nodes_row['ip'];
$port = $nodes_row['port'];
$id = $nodes_row['node_id'];
// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
	$validCheck = count($arr);
}else{
	$validCheck = 0;
}
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
	$capacity = "";
	$storage = "";
	$bandwidth = "";
	$node_ver = "";
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
      <th nowrap="nowrap" scope="row">
<?php if($node_ver>0){ ?>
<a href="./?page=nodeView&id=<?php echo $id; ?>"><?php echo $ip.":".$port; ?></a> <small>v<?php echo $node_ver;?></small>
<?php }else{ echo $ip.":".$port; }?>
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
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
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
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
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

                        <!-- Pie Chart -->
                        
                    </div>                                        
                    
                       <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="myAreaChart" style="display: block; width: 489px; height: 320px;" width="489" height="320" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="myPieChart" width="812" height="245" style="display: block; width: 812px; height: 245px;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-dark"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row --></div>
                    
