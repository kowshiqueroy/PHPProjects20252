<?php
include_once('conn.php');
$sql = "CREATE TABLE IF NOT EXISTS company (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
company VARCHAR(50),
status INT(1)
)";
if (mysqli_query($conn, $sql)) {
    echo "Table company created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS user (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
username VARCHAR(50),
password VARCHAR(50),
company VARCHAR(50),
role INT(1),
status INT(1),
lastlogin DATETIME
)";

if (mysqli_query($conn, $sql)) {
    echo "Table user created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


$sql = "INSERT INTO user (company,username, password, role, status)
VALUES ('0','kowshiqueroy', md5('5877'), 6, 1)
ON DUPLICATE KEY UPDATE id=id";
if (mysqli_query($conn, $sql)) {
    echo "User created successfully";
} else {
    echo "Error creating user: " . mysqli_error($conn);
}
?>
