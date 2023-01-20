<?php if(isset($_SERVER['QUERY_STRING'])){
	if(str_contains($_SERVER['QUERY_STRING'],'page=')){
		$QueryString = str_replace("page=","",$_SERVER['QUERY_STRING']);
	}else{
		$QueryString = $_SERVER['QUERY_STRING'];
	}
}; ?>
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a href="./" class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon ">
                <img src="img/logo.png" style="max-width:100%;" alt="Logo"> 
                </div>
                <div class="sidebar-brand-text mx-3"> <small><sup>beta</sup></small></div>
            </a>
 
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
        
            <li class="nav-item <?php if($QueryString=='dashboard'){ echo "active"; } ?>">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Storj
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if(str_contains($QueryString,'node')){
				$NodeExpanded = "true";
				$NodeCollapse = "";
				$NodeAccordion = "show";
			}else{
				$NodeExpanded = "false";
				$NodeCollapse = "collapsed";
				$NodeAccordion = "";
			}?>
            <li class="nav-item <?php if(str_contains($QueryString,'node')){ echo "active"; } ?>">
              <a class="nav-link <?php echo $NodeCollapse; ?>" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="<?php echo $NodeExpanded; ?>" aria-controls="collapseTwo">
                    <i class="fas fa fa-server"></i>
                    <span>Nodes</span>
                </a>
              <div id="collapseTwo" class="collapse <?php echo $NodeAccordion; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Options:</h6>
                        <a class="collapse-item <?php if($QueryString=='nodeAdd'){ echo "active"; } ?>" href="./?page=nodeAdd">Add </a>
						<a class="collapse-item <?php if($QueryString=='nodePayments'){ echo "active"; } ?>" href="./?page=nodePayments">Payments </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
	            <?php if(str_contains($QueryString,'docker')){
				$DockerExpanded = "true";
				$DockerCollapse = "";
				$DockerAccordion = "show";
			}else{
				$DockerExpanded = "false";
				$DockerCollapse = "collapsed";
				$DockerAccordion = "";
			}?>
            <li class="nav-item <?php if(str_contains($QueryString,'docker')){ echo "active"; } ?>">
              <a class="nav-link <?php echo $DockerCollapse; ?>" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="<?php echo $DockerExpanded; ?>" aria-controls="collapseThree">
                    <i class="fa-brands fa-docker"></i>
                    <span>Docker</span>
                </a>
              <div id="collapseThree" class="collapse <?php echo $DockerAccordion; ?>" aria-labelledby="headingThree" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Options:</h6>
                        <a class="collapse-item <?php if($QueryString=='dockerView'){ echo "active"; } ?>" href="./?page=dockerView">View</a>
                        <a class="collapse-item <?php if($QueryString=='dockerAdd'){ echo "active"; } ?>" href="./?page=dockerAdd">Add</a>
                    </div>
                </div>
            </li>

  <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Options</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if(str_contains($QueryString,'settings')){
				$SettingsExpanded = "true";
				$SettingsCollapse = "";
				$SettingsAccordion = "show";
			}else{
				$SettingsExpanded = "false";
				$SettingsCollapse = "collapsed";
				$SettingsAccordion = "";
			}?>
            <li class="nav-item <?php if(str_contains($QueryString,'settings')){ echo "active"; } ?>">
                <a class="nav-link <?php echo $SettingsCollapse ; ?>" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="<?php echo $SettingsExpanded; ?>" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div id="collapsePages" class="collapse <?php echo $SettingsAccordion; ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings:</h6>
                        <a class="collapse-item <?php if($QueryString=='settingsFeatures'){ echo "active"; } ?>" href="./?page=settingsFeatures">Features</a>
                        <a class="collapse-item <?php if($QueryString=='settingsUpdates'){ echo "active"; } ?>" href="./?page=settingsUpdates">Updates</a>
                        
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <h2><i class="fa-solid fa-circle-info"></i></h2>
              <p class="text-center mb-2"><strong></strong>Need Help?</p>
                <a class="btn btn-success btn-sm" href="https://docs.storjdashboard.com/internal" target="_blank">Help Guide</a>
            </div>

</ul>