<?php
	#include("../../Connections/sql.php");
	#if(isset($sql_error)){ header('Location: '.dirname($_SERVER['PHP_SELF']).''); exit; }
	
//insert db sql
		try{
	$insert_sql = "ALTER TABLE `nodes`
	ADD COLUMN `name` VARCHAR(50) NULL DEFAULT 'Node' AFTER `node_id`;";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "[PASS] [DB] [UPDATED] $pass .nodes ".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
    		
			if(str_contains($sql_error, "Duplicate column name")){
				echo "[PASS] [DB] $pass .nodes - No Update Required".$newline;	
			}else{
				echo "[FAIL] $test MySQL Error: " .$sql_error.$newline;
			}
			
   			} 

		try{
	$insert_sql = "ALTER TABLE `config`
	ADD COLUMN `allow-ip-list` LONGTEXT NULL AFTER `restrict`;";
	$insert_sql_result = mysqli_query($sql,$insert_sql);
			echo "[PASS] [DB] [UPDATED] $pass .config ".$newline;
				} catch (mysqli_sql_exception $e) { 
			$sql_error = $e->getMessage();
			
			if(str_contains($sql_error, "Duplicate column name")){
				echo "[PASS] [DB] $pass .config - No Update Required".$newline;	
			}else{
				echo "[FAIL] $test MySQL Error: " .$sql_error.$newline;
			}
    		
   			} 
?>