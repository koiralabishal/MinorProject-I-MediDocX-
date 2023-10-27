<?php
include('connection.php');
session_start();
session_unset();
session_destroy();
// header("location: index.php");
?>
<script>
    // Redirect to index.php on successful logout
    window.location.href = "index.php";
</script>
<?php
?>