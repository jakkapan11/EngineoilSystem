<?php
session_start();
if (isset($_POST)) {
    $i = 0;

    foreach ($_SESSION['strqty'] as $key) {
        //    echo $i;
        $_SESSION['strqty'][$i] = $_POST['qty_' . $i];
        $i++;
    }
    //$_SESSION['message'] = 'Cart updated successfully';
    echo "<script> window.location.assign('basket.php');</script>";
}
