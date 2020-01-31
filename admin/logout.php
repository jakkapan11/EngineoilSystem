<?php
    session_start();

    unset($_SESSION['emp_id']);
    unset($_SESSION['emp_username']);
    unset($_SESSION['emp_level']);

    //session_destroy();
    
    echo "<script> alert('ออกจากระบบเรียบร้อย');window.location.assign('login.php') </script>";
?>