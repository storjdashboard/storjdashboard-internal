<?php
$msg = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle delete host
if (isset($_POST['delete_host']) && isset($_POST['host_id'])) {
    $host_id = intval($_POST['host_id']);
    $delete_query = "DELETE FROM `$database_sql`.`node_hosts` WHERE `host_id` = $host_id";
    mysqli_query($sql, $delete_query);
    echo "<script>window.location.href='./?page=nodeHosts&msg=deleted';</script>";
    exit;
}

// Handle add new host
if (isset($_POST['add_host']) && !empty(trim($_POST['host_name']))) {
    $host_name = mysqli_real_escape_string($sql, trim($_POST['host_name']));
    $insert_query = "INSERT INTO `$database_sql`.`node_hosts` (`host_name`) VALUES ('$host_name')";
    mysqli_query($sql, $insert_query);
    echo "<script>window.location.href='./?page=nodeHosts&msg=added';</script>";
    exit;
}

// Handle update host
if (isset($_POST['update_host']) && isset($_POST['host_id']) && !empty(trim($_POST['host_name']))) {
    $host_id = intval($_POST['host_id']);
    $host_name = mysqli_real_escape_string($sql, trim($_POST['host_name']));
    $update_query = "UPDATE `$database_sql`.`node_hosts` SET `host_name` = '$host_name' WHERE `host_id` = $host_id";
    mysqli_query($sql, $update_query);
    echo "<script>window.location.href='./?page=nodeHosts&msg=updated';</script>";
    exit;
}

// Message handler
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'deleted':
            $msg = 'Host successfully deleted.';
            $msg_class = 'alert-danger';
            break;
        case 'updated':
            $msg = 'Host successfully updated.';
            $msg_class = 'alert-success';
            break;
        case 'added':
            $msg = 'Host successfully added.';
            $msg_class = 'alert-success';
            break;
        default:
            $msg = '';
    }
}

// Fetch all hosts
$hosts_result = mysqli_query($sql, "SELECT * FROM `$database_sql`.`node_hosts` ORDER BY host_id ASC;");
$hosts = [];
while ($row = mysqli_fetch_assoc($hosts_result)) {
    $hosts[] = $row;
}
?>

<!-- HTML CONTENT STARTS HERE -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Node Hosts</h1>
        <a href="./" class="btn btn-sm btn-danger shadow-sm">
            <i class="fas fa-long-arrow-left"></i> Back
        </a>
    </div>

    <?php if ($msg): ?>
        <div class="alert <?php echo $msg_class; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($msg); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Existing Hosts</h6>
        </div>
        <div class="card-body">
            <?php if (empty($hosts)): ?>
                <p>No hosts added yet.</p>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Host ID</th>
                            <th>Host Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hosts as $host): ?>
                            <tr>
                                <form method="post">
                                    <input type="hidden" name="host_id" value="<?php echo $host['host_id']; ?>">
                                    <td><?php echo $host['host_id']; ?></td>
                                    <td>
                                        <input type="text" name="host_name" value="<?php echo htmlspecialchars($host['host_name']); ?>" class="form-control" required>
                                    </td>
                                    <td>
                                        <button type="submit" name="update_host" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-delete"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="<?php echo $host['host_id']; ?>"
                                            data-name="<?php echo htmlspecialchars($host['host_name']); ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">Add New Host</h6>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="host_name">Host Name</label>
                    <input type="text" name="host_name" class="form-control" id="host_name" required>
                </div>
                <button type="submit" name="add_host" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Host
                </button>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="post">
      <input type="hidden" name="host_id" id="modal_host_id">
      <input type="hidden" name="delete_host" value="1">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete host: <strong id="modal_host_name"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- REQUIRED JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    console.log('jQuery is loaded');

    // Handle delete button click
    $('.btn-delete').on('click', function () {
        var hostId = $(this).data('id');
        var hostName = $(this).data('name');

        $('#modal_host_id').val(hostId);
        $('#modal_host_name').text(hostName);
    });

    // Optional: auto-dismiss alerts
    setTimeout(() => {
        $('.alert-dismissible').alert('close');
    }, 3000);
});
</script>
