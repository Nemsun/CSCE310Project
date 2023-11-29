<?php 
session_start();
include_once 'dbh.inc.php';

$sql = "SELECT * FROM event;";
$result = mysqli_query($conn, $sql);


?>