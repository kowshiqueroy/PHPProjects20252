<?php
require_once '../conn.php';
require_once 'header.php';
?>
<div class="card p-1 text-center">New Order</div>

<?php

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $route_id = $_POST['route_id'];
    $person_id = $_POST['person_id'];
    $order_date = $_POST['order_date'];
    $delivery_date = $_POST['delivery_date'];
    $remarks = $_POST['remarks'];
    $serial = $_POST['serial'];



if (!is_numeric($route_id)) {
    $sql = "SELECT id FROM routes WHERE route_name = '$route_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $route_id = $row['id'];
    } else {
        $sql = "INSERT INTO routes (route_name) VALUES ('$route_id')";
        if ($conn->query($sql) === TRUE) {
            $route_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (!is_numeric($person_id)) {
    $sql = "SELECT id FROM persons WHERE person_name = '$person_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $person_id = $row['id'];
    } else {
        $sql = "INSERT INTO persons (person_name) VALUES ('$person_id')";
        if ($conn->query($sql) === TRUE) {
            $person_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}



    $sql = "UPDATE orders SET route_id='$route_id', person_id='$person_id', order_date='$order_date', delivery_date='$delivery_date', remarks='$remarks', serial='$serial' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<div style="text-align: center;">Order updated successfully</div>';
       echo '<script>window.location.href="create.php?id='.$id.'"</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



if (isset($_POST['create'])) {
    $route_id = $_POST['route_id'];
    $person_id = $_POST['person_id'];
    $order_date = $_POST['order_date'];
    $delivery_date = $_POST['delivery_date'];
    $remarks = $_POST['remarks'];
    $serial = $_POST['serial'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

if (!is_numeric($route_id)) {
    $sql = "SELECT id FROM routes WHERE route_name = '$route_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $route_id = $row['id'];
    } else {
        $sql = "INSERT INTO routes (route_name) VALUES ('$route_id')";
        if ($conn->query($sql) === TRUE) {
            $route_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (!is_numeric($person_id)) {
    $sql = "SELECT id FROM persons WHERE person_name = '$person_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $person_id = $row['id'];
    } else {
        $sql = "INSERT INTO persons (person_name) VALUES ('$person_id')";
        if ($conn->query($sql) === TRUE) {
            $person_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


    $created_by = $_SESSION['id'];
    $sql = "INSERT INTO orders (route_id, person_id, order_date, delivery_date, remarks, serial, created_by, latitude, longitude) VALUES ('$route_id', '$person_id', '$order_date', '$delivery_date', '$remarks', '$serial', '$created_by', '$latitude', '$longitude')";
  
  
  
    if ($conn->query($sql) === TRUE) {
        echo '<div style="text-align: center;">New order created successfully</div>';
        $id = $conn->insert_id;
        echo '<script>window.location.href="create.php?id='.$id.'"</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
        $id='';
        $route_id = '';
        $person_id = '';
        $order_date = '';
        $delivery_date = '';
        $remarks = '';
        $serial = '';
        $draft = '';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM orders WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id= $row["id"];
        $route_id = $row['route_id'];
        $person_id = $row['person_id'];
        $order_date = $row['order_date'];
        $delivery_date = $row['delivery_date'];
        $remarks = $row['remarks'];
        $serial = $row['serial'];
        $draft = $row['draft'];
    }
    else {
        $draft = 0;
        echo '<script>alert("Order not found");</script>';
    }
}

if($draft==0) {
    echo '<div style="text-align: center;">This order has been finalized. You can not edit this.</div>';
    exit;
}

?>

<form  method="post">
    <div class="row">
        <div class="col-md-6">
            <label for="route_id">Route</label>
            <select class="form-control select2edit" id="route_id" name="route_id">
                <?php
                     if(!empty($route_id)){
                    $sql2 = "SELECT route_name FROM routes WHERE id = '$route_id'";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        echo "<option value='$route_id' selected>".$row2['route_name']."</option>";
                    }
                }
                ?>
               
                
                <?php
                $sql = "SELECT * FROM routes order by route_name";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['route_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="person_id">Person</label>
            <select class="form-control select2edit" id="person_id" name="person_id">


                <?php
                     if(!empty($person_id)){
                    $sql2 = "SELECT person_name FROM persons WHERE id = '$person_id'";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        echo "<option value='$person_id' selected>".$row2['person_name']."</option>";
                    }
                }
                ?>

                <?php
                $sql = "SELECT * FROM persons";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['person_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label for="order_date">Order Date</label>
            <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo !empty($order_date) ? $order_date : date('Y-m-d'); ?>">
        </div>
        <div class="col-md-6">
            <label for="delivery_date">Delivery Date</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="<?php echo !empty($delivery_date) ? $delivery_date : date('Y-m-d', strtotime('+1 days')); ?>">
        </div>
        <div class="col-md-6">
            <label for="remarks">Remarks</label>
            <input  type="text" class="form-control" id="remarks" name="remarks" value="<?php echo !empty($remarks) ? $remarks : ''; ?>" ></input>
        </div>

        <div class="col-md-6">
            <label for="serial">Serial</label>
            <input type="number" class="form-control" id="serial" name="serial" value="<?php echo !empty($serial) ? $serial : ''; ?>" >
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <?php if (isset($_REQUEST['id'])) { ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" name="update" value="<?php echo $_REQUEST['id']; ?>" class="btn btn-primary">Update</button>
            <?php } else { ?>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                });
            }
        </script>
                <button type="submit" name="create" value="1" class="btn btn-primary">Create</button>
            <?php } ?>
        </div>
    </div>
</form>

<hr>

    <?php if (isset($_REQUEST['id'])) { ?>


      
            <?php if (isset($_POST['add_product'])) { ?>
                <?php
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $total = $quantity * $price;
                                                if (!is_numeric($product_id)) {
                                                    $sql = "SELECT id FROM products WHERE product_name = '$product_id'";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $product_id = $row['id'];
                                                    } else {
                                                        $sql = "INSERT INTO products (product_name) VALUES ('$product_id')";
                                                        if ($conn->query($sql) === TRUE) {
                                                            $product_id = $conn->insert_id;
                                                        } else {
                                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                                        }
                                                    }
                                                }

                $sql = "INSERT INTO order_product (order_id, product_id, quantity, price, total) VALUES ('$id', '$product_id', '$quantity', '$price', '$total')";
                if ($conn->query($sql) === TRUE) {
                    echo '<div style="text-align: center; color:green;">Product added successfully</div>';
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                ?>
            <?php } ?>
   
    <form action="create.php?id=<?php echo $_REQUEST['id']; ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <label for="product_id">Product</label>
                <select class="form-control select2edit" id="product_id" name="product_id" data-placeholder="Select product">
                    <?php
                    $sql2 = "SELECT * FROM products";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            echo "<option value='" . $row2['id'] . "'>" . $row2['product_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="quantity">Quantity</label>
                <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="col-md-6">
                <label for="total">Total</label>
                <input type="number" step="0.01" class="form-control" id="total" name="total" readonly>
            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <button type="submit" name="add_product" value="<?php echo $_REQUEST['id']; ?>" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#product_id, #quantity, #price').on('keyup', function() {
                var product_id = $('#product_id').val();
                var quantity = $('#quantity').val();
                var price = $('#price').val();
                $('#total').val((quantity * price).toFixed(2));
            });
        });
    </script>



<hr>


    <table class="table table-bordered">
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
            $sql = "SELECT op.id, op.product_id, op.quantity, op.price, op.total, p.product_name FROM order_product op JOIN products p ON op.product_id = p.id WHERE op.order_id = " . $_REQUEST['id'];
            $result = $conn->query($sql);
            $grandQuantity = 0;
            $grandTotal = 0;
            $productCount = $result->num_rows;
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['product_name'] . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td>' . $row['price'] . '</td>
                        <td>' . $row['total'] . '</td>
                        <td><form action="" method="post"><input type="hidden" name="delete_id" value="' . $row['id'] . '"><input type="hidden" name="id" value="' . $_REQUEST['id'] . '"><button type="submit" name="delete_product" value="' . $_REQUEST['id'] . '" class="btn btn-danger">Delete</button></form></td>
                      </tr>';
                $grandQuantity += $row['quantity'];
                $grandTotal += $row['total'];
            }
            echo '<tr>
                    <td colspan="2" class="text-right"><strong>' . $productCount . ' Product(s):</strong></td>
                    <td colspan="3">' . $grandQuantity . ' Quantity</td>
                  </tr>';
            echo '<tr>
                    <td colspan="2" class="text-right"><strong>Grand Total:</strong></td>
                    <td colspan="3"><strong>' . $grandTotal . '</strong>/=</td>
                  </tr>';
            ?>
        </tbody>
        <?php
        if (isset($_POST['delete_product'])) {
            $id = $_POST['delete_id'];
            $sql = "DELETE FROM order_product WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success">Deleted successfully</div>';
                echo '<script>window.location.href="create.php?id=' . $_REQUEST['id'] . '"</script>';
                exit;
            } else {
                echo '<div class="alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }
        }
        ?>
    </table>


    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <?php if (isset($_REQUEST['id'])) { ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
                    <button type="submit" name="update_draft" value="1" class="btn btn-primary">Draft</button>
                    <button type="submit" name="update_draft" value="0" class="btn btn-primary">End</button>
                </form>
            <?php } ?>
        </div>
    </div>

    <?php
    if (isset($_POST['update_draft'])) {
        $id = $_POST['id'];
        $draft = $_POST['update_draft'];
        $sql = "UPDATE orders SET draft='$draft' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Draft updated successfully</div>';
            echo '<script>window.location.href="orders.php"</script>';
            exit;
        } else {
            echo '<div class="alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
    ?>









    <?php } ?>


<?php
require_once 'footer.php';
?>