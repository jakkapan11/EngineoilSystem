<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php
session_start();
require('config/connect.php');
include_once("config/etc_funct_admin.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
  $sql_orders  = "UPDATE orders SET 
        order_delivery_date		= '" . tochristyear($_POST['order_delivery_date']) . "',
        order_deliverynumber    = '" . $_POST['order_deliverynumber'] . "'  WHERE order_id = '". $_POST['order_id'] ."'";

} 

if (mysqli_query($link, $sql_orders) or die(mysqli_error($link))) {
    echo '<script>
    $(document).ready(function() {
     alert("บันทึกจัดส่งสินค้าเรียบร้อย\nรหัสการซื้อ '   . str_pad($_POST['order_id'], 5, 0, STR_PAD_LEFT) .  '"); 
     window.open("delivery_emp.php?orderid='  . str_pad($_POST['order_id'], 5, 0, STR_PAD_LEFT) . '","_blank"); 
    window.location.assign("showpay_emp.php")
  });
    </script>';
}

