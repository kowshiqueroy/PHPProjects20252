<?php
require_once '../conn.php';
$date= $_GET['selected'];
?>

<table class="table">
    <thead class="table-dark">
        <tr><th>ID</th><th>Session ID</th><th>Hits</th><th>Created At</th><th>Updated At</th></tr>
    </thead>
    <tbody>
        <?php

        if($date == 'all'){
            $sql = "SELECT * FROM visitors ORDER BY id DESC";
        }else{
            $sql = "SELECT * FROM visitors WHERE updated_at >= CURDATE()  ORDER BY id DESC";
        }
            
            $result = $conn->query($sql);
            $totalSessions = 0;
            $totalHits = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['session_id'] . "</td><td>" . $row['hits'] . "</td><td>" . $row['created_at'] . "</td><td>" . $row['updated_at'] . "</td></tr>";
                    $totalSessions++;
                    $totalHits += $row['hits'];
                }
                echo "<tr><td colspan='2' style='font-weight: bold;'>".$totalSessions."</td><td style='font-weight: bold;'>" . $totalHits . "</td><td colspan='2'></td></tr>";
            }
        ?>
    </tbody>
</table>
