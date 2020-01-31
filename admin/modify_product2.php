<?php

session_start();
if (!isset($_SESSION['emp_username'])) {
    echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('config/connect.php');

    if ($_FILES['product_pic']['name'] == "") {
        $sql_update  = "UPDATE product SET 
        product_name	        = '" . $_POST['product_name'] . "',
        category_id             = '" . $_POST['category_id'] . "',
        product_amount          = '" . $_POST['product_amount'] . "',
        product_price_unit      = '" . $_POST['product_price_unit'] . "',
        product_unit            = '" . $_POST['product_unit'] . "',
        product_description     = '" . $_POST['product_description'] . "',
        product_status          = '" . $_POST['product_status'] . "'  WHERE product_id = '" . $_POST['product_id'] . "' ";

        if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
            echo "<script> alert('แก้ไขข้อมูลเรียบร้อยแล้วของรหัสสินค้า". $_POST['product_id']."'); window.location.assign('show_product.php')</script>";
        } else {
            echo "<script> alert('แก้ไขข้อมูลผิดพลาด'); window.location.assign('show_product.php')</script>";
        }
    } else {
        $prd_image     =    $_FILES['product_pic']['name'];

        $sql_update  = "UPDATE product SET 
        product_name	        = '" . $_POST['product_name'] . "',
        category_id             = '" . $_POST['category_id'] . "',
        product_amount          = '" . $_POST['product_amount'] . "',
        product_price_unit      = '" . $_POST['product_price_unit'] . "',
        product_picture         = '" . "image/" . $prd_image . "',
        product_unit            = '" . $_POST['product_unit'] . "',
        product_description     = '" . $_POST['product_description'] . "',
        product_status          = '" . $_POST['product_status'] . "'  WHERE product_id = '" . $_POST['product_id'] . "' ";

        if (move_uploaded_file($_FILES['product_pic']['tmp_name'], "../image/" . $prd_image)) {
            if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
                echo "<script> alert('แก้ไขข้อมูลเรียบร้อยของรหัสสินค้า". $_POST['product_id']."'); window.location.assign('show_product.php')</script>";
            }
        } else {
            echo "<script>alert('อัพโหลดไฟล์ล้มเหลว'); window.location.assign('show_product.php');</script>";
        }
    }
}
