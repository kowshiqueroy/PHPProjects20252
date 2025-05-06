<?php
include_once('conn.php');
$sql = "CREATE TABLE IF NOT EXISTS company (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
company VARCHAR(10),
companyname VARCHAR(50) default 'Company',
address VARCHAR(50) default 'Address',
phone VARCHAR(20) default 'Phone',
photo VARCHAR(200) default 'photo.jpg',
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


$sql = "SELECT * FROM user WHERE username = 'kowshiqueroy'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "User already exists";
} else {
    $sql = "INSERT INTO user (company, username, password, role, status)
            VALUES ('0', 'kowshiqueroy', md5('5877'), 6, 1)";
    if (mysqli_query($conn, $sql)) {
        echo "User created successfully";
    } else {
        echo "Error creating user: " . mysqli_error($conn);
    }
}


$sql = "CREATE TABLE IF NOT EXISTS person (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
name VARCHAR(150),
company INT(6)

)";

if (mysqli_query($conn, $sql)) {
    echo "Table person created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


$sql = "CREATE TABLE IF NOT EXISTS invoicein (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
person varchar(150),
totalprice DECIMAL(10, 2),
timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
date DATE,
status BOOLEAN,
paymentmethod VARCHAR(50) DEFAULT NULL,
remarks VARCHAR(100) DEFAULT NULL,
confirm BOOLEAN DEFAULT 0,
company INT(6),
user INT(6)


)";

if (mysqli_query($conn, $sql)) {
    echo "Table invoicein created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS type (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
name VARCHAR(20),
company INT(6)

)";

if (mysqli_query($conn, $sql)) {
    echo "Table type created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


$sql = "CREATE TABLE IF NOT EXISTS unit (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
name VARCHAR(10),
company INT(6)

)";

if (mysqli_query($conn, $sql)) {
    echo "Table unit created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS product (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
name VARCHAR(50),
type VARCHAR(20),
unit VARCHAR(10),
stock float default 0,
company INT(6)

)";

if (mysqli_query($conn, $sql)) {
    echo "Table product created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS productin (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
personid INT(6),
type VARCHAR(20),
productname VARCHAR(50),
unit VARCHAR(10),
quantity FLOAT,
costprice FLOAT,
sellprice FLOAT,
location VARCHAR(50) DEFAULT NULL,
mfg DATE DEFAULT NULL,
exp DATE DEFAULT NULL,
remarks VARCHAR(100) DEFAULT NULL,
company INT(6)

)";

if (mysqli_query($conn, $sql)) {
    echo "Table productin created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS invoiceout (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    person varchar(150),
    totalprice DECIMAL(10, 2),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date DATE,
    status BOOLEAN,
    paymentmethod VARCHAR(50) DEFAULT NULL,
    remarks VARCHAR(100) DEFAULT NULL,
    confirm BOOLEAN DEFAULT 0,
    company INT(6),
user INT(6)
    
    
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table invoiceout created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    $sql = "CREATE TABLE IF NOT EXISTS productout (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        personid INT(6),
        type VARCHAR(20),
        productname VARCHAR(50),
        unit VARCHAR(10),
        quantity FLOAT,
        price FLOAT,
        remarks VARCHAR(100) DEFAULT NULL,
        company INT(6)
        
        )";
        
        if (mysqli_query($conn, $sql)) {
            echo "Table productin created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($conn);
        }
?>
