<?php

    session_start();
    if ((!isset($_SESSION['emp_id']) )) {
    
    }

    if (isset($_GET['category_id']))

    require_once('config/connect.php');

    if (mysqli_query($link, "DELETE FROM category WHERE category_id = '" . $_GET['category_id'] . "' ")) {
        echo "<script> alert('ลบข้อมูลเรียบร้อยของรหัสปะเภทสินค้า". $_GET['category_id']."'); window.location.assign('show_category.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_category.php')</script>";
    }