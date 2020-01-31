<head>
    <title>บันทึกการชําระ</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");

    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }

    ?>

</head>

<body>
    <?php
    $sql_orderdata = "SELECT * FROM orders WHERE order_id = '" . $_GET['orderid'] . "'";
    $q = mysqli_query($link, $sql_orderdata) or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($q);

    $sql_cus = "SELECT * FROM customers WHERE cus_id = '" . $data['cus_id'] . "'";
    $q2 =  mysqli_query($link, $sql_cus) or die(mysqli_error($link));
    $cus_data = mysqli_fetch_assoc($q2);

    $sql_invoice = "SELECT * FROM invoice WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_invoice) or die(mysqli_error($link));
    $invoice_data = mysqli_fetch_assoc($q3);

    $sql_receipt = "SELECT receipt_id FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_receipt) or die(mysqli_error($link));
    $receipt_data = mysqli_fetch_assoc($q3);

    $sql_receipt2 = "SELECT * FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q4 = mysqli_query($link, $sql_receipt2) or die(mysqli_error($link));
    $receipt_data2 = mysqli_fetch_assoc($q4);
    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:70px;">บันทึกการชําระเงิน</h2>
        <hr>
        <form action="payemp2.php" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
                <tr>
                    <td width="180" align="right"><strong>รหัสการสั่งซื้อ :</strong></td>
                    <td width="20%" style="padding-left:20px;"><?= $data['order_id']; ?>
                        <input type="text" name="orders_id" hidden value="<?= $data['order_id'] ?>"></td</td> <td width="200" height="45" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                    <td width="250" style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>
                </tr>
                <tr>
                    <td width="180" align="right"><strong>เลขที่ใบแจ้งหนี้ :</strong></td>
                    <td width="20" style="padding-left:20px;"><?php
                                                                if ($invoice_data['invoice_id'] != "") {
                                                                    echo $invoice_data['invoice_id'];
                                                                } else {
                                                                    echo " <left>-</left>";
                                                                } ?>
                        <input type="text" hidden name="invoice_id" id="invoice_id" value="<?= $invoice_data['invoice_id'] ?>">
                        <input type="text" hidden name="receipt_id" id="receipt_id" value="<?= $receipt_data['receipt_id'] ?>">

                    </td>

                    <td width="20%" height="30" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="250px" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
                </tr>
                <tr>
                    <td width="180" align="right"><strong>วันกําหนดชําระ :</strong></td>
                    <td width="20%" style="padding-left:20px;"><?php
                                                                if ($invoice_data['invoice_id'] != NULL) {
                                                                    echo tothaiyear($invoice_data['invoice_paymendate']) ?>
                                                                <?php } else {
                                                                    echo " <left>-</left>";
                                                                } ?>

                    </td>
                    <td height="25" align="right"><strong>ประเภทการชําระ :</strong> <span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select name="receipt_tye" style="width:227px; " class="form-control" id="receipt_tye" required>
                            <!--<option value="" disabled selected> กรุณาเลือกประเภทการชําระ</option> !-->
                            <option <?php if ($receipt_data2['receipt_tye'] == 0) echo "selected"; ?> value="0">เงินสด</option>
                            <option <?php if ($receipt_data2['receipt_tye'] == 1) echo "selected"; ?> value="1">โอน</option>
                            <option <?php if ($receipt_data2['receipt_tye'] == 2) echo "selected"; ?> value="2">บัตรเดบิต</option>
                            <option <?php if ($receipt_data2['receipt_tye'] == 3) echo "selected"; ?> value="3">บัตรเครดิต</option>
                        </select></td>
                </tr>
                <tr>
                    <td width="180" align="right"><strong>วันทีชําระ :</strong></td>
                    <td width="20%" style="padding-left:14px;"><label for="textfield"></label>
                        <?= tothaiyear(date("Y-m-d")); ?>
                        <input type="text" style="width:250px;" name="payment_date" id="payment_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden /></td>

                    <td align="right"><strong>รายละเอียดการชําระ :</strong> <span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="textarea"></label>
                        <textarea name="receipt_payment_details" style="width:227px;" class="form-control" id="receipt_payment_details" required cols="30" rows="1" required><?= $receipt_data2['receipt_payment_details'] ?></textarea></td>
                </tr>
                <tr>
                    <input type="text" style="width:250px;" hidden name="receipt_date" id="receipt_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden /></td>
                </tr>
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
            </table>

            <h4 class="page-header text-center" style="padding-top:20px; padding-bottom:5px;">รายการสั่งซื้อ</h4>
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
            <td style="padding-top:30px; " colspan="8" align="center"><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันบันทึกชําระ?')) return true; else return false;">บันทึก</button>
                <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
            </td>
        </tr>
        </table>
        </form>
    </div>