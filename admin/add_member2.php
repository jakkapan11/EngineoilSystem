<?php
session_start();
include_once("config/etc_funct_admin.php");

if (!isset($_SESSION['emp_id'])) {
	echo "<script> alert('ตรวจสอบสิทธิ์เข้าใช้งาน'); windwo.location.assign('login.php')</script>";
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('config/connect.php');
	$cus_birth	= tochristyear($_POST['cus_birthday']);
	$phone = $_POST['cus_phone'];
	//$user_name	=	trim($_POST['user_name']);    
	//$password		=	trim($_POST['password']);    

	$chk_phone = mysqli_query($link, "SELECT * FROM customers WHERE cus_phone = '" . $phone. "'");
	if (mysqli_num_rows($chk_phone) != "0") {
		echo "<script> alert('เบอร์โทรศัพท์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}
	
	

	//ถ้าไม่มีให้เพิ่มข้อมูล
	//	echo "$name $number_phone $cus_birth $email $address $user_name $password $cus_postnum";
	$sql		=	"INSERT INTO customers SET 
						cus_name		= '" . $_POST['cus_name'] . "',
						cus_zipcode	    = '" . $_POST['cus_zipcode'] . "',
						cus_birthday	= '" . $cus_birth . "',
						cus_username	= '" . $_POST['cus_phone'] . "',
						cus_email		= '" . $email . "',
						cus_status		= '0',
						cus_password	= '" . $_POST['cus_phone'] . "',
						cus_phone    	= '" . $_POST['cus_phone'] . "',
                        cus_address		= '" . $_POST['cus_address'] . "'";



	if (mysqli_query($link, $sql) or die(mysqli_error($link))) {
		$new_bank = mysqli_insert_id($link);
		echo "<script> alert('เพิ่มข้อมูลเรียบร้อยแล้วของรหัสสมาชิก" .  $new_bank . "'); window.location.assign('show_member.php')</script>";
	}
}
