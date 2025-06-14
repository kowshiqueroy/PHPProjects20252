<?php
  if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], 'ngrok') !== false) {
    $conn = mysqli_connect("localhost", "root", "", "posstore");
  } else {
    $conn = mysqli_connect("localhost", "u312077073_storekr", "ITOijat5877", "u312077073_store");
  }

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  session_start();

  date_default_timezone_set('Asia/Dhaka');

?>