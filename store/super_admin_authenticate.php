<?php
include_once('conn.php');

$username = $_POST['username'];
$password = md5($_POST['password']); // assuming passwords are stored as md5 hash

$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND role = 6 AND status = 1";    
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);
    $sql = "UPDATE user SET lastlogin = NOW() WHERE id = ".$row['id'];
    mysqli_query($conn, $sql);
    $_SESSION['supad'] = true;
    header("Location: supad/");
    exit();
} else {
    echo '<div style="text-align: center; font-size: 24px; color: red;">Error: Invalid username, password, or insufficient role.</div>';
    echo '<meta http-equiv="refresh" content="3;url=supad.php" />';
    
}
?>

