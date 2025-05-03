<?php
include '../conn.php';
$sql = "SELECT p.id, t.name AS type, p.productname, u.name AS unit, p.quantity, p.costprice, p.sellprice, p.location, p.mfg, p.exp, p.remarks 
        FROM productin p 
        JOIN type t ON p.type = t.id 
        JOIN unit u ON p.unit = u.id 
        WHERE p.id = '".$_GET['id']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sql_stock = "SELECT stock FROM product WHERE type = (SELECT id FROM type WHERE name = '".$row['type']."' AND company = '".$_SESSION['company']."') AND name = '".$row['productname']."' AND unit = (SELECT id FROM unit WHERE name = '".$row['unit']."' AND company = '".$_SESSION['company']."')";
$result_stock = mysqli_query($conn, $sql_stock);
$row_stock = mysqli_fetch_assoc($result_stock);

$row['stock'] = $row_stock['stock'];


echo json_encode($row);
?>
