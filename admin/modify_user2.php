<?php

session_start();
include_once("config/etc_funct_admin.php");

if (!isset($_SESSION['emp_username'])) {
    echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('config/connect.php');
    $password        =    trim($_POST['emp_password']);
    $idcard          = $_POST['emp_idcard'];
    
    if ($password != $_POST['emp_password2']) {
        echo "<script> alert('กรอกรหัสผ่านไม่ตรงกัน');window.location.assign('modify_user.php')</script>";
        exit();
    }
    
    $chk_idcard	= mysqli_query($link, "SELECT * FROM employee WHERE emp_idcard = '" . $idcard . "' AND emp_id != '" . $_POST['emp_id'] . "'");
    
    if (mysqli_num_rows($chk_idcard) > 0) {
		echo "<script> alert('หมายเลขบัตรประชาชนถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}
    if ($password == "" && $_POST['emp_password2'] == "") {
        $sql_update  = "UPDATE employee SET 
		        emp_name	            = '" . $_POST['emp_name'] . "',
                emp_birthday            = '" . tochristyear($_POST['emp_birthday']) . "',
                emp_phone               = '" . $_POST['emp_phone'] . "',
                emp_email               = '" . $_POST['emp_email'] . "',
                emp_address             = '" . $_POST['emp_address'] . "',
                emp_idcard              = '" . $_POST['emp_idcard'] . "',
                emp_username            = '" . $_POST['emp_username'] . "' WHERE emp_id = '" . $_SESSION['emp_id'] . "'";
    } else {
      
        $sql_update  = "UPDATE employee SET 
    emp_name	            = '" . $_POST['emp_name'] . "',
    emp_birthday            = '" . tochristyear($_POST['emp_birthday']) . "',
    emp_phone               = '" . $_POST['emp_phone'] . "',
    emp_email               = '" . $_POST['emp_email'] . "',
    emp_address             = '" . $_POST['emp_address'] . "',
    emp_idcard              = '" . $_POST['emp_idcard'] . "',
    emp_username            = '" . $_POST['emp_username'] . "',
    emp_password            = '" . $_POST['emp_password'] . "' WHERE emp_id = '" .  $_SESSION['emp_id'] . "' ";
    }
    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
        echo '<script> 
        alert("แก้ไขข้อมูลผู้ใช้เรียบร้อยแล้ว\nรหัสพนักงาน '. $_SESSION['emp_id']. '"); 
        window.location.assign("index.php")
        </script>';
    }
}
