<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Home</div>


<form method="GET" action="" class="d-md-flex flex-md-row flex-column">
    <div class="form-group mr-md-2 mb-2 mb-md-0">
        <label for="from">From Date:</label>
        <input type="date" name="from" id="from" class="form-control" value="<?php echo isset($_GET['from']) ? $_GET['from'] : ''; ?>">
    </div>
    <div class="form-group mr-md-2 mb-2 mb-md-0">
        <label for="to">To Date:</label>
        <input type="date" name="to" id="to" class="form-control" value="<?php echo isset($_GET['to']) ? $_GET['to'] : ''; ?>">
    </div>
    <div class="form-group mr-md-2 mb-2 mb-md-0">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
    </div>
    <div class="form-group mb-2 mb-md-0">
        <label for="person">Person Name:</label>
        <input type="text" name="person" id="person" class="form-control" value="<?php echo isset($_GET['person']) ? $_GET['person'] : ''; ?>">
    </div>
    <div class="form-group mb-2 mb-md-0">
        <button type="submit" class="btn btn-primary mt-3 mt-md-0">Search</button>
        <button type="button" class="btn btn-primary mt-3 mt-md-0" onclick="window.location.href='innew.php'">Add New</button>
    </div>
</form>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Person</th>
            <th>Details</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $where = "";
        if (!empty($_GET['from'])) $where .= " AND purchase_date >= '" . $_GET['from'] . "'";
        if (!empty($_GET['to'])) $where .= " AND purchase_date <= '" . $_GET['to'] . "'";
        if (!empty($_GET['id'])) $where .= " AND id = '" . $_GET['id'] . "'";
        if (!empty($_GET['person'])) $where .= " AND person_id LIKE '%" . $_GET['person'] . "%'";

        $sql = "SELECT * FROM indetails WHERE 1=1" . $where . " ORDER BY purchase_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['purchase_date'] . "</td><td>" ;
                
                $sql2 = "SELECT details FROM person WHERE id = '".$row['person_id']."'";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    echo $row2['details'];
                }
                
                
                
                echo "</td><td>".($row['type'] == 0 ? " (In)" : " (Back)") . " ".$row['quantity']." ".$row['total']."/= " .$row['payment_method']." ".$row['payment_details']." ". $row['remarks'] .  "</td><td>";
                if ($row['type'] == 0) {
                    echo "<a href='innew.php?id=".$row['id']."' class='btn btn-primary'>Edit</a>";
                }
                echo "<a href='inprint.php?id=".$row['id']."' class='btn btn-success'>Print</a></td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        ?>
    </tbody>
</table>




<?php
require_once 'footer.php';
?>