<?php
include '../conn.php';
$sql = "SELECT p.id, t.name AS type, p.productname, u.name AS unit, p.quantity, p.costprice, p.sellprice, p.location, p.mfg, p.exp, p.remarks 
        FROM productin p 
        JOIN type t ON p.type = t.id 
        JOIN unit u ON p.unit = u.id 
        WHERE p.id = '".$_GET['id']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo json_encode($row);
?>
