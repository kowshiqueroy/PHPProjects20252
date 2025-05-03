<!DOCTYPE html>
<html lang="en">
<head>
  <title>PoSStore - Smart Business Solution</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }
    .container {
      margin-top: 60px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }
    .card:hover {
      box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
    }
    .icon {
      font-size: 2rem;
      color: #007bff;
      margin-right: 10px;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      border-radius: 30px;
      transition: background 0.3s ease-in-out;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .form-control {
      background: #f1f3f5;
      border: 1px solid #ddd;
      padding: 12px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <header class="text-center py-4">
    <h1><i class="fa-solid fa-store"></i> PoSStore - Manage Your Business Effortlessly</h1>
  </header>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card text-center">
          <h2><i class="fa-solid fa-lock"></i> Login</h2>
          <form action="authenticate.php" method="post">
            <div class="form-group mb-3">
              <label for="company">Company Name</label>
              <input type="text" class="form-control" id="company" name="company" placeholder="Enter company name" required>
            </div>
            <div class="form-group mb-3">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group mb-3">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-sign-in-alt"></i> Login</button>
          </form>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <h4><i class="fa-solid fa-cloud"></i> Why PoSStore?</h4>
          <div class="card-text">
            <p><i class="fa-solid fa-mobile-alt icon"></i> Access from Any Device</p>
            <p><i class="fa-solid fa-barcode icon"></i> Easy Inventory Management</p>
            <p><i class="fa-solid fa-barcode icon"></i> Quick Sales with Barcode Scanner</p>
            <p><i class="fa-solid fa-chart-line icon"></i> Custom Reports & Analytics</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>