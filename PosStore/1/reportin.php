<?php
include 'header.php';
?>



<div class="container-fluid py-5">


    <form action="" method="get">
        <div class="row">
            <div class="col-md-2">
                <label for="from">From</label>
                <input type="date" name="from" id="from" class="form-control" value="<?php echo isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'); ?>">
            </div>
            <div class="col-md-2">
                <label for="to">To</label>
                <input type="date" name="to" id="to" class="form-control" value="<?php echo isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'); ?>">
            </div>
            <div class="col-md-2">
                <label for="person">Person</label>
                <input type="text" name="person" id="person" class="form-control" value="<?php echo isset($_GET['person']) ? $_GET['person'] : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="0" <?php echo isset($_GET['status']) && $_GET['status'] == 0 ? 'selected' : ''; ?>>IN</option>
                    <option value="1" <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : ''; ?>>Back</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="">All</option>
                    <?php
                    $sql = "SELECT id, name FROM type WHERE company = '".$_SESSION['company']."'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id']."' ".(isset($_GET['type']) && $_GET['type'] == $row['id'] ? 'selected' : '').">".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="productname">Product Name</label>
                <input type="text" name="productname" id="productname" class="form-control" value="<?php echo isset($_GET['productname']) ? $_GET['productname'] : ''; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <?php
    $where = "";




    $where .= " AND date >= '".(isset($_GET['from']) && !empty($_GET['from']) ? $_GET['from'] : date('Y-m-d'))."' ";
    $where .= " AND date <= '".(isset($_GET['to']) && !empty($_GET['to']) ? $_GET['to'] : date('Y-m-d'))."' ";






    if (isset($_GET['person']) && !empty($_GET['person'])) {
        $where .= " AND person LIKE '%".$_GET['person']."%' ";
    }
    if (isset($_GET['status']) && $_GET['status'] != '') {
        $where .= " AND status = ".$_GET['status']." ";
    }
   
    $sql = "SELECT * FROM invoicein WHERE confirm = 1 AND company = '".$_SESSION['company']."'".$where." ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      
        while ($row = mysqli_fetch_assoc($result)) {
          
            

          
            
            $where2 = "";
            if (isset($_GET['type']) && $_GET['type'] != '') {
                $where2 .= " AND type = ".$_GET['type']." ";
            }
            if (isset($_GET['productname']) && !empty($_GET['productname'])) {
                $where2 .= " AND productname LIKE '%".$_GET['productname']."%' ";
            }
            $sql2 = "SELECT p.id, t.name AS type, p.productname, u.name AS unit, p.quantity, p.costprice, p.sellprice , p.location, p.mfg, p.exp, p.remarks
            FROM productin p 
            JOIN type t ON p.type = t.id 
            JOIN unit u ON p.unit = u.id 
            WHERE p.personid = '".$row['id']."'".$where2;
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
             
              


               
                echo "<table class='table table-bordered'>";


                echo "<tr><td colspan='11' style='text-align: center;'>";
                echo "ID: ".$row['id'];
                echo " <i class='fa fa-user'></i> ".$row['person'];
                echo " <i class='fa fa-wallet'></i> ".$row['totalprice'];
                echo " <i class='fa fa-calendar'></i> ".$row['date'];
                echo " <i class='fa ".($row['status'] == 0 ? "fa-arrow-down" : "fa-undo")."'></i> ".($row['status'] == 0 ? "IN" : "Back");
                echo " <i class='fa fa-money'></i> ".$row['paymentmethod'];
                echo " <i class='fa fa-comment'></i> ".$row['remarks'];
                echo " <i class='fa fa-clock'></i> ".date('d-m-Y H:i:s', strtotime($row['timestamp']));
                echo "</td></tr>";

                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Type</th>";
                echo "<th>Product Name</th>";
                echo "<th>Unit</th>";
                echo "<th>Quantity</th>";
                echo "<th>Cost Price</th>";
                echo "<th>Sell Price</th>";
                echo "<th>Location</th>";  
                echo "<th>Mfg</th>"; 
                 echo "<th>Exp</th>";
                echo "<th>Remarks</th>";
                echo "</tr>";
               
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<tr>";
                    echo "<td>".$row2['id']."</td>";
                    echo "<td>".$row2['type']."</td>";
                    echo "<td>".$row2['productname']."</td>";
                    echo "<td>".$row2['unit']."</td>";
                    echo "<td>".$row2['quantity']."</td>";
                    echo "<td>".$row2['costprice']."</td>";
                    echo "<td>".$row2['sellprice']."</td>";
                    echo "<td>".$row2['location']."</td>";
                    echo "<td>".($row2['mfg'] == '0000-00-00' ? '' : date('d-m-Y', strtotime($row2['mfg'])))."</td>";
                    echo "<td>".($row2['exp'] == '0000-00-00' ? '' : date('d-m-Y', strtotime($row2['exp'])))."</td>";
                    echo "<td>".$row2['remarks']."</td>";
                    echo "</tr>";
                }

                
                
              
                echo "</table>";
              
            }
        }
    
    } else {
      
    }
?>

</div>

<?php

include 'footer.php';
?>