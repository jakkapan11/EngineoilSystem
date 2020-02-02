<head>
    <title>รายงานการเปลี่ยนสินค้าประจําวัน</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <?php

    include("config/connect.php");
    include_once("config/etc_funct_admin.php");
    include("config/mali.php");
    include("config/thdate.php");

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
<h3 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการเปลี่ยนสินค้าประจําวัน</h3>
<h4 align="center" class=" text-center" style="padding-top:1px;">ตั้งแต่วันที่ <?= DateThai($startdate) ?> ถึงวันที่ <?= DateThai($enddate) ?></h4>


<table border="1" width="1750px" align="center">
    <tr>
        <td colspan="14" align="right" style="border-bottom:1px solid;">
            <?php
            echo "<meta charset='utf-8'>";
            date_default_timezone_set("Asia/Bangkok");
            echo ThDate(); // วันที่แสดง
            ?>
        </td>
    </tr>
    <tr style="border-bottom:1px solid; height:30px; ">
        <th style="text-align:center; width:110px;">วันที่เปลี่ยน</th>
        <th style="text-align:center; width:140px;">รหัสการเปลี่ยน</th>
        <th style="text-align:left; padding-left:10px; width:110px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center; width:95px;">รหัสสั่งซื้อ</th>
        <th style="text-align:center; width:115px;">เลขที่ใบเสร็จ</th>
        <th style="text-align:center; width:115px;">วันที่ออกใบเสร็จ</th>
        <th style="text-align:left; padding-left:15px;width:200px;">ชื่อลูกค้า</th>
        <th style="text-align:left;width:260px;">รายการสินค้า</th>
        <th style="text-align:right; width:90px;">จํานวนซื้อ</th>
        <th style="text-align:center; width:90px;">จํานวนเปลี่ยน</th>
        <th style="text-align:center; width:90px;">หน่วยนับ</th>
        <th style="text-align:center; width:110px;">หมายเหตุ</th>
    </tr>


    <?php
    $sql_date = "SELECT DISTINCT date(change_date) FROM amount_change WHERE (date(amount_change.change_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(amount_change.change_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
    $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));

    $sum_a = $sum_b = $sum_c = $sum_d = $sum_e = 0;
    $sum_f = $sum_g = $sum_h = $sum_i = $sum_j = 0; // รวมราคารวมทั้งหมด
    $sum_k = $sum_l = $sum_m = $sum_n = $sum_o = 0; // รวมค่าจัดส่งทั้งหมด

    if (mysqli_num_rows($query_date) == 0) {
        echo "<script>alert('ไม่พบข้อมูลที่ค้นหา'); window.close();</script>";
        exit();
    }
    while ($result_date = mysqli_fetch_array($query_date)) {
        $sum_1 = $sum_2 = $sum_3 = 0;
        echo "
           <tr height='25px'>
           <td align='center'>
            " . short_datetime_thai($result_date['date(change_date)']) . "
           </td>
          ";

        $sql_order = "SELECT * FROM orders 
          LEFT JOIN customers ON orders.cus_id = customers.cus_id
          RIGHT JOIN receipt  ON orders.order_id = receipt.order_id
         
          WHERE date(change_date) = '" . $result_date['date(change_date)'] . "'";
        $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));

        $row_order = 1;
        while ($result_order = mysqli_fetch_array($query_order)) {

            if ($row_order > 1) {
                echo "</tr><tr><td></td>";
            }

            $sum_1 += $result_order['order_total'];
            $sum_2 += $result_order['order_deliverycost'];
            $sum_3 += ($result_order['order_total'] + $result_order['order_deliverycost']);

            switch ($result_order['order_status']) {
                case 0:
                    $order_status = "<font color='orange'>ยังไม่แจ้งชำระ</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_f += $result_order['order_total'];
                    $sum_a += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_k += $result_order['order_deliverycost'];
                    break;
                case 1:
                    $order_status = "<font color='3366CC'>รอการตรวจสอบ</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_g += $result_order['order_total'];
                    $sum_b += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_l += $result_order['order_deliverycost'];
                    break;
                case 2:
                    $order_status = "<font color='54BD54'>ชำระแล้ว</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_h += $result_order['order_total'];
                    $sum_c += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_m += $result_order['order_deliverycost'];
                    break;
                case 3:
                    $order_status = "<font color='9900FF'>ค้างชําระ</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_i += $result_order['order_total'];
                    $sum_d += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_n += $result_order['order_deliverycost'];
                    break;
                case 4:
                    $order_status = "<font color='red'>ยกเลิก</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_j += $result_order['order_total'];
                    $sum_e += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_o += $result_order['order_deliverycost'];
                    break;
                default:
                    $order_status = "-";
            }
    ?>

        <?php
        }
        ?>




    <?php
    }
    ?>