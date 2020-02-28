<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('config/connect.php'); 
   
	//$user_name	=	trim($_POST['user_name']);    
	//$password		=	trim($_POST['password']);    
	   
    

	//ถ้าไม่มีให้เพิ่มข้อมูล
	//	echo "$name $number_phone $emp_birth $email $address $user_name $password $emp_postnum";
	$sql		=	"INSERT INTO category SET 
						category_name		= '" . $_POST['category_name'] . "',			
						category_status	= '0'";
						
						
//                      
if (mysqli_query($link, $sql) or die(mysqli_error($link))) {
	$new_bank = mysqli_insert_id($link);
		echo '<script> alert("เพิ่มข้อมูลประเภทสินค้าเรียบร้อยแล้ว\nรหัสประเภทสินค้า ' .  $new_bank. '"); 
		window.location.assign("show_category.php")
		</script>';
	}
}
