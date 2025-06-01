<?php
require_once '../conn.php';
require_once 'header.php';


if (isset($_SESSION['querylist'])) {
    foreach ($_SESSION['querylist'] as $key => $value) {
        ${$key} = $value;
       // echo '<br>'. $key .''. $value .'';
        
    }
}


if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $sql = "UPDATE orders SET serial = serial + 1 WHERE id = '$update_id'";
    if ($conn->query($sql) === TRUE) {
        echo '<div style="text-align: center;">Order serial updated successfully</div>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>


<div class="card p-1 text-center">Orders</div>
<hr>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary" onclick="window.location.href='create.php'">Create New Order</button>
</div>

<hr>
<form id="filterForm" class="no-print" method="get" action="">
    <div class="row">

        <div class="col-md-2 col-6">
            <label for="order_status">Order Status</label>
            <select class="form-control select2" id="order_status" name="order_status">
                <option value="">All</option>
                <option value="0" <?php echo $order_status == 0 ? 'selected' : ''; ?>>Draft</option>
                <option value="1" <?php echo $order_status == 1 ? 'selected' : ''; ?>>Submit</option>
                <option value="2" <?php echo $order_status == 2 ? 'selected' : ''; ?>>Approve</option>
                <option value="3" <?php echo $order_status == 3 ? 'selected' : ''; ?>>Reject</option>
                <option value="4" <?php echo $order_status == 4 ? 'selected' : ''; ?>>Edit</option>
                <option value="5" <?php echo $order_status == 5 ? 'selected' : ''; ?>>Serial</option>
                <option value="6" <?php echo $order_status == 6 ? 'selected' : ''; ?>>Processing</option>
                <option value="7" <?php echo $order_status == 7 ? 'selected' : ''; ?>>Delivered</option>
                <option value="8" <?php echo $order_status == 8 ? 'selected' : ''; ?>>Returned</option>
                

            </select>
        </div>

         <div class="col-md-2 col-6">
            <label for="created_by">Created By</label>
            <select class="form-control select2" id="created_by" name="created_by">
              
                <?php if ($_SESSION['role'] == 2): ?>
                    <option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['username']; ?></option>
                <?php else: ?>
                    <?php
                    $sql = "SELECT * FROM users WHERE role IN (2,3)";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                        }
                    }
                    ?>

                <?php endif; ?>
                

            </select>
        </div>
        
      
        <div class="col-md-3">
            <label for="route_id">Route Name</label>
            <select class="form-control select2" id="route_id" name="route_id">
                <option value="">All</option>
                <?php
                $sql = "SELECT * FROM routes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        if ($row["id"] == $route_id) {
                             echo "<option selected value='" . $row['id'] . "'>" . $row['route_name'] . "</option>";
                        }
                        else {
                             echo "<option value='" . $row['id'] . "'>" . $row['route_name'] . "</option>";
                        }
                       
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="person_id">Shop Name, Address, Phone</label>
            <select class="form-control select2" id="person_id" name="person_id">
                <option value="">All</option>
                <?php
                $sql = "SELECT * FROM persons";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                         if ($row["id"] == $person_id) {
                             echo "<option selected value='" . $row['id'] . "'>" . $row['person_name'] . "</option>";
                        }
                        else {
                             echo "<option value='" . $row['id'] . "'>" . $row['person_name'] . "</option>";
                        }     
                    
                    }
                }
                ?>
            </select>
        </div>

       
       
        
    </div>
    <div class="row mt-3">
        
    <div class="col-md-2 col-6">
        <label for="order_date_from">Order From</label>
        <input type="date" class="form-control" id="order_date_from" name="order_date_from" value="<?php echo !empty($order_date_from) ? $order_date_from : date('Y-m-d'); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="order_date_to">Order To</label>
        <input type="date" class="form-control" id="order_date_to" name="order_date_to" value="<?php echo !empty($order_date_to) ? $order_date_to : date('Y-m-d'); ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_date_from">Delivery From</label>
        <input type="date" class="form-control" id="delivery_date_from" name="delivery_date_from" value="<?php echo !empty($delivery_date_from) ? $delivery_date_from : ''; ?>">
    </div>
    <div class="col-md-2 col-6">
        <label for="delivery_date_to">Delivery To</label>
        <input type="date" class="form-control" id="delivery_date_to" name="delivery_date_to" value="<?php echo !empty($delivery_date_to) ? $delivery_date_to : ''; ?>">
    </div>





