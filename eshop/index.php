<?php
require_once 'conn.php';

echo "Session ID: " . session_id() . "<br>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Haven</title>
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
            width: 15vw;

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
                   width: 30vw;
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

    



    <?php
        $sql = "SELECT * FROM companyinfo WHERE id = 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $companyname = $row['companyname'];
        $tagline = $row['tagline'];
        $logo = $row['logo'];
        $banner = $row['banner'];
        $offer = $row['offertag'];
        $phone = $row['phone'];
        $email = $row['email'];
        $address = $row['address'];
        $bank = $row['bank'];
    ?>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="admin/<?php echo $logo; ?>" alt="Company Logo" style="height: 50px;">
        </div>
        <h1>Book Haven</h1>
        <div style="display: flex; justify-content: space-between; gap: 5px;">
            <button class="shop-button">Shop</button>
            <button class="shop-button">Cart</button>
        </div>
    </header>

    <div class="info">
        <div class="tagline">Your Gateway to Knowledge!</div>
        <div class="offer">Special Offer: 20% Off All Books!</div>
        <div class="contact">Address: 123 Book Street, City | Phone: +123-456-7890</div>
    </div>

    <!-- Banner -->
    <section class="banner">
        <img src="admin/<?php echo $banner; ?>" alt="Company Logo" >
    </section>

    <!-- Featured Books -->
    <section class="featured-books">
       
        
        <?php
        require_once('conn.php');
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 8";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<img src='admin/" . $row['photo'] . "' alt='" . $row['productname'] . "'>";
                echo "<h3>" . $row['productname'] . "</h3>";
                echo "<p>Price: <del>" . $row['showprice'] . "</del> " . $row['sellprice'] . "</p>";
                echo "<button class='add-to-cart' id='" . $row['id'] . "'>Add to Cart</button>";
                echo "</div>";
            }
        }
        ?>

    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Book Haven. All rights reserved.</p>
    </footer>

    <script>
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", () => {
                fetch("addtocart.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${button.id}`
                })
                .then(response => response.text())
                .then(message => {

                    document.getElementById("top-message").style.display = "block";




                    





                });
            });
        });
    </script>

</body>
</html>