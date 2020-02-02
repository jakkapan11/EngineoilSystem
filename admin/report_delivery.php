<head>
    <title>รายงานการจัดส่งสินค้าประจําวัน ตั้งแต่วันที่ <?= $_POST['startdate'] ?> ถึงวันที่ <?= $_POST['enddate'] ?></title>
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
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการจัดส่งสินค้าประจําวัน</h4>
<h4 align="center" class=" text-center" style="padding-top:1px;">ตั้งแต่วันที่ <?= DateThai($startdate) ?> ถึงวันที่ <?= DateThai($enddate) ?></h4>






<table border="0" width="1750px" align="center">
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
        <th style="text-align:center; width:110px;">วันที่จัดส่ง</th>
        <th style="text-align:center; width:140px;">หมายเลขการจัดส่ง</th>
        <th style="text-align:left; padding-left:10px; width:110px;">ประเภทจัดส่ง</td>
        <th style="text-align:center; width:115px;">วันที่กําหนดส่ง</td>
        <th style="text-align:center; width:117px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center; width:95px;">รหัสสั่งซื้อ</th>
        <th style="text-align:right; width:120px;">ราคารวม(บาท)</th>
        <th style="text-align:right; width:100px;">ค่าส่ง(บาท)</th>
        <th style="text-align:right; width:130px;">รวมสุทธิ(บาท)</th>
        <th style="text-align:left; padding-left:15px;width:200px;">ชื่อลูกค้า</th>
        <th style="text-align:left; width:110px;">สถานที่ส่ง</th>
        <th style="text-align:left;width:260px;">รายการสินค้า</th>
        <th style="text-align:right; width:60px;">จํานวน</th>
        <th style="text-align:center; width:90px;">หน่วยนับ</th>
    </tr>

    <?php
    $sql_date = "SELECT DISTINCT date(order_delivery_date) FROM orders WHERE (date(orders.order_delivery_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(orders.order_delivery_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
    $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
    
    $sum_a = $sum_b = $sum_c = $sum_d = $sum_e = 0;
    $sum_f = $sum_g = $sum_h = $sum_i = $sum_j = 0; // รวมราคารวมทั้งหมด
    $sum_k = $sum_l = $sum_m = $sum_n = $sum_o = 0; // รวมค่าจัดส่งทั้งหมด
    $total = 0; // รวมรายการทั้งหมด

    if (mysqli_num_rows($query_date) == 0) {
        echo "<script>alert('ไม่พบข้อมูลที่ค้นหา'); window.close();</script>";
        exit();
    }
    while ($result_date = mysqli_fetch_array($query_date)) {
        $sum_1 = $sum_2 = $sum_3 = 0;
        echo "
           <tr height='25px'>
           <td align='center'>
            " . short_datetime_thai($result_date['date(order_delivery_date)']) . "
           </td>
          ";
        $sql_order = "SELECT * FROM orders 
          LEFT JOIN customers ON orders.cus_id = customers.cus_id
          RIGHT JOIN receipt  ON orders.order_id = receipt.order_id
         
          WHERE date(order_delivery_date) = '" . $result_date['date(order_delivery_date)'] . "'";
        $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));

        $row_order = 1;
        $count_day = 0;
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

            switch ($result_order['order_type']) {
                case 0:
                    $order_type = "<font color=''>ลงทะเบียน</font>";
                    break;
                case 1:
                    $order_type = "<font color=''>EMS</font>";
                    break;
                case 2:
                    $order_type = "<font color=''>นําสินค้ากลับบ้านเอง</font>";
                    break;

                default:
                    $order_type = "-";
            }

    ?>
            <td align="center"><?= $result_order['order_deliverynumber'] ?></td>
            <td align="left" style="padding-left:10px;"><?= $order_type ?></td>
            <td align="center"><?= short_datetime_thai($result_order['order_deadline_date']) ?></td>
            <td align="center"><?= short_datetime_thai($result_order['order_date']) ?></td>
            <td align="center"><?= $result_order['order_id'] ?></td>
            <td align="right"><?= number_format($result_order['order_total'], 2) ?></td>
            <td align="right"><?= $result_order['order_deliverycost'] ?></td>
            <td align="right"><?= $order_totalprice ?></td>
            <td align="left" style="padding-left:15px;"><?= $result_order['cus_name'] ?></td>
            <td align="left"><?= $result_order['order_place'] ?></td>

            <?php

            $sql_orderdet = "SELECT * FROM orderlist 
            LEFT JOIN product ON orderlist.product_id = product.product_id
            LEFT JOIN category ON product.category_id = category.category_id
            WHERE orderlist.order_id = '" . $result_order['order_id'] . "'";
            $query_orderdet = mysqli_query($link, $sql_orderdet) or die(mysqli_error($link));

            $row_orderdet = 1;
            while ($result_orderdet = mysqli_fetch_array($query_orderdet)) {
                if ($row_orderdet > 1) {
                    echo "</tr><tr><td colspan='11'></td>";
                }
            ?>
                <td><?= $result_orderdet['product_name'] ?></td>
                <td align="right"><?= $result_orderdet['od_amount'] ?></td>
                <td align="center"><?= $result_orderdet['product_unit'] ?></td>
                </tr>
        <?php
                $count_day++; $total++;
                $row_orderdet++;
            }
        }
        ?>
        <tr style="border-top:1px solid; border-bottom:1px solid;">
            <td colspan="5"></td>
            <td align="right"><b>รวม</b></td>
            <td align="right"><b><?= number_format($sum_1, 2) ?></b></td>
            <td align="right"><b><?= number_format($sum_2, 2) ?></b></td>
            <td align="right"><b><?= number_format($sum_3, 2) ?></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b><?= $count_day ?></b></td>
            <td align="center"><b>รายการ</b></td>
        </tr>

    <?php
    }
    ?>
    <tr style="border-bottom:1px solid;">
        <td colspan="4"></td>
        <td align="right" colspan="2" style="color:Black;"><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right" style="color:Black;"><b><?= number_format($sum_f + $sum_g + $sum_h + $sum_i + $sum_j, 2) ?></b></td>
            <td align="right" style="color:Black;"><b><?= number_format($sum_k + $sum_l + $sum_m + $sum_n + $sum_o, 2) ?></b></td>
            <td align="right" style="color:Black;"><b><?= number_format($sum_a + $sum_b + $sum_c + $sum_d, 2) ?></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
            <td align="right"><b><?= $total ?></b></td>
            <td align="center"><b>รายการ</b></td>
        </tr>

</table>
</body>
<br>