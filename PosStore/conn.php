<?php
  $conn = mysqli_connect("localhost", "root", "", "posstore");

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  session_start();
?>