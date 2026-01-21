<?php
session_start();
session_destroy();

// echo "<script>alert('logging out!!');</script>";

header("Location: ../home/login.php");
exit();
?>
