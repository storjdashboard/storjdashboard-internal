<?php 

//
if(isset($_POST['docker_name'])){
	
	$name = $_POST['docker_name'];
	$server_ip = $_POST['server_ip'];
	$server_port = $_POST['server_port'];
	
$docker_query = "INSERT INTO `storj_dashboard`.`docker` (`docker_name`, `server_ip`, `port`) VALUES ('$name', '$server_ip', '$server_port');";
$docker_result = mysqli_query($sql, $docker_query);
?>
<h1>Added Docker Agent</h1>
<a href="./?page=dockerView" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Docker List</a>
<?php 
exit;
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Docker Agent</h1>
                        <a href="./" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
                    </div>

                    <!-- Content Row --><!-- Content Row --><!--- ROW --><!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Docker Details</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
        <div class="row">
          <div class="col-12 ">
                        <div class="p-5">
                            <form method="post" enctype="multipart/form-data" id="form">
                 <div class="form-group">
    <label for="docker_name">Docker Name</label>
    <input name="docker_name" type="text" autofocus="autofocus" required="required" class="form-control" id="docker_name" placeholder="Example: Virtual Machine 1">
  </div>
  <div class="form-group">
    <label for="server_ip">Server IP</label>
    <input name="server_ip" type="text" required="required" class="form-control" id="server_ip" placeholder="Example: 192.168.0.100">
  </div>
  <div class="form-group">
    <label for="server_port">Server Port</label>
    <input name="server_port" type="number" required="required" class="form-control" id="server_port" placeholder="Example: 4243">
  </div>																
								
<div class="text-center">                                
                                <button type="submit" class="btn btn-primary btn-user"> Add Docker Agent </button>
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
                    
