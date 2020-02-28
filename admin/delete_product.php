<?php

    session_start();
    if ((!isset($_SESSION['emp_id']) )) {
    
    }

    if (isset($_GET['product_id']))

    require_once('config/connect.php');

    if (mysqli_query($link, "DELETE FROM product WHERE product_id = '" . $_GET['product_id'] . "' ")) {
        echo '<script> alert("ลบข้อมูลสินค้าเรียบร้อยแล้ว\nรหัสสินค้า '. $_GET['product_id']. '"); 
        window.location.assign("show_product.php")
        </script>';
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_product.php')</script>";
    }