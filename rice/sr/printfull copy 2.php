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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .invoice {
            background-color: #ffffff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        
        .invoice-header, .invoice-footer {
            text-align: center;
            padding: 20px;
        }

        .invoice-header img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .invoice-details, .invoice-items {
            width: 100%;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .invoice-items th, .invoice-items td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .invoice-summary {
            text-align: right;
        }

        .invoice-summary table {
            width: auto;
            margin-left: auto;
            border-top: 2px solid #000;
        }

        .invoice-summary th, .invoice-summary td {
            padding: 8px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }

            .invoice {
                box-shadow: none;
                margin: 0 auto;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align: center;">
    <button onclick="window.print()">Print Invoice</button>
</div>

<?php foreach ($ids as $id): ?>
    <div class="invoice">
        <!-- Invoice generation code goes here -->
        <!-- For example purposes, static content is shown -->
        <div class="invoice-header">
            <img src="path/to/your/logo.png" alt="Company Logo">
            <h1>Invoice</h1>
            <p>Invoice #: 12345</p>
            <p>Date: <?= date("Y-m-d") ?></p>
        </div>
        <div class="invoice-details">
            <div>
                <strong>Bill To:</strong>
                <p>Client Name</p>
              
            </div>
            <div>
                <strong>Ship To:</strong>
                <p>Recipient Name</p>
              
            </div>
        </div>
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
                    <!-- Dynamically generated rows go here -->
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <!-- More items... -->
                     <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>Item 1</td>
                        <td>1</td>
                        <td>$100.00</td>
                        <td>$100.00</td>
                    </tr>
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
    </div>
<?php endforeach; ?>

</body>
</html>