<pre><?php
  include_once("cfg.php");
    // Initialize a file URL to the variable
	$new_version = trim($github_version);
	$directory = $root_dir."/include_content/scripts/update/downloads/";
	//https://github.com/storjdashboard/storjdashboard-internal/archive/refs/tags/v1.0.0.1.tar.gz
    //$url = "https://github.com/storjdashboard/storjdashboard-internal/archive/refs/tags/v$new_version.tar.gz"; DEBUG
$url = "https://github.com/storjdashboard/storjdashboard-internal/archive/refs/tags/v$new_version.tar.gz";
      echo "attempting: https://github.com/storjdashboard/storjdashboard-internal/archive/refs/tags/v$new_version.tar.gz<br>";
    // Use basename() function to return the base name of file
    $file_name = basename($url);
      
    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using base name
	$start_time = microtime(true);

    if (file_put_contents($directory.$file_name, @file_get_contents($url)))
    {
        echo "<p>File downloaded successfully in ".number_format(microtime(true) - $start_time, 2)." seconds.</p>";
    }
    else
    { echo "<p>Update failed.</p>"; exit; }

	//check file exists 
	clearstatcache();
	if(file_exists($directory.$file_name)){
	echo "<p>File Found</p>";
	}
	//check file size
	$filesize = filesize($directory.$file_name);
	if($filesize>0){
	echo "<p>File is Valid (".number_format($filesize,0)." Bytes)</p>";
	}

?>
If all passed
run command
<kbd>sudo bash <?php echo $root_dir; ?>/include_content/scripts/update/linux_updater.sh <?php echo $root_dir; ?> <?php echo $file_name; ?> <?php echo $new_version; ?></kbd>