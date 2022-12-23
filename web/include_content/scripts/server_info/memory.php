<?php
$output = null; $code = null; $item = null; $count=0;
$MemTotal=null;$MemFree=null;$MemAvailable=null;$Buffers=null;

$command = "cat /proc/meminfo"; //reading memory data
exec($command,$output,$code);

$total_rows = count($output);
// example content
//    [0] => MemTotal:        1000088 kB
//    [1] => MemFree:           90100 kB
//    [2] => MemAvailable:     493340 kB
//    [3] => Buffers:           46632 kB

do{
	$item = $output[$count];
	if(str_starts_with($item,"MemTotal:")){
		$item = preg_replace("/[^0-9]/", '', $item);
		$MemTotal = $item;
	}
	if(str_starts_with($item,"MemFree:")){
		$item = preg_replace("/[^0-9]/", '', $item);
		$MemFree = $item;
	}
	if(str_starts_with($item,"MemAvailable:")){
		$item = preg_replace("/[^0-9]/", '', $item);
		$MemAvailable = $item;
	}
	if(str_starts_with($item,"Buffers:")){
		$item = preg_replace("/[^0-9]/", '', $item);
		$Buffers = $item;
	}	
	$count=$count+1;
}while($count!==$total_rows);

$MemFree = $MemFree+$MemAvailable;

$PercentFree=$MemFree/$MemTotal*100;
$PercentUsed=100-$PercentFree;
//echo $PercentFree."%"; 
echo "<strong>Total:</strong> ".number_format(($MemTotal/1000),0)."MB"; 
echo "<br>";
echo "<strong>Available:</strong> ".number_format($PercentUsed,1)."%"; 

?>