<?php

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['intline'])) {

    unset($_SESSION['intline']);
    unset($_SESSION['product_id']);
    unset($_SESSION['strqty']);

    echo "<script> alert('ล้างตะกร้าเรียบร้อย'); window.location.assign('basket.php')</script>";
   
} else {
    echo "<script> alert('ล้างตะกร้าเรียบร้อย'); window.location.assign('basket.php')</script>";
}
?>