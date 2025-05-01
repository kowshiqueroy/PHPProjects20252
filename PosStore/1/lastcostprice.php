<?php
include '../conn.php';
$productname = $_GET['name'];
$type = $_GET['type'];
$unit = $_GET['unit'];

$sql = "SELECT sellprice, costprice FROM productin WHERE productname = '$productname' AND type = '$type' AND unit = '$unit' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>