<head>
    <title>รายงานการรับชําระประจําเดือน</title>
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
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการรับชําระประจําเดือน</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">เดือน <?= MonthThai($month) ?> พ.ศ. <?= $year + 543 ?></h4>


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
        <th style="text-align:center; width:100px;">วันที่ชําระ</th>
        <th style="text-align:left; padding-left:15px; width:150px;">ประเภทการชําระ</th>
        <th style="text-align:center; width:100px;">เลขที่ใบเสร็จ</th>
        <th style="text-align:center; width:110px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center; width:100px;">รหัสสั่งซื้อ</th>
        <th style="text-align:center; width:120px;">เลขที่ใบแจ้งหนี้</th>
        <th style="text-align:center; width:100px;">เครดิต(วัน)</th>
        <th style="text-align:center; width:120px;">วันกําหนดชําระ</th>
        <th style="text-align:left; padding-left:10px; width:100px;">รายละเอียดการชําระ</th>
        <th style="text-align:left; width:170px;">ชื่อลูกค้า</th>
        <th style="text-align:left; width:170px;">ชื่อพนักงาน</th>
        <th style="text-align:right; width:110px;">ราคารวม(บาท)</th>
        <th style="text-align:right; width:90px;">ค่าส่ง(บาท)</th>
        <th style="text-align:right; width:110px;">รวมสุทธิ(บาท)</th>
    </tr>

    <?php
    $sql_date = "SELECT DISTINCT date(receipt_date) FROM receipt
                WHERE month(receipt_date) = '$month' AND year(receipt_date) = '$year'
                ORDER BY date(receipt_date) ASC";
    $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
    $sum_a = $sum_b = $sum_c = $sum_d = $sum_e = 0;

    if (mysqli_num_rows($query_date) == 0) {
        echo "<script>alert('ไม่พบข้อมูลที่ค้นหา'); window.close();</script>";
        exit();
    }
    while ($result_date = mysqli_fetch_array($query_date)) {
        $sum_1 = $sum_2 = $sum_3 = 0;
        echo "
                        <tr height='25px'>
                        <td align='center'>
                         " . short_datetime_thai($result_date['date(receipt_date)']) . "
                        </td>
                        ";

        $sql_order = "SELECT *
                        FROM receipt
                        LEFT JOIN invoice ON receipt.invoice_id = invoice.invoice_id
                        LEFT JOIN employee ON receipt.emp_id = employee.emp_id
                        WHERE date(receipt_date) = '" . $result_date['date(receipt_date)'] . "'";
        $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));

        $row_order = 1; //แถว
        while ($result_order = mysqli_fetch_array($query_order)) {

            if ($row_order > 1) {
                echo "</tr><tr><td></td>";
            }

            $sql_order2 = "SELECT * FROM orders 
                    LEFT JOIN customers ON orders.cus_id = customers.cus_id
                    WHERE order_id = '" . $result_order['receipt_id'] . "'";
            $query_order2 = mysqli_query($link, $sql_order2) or die(mysqli_error($link));
            $result_order2 = mysqli_fetch_assoc($query_order2);


            $sum_1 += $result_order2['order_total'];
            $sum_2 += $result_order2['order_deliverycost'];
            $sum_3 += ($result_order2['order_total'] + $result_order2['order_deliverycost']);

            switch ($result_order['receipt_tye']) {
                case 0:
                    $receipt_tye = "<font color='CC6666'>เงินสด</font>";
                    $order_totalprice = "<font color='CC6666'>" . number_format($result_order2['order_deliverycost'] + $result_order2['order_total'], 2) . "</font>";
                    $sum_a += $result_order2['order_deliverycost'] + $result_order2['order_total'];
                    $order_deliverycost = "<font color='Black'>" . number_format($result_order2['order_deliverycost'], 2) . "</font>";
                    $order_total = "<font color='Black'>" . number_format($result_order2['order_total'], 2) . "</font>";
                    break;
                case 1:
                    $receipt_tye = "<font color='339999'>โอน</font>";
                    $order_totalprice = "<font color='339999'>" . number_format($result_order2['order_deliverycost'] + $result_order2['order_total'], 2) . "</font>"; //รวมสุทธิ
                    $sum_b += $result_order2['order_deliverycost'] + $result_order2['order_total'];  // รวมสถานะ
                    $order_deliverycost = "<font color='Black'>" . number_format($result_order2['order_deliverycost'], 2) . "</font>"; // ค่าส่ง
                    $order_total = "<font color='Black'>" . number_format($result_order2['order_total'], 2) . "</font>"; //ราคารวม
                    break;
                case 2:
                    $receipt_tye = "<font color='FF9999'>บัตรเดบิต</font>";
                    $order_totalprice = "<font color='FF9999'>" . number_format($result_order2['order_deliverycost'] + $result_order2['order_total'], 2) . "</font>";
                    $sum_c += $result_order2['order_deliverycost'] + $result_order2['order_total'];
                    $order_deliverycost = "<font color='Black'>" . number_format($result_order2['order_deliverycost'], 2) . "</font>";
                    $order_total = "<font color='Black'>" . number_format($result_order2['order_total'], 2) . "</font>";
                    break;
                case 3:
                    $receipt_tye = "<font color='0000DD'>บัตรเครดิต</font>";
                    $order_totalprice = "<font color='0000DD'>" . number_format($result_order2['order_deliverycost'] + $result_order2['order_total'], 2) . "</font>";
                    $sum_d += $result_order2['order_deliverycost'] + $result_order2['order_total'];
                    $order_deliverycost = "<font color='Black'>" . number_format($result_order2['order_deliverycost'], 2) . "</font>";
                    $order_total = "<font color='Black'>" . number_format($result_order2['order_total'], 2) . "</font>";
                    break;
                default:
                    $ordereceipt_tyer_status = "-";
            }


            if ($result_order['invoice_paymendate'] == "0000-00-00")
                $invoice_paymendate = "";
            else $invoice_paymendate = short_datetime_thai($result_order['invoice_paymendate']);


    ?>
            
                <td style="padding-left:15px;"><?= $receipt_tye ?></td>
                <td align="center"><?= $result_order['receipt_id'] ?></td>
                <td align="center"><?= short_datetime_thai($result_order2['order_date']) ?></td>
                <td align="center"><?= $result_order2['order_id'] ?></td>
                <td align="center"><?php
                                    if (!empty($result_order['invoice_id']))
                                        echo $result_order['invoice_id'];
                                    else echo "-" ?></td>
                <td align="center"><?php
                                    if (!empty($result_order['invoice_credit']))
                                        echo $result_order['invoice_credit'];
                                    else echo "-" ?></td>
                <td align="center"><?php
                                    if (short_datetime_thai($result_order['invoice_paymendate']))
                                        echo short_datetime_thai($result_order['invoice_paymendate']);
                                    else echo "-" ?></td>
                <td align="left" style="padding-left:10px;"><?= $result_order['receipt_payment_details'] ?></td>
                <td align="left"><?= $result_order2['cus_name'] ?></td>
                <td align="left"><?= $result_order['emp_name'] ?></td>
                <td align="right"><?= $order_total ?></td>
                <td align="right"><?= $order_deliverycost ?></td>
                <td align="right"><?= $order_totalprice ?></td>
            </tr>

        <?php
            $row_order++;
        }
        ?>
        <tr style="border-top:1px solid; border-bottom:1px solid;">
            <td colspan="10"></td>
            <td align="right"><b>รวม</b></td>
            <td align="right"><b><?= number_format($sum_1, 2) ?></b></td>
            <td align="right"><b><?= number_format($sum_2, 2) ?></b></td>
            <td align="right"><b><?= number_format($sum_3, 2) ?></b></td>
        </tr>

    <?php
    }
    ?>
    <tr>
        <td colspan="9"></td>
        <td align="right" colspan="2" style="color:Black;"><b>รวมทั้งหมด(บาท)</b></td>
        <td align="right" colspan="3" style="color:Black;"><b><?= number_format($sum_a + $sum_b + $sum_c + $sum_d, 2) ?></b></td>
    </tr>
    <tr>
        <td colspan="9"></td>
        <td align="right" colspan="2" style="color:CC6666;"><b>รวมเงินสดทั้งหมดทั้งหมด(บาท)</b></td>
        <td align="right" colspan="3" style="color:CC6666;"><b><?= number_format($sum_a, 2) ?></b></td>
    </tr>
    <tr>
        <td colspan="9"></td>
        <td align="right" colspan="2" style="color:339999;"><b>รวมเงินโอนทั้งหมด(บาท)</b></td>
        <td align="right" colspan="3" style="color:339999;"><b><?= number_format($sum_b, 2) ?></b></td>
    </tr>
    <tr>
        <td colspan="9"></td>
        <td align="right" colspan="2" style="color:FF9999;"><b>รวมบัตรเดบิตทั้งหมด(บาท)</b></td>
        <td align="right" colspan="3" style="color:FF9999;"><b><?= number_format($sum_c, 2) ?></b></td>
    </tr>
    <tr style="border-bottom:1px solid;">
        <td colspan="9"></td>
        <td align="right" colspan="2" style="color:0000DD;"><b>รวมบัตรเครดิตทั้งหมด(บาท)</b></td>
        <td align="right" colspan="3" style="color:0000DD;"><b><?= number_format($sum_d, 2) ?></b></td>
    </tr>
</table>
<br>