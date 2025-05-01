<?php

include '../conn.php';
$sql = "SELECT company FROM company WHERE id = '".$_SESSION['company']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$company = $row['company'];


if (isset($_GET['id']) && isset($_GET['type'])) {
    $person= $_GET['id'];
    $type = $_GET['type'];

    $sql = "SELECT id, type, productname,unit, quantity,sellprice FROM productin WHERE personid = '$person'";
   $result = mysqli_query($conn, $sql);

echo '<body style="width: 1000px; height: 100%; margin: 0; padding: 0;"><div class="barcodes" style="text-align:right; ">';
while ($row = mysqli_fetch_assoc($result)) {
    $barcodeData = str_pad($row['id'], 8, '0', STR_PAD_LEFT);
    $quantity = $row['quantity'];
    echo '<div class="barcode">';
    echo '<p style="text-decoration: underline; font-weight: bold; font-size: 10px;">'.$row['productname']. 'Code:'.$row['id'].' Q:'.$row['quantity'].'</p><br>';
    for ($i = 0; $i < $quantity; $i++) {
        echo '<div class="barcode-item" style="margin-bottom: 35px;  objet-align: right;">';
        echo '<img  src="https://barcode.tec-it.com/barcode.ashx?data=' . urlencode($barcodeData) . '&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=png&rotation=0&color=000000&bgcolor=FFFFFF&qunit=Mm&quiet=0&font=Arial&fontsize=14&fontstyle=regular&fontencodings=Auto&fontaspectratio=1&fontxscale=1&fontyscale=1&fontboldscale=1&showhg=0&showscan=0&showtext=1&showchecksum=0&textxalign=Left&textyalign=Top&textfontaspectratio=1&textxscale=1&textyscale=1&textboldscale=1&textfontencodings=Auto&textfont=Arial&textfontsize=14&textfontstyle=regular&textfontboldscale=1&borderw=0&bordercolor=000000&backgroundcolor=FFFFFF&backgroundopacity=0&errorcorlvl=L&addcheckdigit=0" alt="" title="" />';
      
            
      if ($type == 2) {
        echo '<div style="float: right; width: 100px; text-align: center;"><p style=" font-size: 12px;margin-top:5px;text-align: center;">' . $row['productname'] . '<br>Price:'.  $row['sellprice'].'/=<br>' . $company . '</p></div>';
      }
       
        echo '</div>';
    }

    echo '</div>';
}
echo '</div> </body>';
}

// $sql = "SELECT id, type, productname FROM productin";

?>



