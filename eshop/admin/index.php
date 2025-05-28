<?php
require_once '../conn.php';

$msg="Database Logs:<br>";
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
  favicon VARCHAR(255) NOT NULL,
  logo VARCHAR(255) NOT NULL,
  banner VARCHAR(255) NOT NULL,
  offertag VARCHAR(255) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  address VARCHAR(255) NOT NULL,
  bank VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg.="Table companyinfo";
} else {
    $msg.="Error creating table: " . $conn->error;
}
  $msg.="<br>";





$sql = "CREATE TABLE IF NOT EXISTS photos (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL,
  timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table photos";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS products (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  productname VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  brand VARCHAR(255) NOT NULL,
  maker VARCHAR(255) NOT NULL,
  unitname VARCHAR(255) NOT NULL,
  stock INT(11) NOT NULL DEFAULT 0,
  details TEXT NOT NULL,
  review TEXT NOT NULL,
  costprice DECIMAL(15,2) NOT NULL,
  showprice DECIMAL(15,2) NOT NULL,
  sellprice DECIMAL(15,2) NOT NULL,
  photo VARCHAR(255) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 1
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table products";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table categories";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS brands (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table brands";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS makers (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table makers";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS unitnames (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table unitnames";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";


$sql = "CREATE TABLE IF NOT EXISTS person (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  details VARCHAR(255) NOT NULL
  
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table person";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS indetails (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  person_id INT(11) NOT NULL,
  total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  purchase_date DATE NOT NULL DEFAULT CURRENT_DATE,
  type BOOLEAN NOT NULL DEFAULT 0,
  status BOOLEAN NOT NULL DEFAULT 0,
  payment_method VARCHAR(10) DEFAULT NULL,
  payment_details VARCHAR(100) DEFAULT NULL,
  remarks VARCHAR(255) DEFAULT NULL,
  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

  
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table indetails";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS inproducts (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT(11) NOT NULL,
  price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  quantity INT(11) NOT NULL DEFAULT 0,
  indetails_id INT(11) NOT NULL
  
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table inproducts";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";
$sql = "CREATE TABLE IF NOT EXISTS outdetails (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  person_id INT(11) NOT NULL,
  total DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  purchase_date DATE NOT NULL DEFAULT CURRENT_DATE,
  type BOOLEAN NOT NULL DEFAULT 0,
  status BOOLEAN NOT NULL DEFAULT 0,
  payment_method VARCHAR(10) DEFAULT NULL,
  payment_details VARCHAR(100) DEFAULT NULL,
  remarks VARCHAR(255) DEFAULT NULL,
  session_id VARCHAR(255) DEFAULT NULL,
  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

  
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table outdetails";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS outproducts (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT(11) NOT NULL,
  price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  quantity INT(11) NOT NULL DEFAULT 0,
  outdetails_id INT(11) NOT NULL
  
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table outproducts";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";


$sql = "CREATE TABLE IF NOT EXISTS review (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT(11) NOT NULL,
  name VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  contact VARCHAR(50) NOT NULL,
  star INT(1) NOT NULL DEFAULT 0,
  review TEXT NOT NULL,
  status BOOLEAN NOT NULL DEFAULT 0,
  type BOOLEAN NOT NULL DEFAULT 0,
  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table review";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

$sql = "CREATE TABLE IF NOT EXISTS featured (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT(11) NOT NULL,
  type INT(1) NOT NULL DEFAULT 0
)";
if ($conn->query($sql) === TRUE) {
    $msg .= "Table featured";
} else {
    $msg .= "Error creating table: " . $conn->error;
}
$msg .= "<br>";

?>

<?php

if(isset($_POST['submitLogin'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND status=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        $sql = "UPDATE users SET last_login=NOW() WHERE username='$username'";
        $conn->query($sql);


        $_SESSION['admin'] = true;
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        $_SESSION['status'] = $user['status'];
        switch ($user['role']) {
            case 1:
                $_SESSION['rolename'] = 'admin';
                break;
            case 2:
                $_SESSION['rolename'] = 'viewer';
                break;
            case 3:
                $_SESSION['rolename'] = 'editor';
                break;
            case 4:
                $_SESSION['rolename'] = 'manager';
                break;
            default:
                $_SESSION['rolename'] = 'unknown';
                break;
        }
        $_SESSION['id'] = $user['id'];

    } else {
        $msg.="Invalid username or password";

    }
}





if(isset($_SESSION['admin']) && $_SESSION['admin'] == true && $_SESSION['status'] == 1){
    header("Location: home.php");
}else{


    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background-color: #fafafa;
            font-family: sans-serif;
        }
        .login-form {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            margin: 100px auto;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 2px #ccc;
        }
        .message{
            text-align: center;
            background-color: #fff;
            
            border: 1px solid #ddd;
            box-shadow: 2px 2px 2px #ccc;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form input[type="text"], .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Admin Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="submitLogin" value="Login">
        </form>

       <div class="message"> <p><?php echo $msg; ?></p> </div>
    </div>
</body>
</html>

<?php
   
}
?>




