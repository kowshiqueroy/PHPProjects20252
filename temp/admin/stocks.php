<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Stocks</div>


<form action="" method="get" class="d-flex flex-wrap">
    <div class="col-6 col-md-2 mb-3">
        <label for="id" class="form-label">ID:</label>
        <input type="text" class="form-control" name="id" id="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label for="productname" class="form-label">Product Name:</label>
        <input type="text" class="form-control" name="productname" id="productname" value="<?php echo isset($_GET['productname']) ? $_GET['productname'] : ''; ?>">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label for="category" class="form-label">Category:</label>
        <input type="text" class="form-control" name="category" id="category" value="<?php echo isset($_GET['category']) ? $_GET['category'] : ''; ?>">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label for="brand" class="form-label">Brand:</label>
        <input type="text" class="form-control" name="brand" id="brand" value="<?php echo isset($_GET['brand']) ? $_GET['brand'] : ''; ?>">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label for="maker" class="form-label">Maker:</label>
        <input type="text" class="form-control" name="maker" id="maker" value="<?php echo isset($_GET['maker']) ? $_GET['maker'] : ''; ?>">
    </div>
    <div class="col-6 col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="stocks.php" class="ms-2 btn btn-secondary">All</a>
    </div>
</form>


<table class="table table-striped mt-3 table-responsive">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Maker</th>
            <th>Unit Name</th>
            <th>Stock</th>
            <th>Details</th>
            <th>Review</th>
            <th>Cost Price</th>
            <th>Show Price</th>
            <th>Sell Price</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $where = '';
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $where .= " id = '" . $_GET['id'] . "' AND";
            }
            if (isset($_GET['productname']) && !empty($_GET['productname'])) {
                $where .= " productname LIKE '%" . $_GET['productname'] . "%' AND";
            }
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $where .= " category LIKE '%" . $_GET['category'] . "%' AND";
            }
            if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                $where .= " brand LIKE '%" . $_GET['brand'] . "%' AND";
            }
            if (isset($_GET['maker']) && !empty($_GET['maker'])) {
                $where .= " maker LIKE '%" . $_GET['maker'] . "%' AND";
            }
            $where = rtrim($where, ' AND');
            $sql = "SELECT id, productname, category, brand, maker, unitname, stock, details, review, costprice, showprice, sellprice, photo FROM products WHERE status = 1"; 
            if ($where) {
                $sql .= " " . $where;
            }
            $sql .= " ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['productname'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['brand'] . "</td>";
                    echo "<td>" . $row['maker'] . "</td>";
                    echo "<td>" . $row['unitname'] . "</td>";
                    echo "<td>" . $row['stock'] . "</td>";
                    echo "<td>" . $row['details'] . "</td>";
                    echo "<td>" . $row['review'] . "</td>";
                    echo "<td>" . $row['costprice'] . "</td>";
                    echo "<td>" . $row['showprice'] . "</td>";
                    echo "<td>" . $row['sellprice'] . "</td>";
                    echo "<td><img src='" . $row['photo'] . "' width='100'></td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>





<?php
require_once 'footer.php';
?>