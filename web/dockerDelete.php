<?php require_once("cfg.php"); ?>
<?php if($config_row['restrict']==1){ require_once($resitrct_file); } ?>
<?php require_once($sql_conn_file); ?>
<?php if($_SERVER['QUERY_STRING']==''){	header("location: ./?page=dashboard"); };	?>

<?php
$node_id = $_GET['id'];
$docker_query = "DELETE FROM `storj_dashboard`.`docker` WHERE  `id`='$node_id';";
$docker_result = mysqli_query($sql, $docker_query);
header("location: ./?page=dockerView");
?>