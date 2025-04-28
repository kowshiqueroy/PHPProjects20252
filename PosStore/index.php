<!DOCTYPE html>
<html>
<head>
  <title>PoSStore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-+YgY+qJKHgaqTKdVtau4JKUHQ95DP5uUJIE7VGD/lSrdc4bqwno6votZBQIUZrV" crossorigin="anonymous"></script>
  <style>
    .container{
      margin-top: 10px;
    }
    .form-control{
      width: 300px;
    }
    .card{
      margin: 0 auto; /* Added */
      float: none; /* Added */
      margin-bottom: 10px; /* Added */
    }
  </style>
</head>
<body>

  <header>
    <h1 class="text-center">Manage Your Store with Us</h1>
  </header>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="card card-block">
          <h2 class="card-title">PoSStore</h2>
          <form action="authenticate.php" method="post">
            <div class="form-group">
              <label for="companyname">Company Name</label>
              <input type="text" class="form-control" id="companyname" name="companyname" required>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card card-block">
          <h4 class="card-title">Cloud Data</h4>
          <div class="card-text">
            <p id="compname">Any Device</p>
            <p id="compaddress">Barcode</p>
            <p id="compemail">Fully Free</p>
            <p id="compphone">01632950179</p>
          </div>
        </div>
      </div>
    </div>


  </div>
</body>
</html>

