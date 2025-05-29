<?php
require_once 'conn.php';
?>



<?php
$msg='';
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
                $_SESSION['rolename'] = 'sr';
                break;
            case 3:
                $_SESSION['rolename'] = 'sradmin';
                break;
            case 4:
                $_SESSION['rolename'] = 'viewer';
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
    header("Location: ".$_SESSION['rolename']."/index.php");
}else{


    ?>

<!DOCTYPE html>
<html>
<head>
    <title>SHARM Sales APP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            background-color: #fafafa;
            font-family: sans-serif;
        }
        .login-form {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            margin: 100px auto;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 2px #ccc;
        }
        .message{
            text-align: center;
            background-color: #fff;
            
            border: 1px solid #ddd;
            box-shadow: 2px 2px 2px #ccc;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form input[type="text"], .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>SHARM Sales App</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submitLogin" value="Login">
        </form>

       <div class="message"> <p>Developer: <b>kowshiqueroy@gmail.com</b>
        
       <?php 
       echo $msg;
        ?>
        </p> </div>
    </div>
</body>
</html>

<?php
   
}
?>




