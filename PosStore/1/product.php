<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $unit = $_POST['unit'];
    $sql = "SELECT * FROM product WHERE name = '$name' AND type = (SELECT id FROM type WHERE name = '$type' AND company = '" . $_SESSION['company'] . "')  AND company = '" . $_SESSION['company'] . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "Product name already exists!";
        $similarRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $sql = "INSERT INTO product (name, type, unit, company) VALUES ('$name', (SELECT id FROM type WHERE name = '$type' AND company = '" . $_SESSION['company'] . "'), (SELECT id FROM unit WHERE name = '$unit' AND company = '" . $_SESSION['company'] . "'), '" . $_SESSION['company'] . "')";
        if (mysqli_query($conn, $sql)) {
            $message = "Product name inserted successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM type WHERE company = '" . $_SESSION['company'] . "' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$types = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM unit WHERE company = '" . $_SESSION['company'] . "' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$units = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT p.id, t.name AS type, u.name AS unit, p.name FROM product p 
        JOIN type t ON p.type = t.id 
        JOIN unit u ON p.unit = u.id 
        WHERE p.company = '" . $_SESSION['company'] . "' ORDER BY p.id DESC";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container py-5 d-flex justify-content-center">
    <div class="w-50">
        <form action="" method="post" class="mb-4">
            <div class="row mb-3">
                <div class="col-sm-auto">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select select2n" id="type" name="type" required>
                        <option value="">Select a type</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo $type['name']; ?>"><?php echo $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-auto">
                    <label for="unit" class="form-label">Unit</label>
                    <select class="form-select select2n" id="unit" name="unit" required>
                        <option value="">unit</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit['name']; ?>"><?php echo $unit['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <h3>Existing Products</h3>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Unit</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody id="product-table">
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['type']; ?></td>
                        <td><?php echo $product['unit']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function () {
        var input = this.value.toLowerCase();
        var table = document.getElementById('product-table');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var name = row.getElementsByTagName('td')[3].textContent.toLowerCase();
            if (name.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
</script>

<?php
include 'footer.php';
?>

