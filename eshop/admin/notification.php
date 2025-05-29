<?php
require_once '../conn.php';

$sql = "SELECT * FROM outdetails ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row['type'] == 0 && strpos($row['session_id'], 'Ordered') !== false) {
    

    echo '1';
} else {
    echo '0';
}
?>

