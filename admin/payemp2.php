<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php
session_start();
require('config/connect.php');
include_once("config/etc_funct_admin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentdate  = tochristyear($_POST['payment_date']);
    $receiptdate = tochristyear($_POST['receipt_date']);


    $sql_receipt  = "UPDATE receipt SET 
	payment_date              = '" . $paymentdate . "',
    receipt_date              = '" . $receiptdate . "',
    receipt_tye	        	  = '" . $_POST['receipt_tye'] . "',
    emp_id                    = '" . $_SESSION['emp_id'] . "',
    invoice_id                = NULLIF('". $_POST['invoice_id'] ."',''),
    receipt_payment_details	  = '" . $_POST['receipt_payment_details'] . "' WHERE receipt_id = '". $_POST['receipt_id'] ."'";


    mysqli_query($link, $sql_receipt) or die(mysqli_error($link));

    $sql_update  = "UPDATE orders SET 
	order_status            = '2'  WHERE order_id = '" . $_POST['orders_id'] . "' ";

    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {

        echo '<script> 
        $(document).ready(function() {
        alert("บันทึกการชําระเรียบร้อย\nเลขที่ใบเสร็จคือ ' . str_pad($_POST['orders_id'], 5, 0, STR_PAD_LEFT) .  '"); 
        window.open("bill.php?orderid='  . str_pad($_POST['orders_id'], 5, 0, STR_PAD_LEFT) . '","_blank"); 
        window.location.assign("showpay_emp.php")
    });
    </script>';
        
    }
}


                                   