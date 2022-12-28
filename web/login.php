<?php 
require_once("cfg.php");
require_once($sql_conn_file);

// Check connection
if (!$sql) {
  die("Connection failed: " . mysqli_connect_error());
  exit;
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=hash("sha384",$_POST['pw']);
  $SD_fldUserAuthorization = "";


if(isset($_POST['redirect'])){

if($_POST['redirect']<>''){
	$SD_redirectLoginFailed = $root_url_dir."/login.html?error=1&redirect=".$_POST['redirect'];
	$SD_redirectLoginSuccess = $_POST['redirect'];
}else{
	$SD_redirectLoginFailed = $root_url_dir."/login.html?error=1";
	$SD_redirectLoginSuccess = $root_url_dir."/";
}  

}

mysqli_select_db($sql,$database_sql);
  
  $LoginRS__query=sprintf("SELECT user,pw FROM login WHERE user='%s' AND pw='%s'",
    $loginUsername, $password); 
   
  $LoginRS = mysqli_query($sql,$LoginRS__query) or die(mysqli_error($mysqli));
  $loginFoundUser = mysqli_num_rows($LoginRS);

  
  if ($loginFoundUser) {
    // continue login
	session_regenerate_id(true);

    //declare two session variables and assign them
    $_SESSION['SD_Username'] = $loginUsername;

    //header("Location: " . $SD_redirectLoginSuccess );
	header("Location: " . $SD_redirectLoginSuccess );
	 }
	else {
	  //failed
    header("Location: ". $SD_redirectLoginFailed );
  }
}
?>