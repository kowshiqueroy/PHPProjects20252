<?php
require_once("../conn.php");

if (!isset($_GET["idall"]) OR empty($_GET["idall"])) {
    echo "<div style='text-align: center;'>ID Not Found</div>";
    exit;
}

$ids = explode(",", $_GET["idall"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Invoices</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            width: 95%;
        }

        .invoice-header, .invoice-footer {
            text-align: center;
            padding: 10px 20px;
        }

        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
              width: 95%;
              margin: 5px auto;
        }

        .invoice-header img {
            max-width: 100px; /* Smaller logo for compactness */
            margin-right: 10px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 24px; /* Smaller font size for compactness */
        }

        .invoice-details, .invoice-items, .signature-block {
            width: 95%;
              margin: 5px auto;
            padding: 0 5px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px; /* Smaller font size for compactness */
            margin-top: 2px;
        }
        .invoice-billto {

    text-align: center;
    font-size: 14px; /* Smaller font size for compactness */
    margin-top: 20px;


            font-size: 14px; /* Smaller font size for compactness */
            margin-top: 20px;
        }

        .invoice-items table, .invoice-summary table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        .invoice-items th, .invoice-items td, .invoice-summary th, .invoice-summary td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px; /* Smaller font size for compactness */
        }

        .signature-block {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-bottom: 60px; /* Space for signatures */
        }

        .signature {
            border-top: 1px solid #000;
            text-align: center;
            margin-top: 40px;
            padding-top: 5px;
            flex-basis: 30%;
        }

        @media print {
            body, .invoice{
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .no-print, .print-hidden {
                display: none;
            }

            .invoice {
                page-break-after: always;
            }

            .invoice:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>

<div class="no-print print-hidden" style="display: flex; justify-content: space-between; align-items: center;">
    <div style="margin-left: 10px;">
        <button type="button" class="no-print print-hidden"
            style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;"
            onclick="window.location.href='orders.php'">Go to Orders</button>
    </div>
    <button class="no-print print-hidden"
            style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;" 
            onclick="window.print()">Print Invoice</button>
</div>



<?php
$sql = "SELECT * FROM companyinfo WHERE id = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $companyname = htmlspecialchars($row['companyname']);
    $tagline = htmlspecialchars($row['tagline']);
    $address = htmlspecialchars($row['address']);
    $phone = htmlspecialchars($row['phone']);
    $logo = htmlspecialchars($row['logo']);
    $email = htmlspecialchars($row['email']);
} else {
    $companyname = "";
    $tagline = "";
    $address = "";
    $phone = "";
    $logo = "";
     $email = "";
}
?>








<?php foreach ($ids as $id): ?>
    <div class="invoice">
        <div class="invoice-header">
            <img src="<?= $logo ?>" alt="Company Logo">
            <h1><?= $companyname ?></h1>
           
        </div>

        <div class="invoice-details">
            <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($address) ?></p>
            <p><i class="fas fa-phone"></i> <?= htmlspecialchars($phone) ?></p>
            <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($email) ?></p>
            
        
        </div>
        <div class="invoice-details">
             <p>Invoice #: orderdate -<?= htmlspecialchars($id) ?></p>
             <p>Route: route serial</p>
            <p>Date: <?= date("Y-m-d") ?></p>
            
        
        </div>
        <div class="invoice-billto">
                <strong>Bill To: fjhfgjhfgg</strong> 
               
            </div>
        <br>
        <div class="invoice-items">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr> <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <!-- More Items -->
                </tbody>
            </table>
        </div>
        <div class="invoice-summary">
            <table>
                <tr>
                    <th>Total:</th>
                    <td>$100.00</td>
                </tr>
            </table>
        </div>
        <div class="invoice-footer">
            <p>Thank you for your business!</p>
        </div>
        <div class="signature-block ">
            <div class="signature">
                Authorized Signature
            </div>
            <div class="signature">
                Date
            </div>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>