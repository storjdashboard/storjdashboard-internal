<?php 
$docker_id = $_GET['id'];
$docker_query = "SELECT * FROM $database_sql.docker WHERE `id` = '$docker_id' order by `docker_name` asc;";
$docker_result = mysqli_query($sql, $docker_query);
$docker_total = mysqli_num_rows($docker_result);
$docker_row = mysqli_fetch_assoc($docker_result);

$name = $docker_row['docker_name'];
$ip =$docker_row['server_ip'];
$port = $docker_row['port'];
$id = $docker_row['id'];
?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Docker ['<?php echo $name; ?>']</h1>
                        <a href="./?page=dockerView" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
			    
                    </div>

                    <!-- Content Row -->
                    

                    <!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Docker Info</h6>
                                    
                                </div>
                                <div class="card-body pt-0">
                                <div class="table-responsive pt-0">
<table class="table table-hover display" id="NodesTable">
  <thead>
    <tr>
      <th scope="col">Container Name</th>
      <th scope="col">State</th>
      <th scope="col">Status</th>
      <th scope="col">Created</th>
      <th scope="col">&nbsp;</th>
      </tr>
  </thead>
  <tbody>
<?php // start work // 

$onlineResult = 0;
// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/containers/json?all=true",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
	$validCheck = count($arr);
	
	// set variables
	$cur_container = 0;
	
}else{
	$validCheck = 0;
	$cur_container = 0;
	
}

//echo $validCheck;
	  
do{	
	$cur_id = $arr[$cur_container]['Id'];
?>		  
    <tr>
      <th nowrap="nowrap" scope="row"><?php echo $arr[$cur_container]['Image']; ?></th>
      <td nowrap="nowrap"><?php echo $arr[$cur_container]['State']; ?></td>
      <td nowrap="nowrap"><?php echo $arr[$cur_container]['Status']; ?></td>
      <td nowrap="nowrap"><?php echo date("D M j G:i:s",$arr[$cur_container]['Created']); ?></td>
      <td nowrap="nowrap">
 <a href="./?page=dockerLogs<?php echo"&Did=$docker_id&id=$cur_id&prev=30&full=1";?>">30 Mins Full Logs</a> | <a href="./docker.php<?php echo"?ip=".$ip."&port=".$port."&id=".$cur_id."&opt=start&method=POST";?>">Start</a>
		  | <a href="./docker.php<?php echo"?ip=".$ip."&port=".$port."&id=".$cur_id."&opt=stop&method=POST";?>">Stop</a>
		  | <a href="./docker.php<?php echo"?ip=".$ip."&port=".$port."&id=".$cur_id."&opt=restart&method=POST";?>">Restart</a></td>
      </tr>
   <?php $cur_container = $cur_container+1; } while($cur_container!==$validCheck); ?> 
    </tbody>
</table>

                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
                    </div>
                    
					<!--- ROW -->
                    
