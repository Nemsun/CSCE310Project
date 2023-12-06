<!-- Written by Patrick Keating -->

<?php
session_start();

session_destroy();

header("Location: ../index.php");
exit();
?>