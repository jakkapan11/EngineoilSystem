<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<?php
session_start();
include("config/connect.php");
include_once("config/etc_funct_admin.php");

if (!isset($_SESSION['emp_username'])) {
  echo "<script>window.location.assign('login.php')</script>";
}


if ($_POST['cus_id'] == "") {
  echo "<script>alert('กรุณาเลือกลูกค้า'); window.history.back();</script>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $totalprice = $_POST['order_total'];
  $orderdate = tochristyear($_POST['order_date']);

  if ($_POST['order_status'] == 2) {
    $receipt_date = date("Y-m-d");
    $payment_date = date("Y-m-d");
  } elseif ($_POST['order_status'] == 3) {
    $receipt_date = "";
    $payment_date = "";
  }

  if ($_POST['order_type'] == "-") {
    $deliverycost = 0;
  } elseif ($_POST['order_type'] == 0) {
    $deliverycost = 50;
  } elseif ($_POST['order_type'] == 1) {
    $deliverycost = 100;
  } else {
    $deliverycost = 0;
  }

  $sqlorder = "INSERT INTO orders SET 
    order_date	        	= '" . $orderdate . "',
    order_deadline_date		= '" . tochristyear($_POST['order_deadline_date']) . "',
    order_total	        	= '" . $_POST['order_total'] . "',
    order_deliverycost	 	= '" . $deliverycost . "',
    order_type	 	        = '" . $_POST['order_type'] . "',
    order_status	 	      = '" . $_POST['order_status'] . "',
    cus_id	 	            = '" . $_POST['cus_id'] . "'";

  mysqli_query($link, $sqlorder) or die(mysqli_error($link));

  $last_orderid = mysqli_insert_id($link);

  if ($_POST['order_status'] == 2) {
    $receipt_tye = $_POST['receipt_tye'];
    $receipt_payment_details = $_POST['receipt_payment_details'];
  } elseif ($_POST['order_status'] == 3) {
    $receipt_tye = "";
    $receipt_payment_details = "";
  }

  $sqlreceipt = "INSERT INTO receipt SET 
    receipt_tye	        	    = '$receipt_tye',
    emp_id                    = '" . $_SESSION['emp_id'] . "',
    order_id                  = '" .  $last_orderid . "',
    receipt_date              = '" . $receipt_date . "',
    receipt_payment_details	  = ' $receipt_payment_details '";
    
  if ($_POST['order_status'] == 2) {
    mysqli_query($link, $sqlreceipt) or die(mysqli_error($link));
    $last_receipt = mysqli_insert_id($link);
  }
  //    $sql ="INSERT INTO receipt (receipt_tye, receipt_payment_details , invoice_id)
  // VALUES ('".$_POST['receipt_tye']."','".$_POST['receipt_payment_details']."' , 1)";
  // mysqli_query($link, $sql) or die(mysqli_error($link));
  if (isset($_POST['invoice_credit'])) {
    $invoice_paymendate = date("Y-m-d", strtotime("+" . $_POST['invoice_credit'] . "day"));
    $invoice_credit = $_POST['invoice_credit'];
  } else {
    $invoice_credit = "";
    $invoice_paymendate = "";
  }

  $sqlinvoice    =  "INSERT INTO invoice SET 
		invoice_issued_date  = '" . tochristyear($_POST['invoice_issued_date']) . "',
		invoice_credit		   = '" . $invoice_credit . "',
		emp_id               = '" . $_SESSION['emp_id'] . "',
		invoice_paymendate   = '" . $invoice_paymendate . "',
		order_id             = '" . $last_orderid . "' ";

  if ($_POST['order_status'] == 3) {
    mysqli_query($link, $sqlinvoice) or die(mysqli_error($link));
    $last_invoice = mysqli_insert_id($link);
  }
  for ($i = 0; $i < count($_SESSION['productid']); $i++) {

    $sql_product = "SELECT product_price_unit FROM product WHERE product_id = '" . $_SESSION['productid'][$i] . "'";
    $product_data = mysqli_fetch_assoc(mysqli_query($link, $sql_product));

    $sql_orderlist = "INSERT INTO orderlist SET
      product_id      = '" . $_SESSION['productid'][$i] . "',
      od_amount       = '" . $_SESSION['strqty2'][$i] . "',
      od_price_unit   = '" . $product_data['product_price_unit'] . "',
      od_status       = '0',
      order_id        = '" . $last_orderid . "'";

    mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

    $sql_stock = "UPDATE product SET
      product_amount = (product_amount - '" . $_SESSION['strqty2'][$i] . "') WHERE product_id = '" . $_SESSION['productid'][$i] . "'";
    mysqli_query($link, $sql_stock) or die(mysqli_error($link));
    // $new_bank = mysqli_insert_id($link);
  }
  unset($_SESSION['intline2']);
  unset($_SESSION['productid']);
  unset($_SESSION['strqty2']);
  mysqli_close($link);

  if ($_POST['order_status'] == 2) {
    echo '<script>  
      $(document).ready(function() {
        alert("บันทึกการสั่งซื้อเรียบร้อย\nรหัสการสั่งซื้อ ' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) . ' เลขที่ใบเสร็จ ' . str_pad($last_receipt, 5, 0, STR_PAD_LEFT) .  '"); 
        window.open("bill.php?orderid=' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) . '","_blank"); 
        window.location.assign("showpay_emp.php");
      });
      </script>';
  } elseif ($_POST['order_status'] == 3) {
    echo '<script>  
    $(document).ready(function() {
      alert("บันทึกการสั่งซื้อเรียบร้อย\nรหัสการสั่งซื้อ ' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) .  ' เลขที่ใบแจ้งหนี้ ' . str_pad($last_invoice, 5, 0, STR_PAD_LEFT) .   '"); 
      window.open("invoice.php?orderid=' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) . '","_blank"); 
      window.location.assign("orderhistory.php");
    });
    </script>';
  }
}
