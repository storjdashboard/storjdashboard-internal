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
            <?php if(str_contains($QueryString,'dashboard')){
			$DashboardActive = "active";
			}else{
			$DashboardActive = "";
			}?>            
            <li class="nav-item active">
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
            <li class="nav-item">
              <a class="nav-link <?php echo $NodeCollapse; ?>" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="<?php echo $NodeExpanded; ?>" aria-controls="collapseTwo">
                    <i class="fas fa fa-server"></i>
                    <span>Nodes</span>
                </a>
              <div id="collapseTwo" class="collapse <?php echo $NodeAccordion; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Options:</h6>
                        <a class="collapse-item <?php if($QueryString=='nodeAdd'){ echo "active"; } ?>" href="./?page=nodeAdd">Add Node</a>
                        <a class="collapse-item" href="#">Settings</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            

  <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Options</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Dashboard:</h6>
                        <a class="collapse-item" href="#">Features</a>
                        <a class="collapse-item" href="#">Order</a>
                        <a class="collapse-item" href="#">Settings</a>
                        
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Something</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
              <p class="text-center mb-2"><strong>TEXT</strong> TEXT</p>
                <a class="btn btn-success btn-sm" href="#">TEXT</a>
            </div>

</ul>