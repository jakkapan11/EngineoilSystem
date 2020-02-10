<head>
    <title>รายงานการเปลี่ยนสินค้าประจําวัน ตั้งแต่วันที่ <?= $_POST['startdate'] ?> ถึงวันที่ <?= $_POST['enddate'] ?></title>
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
<h4 align="center" class="page-header text-center" style="padding-top:1px;">รายงานการเปลี่ยนสินค้าประจําวัน</h4>
<h4 align="center" class=" text-center" style="padding-top:1px;">ตั้งแต่วันที่ <?= DateThai($startdate) ?> ถึงวันที่ <?= DateThai($enddate) ?></h4>


<table border="0" width="1650px" align="center">
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
        <th style="text-align:center; width:120px;">วันที่เปลี่ยน</th>
        <th style="text-align:center; width:125px;">รหัสการเปลี่ยน</th>
        <th style="text-align:center;  width:110px;">วันที่สั่งซื้อ</th>
        <th style="text-align:center; width:110px;">รหัสสั่งซื้อ</th>
        <th style="text-align:center; width:115px;">เลขที่ใบเสร็จ</th>
        <th style="text-align:center; width:120px;">วันที่ออกใบเสร็จ</th>
        <th style="text-align:left; padding-left:15px;width:200px;">ชื่อลูกค้า</th>
        <th style="text-align:left;width:260px;">รายการสินค้า</th>
        <th style="text-align:right; width:90px;">จํานวนซื้อ</th>
        <th style="text-align:right; width:110px;">จํานวนเปลี่ยน</th>
        <th style="text-align:center; width:90px;">หน่วยนับ</th>
        <th style="text-align:center; width:110px;">หมายเหตุ</th>
    </tr>


    <?php
    $sql_date = "SELECT DISTINCT date(change_date) FROM amount_change WHERE (date(amount_change.change_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(amount_change.change_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
    $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));

    //$sum_a = $sum_b = $sum_c = $sum_d = $sum_e = 0;
    //$sum_f = $sum_g = $sum_h = $sum_i = $sum_j = 0; // รวมราคารวมทั้งหมด
    //$sum_k = $sum_l = $sum_m = $sum_n = $sum_o = 0; // รวมค่าจัดส่งทั้งหมด
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
            " . short_datetime_thai($result_date['date(change_date)']) . "
           </td>
          ";

        $sql_change = "SELECT * FROM amount_change
            LEFT JOIN orderlist ON amount_change.od_id = orderlist.od_id
            LEFT JOIN product ON orderlist.product_id = product.product_id
            LEFT JOIN orders ON orderlist.order_id = orders.order_id
            LEFT JOIN customers ON orders.cus_id = customers.cus_id
            LEFT JOIN receipt ON receipt.order_id = orders.order_id 
         
          WHERE date(change_date) = '" . $result_date['date(change_date)'] . "'";
        $query_change = mysqli_query($link, $sql_change) or die(mysqli_error($link));
        $row_order = 1;
        $count_day = 0;

        $row_change = 1;
        while ($result_change = mysqli_fetch_array($query_change)) {

            if ($row_change > 1) {
                echo "</tr><tr><td></td>";
            }
    ?>
            <td align="center"><?= $result_change['change_id'] ?></td>
            <td align="center"><?= short_datetime_thai($result_change['order_date']) ?></td>
            <td align="center"><?= $result_change['order_id'] ?></td>
            <td align="center"><?= $result_change['receipt_id'] ?></td>
            <td align="center"><?= short_datetime_thai($result_change['receipt_date']) ?></td>
            <td align="left" style="padding-left:15px;"><?= $result_change['cus_name'] ?></td>
            <td align="left"><?= $result_change['product_name'] ?></td>
            <td align="right"><?= $result_change['od_amount'] ?></td>
            <td align="right"><?= $result_change['change_Amount'] ?></td>
            <td align="center"><?= $result_change['product_unit'] ?></td>
            <td align="center"><?= $result_change['change_notes'] ?></td>
           
            <?php
            $sql_orderlist = "SELECT * FROM orderlist 
                LEFT JOIN product ON orderlist.product_id = product.product_id
                "

            ?>


        <?php
         $count_day++; $total++;
            $row_change++;
        }
        ?>
<tr style="border-top:1px solid; border-bottom:1px solid;">
            <td colspan="7"></td>
            <td align="right"><b>รวม</b></td>
           
        
            <td align="right"><b><?= $count_day ?></b></td>
            <td align="center"><b>รายการ</b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
        </tr>
    <?php
    }
    ?>
    <tr style="border-bottom:1px solid;">
        <td colspan="5"></td>
        <td align="right" colspan="3" style="color:Black;"><b>รวมทั้งหมด</b></td>
        
            <td align="right"><b><?= $total ?></b></td>
            <td align="center"><b>รายการ</b></td>
            <td align="right"><b></b></td>
            <td align="right"><b></b></td>
        </tr>

</table>
</body>
<br>