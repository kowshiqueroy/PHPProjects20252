<?php
include 'header.php';
?>



<div class="container-fluid py-5">



  <div class="row">
    <div class="col-md-6">
      <?php
      $sql = "SELECT SUM(totalprice) AS totalin FROM invoicein WHERE company = '".$_SESSION['company']."' AND confirm = 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $totalin = $row['totalin'] ? $row['totalin'] : 0;
      ?>
      <h3>Total Invoices In Cost: <?php echo number_format($totalin, 2) ?></h3>
    </div>
    <div class="col-md-6">
      <?php
      $sql = "SELECT SUM(totalprice) AS totalout FROM invoiceout WHERE company = '".$_SESSION['company']."' AND confirm = 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $totalout = $row['totalout'] ? $row['totalout'] : 0;
      ?>
      <h3>Total Invoices Out Sells: <?php echo number_format($totalout, 2) ?></h3>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <?php
      $sql = "SELECT COUNT(*) AS totalin FROM invoicein WHERE company = '".$_SESSION['company']."' AND confirm = 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $totalin = $row['totalin'] ? $row['totalin'] : 0;
      ?>
      <h3>Total Invoices In: <?php echo number_format($totalin) ?></h3>
    </div>
    <div class="col-md-6">
      <?php
      $sql = "SELECT COUNT(*) AS totalout FROM invoiceout WHERE company = '".$_SESSION['company']."' AND confirm = 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $totalout = $row['totalout'] ? $row['totalout'] : 0;
      ?>
      <h3>Total Invoices Out: <?php echo number_format($totalout) ?></h3>
    </div>
  </div>

</div>

<?php

include 'footer.php';
?>