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
            width: 90vw;
            margin: 0 auto;
            background-color: #f2f2f2;
        }
        .container {
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            
            border-radius: 10px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            max-height: 200px;
            width: 200px;
        }
        .header .company-info {
            text-align: center;
            flex: 1;
        }
        .header .company-info h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .header .company-info p {
            font-size: 12px;
            margin: 0;
        }
        .header .qr {
            max-height: 100px;
            width: 200px;
            text-align: right;
        }
        .header .qr img {
            height: 100px;
            width: 100px;
        }
        
        .invoice {
            margin-top: 0px;
        }
        .invoice .details{

            width: 100%;
            
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
                <img src="https://www.ovijatfood.com/images/logo.png" alt="logo">
                <div class="company-info">
                    <h1>Company Name</h1>
                    <p>Address</p>
                    <p>Contact</p>
                </div>

                <div class="qr">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" alt="" >

                </div>

            </div>
            <div class="invoice">
                

                <div class="details" style="text-align: center;">
                    <div style="text-align: left; display: inline-block; width: 30%; ">Drafted by Userjagdgasd<br>2022-01-01 12:00:00</div>
                    <div style="  text-align: center; display: inline-block; width: 30%; "><h3>INVOICE <?php echo $_GET['id']; ?></h3></div>
                    <div style="text-align: right; display: inline-block; width: 30%;">Date: 2025-01-01<br>Back</div>
                </div>
                <div style=" margin-top: -20px; text-align: center;"><h3>Customer: Example Customer with Address and Contact xxxxx</h3></div>
               
               
               
                <table class="table table-hover table-bordered mt-3">
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
                            <td class="text-end">Total</td>
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

