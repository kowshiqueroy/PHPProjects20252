<?php

include_once('conn.php');

    $company = $_POST['company'];

    $sql = "SELECT id FROM company WHERE company = '$company'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $companyid = $row['id'];
    } else {
        header("Location: notice.php?msg=Company+does+not+exist");
        exit();
    }
    
    $username = $_POST['username'];
    $password = md5($_POST['password']); // assuming passwords are stored as md5 hash

    $sql = "SELECT * FROM user WHERE username = '$username'  AND company = '$companyid'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['password'] != $password) {
            echo '<div style="text-align: center; font-size: 24px; color: red;">Wrong password</div>';
            echo '<meta http-equiv="refresh" content="3;url=index.php" />';
            exit();
        }
        
        if ($row['status'] == 0) {
            header("Location: notice.php?msg=Your+account+is+currently+blocked.+Please+contact+the+admin+for+more+information.");
            exit();
        }
       
        $_SESSION['uid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['company'] = $companyid;
        $_SESSION['role'] = $row['role'];
        $sql = "SELECT status FROM company WHERE id = '$companyid'";
        $result = mysqli_query($conn, $sql);
        $company_status = mysqli_fetch_assoc($result)['status'];
        if ($company_status == 0) {
            header("Location: notice.php?msg=Company+is+currently+blocked.+Please+contact+the+PoSStore+admin+for+more+information.");
        } else {

            $sql = "UPDATE user SET lastlogin = NOW() WHERE id = " . $row['id'];
            mysqli_query($conn, $sql);
            header("Location: " . $row['role'] . "/");
        }
        exit();
    } else {
        echo '<div style="text-align: center; font-size: 24px; color: red;">Invalid Username</div>';
        echo '<meta http-equiv="refresh" content="3;url=index.php" />';
    }


?>