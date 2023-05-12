<?php
// allowed ip range - no login required
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
//echo $ip; // debug
$in_range = 0;
		// split valid ranges
if($config_row['allow-ip-list']!=null){
	$ip_list = explode("\r\n",$config_row['allow-ip-list']);	
}
$counter = 0;
if(count($ip_list)!=0){
do{
		if(!empty($ip_list[$counter])){
	$ip_list_split = explode("-",$ip_list[$counter]);	
	if(!is_null($ip_list_split[0])){
		$low_ip = $ip_list_split[0];
	}
	if(!is_null($ip_list_split[1])){
		$high_ip = $ip_list_split[1];
	} 
			
	if ($ip <= $high_ip && $low_ip <= $ip) {
		$in_range = 1;
	}
		}
$counter = $counter+1;
		
}while($counter!=count($ip_list));
	
}	

////////////////////
//echo "<strong>Allow List:</strong> $in_range"; // debug

?>