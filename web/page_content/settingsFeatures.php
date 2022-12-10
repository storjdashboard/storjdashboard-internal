<?php $updated = 0;
$set_show_live_bw=0;
$set_restrict=0;
if(isset($_POST['update'])){
	// data has been posted 
//UPDATE `storj_dashboard`.`config` SET `version` = '1.0.0.2' WHERE (`id` = '0');

		if(isset($_POST['restricted'])){if(is_null($_POST['restricted']) || $_POST['restricted'] ==''){ $set_restrict =0; }else{ $set_restrict = $_POST['restricted'];}}
		if(isset($_POST['live_data'])){if(is_null($_POST['live_data']) || $_POST['live_data'] ==''){ $set_show_live_bw =0; }else{ $set_show_live_bw = $_POST['live_data'];}}
		
	if($set_show_live_bw==''){$set_show_live_bw=0;}
	if($set_restrict==''){$set_restrict=0;}
	$features_update_query = "UPDATE `storj_dashboard`.`config` SET `show_live_bw` = '$set_show_live_bw', `restrict` = '$set_restrict' WHERE (`id` = '0');";
		$features_update_result = mysqli_query($sql, $features_update_query);
	$updated = 1;
 //read site config // 
$config_query = "SELECT * FROM storj_dashboard.config where id = 0;";
$config_result = mysqli_query($sql, $config_query);
$config_total = mysqli_num_rows($config_result);
$config_row = mysqli_fetch_assoc($config_result);	
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Settings &gt; Features</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
                    </div>

                    <!-- Content Row --><!-- Content Row --><!--- ROW --><!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Features</h6>
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
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
								
								<div class="card-body">
        <div class="row">
          <div class="col-xl-12 col-lg-6">
                        <div class="p-5">
                            <form action="?page=settingsFeatures" method="post" enctype="multipart/form-data" id="form" name="form" novalidate="novalidate">
                                <div class="form-group row">
									
<?php if($updated==1){?>
<span class"text-center"><h1>Updated!</h1></span>
<?php }?>
                                    <div class="col-12 m-2 text-center">
<input name="live_data" type="checkbox" id="live_data" form="form" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" <?php if($config_row['show_live_bw']){ echo "checked"; } ?>>
Live Data Display										
                                    </div>
									
                                    <div class="col-12  m-2 text-center">
<input name="restricted" type="checkbox" id="restricted" form="form" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" <?php if($config_row['restrict']){ echo "checked"; } ?>>
Login Protected										
                                    </div>
                                </div>
<div class="text-center">                                
                                <button type="submit" class="btn btn-primary btn-user">
                                    Update Settings
                                </button>
                                <a href="./" class="btn btn-secondary btn-user">
                                    Back
                                </a>
                  <input name="update" type="hidden" id="update" form="form" value="1">
</div>                                
                            </form>

                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>

<!-- Content Row --></div>
                    
