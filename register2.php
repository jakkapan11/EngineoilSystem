<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('conf/connection.php'); 
	include_once("conf/etc_funct.php");
	
	$cus_birth	= 	$_POST['cus_birthday'];     
	$cus_username	=	trim($_POST['cus_username']);
	$password		=	trim($_POST['cus_password']);
	$email = $_POST['cus_email'];
	$phone = $_POST['cus_phone'];
	$username	    = $cus_username;
	//$user_name	=	trim($_POST['user_name']);    
	//$password		=	trim($_POST['password']);    
	
	if ($password != $_POST['cus_password2']) {
		echo "<script> alert('รหัสผ่านไม่ตรงกัน'); window.history.back(); </script>";
		exit();
	}
	
	$chk_email	= mysqli_query($link, "SELECT * FROM customers WHERE cus_email = '" . $email . "'");   
	if (mysqli_num_rows($chk_email) != "0") {
		echo "<script> alert('อีเมลล์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}	
    $chk_phone	= mysqli_query($link, "SELECT * FROM customers WHERE cus_phone = '" . $phone . "'");   
	if (mysqli_num_rows($chk_phone) != "0") {
		echo "<script> alert('เบอร์โทรศัพท์ใช้งานแล้ว'); window.history.back();</script>";
		exit();
	}	
	$chk_username = mysqli_query($link, "SELECT * FROM customers WHERE cus_username = '" . $username . "'");   
	if (mysqli_num_rows($chk_username) != "0") {
		echo "<script> alert('ชื่อผู้ใช้ถูกใช้ไปแล้ว'); window.history.back();</script>";
		exit();
	}	
	//ถ้าไม่มีให้เพิ่มข้อมูล
	//echo "$name $number_phone $cus_birth $email $address $user_name $password $cus_postnum";
	$sql		=	"INSERT INTO customers SET 
						cus_name		= '" . $_POST['cus_name'] . "',
						cus_zipcode	    = '" . $_POST['cus_zipcode'] . "',
						cus_birthday	= '" . tochristyear($cus_birth) . "',
                        cus_username	= '" . $cus_username . "',
						cus_email		= '" . $email . "',
						cus_status		= '0',
						cus_password	= '" . $password . "',
                        cus_phone    	= '" . $_POST['cus_phone'] . "',
                        cus_address		= '" . $_POST['cus_address'] ."'";

    

if (mysqli_query($link, $sql) or die(mysqli_error($link))) {
	$new_bank = mysqli_insert_id($link);
	echo "<script> alert('สมัครสมาชิกสําเร็จของรหัสสมาชิก". $new_bank . "'); window.location.assign('index.php')</script>";
	}
}
