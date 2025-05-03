<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            .page {
                margin: 0;
                box-sizing: border-box;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f2f2f2;
        }
        .header .address {
            padding-left: 20px;
        }
        .header .address p {
            margin: 0;
        }
        .invoice {
            margin-top: 20px;
        }
        .invoice table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice table thead tr {
            background-color: #f2f2f2;
        }
        .invoice table td, .invoice table th {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .invoice table th:nth-child(1), .invoice table td:nth-child(1) {
            width: 60%;
            text-align: left;
        }
        .invoice table th:nth-child(2), .invoice table td:nth-child(2) {
            width: 5%;
            text-align: right;
        }
        .invoice table th:nth-child(3), .invoice table td:nth-child(3) {
            width: 10%;
            text-align: right;
        }
        .invoice table th:nth-child(4), .invoice table td:nth-child(4) {
            width: 15%;
            text-align: right;
        }
     
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page">
            <div class="header">
                <div>
                    <h1>Company name</h1>
                    <p>City, State, Zip Phone: 123-456-7890</p>
                    <p>Customer Name</p>
                </div>
                <div class="address">
                    <p>Invoice: 123</p>
                    <p><?php echo date('Y-m-d h:m:s'); ?></p>
                    <p>Status:</p>
                </div>
            </div>


            <div class="invoice">
                <table class="table table-hover  table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <td>Sample Item 1</td>
                            <td>2</td>
                            <td>15.00</td>
                            <td>30.00</td>
                        </tr>
                       
                    
                        <tr>
                            <td colspan="2" class="text-end">Taka in Words</td>
                
                            <td  class="text-end">Total</td>
                            <td>110.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="footer">
                <p>Payment Method: Cash Remarks: </p>
                <p>Signature</p>
                <p>Signature</p>
            </div>
        </div>
    </div>
</body>

