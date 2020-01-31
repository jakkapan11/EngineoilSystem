<?php

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['intline2'])) {

    unset($_SESSION['intline2']);
    unset($_SESSION['productid']);
    unset($_SESSION['strqty2']);

    echo "<script> alert('ล้างตะกร้าเรียบร้อย'); window.location.assign('after_basket.php')</script>";
   
} else {
    echo "<script> alert('ล้างตะกร้าเรียบร้อย'); window.location.assign('after_basket.php')</script>";
}
?>