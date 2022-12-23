<?php 

$ip =$nodes_row['ip'];
$port = $nodes_row['port'];
// CURL check
$jsonobj = @file_get_contents("http://$ip:$port/api/sno/", false, $ctx);
$arr = json_decode($jsonobj, true);
$validCheck = @count($arr);
if($validCheck>0){

$capacity = formatSize($arr['diskSpace']['available']);
$storage = formatSize($arr['diskSpace']['used']+$arr['diskSpace']['trash']);
$bandwidth = formatSize($arr['bandwidth']['used']);

$LastPingToTime = explode(".",$arr['lastPinged']);
$LastPingToTime = strtotime($LastPingToTime[0]);
$onlineCalc = round(time()-$LastPingToTime);
if($onlineCalc<=30){$onlineResult = 1;}else{$onlineResult = 0;}
}else{
	$onlineResult = 0;
	$capacity = 0;
	$storage = 0;
	$bandwidth = 0;
}

?>