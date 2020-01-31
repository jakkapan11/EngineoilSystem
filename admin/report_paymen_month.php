<head>
<title>รายงานการรับชําระประจําเดือน</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }
    ?>
</head>
</head>

<h4 align="center" class="page-header text-center" style="padding-top:40px;">อู่ชัยยานยนต์</h4>
<h3 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการรับชําระประจําเดือน</h3>