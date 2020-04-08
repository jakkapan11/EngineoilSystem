<head>
    <title>รายงานการสั่งซื้อประจําวัน ตั้งแต่วันที่ <?= $_POST['startdate'] ?> ถึงวันที่ <?= $_POST['enddate'] ?></title>
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

<style type="text/css" media="print">
    @page {
        size: auto;
    }
</style>

<?php
$startdate  = tochristyear($_POST['startdate']);
$enddate    = tochristyear($_POST['enddate']);
?>
<h4 align="center" class="page-header text-center" style="padding-top:40px;">อู่ชัยยานยนต์</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการสั่งซื้อประจําวัน</4h>
    <h4 align="center" class=" text-center" style="padding-top:1px;">ตั้งแต่วันที่ <?= DateThai($startdate) ?> ถึงวันที่ <?= DateThai($enddate) ?></h4>


    <table border="0" width="1870px" align="center">

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
            <th style="text-align:center; width:100px;">วันที่สั่งซื้อ</th>
            <th style="text-align:center; width:90px;">รหัสสั่งซื้อ</th>
            <th style="text-align:right; width:90px;">รหัสลูกค้า</th>
            <th style="text-align:left; padding-left:15px; width:160px;">ชื่อลูกค้า</th>
            <th style="text-align:left; padding-left:10px; width:140px;">ประเภทการชําระ</th>
            <th style="text-align:left; padding-left:15px;width:125px;">สถานะสั่งซื้อ</th>
            <th style="text-align:right; width:120px;">ราคารวม(บาท)</th>
            <th style="text-align:right; width:115px;">ค่าส่ง(บาท)</th>
            <th style="text-align:right; width:125px;">รวมสุทธิ(บาท)</th>
            <th style="text-align:left; padding-left:15px;width:120px;">ประเภทสินค้า</th>
            <th style="text-align:left; padding-left:15px;width:280px;">รายการสินค้า</th>
            <th style="text-align:right; width:150px;">ราคาต่อหน่วย(บาท)</th>
            <th style="text-align:right;width:65px;">จำนวน</th>
            <th style="text-align:right; width:100px;">ราคา(บาท)</th>
        </tr>

        <?php
        $sql_date = "SELECT DISTINCT date(order_date) FROM orders WHERE (date(orders.order_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(orders.order_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
        $sum_a = $sum_b = $sum_c = $sum_d = $sum_e = 0;
        $sum_k = $sum_l = $sum_m = $sum_n = $sum_o = 0; // รวมค่าจัดส่งทั้งหมด
        $sum_f = $sum_g = $sum_h = $sum_i = $sum_j = 0; // รวมราคารวมทั้งหมด

        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ค้นหา'); window.close();</script>";
            exit();
        }

        while ($result_date = mysqli_fetch_array($query_date)) {
            $sum_1 = $sum_2 = $sum_3 = 0;
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(order_date)']) . "
               </td>
              ";

            $sql_order = "SELECT orders.order_id, customers.cus_name, orders.order_total, orders.cus_id, order_deliverycost, 
            order_status, receipt_tye, order_status FROM orders 
               LEFT JOIN customers ON orders.cus_id = customers.cus_id
               LEFT JOIN receipt  ON orders.order_id = receipt.order_id
               WHERE date(order_date) = '" . $result_date['date(order_date)'] . "'
               ORDER BY orders.order_id ASC";
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
                        $order_totalprice = "<font color='orange'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $order_deliverycost =  "<font color='orange'>" . number_format($result_order['order_deliverycost'], 2) . "</font>";  //สีของค่าส่ง
                        $order_total = "<font color='orange'>" . number_format($result_order['order_total'], 2) . "</font>";
                        $sum_a += $result_order['order_deliverycost'] + $result_order['order_total'];
                        $sum_k += $result_order['order_deliverycost'];
                        $sum_f += $result_order['order_total'];
                        //  $order_totalprice = "<font color='orange'>" . $result_order['order_totalprice'] . "</font>";
                        //$total_trans_0++;
                        break;
                    case 1:
                        $order_status = "<font color='3366CC'>รอการตรวจสอบ</font>";
                        $order_totalprice = "<font color='3366CC'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $order_deliverycost =  "<font color='3366CC'>" . number_format($result_order['order_deliverycost'], 2) . "</font>";
                        $order_total = "<font color='3366CC'>" . number_format($result_order['order_total'], 2) . "</font>";
                        $sum_b += $result_order['order_deliverycost'] + $result_order['order_total']; 
                        $sum_l += $result_order['order_deliverycost'];
                        $sum_g += $result_order['order_total'];
                        //  $order_totalprice = "<font color='#0072EE'>" . $result_order['order_totalprice'] . "</font>";
                        //$total_trans_1++;
                        break;
                    case 2:
                        $order_status = "<font color='54BD54'>ชำระแล้ว</font>";
                        $order_totalprice = "<font color='54BD54'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $order_deliverycost =  "<font color='54BD54'>" . number_format($result_order['order_deliverycost'], 2) . "</font>";
                        $order_total = "<font color='54BD54'>" . number_format($result_order['order_total'], 2) . "</font>";
                        $sum_c += $result_order['order_deliverycost'] + $result_order['order_total'];
                        $sum_m += $result_order['order_deliverycost'];
                        $sum_h += $result_order['order_total'];
                        //$order_totalprice = "<font color='#12BB4F'>" . $result_order['order_totalprice'] . "</font>";
                        //$total_trans_2++;
                        break;
                    case 3:
                        $order_status = "<font color='9900FF'>ค้างชําระ</font>";
                        $order_totalprice = "<font color='9900FF'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $order_deliverycost =  "<font color='9900FF'>" . number_format($result_order['order_deliverycost'], 2) . "</font>";
                        $order_total = "<font color='9900FF'>" . number_format($result_order['order_total'], 2) . "</font>";
                        $sum_d += $result_order['order_deliverycost'] + $result_order['order_total'];
                        $sum_n += $result_order['order_deliverycost'];
                        $sum_i += $result_order['order_total'];
                        //$order_totalprice = "<font color='red'>" . $result_order['order_totalprice'] . "</font>";
                        //$total_trans_3++;
                        break;
                    case 4:
                        $order_status = "<font color='red'>ยกเลิก</font>";
                        $order_totalprice = "<font color='red'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $order_deliverycost =  "<font color='red'>" . number_format($result_order['order_deliverycost'], 2) . "</font>";
                        $order_total = "<font color='red'>" . number_format($result_order['order_total'], 2) . "</font>";
                        $sum_e += $result_order['order_deliverycost'] + $result_order['order_total'];
                        $sum_o += $result_order['order_deliverycost'];
                        $sum_j += $result_order['order_total'];
                        //$order_totalprice = "<font color='red'>" . $result_order['order_totalprice'] . "</font>";
                        //$total_trans_3++;
                        break;
                    default:
                        $order_status = "-";
                }

                switch ($result_order['receipt_tye']) {
                    case 0:
                        $receipt_tye = "<font color=''>เงินสด</font>";
                        break;
                    case 1:
                        $receipt_tye = "<font color=''>โอน</font>";
                        break;
                    case 2:
                        $receipt_tye = "<font color=''>บัตรเดบิต</font>";
                        break;
                    case 3:
                        $receipt_tye = "<font color=''>บัตรเครดิต</font>";
                        break;
                    default:
                        $ordereceipt_tyer_status = "-";
                }


        ?>

                <td align="center"><?= $result_order['order_id'] ?></td>
                <td align="right"><?= $result_order['cus_id'] ?></td>
                <td align="left" style="padding-left:15px;"><?= $result_order['cus_name'] ?></td>
                <td align="left" style="padding-left:10px;">
                    <?php
                    if ($result_order['order_status'] != 0 && $result_order['order_status'] != 3 && $result_order['order_status'] != 4)
                        echo $receipt_tye;
                    else
                        echo "-"
                    ?>
                <td style="padding-left:15px;"><?= $order_status ?></td>
                <td align="right"><?= $order_total ?></td>
                <td align="right"><?= $order_deliverycost ?></td>
                <td align="right"><?= $order_totalprice ?></td>

                <?php

                $sql_orderdet = "SELECT * FROM orderlist 
                    LEFT JOIN product ON orderlist.product_id = product.product_id
                    LEFT JOIN category ON product.category_id = category.category_id
                    WHERE orderlist.order_id = '" . $result_order['order_id'] . "'";
                $query_orderdet = mysqli_query($link, $sql_orderdet) or die(mysqli_error($link));

                $row_orderdet = 1;
                while ($result_orderdet = mysqli_fetch_array($query_orderdet)) {
                    if ($row_orderdet > 1) {
                        echo "</tr><tr><td colspan='9'></td>";
                    }
                ?>

                    <td style="padding-left:15px;"><?= $result_orderdet['category_name'] ?></td>
                    <td style="padding-left:20px;"><?= $result_orderdet['product_name'] ?></td>
                    <td align="right"><?=  number_format($result_orderdet['od_price_unit'], 2) ?></td>
                    <td align="right"><?= $result_orderdet['od_amount'] ?></td>
                    <td align="right"><?= number_format($result_orderdet['od_amount'] *  $result_orderdet['od_price_unit'], 2) ?></td>


                    </tr>
            <?php
                    $row_orderdet++;
                }
                $row_order++;
            }
            // $total += $sum_per_date;

            ?>
            <tr style="border-bottom:1px solid;">
                <td colspan="5"></td>
                <td align="right"><b>รวม</b></td>
                <td align="right"><b><?= number_format($sum_1, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_2, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_3, 2) ?></b></td>
                <td align="right"><b></b></td>
                <td align="right"><b></b></td>
                <td align="right"><b></b></td>
                <td align="right"><b></b></td>
                <td align="right"><b></b></td>
            </tr>
        <?php
        }

        ?>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:Black;"><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right"  style="color:Black;"><b><?= number_format($sum_f + $sum_g + $sum_h + $sum_i + $sum_j, 2) ?></b></td>
            <td align="right"  style="color:Black;"><b><?= number_format($sum_k + $sum_l + $sum_m + $sum_n + $sum_o, 2) ?></b></td>
            <td align="right"  style="color:Black;"><b><?= number_format($sum_a + $sum_b + $sum_c + $sum_d + $sum_e, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:orange;"><b>รวมยังไม่แจ้งชำระทั้งหมด(บาท)</b></td>
            <td align="right" style="color:orange;"><b><?= number_format($sum_f, 2) ?></b></td>
            <td align="right" style="color:orange;"><b><?= number_format($sum_k, 2) ?></b></td>
            <td align="right" style="color:orange;"><b><?= number_format($sum_a, 2) ?></b></td>
           
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:3366CC;"><b>รวมรอการตรวจสอบทั้งหมด(บาท)</b></td>
            <td align="right" style="color:3366CC;"><b><?= number_format($sum_g, 2) ?></b></td>
            <td align="right" style="color:3366CC;"><b><?= number_format($sum_l, 2) ?></b></td>
            <td align="right" style="color:3366CC;"><b><?= number_format($sum_b, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:54BD54;"><b>รวมชำระทั้งหมด(บาท)</b></td>
            <td align="right" style="color:54BD54;"><b><?= number_format($sum_h, 2) ?></b></td>
            <td align="right" style="color:54BD54;"><b><?= number_format($sum_m, 2) ?></b></td>
            <td align="right" style="color:54BD54;"><b><?= number_format($sum_c, 2) ?></b></td>

        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:9900FF;"><b>รวมค้างชําระทั้งหมด(บาท)</b></td>
            <td align="right" style="color:9900FF;"><b><?= number_format($sum_i, 2) ?></b></td>
            <td align="right" style="color:9900FF;"><b><?= number_format($sum_n, 2) ?></b></td>
            <td align="right" style="color:9900FF;"><b><?= number_format($sum_d, 2) ?></b></td>
        </tr>
        <tr style="border-bottom:1px solid;">
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:red;"><b>รวมยกเลิกทั้งหมด(บาท)</b></td>
            <td align="right" style="color:red;"><b><?= number_format($sum_j, 2) ?></b></td>
            <td align="right" style="color:red;"><b><?= number_format($sum_o, 2) ?></b></td>
            <td align="right" style="color:red;"><b><?= number_format($sum_e, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="14"></td>
            <td align="right" colspan="2" style="color:red;"><b></b></td>
            <td align="right" colspan="3" style="color:red;"></td>
        </tr>

    </table>
    </body>
    <br>