<?php

$output = null; $code = null;
$command = "grep -c processor /proc/cpuinfo";

exec($command,$output,$code);
echo "<strong>Cores:</strong> ".$output[0];

echo "<br>";

$output = null; $code = null;
$command = "cat /proc/loadavg";

exec($command,$output,$code);
$avg = explode(" ",$output[0]);

echo "<strong>15 Min Avg:</strong> ".$avg[2];

?>