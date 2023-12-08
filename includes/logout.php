<!-- Written by Patrick Keating -->

<!-- Handles the logout of the user for both admin and student -->
<?php
session_start();

session_destroy();

header("Location: ../index.php");
exit();
?>