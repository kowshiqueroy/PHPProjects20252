<?php
include 'header.php';
?>

<div class="container-fluid py-5">

    <div class="row">
        <div class="col-md-12">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fromdate">From Date</label>
                            <input type="date" class="form-control" id="fromdate" name="fromdate" value="<?php echo isset($_GET['fromdate']) ? $_GET['fromdate'] : date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="todate">To Date</label>
                            <input type="date" class="form-control" id="todate" name="todate" value="<?php echo isset($_GET['todate']) ? $_GET['todate'] : date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="person">Person</label>
                            <select class="form-control" id="person" name="person">
                                <?php if (isset($_GET['person'])): ?>
                                    <option value="<?php echo $_GET['person']; ?>"><?php echo $_GET['person']; ?></option>
                                <?php endif; ?>
                                
                                <option value="">All</option>
                                <?php
                                $sql = "SELECT * FROM person WHERE company = '".$_SESSION['company']."'";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <option  <?php echo isset($_GET['person']) && $_GET['person'] == $row['id'] ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Date</th>
                        <th scope="col">Person</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM invoiceout WHERE company = '".$_SESSION['company']."' ";
                    if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
                        $sql .= " AND date BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."'";
                    }
                    else {

                        $sql .= " AND date = '".date('Y-m-d')."'";
                    }
                    if (isset($_GET['person']) && $_GET['person'] != '') {
                        $sql .= " AND person = '".$_GET['person']."'";
                    }

                    $sql .= " ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);
                    $total = 0;
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['person']; ?></td>
                            <td><?php echo $row['totalprice']; ?></td>
                            <td><?php echo $row['status'] ? 'Back' : 'Out'; ?></td>
                            <td>
                                <?php if ($row['confirm'] == 0): ?>
                                    <a href="outadd.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i></a>
                                    <a href="invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</a>
                                <?php else: ?>
                                    <a href="outadd.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                                    <a href="invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</a>
                                <?php endif; ?>
                                <a href="outlist.php?delid=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this invoiceout?');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<?php
if (isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    
    $sql = "SELECT id FROM productout WHERE personid = '$delid'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['id']."<br>";

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


        $sql = "UPDATE product SET stock = '$squantity' + '$pquantity' WHERE id = '$psid'";
        if (mysqli_query($conn, $sql)) {}
        

    }
    $sql = "DELETE FROM invoiceout WHERE id = '$delid'";
    if (mysqli_query($conn, $sql)) {
        $sql = "DELETE FROM productout WHERE personid = '$delid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href = 'outlist.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<?php

include 'footer.php';
?>

