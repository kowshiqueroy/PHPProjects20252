<?php
    require_once("../conn.php");

    if(!isset($_GET["idall"]) OR empty($_GET["idall"])){
        echo "<div style='text-align: center;'>ID Not Found</div>";
      exit;

    }

?>
    <style>
        .no-print {
            display: block;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <div class="no-print" style="text-align: center;">
        <button type="button" class="btn btn-secondary" style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;" onclick="window.location.href='orders.php'">Go to Orders</button>
    </div>
    <hr class="no-print">
<?php
    $ids=$_GET["idall"];
     $productNamesall = array();
              $productQuantitiesall = array();
              $grandAmount=0.00;

    $ids=explode(",", $ids);
    foreach($ids as $id){
       echo "<br>";

?>
    <style>
        @page {
            size: A4;
        }
    </style>
<?php

             
    $sql = "SELECT * FROM orders WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div style='display: flex; justify-content: space-between; overflow-y: auto; max-height: 200px'>";
            echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
            echo "<p><strong></strong> " . $row['order_date'] . " <> ". $row['delivery_date'] . "</p>";
            $routeResult = $conn->query("SELECT route_name FROM routes WHERE id = '" . $row['route_id'] . "'");
            if ($routeResult->num_rows > 0) {
                $routeRow = $routeResult->fetch_assoc();
                echo "<p><strong>Route: </strong> " . $routeRow['route_name'] . "</p>";
            }
            echo "<p>(" . $row['order_serial'] . ")</p>";

            $personResult = $conn->query("SELECT person_name FROM persons WHERE id = '" . $row['person_id'] . "'");
            if ($personResult->num_rows > 0) {
                $personRow = $personResult->fetch_assoc();
                echo "<p><strong>Shop:</strong> " . $personRow['person_name'] . "</p>";
            }
            echo "</div>";
          
        }
    }
     
                $productNames = array();
                $productQuantities = array();

                 $totalQuantity = 0;
                 $totalTotal = 0;
                $result = $conn->query("SELECT * FROM order_product WHERE order_id = '$id'");
                echo "<div style='display: flex; flex-wrap: wrap; justify-content: center;'>";
                while($row = $result->fetch_assoc()) {
                    echo "<div style='border: 1px solid #ddd; margin: 2px; padding: 2px; width: auto; text-align: center;'>";
                    $sql2 = "SELECT product_name FROM products WHERE id = '" . $row['product_id'] . "'";
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    echo "<p style='padding-left: 10px; padding-right: 10px;'><strong>" . $row2['product_name'] . "</strong>  " . $row['quantity'] . " X " . $row['price'] . " = " . $row['total'] . "/=</p>";
                    echo "</div>";
                        $totalQuantity += $row['quantity'];
                         $totalTotal += $row['total'];
                    if (!in_array($row2['product_name'], $productNames)) {
                            $productNames[] = $row2['product_name'];
                            $productQuantities[$row2['product_name']] = $row['quantity'];
                        } else {
                            $productQuantities[$row2['product_name']] += $row['quantity'];
                        }

                        if (!in_array($row2['product_name'], $productNamesall)) {
                            $productNamesall[] = $row2['product_name'];
                            $productQuantitiesall[$row2['product_name']] = $row['quantity'];
                        } else {
                            $productQuantitiesall[$row2['product_name']] += $row['quantity'];
                        }
                }
                echo "</div>";

                  echo '<p style="text-align: center;">' . count($productNames) . ' Unique Products Quantity: ' . $totalQuantity . ' Amount: ' . $totalTotal . '/= ';
    $grandAmount+=$totalTotal;
    echo '';
    foreach ($productNames as $productName) {
        echo $productName . ': ' . $productQuantities[$productName] . ' ';
    }
    echo '</p>';

         echo "<hr>";

?>





<?php



    }

  echo '<p style="text-align: center;">' . count($productNamesall) . ' Unique Products Total Amount: ' . $grandAmount . '/= ';
    foreach ($productNamesall as $productNameall) {
        echo $productNameall . ': ' . $productQuantitiesall[$productNameall] . ' ';
    }
    echo '</p>';
?>
