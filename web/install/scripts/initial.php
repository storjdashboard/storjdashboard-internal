<?php
$pass_count = 0;
$fail_count = 0;
$newline = "<br>";
$pass = "<i class='fa fa-check' style='color:green' aria-hidden='true'></i>";
$fail = "<i class='fa fa-times' style='color:red' aria-hidden='true'></i>";
$test = "<i class='fa fa-info-circle' style='color:orange' aria-hidden='true'></i>";

//install log
$log_uname = base64_encode(php_uname());
if(file_exists("../version")){
	$log_version_ = @file_get_contents("../version");
}else{
	$log_version_ = "0.0";
}
$log_version = base64_encode($log_version_);

// check php version 8>
echo "<small><em>".php_uname()."</em></small>";
echo $newline;
if(PHP_VERSION>=8){
	echo "[PASS] $pass PHP Version 8>".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail PHP Version 8> -- Must be updated! ".$newline;
	$fail_count=$fail_count+1;
}

// check CURL version
    function _iscurl() {
        return function_exists('curl_version');
	}
if(_iscurl()){
	echo "[PASS] $pass PHP CURL Installed".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail PHP CURL Not Installed".$newline;
	$fail_count=$fail_count+1;
}

// check if folders are writable
chmod("../include_content/scripts/update", 0777);
if(is_writable("../include_content/scripts/update")){
	echo "[PASS] $pass Writable > Update Folder".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail Update Folder Not Writable".$newline;
	$fail_count=$fail_count+1;
}
if(!file_exists("../include_content/scripts/update/downloads")){
	mkdir("../include_content/scripts/update/downloads", 0777);
}
chmod("../include_content/scripts/update/downloads", 0777);
if(is_writable("../include_content/scripts/update/downloads")){
	echo "[PASS] $pass Writable > Downloads Folder ".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail Downloads Folder Not Writable".$newline;
	$fail_count=$fail_count+1;
}
chmod("../Connections", 0777);
if(is_writable("../Connections")){
	echo "[PASS] $pass Writable > Connections Folder ".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail Connections Folder Not Writable".$newline;
	$fail_count=$fail_count+1;
}
chmod("../Connections/sql.php", 0777);
if(is_writable("../Connections/sql.php")){
	echo "[PASS] $pass Writable > Connections SQL File ".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail Connections SQL File Not Writable".$newline;
	$fail_count=$fail_count+1;
}
chmod("../cfg.php", 0777);
if(is_writable("../cfg.php")){
	echo "[PASS] $pass Writable > Config File ".$newline;
	$pass_count=$pass_count+1;
}else{
	echo "[FAIL] $fail Config File Not Writable".$newline;
	$fail_count=$fail_count+1;
}

