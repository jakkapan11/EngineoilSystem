<?php

session_start();
include_once("config/etc_funct_admin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('config/connect.php');

            //              ชื่อ Table ใน DB
    $sql_update  = "UPDATE customers SET 
		        cus_name	            = '" . $_POST['cus_name'] . "',
                cus_birthday            = '" . tochristyear($_POST['cus_birthday']) . "',
                cus_phone               = '" . $_POST['cus_phone'] . "',
                cus_email               = '" . $_POST['cus_email'] . "',
                cus_address             = '" . $_POST['cus_address'] . "',
                cus_zipcode             = '" . $_POST['cus_zipcode'] . "',
                cus_status              = '" . $_POST['cus_status'] . "'  WHERE cus_id = '" . $_POST['cus_id'] . "'";
}

            // ชื่อ Field ใน DB                 ชื่อ textfield จากฟอร์มหน้าก่อนหน้า             รหัส pk         ชือ่ textfield form หน้ก่อนหน้า


if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo '<script> alert("แก้ไขข้อมูลเรียบร้อยแล้ว\nรหัสสมาชิก '. $_POST['cus_id']. '"); 
    window.location.assign("show_member.php")
    </script>';
}
