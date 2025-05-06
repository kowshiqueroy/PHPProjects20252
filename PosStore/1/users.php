<?php
include 'header.php';
?>





    <?php
    $sql = "SELECT * FROM company WHERE id = '".$_SESSION['company']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $companyname = $row['companyname'];
    $address = $row['address'];
    $phone = $row['phone'];
    $photo = $row['photo'];
    ?>
 <?php
    if (isset($_POST["updatecompany"])) {
        $companyname = $_POST["companyname"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $photo = $_POST["photo"];
        $sql = "UPDATE company SET companyname = '$companyname', address = '$address', phone = '$phone', photo = '$photo' WHERE id = '".$_SESSION['company']."'";
        if (mysqli_query($conn, $sql)) {
            echo "Information Updated";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>


<?php
            if (isset($_POST["updatepassword"])) {
                $oldpassword = $_POST["oldpassword"];
                $newpassword = md5($_POST["newpassword"]);
                $sql = "SELECT * FROM user WHERE id = '".$_SESSION['uid']."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row['password'] == md5($oldpassword)) {
                    $sql = "UPDATE user SET password = '$newpassword' WHERE id = '".$_SESSION['uid']."'";
                    if (mysqli_query($conn, $sql)) {
                        echo "Password Updated";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Old password does not match";
                }
            }



            if (isset($_GET['uid'])) {
                $uid = $_GET['uid'];
                $sql = "SELECT * FROM user WHERE id = '$uid'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $status = $row['status'] == 1 ? 0 : 1;
                $sql = "UPDATE user SET status = '$status' WHERE id = '$uid'";
                if (mysqli_query($conn, $sql)) {
                    echo "User status updated successfully";
                    echo "<script>window.location.href = 'users.php';</script>";
                    
                   
                } else {
                    echo "Error updating user status: " . mysqli_error($conn);
                }
            }
            if (isset($_POST['createuser'])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                $role = $_POST['role'];
                $status = 1;
                $sql = "SELECT * FROM user WHERE username = '$username' AND company = '".$_SESSION['company']."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "User already exists";
                } else {
                    $sql = "INSERT INTO user (username, password, role, company, status) VALUES ('$username', '$password', '$role', '".$_SESSION['company']."', '$status')";
                    if (mysqli_query($conn, $sql)) {
                        echo "User created successfully";
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        echo "Error creating user: " . mysqli_error($conn);
                    }
                }
            }
            ?>




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0-beta1/css/bootstrap.min.css" integrity="sha512-8apZeaK72VGvV4yPjsPSD+H6vhJDxmvNxpxF4HjXhwpezoMnQ7VUgKecTc6sj1iZTqwwkLhpDfwbGJUFncRFA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0-beta1/js/bootstrap.min.js" integrity="sha512-KocLQV8bVCkFscjTWfXIqiGLvbQV2bRlhvxVWz2kkjFQOl7iHVwzRWyy9ztdbu+5QC/6ugmPitxQy4DXmjkXzw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .container-fluid {
        padding: 0 3rem;
    }
    .card {
        margin-top: 1rem;
    }
    .card-header {
        background-color: #343a40;
        color: white;
    }
    .table {
        margin-top: 1rem;
    }
    .table thead tr th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody tr td {
        vertical-align: middle;
    }
    .btn {
        margin-top: 0.5rem;
    }
</style>

<div class="container-fluid py-5">
    <div class="card">
        <h5 class="card-header">Update Company Information</h5>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="companyname" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company Name" value="<?php echo $companyname; ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $address; ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $phone; ?>">
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="photo" name="photo" placeholder="Photo" value="<?php echo $photo; ?>">
                        <span class="input-group-text">
                            <?php if($photo != 'photo.jpg'){ ?>
                            <img src="<?php echo $photo; ?>" width="50" height="50" alt="photo">
                            <?php } ?>
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" name="updatecompany" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
   

    <div class="row mt-3">
        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="1">Admin</option>
                        <option value="2">Manager</option>
                        <option value="3">Inventory</option>
                        <option value="4">Sales</option>
                        <option value="5">Assistant</option>
                      
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="createuser">Create User</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="oldpassword" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" required>
                </div>
                <div class="mb-3">
                    <label for="newpassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="updatepassword">Update Password</button>
                </div>
            </form>
           
        </div>

        <h3>User List</h3>
            <?php
            $sql = "SELECT * FROM user WHERE company = '".$_SESSION['company']."' ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<table class='table'>";
                echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Status</th><th>Action</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>";
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
                       
                    }
                    echo "</td>";
                    echo "<td>";
                    echo $row['status'] == 1 ? "Active" : "Inactive";
                    echo "</td>";
                    echo "<td>";
                    if ($row['status'] == 1) {
                        echo "<a href='?uid=".$row['id']."' class='btn btn-danger'>Inactive</a>";
                    } else {
                        echo "<a href='?uid=".$row['id']."' class='btn btn-success'>Active</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No users found";
            }
            
            ?>
    </div>

</div>

<?php

include 'footer.php';
?>