// check sql connection file exists
if(file_exists("../Connections/sql.php")){
	echo "[PASS] $pass SQL Connection File Found".$newline;
	$pass_count=$pass_count+1;
	$sql_file_exist = 1;	
// check sql connection

		// Create connection
	include("../Connections/sql.php");
	//$database_sql = "storjdashboard"; // DEBUG
	$conn = $sql;
		// Check connection
	if (!$conn) {
		$sql_connection_exist = 0;
  		echo "[FAIL] $fail SQL Failed To Connect *" . mysqli_connect_error().$newline." <a href='db_setup.php'>Create DB</a> $newline";
		$fail_count=$fail_count+1;
	}else{
		$sql_connection_exist = 1;
	echo "[PASS] $pass SQL Connected successfully".$newline;
		$pass_count=$pass_count+1;
		}
		// check sql tables exist
	if($sql_connection_exist==1){ // database has a value
			echo "[TEST] $test SQL Database Check/Test (<em>$database_sql</em>)".$newline;

/////////////
	// MODIFY SQL 
	include_once("modifyDB_nodes.php");
	
	
///////////////					     
				     
		try {
			$list_tables = "SHOW TABLES FROM `$database_sql`";
			$result1 = mysqli_query($sql,$list_tables);
			$table_count =0;
			while ($row = mysqli_fetch_row($result1)) {
			$this_table[$table_count] = "{$row[0]}";
    		// echo "[PASS] $pass ** Table Found: <em>".$this_table[$table_count]."</em> $newline"; // USE FOR DEBUG
			$table_count=$table_count+1;
			
			}
		// check 6 tables
		if(isset($this_table) && count($this_table)==6){
			echo "[PASS] $pass SQL Database Check/Test (<em>$database_sql</em>)".$newline;
			$pass_count=$pass_count+1;
		}else{
			echo "[FAIL] $fail SQL Tables Do Not Match Expected > <a href='db_setup.php'>Create DB</a>".$newline;
			$fail_count=$fail_count+1;
		}
////////////////////				
			} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
			echo "[FAIL] $fail DB Error, could not list tables".$newline;
    		echo "[FAIL] $fail MySQL Error: " .$sql_error.$newline;
			echo "[FAIL] $fail <a href='db_setup.php'>Create DB</a>$newline";
			$fail_count=$fail_count+1;
   			} 
	}
}else{
	$sql_file_exist = 0;
	echo "[FAIL] $fail SQL File Not Found".$newline;
	$fail_count=$fail_count+1;
}
/////////////////////
if($sql_connection_exist==1){
try{
$LoginAccounts=0;
$ConfigExists=0;
	// check rows valid data
	$valid_counter = count($this_table);
	$valid_count = 0;
	do{
	$validCheck_query = "SELECT * FROM ".$database_sql.".".$this_table[$valid_count]." ;";
	$validCheck_result = mysqli_query($sql, $validCheck_query);
	$validCheck_total = mysqli_num_rows($validCheck_result);
	
	//echo "[PASS] $pass ** SQL Table Checked <em>".$this_table[$valid_count]."</em>: $validCheck_total Rows".$newline; // DEBUG
		
		// checking if any login accounts exist
		if($this_table[$valid_count]=='config'){
			$ConfigExists = $validCheck_total;
			if($ConfigExists>0){
					echo "[PASS] $pass ** SQL Database Config Table Exists + Valid Data $newline";
				$pass_count=$pass_count+1;
			}
		}		
		if($this_table[$valid_count]=='login'){
			$LoginAccounts = $validCheck_total;
			if($LoginAccounts>0){
					echo "[PASS] $pass ** SQL Database Login Table Exists + Valid Data $newline";
				$pass_count=$pass_count+1;
			}
		}
		
		$valid_count=$valid_count+1; }while($valid_count!==$valid_counter);

			// check if version file exists
			if(file_exists("../version")){
				$new_ver = trim(@file_get_contents("../version"));
			echo "[PASS] [EXISTS] $pass Version File Exists *($new_ver)".$newline;
				// update sql 
				try{
				$new_ver = trim(@file_get_contents("../version"));
			
					$versionUpdate_query = "UPDATE `$database_sql`.`config` SET `version`='$new_ver' WHERE  `id`=0;";
					$versionUpdate_result = mysqli_query($sql, $versionUpdate_query);
				echo "[PASS] [UPDATED] $pass Version Updated".$newline;
				} catch (mysqli_sql_exception $e) { 
					$sql_error = $e->getMessage();
					echo "ERROR: ".$sql_error.$newline;
					$fail_count=$fail_count+1;
				}
			$pass_count=$pass_count+1;	
			}else{
			echo "[PASS] $pass Version File Not Found".$newline;
				$pass_count=$pass_count+1;
			}

	


} catch (mysqli_sql_exception $e) { 
	$sql_error = $e->getMessage();
	echo "ERROR: ".$sql_error.$newline;
	$fail_count=$fail_count+1;
}
	
}
@file_get_contents("https://storjdashboard.com/api/internal_install?uname=$log_uname&v=$log_version&f=$fail_count&p=$pass_count"); // helps with debug // error information
?>
