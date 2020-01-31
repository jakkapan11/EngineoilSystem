<?php
session_start();
require('config/connect.php');
include_once("config/etc_funct_admin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$invoice_issued_date = tochristyear($_POST['invoice_issued_date']);
	
	$sqlinvoice		=	"INSERT INTO invoice SET 
		invoice_issued_date = '" . $invoice_issued_date . "',
		invoice_credit		= '" . $_POST['invoice_credit'] . "',
		emp_id              = '" . $_SESSION['emp_id'] . "',
		invoice_paymendate  = '" . $_POST['invoice_paymendate'] . "',
		order_id            = '".  $_POST['orders_id']."' ";
	
	mysqli_query($link, $sqlinvoice	) or die(mysqli_error($link));
	$new_bank = mysqli_insert_id($link);

	$sql_update  = "UPDATE orders SET 
	order_status            = '3'  WHERE order_id = '" . $_POST['orders_id'] . "' ";


	if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
		
		echo "<script> alert('บันทึกใบแจ้งหนี้เรียบร้อยของรหัส" . str_pad($new_bank, 5, 0, STR_PAD_LEFT) .  "'); window.location.assign('orderhistory.php')</script>";
	}
}


