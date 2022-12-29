<?php 
    session_unset();
    session_destroy();
    session_regenerate_id(true);
?>
<script>
window.location.replace("./?page=dashboard");
</script>