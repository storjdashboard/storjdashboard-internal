<?php 
// Fetch node_hosts for dropdown
$hosts_query = "SELECT * FROM $database_sql.node_hosts ORDER BY host_name ASC;";
$hosts_result = mysqli_query($sql, $hosts_query);
$hosts = [];
while ($row = mysqli_fetch_assoc($hosts_result)) {
    $hosts[] = $row;
}

// Handle form submission
if (isset($_POST['node_ip']) && isset($_POST['node_port'])) {
    $server_name = mysqli_real_escape_string($sql, $_POST['node_name']);
    $server_ip = mysqli_real_escape_string($sql, $_POST['node_ip']);
    $server_port = mysqli_real_escape_string($sql, $_POST['node_port']);
    $server_ext_ip = isset($_POST['node_ext_ip']) ? mysqli_real_escape_string($sql, $_POST['node_ext_ip']) : null;
    $server_host_id = $_POST['node_host_id'] ?? null;
    if ($server_host_id === 'none') $server_host_id = null;

    $query = "
        INSERT INTO `$database_sql`.`nodes` 
        (`name`, `ip`, `port`, `ext_ip`, `host_id`) 
        VALUES (
            '$server_name',
            '$server_ip',
            '$server_port',
            " . ($server_ext_ip ? "'$server_ext_ip'" : "NULL") . ",
            " . ($server_host_id !== null ? intval($server_host_id) : "NULL") . "
        );
    ";
    mysqli_query($sql, $query);
    ?>
    <h1>Added Node</h1>
    <a href="./" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Dashboard</a>
    <?php
    exit;
}
?>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add Node</h1>
    <a href="./" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa fa-long-arrow-left"></i> Back</a>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Node Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="node_name">Node Name</label>
                                    <input name="node_name" type="text" autofocus required class="form-control" id="node_name" placeholder="Example: Storj-01">
                                </div>   
                                
                                <div class="form-group">
                                    <label for="node_ip">Node IP / Hostname</label>
                                    <input name="node_ip" type="text" required class="form-control" id="node_ip" placeholder="Example: 192.168.5.101">
                                </div>                                    

                                <div class="form-group">
                                    <label for="node_port">Node Port</label>
                                    <input name="node_port" type="number" required class="form-control" id="node_port" placeholder="Example: 14002">
                                </div>  

                                <div class="form-group">
                                    <label for="node_ext_ip">External IP / Hostname (optional)</label>
                                    <input name="node_ext_ip" type="text" class="form-control" id="node_ext_ip" placeholder="Example: ext.domain.com or 203.0.113.5">
                                </div>

                                <div class="form-group">
                                    <label for="node_host_id">Node Host</label>
                                    <select name="node_host_id" class="form-control" id="node_host_id">
                                        <option value="">None</option>
                                        <?php foreach ($hosts as $host): ?>
                                            <option value="<?php echo $host['host_id']; ?>">
                                                <?php echo htmlspecialchars($host['host_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="text-center">                                
                                    <button type="submit" class="btn btn-primary btn-user">Add Node</button>
                                    <a href="./" class="btn btn-secondary btn-user">Back</a>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
