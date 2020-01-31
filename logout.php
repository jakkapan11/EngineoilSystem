<?php
    session_start();

    unset($_SESSION['cus_id']);
    unset($_SESSION['cus_username']);
   

    //session_destroy();
    echo "<script> alert('ออกจากระบบเรียบร้อย');window.location.assign('index.php') </script>";
?>