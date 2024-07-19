<?php
///config file
$root_dir = "/var/www/html/[cfg_root_dir]";  // Edit this to your direct server pathway | DO NOT ADD TRAILING '/'
$root_url_dir = "."; // Can be left alone
$sql_conn_file = "Connections/sql.php"; // Can be left alone
$resitrct_file = "include_content/restrict.php"; // Can be left alone

/// no editing required below this ------------------
?><?php
//function errorHandler() { echo "<script>window.location = '?page=error';</script>"; }
//set_error_handler('errorHandler');
?><?php require_once($sql_conn_file);
 //read site config // 
$config_query = "SELECT * FROM $database_sql.config where id = 0;";
$config_result = mysqli_query($sql, $config_query);
$config_total = mysqli_num_rows($config_result);
$config_row = mysqli_fetch_assoc($config_result);
?>
