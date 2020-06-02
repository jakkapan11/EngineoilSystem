<?php

session_start();
include_once("conf/etc_funct.php");

if (!isset($_SESSION['cus_username'])) {
    echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('conf/connection.php');
    $password        =    trim($_POST['cus_password']);
    
    if ($password != $_POST['cus_password2']) {
        echo "<script> alert('รหัสผ่านไม่ตรงกัน');window.location.assign('profile.php')</script>";
        exit();
    }

    if ($password == "" && $_POST['cus_password2'] == "") {
        $sql_update  = "UPDATE customers SET 
		        cus_name	            = '" . $_POST['cus_name'] . "',
                cus_birthday            = '" . tochristyear($_POST['cus_birthday']) . "',
                cus_phone               = '" . $_POST['cus_phone'] . "',
                cus_email               = '" . $_POST['cus_email'] . "',
                cus_address             = '" . $_POST['cus_address'] . "',
                cus_zipcode             = '" . $_POST['cus_zipcode'] . "',
                cus_username            = '" . $_POST['cus_username'] . "' WHERE cus_id = '" . $_SESSION['cus_id'] . "'";
    } else {
      
        $sql_update  = "UPDATE customers SET 
    cus_name	            = '" . $_POST['cus_name'] . "',
    cus_birthday            = '" . tochristyear($_POST['cus_birthday']). "',
    cus_phone               = '" . $_POST['cus_phone'] . "',
    cus_email               = '" . $_POST['cus_email'] . "',
    cus_address             = '" . $_POST['cus_address'] . "',
    cus_zipcode             = '" . $_POST['cus_zipcode'] . "',
    cus_username            = '" . $_POST['cus_username'] . "',
    cus_password            = '" . $_POST['cus_password'] . "' WHERE cus_id = '" .  $_SESSION['cus_id'] . "' ";
    }
    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
        echo '<script> alert("แก้ไขข้อมูลสมาชิกเรียบร้อยแล้ว\nรหัสสมาชิก '. $_SESSION['cus_id'].'"); 
        window.location.assign("index.php")
        </script>';
    }
}
