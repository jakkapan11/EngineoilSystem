<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>head</title>
	<?php
	if (!isset($_SESSION)) {
		session_start();
	} ?>

</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="js/bootstrap.min.js"></script>
<!-- <script src="css/font-awesome.min.css"></script> -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<!-- thai extension -->
<script type="text/javascript" src="js/bootstrap-datepicker-thai.js"></script>
<script type="text/javascript" src="js/locales/bootstrap-datepicker.th.js"></script>
<link href="css/datepicker.css" rel="stylesheet">

<body>
	<div style=" position: -webkit-sticky; position: sticky; z-index:1; top: 0;">
		<nav class="navbar navbar-expand-lg  navbar-dark bg-secondary">
			<a class="navbar-brand" href="index.php">อู่ชัยยานยนต์</a>
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
				<span class="navbar-toggler-icon"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div id="navbarCollapse" class="collapse navbar-collapse ">
				<div class="col-md-4">
					<h6 class="" style="color:white; margin-top:8px;">32/2 หมู่ 2 ตำบลแหลมงอบ อำเภอแหลมงอบ จังหวัดตราด 23120</h6>
				</div>
			</div>
		</nav>
		<nav class="navbar navbar-expand-lg  navbar-dark bg-secondary" style="border-top:1px white solid;">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
				<span class="navbar-toggler-icon"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<div id="navbarCollapse" class="collapse navbar-collapse ">
			<ul class="nav navbar-nav">
					<li class="nav-item active"><a href="index.php" class="nav-link">หน้าแรก</a></li>
					<?php if ($_SESSION['emp_level'] == 1) { ?>
						<li class="nav-item active"><a href="show_employee.php" class="nav-link">แสดง/ลบข้อมูลพนักงาน</a></li>
					<?php	} ?>
					<li class="nav-item active"><a href="show_member.php" class="nav-link">แสดง/ลบข้อมูลสมาชิก</a></li>
					<li class="nav-item active"><a href="show_category.php" class="nav-link">แสดง/ลบข้อมูลประเภทสินค้า</a></li>
					<li class="nav-item active"><a href="show_product.php" class="nav-link">แสดง/ลบข้อมูลสินค้า</a></li>
					<li class="nav-item active"><a href="logproduct.php" class="nav-link">แสดงรายการสินค้า</a></li>
					<li class="nav-item active"><a href="orderhistory.php" class="nav-link">แสดง/ยกเลิกรายการสั่งซื้อ</a></li>
					<li class="nav-item active"><a href="showpay_emp.php" class="nav-link">แสดงการชําระ</a></li>

					<?php if ($_SESSION['emp_level'] == 1) { ?>
						<li class="nav-item  active dropdown">
							<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">รายงาน<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="select_order_day.php" class="dropdown-item">รายงานการสั่งซื้อประจําวัน</a></li>
								<li><a href="select_order_month_year.php" class="dropdown-item">รายงานการสั่งซื้อประจําเดือน</a></li>
								<li><a href="select_day.php" class="dropdown-item">รายงานการจัดส่งสินค้าประจําวัน</a></li>
								<li><a href="selct_change_day.php" class="dropdown-item">รายงานการเปลี่ยนสินค้าประจําวัน</a></li>
								<li><a href="select_paymen_day.php" class="dropdown-item">รายงานการรับชําระประจําวัน</a></li>
								<li><a href="select_paymen_month.php" class="dropdown-item">รายงานการรับชําระประจําเดือน</a></li>
								<li><a href="select_month_year.php" class="dropdown-item">รายงานหนี้ค้างชําระประจําเดือน</a></li>
								<li><a target="_blank" href="report_category.php" class="dropdown-item">รายงานสินค้าแยกตามประเภท</a></li>
							</ul>
						<?php	} ?>
						</li>
				</ul>
				<ul class="nav navbar-nav navbar-right ml-auto " style="padding-right:20px; ">
					<li class="nav-item active dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"><i class="fa fa-user-o"></i> สวัสดี, <?= $_SESSION['emp_username'] ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="modify_user.php" class="dropdown-item"><i class="fa fa-user-o"></i> แก้ไขข้อมูลผู้ใช้</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="<?= ($_SESSION['emp_level'] == 1) ? "manual_admin.pdf" : "UserManualEmployee.pdf" ?>"  target="_blank" class="dropdown-item"><i class="fa fa-book"></i> คู่มือการใช้งาน</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> ออกจากระบบ</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</body>