<?php 
$docker_query = "SELECT * FROM $database_sql.docker order by `docker_name` asc;";
$docker_result = mysqli_query($sql, $docker_query);
$docker_total = mysqli_num_rows($docker_result);
$docker_row = mysqli_fetch_assoc($docker_result);
?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Docker</h1>
                        <!--<a href="./?page=dockerView" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>-->
					</div>

                    <!-- Content Row -->
                    

                    <!-- Content Row -->
                    		<div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4 pt-0">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Docker Agents</h6>
<div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">DOCKER:</div>
                                            <a class="dropdown-item" href="./?page=dockerAdd">Add Agent</a>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="card-body pt-0">
                                <div class="table-responsive pt-0">
<table class="table table-hover display" id="NodesTable">
  <thead>
    <tr>
      <th scope="col">Docker Name</th>
      <th scope="col">Status</th>
      <th scope="col">Containers</th>
      </tr>
  </thead>
  <tbody>
<?php 
// restart values 

//

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 5,  //1200 Seconds is 20 Minutes	
    )
));
?>
<?php if($docker_total>0){?>
<?php do { ?>
<?php // start work // 
$docker_name = $docker_row['docker_name'];
$ip =$docker_row['server_ip'];
$port = $docker_row['port'];
$id = $docker_row['id'];
$onlineResult = 0;
// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/info",false,$ctx);
$arr = json_decode($jsonobj, true);

if(is_array($arr)){
	$validCheck = count($arr);
	
	// set variables
	$containers_total = $arr['Containers'];
	$containers_running = $arr['ContainersRunning'];
}else{
	$validCheck = 0;
	$containers_total = 0;
	$containers_running = 0;
}

?>		  
    <tr>
      <th nowrap="nowrap" scope="row">
<?php if($validCheck>0){ $onlineResult = 1; ?>
<a href="./?page=dockerInfo&id=<?php echo $id; ?>"><?php echo $docker_name."</a> <small><em>".$ip.":".$port."</em></small>"; ?>
<?php }else{ echo $docker_name." <small><em>".$ip.":".$port."</em></small>"; }?>
&nbsp;&nbsp;&nbsp;<a href="./?page=dockerEdit&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>
</th>
      <td nowrap="nowrap">
        <?php if($onlineResult == 1){ ?>
        <span class="btn-success btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
          <span class="text">ONLINE</span>
          </span>  
        <?php }elseif($onlineResult == 0){ ?>
        <span class="btn-danger btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-times"></i>
            </span>
          <span class="text">OFFLINE</span>
          </span>                
        <?php } ?>
      </td>
      <td nowrap="nowrap"><?php echo $containers_running." / ".$containers_total; ?>&nbsp;</td>
      </tr>
    
<?php } while ($docker_row = mysqli_fetch_assoc($docker_result)); ?>  
<?php } // docker total > 0?>
    </tbody>
</table>
<?php if($docker_total==0){?>
Get Started... <a href="./?page=dockerAdd">Add a Docker Agent</a>
<?php 
}
?>
                       
                                                                    
                                </div>
                            </div>
                        </div>     
                    </div>
                    </div>
                    
