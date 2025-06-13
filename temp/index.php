<?php
require_once 'conn.php';
 $msg = '';
if(isset($_POST['submitLogin'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND status=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        $sql = "UPDATE users SET last_login=NOW() WHERE username='$username'";
        $conn->query($sql);


        $_SESSION['admin'] = true;
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        $_SESSION['status'] = $user['status'];
        switch ($user['role']) {
            case 1:
                $_SESSION['rolename'] = 'admin';
                break;
            case 2:
                $_SESSION['rolename'] = 'viewer';
                break;
            case 3:
                $_SESSION['rolename'] = 'editor';
                break;
            case 4:
                $_SESSION['rolename'] = 'manager';
                break;
            default:
                $_SESSION['rolename'] = 'unknown';
                break;
        }
        $_SESSION['id'] = $user['id'];

    } else {
        $msg.="Invalid username or password";

    }
}





if(isset($_SESSION['admin']) && $_SESSION['admin'] == true && $_SESSION['status'] == 1){
    header("Location: home.php");
}else{


    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .message {
            text-align: center;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            color: #721c24;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 24px;
        }
        .login-form input[type="text"], 
        .login-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f9f9f9;
            transition: background-color 0.3s;
        }
        .login-form input[type="text"]:focus, 
        .login-form input[type="password"]:focus {
            background-color: #e9ecef;
            outline: none;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s;
        }
        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        @media only screen and (max-width: 767px) {
            .login-form {
                width: 90%;
                padding: 20px;
                transform: scale(1.2);
            }
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Inventory Management Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submitLogin" value="Login">
        </form>
        <div class="message">
            <p><?php echo $msg; ?></p>
        </div>
    </div>
</body>
</html>

<?php
   
}
?>




