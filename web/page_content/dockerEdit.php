<?php 
$id = $_GET['id'];
$nodes_query = "SELECT * FROM storj_dashboard.docker where id = '$id'";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_total = mysqli_num_rows($nodes_result);
$nodes_row = mysqli_fetch_assoc($nodes_result);

	$node_id = $nodes_row['id'];
?>
<?php 
function formatSize($bytes,$decimals=2){
    $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1000,$factor)).@$size[$factor];
}
?>
<?php 

//
if(isset($_POST['submit'])){

	$server_ip = $_POST['node_ip'];
	$server_port = $_POST['node_port'];
	
$docker_query = "UPDATE `storj_dashboard`.`docker` SET `port`='$server_port', `server_ip`='$server_ip' WHERE  `id`='$node_id';";
$docker_result = mysqli_query($sql, $docker_query);
	?>
<h1>Updated Docker Agent</h1>
<a href="./?page=dockerView" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Docker List</a>
<?php
	exit;
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Editing [<?php echo $nodes_row['server_ip'].":".$nodes_row['port']; ?>]</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#node_delete_modal"><i class="fas fa-trash" ></i> Delete Docker Agent</a>
                    </div>

                    <!-- Content Row --><!-- Content Row --><!--- ROW --><!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Edit Below</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
        <div class="row">
          <div class="col-12">
                        <div class="p-5">
                            <form method="post" enctype="multipart/form-data">
<div class="form-group">

<div class="form-group">
    <label for="node_ip">Node IP</label>
    <input name="node_ip" type="text" autofocus="autofocus" required="required" class="form-control" id="node_ip" placeholder="Example: 192.168.5.101" value="<?php echo $nodes_row['server_ip'];?>">
  </div>                                    

<div class="form-group">
    <label for="node_port">Node Port</label>
    <input name="node_port" type="number" required="required" class="form-control" id="node_port" placeholder="Example: 14002" value="<?php echo $nodes_row['port'];?>">
  </div>  

                                </div>								
                                
<div class="text-center">                                
                                <button type="submit" class="btn btn-primary btn-user">
                                    Update
                                </button>
                                <a href="./?page=dockerView" class="btn btn-secondary btn-user">
                                    Back
                                </a>
</div>                                
								<input type="hidden" id="submit" name="submit" value="form">
                            </form>

                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>

<!-- Content Row --></div>
                    
<!-- Modal -->
<div class="modal fade" id="node_delete_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You will be deleting this docker agent if you continue.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
        <a href="./dockerDelete.php?id=<?php echo $node_id; ?>" type="button" class="btn btn-danger">Delete Node</a>
      </div>
    </div>
  </div>
</div>	
