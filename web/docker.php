<?php require_once("cfg.php"); ?>
<?php if($config_row['restrict']==1){ require_once($resitrct_file); } ?>
<?php require_once($sql_conn_file); ?>
<?php if($_SERVER['QUERY_STRING']==''){	header("location: ./?page=dashboard"); };	?>
<?php
$option = $_GET['opt'];
$id = $_GET['id'];
$method = $_GET['method'];
$ip = $_GET['ip'];
$port = $_GET['port'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://$ip:$port/containers/$id/$option");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "$method");


$headers = array();
$headers[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

// Check if Referral URL exists
if (isset($_SERVER['HTTP_REFERER'])) {
  // Store Referral URL in a variable
  $refURL = $_SERVER['HTTP_REFERER'];
  // Display the Referral URL on web page
  header("location: $refURL");
} else {
  header("location: ./");
}
?>