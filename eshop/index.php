 
 <?php
 require_once("head.php");
 ?>
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