<?php
require_once 'conn.php';

if(!isset($_SESSION['sid'])) {
    $_SESSION['sid']= session_id();
}


?>

   <?php
        $sql = "SELECT * FROM companyinfo WHERE id = 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $companyname = $row['companyname'];
        $tagline = $row['tagline'];
        $logo = $row['logo'];
        $favicon= $row['favicon'];
        $banner = $row['banner'];
        $offertag = $row['offertag'];
        $phone = $row['phone'];
        $email = $row['email'];
        $address = $row['address'];
        $bank = $row['bank'];
        $mobilebankingcharge=2;
        $deliverycharge=5;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $companyname; ?></title>
    <link rel="shortcut icon" href="admin/<?php echo $favicon; ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    
    
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: linear-gradient(to right, #4CAF50, #2E8B57);
            color: white;
        }

        .logo {
            font-size: 2rem;
        }

        .shop-button {
            background: #FFD700;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .shop-button:hover {
            background: #E6B800;
        }

        .info {
            text-align: center;
            margin-top: 10px;
            width: 100%;
        }

        .tagline {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .offer {
            color: #FFD700;
            font-size: 1rem;
        }

        .contact {
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Banner */
        .banner {
            
            padding: 80px;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
          
           
        }
        .banner img {
            width: 80vw;
            max-height: 300px;
            
        }

        /* Featured Books */
        .featured-books {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 40px;
             grid-template-columns: repeat(4, 1fr);
        }

        .book {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 100px;
            width: 20vw;

        }

        .book img {
            height: 150px;
            max-width: 150px;
           
            border-radius: 5px;
        }

        .book h3 {
            margin: 10px 0;
            font-size: 1.2rem;
        }

        .book p {
            font-size: 1rem;
            color: #666;
        }

        .book button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
           
            
            
        }

        .book button:hover {
            background: #2E8B57;
        }

        .book:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        
        .percentSave {
            animation: fadeInOut 2s ease-in-out infinite;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            padding: 15px;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .featured-books {
                grid-template-columns: repeat(2, 1fr);
             
            }

              .banner img {
            width: 65vw;
            max-height: 100px;
            
        }
            .book {
                   width: 40vw;
            }

            /* Adjust header layout for mobile */
            header {
                flex-direction: column;
                text-align: center;
            }

            .shop-button {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

   
    
<div id="top-message" style=" display: none; position: fixed; top: 0; left: 0; width: 100%; background: #4CAF50; color: white; padding: 10px; z-index: 1000; text-align: center;">
    <p>Succesfully added to Cart</p>
    <div style="margin-top: 10px;">
        <button style="background:#2196F3; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px;" onclick="window.location.href='cart.php'">Go to Cart</button>
        <button style="background:#ff9800; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px;" onclick="document.getElementById('top-message').style.display='none'">Continue Shopping</button>
    </div>
</div>

    



 
    <!-- Header -->
    <header>
        <div class="logo" onclick="window.location.href='index.php'">
            <img src="admin/<?php echo $logo; ?>" alt="Company Logo" style="height: 50px;">
        </div>
        <h1 onclick="window.location.href='index.php'"><?php echo $companyname; ?></h1>
        <div style="display: flex; justify-content: space-between; gap: 5px;">
            <button class="shop-button" onclick="window.location.href='shop.php'">Shop</button>
            <button class="shop-button" onclick="window.location.href='cart.php'">Cart</button>
        </div>
    </header>

    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner-border {
            width: 5rem;
            height: 5rem;
            border: 0.5rem solid #ccc;
            border-top: 0.5rem solid #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div id="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('preloader').style.display = 'none';
        }, 1000);
    </script>

  
   

   