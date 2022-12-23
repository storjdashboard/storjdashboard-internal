<?php // get latest version info from github // 
$github_version = null;
$file_get_github = @file_get_contents("https://raw.githubusercontent.com/storjdashboard/storjdashboard-internal/main/latest_version"); 
$file_get_github = trim($file_get_github);
				$config_row['version'] = "1.0.0.0"; // DEBUG
				$file_get_github = "1.0.0.1"; // DEBUG
	
if($file_get_github>0){
	$github_version = $file_get_github; 
}else{ 
	$github_version = " UNABLE TO READ GITHUB";
} 
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Settings &gt; Updates</h1>
                        <a href="./" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
                    </div>

                    <!-- Content Row --><!-- Content Row --><!--- ROW --><!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Check for updates</h6>
                                    
                                </div>
                                <!-- Card Body -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
								
								<div class="card-body">
        <div class="row">
          <div class="col-12">
                        <div class="p-5">
                            <p><strong>Current Version:</strong> v<?php echo $config_row['version']; ?></p>
							<p><strong>Github Version:</strong> v<?php echo $github_version; ?></p>
							
<?php if($file_get_github>0){							?>
							
							<?php if($config_row['version']==$github_version){ ?>
							<p class="btn btn-success">You have the latest version !</p>
<?php }else{ ?>
							<p>Update is available</p>
							<p><a href="./?page=settingsUpdates&upgrade=1" class="btn btn-warning text-dark">Click to update !</a></p>
							<p><?php if(isset($_GET['upgrade']) && $_GET['upgrade']==1){ ?>

								<?php include_once("$root_dir/include_content/scripts/update/fileDownload.php"); ?>
<?php	} ?>
							</p>
<?php
	}
}  ?>
                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>

<!-- Content Row --></div>
                    
