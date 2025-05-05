<?php
include 'header.php';


if (isset($_GET['next'])) {
    $name = $_GET['name'];
    $date = $_GET['date'];
    $status = $_GET['status'];

   

    if ($name != "-") {
        $sql = "SELECT * FROM person WHERE name = '$name' AND company = '".$_SESSION['company']."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          
        } else {
            $sql = "INSERT INTO person (name, company) VALUES ('$name', '".$_SESSION['company']."')";
            if (mysqli_query($conn, $sql)) {
          
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }


        $sql = "INSERT INTO invoicein (person, date, status, company) VALUES ('$name', '$date', '$status', '".$_SESSION['company']."')";
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            echo "<script>window.location.href = 'inadd.php?id=$id';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT confirm, timestamp FROM invoicein WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $confirm = $row['confirm'];

    if ($confirm == 1) {
      
        if (mysqli_query($conn, $sql)) {
           echo '<div style="text-align: center; border: 1px solid #ccc; color: red; border-radius: 10px; padding: 10px; background-color: #f5f5f5;"> Already Confirmed @ '.$row['timestamp'].'. Cant edit.</div>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    else {
   


    if (isset($_GET['save'])) {
        $id = $_GET['id'];
        $name = $_GET['name'];

        if ($name != "-") {
            $sql = "SELECT * FROM person WHERE name = '$name' AND company = '".$_SESSION['company']."'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              
            } else {
                $sql = "INSERT INTO person (name, company) VALUES ('$name', '".$_SESSION['company']."')";
                if (mysqli_query($conn, $sql)) {
              
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
        $sql = "UPDATE invoicein SET person = '".$_GET['name']."', date = '".$_GET['date']."', status = '".$_GET['status']."' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'inadd.php?id=$id';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }


     
    }

    if (isset($_GET['add'])) {
        $id = $_GET['id'];
        $name = $_GET['name'];
            
        $type = $_GET['type'];
        $unit = $_GET['unit'];
        $quantity = $_GET['quantity'];
        $costprice = $_GET['costprice'];
        $sellprice = $_GET['sellprice'];
        $location = $_GET['location'];
        $mfg = $_GET['mfg'];
        $exp = $_GET['exp'];
        $remarks = $_GET['remarks'];
    
        $sql = "INSERT INTO productin (personid, type, productname, unit, quantity, costprice, sellprice, location, mfg, exp, remarks, company) 
                VALUES ('$id', '$type', 
                '$name', '$unit', '$quantity', '$costprice', '$sellprice', '$location', '$mfg', '$exp', '$remarks', '".$_SESSION['company']."')";
    
        if (mysqli_query($conn, $sql)) {

            $sql = "SELECT totalprice FROM invoicein WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalprice = $row['totalprice'] ? $row['totalprice'] : 0;
            $totalprice += $quantity * $costprice;
            $sql = "UPDATE invoicein SET totalprice = '$totalprice' WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {}
            echo "<script>window.location.href = 'inadd.php?id=$id';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



    }


    if (isset($_GET['delid'])) {
        $delid = $_GET['delid'];
        $id = $_GET['id'];
        $sql = "SELECT totalprice FROM invoicein WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalprice = $row['totalprice'] ? $row['totalprice'] : 0;

        $sql = "SELECT costprice, quantity FROM productin WHERE id = '$delid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $costprice = $row['costprice'];
        $quantity = $row['quantity'];

        $totalprice -= $quantity * $costprice;
        $sql = "UPDATE invoicein SET totalprice = '$totalprice' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {}


        $sql = "DELETE FROM productin WHERE id = '$delid'";
        if (mysqli_query($conn, $sql)) {
  

           
            echo "<script>window.location.href = 'inadd.php?id=$id';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    
    if (isset($_GET['saveend'])) {
        $id = $_GET['id'];
        $paymentmethod = $_GET['paymentmethod'];
        $remarks = $_GET['remarks'];



        $sql = "SELECT id FROM productin WHERE personid = '$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['id']."<br>";

            $sql = "SELECT type, productname, unit, quantity FROM productin WHERE id = '".$row['id']."'";
            $result2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result2);
            $stype = $row2['type'];
            $pname = $row2['productname'];
            $punit = $row2['unit'];
            $pquantity = $row2['quantity'];
            $sql = "SELECT id, stock FROM product WHERE type = '$stype' AND name = '$pname' AND unit = '$punit' and company = '".$_SESSION['company']."'";
            $result2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result2);
            $squantity = $row2['stock'];
            $psid= $row2['id'];


            $sql = "UPDATE product SET stock = '$squantity' + '$pquantity' WHERE id = '$psid'";
            if (mysqli_query($conn, $sql)) {}
            

        }

       

        $sql = "UPDATE invoicein SET  confirm = 1, paymentmethod = '$paymentmethod', remarks = '$remarks' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'inlist.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    if (isset($_GET['saveon'])) {
        $id = $_GET['id'];
        $paymentmethod = $_GET['paymentmethod'];
        $remarks = $_GET['remarks'];

        $sql = "UPDATE invoicein SET paymentmethod = '$paymentmethod', remarks = '$remarks' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'inlist.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }





        
}
}

?>



<div class="container-fluid py-5">

    <div class="container-fluid bg-primary mb-5 wow fadeIn noprint" data-wow-delay="0.1s" style="padding: 35px;">
        <div class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-9">
                                <label for="name" class="form-label text-white">Name Shop/Address Contact Details ID</label>
                                <select class="form-select border-0 select2" id="pname" name="name">
                                      <?php 
                                   if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                       $sql = "SELECT * FROM invoicein WHERE id = '$id'";
                                     $result = mysqli_query($conn, $sql);
                                      if ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option selected>".$row['person']."</option>";
                                       }
                                    } else {
                                        echo "<option value='-' selected>Example: Kowshique Roy Babu Para, Nilphamari 01632950179 4322</option>";
                                    }
                                
                                   
                                    $sql = "SELECT * FROM person WHERE company = '".$_SESSION['company']."' ORDER BY name DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option>".$row['name']."</option>";
                                    }
                                    ?>
                                </select>

                               
                            </div>
                    
                            <div class="col-md-2">
                                <label for="date" class="form-label text-white">Date</label>



                                <?php
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $sql = "SELECT date FROM invoicein WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $dateValue = date('Y-m-d', strtotime($row['date']));
                                } else {
                                    $dateValue = date('Y-m-d');
                                }
                                ?>
                                <input type="date" class="form-control border-0" id="date" name="date" value="<?php echo $dateValue; ?>" required>
                            
                           
                            </div>
                            <div class="col-md-1">
                                <label for="status" class="form-label text-white">Status</label>
                                <select class="form-select border-0" id="status" name="status">
                                    <?php if (isset($_GET['id'])) {
                                        $sql = "SELECT status FROM invoicein WHERE id = ".$_GET['id'];
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $selectedStatus = $row['status'];
                                    } else {
                                        $selectedStatus = 0;
                                    } ?>
                                    <option value="0" <?php echo $selectedStatus == 0 ? 'selected' : ''; ?>>IN</option>
                                    <option value="1" <?php echo $selectedStatus == 1 ? 'selected' : ''; ?>>Back</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php if (isset($_GET['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <button class="btn btn-success border-0 w-100 h-100" name="save" type="submit">Update</button>
                        <?php } else { ?>
                            <button class="btn btn-success border-0 w-100 h-100" name="next" type="submit">Next</button>
                        <?php } ?>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>




    <?php if (isset($_GET['id'])) { ?>





        <div class="container-fluid ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <select class="form-select border-0 select2n" id="type" name="type" onChange="this.form.submit()" required>
                                        <option value="">Select Type</option>
                                        <?php
                                            $sql = "SELECT DISTINCT type FROM product WHERE company = '".$_SESSION['company']."' ORDER BY type ASC";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $typeName = $row['type'];
                                                $typeSql = "SELECT name FROM type WHERE id = '$typeName'";
                                                $typeResult = mysqli_query($conn, $typeSql);
                                                $typeRow = mysqli_fetch_assoc($typeResult);
                                                echo "<option value='".$typeName."' ".(isset($_GET['type']) && $_GET['type'] == $typeName ? 'selected' : '').">".$typeRow['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select border-0 select2n" id="name" name="name" onChange="this.form.submit()" required>
                                        <option value="">Select Product Name</option>
                                        <?php
                                            if (isset($_GET['type'])) {
                                                $sql = "SELECT DISTINCT name FROM product WHERE type = '".$_GET['type']."' AND company = '".$_SESSION['company']."' ORDER BY name ASC";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $productName = $row['name'];
                                                    echo "<option value='".$productName."' ".(isset($_GET['name']) && $_GET['name'] == $productName ? 'selected' : '').">".$productName."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <select class="form-select border-0 select2n" id="unit" name="unit" required>
                                       
                                        <?php
                                            if (isset($_GET['name'])) {
                                                $sql = "SELECT DISTINCT unit FROM product WHERE name = '".$_GET['name']."' AND company = '".$_SESSION['company']."' ORDER BY unit ASC";
                                                $result = mysqli_query($conn, $sql);
                                                $units = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                if (count($units) == 1) {
                                                    $unit = $units[0];
                                                    $unitSql = "SELECT name FROM unit WHERE id = '".$unit['unit']."'";
                                                    $unitResult = mysqli_query($conn, $unitSql);
                                                    $unitRow = mysqli_fetch_assoc($unitResult);
                                                    echo "<option value='".$unit['unit']."' selected readonly>".$unitRow['name']."</option>";
                                                } else {
                                                    foreach ($units as $unit) {
                                                        $unitSql = "SELECT name FROM unit WHERE id = '".$unit['unit']."'";
                                                        $unitResult = mysqli_query($conn, $unitSql);
                                                        $unitRow = mysqli_fetch_assoc($unitResult);
                                                        echo " <option value=''>Select Unit</option> <option value='".$unit['unit']."' ".(isset($_GET['unit']) && $_GET['unit'] == $unit['unit'] ? 'selected' : '').">".$unitRow['name']."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" class="form-control" id="costprice" name="costprice" placeholder="Cost Price/Unit" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" class="form-control" id="sellprice" name="sellprice" placeholder="Sell Price/Unit" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="mfg" name="mfg" placeholder="MFG">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="exp" name="exp" placeholder="EXP">
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"></textarea>
                                </div>
                                <div class="col-md-2 text-end">
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <button class="btn btn-success border-0" name="add" type="submit">Add</button>
                                </div>
                            </div>
                        </form>




                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Unit</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Cost Price</th>
                                    <th>Sell Price</th>
                                    <th>Location</th>
                                    <th>MFG</th>
                                    <th>EXP</th>
                                    <th>Total</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT p.id, t.name AS type, u.name AS unit, p.productname, p.quantity, p.costprice, p.sellprice, p.location, p.mfg, p.exp, p.remarks 
                            FROM productin p 
                            JOIN type t ON p.type = t.id 
                            JOIN unit u ON p.unit = u.id 
                            WHERE p.personid = '$id' ORDER BY p.id DESC";
                            $result = mysqli_query($conn, $sql);
                            $subtotal = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $total = $row['quantity'] * $row['costprice'];
                                $subtotal += $total;
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['costprice']; ?></td>
                                    <td><?php echo $row['sellprice']; ?></td>
                                    <td><?php echo $row['location']; ?></td>
                                    <td><?php echo $row['mfg']; ?></td>
                                    <td><?php echo $row['exp']; ?></td>
                                    <td><?php echo number_format($total, 2); ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td>
                                        <a href="inadd.php?id=<?php echo $id; ?>&delid=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="text-end"><strong>Sub Total:</strong></td>
                                    <td colspan="3"><?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>

<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <label for="paymentmethod" class="form-label">Payment Method</label>
                <select class="form-select" id="paymentmethod" name="paymentmethod" required>
                    <?php if (!is_null($row['paymentmethod'])): ?>
                        <option value="<?php echo $row['paymentmethod']; ?>" selected><?php echo strtoupper($row['paymentmethod']); ?></option>
                    <?php endif; ?>
                    
                    <option value="cash">Cash</option>
                    <option value="bkash">Bkash</option>
                    <option value="nagad">Nagad</option>
                    <option value="mobile">Rocket</option>
                    <option value="netbanking">Net Banking</option>
                    <option value="upi">Upi</option>
                    <option value="card">Card</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="remarks" class="form-label">Remarks</label>
                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo isset($row['remarks']) ? $row['remarks'] : ''; ?></input>
      
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-end">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button class="btn btn-secondary" name="saveon" type="submit">Save</button>
                <button class="btn btn-primary" name="saveend" type="submit">Save & End</button>
            </div>
        </div>

    </form>
</div>

                    </div>
                </div>
            </div>
        </div>





        
    <?php } ?>


















</div>



<?php
include 'footer.php';
?>


