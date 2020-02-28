<?php

    session_start();
    if ((!isset($_SESSION['emp_id']) )) {
       
    }

    if (isset($_GET['cus_id']))

    require_once('config/connect.php');

    if (mysqli_query($link, "DELETE FROM customers WHERE cus_id = '" . $_GET['cus_id'] . "' ")) {
        echo '<script> alert("ลบข้อมูลสมาชิกเรียบร้อยแล้ว\nรหัสสมาชิก '. $_GET['cus_id']. '"); 
        window.location.assign("show_member.php")
        </script>';
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_member.php')</script>";
    }

?>