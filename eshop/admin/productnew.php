<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">New Product</div>

<style>
    th, td {
        padding: 5px;
    }
</style>
<?php
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<form action="" method="post">
    <div class="row mb-3">
        <div class="col">
            <label for="category" class="form-label">Category:</label>
            <select class="form-control select2edit" name="category" id="category" required>
               
                <?php
                $sql2 = "SELECT id, name FROM categories ORDER BY id DESC";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $selected = (isset($row) && $row['category'] == $row2['name']) ? "selected" : "";
                        echo "<option value='" . $row2['name'] . "' $selected>" . $row2['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label for="brand" class="form-label">Brand:</label>
            <select class="form-control select2edit" name="brand" id="brand" required>
             
                <?php
                $sql2 = "SELECT id, name FROM brands ORDER BY id DESC";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $selected = (isset($row) && $row['brand'] == $row2['name']) ? "selected" : "";
                        echo "<option value='" . $row2['name'] . "' $selected>" . $row2['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label for="maker" class="form-label">Maker:</label>
            <select class="form-control select2edit" name="maker" id="maker" required>
                
                <?php
                $sql2 = "SELECT id, name FROM makers ORDER BY id DESC";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $selected = (isset($row) && $row['maker'] == $row2['name']) ? "selected" : "";
                        echo "<option value='" . $row2['name'] . "' $selected>" . $row2['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label for="unitname" class="form-label">Unit Name:</label>
            <select class="form-control select2edit" name="unitname" id="unitname" required>
                
                <?php
                $sql2 = "SELECT id, name FROM unitnames ORDER BY id DESC";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $selected = (isset($row) && $row['unitname'] == $row2['name']) ? "selected" : "";
                        echo "<option value='" . $row2['name'] . "' $selected>" . $row2['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="productname" class="form-label">Name:</label>
            <input class="form-control" type="text" name="productname" id="productname" value="<?php echo isset($row) ? $row['productname'] : ''; ?>" required>
        </div>
        <div class="col">
            <label for="photo" class="form-label">Photo:</label>
            <div class="input-group">
                <select class="form-select" id="photo" name="photo" required onchange="document.getElementById('preview').src = this.value">
                    <?php
                    $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $selected = (isset($row) && $row['photo'] == $row2['link']) ? "selected" : "";
                            echo "<option value='" . $row2['link'] . "' $selected>" . $row2['id'] . " - " . $row2['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <div class="input-group-append">
                    <img height="50px" style="height: 50px; box-sizing: border-box;" src="<?php echo isset($row) ? $row['photo'] : ''; ?>" alt="Preview" id="preview" style="border: 1px solid #ccc; padding: 4px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="costprice" class="form-label">Cost Price:</label>
            <input class="form-control" type="number" name="costprice" id="costprice" value="<?php echo isset($row) ? $row['costprice'] : ''; ?>" required>
        </div>
        <div class="col">
            <label for="showprice" class="form-label">Show Price:</label>
            <input class="form-control" type="number" name="showprice" id="showprice" value="<?php echo isset($row) ? $row['showprice'] : ''; ?>" required>
        </div>
        <div class="col">
            <label for="sellprice" class="form-label">Sell Price:</label>
            <input class="form-control" type="number" name="sellprice" id="sellprice" value="<?php echo isset($row) ? $row['sellprice'] : ''; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="details" class="form-label">Details:</label>
            <textarea class="form-control" name="details" id="details" required><?php echo isset($row) ? $row['details'] : ''; ?></textarea>
        </div>
        <div class="col">
            <label for="review" class="form-label">Review:</label>
            <textarea class="form-control" name="review" id="review" required><?php echo isset($row) ? $row['review'] : ''; ?></textarea>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var image = document.getElementById('preview');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <div style="display: flex; justify-content: center;">
        <?php if (isset($_GET['id'])) { ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
        <?php } else { ?>
            <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
        <?php } ?>
    </div>
</form>
<?php
if (isset($_POST['submit'])) {
    $productname = $_POST['productname'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $maker = $_POST['maker'];
    $unitname = $_POST['unitname'];
    
    $details = $_POST['details'];
    $review = $_POST['review'];
    $costprice = $_POST['costprice'];
    $showprice = $_POST['showprice'];
    $sellprice = $_POST['sellprice'];
    $photo = $_POST['photo'];
    $sql = "SELECT id FROM categories WHERE name = '$category'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO categories (name) VALUES ('$category')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM brands WHERE name = '$brand'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO brands (name) VALUES ('$brand')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM makers WHERE name = '$maker'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO makers (name) VALUES ('$maker')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM unitnames WHERE name = '$unitname'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO unitnames (name) VALUES ('$unitname')";
        $conn->query($sql);
    }



    $sql = "SELECT id FROM products WHERE productname = '$productname' AND brand = '$brand' AND maker = '$maker'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO products (productname, category, brand, maker, unitname, details, review, costprice, showprice, sellprice, photo) VALUES ('$productname', '$category', '$brand', '$maker', '$unitname', '$details', '$review', '$costprice', '$showprice', '$sellprice', '$photo')";
        if ($conn->query($sql) === TRUE) {

            echo "New record created successfully";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Product already exists";
    }

    

}
if (isset($_POST['update'])) {

    $productname = $_POST['productname'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $maker = $_POST['maker'];
    $unitname = $_POST['unitname'];
    
    $details = $_POST['details'];
    $review = $_POST['review'];
    $costprice = $_POST['costprice'];
    $showprice = $_POST['showprice'];
    $sellprice = $_POST['sellprice'];
    $photo = $_POST['photo'];
    $id = $_POST['id'];


    $sql = "SELECT id FROM categories WHERE name = '$category'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO categories (name) VALUES ('$category')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM brands WHERE name = '$brand'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO brands (name) VALUES ('$brand')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM makers WHERE name = '$maker'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO makers (name) VALUES ('$maker')";
        $conn->query($sql);
    }
    $sql = "SELECT id FROM unitnames WHERE name = '$unitname'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO unitnames (name) VALUES ('$unitname')";
        $conn->query($sql);
    }


    $sql = "UPDATE products SET productname = '$productname', category = '$category', brand = '$brand', maker = '$maker', unitname = '$unitname', details = '$details', review = '$review', costprice = '$costprice', showprice = '$showprice', sellprice = '$sellprice', photo = '$photo' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    
}
?>
<table class="table table-striped mt-3">
    <thead class="table-dark">
        <tr><th>ID</th><th>Name</th><th>Category</th><th>Brand</th><th>Maker</th><th>Unit Name</th><th>Stock</th><th>Details</th><th>Review</th><th>Cost Price</th><th>Show Price</th><th>Sell Price</th><th>Photo</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT id, productname, category, brand, maker, unitname, stock, details, review, costprice, showprice, sellprice, photo FROM products ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['productname'] . "</td><td>" . $row['category'] . "</td><td>" . $row['brand'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['unitname'] . "</td><td>" . $row['stock'] . "</td><td>" . $row['details'] . "</td><td>" . $row['review'] . "</td><td>" . $row['costprice'] . "</td><td>" . $row['showprice'] . "</td><td>" . $row['sellprice'] . "</td><td><img width='100' src='" . $row['photo'] . "'></td><td><a href='productnew.php?id=" . $row['id'] . "'>Edit</a></td></tr>";
                }
            }
        ?>
    </tbody>
</table>
<?php
require_once 'footer.php';
?>