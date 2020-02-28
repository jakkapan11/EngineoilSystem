<?php
session_start();
include_once("config/etc_funct_admin.php");

if (!isset($_SESSION['emp_id'])) {
	echo "<script> alert('ตรวจสอบสิทธิ์เข้าใช้งาน'); windwo.location.assign('login.php')</script>";
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('config/connect.php');
	$emp_birth	    = 	tochristyear($_POST['emp_birthday']);
	$email  = $_POST['emp_email'];
	$phone  = $_POST['emp_phone'];
	$idcard = $_POST['emp_idcard'];
	//$user_name	=	trim($_POST['user_name']);    
	//$password		=	trim($_POST['password']);    
	
	$chk_phone	= mysqli_query($link, "SELECT * FROM employee WHERE emp_phone = '" . $phone . "'");
	if (mysqli_num_rows($chk_phone) != "0") {
		echo "<script> alert('เบอร์โทรศัพท์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}

	$chk_idcard	= mysqli_query($link, "SELECT * FROM employee WHERE emp_idcard = '" . $idcard . "'");
	if (mysqli_num_rows($chk_idcard) != "0") {
		echo "<script> alert('หมายเลขบัตรประชาชนถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}
	//ถ้าไม่มีให้เพิ่มข้อมูล
	//	echo "$name $number_phone $emp_birthday $email $address $user_name $password $emp_postnum";

	$sql		=	"INSERT INTO employee SET 
						emp_name		= '" . $_POST['emp_name'] . "',
						emp_username	= '" . $_POST['emp_idcard'] . "',
						emp_birthday	= '" . $emp_birth . "',
						emp_phone		= '" . $_POST['emp_phone'] . "',
						emp_email		= '" . $email . "',
						emp_level		= '" . $_POST['emp_level'] . "',
						emp_status		= '0',
						emp_password	= '" . $_POST['emp_idcard'] . "',
						emp_idcard		= '" . $_POST['emp_idcard'] . "',
						emp_address		= '" . $_POST['emp_address'] . "'";
	//                                   



	if (mysqli_query($link, $sql) or die(mysqli_error($link))) {
		$new_bank = mysqli_insert_id($link);
		echo '<script> alert("เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว\nรหัสพนักงาน '. $new_bank . '"); 
		window.location.assign("show_employee.php")
		</script>';
	}
}
