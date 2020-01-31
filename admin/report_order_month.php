<head>
    <title>รายงานการสั่งซื้อประจําเดือน</title>
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

<h4 align="center" class="page-header text-center" style="padding-top:40px;">อู่ชัยยานยนต์</h4>
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการสั่งซื้อประจําเดือน</4h>
    <h4 align="center" class="page-header text-center" style="padding-top:1px;">เดือน <?= MonthThai($month) ?> พ.ศ. <?= $year + 543 ?></h4>


    <table border="0" width="1250px" align="center">

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
            <th style="text-align:center; width:120px;">วันที่สั่งซื้อ</th>
            <th style="text-align:center; width:120px;">รหัสสั่งซื้อ</th>
            <th style="text-align:left; width:190px;">ชื่อลูกค้า</th>
            <th style="text-align:left; width:150px;">สถานะสั่งซื้อ</th>
            <th style="text-align:center;  width:120px;">วันกําหนดส่ง</th>
            <th style="text-align:left; padding-left:25px; width:120px;">ประเภทจัดส่ง</th>
            <th style="text-align:right;  width:150px;">ราคารวม(บาท)</th>
            <th style="text-align:right; width:95px;">ค่าส่ง(บาท)</th>
            <th style="text-align:right; width:120px;">รวมสุทธิ(บาท)</th>
        </tr>

        <?php
        $sql_date = "SELECT DISTINCT date(order_date) FROM orders 
                WHERE month(order_date) = '$month' AND year(order_date) = '$year'";
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
                " . short_datetime_thai($result_date['date(order_date)']) . "
               </td>
               </tr>";

            $sql_order = "SELECT * FROM orders 
               LEFT JOIN customers ON orders.cus_id = customers.cus_id
               WHERE date(order_date) = '" . $result_date['date(order_date)'] . "'";
            $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));


            while ($result_order = mysqli_fetch_array($query_order)) {
                $sum_1 += $result_order['order_total'];
                $sum_2 += $result_order['order_deliverycost'];
                $sum_3 += ($result_order['order_total'] + $result_order['order_deliverycost']);

                switch ($result_order['order_status']) {

                    case 0:
                        $order_status = "<font color='orange'>ยังไม่แจ้งชำระ</font>";
                        $order_totalprice = "<font color='orange'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $sum_a += $result_order['order_deliverycost'] + $result_order['order_total'];
                        break;
                    case 1:
                        $order_status = "<font color='3366CC'>รอการตรวจสอบ</font>";
                        $order_totalprice = "<font color='3366CC'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $sum_b += $result_order['order_deliverycost'] + $result_order['order_total'];

                        //$total_trans_1++;
                        break;
                    case 2:
                        $order_status = "<font color='54BD54'>ชำระแล้ว</font>";
                        $order_totalprice = "<font color='54BD54'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $sum_c += $result_order['order_deliverycost'] + $result_order['order_total'];
                        //$total_trans_2++;
                        break;
                    case 3:
                        $order_status = "<font color='9900FF'>ค้างชําระ</font>";
                        $order_totalprice = "<font color='9900FF'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $sum_d += $result_order['order_deliverycost'] + $result_order['order_total'];
                        //$total_trans_3++;
                        break;
                    case 4:
                        $order_status = "<font color='red'>ยกเลิก</font>";
                        $order_totalprice = "<font color='red'>" . number_format($result_order['order_deliverycost'] + $result_order['order_total'], 2) . "</font>";
                        $sum_e += $result_order['order_deliverycost'] + $result_order['order_total'];
                        //$total_trans_3++;
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


                if ($result_order['order_deadline_date'] == "0000-00-00")
                    $order_deadline_date = "";
                else $order_deadline_date = short_datetime_thai($result_order['order_deadline_date']);


        ?>
                <tr height="20px">
                    <td></td>
                    <td align="center"><?= $result_order['order_id'] ?></td>
                    <td align="left"><?= $result_order['cus_name'] ?></td>
                    <td style="padding-left:15px;"><?= $order_status ?></td>
                    <td align="center"><?php if ($order_deadline_date != "") {
                                            echo $order_deadline_date;
                                        } else {
                                            echo " <left>-</left>";
                                        } ?></td>
                    <td style="padding-left:25px;"><?= $order_type ?></td>
                    <td align="right"><?= number_format($result_order['order_total'], 2) ?></td>
                    <td align="right"><?= $result_order['order_deliverycost'] ?></td>
                    <td align="right"><?= $order_totalprice ?></td>
                </tr>
            <?php
            }
            ?>
            <tr style="border-top:1px solid; border-bottom:1px solid;">
                <td colspan="5"></td>
                <td align="right"><b>รวม</b></td>
                <td align="right"><b><?= number_format($sum_1, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_2, 2) ?></b></td>
                <td align="right"><b><?= number_format($sum_3, 2) ?></b></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:orange;"><b>รวมยังไม่แจ้งชำระทั้งหมด(บาท)</b></td>
            <td align="right" colspan="3"style="color:orange;"><b><?= number_format($sum_a, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:3366CC;"><b>รวมรอการตรวจสอบทั้งหมด(บาท)</b></td>
            <td align="right" colspan="3"style="color:3366CC;"><b><?= number_format($sum_b, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:54BD54;"><b>รวมยังชำระทั้งหมด(บาท)</b></td>
            <td align="right" colspan="3"style="color:54BD54;"><b><?= number_format($sum_c, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:9900FF;"><b>รวมค้างชําระทั้งหมด(บาท)</b></td>
            <td align="right" colspan="3"style="color:9900FF;"><b><?= number_format($sum_d, 2) ?></b></td>
        </tr>
        <tr style="border-bottom:1px solid;">
            <td colspan="4"></td>
            <td align="right" colspan="2" style="color:red;"><b>รวมยกเลิกทั้งหมด(บาท)</b></td>
            <td align="right" colspan="3"style="color:red;"><b><?= number_format($sum_e, 2) ?></b></td>
        </tr>
   
   
    </table>
    <br>