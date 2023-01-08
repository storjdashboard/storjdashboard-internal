<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Install</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 p-t-275 p-b-100">
        <div class="wrapper wrapper--w690">
            <div class="card card-1">
                <div class="card-heading">
                    <h2 class="title">StorjDashboard</h2>
                </div>
                <div class="card-body">
                    <form class="wizard-container" method="POST" action="db_setup_complete.php" id="js-wizard-form">
                        <ul class="nav nav-tab">
                            <li class="active">
                                <a href="#tab1" data-toggle="tab">1</a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab">1</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
								<h4>Database Administration</h4><br>
<?php $fileExist_db = 0;$hostname_sql = "";$database_sql = "";$username_sql = "";$password_sql = "";
echo "<h5>";
if(file_exists("../Connections/sql.php")){
if($hostname_sql=="" || $database_sql==""  || $username_sql==""  || $password_sql==""){
		echo "<br><span style='color:#cc7000'><strong>Notice:</strong> SQL file has empty data.</span>"; 
}else{	
	
	include_once("../Connections/sql.php");
	$fileExist_db = 1;
		echo "<br><span style='color:red'><strong>Warning:</strong> Reading Existing SQL file</span>";
	if(isset($sql_error)){
		echo "<br><span style='color:red'><strong>Warning:</strong> $sql_error</span>";
	}else{
		echo "<br><span style='color:green'><strong>Notice:</strong> MySQL Connected</span>";
	}

if(is_writable("../Connections/sql.php")){}else{
	echo "<br><span style='color:red'><strong>Warning:</strong> Connections/sql.php not writable</span>";
}	
}
}
echo "</h5>";
?><br>
                                <div class="input-group">
                                    <label class="label">Database Host:</label>
                                    <input class="input--style-1" type="text" name="db_host" placeholder="example: localhost" required value="<?php echo $hostname_sql; ?>">
                                </div>
                                <div class="input-group">
                                    <label class="label">Database Name:</label>
                                    <input class="input--style-1" type="text" name="db_name" placeholder="example: storj_dashboard" required value="<?php echo $database_sql; ?>">
                                </div>			
                                <div class="input-group">
                                    <label class="label">Database Username:</label>
                                    <input class="input--style-1" type="text" name="db_username" placeholder="example: storj" required value="<?php echo $username_sql; ?>">
                                </div>								
                                <div class="input-group">
                                    <label class="label">Database Password:</label>
                                    <input class="input--style-1" type="text" name="db_pw" placeholder="example: pa55w0rd!" required value="<?php echo $password_sql; ?>">                     </div>								
                                <div class="btn-next-con">
                                    <a class="btn-next" href="#">Next</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2"> 
							<h4>Dashboard Login</h4><br>
                                <div class="input-group">
                                    <label class="label">Admin Username:</label>
                                    <input class="input--style-1" type="text" name="login_user" placeholder="example: admin">
                                </div>
                                <div class="input-group">
                                    <label class="label">Admin Password:</label>
                                    <input class="input--style-1" type="text" name="login_pw" placeholder="....">
                                </div>
                                <div class="btn-next-con">
                                    <a class="btn-back" href="#">back</a>
                                    <a class="btn-last" href="#" onclick="document.getElementById('js-wizard-form').submit();">Submit</a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="vendor/bootstrap-wizard/bootstrap.min.js"></script>
    <script src="vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body>

</html>
<!-- end document-->