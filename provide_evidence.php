<?php
session_start();
include("conf/connection.php");

if (!isset($_SESSION['cus_username'])) {
  echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



  $ord_image     =    $_FILES['order_evidence']['name'];

  $sql_update  = "UPDATE orders SET 
        order_notification_date = '" . date('Y-m-d') . "',
        order_evidence          = '" . "image/evidence/" . $ord_image . "',
        order_status            = '1'  WHERE order_id = '" . $_POST['orders_id'] . "' ";

  if (move_uploaded_file($_FILES['order_evidence']['tmp_name'], "image/evidence/" . $ord_image)) {
    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
      echo '<script> alert("บันทึกแจ้งหลักฐานเรียบร้อย\nรหัสการสั่งซื้อ '. $_POST['orders_id']. '"); 
      window.location.assign("show_order.php")
      </script>';
    }
  } else {
    echo "<script>alert('อัพโหลดไฟล์ล้มเหลว'); window.location.assign('show_order.php');</script>";
  }
}
