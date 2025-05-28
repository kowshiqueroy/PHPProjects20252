 
 <?php
 require_once("head.php");
 ?>
    <style>
        .search-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #f9f9f9;
        }
        .search-form div {
            flex: 1 1 200px;
        }
        .search-form label {
            display: block;
            margin-bottom: 5px;
        }
        .search-form select, 
        .search-form input, 
        .search-form button, 
        .search-form a {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            outline: none;
        }
        .search-form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            align-self: flex-end;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }
            .search-form div {
                flex: 1 1 auto;
            }
        }
    </style>

    <form action="" method="get" class="search-form">
        <div>
       
            <select name="option" id="option">
                <option value="name" <?php echo isset($_GET['option']) && $_GET['option'] == 'name' ? 'selected' : ''; ?>>Book Name</option>
                <option value="author" <?php echo isset($_GET['option']) && $_GET['option'] == 'author' ? 'selected' : ''; ?>>Author</option>
                <option value="publisher" <?php echo isset($_GET['option']) && $_GET['option'] == 'publisher' ? 'selected' : ''; ?>>Publisher</option>
            </select>
        </div>
        <div>
           
            <input type="text" name="keyword" id="keyword" placeholder="All" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Search</button>
           
        </div>
    </form>

    <script>
        document.getElementById('option').addEventListener('change', function() {
            // Add JavaScript behavior for option change if needed
            console.log('Option changed:', this.value);
        });
    </script>
     <!-- Featured Books -->
    <section class="featured-books">
       
        
      
       
        <?php
        require_once('conn.php');
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";


        if (isset($_GET['option']) && isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            switch ($_GET['option']) {
                case 'name':
                    $sql = "SELECT * FROM products WHERE productname LIKE '%" . $_GET['keyword'] . "%' ORDER BY id DESC";
                    break;
                case 'author':
                    $sql = "SELECT p.* FROM products p JOIN brands b ON p.brand = b.name WHERE b.name LIKE '%" . $_GET['keyword'] . "%' ORDER BY p.id DESC";
                    break;
                case 'publisher':
                    $sql = "SELECT p.* FROM products p JOIN makers m ON p.maker = m.name WHERE m.name LIKE '%" . $_GET['keyword'] . "%' ORDER BY p.id DESC";
                    break;
            }

            


             }

             else  if (isset($_GET['option'])){
  $sql = "SELECT * FROM products ORDER BY id DESC";
}
              
       
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book' style='align-items: center;'>";

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



 <?php
 require_once("foot.php");
 ?>