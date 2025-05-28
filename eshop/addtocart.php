<?php
require_once 'conn.php';
$product_id = $_POST['id'];





$session_id = $_SESSION['sid'] ;
echo "Session ID: " . $session_id;
echo "Product ID: ". $product_id ." ";


 $outdetails_id ="";
$sql = "SELECT id FROM outdetails WHERE session_id = '$session_id' AND type = 0 LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $outdetails_id = $row['id'];
} else {
    $sql = "INSERT INTO outdetails (session_id, type, status) VALUES ('$session_id', 0, 0)";
    if ($conn->query($sql) === TRUE) {
        $outdetails_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


echo "outdetails_id: ". $outdetails_id ."";

$sql = "SELECT sellprice FROM products WHERE id = '$product_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sellprice = $row['sellprice'];
} else {
    $sellprice = 0;
}

$sql = "SELECT id FROM outproducts WHERE outdetails_id = '$outdetails_id' AND product_id = '$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sql = "UPDATE outproducts SET quantity = quantity + 1 WHERE outdetails_id = '$outdetails_id' AND product_id = '$product_id'";
      echo " Add ";
} else {
    $sql = "INSERT INTO outproducts (outdetails_id, product_id, price, quantity) VALUES ('$outdetails_id', '$product_id', '$sellprice', 1)";
     echo " New ";
}

if ($conn->query($sql) === TRUE) {
    echo "Record updated or created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


?>