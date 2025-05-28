 
 <?php
 require_once("head.php");
 ?>
   <div class="info">
        <div class="tagline"><?php
            echo $tagline;
        ?></div>
        <div class="offertag"><?php
           echo $offertag;
        ?></div>
        <div class="contact"><?php
           echo $address;
        ?> | <?php
         echo $phone;
        ?> | <?php
         echo $email;
        ?></div>
    </div>

 <!-- Banner -->
    <section class="banner">
        <img src="admin/<?php echo $banner; ?>" alt="Company Logo" >
    </section>
   
   
   
   
    <!-- Featured Books -->

        <h2 style="text-align: center; font-size: 2.5rem; font-weight: bold;  text-shadow: 2px 2px 2px #ccc;">Featured</h2>

    <section class="featured-books">
       
        
       
        
        <?php
        require_once('conn.php');



        $sql = "SELECT p.id, p.photo, p.productname, p.brand, p.showprice, p.sellprice FROM products p JOIN featured f ON p.id = f.product_id WHERE f.type = 1 ORDER BY f.id DESC LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<a style='text-decoration: none; color: inherit;' href='p.php?id=" . $row['id'] . "'><img src='admin/" . $row['photo'] . "' alt='" . $row['productname'] . "'>";
                echo "<h3>" . $row['productname'] . "</h3>";
                echo "<p>". $row['brand'] ."</p>";
                echo "<p>Price: <del>" . $row['showprice'] . "</del> " . $row['sellprice'] . "</p></a>";
                echo "<button class='add-to-cart' id='" . $row['id'] . "'>Add to Cart</button>";
                echo "</div>";
            }
        }





        ?>

    </section>

      <!-- Featured Books -->

        <h2 style="text-align: center; font-size: 2.5rem; font-weight: bold;  text-shadow: 2px 2px 2px #ccc;">Best Selling</h2>

    <section class="featured-books">
       
        
       
        
        <?php
        require_once('conn.php');



        $sql = "SELECT p.id, p.photo, p.productname, p.stock, p.brand, p.showprice, p.sellprice FROM products p JOIN featured f ON p.id = f.product_id WHERE f.type = 2 ORDER BY f.id DESC LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
$per=($row['showprice'] - $row['sellprice'])/$row['showprice']*100;
                
                echo "<a style='  text-decoration: none; color: inherit;' href='p.php?id=" . $row['id'] . "'><img  src='admin/" . $row['photo'] . "' alt='" . $row['productname'] . "'>";
                if (  $per>0 && $row['stock'] < 2) {
                    echo "<p style='font-weight: bold; margin-top: -30px; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; color: red;' id='" . $row['id'] . "'>Save " . intval($per) . "%</p>";
                }
                
                else if ($row['stock'] < 2) {
                    echo "<p style='color: red; text-align: center; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold; margin-top: -30px;'>Low Stock</p>";
                }  
                else if (  $per>0) {
                    echo "<p class='percentSave' style=' color: green; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold; margin-top: -30px;'>Save " . intval($per) . "%</p>";
                }
                                 echo "<h3>" . $row['productname'] . "</h3>";
                echo "<p>". $row['brand'] ."</p>";
                echo "<p>Price: <del>" . $row['showprice'] . "</del> " . $row['sellprice'] . "</p></a>";
                echo "<button class='add-to-cart' id='" . $row['id'] . "'>Add to Cart</button>";
                echo "</div>";
            }
        }





        ?>

    </section>
 <!-- Featured Books -->

        <h2 style="text-align: center; font-size: 2.5rem; font-weight: bold;  text-shadow: 2px 2px 2px #ccc;">Best offers</h2>

    <section class="featured-books">
       
        
       
        
        <?php
        require_once('conn.php');



        $sql = "SELECT p.id, p.photo, p.productname, p.brand, p.showprice, p.sellprice FROM products p JOIN featured f ON p.id = f.product_id WHERE f.type = 3 ORDER BY f.id DESC LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<a style='text-decoration: none; color: inherit;' href='p.php?id=" . $row['id'] . "'><img src='admin/" . $row['photo'] . "' alt='" . $row['productname'] . "'>";
                echo "<h3>" . $row['productname'] . "</h3>";
                echo "<p>". $row['brand'] ."</p>";
                echo "<p>Price: <del>" . $row['showprice'] . "</del> " . $row['sellprice'] . "</p></a>";
                echo "<button class='add-to-cart' id='" . $row['id'] . "'>Add to Cart</button>";
                echo "</div>";
            }
        }





        ?>

    </section>



 <?php
 require_once("foot.php");
 ?>