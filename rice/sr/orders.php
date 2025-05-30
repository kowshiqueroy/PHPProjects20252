<?php
require_once '../conn.php';
require_once 'header.php';
?>


<div class="card p-1 text-center">Orders</div>
<hr>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary" onclick="window.location.href='create.php'">Create New Order</button>
</div>

<hr>
<form class="no-print" method="post" action="">
    <div class="row">

        <div class="col-md-1 col-4">
            <label for="draft_status">Edit</label>
            <select class="form-control select2" id="draft_status" name="draft_status">
                <option value="">All</option>
                <option value="0" <?php echo (isset($_POST['draft_status']) && $_POST['draft_status'] == '0') ? 'selected' : ''; ?>>End</option>
                <option value="1" <?php echo (isset($_POST['draft_status']) && $_POST['draft_status'] == '1') ? 'selected' : ''; ?>>Draft</option>
            </select>
        </div>
        <div class="col-md-1 col-4">
            <label for="approval">Approval</label>
            <select class="form-control select2" id="approval" name="approval">
                <option value="">All</option>
                <option value="1" <?php echo (isset($_POST['approval']) && $_POST['approval'] == '1') ? 'selected' : ''; ?>>Approved</option>
                <option value="0" <?php echo (isset($_POST['approval']) && $_POST['approval'] == '0') ? 'selected' : ''; ?>>Pending</option>
            </select>
        </div>
        <div class="col-md-1 col-4">
            <label for="delivery_status">Delivery</label>
            <select class="form-control select2" id="delivery_status" name="delivery_status">
                <option value="">All</option>
                <option value="1" <?php echo (isset($_POST['delivery_status']) && $_POST['delivery_status'] == '1') ? 'selected' : ''; ?>>Delivered</option>
                <option value="0" <?php echo (isset($_POST['delivery_status']) && $_POST['delivery_status'] == '0') ? 'selected' : ''; ?>>Not Delivered</option>
            </select>
        </div>

        <div class="col-md-1 col-4">
            <label for="back_status">Back</label>
            <select class="form-control select2" id="back_status" name="back_status">
                <option value="">All</option>
                <option value="1" <?php echo (isset($_POST['back_status']) && $_POST['back_status'] == '1') ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?php echo (isset($_POST['back_status']) && $_POST['back_status'] == '0') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>

        <div class="col-md-1 col-4">
            <label for="close_status">Close</label>
            <select class="form-control select2" id="close_status" name="close_status">
                <option value="">All</option>
                <option value="1" <?php echo (isset($_POST['close_status']) && $_POST['close_status'] == '1') ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?php echo (isset($_POST['close_status']) && $_POST['close_status'] == '0') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="col-md-1 col-4">
            <label for="created_by">Created By</label>
            <select class="form-control select2" id="created_by" name="created_by">
                <?php
                     if($_SESSION['role'] == '2'){

                        echo '<option selected value="'.$_SESSION['id'].'">'.$_SESSION['username'].'</option>';
                     }else{

                        ?>
                          <option value="">All</option>
                <?php
                $sql = "SELECT id, username FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = isset($_POST['created_by']) && $_POST['created_by'] == $row['id'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['username'] . "</option>";
                    }
                }
                ?>
                        <?php
                     }
                ?>
              
               
            </select>
        </div>
        <div class="col-md-3">
            <label for="route_name">Route Name</label>
            <select class="form-control select2" id="route_name" name="route_name">
                <option value="">All</option>
                <?php
                $sql = "SELECT * FROM routes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = isset($_POST['route_name']) && $_POST['route_name'] == $row['id'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['route_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="person_name">Person Name</label>
            <select class="form-control select2" id="person_name" name="person_name">
                <option value="">All</option>
                <?php
                $sql = "SELECT * FROM persons";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = isset($_POST['person_name']) && $_POST['person_name'] == $row['id'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['person_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

       
       
        
    </div>
    <div class="row mt-3">
         <?php if (isset($_POST['search'])): ?>
    <div class="col-md-2 col-6">
        <label for="order_from_date">Order From</label>
        <input type="date" class="form-control" id="order_from_date" name="order_from_date" value="<?php echo htmlspecialchars(isset($_POST['order_from_date']) ? $_POST['order_from_date'] : date('m-d-Y')); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="order_to_date">Order To</label>
        <input type="date" class="form-control" id="order_to_date" name="order_to_date" value="<?php echo htmlspecialchars(isset($_POST['order_to_date']) ? $_POST['order_to_date'] : date('m-d-Y')); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_from_date">Delivery From</label>
        <input type="date" class="form-control" id="delivery_from_date" name="delivery_from_date" value="<?php echo htmlspecialchars($_POST['delivery_from_date']); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_to_date">Delivery To</label>
        <input type="date" class="form-control" id="delivery_to_date" name="delivery_to_date" value="<?php echo htmlspecialchars($_POST['delivery_to_date']); ?>">
    </div>
<?php else: ?>
    <div class="col-md-2 col-6">
        <label for="order_from_date">Order From</label>
        <input type="date" class="form-control" id="order_from_date" name="order_from_date" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="order_to_date">Order To</label>
        <input type="date" class="form-control" id="order_to_date" name="order_to_date" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_from_date">Delivery From</label>
        <input type="date" class="form-control" id="delivery_from_date" name="delivery_from_date">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_to_date">Delivery To</label>
        <input type="date" class="form-control" id="delivery_to_date" name="delivery_to_date">
    </div>
<?php endif; ?>
<div class="col-md-2 col-6 mt-4">
    <button type="submit" class="btn btn-primary" name="search">Search</button>
</div>
<div class="col-md-2 col-6 mt-4">
    <button type="button" class="btn btn-success" onclick="window.location.href='orders.php'">Refresh</button>
</div>
       
         
       
    </div>

</form>

<hr>


<hr>
<div >
    <table class="table table-striped table-bordered">

    
        <style>
            /* #table_head th{
                white-space: nowrap;
                transform: rotate(-45deg);
                transform-origin: 20px 20px;
                text-align: left;
              
            } */
        </style>
        <thead>
            <tr id="table_head" style="text-align: center; height: 100px;">
                <th >ID</th>
                <th>Draft</th>
                <th>Route</th>
                <th>Person</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Serial</th>
                <th>Approval</th>
                <th>Delivery</th>
                <th>Back</th>
                <th>Close</th>
                <th>Created By</th>
                <th>Approved By</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody id="table_data">
            <?php
              $productNamesall = array();
              $productQuantitiesall = array();
              $grandAmount=0.00;
              $idall= "";
            
                    $sql = "SELECT orders.*, persons.person_name, routes.route_name
                    FROM orders 
                    LEFT JOIN persons ON orders.person_id = persons.id 
                    LEFT JOIN routes ON orders.route_id = routes.id 
                     ";

                    $where = "WHERE 1=1";

                if (isset($_POST['search'])) {
                $draft_status = $_POST['draft_status'];
                $approval = $_POST['approval'];
                $delivery_status = $_POST['delivery_status'];
                $back_status = $_POST['back_status'];
                $close_status = $_POST['close_status'];
                $created_by = $_POST['created_by'];
                $route_name = $_POST['route_name'];
                $person_name = $_POST['person_name'];
                $order_from_date = $_POST['order_from_date'];
                $order_to_date = $_POST['order_to_date'];
                $delivery_from_date = $_POST['delivery_from_date'];
                $delivery_to_date = $_POST['delivery_to_date'];

                if ($draft_status !== '') {
                    $where .= " AND draft = '$draft_status'";
                }
                if ($approval !== '') {
                    $where .= " AND approval = '$approval'";
                }
                if ($delivery_status !== '') {
                    $where .= " AND delivery = '$delivery_status'";
                }
                if ($back_status !== '') {
                    $where .= " AND back = '$back_status'";
                }
                if ($close_status !== '') {
                    $where .= " AND close = '$close_status'";
                }
                if ($created_by !== '') {

                    if($_SESSION['role'] == '2'){
                        $where .= " AND orders.created_by = '".$_SESSION['id']."'";
                         }
                         else {
                         $where .= " AND created_by = '$created_by'";
                        }

                }
                if ($route_name !== '') {
                    $where .= " AND route_id = '$route_name'";
                }
                if ($person_name !== '') {
                    $where .= " AND person_id = '$person_name'";
                }
                if ($order_from_date !== '') {
                    $where .= " AND order_date >= '$order_from_date'";
                } else {
                    $where .= " AND order_date >= '" . date('Y-m-d') . "'";
                }
                if ($order_to_date !== '') {
                    $where .= " AND order_date <= '$order_to_date'";
                } else {
                    $where .= " AND order_date <= '" . date('Y-m-d') . "'";
                }
                if ($delivery_from_date !== '') {
                    $where .= " AND delivery_date >= '$delivery_from_date'";
                }
                if ($delivery_to_date !== '') {
                    $where .= " AND delivery_date <= '$delivery_to_date'";
                }

                 $sql .= " $where ";
            }
            else {
                 $where .= " AND orders.order_date >= CURDATE() AND orders.order_date <= CURDATE()";
                  if($_SESSION['role'] == '2'){
                        $where .= " AND orders.created_by = '".$_SESSION['id']."'";
                         }

                $sql .= " $where ";
            }

            

            $sql .= "ORDER BY orders.serial ";

           

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php
                        
                        
                        echo $row['id'];
                        
                        
                        
                        if(empty($idall)){
                            $idall .= $row['id'];
                        } else {
                            $idall .= ",".$row['id'];
                        }
                        
                        
                        
                        
                        ?></td>
                        <td>

                            <?php 
                            if ($row['draft'] != '0') {
                            echo "<a href='create.php?id=" . $row['id'] . "'>Edit</a>";
                            }
                            else {
                                 echo 'No';
                            }
                             ?>

                        </td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['person_name']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td><?php echo $row['delivery_date']; ?></td>
                        <td><?php echo $row['serial']; ?></td>
                        <td><?php echo $row['approval'] ? 'Approved' : 'Pending'; ?></td>
                        <td><?php echo $row['delivery'] ? 'Delivered' : 'Not Delivered'; ?></td>
                        <td><?php echo $row['back'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['close'] ? 'Yes' : 'No'; ?></td>
                        <td><?php 
                        $createdByUserId = $row['created_by'];
                        $sql = "SELECT username FROM users WHERE id = $createdByUserId";
                        $result2 = $conn->query($sql);
                        if ($result2->num_rows > 0) {
                            $user = $result2->fetch_assoc();
                            echo $user['username'];
                        } else {
                            echo "Unknown";
                        }
                        ?> <?php echo $row['timestamp']; ?>  
                       
                        
                        </td>


                        <td> <?php 
                        if ($row['approved_by'] != 0) {
                            $sql = "SELECT username FROM users WHERE id = " . $row['approved_by'];
                            $result3 = $conn->query($sql);
                            if ($result3->num_rows > 0) {
                                $approver = $result3->fetch_assoc();
                                echo $approver['username'];
                            } else {
                                echo "Unknown";
                            }
                        } else {
                            echo "None";
                        }
                        ?>
                        
                        <?php echo $row['updated_at']; ?>
                         <?php 
                        $latitude = $row['latitude'];
                        $longitude =$row['longitude'];
                        $googleMapsUrl = "https://www.google.com/maps?q={$latitude},{$longitude}";
                        echo'<a href="' . $googleMapsUrl . '" target="_blank">Map</a>';
                        ?></td>
                        
                        
                        
                        
                     
                        <td><?php echo $row['remarks']; ?></td>
                    </tr>

                    <tr><td colspan="15">
                        
                    
<?php


$order_id = $row['id']; // Assuming $row['id'] contains the current order ID

$sql = "SELECT order_product.*, products.product_name 
        FROM order_product 
        LEFT JOIN products ON order_product.product_id = products.id 
        WHERE order_product.order_id = '$order_id'";
        
$result4 = $conn->query($sql);
if ($result4->num_rows > 0) {
    echo '<table class="table table-bordered ">';
    echo '<thead><tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead><tbody>';
    $productNames = array();
    $productQuantities = array();
    $totalQuantity = 0;
    $totalTotal = 0;
    while ($orderProductRow = $result4->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $orderProductRow['product_name'] . '</td>';
        echo '<td>' . $orderProductRow['quantity'] . '</td>';
        echo '<td>' . $orderProductRow['price'] . '</td>';
        echo '<td>' . $orderProductRow['total'] . '</td>';
        echo '</tr>';

        $totalQuantity += $orderProductRow['quantity'];
        $totalTotal += $orderProductRow['total'];

        if (!in_array($orderProductRow['product_name'], $productNames)) {
            $productNames[] = $orderProductRow['product_name'];
            $productQuantities[$orderProductRow['product_name']] = $orderProductRow['quantity'];
        } else {
            $productQuantities[$orderProductRow['product_name']] += $orderProductRow['quantity'];
        }

        if (!in_array($orderProductRow['product_name'], $productNamesall)) {
            $productNamesall[] = $orderProductRow['product_name'];
            $productQuantitiesall[$orderProductRow['product_name']] = $orderProductRow['quantity'];
        } else {
            $productQuantitiesall[$orderProductRow['product_name']] += $orderProductRow['quantity'];
        }
    }
    echo '<tr><td style="text-align: center;">' . count($productNames) . ' Unique Products</td><td style="text-align: center;">' . $totalQuantity . '</td><td style="text-align: center;">-</td><td style="text-align: center;">' . $totalTotal . '</td></tr>';
    $grandAmount+=$totalTotal;
    echo '<tr><td colspan="4" style="text-align: center;">';
    foreach ($productNames as $productName) {
        echo $productName . ': ' . $productQuantities[$productName] . '<br>';
    }
    echo '</td></tr>';
    

    echo '</tbody></table>';
} else {
    echo '<div style="text-align: center;">No products found for this order.</div>';
}
?>

                    
                    
                    
                    
                    
                    
                    
                    <hr></td></tr>

                    
                    <?php
                    
                }

                 echo '<tr><td colspan="15" style="text-align: center">' . count($productNamesall) . ' Unique Products Total Amount: ' . $grandAmount . '/=<br>';
                      echo '';
    foreach ($productNamesall as $productNameall) {
        echo $productNameall . ': ' . $productQuantitiesall[$productNameall] . '<br>';
    }
    echo '</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<hr>
<?php
    echo '<div style="text-align: center;"><button type="button" class="btn btn-secondary" onclick="window.location.href=\'printshort.php?idall=' . $idall . '\'">Print Short</button><button type="button" class="btn btn-secondary" style="margin-left: 10px;" onclick="window.location.href=\'printfull.php?idall=' . $idall . '\'">Print Full</button></div>';
?>

<?php
require_once 'footer.php';
?>