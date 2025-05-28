<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Reviews</div>

<table class="table mt-3">
    <thead class="table-dark">
        <tr><th>ID</th><th>Product ID</th><th>Name</th><th>Address</th><th>Contact</th><th>Star</th><th>Review</th><th>Status</th></tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM review ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {



                    echo "<tr>
                    <td><a href='../p.php?id=" . $row['product_id'] . "'>" . $row['id'] . "</a></td>
                    
                    
                    
                    <td>";
                    
                    
                    
                    $sql2 = "SELECT productname FROM products WHERE id = " . $row['product_id'];
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                $row2 = $result2->fetch_assoc();
                                echo $row2['productname'];
                            }
                    
                    
                    
                    
                    echo "</td><td>" . $row['name'] .
                     "</td><td>" . $row['address'] . "</td><td>" . $row['contact'] .
                      "</td><td>" . $row['star'] . "</td><td>" . $row['review'] ." @".$row['timestamp']. "</td><td>
                      <a href='reviews.php?toggle=" . $row['id'] . "'>" . ($row['status'] == 1 ? 'Showing' : 'Hidden') . "</a></td></tr>";
                }
            }
        ?>
    </tbody>
</table>

<?php
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $sql = "UPDATE review SET status = IF(status = 1, 0, 1) WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='reviews.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>
<?php
require_once 'footer.php';
?>