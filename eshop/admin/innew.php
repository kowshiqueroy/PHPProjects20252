<?php
require_once '../conn.php';
require_once 'header.php';
?>
<?php
    
if (isset($_POST['submit'])) {
    $person = $_POST['person'];
    $date = $_POST['date'];
    $type = $_POST['type'];


    $sql = "SELECT id FROM person WHERE details = '$person'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $person_id = $row['id'];
    } else {
        $sql = "INSERT INTO person (details) VALUES ('$person')";
        if ($conn->query($sql) === TRUE) {
            $person_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $sql = "INSERT INTO indetails (person_id, purchase_date, type) VALUES ('$person_id', '$date', '$type')";
    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;
        header("Location: innew.php?id=$id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $person = $_POST['person'];
    $date = $_POST['date'];
    $type = $_POST['type'];


    $sql = "SELECT id FROM person WHERE details = '$person'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $person_id = $row['id'];
    } else {
        $sql = "INSERT INTO person (details) VALUES ('$person')";
        if ($conn->query($sql) === TRUE) {
            $person_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $sql = "UPDATE indetails SET person_id = '$person_id', purchase_date = '$date', type = '$type' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: innew.php?id=$id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}








?>
<div class="card p-1 text-center">Add New In Details</div>


<div class="row">
    <form method="POST" action="" class="d-flex flex-wrap">
        <div class="col-6 col-md-4">
            <div class="form-group mt-3">
                <label for="person">Person Name:</label>
                <select name="person" id="person" class="form-control select2" required>

                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT person_id FROM indetails WHERE id = '$id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $sql = "SELECT details FROM person WHERE id = '".$row['person_id']."'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<option selected>".$row['details']."</option>";
                        }
                    }
                }

                ?>
                

                
                    <?php
                    $sql = "SELECT id, details FROM person ORDER BY id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option >".$row['details']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-group mt-3">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="<?php 
                
                
                
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT purchase_date FROM indetails WHERE id = '$id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo date('Y-m-d', strtotime($row['purchase_date']));
                    }
                }
                else {
                    echo date('Y-m-d');
                }
                
                
                
                ?>" required>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="form-group mt-3">
                <label for="type">Type:</label>
                <select name="type" id="type" class="form-control">
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT type FROM indetails WHERE id = '$id'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            if ($row['type'] == 0) {
                                echo "<option value='0' selected>IN</option>";
                                echo "<option value='1'>Back</option>";
                            } else {
                                echo "<option value='0'>IN</option>";
                                echo "<option value='1' selected>Back</option>";
                            }
                        }
                    } else {
                        echo "<option value='0' selected>IN</option>";
                        echo "<option value='1'>Back</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6  col-md-2 text-center">
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
            <?php else: ?>
                <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
            <?php endif; ?>
        </div>
    </form>
</div>


<?php if (isset($_GET['id'])): ?>
    <hr>
    

<form id="productForm" class="mt-3 d-flex flex-wrap" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    
    <div class="col-6 col-md-3 mb-3">
        <label for="productName" class="form-label">Product Name:</label>
        <select class="form-control select2n" id="productName" name="productName" required>
            <?php
            $sql = "SELECT *FROM products ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['category'] ." ". $row['brand'] ." ". $row['maker'] ." ". $row['productname'] ." ". $row['unitname'] 
                    ." ". $row['stock'] ."</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <label for="quantity" class="form-label">Quantity:</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required oninput="calculateTotal()">
    </div>
    <div class="col-6 col-md-3 mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" required oninput="calculateTotal()">
    </div>
    <div class="col-6 col-md-3 mb-3">
        <label for="total" class="form-label">Total:</label>
        <input type="text" class="form-control" id="total" name="total" readonly>
    </div>
    <div class="col-12 d-flex justify-content-end">
        <button type="submit" name= "add" class="btn btn-primary">Add Product</button>
    </div>
</form>

<script>
    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value);
        const price = parseFloat(document.getElementById('price').value);
        if (!isNaN(quantity) && !isNaN(price)) {
            document.getElementById('total').value = (quantity * price).toFixed(2);
        }
    }
</script>

