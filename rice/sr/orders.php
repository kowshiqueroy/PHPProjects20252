<?php
require_once '../conn.php';
require_once 'header.php';


// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

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

        <div class="col-md-1 col-4">
            <label for="draft">Edit</label>
            <select class="form-control select2" id="draft" name="draft">
                <option value="">All</option>
                <option value="0">End</option>
                <option value="1">Draft</option>
            </select>
        </div>
        <div class="col-md-1 col-4">
            <label for="approval">Approval</label>
            <select class="form-control select2" id="approval" name="approval">
                <option value="">All</option>
                <option value="1">Approved</option>
                <option value="0">Pending</option>
            </select>
        </div>
        <div class="col-md-1 col-4">
            <label for="delivery_status">Delivery</label>
            <select class="form-control select2" id="delivery" name="delivery">
                <option value="">All</option>
                <option value="1">Delivered</option>
                <option value="0">Not Delivered</option>
            </select>
        </div>

        <div class="col-md-1 col-4">
            <label for="back_status">Back</label>
            <select class="form-control select2" id="back" name="back">
                <option value="">All</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="col-md-1 col-4">
            <label for="close">Close</label>
            <select class="form-control select2" id="close" name="close">
                <option value="">All</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
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
                $sql = "SELECT id, username FROM users WHERE role = '2' OR role = '3'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                    }
                }
                ?>
                        <?php
                     }
                ?>
              
               
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
                        echo "<option value='" . $row['id'] . "'>" . $row['route_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="person_id">Person Name</label>
            <select class="form-control select2" id="person_id" name="person_id">
                <option value="">All</option>
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
        
    <div class="col-md-2 col-6">
        <label for="order_from_date">Order From</label>
        <input type="date" class="form-control" id="order_from_date" name="order_date" value="<?php echo date('Y-m-d'); ?>">
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
                <th >ID</th>
                
                <th>Route</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
               <th>Remarks</th>
                <th>Approval</th>
                <th>Delivery</th>
                <th>Back</th>
                <th>Close</th>
                <th>Created By</th>
                <th>Approved By</th>
                
            </tr>
        </thead>
        <tbody id="table_data">
            <?php
                $idall = '';
                print_r($_SESSION['querylist']);
               
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
