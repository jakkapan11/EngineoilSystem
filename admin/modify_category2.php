<?php

session_start();
if (!isset($_SESSION['emp_username'])) {
    echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('config/connect.php');

            //              ชื่อ Table ใน DB
    $sql_update  = "UPDATE category SET 
		        category_name	        = '" . $_POST['category_name'] . "',
                category_status         = '" . $_POST['category_status'] . "'  WHERE category_id = '" . $_POST['category_id'] . "' ";
}

            // ชื่อ Field ใน DB                 ชื่อ textfield จากฟอร์มหน้าก่อนหน้า             รหัส pk         ชือ่ textfield form หน้ก่อนหน้า


if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo "<script> alert('แก้ไขข้อมูลเรียบร้อยแล้วของรหัสประเภทสินค้า". $_POST['category_id']. "'); window.location.assign('show_category.php')</script>";
}
