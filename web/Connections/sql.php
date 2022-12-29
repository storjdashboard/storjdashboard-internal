<?php
ini_set('display_errors', 0);

$hostname_sql = "localhost";
$database_sql = "storj_dashboard";
$username_sql = "";
$password_sql = "";
$sql = mysqli_connect($hostname_sql, $username_sql, $password_sql, $database_sql); 

if (!isset($_SESSION)) {
  session_start();
}
?>
