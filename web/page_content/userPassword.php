<?php 
$id = $_SESSION['SD_Username'];
$nodes_query = "SELECT * FROM $database_sql.login where `user` = '$id'";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_total = mysqli_num_rows($nodes_result);
$nodes_row = mysqli_fetch_assoc($nodes_result);

	$node_id = $nodes_row['id'];
?>
<?php 

//
if(isset($_POST['submit'])){

	$pw = hash("sha384",$_POST['pw']);
	
$docker_query = "UPDATE `$database_sql`.`login` SET `pw`='$pw' WHERE  `id`='$node_id';";
$docker_result = mysqli_query($sql, $docker_query);
	?>
<h1>Updated Password</h1>
<a href="./?page=logout" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Continue </a>
<?php
	exit;
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Update Password</h1>
                        <a href="./?page=dashboard" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-home" ></i> Home</a>
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
    <label for="node_ip">User</label>
    <input  readonly type="text" required="required" class="form-control" placeholder="..." value="<?php echo $nodes_row['user'];?>">
  </div>                                    

<div class="form-group">
    <label for="pw">New Password</label>
    <input name="pw" type="password" required="required" class="form-control" id="pw" autofocus="autofocus" placeholder="N3w P455w02d" value="">
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
