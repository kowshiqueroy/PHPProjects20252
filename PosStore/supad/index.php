<?php
include_once('../conn.php');


if (!isset($_SESSION['supad']) || $_SESSION['supad'] !== true) {
    header("Location: ../supad.php");
    exit();
}

if (isset($_POST['createcompany'])) {
    $company = $_POST['company'];
    $sql = "SELECT * FROM company WHERE company = '$company'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Company already exists";
    } else {
        $sql = "INSERT INTO company (company, status) VALUES ('$company', 1)";
        if (mysqli_query($conn, $sql)) {
            echo "Company inserted successfully";
        } else {
            echo "Error creating company: " . mysqli_error($conn);
        }
    }
}
if  (isset($_POST['createuser'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // assuming passwords are stored as md5 hash
    $company = $_POST['company'];
    $role = $_POST['role'];
    $status = 1;
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "User already exists";
    } else {
        $sql = "INSERT INTO user (username, password, company, role, status) VALUES ('$username', '$password', '$company', '$role', '$status')";
        if (mysqli_query($conn, $sql)) {
            echo "User inserted successfully";
        } else {
            echo "Error creating user: " . mysqli_error($conn);
        }
    }
}
if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $sql = "SELECT * FROM company WHERE id = '$cid'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'] == 1 ? 0 : 1;
        $sql = "UPDATE company SET status = '$status' WHERE id = '$cid'";
        if (mysqli_query($conn, $sql)) {
            echo "Company status updated successfully";
        } else {
            echo "Error updating company status: " . mysqli_error($conn);
        }
    } else {
        echo "Company not found";
    }
}

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $sql = "SELECT * FROM user WHERE id = '$uid'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'] == 1 ? 0 : 1;
        $sql = "UPDATE user SET status = '$status' WHERE id = '$uid'";
        if (mysqli_query($conn, $sql)) {
            echo "User status updated successfully";
        } else {
            echo "Error updating user status: " . mysqli_error($conn);
        }
    } else {
        echo "User not found";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Super Admin - PoSStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlHanbsdirFQzTYVTdnjhVyVBFvJOsqWgY=" crossorigin="anonymous" />
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Heebo', sans-serif;
        }
        .container {
            margin-top: 10px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card {
            margin: 0 auto; /* Added */
            float: none; /* Added */
            margin-bottom: 10px; /* Added */
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #3f51b5;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .table th, .table td {
            border-top: none;
        }
        .table thead th {
            border-bottom: none;
        }
        .btn {
            border-radius: 0;
        }
        .btn-primary {
            background-color: #3f51b5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-building"></i> Create Company</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="company">Company Name</label>
                                <input type="text" class="form-control" id="company" name="company" required>
                            </div>
                            <button type="submit" name="createcompany" class="btn btn-primary btn-block">Create</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body text-center">
                        <a href="../logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user"></i> Create User</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="company">Company Name</label>
                                <select class="form-control" id="company" name="company" required>
                                    <?php
                                        $sql = "SELECT * FROM company order by id DESC";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id'] . "'>".$row['company']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option>
                                    <option value="3">Inventory</option>
                                    <option value="4">Sales</option>
                                    <option value="5">Assistant</option>
                                    <option value="6">Super</option>
                                </select>
                            </div>
                            <button type="submit" name="createuser" class="btn btn-primary btn-block">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Company Name</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM company order by id DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>".$row['id']."</td>
                                                <td>".$row['company']."</td>
                                                <td>".$row['status']."</td>
                                                <td>
                                                    <a href='index.php?cid=".$row['id']."' class='btn btn-".($row['status'] == 1 ? "success" : "danger")."'>".($row['status'] == 1 ? "Disable" : "Enable")."</a>
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>User</h3>
                    </div>
                    <div class="card-body">
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                        <table class="table table-striped table-responsive" id="myTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Company Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM user  order by company  ";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>".$row['id']."</td>
                                                <td>".$row['username']."</td>
                                                <td>";
                                                    
                                                        $sql2 = "SELECT company FROM company WHERE id = '".$row['company']."'";
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        if (mysqli_num_rows($result2) > 0) {
                                                            $row2 = mysqli_fetch_assoc($result2);
                                                            echo $row2['company'];
                                                        } else {
                                                            echo "None";
                                                        }
                                                 
                                               echo " </td>
                                                <td>";
                                                    switch ($row['role']) {
                                                        case 1:
                                                            echo "Admin";
                                                            break;
                                                        case 2:
                                                            echo "Manager";
                                                            break;
                                                        case 3:
                                                            echo "Inventory";
                                                            break;
                                                        case 4:
                                                            echo "Sales";
                                                            break;
                                                        case 5:
                                                            echo "Assistant";
                                                            break;
                                                        case 6:
                                                            echo "Super";
                                                            break;
                                                        default:
                                                            echo "Unknown";
                                                    }
                                                echo "</td>
                                                <td>".$row['status']."</td>
                                                <td>
                                                    <a href='index.php?uid=".$row['id']."' class='btn btn-".($row['status'] == 1 ? "success" : "danger" )."'>".($row['status'] == 1 ? "Disable" : "Enable")."</a>
                                                </td>
                                                <td>".$row['lastlogin']."</td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <script>
                            function myFunction() {
                              var input, filter, table, tr, td, i;
                              input = document.getElementById("myInput");
                              filter = input.value.toUpperCase();
                              table = document.getElementById("myTable");
                              tr = table.getElementsByTagName("tr");
                              for (i = 0; i < tr.length; i++) {
                                td = tr[i].getElementsByTagName("td");
                                var show = false;
                                for (var j = 0; j < td.length; j++) {
                                    if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                                        show = true;
                                        break;
                                    }
                                }
                                if (show) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                              }
                            }
                        </script>
                        <br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br><br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

