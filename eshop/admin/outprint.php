<?php
require_once '../conn.php';
if(!isset($_GET['id'])) {
    header("Location: outproducts.php");
    exit;
}
?>


<?php
$id = $_GET["id"];
$sql = "SELECT * FROM outdetails WHERE id = '$id'";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $person_id= $row['person_id'];
                    $total= $row['total'];
                    $purchase_date= $row['purchase_date'];
                    $type= $row['type'];
                    $status= $row['status'];
                    $paymentmethod= $row['payment_method'];

                    $payment_details= $row['payment_details'];
                    $remarks=$row['remarks'];

                   
                    
                }
            }

?>
<style>
    @media print {
        
        .a4 {
            display: block;
            width: 210mm;
            height: auto;
            margin: 0 auto;
        }
    }
</style>

<div class="a4" >
 
<div class="invoice" >
    <div class="header" style="display: flex; justify-content: space-between; align-items: center;">
        <?php
            $sql = "SELECT logo, companyname, address, phone FROM companyinfo WHERE id = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<img src="' . $row['logo'] . '" alt="Company Logo" style="width:80px;">';
                echo '<div style="text-align:center;">';
                echo '<h2 style="margin: 0;">' . $row['companyname'] . '</h2>';
                echo '<p style="margin: 2px 0;">' . $row['address'] . '</p>';
                echo '<p style="margin: 2px 0;">Phone: ' . $row['phone'] . '</p>';
                echo '</div>';
            }
        ?>
    </div>

    <hr style="margin: 15px 0;">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div class="invoice-details">
            <h3 style="margin-bottom: 5px;">INVOICE #<?php echo $id; ?></h3>
        </div>
        <div style="text-align:right;">
            <p style="margin: 2px 0;"><?php 
             if($status == 0){
                echo ' Out ';
            }
            else{
                echo 'Back ';
            }
            if($type == 0){
                echo '<strong>Type:</strong> Draft <br>';
            }
            else{
                echo 'Confirmed ';
            }
            
            ?><strong>Date:</strong> <?php echo date('Y-m-d'); ?></p>
           
        </div>
    </div>

    <hr style="margin: 15px 0;">

    <div class="client-info">
        <?php
            $sql = "SELECT details FROM person WHERE id = '$person_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h4 style="margin-bottom: 5px;">Bill To: ' . $row['details'] . '</h4>';
            }
        ?>
      
    </div>

    <table style="width:100%; border-collapse: collapse; margin-top: 15px;">
        <thead style="background-color:#f2f2f2;">
            <tr>
                <th style="padding:8px; text-align:left;">Description</th>
                <th style="padding:8px; text-align:center;">Qty</th>
                <th style="padding:8px; text-align:center;">Price</th>
                <th style="padding:8px; text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT product_id, quantity, price FROM outproducts WHERE outdetails_id = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td style="padding:8px;">' . getProductname($row['product_id']) . '</td>';
                    echo '<td style="padding:8px; text-align:center;">' . $row['quantity'] . '</td>';
                    echo '<td style="padding:8px; text-align:center;">' . number_format($row['price'], 2) . '</td>';
                    echo '<td style="padding:8px; text-align:right;">' . number_format($row['price'] * $row['quantity'], 2) . '</td>';
                    echo '</tr>';
                }
            }

function getProductname($product_id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['category'].'-'.$row['brand'].'-'.$row['maker'].'- <b>'.$row['productname'].'</b>';
    }
    return null;
}

            ?>
        
        </tbody>
        <tfoot>
           
            <tr>
                <td colspan="3" style="padding:8px; text-align:right;"><strong>Total</strong></td>
                <td style="padding:8px; text-align:right;"><strong><?php echo $total; ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <hr style="margin: 15px 0;">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <?php if (!empty($paymentmethod)): ?>
            <p><strong>Payment Method:</strong> <?php echo $paymentmethod; ?></p>
        <?php endif; ?>
        <?php if (!empty($payment_details)): ?>
            <p><strong>Details:</strong> <?php echo $payment_details; ?></p>
        <?php endif; ?>
        <?php if (!empty($remarks)): ?>
            <p><strong>Remarks:</strong> <?php echo $remarks; ?></p>
        <?php endif; ?>
    </div>
</div>


</div>



<?php
require_once 'footer.php';
?>