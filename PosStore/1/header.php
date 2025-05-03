<?php include '../conn.php'; 


    if ($_SESSION['role'] != basename(__DIR__)) {
        header("Location: ../" . $_SESSION['role'] . "/");
        exit();
    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PoSStore</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

  

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

 

    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0 noprint">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">PoSStore</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                 
                    <a href="users.php" class="nav-item nav-link"><?php 
                        $sql = "SELECT company FROM company WHERE id = '".$_SESSION['company']."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['company'];
                    ?></a>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">In</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="inadd.php" class="dropdown-item">Add</a>
                            <a href="inlist.php" class="dropdown-item">List</a>
                            <a href="type.php" class="dropdown-item">Type</a>
                            <a href="unit.php" class="dropdown-item">Unit</a>
                            <a href="product.php" class="dropdown-item">Product</a>

                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Out</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="outadd.php" class="dropdown-item">Add</a>
                            <a href="outlist.php" class="dropdown-item">List</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Report</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="reportstock.php" class="dropdown-item">Stock</a>
                            <a href="reportin.php" class="dropdown-item">In</a>
                            <a href="reportout.php" class="dropdown-item">Out</a>
                        </div>
                    </div>
                 
                    
                    
                </div>

                <a href="../logout.php" class="btn btn-danger rounded-0 py-4 px-lg-5 d-lg-block  text-center mx-auto logoutbtn"><?php echo $_SESSION["username"];?> <i class="fa fa-sign-out-alt me-3"></i>Logout</a>
           
           
            </div>
        </nav>
        <!-- Navbar End -->

    
        <div>