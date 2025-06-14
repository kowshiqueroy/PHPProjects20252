<?php

include '../conn.php';
            $id = $_GET['id'];
            $sql = "SELECT * FROM invoiceout WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalprice = $row['totalprice'];
            $person = $row['person']=="-"?"............................................................................":$row['person'];
            $date = $row['date'];
            $status = $row['status'];
            $timestamp = $row['timestamp'];
            $paymentmethod = $row['paymentmethod'];
            $remarks = $row['remarks'];
            $confirm=$row['confirm'];
            $company=$row['company'];
            $user=$row['user'];

            $sql = "SELECT * FROM company WHERE id = '$company'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $companyname = $row['companyname'];
            $address = $row['address'];
            $phone = $row['phone'];
            $photo = $row['photo'];

            $user = "";
            $sql = "SELECT * FROM user WHERE id = '$user'";
            $result = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
                $user = $row['username'];
            }


function convertNumberToWords($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error('convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        if ($fraction != 0.00) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
    }

    return $string;
}

$totalpriceWords = convertNumberToWords($totalprice);

           

           
            ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVOICE <?php echo $id."/".$company; ?></title>
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
            margin: 5px 0;
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
                <?php if($photo != 'photo.jpg'){ ?>
                <img src="<?php echo $photo; ?>" alt="logo">
                <?php } ?>
                <div class="company-info">
                    <h1><?php echo $companyname; ?></h1>
                    <p><?php echo $address; ?></p>
                    <p>Phone: <?php echo $phone; ?></p>
                    <h3>INVOICE <?php echo $_GET['id']; ?></h3>
                </div>

                <div class="qr">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" alt="" >

                </div>

            </div>


           








            <div class="invoice">
                

                <div class="details" style="margin-top: 0px;">
                    <div style="float: left; width: 50%;">
                        <p><?php echo $confirm == 0 ? "Drafted" : "Created"; ?> by <?php echo $user; ?> @ <?php echo $timestamp; ?></p>
                    </div>
                    <div style="float: right; width: 50%; text-align: right;">
                        
                        <p><?php echo $status == 0 ? "Out" : "Back"; ?> Date: <?php echo $date; ?></p>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div style=" margin-top: -10px; text-align: center;"><h3><?php echo $status == 0 ? "Customer" : "Seller"; ?>: <?php echo $person; ?></h3></div>
               
               
               
                <?php
                $sql = "SELECT * FROM productout WHERE personid = '" . $_GET['id'] . "'";
                $result = mysqli_query($conn, $sql);
                ?>
                <table class="table table-hover table-bordered mt-3">
                    <thead>
                        <tr>
                            
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                           
                            echo "<td>". $sl++ .". ". $row['productname'] . "</td>";
                            echo "<td>" . $row['quantity'] . " " . $row['unit'] . "</td>";
                            echo "<td>" . $row['price'] . "/-</td>";
                            echo "<td>=" . ($row['quantity'] * $row['price']) . "/-</td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="2" style="text-align: right;" class="text-end"><?php echo $totalpriceWords; ?> Taka Only</td>
                            <td colspan="2" class="text-end"><h4 class="font-weight-bold">Total =<?php echo $totalprice; ?>/-</h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p>Payment Method: <?php echo $paymentmethod; ?> Remarks: <?php echo $remarks; ?></p>

            <div class="footer">
                <p>Receiver's Signature</p>
                <p>Company's Signature</p>
            </div>
        </div>
    </div>
</body>

