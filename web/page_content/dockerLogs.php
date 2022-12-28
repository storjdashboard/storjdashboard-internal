<?php 
$docker_id = $_GET['Did'];
$docker_query = "SELECT * FROM $database_sql.docker WHERE `id` = '$docker_id' order by `docker_name` asc;";
$docker_result = mysqli_query($sql, $docker_query);
$docker_total = mysqli_num_rows($docker_result);
$docker_row = mysqli_fetch_assoc($docker_result);

$name = $docker_row['docker_name'];
$ip =$docker_row['server_ip'];
$port = $docker_row['port'];
$Did = $docker_row['id'];
$id = $_GET['id'];

$url_var = "";
$prev = strtotime("-5 minutes");

if(isset($_GET['prev'])){
	if($_GET['prev']>0){
		$prev = strtotime("-".$_GET['prev']." minutes");
	}
}
if(isset($_GET['full'])){
	if($_GET['full']==1){
		$url_var = "stderr=true&stdout=true&since=$prev";
	}
}
if(isset($_GET['error'])){
	if($_GET['error']==1){
		$url_var = "stderr=true&stdout=false&since=$prev";
	}
}

?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Docker Logs</h1>
                    <!--    <a href="./" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i class="fas fa-fw fa-cog"></i> Customise</a>
					-->
                    </div>

                    <!-- Content Row -->
                    

                    <!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Log Data</h6>
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
<?php // start work // 

// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/containers/$id/logs?$url_var",false,$ctx);

	  
$log_data = str_replace("","",iconv("UTF-8", "UTF-8//IGNORE", $jsonobj));
	
$split_log_data = explode(PHP_EOL, $log_data);

$total_log_lines = count($split_log_data)-1;

	  $log_line_count = 0;

?>									
<table class="table table-hover display" id="LogTable">
  <thead>
    <tr>
      <th nowrap="nowrap" scope="col">Time</th>
      <th nowrap="nowrap" scope="col"> x </th>
      <th nowrap="nowrap" scope="col">Status</th>
      <th nowrap="nowrap" scope="col">Satellite</th>
      <th nowrap="nowrap" scope="col">Piece ID</th>
      <th nowrap="nowrap" scope="col">Action</th>
      </tr>
  </thead>
  <tbody>
<?php 	  
if($total_log_lines>0){	  
	  
do{ 
	// reset variables
	$TL_info= "";
	$TL_info2= "";
	$TL_info3= "";
	$TL_json= "";
	
	  $split_log_line_data_tabs = preg_split("/\t+/", $split_log_data[$log_line_count]);
	
if(!is_null($split_log_line_data_tabs[0]) && count($split_log_line_data_tabs)>1){	
	$TL_time = date("D M j G:i:s",strtotime(preg_replace('/[\x00-\x1F\x7F]/', '', $split_log_line_data_tabs[0])));
	$TL_info = $split_log_line_data_tabs[1];
	$TL_info2 = $split_log_line_data_tabs[2];
	$TL_info3 = $split_log_line_data_tabs[3];
	if(isset($split_log_line_data_tabs[4])){
	$TL_json = json_decode($split_log_line_data_tabs[4],true);
	}
	if(str_contains($TL_info3,'delete piece')){
		$TL_json['Action']="DELETE";
	}
	
// NICE SAT ID 
	if(isset($TL_json['Satellite ID'])){
	if($TL_json['Satellite ID']=='12tRQrMTWUWwzwGh18i7Fqs67kmdhH9t6aToeiwbo5mfS2rUmo'){
		$TL_sat = 'us2.storj.io:7777';
	}
	if($TL_json['Satellite ID']=='1wFTAgs9DP5RSnCqKV1eLf6N9wtk4EAtmN5DpSxcs8EjT69tGE'){
		$TL_sat = 'saltlake.tardigrade.io:7777';
	}
	if($TL_json['Satellite ID']=='121RTSDpyNZVcEU84Ticf2L1ntiuUimbWgfATz21tuvgk3vzoA6'){
		$TL_sat = 'ap1.storj.io:7777';
	}
	if($TL_json['Satellite ID']=='12EayRS2V1kEsWESU9QMRseFhdxYxKicsiFmxrsLZHeLUtdps3S'){
		$TL_sat = 'us1.storj.io:7777';
	}
	if($TL_json['Satellite ID']=='12L9ZFwhzVpuEKMUNUqkaTLGzwY9G24tbiigLiXpmZWKwmcNDDs'){
		$TL_sat = 'eu1.storj.io:7777';
	}
	if($TL_json['Satellite ID']=='12rfG3sh9NCWiX3ivPjq2HtdLmbqCrvHVEzJubnzFzosMuawymB'){
		$TL_sat = 'europe-north-1.tardigrade.io:7777';
	}
		}else{
		$TL_sat = "";
	}
	//// END NICE SAT ID
?>		  
    <tr>
      <th nowrap="nowrap" scope="row"><?php echo $TL_time; ?></th>
      <td nowrap="nowrap"><?php echo $TL_info." ".$TL_info2; ?></td>
      <td nowrap="nowrap"><?php echo $TL_info3; ?></td>
      <td nowrap="nowrap"><?php echo $TL_sat; ?></td>
      <td nowrap="nowrap"><?php if(isset($TL_json['Piece ID'])){ echo $TL_json['Piece ID'];}else{ echo ""; }?></td>
      <td nowrap="nowrap"><?php if(isset($TL_json['Action'])){ echo $TL_json['Action'];}else{ echo ""; } ?></td>
      </tr>
   <?php  
	}
	
	if(count($split_log_line_data_tabs)==1){
		?>  
	  <tr>
      <td colspan="6" nowrap="nowrap" scope="row"><pre style="display:table-cell"><?php echo preg_replace('/[\x00-\x1F\x7F]/', '', $split_log_data[$log_line_count]); ?></pre></td>
      </tr>
	  <?php	  
	}
		$log_line_count = $log_line_count+1;
	}while($log_line_count<$total_log_lines);	
	
	} // if more than 0 found	
?>
    </tbody>
</table>
							

                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
                    </div>
                    
					<!--- ROW -->
	