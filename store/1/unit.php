<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sql = "SELECT * FROM unit WHERE name = '$name' AND company = '" . $_SESSION['company'] . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "Unit name already exists!";
        $similarRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $sql = "INSERT INTO unit (name, company) VALUES ('$name', '" . $_SESSION['company'] . "')";
        if (mysqli_query($conn, $sql)) {
            $message = "Unit name inserted successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM unit WHERE company = '" . $_SESSION['company'] . "' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$units = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container py-5 d-flex justify-content-center">
    <div class="w-50">
        <form action="" method="post" class="mb-4">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Unit Name" required>
                <label for="name">Unit Name</label>
            </div>
                 <div class="d-flex justify-content-center">
 <button type="submit" class="btn btn-primary">Add Unit</button>
                 </div>
           
        </form>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <h3>Existing Units</h3>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody id="unit-table">
                <?php foreach ($units as $unit): ?>
                    <tr>
                        <td><?php echo $unit['id']; ?></td>
                        <td><?php echo $unit['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function () {
        var input = this.value.toLowerCase();
        var table = document.getElementById('unit-table');
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
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

