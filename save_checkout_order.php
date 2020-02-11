<?php
session_start();
include("conf/connection.php");
include_once("conf/etc_funct.php");

if (!isset($_SESSION['cus_username'])) {
  echo "<script>window.location.assign('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $totalprice = $_POST['order_total'];
  $orderdate = tochristyear($_POST['order_date']);



  if ($_POST['order_type'] == 0) {
    $deliverycost = 50;
  } elseif ($_POST['order_type'] == 1) {
    $deliverycost = 100;
  } else {
    $deliverycost = 0;
  }


  $sqlorder = "INSERT INTO orders SET 
    order_date	        	= '" . $orderdate . "',
    order_deadline_date		= '" . tochristyear($_POST['order_deadline_date']) . "',
    order_place	        	= '" . $_POST['order_place'] . "',
    order_total	        	= '" . $_POST['order_total'] . "',
    order_deliverycost	 	= '" . $deliverycost . "',
    order_type	 	        = '" . $_POST['order_type'] . "',
    order_status	 	      =  '0',
    cus_id	 	            = '" . $_SESSION['cus_id'] . "'";

  mysqli_query($link, $sqlorder) or die(mysqli_error($link));

  $last_orderid = mysqli_insert_id($link);

  


  for ($i = 0; $i < count($_SESSION['product_id']); $i++) {

    $sql_product = "SELECT product_price_unit FROM product WHERE product_id = '" . $_SESSION['product_id'][$i] . "'";
    $product_data = mysqli_fetch_assoc(mysqli_query($link, $sql_product));

    $sql_orderlist = "INSERT INTO orderlist SET
      product_id      = '" . $_SESSION['product_id'][$i] . "',
      od_amount       = '" . $_SESSION['strqty'][$i] . "',
      od_price_unit   = '" . $product_data['product_price_unit'] . "',
      od_status       = '0',
      order_id        = '" . $last_orderid . "'";

    mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

    $sql_stock = "UPDATE product SET
      product_amount = (product_amount - '" . $_SESSION['strqty'][$i] . "') WHERE product_id = '" . $_SESSION['product_id'][$i] . "'";
    mysqli_query($link, $sql_stock) or die(mysqli_error($link));
    //  $new_bank = mysqli_insert_id($link);
  }
  unset($_SESSION['intline']);
  unset($_SESSION['product_id']);
  unset($_SESSION['strqty']);
  mysqli_close($link);
   echo "<script>alert('บันทึกการสั่งซื้อเรียบร้อยแล้วของหรัส" . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) .  "'); window.location.assign('show_order.php')</script>";
}
