<?php
include '../conn.php';
$productname = $_GET['name'];
$type = $_GET['type'];
$unit = $_GET['unit'];

$sql = "SELECT sellprice, costprice FROM productin WHERE productname = '$productname' AND type = '$type' AND unit = '$unit' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
    $row = array('sellprice' => 0, 'costprice' => 0);
}

$sql_stock = "SELECT stock FROM product WHERE type = '$type' AND name = '$productname' AND unit = '$unit' AND company = '".$_SESSION['company']."'";
$result_stock = mysqli_query($conn, $sql_stock);
if (!$result_stock) {
    die("Error executing stock query: " . mysqli_error($conn));
}

$row_stock = mysqli_fetch_assoc($result_stock);
$row['stock'] = $row_stock ? $row_stock['stock'] : 0;

echo json_encode($row);
?>