<?php
if (!isset($_SESSION)) {
  session_start();
}
$SD_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable SD_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$SD_restrictGoTo = "login.html";
if (!((isset($_SESSION['SD_Username'])) && (isAuthorized("",$SD_authorizedUsers, $_SESSION['SD_Username'])))) {   
  $SD_qsChar = "?";
  $SD_referrer = $_SERVER['PHP_SELF'];
  if (strpos($SD_restrictGoTo, "?")) $SD_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $SD_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $SD_restrictGoTo = $SD_restrictGoTo. $SD_qsChar . "redirect=" . $SD_referrer;
  header("Location: ". $SD_restrictGoTo); 
  exit;
}
?>