<?php if (isset($_POST['add'])): ?>
    <?php
    $id = $_POST['id'];
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $sql = "INSERT INTO inproducts (indetails_id, product_id, quantity, price) VALUES ('$id', '$productName', '$quantity', '$price')";
    if ($conn->query($sql) === TRUE) {

        $sql = "SELECT total FROM indetails WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalprice = $row['total'] ? $row['total'] : 0;
            $totalprice += $total;
            $sql = "UPDATE indetails SET total = '$totalprice' WHERE id = '$id'";
            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

    $sql = "SELECT stock FROM products WHERE id = '$productName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newStock = $row['stock'] + $quantity;
        $sqlUpdateStock = "UPDATE products SET stock = '$newStock', costprice = '$price'  WHERE id = '$productName'";
        if (!$conn->query($sqlUpdateStock)) {
            echo "Error updating stock: " . $conn->error;
        }
    }





        }
        echo "<script>window.location.href='innew.php?id=".$_POST['id']."';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    ?>
<?php endif; ?>




<?php if (isset($_GET['id'])): ?>
    <h3>Product List</h3>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_GET['id'];
            $sql = "SELECT *
                    FROM inproducts 
                    WHERE indetails_id = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                            
                            $sql2 = "SELECT * FROM products WHERE id = '".$row['product_id']."'";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    echo "<td>" . $row2['category'] ." ". $row2['brand'] ." ". $row2['maker'] ." ". $row2['productname'] ." ". $row2['unitname'] . "</td>";
                                }
                            }
                           
                           echo "<td>" . $row['quantity'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td>" . ($row['quantity'] * $row['price']) . "</td>
                         
                            <td><a href='innew.php?id=".$_GET['id']."&delete=" . $row['id'] . "'>Delete</a></td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_GET['delete'])): ?>
    <?php
    $id = $_GET['delete'];

    $sql = "SELECT product_id, quantity FROM inproducts WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productId = $row['product_id'];
        $quantity = $row['quantity'];

        // Update stock
        $sql = "UPDATE products SET stock = stock - '$quantity' WHERE id = '$productId'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href='innew.php?id=".$_GET['id']."';</script>";
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    }
    $sql = "DELETE FROM inproducts WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {


    

        echo "<script>window.location.href='innew.php?id=".$_GET['id']."';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    ?>
<?php endif; ?>

<?php
        $pm="";
        $pd="";
        $r="";
        $sql = "SELECT * FROM indetails WHERE id = '".$_GET['id']."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pm = $row["payment_method"];
            $pd = $row["payment_details"];
            $r = $row["remarks"];
       
        }
        ?>

    <div class="row">
        <form action="" method="post" class="d-flex justify-content-between">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

            <div class="col-3 mb-3 me-2">
                <label for="payment_method" class="form-label">Payment Method:</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="<?php echo $row['payment_method']; ?>"><?php echo $pm; ?></option>
                    <option value="Cash">Cash</option>
                    <option value="Debit">Debit</option>
                    <option value="MobileBanking">Mobile Banking</option>
                    <option value="Credit">Credit</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Bank">Bank</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-3 mb-3 me-2">
                <label for="payment_details" class="form-label">Payment Details:</label>
                <input type="text" class="form-control" id="payment_details" name="payment_details" value="<?php echo $pd; ?>" >
            </div>
            <div class="col-3 mb-3 me-2">
                <label for="remarks" class="form-label">Remarks:</label>
                <input type="text" class="form-control" id="remarks" name="remarks" value="<?php echo $r; ?>">
            </div>
            <div class="col-3 mb-3 text-end">
                <button type="submit" name="draft" class="btn btn-secondary me-2">Draft</button>
                <button type="submit" name="confirm" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>



<?php if (isset($_POST['draft'])): ?>
    <?php
    $payment_method = $_POST['payment_method'];
    $payment_details = $_POST['payment_details'];
    $remarks = $_POST['remarks'];
    $id = $_POST['id'];

    $sql = "UPDATE indetails SET payment_method = '$payment_method', payment_details = '$payment_details', remarks = '$remarks' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='innew.php?id=".$_GET['id']."';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    ?>



<?php endif; ?>
<?php if (isset($_POST['confirm'])): ?>
    <?php
    $payment_method = $_POST['payment_method'];
    $payment_details = $_POST['payment_details'];
    $remarks = $_POST['remarks'];
    $id = $_POST['id'];

    $sql = "UPDATE indetails SET payment_method = '$payment_method', payment_details = '$payment_details', remarks = '$remarks' ,type = 1 WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='innew.php?id=".$_GET['id']."';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    ?>



<?php endif; ?>



<?php endif; ?>


<?php
require_once 'footer.php';
?>