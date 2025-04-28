<?php
    session_start();
    session_destroy();
    echo '<div style="text-align: center; font-size: 24px; color: red;">Logging out...</div>';
    echo '<br><br><div style="text-align: center; font-size: 40px; color: green;">PoSStore</div>';

    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
?>