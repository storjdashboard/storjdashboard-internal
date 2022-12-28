<?php
///config file
$root_dir = "/var/www/html/sd-internal";  // DO NOT ADD TRAILING '/'
$root_url_dir = ".";
$sql_conn_file = "Connections/sql.php";
$resitrct_file = "include_content/restrict.php";
?>

<?php
function errorHandler() { echo "<script>window.location = '?page=error';</script>"; }
//set_error_handler('errorHandler');
?>

<?php require_once($sql_conn_file);
 //read site config // 
$config_query = "SELECT * FROM $database_sql.config where id = 0;";
$config_result = mysqli_query($sql, $config_query);
$config_total = mysqli_num_rows($config_result);
$config_row = mysqli_fetch_assoc($config_result);
?>

<?php // display all errors
//ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL);
?>