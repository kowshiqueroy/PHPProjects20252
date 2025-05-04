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


        $sql = "INSERT INTO invoiceout (person, date, status, company) VALUES ('$name', '$date', '$status', '".$_SESSION['company']."')";
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            echo "<script>window.location.href = 'outadd.php?id=$id';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT confirm, timestamp FROM invoiceout WHERE id = '$id'";
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
        $sql = "UPDATE invoiceout SET person = '".$_GET['name']."', date = '".$_GET['date']."', status = '".$_GET['status']."' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'outadd.php?id=$id';</script>";
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
        $price = $_GET['sellprice'];
    
        $remarks = $_GET['remarks'];
    
        $sql = "INSERT INTO productout (personid, type, productname, unit, quantity, price, remarks, company) 
                VALUES ('$id', '$type', 
                '$name', '$unit', '$quantity',  '$price', '$remarks', '".$_SESSION['company']."')";
    
        if (mysqli_query($conn, $sql)) {

            $sql = "SELECT totalprice FROM invoiceout WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalprice = $row['totalprice'] ? $row['totalprice'] : 0;
            $totalprice += $quantity * $price;
            $sql = "UPDATE invoiceout SET totalprice = '$totalprice' WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {}
            echo "<script>window.location.href = 'outadd.php?id=$id';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



    }


    if (isset($_GET['delid'])) {
        $delid = $_GET['delid'];
        $id = $_GET['id'];
        $sql = "SELECT price, quantity FROM productout WHERE id = '$delid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $costprice = $row['costprice'];
        $quantity = $row['quantity'];

        $sql = "SELECT totalprice FROM invoiceout WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalprice = $row['totalprice'] ? $row['totalprice'] : 0;

        $totalprice -= $quantity * $costprice;
        $sql = "UPDATE invoiceout SET totalprice = '$totalprice' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {}


        $sql = "DELETE FROM productout WHERE id = '$delid'";
        if (mysqli_query($conn, $sql)) {
  

           
            echo "<script>window.location.href = 'outadd.php?id=$id';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    
    if (isset($_GET['saveend'])) {
        $id = $_GET['id'];
        $paymentmethod = $_GET['paymentmethod'];
        $remarks = $_GET['remarks'];

        
        $sql = "SELECT id FROM productout WHERE personid = '$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            

            $sql = "SELECT type, productname, unit, quantity FROM productout WHERE id = '".$row['id']."'";
            $result2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result2);
            $stype = $row2['type'];
            $pname = $row2['productname'];
            $punit = $row2['unit'];
            $pquantity = $row2['quantity'];
            $sql = "SELECT id, stock FROM product WHERE type = (SELECT id FROM type WHERE name = '$stype' AND company = '".$_SESSION['company']."') AND name = '$pname' AND unit = (SELECT id FROM unit WHERE name = '$punit' AND company = '".$_SESSION['company']."')";
            $result2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result2);
            $squantity = $row2['stock'];
            $psid= $row2['id'];


            $sql = "UPDATE product SET stock = '$squantity' - '$pquantity' WHERE id = '$psid'";
            if (mysqli_query($conn, $sql)) {}
            

        }

        $sql = "UPDATE invoiceout SET  confirm = 1, paymentmethod = '$paymentmethod', remarks = '$remarks' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'outlist.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    if (isset($_GET['saveon'])) {
        $id = $_GET['id'];
        $paymentmethod = $_GET['paymentmethod'];
        $remarks = $_GET['remarks'];

        $sql = "UPDATE invoiceout SET paymentmethod = '$paymentmethod', remarks = '$remarks' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'outlist.php';</script>";
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
                                <select class="form-select border-0 select2" id="name" name="name">
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM invoiceout WHERE id = '$id'";
                                        $result = mysqli_query($conn, $sql);
                                        if ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option  selected>".$row['person']."</option>";
                                        }
                                    } else {
                                        echo "<option value='-' selected>Example: Kowshique Roy Babu Para, Nilphamari 01632950179 4322</option>";
                                    }
                                    ?>
                                    <?php
                                    $sql = "SELECT * FROM person WHERE company = '".$_SESSION['company']."' order by name DESC";
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
                                    $sql = "SELECT date FROM invoiceout WHERE id = '$id'";
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
                                        $sql = "SELECT status FROM invoiceout WHERE id = ".$_GET['id'];
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $selectedStatus = $row['status'];
                                    } else {
                                        $selectedStatus = 0;
                                    } ?>
                                    <option value="0" <?php echo $selectedStatus == 0 ? 'selected' : ''; ?>>OUT</option>
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
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-2">
                                   
                                    <input type="number" class="form-control border-0" id="barcode" name="barcode" placeholder="Barcode" onkeydown="if(event.keyCode==13){this.form.submit();}">
                                    <script>
                                        const barcodeInput = document.getElementById('barcode');
                                        barcodeInput.addEventListener('keypress', function(e) {
                                            if (e.keyCode == 13) {
                                                e.preventDefault();
                                                this.form.submit();
                                            }
                                        });
                                    </script>
                                </div>
                                <div class="col-md-3 prf">
                                    <select class="form-select border-0 select2n" id="type" name="type" onChange="this.form.submit()" required>
                                        <option value="">Select Type</option>
                                        <?php


                                        if (isset($_GET['type'])) {
                                            $selectedType = $_GET['type'];
                                            echo "<option value='$selectedType' selected>".$selectedType."</option>";
                                        }








                                            $sql = "SELECT DISTINCT type FROM product WHERE company = '".$_SESSION['company']."' ORDER BY type ASC";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $typeName = $row['type'];
                                                $typeSql = "SELECT name FROM type WHERE id = '$typeName'";
                                                $typeResult = mysqli_query($conn, $typeSql);
                                                $typeRow = mysqli_fetch_assoc($typeResult);
                                                echo "<option>".$typeRow['name']."</option>";



                                               
                                               
                                           
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 prf">
                                    <select class="form-select border-0 select2n" id="pname" name="name" onChange="this.form.submit()" required>
                                        <option value="">Select Product Name</option>
                                        <?php
                                            if (isset($_GET['type'])) {
                                                $typeSql = "SELECT id FROM type WHERE name = '".$_GET['type']."' AND company = '".$_SESSION['company']."'";
                                                $typeResult = mysqli_query($conn, $typeSql);
                                                $typeRow = mysqli_fetch_assoc($typeResult);
                                                $typeId = $typeRow['id'];
                                                $sql = "SELECT DISTINCT name FROM product WHERE type = '$typeId' AND company = '".$_SESSION['company']."' ORDER BY name ASC";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $productName = $row['name'];
                                                    echo "<option value='".$productName."' ".(isset($_GET['name']) && $_GET['name'] == $productName ? 'selected' : '').">".$productName."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1 prf">
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
                                                    echo "<option  selected readonly>".$unitRow['name']."</option>";
                                                } else {
                                                    foreach ($units as $unit) {
                                                        $unitSql = "SELECT name FROM unit WHERE id = '".$unit['unit']."'";
                                                        $unitResult = mysqli_query($conn, $unitSql);
                                                        $unitRow = mysqli_fetch_assoc($unitResult);
                                                        echo " <option value=''>Select Unit</option> <option  ".(isset($_GET['unit']) && $_GET['unit'] == $unit['unit'] ? 'selected' : '').">".$unitRow['name']."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="costprice" class="form-label">Get Price</label>
                                    <input type="text" class="form-control" id="costprice" name="costprice" placeholder="" required readonly onclick="getLastCostPrice();">
                                </div>


                                <div class="col-md-2">
                                    <label for="sellprice" class="form-label">Sell Price</label>
                                    <input type="number" step="0.01" class="form-control" id="sellprice" name="sellprice" placeholder="Sell Price" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks">
                                </div>

                                <div class="col-md-2 text-end">
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <button class="btn btn-success border-0" name="add" type="submit">Add</button>
                                </div>
                            </div>
                        </form>
                      
                        <script>





                  
                            document.getElementById('barcode').addEventListener('input', function() {
                                var barcode = this.value;
                                fetch(`barcodeget.php?id=${barcode}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data) {

                                            console.log('API Response:', data);
                                            document.getElementById('type').innerHTML = `<option value="${data.type}" selected>${data.type}</option>`;
                                            document.getElementById('pname').innerHTML = `<option value="${data.productname}" selected>${data.productname}</option>`;
                                            document.getElementById('unit').innerHTML = `<option value="${data.unit}" selected>${data.unit}</option>`;
                                           

                                        



                                           
                                           
                                           
                                            document.getElementById('costprice').value = data.costprice.toString().split('').map(digit => {
                                                switch (digit) {
                                                    case '0': return 'A';
                                                    case '1': return 'B';
                                                    case '2': return 'C';
                                                    case '3': return 'D';
                                                    case '4': return 'E';
                                                    case '5': return 'F';
                                                    case '6': return 'G';
                                                    case '7': return 'H';
                                                    case '8': return 'I';
                                                    case '9': return 'j';
                                                }
                                            }).join('');
                                            document.getElementById('sellprice').value = data.sellprice;
                                            if (data.stock <= 0) {
                    document.getElementById("remarks").style.backgroundColor = 'red';


                    document.getElementById("remarks").placeholder = data.stock + ' Stock Available';
                } else {
 document.getElementById("remarks").style.backgroundColor = 'white';
                    document.getElementById("remarks").placeholder = data.stock + ' Stock Available';     
                
                }
                                        } else {
                                            document.getElementById('costprice').value = '';
                                            document.getElementById("sellprice").value = '';
                                            document.getElementById("remarks").placeholder = '';

                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        
                                    });
                            });
                        </script>
<script>
    function getLastCostPrice() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 console.log("Raw Response:", this.responseText); 
                var response = JSON.parse(this.responseText);
                document.getElementById('costprice').value = response.costprice.toString().split('').map(digit => {
                                                switch (digit) {
                                                    case '0': return 'A';
                                                    case '1': return 'B';
                                                    case '2': return 'C';
                                                    case '3': return 'D';
                                                    case '4': return 'E';
                                                    case '5': return 'F';
                                                    case '6': return 'G';
                                                    case '7': return 'H';
                                                    case '8': return 'I';
                                                    case '9': return 'j';
                                                }
                                            }).join('');
                document.getElementById("sellprice").value = response.sellprice;

                if (response.stock <= 0) {
                    document.getElementById("remarks").style.backgroundColor = 'red';
                    document.getElementById("remarks").placeholder = response.stock + ' Stock Available';
                } else {
 document.getElementById("remarks").style.backgroundColor = 'white';
                    document.getElementById("remarks").placeholder = response.stock + ' Stock Available';     
                
                }
                console.log(response);
            }
            else {
                document.getElementById('costprice').value = '';
                document.getElementById("sellprice").value = '';
                document.getElementById("remarks").placeholder = '';

            }
        };



        var pname = document.getElementById("pname").value;
        var type = document.getElementById("type").value;
        var unit = document.getElementById("unit").value;
        var barcode = document.getElementById("barcode").value;

        xhttp.open("GET", `lastcostprice.php?name=${pname}&type=${type}&unit=${unit}&id=${barcode}`, true);
       
       
        xhttp.send();
    }
</script>


                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                  
                                    <th>Type</th>
                                    <th>Product Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT po.id, po.type, po.productname, po.unit, po.quantity, po.price, po.remarks FROM productout po JOIN invoiceout io ON po.personid = io.id WHERE io.id = '$id' ORDER BY po.id DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity'] * $row['price']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td>
                                        <a href="outadd.php?id=<?php echo $id; ?>&delid=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                                <tr>
                                    <td colspan="6" class="text-end">Sub Total</td>
                                    <td colspan="2"><b><?php
                                        $sql = "SELECT totalprice FROM invoiceout WHERE id = '$id'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo number_format($row['totalprice'], 2);
                                    ?></b></td>
                                </tr>

                            </tbody>
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


