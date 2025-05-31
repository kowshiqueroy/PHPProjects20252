<?php
require_once("../conn.php");

if (!isset($_GET["idall"]) || empty($_GET["idall"])) {
    echo "<div style='text-align: center;'>ID Not Found</div>";
    exit;
}

$ids = $_GET["idall"];
$ids = explode(",", $ids);
$productNamesall = array();
$productQuantitiesall = array();
$grandAmount = 0.00;
?>

<style>
    @page {
        size: A4;
        margin: 20mm;
    }

    .invoice {
        width: 100%;
        max-width: 900px;
        padding: 20px;
        margin: auto;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        page-break-inside: avoid;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        page-break-before: always;
    }

    .header img {
        width: 100px;
        border-radius: 50%;
    }

    .company-info {
        text-align: center;
    }

    .company-info h2 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .company-info p {
        margin: 0;
        font-size: 16px;
    }

    .content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .content div {
        border: 1px solid #ddd;
        margin: 2px;
        padding: 5px;
        width: auto;
        text-align: center;
    }

    .footer {
        text-align: center;
        page-break-after: always;
    }

    .no-print {
        display: block;
    }

    @media print {
        .no-print {
            display: none;
        }

        .invoice {
            page-break-after: always;
        }
    }
</style>

<div class="no-print" style="text-align: center;">
    <button type="button" class="btn btn-secondary"
        style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;"
        onclick="window.location.href='orders.php'">Go to Orders</button>
</div>
<hr class="no-print">

<?php
foreach ($ids as $id) {
    $sql = "SELECT companyname, tagline, address, phone, logo FROM companyinfo WHERE id = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<div class="invoice">';
        echo '<div class="header">';
        echo '<img src="' . $row['logo'] . '" alt="Company Logo">';
        echo '<div class="company-info">';
        echo '<h2>' . $row['companyname'] . '</h2>';
        echo '<p>' . $row['tagline'] . '</p>';
        echo '<p>' . $row['address'] . '</p>';
        echo '<p>Phone: ' . $row['phone'] . '</p>';
        echo '</div>';
        echo '</div>';
    }

    $sql = "SELECT * FROM orders WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
            echo "<p><strong>Dates:</strong> " . $row['order_date'] . " <> " . $row['delivery_date'] . "</p>";
            
            $routeResult = $conn->query("SELECT route_name FROM routes WHERE id = '" . $row['route_id'] . "'");
            if ($routeResult->num_rows > 0) {
                $routeRow = $routeResult->fetch_assoc();
                echo "<p><strong>Route: </strong>" . $routeRow['route_name'] . "</p>";
            }

            echo "<p>(" . $row['serial'] . ")</p>";
            
            $personResult = $conn->query("SELECT person_name FROM persons WHERE id = '" . $row['person_id'] . "'");
            if ($personResult->num_rows > 0) {
                $personRow = $personResult->fetch_assoc();
                echo "<p><strong>Name:</strong> " . $personRow['person_name'] . "</p>";
            }
            echo "</div>";
        }
    }

    $productNames = array();
    $productQuantities = array();
    $totalQuantity = 0;
    $totalTotal = 0;

    $result = $conn->query("SELECT * FROM order_product WHERE order_id = '$id'");
    echo "<div class='content'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        $sql2 = "SELECT product_name FROM products WHERE id = '" . $row['product_id'] . "'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        echo "<p><strong>" . $row2['product_name'] . "</strong></p>";
        echo "<p><strong></strong> " . $row['quantity'] . " X " . $row['price'] . " = " . $row['total'] . "/=</p>";
        echo "</div>";

        $totalQuantity += $row['quantity'];
        $totalTotal += $row['total'];

        if (!isset($productQuantities[$row2['product_name']])) {
            $productQuantities[$row2['product_name']] = $row['quantity'];
        } else {
            $productQuantities[$row2['product_name']] += $row['quantity'];
        }

        if (!isset($productQuantitiesall[$row2['product_name']])) {
            $productQuantitiesall[$row2['product_name']] = $row['quantity'];
        } else {
            $productQuantitiesall[$row2['product_name']] += $row['quantity'];
        }
    }
    echo "</div>";

    echo '<p style="text-align: center;">' . count($productNames) . ' Unique Products Quantity: ' . $totalQuantity . ' Amount: ' . $totalTotal . '/=</p>';
    echo "<hr>";
    echo "</div>";
}

echo '<p style="text-align: center;"> Summary: ' . count($productQuantitiesall) . ' Unique Products Total Amount: ' . $grandAmount . '/= ';
foreach ($productQuantitiesall as $productNameall => $quantityall) {
    echo $productNameall . ': ' . $quantityall . ' ';
}
echo '</p>';
?>