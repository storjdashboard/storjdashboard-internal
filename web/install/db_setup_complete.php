<?php 
ini_set('display_errors', 1);
$post_fail = 0;
if(!isset($_POST['db_host']) || $_POST['db_host']==''){$post_fail =1;}if(!isset($_POST['db_name']) || $_POST['db_name']==''){$post_fail =1;}if(!isset($_POST['db_username']) || $_POST['db_username']==''){$post_fail =1;}if(!isset($_POST['db_pw']) || $_POST['db_pw']==''){$post_fail =1;}if(!isset($_POST['login_user']) || $_POST['login_user']==''){$post_fail =1;}if(!isset($_POST['login_pw']) || $_POST['login_pw']==''){$post_fail =1;}
if($post_fail == 1){header("location: db_setup.php?fail=1");exit;}
if($post_fail ==0){
// variable set 
	$newline = "<br>";
	$host = $_POST['db_host'];
	$db_name = $_POST['db_name'];
	$db_username = $_POST['db_username'];
	$db_pw = $_POST['db_pw'];
	$login_user = $_POST['login_user'];
	$login_pw = hash("sha384",$_POST['login_pw']);
	
	//create sql file

$myfile = fopen("../Connections/sql.php", "w") or die("Unable to open file!");
$txt = "<?php
ini_set('display_errors', 0); //change value to 1 instead of 0 for debugging

".'$hostname_sql'." = '".$host."';
".'$database_sql'." = '".$db_name."';
".'$username_sql'." = '".$db_username."'; 
".'$password_sql'." = '".$db_pw."';
".'$sql'." = '';

if(".'$hostname_sql'."=='' || ".'$database_sql'."==''  || ".'$username_sql'."==''  || ".'$password_sql'."==''){
	echo '<br>SQL File is not complete. (/Connections/sql.php)<br>'; }else{
try{ ".'$sql'." = mysqli_connect(".'$hostname_sql'.", ".'$username_sql'.", ".'$password_sql'.", ".'$database_sql'.");  } catch (mysqli_sql_exception ".'$e'.") { ".'$sql_error'." = ".'$e->getMessage(); }'." 
}

if (!isset(".'$_SESSION'.")) {
  session_start();
}
?>";
fwrite($myfile, $txt);
fclose($myfile);

//header("location: ./"); //DEBUG
	
	//// SQL WORK
	/////////////
	include("../Connections/sql.php");
	if(isset($sql_error)){ header('Location: '.dirname($_SERVER['PHP_SELF']).''); exit; }
	ini_set('display_errors', 1);
	////////////////////////////
	

	try{
	$insert_sql = "	DROP TABLE IF EXISTS `config`, `docker`,`login`, `nodes`, `paystubs`;";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Drop tables if exists".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
	//insert db sql
		try{
	$insert_sql = "CREATE TABLE IF NOT EXISTS `config` ( 
	`id` INT(10) NOT NULL,
	`version` VARCHAR(10) NOT NULL DEFAULT '1',
	`show_live_bw` INT(10) NOT NULL DEFAULT '0',
	`show_server_info` INT(10) NOT NULL DEFAULT '0',
	`restrict` INT(10) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
);";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Created config".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
			try{
	$insert_sql = "CREATE TABLE IF NOT EXISTS `docker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `docker_name` tinytext NOT NULL,
  `server_ip` tinytext NOT NULL,
  `port` int NOT NULL DEFAULT '4243',
  `user` tinytext,
  `pw` text,
  PRIMARY KEY (`id`)
) COMMENT='adding/removing docker';";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Created docker".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
				try{
	$insert_sql = "CREATE TABLE IF NOT EXISTS `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `pw` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_UNIQUE` (`user`)
) ;";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Created login".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
		
				try{
	$insert_sql = "CREATE TABLE IF NOT EXISTS `nodes` (
  `node_id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `port` varchar(45) NOT NULL,
  PRIMARY KEY (`node_id`)
) ;";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Created nodes".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
				try{
	$insert_sql = "CREATE TABLE IF NOT EXISTS `paystubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `satelliteId` tinytext NOT NULL,
  `period` tinytext NOT NULL,
  `created` tinytext NOT NULL,
  `held` int NOT NULL DEFAULT '0',
  `owed` int NOT NULL DEFAULT '0',
  `disposed` int NOT NULL DEFAULT '0',
  `paid` int NOT NULL DEFAULT '0',
  `distributed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)  COMMENT='api/heldamount/paystubs/2000-01/YYYY-MM';";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "Created paystubs".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
		
	

	//drop all tables in db

	try{
	$drop_sql = "TRUNCATE TABLE config;";
	$drop_sql_result = mysqli_query($sql,$drop_sql);
		echo "Flushed config".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	try{
	$drop_sql = "TRUNCATE TABLE docker;";
	$drop_sql_result = mysqli_query($sql,$drop_sql);
		echo "Flushed docker".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	try{
	$drop_sql = "TRUNCATE TABLE login;";
	$drop_sql_result = mysqli_query($sql,$drop_sql);
		echo "Flushed login".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	try{
	$drop_sql = "TRUNCATE TABLE nodes;";
	$drop_sql_result = mysqli_query($sql,$drop_sql);
		echo "Flushed nodes".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	try{
	$drop_sql = "TRUNCATE TABLE paystubs;";
	$drop_sql_result = mysqli_query($sql,$drop_sql);	
		echo "Flushed paystubs".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
		
	//add admin account
		try{
		$drop_sql = "INSERT INTO `$database_sql`.`login` (`user`, `pw`) VALUES ('$login_user', '$login_pw');";
	$drop_sql_result = mysqli_query($sql,$drop_sql);	
			echo "Admin Account Created".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
	
	//add config
			try{
		$drop_sql = "INSERT INTO `$database_sql`.`config` (`id`, `show_live_bw`, `show_server_info`, `restrict`) VALUES (0, 0, 0, 1);";
	$drop_sql_result = mysqli_query($sql,$drop_sql);	
			echo "Config SQL Created".$newline;
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		echo "[FAIL]  MySQL Error: " .$sql_error.$newline;
   			} 
	
	
header("location: ./");
} /// post file = 0

?>
