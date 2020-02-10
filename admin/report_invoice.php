<head>
    <title>รายงานหนี้ค้างชําระประจําเดือน</title>
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

    $month  = $_POST['month'];
    $year   = $_POST['year'];

    ?>
</head>

<style type="text/css" media="print">
    @page {
        size: auto;
    }
</style>

<h4 align="center" class="page-header text-center" style="padding-top:40px;">อู่ชัยยานยนต์</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานหนี้ค้างชําระประจําเดือน</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">เดือน <?= MonthThai($month) ?> พ.ศ. <?= $year + 543 ?></h4>

<table border="0" width="1370px" align="center">

    <tr>
        <td colspan="10" align="right" style="border-bottom:1px solid;">
            <?php
            echo "<meta charset='utf-8'>";
            date_default_timezone_set("Asia/Bangkok");
            echo ThDate(); // วันที่แสดง
            ?>
        </td>
    </tr>

    <tr style="border-bottom:1px solid; height:30px; ">
        <th style="text-align:center; width:120px;">วันกําหนดชําระ</th>
        <th style="text-align:center; width:140px;">วันที่ออกใบแจ้งหนี้</th>
        <th style="text-align:center; width:120px;">เลขที่ใบแจ้งหนี้</th>
        <th style="text-align:center; width:120px;">รหัสสั่งซื้อ</th>
        <th style="text-align:center; width:120px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center;  width:120px;">เครดิต(วัน)</th>
        <th style="text-align:left; width:150px;">ชื่อลูกค้า</th>
        <th style="text-align:right;  width:120px;">ราคารวม(บาท)</th>
        <th style="text-align:right; width:95px;">ค่าส่ง(บาท)</th>
        <th style="text-align:right; width:120px;">รวมสุทธิ(บาท)</th>
    </tr>

    <?php
    $sql_date = "SELECT DISTINCT date(invoice_paymendate) FROM invoice
                WHERE month(invoice_paymendate) = '$month' AND year(invoice_paymendate) = '$year'
                ORDER BY date(invoice_paymendate) ASC";
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
                " . short_datetime_thai($result_date['date(invoice_paymendate)']) . "
               </td>
               ";

        $sql_order = "SELECT * FROM invoice
               LEFT JOIN orders ON invoice.order_id = orders.order_id
               LEFT JOIN customers ON orders.cus_id = customers.cus_id
               WHERE date(invoice_paymendate) = '" . $result_date['date(invoice_paymendate)'] . "'";
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
                    $sum_a += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_f += $result_order['order_total'];
                    $sum_k += $result_order['order_deliverycost'];
                    break;
                case 1:
                    $order_status = "<font color='3366CC'>รอการตรวจสอบ</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_b += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_g += $result_order['order_total'];
                    $sum_l += $result_order['order_deliverycost'];
                    //$total_trans_1++;
                    break;
                case 2:
                    $order_status = "<font color='54BD54'>ชำระแล้ว</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_c += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_h += $result_order['order_total'];
                    $sum_m += $result_order['order_deliverycost'];
                    //$total_trans_2++;
                    break;
                case 3:
                    $order_status = "<font color='9900FF'>ค้างชําระ</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_d += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_i += $result_order['order_total'];
                    $sum_n += $result_order['order_deliverycost'];
                    //$total_trans_3++;
                    break;
                case 4:
                    $order_status = "<font color='red'>ยกเลิก</font>";
                    $order_totalprice = "<font color='Black'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                    $sum_e += $result_order['order_deliverycost'] + $result_order['order_total'];
                    $sum_j += $result_order['order_total'];
                    $sum_o += $result_order['order_deliverycost'];
                    //$total_trans_3++;
                    break;
                default:
                    $order_status = "-";
            }


            if ($result_order['order_deadline_date'] == "0000-00-00")
                $order_deadline_date = "";
            else $order_deadline_date = short_datetime_thai($result_order['order_deadline_date']);



    ?>

                <td align="center"><?= short_datetime_thai($result_order['invoice_issued_date']) ?></td>
                <td align="center"><?= $result_order['invoice_id'] ?></td>
                <td align="center"><?= $result_order['order_id'] ?></td>
                <td align="center"><?= short_datetime_thai($result_order['order_date']) ?></td>
                <td align="center"><?= $result_order['invoice_credit'] ?></td>
                <td align="left"><?= $result_order['cus_name'] ?></td>
                <td align="right"><?= number_format($result_order['order_total'], 2) ?></td>
                <td align="right"><?= $result_order['order_deliverycost'] ?></td>
                <td align="right"><?= $order_totalprice ?></td>

            <?php
            $row_order++;
        }
            ?>
            <tr style="border-top:1px solid; border-bottom:1px solid;">
                <td colspan="6"></td>
                <td align="right"><b>รวม</b></td>
                <td align="right"><b><?= number_format($sum_1, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_2, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_3, 2) ?></b></td>
            </tr>

        <?php
    }
        ?>
        <tr style="border-bottom:1px solid;">
            <td colspan="5"></td>
            <td align="right" colspan="2" style="color:Black;"><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right" style="color:Black;"><b><?= number_format($sum_f + $sum_g + $sum_h + $sum_i + $sum_j, 2) ?></b></td>
            <td align="right" style="color:Black;"><b><?= number_format($sum_k + $sum_l + $sum_m + $sum_n + $sum_o, 2) ?></b></td>
            <td align="right" colspan="3" style="color:Black;"><b><?= number_format($sum_a + $sum_b + $sum_c + $sum_d, 2) ?></b></td>
        </tr>

</table>
<br>