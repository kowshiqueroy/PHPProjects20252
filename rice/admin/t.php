<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Home</div>

<?php
echo $_SESSION['username'];
echo $_SESSION['id'];
echo $_SESSION['role'];
echo $_SESSION['rolename'];
?>
<?php
require_once 'footer.php';
?>