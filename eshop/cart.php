 
 <?php
 require_once("head.php");
 ?>
  

<?php 
  $session_id = $_SESSION['sid'];
  $sql = "SELECT id FROM outdetails WHERE session_id = '$session_id' AND type=0 LIMIT 1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $outdetails_id = $row['id'];

function getProductname($id) {
    $sql = "SELECT productname FROM products WHERE id = '$id'";
    $result = $GLOBALS['conn']->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['productname'];
    }
    return "";
}
      ?>




<style>
    table{
        width: 100%;
        border-collapse: collapse;
    }
    th, td{
        padding: 10px;
        border: 1px solid #ddd;
    }
    th{
        text-align: left;
        background-color: #f5f5f5;
    }
    .productinfo{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .productname{
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .productprice{
        font-size: 16px;
        margin-bottom: 10px;
    }
    .productquantity{
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>


<h3>Your Cart</h3>



<table class="table table-striped">
    <thead>
        <tr>
            <th style="text-align: center;">Product</th>
            <th style="text-align: center;">Quantity</th>
            <th style="text-align: center;">Price</th>
            <th style="text-align: center;">Total</th>
            <th style="text-align: center;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM outproducts WHERE outdetails_id = '$outdetails_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a style='text-decoration:none;' href='p.php?id=" . $row['product_id'] . "'>" . getProductname($row['product_id']) . "</a></td>";
                echo "<td>";
                echo "<a style='text-decoration:none;' href='cart.php?decrease=" . $row['id'] . "'>-</a> " . $row['quantity'] . " <a style='text-decoration:none;' href='cart.php?increase=" . $row['id'] . "'>+</a>";
                echo "</td>";
                echo "<td>" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . number_format($row['price'] * $row['quantity'], 2) . "</td>";
                echo "<td><a style='text-decoration:none;' href='cart.php?delete=" . $row['id'] . "'>X</a></td>";
                echo "</tr>";
                $total += $row['price'] * $row['quantity'];
            }
            echo "<tr><td colspan='3' style='text-align: right;'>Sub Total: </td><td style='font-weight: bold;'>" . number_format($total, 2) . "</td></tr>";
             echo "<tr><td colspan='3' style='text-align: right;'>Mobile Banking Charge: </td><td style='font-weight: bold;'>" . number_format($mobilebankingcharge, 2)  . "</td></tr>";
              echo "<tr><td colspan='3' style='text-align: right;'>Delivery Charge: </td><td style='font-weight: bold;'>" . number_format($deliverycharge, 2)  . "</td></tr>";
               echo "<tr><td colspan='3' style='text-align: right;'>Total: </td><td style='font-weight: bold;'>" . number_format( $total + $mobilebankingcharge + $deliverycharge, 2) . "</td></tr>";
        }

if (isset($_GET['increase'])) {
    $id = $_GET['increase'];
    $sql = "UPDATE outproducts SET quantity = quantity + 1 WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='cart.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['decrease'])) {
    $id = $_GET['decrease'];
    $sql = "UPDATE outproducts SET quantity = quantity - 1 WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        if ($conn->query("SELECT quantity FROM outproducts WHERE id = '$id'")->fetch_assoc()['quantity'] == 0) {
            $sql = "DELETE FROM outproducts WHERE id = '$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>window.location.href='cart.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM outproducts WHERE id = '$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='cart.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}




        ?>
    </tbody>
</table>
<?php
if (isset($_POST['order'])) {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $payment_method = $_POST['payment_method'];
  $payment_details = $_POST['payment_details'];
  $remarks = $_POST['remarks'];

  $person_name = $name . " " . $address . " " . $phone;
  $sql = "SELECT id FROM person WHERE details = '$person_name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $person_id = $row['id'];
  } else {
    $sql = "INSERT INTO person (details) VALUES ('$person_name')";
    if ($conn->query($sql) === TRUE) {
      $person_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
$session_id2=$session_id." Ordered";
  $sql = "UPDATE outdetails SET session_id = '$session_id2', person_id = '$person_id', payment_method = '$payment_method', payment_details = '$payment_details', remarks = '$remarks' WHERE id = '".   $outdetails_id."'";
  if ($conn->query($sql) === TRUE) {

    echo "<div class='alert alert-success text-center'>Successfully Ordered</div>";
echo "<script>
    setTimeout(function() {
        window.location.href='cart.php';
    }, 2000);
</script>";

    
    
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

?>
<div class="container mt-5">
  <div class="card shadow">
    <h5 class="card-header bg-primary text-white text-center">Checkout</h5>
    <div class="card-body">
      <form action="cart.php" method="POST">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
          </div>
        
          <div class="col-md-4 mb-3">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
          </div>
        </div>
         <div class="row">  

         <?php
             echo '<div style="margin-bottom: 15px;" class="text-center p-2  rounded">Payment Instructions: ' . htmlspecialchars($bank) . '</div>';
         ?>
         </div>
        <div class="row">
          <div class="col-md-2 mb-3">
            <label for="payment_method">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
          
              <option>BKash</option>
              <option>Rocket</option>
              <option>Nagad</option>
              <option>Other</option>
           
            </select>
          </div>
        
            <div class="col-md-3 mb-3">
            <label for="payment_details">Payment Details</label>
            <input type="text" class="form-control" id="payment_details" name="payment_details" placeholder="Transaction ID / Number / Details" required>
            </div>
            <div class="col-md-3 mb-3">
            <label for="remarks">Remarks</label>
            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Any special instructions">
            </div>

             <div class="col-md-3  h-100">
           <button type="submit" name="order" class="btn btn-success btn-lg w-100">Place Order</button>
            </div>
            

        </div>
      </form>
    </div>
  </div>
</div>


      <?php
  }
  else {
    ?>

    <div style="text-align:center;padding:50px;margin-bottom:400px;">
        <h3>No Pending Orders</h3>
        <a href="shop.php" class="btn btn-primary btn-lg">Go to Shop Page</a>
        
    </div>

<?php
  }
?>
  


 <?php
 require_once("foot.php");
 ?>


