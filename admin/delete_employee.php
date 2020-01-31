<?php

    session_start();
    if ((!isset($_SESSION['emp_id']) || ($_SESSION['emp_level'] != 1))) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login.php')</script>";
    }

    if (isset($_GET['emp_id']))

    require_once('config/connect.php');

    if (mysqli_query($link, "DELETE FROM employee WHERE emp_id = '" . $_GET['emp_id'] . "' ")) {
        echo "<script> alert('ลบข้อมูลเรียบร้อยแล้วของรหัสพนักงาน". $_GET['emp_id']."'); window.location.assign('show_employee.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_employee.php')</script>";
    }

?>