<?php

session_start();
include_once("config/etc_funct_admin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('config/connect.php');
    $phone = $_POST['cus_phone'];
    
    $chk_phone	= mysqli_query($link, "SELECT * FROM customers WHERE cus_phone = '" . $phone . "' AND cus_id != '" . $_POST['cus_id'] . "'");
        if (mysqli_num_rows($chk_phone) > 0) {
		echo "<script> alert('เบอร์โทรศัพท์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}



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
    echo '<script> alert("แก้ไขข้อมูลสมาชิกเรียบร้อยแล้ว\nรหัสสมาชิก '. $_POST['cus_id']. '"); 
    window.location.assign("show_member.php")
    </script>';
}
