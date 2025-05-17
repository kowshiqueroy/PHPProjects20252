<?php
  if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], 'ngrok') !== false) {
    $conn = mysqli_connect("localhost", "root", "", "eshop");
  } else {
    $conn = mysqli_connect("remotemysql.com", "6Xp6UyKpFp", "8Xvq4YmL4L", "6Xp6UyKpFp");
  }

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  session_start();

  date_default_timezone_set('Asia/Dhaka');
  //conn

?>