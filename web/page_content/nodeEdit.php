<?php 
$id = $_GET['id'];
$nodes_query = "SELECT * FROM $database_sql.nodes WHERE node_id = '$id' LIMIT 1;";
$nodes_result = mysqli_query($sql, $nodes_query);
$nodes_row = mysqli_fetch_assoc($nodes_result);
$node_id = $nodes_row['node_id'];

// Fetch node_hosts for dropdown
$hosts_query = "SELECT * FROM $database_sql.node_hosts ORDER BY host_name ASC;";
$hosts_result = mysqli_query($sql, $hosts_query);
$hosts = [];
while ($row = mysqli_fetch_assoc($hosts_result)) {
    $hosts[] = $row;
}

if (isset($_POST['submit'])) {
    $server_ip = $_POST['node_ip'];
    $server_port = $_POST['node_port'];
    $server_name = $_POST['node_name'];
    $server_ext_ip = $_POST['node_ext_ip'] ?? null;
    $server_host_id = $_POST['node_host_id'] ?? null;
    if ($server_host_id === 'none') $server_host_id = null;

    $update_query = "
        UPDATE `$database_sql`.`nodes` SET 
        `name` = '".mysqli_real_escape_string($sql, $server_name)."',
        `port` = '".mysqli_real_escape_string($sql, $server_port)."',
        `ip` = '".mysqli_real_escape_string($sql, $server_ip)."',
        `ext_ip` = " . ($server_ext_ip ? "'".mysqli_real_escape_string($sql, $server_ext_ip)."'" : "NULL") . ",
        `host_id` = " . ($server_host_id !== null ? intval($server_host_id) : "NULL") . "
        WHERE `node_id` = '$node_id';
    ";
    mysqli_query($sql, $update_query);
    ?>
    <h1>Updated Node</h1>
    <a href="./" class="btn btn-primary btn-user"><i class="fas fa fa-long-arrow-left"></i> Dashboard</a>
    <?php exit;
}
?>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editing <?php echo $nodes_row['name']; ?> <small>[<?php echo $nodes_row['ip'].":".$nodes_row['port']; ?>]</small></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#node_delete_modal"><i class="fas fa-trash" ></i> Delete Node</a>
</div>

<!-- Form -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Edit Below</h6>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="p-5">
                        <form method="post" enctype="multipart/form-data">

                          <div class="form-group">
                            <label for="node_name">Node name</label>
                            <input name="node_name" type="text" required class="form-control" id="node_name" placeholder="Example: Storj-01" value="<?php echo htmlspecialchars($nodes_row['name']); ?>">
                          </div>  

                          <div class="form-group">
                            <label for="node_ip">Node IP / Hostname</label>
                            <input name="node_ip" type="text" required class="form-control" id="node_ip" placeholder="Example: 192.168.5.101" value="<?php echo htmlspecialchars($nodes_row['ip']); ?>">
                          </div>                                    

                          <div class="form-group">
                            <label for="node_port">Node Port</label>
                            <input name="node_port" type="number" required class="form-control" id="node_port" placeholder="Example: 14002" value="<?php echo htmlspecialchars($nodes_row['port']); ?>">
                          </div>  

                          <div class="form-group">
                            <label for="node_ext_ip">External IP / Hostname</label>
                            <input name="node_ext_ip" type="text" class="form-control" id="node_ext_ip" placeholder="Optional external IP or hostname" value="<?php echo htmlspecialchars($nodes_row['ext_ip']); ?>">
                          </div>

                          <div class="form-group">
                            <label for="node_host_id">Node Host</label>
                            <select name="node_host_id" class="form-control" id="node_host_id">
                              <option value="none">None</option>
                              <?php foreach ($hosts as $host): ?>
                                <option value="<?php echo $host['host_id']; ?>" 
                                  <?php echo ($nodes_row['host_id'] == $host['host_id']) ? 'selected' : ''; ?>>
                                  <?php echo htmlspecialchars($host['host_name']); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <div class="text-center">                                
                            <button type="submit" class="btn btn-primary btn-user">Update</button>
                            <a href="./" class="btn btn-secondary btn-user">Back</a>
                          </div>                                
                          <input type="hidden" id="submit" name="submit" value="form">
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="node_delete_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        You will be deleting this node if you continue.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
        <a href="./nodeDelete.php?id=<?php echo $node_id; ?>" class="btn btn-danger">Delete Node</a>
      </div>
    </div>
  </div>
</div>

</div>
