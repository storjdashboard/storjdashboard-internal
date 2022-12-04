<?php
///config file
$root_dir = "/var/www/html/sd-internal";
$root_url_dir = ".";
$sql_conn_file = "Connections/sql.php";
?>

<?php
function errorHandler() { echo "<script>window.location = '?page=error';</script>"; }
//set_error_handler('errorHandler');
?>