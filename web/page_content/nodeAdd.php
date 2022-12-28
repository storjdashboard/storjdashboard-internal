<?php 

//
if(isset($_POST['node_ip']) && isset($_POST['node_port'])){
	
	$server_ip = $_POST['node_ip'];
	$server_port = $_POST['node_port'];
	
$docker_query = "INSERT INTO `$database_sql`.`nodes` (`ip`, `port`) VALUES ('$server_ip', '$server_port');";
$docker_result = mysqli_query($sql, $docker_query);
	?>
<h1>Added Node</h1>
<a href="./" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Dashboard</a>
<?php
	exit;
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Node</h1>
                        <a href="./" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
                    </div>

                    <!-- Content Row --><!-- Content Row --><!--- ROW --><!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Node Details</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
        <div class="row">
          <div class="col-12 ">
                        <div class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">

<div class="form-group">
    <label for="node_ip">Node IP</label>
    <input name="node_ip" type="text" autofocus="autofocus" required="required" class="form-control" id="node_ip" placeholder="Example: 192.168.5.101">
  </div>                                    

<div class="form-group">
    <label for="node_port">Node Port</label>
    <input name="node_port" type="number" required="required" class="form-control" id="node_port" placeholder="Example: 14002">
  </div>  

                                </div>
<div class="text-center">                                
                                <button type="submit" class="btn btn-primary btn-user">
                                    Add Node
                                </button>
                                <a href="./" class="btn btn-secondary btn-user">
                                    Back
                                </a>
</div>                                
                            </form>

                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>

<!-- Content Row --></div>
                    
