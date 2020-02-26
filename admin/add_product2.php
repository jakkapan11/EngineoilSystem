<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('config/connect.php'); 
	   
	 $prd_image     =    $_FILES['product_pic']['name'];

	//$user_name	=	trim($_POST['user_name']);    
	//$password		=	trim($_POST['password']);    
	   
    
	//ถ้าไม่มีให้เพิ่มข้อมูล
	//	echo "$name $number_phone $cus_birth $email $address $user_name $password $cus_postnum";

	$sql		=	"INSERT INTO product SET 
						product_name	    = '" . $_POST['product_name'] . "',
						category_id         = '" . $_POST['category_id'] . "',
                        product_amount      = '" . $_POST['product_amount'] . "',
                        product_price_unit	= '" . $_POST['product_price_unit'] . "',
						product_unit		= '" . $_POST['product_unit'] . "',
                        product_status		= '0',
						product_picture     = '" . "image/" . $prd_image . "',
                        product_description	= '" . $_POST['product_description'] ."'";

    
if (move_uploaded_file($_FILES['product_pic']['tmp_name'], "../image/" . $prd_image))
if (mysqli_query($link, $sql) or die(mysqli_error($link))) {
	$new_bank = mysqli_insert_id($link);
	echo '<script> alert("เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว\nรหัสสินค้า '  .  $new_bank. '"); 
	window.location.assign("show_product.php")
	</script>';
	}
}