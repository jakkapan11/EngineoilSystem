<head>
    <title>บันทึกใบแจ้งหนี้</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");

    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }

    ?>

    <script>
        $(document).ready(function() {
            $('.datepicker-checkout').datepicker({
                language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                format: 'dd/mm/yyyy',
                disableTouchKeyboard: true,
                todayBtn: false,
                endDate: '+30d',
                startDate: 'now',
                autoclose: true, //Set เป็นปี พ.ศ.
                inline: true
            }) //กำหนดเป็นวันปัจุบัน       
        });
    </script>
</head>

<body>
    <?php
    $sql_orderdata = "SELECT * FROM orders WHERE order_id = '" . $_GET['orderid'] . "'";
    $q = mysqli_query($link, $sql_orderdata) or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($q);

    $sql_cus = "SELECT * FROM customers WHERE cus_id = '" . $data['cus_id'] . "'";
    $q2 =  mysqli_query($link, $sql_cus) or die(mysqli_error($link));
    $cus_data = mysqli_fetch_assoc($q2);
    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:80px;">บันทึกใบแจ้งหนี้</h2>
        <hr>
        <form action="record_invoice2.php" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">

                <tr>
                    <td width="220" align="right"><strong>รหัสการสั่งซื้อ :<strong></td>
                    <td width="20%" style="padding-left:20px;"><?= $data['order_id']; ?>
                        <input type="text" name="orders_id" hidden value="<?= $data['order_id'] ?>"></td</td> <td width="200" height="45" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                    <td width="250" style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>
                </tr>
                <td width="220" align="right"><strong>เครดิต (วัน) :</strong><span style="color:red;">*</span></td>
                <td width="20%" style="padding-left:20px;"><label for="textfield"></label>
                    <input style="width:60px;" class="form-control" type="text" name="invoice_credit" id="invoice_credit" onkeyup="check_invoice_credit();" required /></td>
                <td width="215" height="50" align="right"><strong>รหัสลูกค้า :</strong> </td>
                <td width="30%" style="padding-left:20px;"><?php echo $cus_data['cus_id'] ?></td>
                </tr>
                <td width="215" height="45" align="right"><strong>วันกําหนดชําระ :</strong> </td>
                <td width="20%" style="padding-left:20px;">
                    <?php
                    $strStartDate = date('Y-m-d'); //วันที่ปัจจุบัน
                    $strNewDate = date("Y-m-d", strtotime("+7 day", strtotime($strStartDate))); // วันที่ปัจจุบัน + 7 วัน
                    echo DateThai($strNewDate);
                    ?>
                    <input type="text" hidden name="invoice_paymendate" value="<?php echo $strNewDate; ?>">
                </td>
                <td width="200" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                <td width="250px" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
                </tr>
                <tr>
                    <td width="215" height="45" align="right"><strong>วันที่ออกใบแจ้งหนี้ :</strong> </td>
                    <td width="20%" style="padding-left:14px;"><label for="textfield"></label>
                        <?= tothaiyear(date("Y-m-d")); ?>
                        <input type="text" style="width:250px;" name="invoice_issued_date" id="invoice_issued_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden /></td>
                    <td width="200" height="45" align="right"><strong>เบอร์โทร์ศัพท์ :</strong> </td>
                    <td width="250px" style="padding-left:20px;"><?php echo $cus_data['cus_phone']; ?></td>
                </tr>
            </table>

            </table>
            <h4 class="page-header text-center" style="padding-top:30px; padding-bottom:20px;">รายการสั่งซื้อ</h4>
            <table class="table" align="center" border="0">
                <thead>
                    <tr>
                        <th style="text-align:right;width:100px;">รหัสสินค้า</th>
                        <th style="text-align:left; width:120px;">ชื่อสินค้า</th>
                        <th style="text-align:center;width:100px;">รูปภาพ</th>
                        <th style="text-align:left;width:100px;">ประเภท</th>
                        <th style="text-align:right;width:200px;">ราคาต่อหน่วย (บาท)</th>
                        <th style="text-align:right;width:110px;">จํานวน</th>
                        <th style="text-align:right;width:140px;">ราคารวม (บาท)</th>
                        <th style="text-align:left;width:57px;"></th>
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

                            <td style="padding-top:20px;" align="right"><?= $result_orderlist["product_id"]; ?></td>
                            <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                            <td align="center"><img style="width:66px; height:67px;" src="../<?= $result['product_picture']; ?>"></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($result_orderlist['od_price_unit'], 2); ?></td>
                            <td style="padding-top:20px; text-align:right;"><?= $result_orderlist['od_amount'] ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($t1, 2); ?></td>
                            <td></td>
                        </tr>
                    <?php
                    } ?>
        </form>
        <tr align="right">
            <td colspan="6"><b>รวมทั้งหมด</b></td>
            <input type="text" hidden name="order_total" value="<?= $sum1 ?>">
            <td><b id="sum"><?= number_format($data['order_total'], 2); ?></b></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td colspan="6"><b>ค่าจัดส่ง</b></td>
            <td><b><span id="fee"><?= $data['order_deliverycost'] ?></b></span></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td colspan="6"><b>รวมสุทธิ</b></td>
            <td><b id="sum_total"><?= number_format($data['order_deliverycost'] + $data['order_total'], 2) ?></b></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr>
            <td style="padding-top:30px; " colspan="8" align="center"><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึกใบแจ้งหนี้?')) return true; else return false;">บันทึก</button>
                <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>

            </td>
        </tr>
        </table>
        </form>
    </div>
</body>
<script>
    function check_invoice_credit() {
        var invoice_credit = $('#invoice_credit').val();

        if (invoice_credit != '7') {
            alert("กรอกเครดิตได้แค่ 7 วัน");
            $('#invoice_credit').val('');
        }

    }
</script>
<?php
function DateThai($date)
{
    $result = "";
    $strYear = date("Y", strtotime($date)) + 543;
    $strMonth = date("m", strtotime($date));
    $strDay = date("d", strtotime($date));
    $result = $strDay . '/' . $strMonth . '/' . $strYear;
    return $result;
}
?>