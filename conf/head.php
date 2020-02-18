<!DOCTYPE html>
<html lang="en">

<?php

if (!isset($_SESSION)) {
	session_start();
}

?>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>head</title>
	<link rel="shortcut icon" href="favicon.ico" />

</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="admin/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script src="css/font-awesome.min.css"></script> -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="admin/js/bootstrap-datepicker.js"></script>
<!-- thai extension -->
<script type="text/javascript" src="admin/js/bootstrap-datepicker-thai.js"></script>
<script type="text/javascript" src="admin/js/locales/bootstrap-datepicker.th.js"></script>
<link href="admin/css/datepicker.css" rel="stylesheet">


<body>

	<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">อู่ชัยยานยนต์</a>
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
			<ul class="nav navbar-nav">
				<li class="nav-item"><a href="index.php" class="nav-link">หน้าแรก</a></li>

				<li class="nav-item"><a href="show_product.php" class="nav-link">แสดงสินค้า</a></li>

				<?php if (isset($_SESSION['cus_id'])) { ?>
					<li class="nav-item"><a href="show_order.php" class="nav-link">แสดงรายการสั่งซื้อ</a></li>
				<?php } ?>
				<li class="nav-item"><a href="contact.php" class="nav-link">ติดต่อเรา</a></li>
				<li class="nav-item"><a target="_blank" href="manual.pdf" class="nav-link">คู่มือการใช้งาน</a></li>
			</ul>

			<?php if (isset($_SESSION['cus_id'])) { ?>
				<ul class="nav navbar-nav navbar-right ml-auto " style="padding-right:px; ">
					<li class="nav-item dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"><i class="fa fa-user-o"></i> สวัสดี, <?= $_SESSION['cus_username'] ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="profile.php" class="dropdown-item"><i class="fa fa-user-o"></i> แก้ไขสมาชิก</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="basket.php" class="dropdown-item"><i class="fa fa-shopping-cart"></i> ตะกร้าสินค้า <span class="badge badge-light" style="font-size:15px;"></span></a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> ออกจากระบบ</a></li>
						</ul>
					</li>
				</ul> <?php
						} else { ?>
				<ul class="nav navbar-nav navbar-right ml-auto">
					<li class="nav-item"><a href="register.php" class="nav-link"><i class="fa fa-key"></i> สมัครสมาชิก</a></li>
					<li class="nav-item"><a href="login.php" class="nav-link"><i class="fa fa-user-o"></i> เข้าสู่ระบบ</a></li>
				</ul>
			<?php } ?>
	</nav>
</body>