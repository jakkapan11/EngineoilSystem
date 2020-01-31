<?php

session_start();
include_once("config/etc_funct_admin.php");

if (!isset($_SESSION['emp_username'])) {
    echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('config/connect.php');

            //              ชื่อ Table ใน DB
    $sql_update  = "UPDATE employee SET 
		        emp_name	            = '" . $_POST['emp_name'] . "',
                emp_birthday            = '" . tochristyear($_POST['emp_birthday']) . "',
                emp_phone               = '" . $_POST['emp_phone'] . "',
                emp_email               = '" . $_POST['emp_email'] . "',
                emp_address             = '" . $_POST['emp_address'] . "',
                emp_idcard              = '" . $_POST['emp_idcard'] . "',
                emp_level               = '" . $_POST['emp_level'] . "',
                emp_status              = '" . $_POST['emp_status'] . "'  WHERE emp_id = '" . $_POST['emp_id'] . "' ";
}

            // ชื่อ Field ใน DB                 ชื่อ textfield จากฟอร์มหน้าก่อนหน้า             รหัส pk         ชือ่ textfield form หน้ก่อนหน้า


if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo '<script>
     alert("แก้ไขข้อมูลเรียบร้อยแล้ว\nรหัสพนักงาน '. $_POST['emp_id']. '"); 
     window.location.assign("show_employee.php")
     </script>';
}
