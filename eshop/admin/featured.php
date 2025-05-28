<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Featured</div>

<style>
    th, td {
        padding: 5px;
    }
</style>
<div class="mt-3">
    <form class="d-flex flex-wrap" method="POST">
        <div class="col-md-3 mb-3">
            <label for="product" class="form-label">Product ID:</label>
            <select class="form-control select2n" id="product" name="product" required>
                <?php
                $sql = "SELECT id, productname FROM products ORDER BY id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['productname'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="type" class="form-label">Type:</label>
            <select class="form-control" id="type" name="type" required>
                <option value="1">Featured 1</option>
                <option value="2">Best Selling 2</option>
                <option value="3">Best Offers 3</option>
            </select>
        </div>
        <div class="col-md-3 mt-auto">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<hr>

<table class="table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT f.id, f.product_id, f.type, p.productname FROM featured f JOIN products p ON f.product_id = p.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row['product_id'] . "</td>
                        <td>" . $row['productname'] . "</td>
                        <td>" . $row['type'] . "</td>
                        <td><a href='featured.php?del=" . $row['id'] . "'>Delete</a></td>
                    </tr>";
                }
            }
        ?>
    </tbody>
</table>

<?php
if (isset($_POST['product'])) {
    $productId = $_POST['product'];
    $type = $_POST['type'];
    $sql = "SELECT * FROM featured WHERE product_id = '$productId' AND type = '$type'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO featured (product_id, type) VALUES ('$productId', '$type')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href='featured.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "DELETE FROM featured WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='featured.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<?php
require_once 'footer.php';
?>