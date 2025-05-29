<?php

require_once 'conn.php';

$msg="Database Logs:<br>";


function drop_all_tables($conn) {
    $msg = "";

    $sql = "SET FOREIGN_KEY_CHECKS = 0";
    if ($conn->query($sql) !== TRUE) {
        $msg .= "Error set foreign key checks: " . $conn->error;
    }
    $msg .= "<br>";

    $tables = array();
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    foreach ($tables as $table) {
        $sql = "DROP TABLE IF EXISTS `$table`";
        if ($conn->query($sql) !== TRUE) {
            $msg .= "Error dropping table $table: " . $conn->error;
        } else {
            $msg .= "Table $table dropped";
        }
        $msg .= "<br>";
    }

    $sql = "SET FOREIGN_KEY_CHECKS = 1";
    if ($conn->query($sql) !== TRUE) {
        $msg .= "Error set foreign key checks: " . $conn->error;
    }
    $msg .= "<br>";

    return $msg;
}

//$msg = drop_all_tables($conn);



$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  role INT(1) NOT NULL DEFAULT 1,
  status BOOLEAN NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg.="Table users";
} else {
   $msg.="Error creating table: " . $conn->error; 
}
  $msg.="<br>";



$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $username = 'kowshiqueroy';
    $password = md5('5877');
    $sql = "INSERT INTO users (username,password) VALUES ('$username','$password')";
    if ($conn->query($sql) === TRUE) {
        $msg.="Admin: " . $username;
    } else {
        $msg.="Error creating user: " . $conn->error;
    }
    $msg.="<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS companyinfo (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  companyname VARCHAR(255) NOT NULL,
  tagline VARCHAR(255) NOT NULL,
  logo VARCHAR(255) NOT NULL,
  offertag VARCHAR(255) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  address VARCHAR(255) NOT NULL
 
)";
if ($conn->query($sql) === TRUE) {
    $msg.="Table companyinfo";
} else {
    $msg.="Error creating table: " . $conn->error;
}
  $msg.="<br>";


$sql = "CREATE TABLE IF NOT EXISTS routes (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  route_name VARCHAR(50) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 1
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table route";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS products (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(50) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 1
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table products";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";


$sql = "CREATE TABLE IF NOT EXISTS persons (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  person_name VARCHAR(100) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 1

)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table persons";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";


$sql = "CREATE TABLE IF NOT EXISTS orders (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  person_id INT(11) NOT NULL,
  total DECIMAL(15,2) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 0,
  delivery BOOLEAN NOT NULL DEFAULT 0,
  latitude DECIMAL(10,8) NOT NULL,
  longitude DECIMAL(11,8) NOT NULL,
  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_by INT(11) NOT NULL,
  approved_by INT(11) NOT NULL,
  route_id INT(11) NOT NULL,
   FOREIGN KEY (route_id) REFERENCES routes(id),
   FOREIGN KEY (person_id) REFERENCES persons(id),
   FOREIGN KEY (created_by) REFERENCES users(id),
   FOREIGN KEY (approved_by) REFERENCES users(id)

)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table orders";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";


$sql = "CREATE TABLE IF NOT EXISTS order_product (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  quantity INT(11) NOT NULL,
  price DECIMAL(15,2) NOT NULL,
  total DECIMAL(15,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id)
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table order_product";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";








echo "<div style='text-align: center;'>$msg</div>";
?>