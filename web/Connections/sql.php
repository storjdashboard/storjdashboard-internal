<?php
ini_set('display_errors', 0);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sql = "localhost";
$database_sql = "storj_dashboard";
$username_sql = "";
$password_sql = "";
$sql = mysqli_connect($hostname_sql, $username_sql, $password_sql, $database_sql); 

if (!isset($_SESSION)) {
  session_start();
}
?>
