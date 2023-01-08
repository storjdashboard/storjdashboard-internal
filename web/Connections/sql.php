<?php
ini_set('display_errors', 0 ); //change value to 1 instead of 0 for debugging

$hostname_sql = "localhost";
$database_sql = "";
$username_sql = "";
$password_sql = "";
$sql = "";

if($hostname_sql=="" || $database_sql==""  || $username_sql==""  || $password_sql==""){
	echo "<br>SQL File is not complete. (/Connections/sql.php)<br>"; }else{
try{ $sql = mysqli_connect($hostname_sql, $username_sql, $password_sql, $database_sql); } catch (mysqli_sql_exception $e) { $sql_error = $e->getMessage(); }
}

if (!isset($_SESSION)) {
  session_start();
}
?>
