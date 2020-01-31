<head>
    <title>ใบส่งของ</title>
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<?php
$sql_orderdata = "SELECT * FROM orders WHERE order_id = '" . $_GET['orderid'] . "'";
$q = mysqli_query($link, $sql_orderdata) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($q);

$sql_cus = "SELECT * FROM customers WHERE cus_id = '" . $data['cus_id'] . "'";
$q2 =  mysqli_query($link, $sql_cus) or die(mysqli_error($link));
$cus_data = mysqli_fetch_assoc($q2);

if ($data['order_deadline_date'] == "0000-00-00")
    $order_deadline_date = "";
else $order_deadline_date = DateThai($data['order_deadline_date']);

if ($data['order_delivery_date'] == "0000-00-00")
    $order_delivery_date = "";
else $order_delivery_date = DateThai($data['order_delivery_date']);

?>
<br>
<div class="container" style="border: 1pt solid black;">
    <h2 class="page-header text-center" style="padding-top:30px;">ใบส่งของ</h2>
    <h6 class="page-header text-center" style="padding-top:0px;">ร้านอู่ชัยยานยนต์</h6>
    <h6 class="page-header text-center" style="padding-top:0px;">32/2 หมู่ 2 ตำบลแหลมงอบ อำเภอแหลมงอบ จังหวัดตราด 23120</h6>
    <hr>

    <form action="#" method="POST">
        <table border="0" align="center" style="border:1px solid #C0C0C0;width:930px;">
            <tr>
                <td colspan="4"><label for="select"></label>
            </tr>
            <tr>
                <td width="200" height="40" align="right"><strong>รหัสการสั่งซื้อ :</strong></td>
                <td width="25%" style="padding-left:20px;"><?= $data['order_id'] ?></td>

                <td width="260" align="right"><strong>วันที่กําหนดส่ง :</strong></td>
                <td width="30%" style="padding-left:20px;"><?= $order_deadline_date ?></td>
            </tr>
            <tr>
                <td width="200" height="40" align="right"><strong>วันที่สั่งซื้อ :</strong></td>
                <td width="25%" style="padding-left:20px;"><?= DateThai($data['order_date']); ?></td>

                <td width="260" height="40" align="right"><strong>รหัสลูกค้า :</strong></td>
                <td width="30%" style="padding-left:20px;"><?php echo $cus_data['cus_id'] ?></td>
            </tr>
            <tr>
                <td width="200" height="40" align="right"><strong>วันที่จัดส่ง :</strong></td>
                <td width="25%" style="padding-left:20px;"><?= $order_delivery_date  ?></td>

                <td width="260" height="40" align="right"><strong>ชื่อ-นามสกุล :</strong></td>
                <td width="30%" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
            </tr>
            <tr>
                <td width="200" height="40" align="right"><strong>หมายเลขส่ง :</strong></td>
                <td width="25%" style="padding-left:20px;"><?= $data['order_deliverynumber'] ?></td>

                <td width="260" height="40" align="right"><strong>สถานที่ส่ง :</strong></td>
                <td style="padding-left:20px;"> <?php echo $data['order_place'] ?> </td>
            </tr>
            <tr>
                <td colspan="4"><label for="select"></label>
            </tr>
        </table>

        <h5 class="page-header text-center" style="padding-top:30px; padding-bottom:5px;">รายการสั่งซื้อ</h5>
        <table class="table" align="center" border="0" style="width:980px;">
            <thead>
                <tr>
                    <th style="text-align:left; width:120px;">รายการสินค้า</th>
                    <th style="text-align:left;width:100px;">ประเภท</th>
                    <th style="text-align:center;width:90px;">หน่วย</th>
                    <th style="text-align:right;width:200px;">ราคาต่อหน่วย (บาท)</th>
                    <th style="text-align:right;width:95px;">จํานวน</th>
                    <th style="text-align:right;width:140px;">ราคารวม (บาท)</th>

                </tr>
                <?php

                $sql_orderlist = "SELECT * FROM orderlist WHERE order_id = '" . $_GET['orderid'] . "'";
                $query_orderlist = mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

                while ($result_orderlist = mysqli_fetch_array($query_orderlist)) {

                    $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_id = '" . $result_orderlist['product_id'] . "' ";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                    $result = mysqli_fetch_array($query);

                    $t1 = $result['product_price_unit'] * $result_orderlist['od_amount'];
                ?>
                    <tr>


                        <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                        <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                        <td style="padding-top:20px;" align="right"><?= $result['product_unit'] ?></td>
                        <td style="padding-top:20px;" align="right"><?= number_format($result_orderlist['od_price_unit'], 2); ?></td>
                        <td style="padding-top:20px; text-align:right;"><?= $result_orderlist['od_amount'] ?></td>
                        <td style="padding-top:20px;" align="right"><?= number_format($t1, 2); ?></td>

                    </tr>
                <?php
                } ?>
    </form>

    <td style="padding-top:30px; " colspan="7" align="center"><span style="color:red;">หมายเหตุ สามารถนําใบเสร็จมาเปลี่ยนสินค้าที่ชํารุดภายใน 3-5 วันหลังจากวันที่ชําระ</span> </td>

    </table>
    </form>
    <table border="0" align="center" style="width:1050px;">
        <tr align="right">
            <td width="909" height="25"><b>รวมทั้งหมด</b></td>
            <td width="100"><b id="sum"><?= number_format($data['order_total'], 2); ?></b></td>
            <td width="150" align="right" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td width="300" height="25"><b>ค่าจัดส่ง</b></td>
            <td><b><span id="fee"><?= $data['order_deliverycost'] ?></b></span></td>
            <td align="right" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td width="300" height="25"><b>รวมสุทธิ</b></td>
            <td><b id="sum_total"><?= number_format($data['order_deliverycost'] + $data['order_total'], 2) ?></b></td>
            <td align="right" colspan="2"><b>บาท</b></td>
        </tr>
    </table>

    <table border="0" align="center" style="width:990px;">
        <td width="200" height="40" align="left"><strong>วันที่พิมพ์ :</strong></td>
        <td width="91%" align="left" style="padding-left:10px;">
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

                return " $day $ThMonth[$months] พ.ศ. $years";
            }
            echo ThDate(); // วันที่แสดง
            ?>
        </td>
</div>
</table>