<div class="col-md-2 col-6 mt-4">
    <button type="button" class="btn btn-primary" name="search" onclick="setSessionQueryData()">Search</button>
</div>


<div class="col-md-2 col-6 mt-4">
    <button type="button" class="btn btn-success" onclick="blankSessionQueryData()">Refresh</button>
</div>
<script>
    function refreshPage() {
        window.location.href = 'orders.php';
    }
</script>
       
         
       
    </div>

</form>


<script>



    function setSessionQueryData() {

        var formData = new FormData(document.getElementById('filterForm'));
        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                refreshPage();
            }
        };
        xhttp.open("POST", "set_session_data.php", true);
        xhttp.send(formData);
        



    }
function blankSessionQueryData() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            refreshPage();
            
        }
    };
    xhttp.open("POST", "clear_session_data.php", true);
    xhttp.send();
}

    </script>
<hr>


<hr>
<div class="table-responsive">
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
                <th>Action</th>   
                <th>Route</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Dates</th>
                <th>Remarks</th>
                <th>Approved By</th>
                <th>Created</th>
                <th></th>

                
            </tr>
        </thead>
        <tbody id="table_data">
            <?php
                $idall = '';       
            ?>

<?php
    

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        if (empty($idall)) {
            $idall = $row['id'];
        } else {
            $idall .= ",".$row['id'];
        }
        echo '<tr>';
        echo '<td>ID: ' . htmlspecialchars($row['id']) ."<br>";
        switch ($row['order_status']) {
            case 0:
                echo '<a href="create.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Draft</a>';
                break;
            case 1:
                echo '<span class="btn btn-warning">Submit</span>';
                break;
            case 2:
                echo '<span class="btn btn-success">Approve</span>';
                break;
            case 3:
                echo '<span class="btn btn-danger">Reject</span>';
                break;
            case 4:
                echo '<a href="create.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Edit</a>';
                break;
            case 5:
                echo '<span class="btn btn-info">Serial</span>';
                break;
            case 6:
                echo '<span class="btn btn-secondary">Processing</span>';
                break;
            case 7:
                echo '<span class="btn btn-success">Delivered</span>';
                break;
            case 8:
                echo '<span class="btn btn-danger">Returned</span>';
                break;
            default:
                echo '';
                break;
        }
        
        echo '</td>';
        $sql2 = "SELECT route_name FROM routes WHERE id = '".$row['route_id']."'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            echo '<td>' . htmlspecialchars($row2['route_name']) . '</td>';
        }
        
        $sql3 = "SELECT person_name FROM persons WHERE id = '".$row['person_id']."'";
        $result3 = $conn->query($sql3);
        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_assoc();
            echo '<td>' . htmlspecialchars($row3['person_name']) . '</td>';
        }
        echo '<td>' . htmlspecialchars($row['total']) . '</td>';
        echo '<td> order:' . htmlspecialchars($row['order_date']) . '<br>delivery:' . htmlspecialchars($row['delivery_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['remarks']) . '</td>';
       
     
        
        $sql5 = "SELECT username FROM users WHERE id = '".$row['approved_by']."'";
        $result5 = $conn->query($sql5);
        if ($result5->num_rows > 0) {
            $row5 = $result5->fetch_assoc();
            echo '<td>' .htmlspecialchars($row['updated_at']). ' '.'<br>' . htmlspecialchars($row5['username']) .''.'</td>';
        } else {
            echo '<td></td>';
        }
        echo '<td>' . htmlspecialchars($row['created_at']);
        
          
      $sql4 = "SELECT username FROM users WHERE id = '".$row['created_by']."'";
        $result4 = $conn->query($sql4);
        if ($result4->num_rows > 0) {
            $row4 = $result4->fetch_assoc();
            echo ' <br>' . htmlspecialchars($row4['username']) . '';
        } else {
            echo '-';
        }
        
        
        echo '</td>';
       
        echo '<td><a href="https://www.google.com/maps/search/?api=1&query=' . htmlspecialchars($row['latitude']) . ',' . htmlspecialchars($row['longitude']) . '" target="_blank"> <i class="fa fa-map-marker" aria-hidden="true"></i></a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="12" style="text-align: center;">No orders found</td></tr>';
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
