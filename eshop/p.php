<?php

require_once 'head.php';
?>



<?php

if (isset($_GET['submit'])) {
    // Handle form submission logic here
    $productId = $_GET['id'];
    $name = $_GET['name'];
    $address = $_GET['address'];
    $contact = $_GET['contact'];
    $star = $_GET['stars'];
    $review = $_GET['review'];
    $sql = "INSERT INTO review (product_id, name, address, contact, star, review) VALUES ('$productId', '$name', '$address', '$contact', '$star', '$review')";
    if ($conn->query($sql) === TRUE) {
       // echo "<script>window.location.href='p.php?id=".$_GET['id']."';</script>";
       
    } else {
        echo "Error submitting review: " . $conn->error;
    }
}


$id = $_GET['id'];

  $sql = "SELECT * FROM products WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>


    <style>
       

        .product-container {
            max-width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .book-item {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }

        .book-item img {
            max-width: 250px;
            height: auto;
            border-radius: 10px;
        }

        .book-info {
            flex: 1;
        }

        .book-info h2 {
            font-size: 24px;
            color: #333;
        }

        .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #d9534f;
        }

        button {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .review-section {
            margin-top: 30px;
            background: #fafafa;
            padding: 20px;
            border-radius: 10px;
        }

        .review-section form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .review-section input, .review-section select, .review-section textarea {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .reviews {
            margin-top: 20px;
        }

        .review-item {
            background: #fff;
            padding: 15px;
            border: none;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .review-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .like-dislike {
            display: flex;
            gap: 10px;
        }

        .like, .dislike {
            cursor: pointer;
            font-size: 18px;
            color: #888;
        }

        .like:hover, .dislike:hover {
            color: #007bff;
        }

        @media (max-width: 768px) {
            .book-item {
                flex-direction: column;
                align-items: center;
            }

            .book-info {
                text-align: center;
            }
        }
    </style>


    <div class="product-container">
        <div class="book-item">
            <img src="admin/<?php echo $row['photo']; ?>" alt="<?php echo $row['productname']; ?>">
            <div class="book-info">
                <h2><?php echo $row['productname']; ?></h2>
                <p>Author: <?php echo $row['brand']; ?> | Category: <?php echo $row['category']; ?> | Publisher: <?php echo $row['maker']; ?></p>
                <p class="price">Price: <del><?php echo $row['showprice']; ?></del> <?php echo $row['sellprice']; ?></p>
                        <?php
            

                            $per=($row['showprice'] - $row['sellprice'])/$row['showprice']*100;
                            
                            
                            
                             
                            if (  $per>0) {
                                echo "<p class='percentSave' style=' color: green; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold; '>Save " . intval($per) . "%</p>";
                            }
                              if ($row['stock'] < 2) {
                                echo "<p style='color: red; text-align: center; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold; '>Low Stock</p>";
                            }
                        ?>
                <hr>
                <p>Description: <?php echo $row['details']; ?></p>
                <p><?php echo $row['review']; ?></p>
                <hr>

                <button  class="add-to-cart" id="<?php echo $row['id']; ?>">Add to Cart</button>
            </div>
        </div>
        
        <div class="review-section">
            <h2>Leave a Review</h2>
            <form id="reviewForm">
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="text" name="contact" placeholder="Your Phone / Email" required>
                </div>
                <input type="text" name="address" placeholder="Your Address " required>

                <style>
                    .reviewbox {
                        display: flex;
                        
                        gap: 10px;
                    }
                @media (max-width: 768px) {
                    .reviewbox {
                        flex-direction: column;
                        align-items: center;
                    }
                    
                }


                </style>
                 
                <div  class="reviewbox" >
                   
                 <style>
                    .stars {
    display: flex;
    gap: 5px;
    flex-direction: row-reverse; /* Ensures the stars align from right to left */
}

.star {
    font-size: 2rem;
    cursor: pointer;
    color: #ccc; /* Default gray color */
    transition: color 0.3s;
}

/* Hide radio buttons */
input[type="radio"] {
    display: none;
}

/* Change star color when selected */
input[type="radio"]:checked ~ label {
    color: gold;
}

/* Highlight stars on hover */
.stars label:hover,
.stars label:hover ~ label {
    color: gold;
}
                 </style>
                 
                 
                    <div class="stars">
    <input type="radio" name="stars" value="5" id="star5">
    <label for="star5" class="star">★</label>
    <input type="radio" name="stars" value="4" id="star4">
    <label for="star4" class="star">★</label>
    <input type="radio" name="stars" value="3" id="star3">
    <label for="star3" class="star">★</label>
    <input type="radio" name="stars" value="2" id="star2">
    <label for="star2" class="star">★</label>
    <input type="radio" name="stars" value="1" id="star1">
    <label for="star1" class="star">★</label>
</div>

<script>
    document.querySelectorAll('.star').forEach((star, index, stars) => {
        if (index === 0) {
            star.click();
        }
    });

    document.querySelectorAll('.star').forEach((star, index, stars) => {
        star.addEventListener('click', function () {
            let nextSiblings = [];
            let nextSibling = this.nextElementSibling;

            while (nextSibling) {
                nextSiblings.push(nextSibling);
                nextSibling = nextSibling.nextElementSibling;
            }

            stars.forEach(s => s.style.color = '#ccc');
            this.style.color = 'gold';
            nextSiblings.forEach(s => s.style.color = 'gold');
        });
    });

</script>

<input type="text" name="review" placeholder="Write your review here..." required>
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
      <button name="submit" type="submit">Submit Review</button>
                </div>
                
          
            </form>
        </div>

        <div class="reviews">
            <h2>Reviews</h2>
            <?php
    $productId = $_GET['id'];
    $sql = "SELECT name, star, review, timestamp FROM review WHERE product_id = '$productId' AND status = 1 AND type = 0 ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="review-item">';
            echo '<div class="review-info">';
            echo '<p><strong>' . htmlspecialchars($row['name']) . '</strong> ';
            for ($i = 0; $i < $row['star']; $i++) {
                echo '★';
            }
            for ($i = $row['star']; $i < 5; $i++) {
                echo '☆';
            }
            echo '</p>';
            echo '<span class="timestamp">' . date('F j, Y | H:i', strtotime($row['timestamp'])) . '</span>';
            echo '</div>';
            echo '<p>"' . htmlspecialchars($row['review']) . '"</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No reviews yet.</p>';
    }
?>


        </div>
    </div>

  



<?php
    




            }

        }
        else {
        }
?>




<?php
require_once 'foot.php';
?>