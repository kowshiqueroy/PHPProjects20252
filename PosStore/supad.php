<?php
include_once('conn.php');

if(isset($_SESSION['supad'])){
    header("Location: supad/index.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Super Admin Login - PoSStore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <style>
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      width: 100%;
      max-width: 400px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-header {
      background-color: #007bff;
      color: white;
      border-bottom: none;
      padding: 15px;
      border-radius: 10px 10px 0 0;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 50px;
      padding: 10px 20px;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header text-center">
        <h3>Super Admin Login</h3>
      </div>
      <div class="card-body">
        <form action="super_admin_authenticate.php" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
      </div>
      <div class="card-footer text-center">
        <a href="index.php">Back to Home</a>
       
      </div>
    </div>

