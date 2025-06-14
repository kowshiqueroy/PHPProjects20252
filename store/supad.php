<?php
include_once('conn.php');

if(isset($_SESSION['supad'])){
    header("Location: supad/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Super Admin Login - PoSStore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #8B9467, #F7D2C4);
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      width: 100%;
      max-width: 400px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 20px;
    }
    .card-header {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .btn-primary {
      background: linear-gradient(to right, #FFC107, #FFA07A);
      border: none;
      border-radius: 30px;
      padding: 15px;
      font-size: 18px;
      font-weight: bold;
      transition: all 0.3s ease;
      color: #fff;
    }
    .btn-primary:hover {
      background: linear-gradient(to right, #FF9900, #FFC107);
    }
    .form-control {
      border-radius: 30px;
      padding: 12px;
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
      border: none;
    }
    .form-control::placeholder {
      color: #ddd;
    }
    .card-footer {
      text-align: center;
      margin-top: 15px;
    }
    .card-footer a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }
    .card-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        Super Admin Login
      </div>
      <div class="card-body">
        <form action="super_admin_authenticate.php" method="post">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
      <div class="card-footer">
        <a href="index.php">Back to Home</a>
      </div>
    </div>
  </div>
</body>
</html>