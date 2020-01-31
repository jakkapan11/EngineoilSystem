<head>
    <title>รายงานการจัดส่งสินค้าประจําวัน ตั้งแต่วันที่ <?= $_POST['startdate'] ?> ถึงวันที่ <?= $_POST['enddate'] ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");
    include("config/mali.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }
    ?>
</head>
<?php
$startdate  = tochristyear($_POST['startdate']);
$enddate    = tochristyear($_POST['enddate']);
?>

<h4 align="center" class="page-header text-center" style="padding-top:40px;">อู่ชัยยานยนต์</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการจัดส่งสินค้าประจําวัน</h4>
<h4 align="center" class=" text-center" style="padding-top:1px;">ตั้งแต่วันที่ <?= DateThai($startdate) ?> ถึงวันที่ <?= DateThai($enddate) ?></h4>






<table border="0" width="1850px" align="center">
    <tr>
        <td colspan="14" align="right" style="border-bottom:1px solid;">
            <?php
            echo "<meta charset='utf-8'>";
            date_default_timezone_set("Asia/Bangkok");
            function ThDate()
            {
                //วันภาษาไทย
                $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                //เดือนภาษาไทย
                $ThMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

                //กำหนดคุณสมบัติ
                $week = date("w"); // ค่าวันในสัปดาห์ (0-6)
                $months = date("m") - 1; // ค่าเดือน (1-12)
                $day = date("d"); // ค่าวันที่(1-31)
                $years = date("Y") + 543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

                return "วันที่พิมพ์
                $day  $ThMonth[$months] พ.ศ. $years";
            }
            echo ThDate(); // วันที่แสดง
            ?>
        </td>
    </tr>
    <tr style="border-bottom:1px solid; height:30px; ">
        <th style="text-align:center; width:90px;">วันที่จัดส่ง</th>
        <th style="text-align:center; width:115px;">หมายเลขจัดส่ง</th>
        <th style="text-align:left; padding-left:10px; width:100px;">ประเภทจัดส่ง</th>
        <th style="text-align:center; width:105px;">วันที่กําหนดส่ง</th>
        <th style="text-align:center; width:95px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center; width:95px;">รหัสสั่งซื้อ</th>
        <th style="text-align:right; width:110px;">ราคารวม(บาท)</th>
        <th style="text-align:right; width:90px;">ค่าส่ง(บาท)</th>
        <th style="text-align:right; width:100px;">รวมสุทธิ(บาท)</th>
        <th style="text-align:left; padding-left:15px;width:150px;">ชื่อลูกค้า</th>
        <th style="text-align:left; width:170px;">สถานที่ส่ง</th>
        <th style="text-align:left;width:160px;">รายการสินค้า</th>
        <th style="text-align:right; width:60px;">จํานวน</th>
        <th style="text-align:center; width:80px;">หน่วยนับ</th>
    </tr>

    <?php
    $sql_date = "SELECT DISTINCT date(order_delivery_date) FROM orders WHERE (date(orders.order_delivery_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(orders.order_delivery_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
    $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));

    if (mysqli_num_rows($query_date) == 0) {
        echo "<script>alert('ไม่พบข้อมูลที่ค้นหา'); window.close();</script>";
        exit();
    }
    ?>


</table>
    </body>