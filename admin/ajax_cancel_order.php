<?php
include("config/connect.php");

$sql_update  = "UPDATE orders SET 
    order_status            = '4'  WHERE order_id = '" . $_POST['update_order_id'] . "' ";
mysqli_query($link, $sql_update) or die(mysqli_error($link));


$sql_orderlist = "SELECT * FROM orderlist WHERE order_id = '" . $_POST['update_order_id'] . "'";
$query_orderlist = mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

while ($result_orderlist = mysqli_fetch_array($query_orderlist)) {

  $sql_stock = "UPDATE product SET
      product_amount = (product_amount + '" . $result_orderlist['od_amount'] . "') WHERE product_id = '" . $result_orderlist['product_id'] . "'";
  mysqli_query($link, $sql_stock) or die(mysqli_error($link));

  $sql_invoice = "UPDATE invoice SET
     invoice_status = '1' WHERE order_id = '" . $_POST['update_order_id'] . "' ";
  mysqli_query($link, $sql_invoice) or die(mysqli_error($link));



}

