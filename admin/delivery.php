<head>
    <title>บันทึกการจัดส่งสินค้า</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include("config/etc_funct_admin.php");

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
                clearBtn: true,
                endDate: '+30d',
                startDate: 'now',
                autoclose: true, //Set เป็นปี พ.ศ.
                inline: true
            }) //กำหนดเป็นวันปัจุบัน       
        });

        function notThai(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
           // console.log(charCode);
            if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) ||  (charCode >= 48 && charCode <= 57) ) {
             //   console.log("True");
                return true;
                
            } else {
                return false;
            }
        }
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

    $sql_invoice = "SELECT * FROM invoice WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_invoice) or die(mysqli_error($link));
    $invoice_data = mysqli_fetch_assoc($q3);

    $sql_receipt = "SELECT receipt_id FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_receipt) or die(mysqli_error($link));
    $receipt_data = mysqli_fetch_assoc($q3);

    $sql_receipt2 = "SELECT * FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q4 = mysqli_query($link, $sql_receipt2) or die(mysqli_error($link));
    $receipt_data2 = mysqli_fetch_assoc($q4);


    if ($data['order_deadline_date'] == "0000-00-00")
        $order_deadline_date = "";
    else $order_deadline_date = tothaiyear($data['order_deadline_date']);

    if ($receipt_data2['receipt_date'] == "0000-00-00")
        $receipt_date = "";
    else $receipt_date = tothaiyear($receipt_data2['receipt_date']);
    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:80px;">บันทึกการจัดส่งสินค้า</h2>
        <hr>
        <form action="delivery2.php" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
                <tr>
                    <td width="180" height="45" align="right"><strong>รหัสการสั่งซื้อ :</strong></td>
                    <td width="20%" style="padding-left:20px;"><?= $data['order_id']; ?>
                        <input type="text" hidden name="order_id" id="order_id" value="<?= $data['order_id'] ?>">

                    <td width="160" align="right"><strong>วันที่กําหนดส่ง :</strong> </span></td>
                    <td width="200" style="padding-left:20px;"><?php
                                                               if ($order_deadline_date != "") {
                                                                echo $order_deadline_date;
                                                            } else {echo " <left>-</left>"; } ?></td>
                </tr>
                <tr>
                    <td width="200" height="45" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                    <td width="250" style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>
                   
                    <td width="160" height="45" align="right"><strong>วันที่ออกใบเสร็จ :</strong> </td>
                    <td width="200" style="padding-left:20px;"><?php
                                                             if ($receipt_date != "") {
                                                             echo $receipt_date;
                                                            } else {echo " <left>-</left>"; } ?></td>
                </tr>
                <tr>
                    <td width="20%" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="250px" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
                    <td width="200" align="right"><strong>สถานะ :</strong> <span style="color:red; "></span></td>
                    <td><?php
                        if ($data['order_status'] == 0) {
                            echo "<span style='padding-left:20px;color:orange;'>ยังไม่แจ้งชําระ</span>";
                        } elseif ($data['order_status'] == 1) {
                            echo "<span style='padding-left:20px;color:3366CC;'>รอการตรวจสอบ</span>";
                        } elseif ($data['order_status'] == 2) {
                            echo "<span style='padding-left:20px;color:54BD54;'>ชําระแล้ว</span>";
                        } elseif ($data['order_status'] == 3) {
                            echo "<span style='padding-left:20px;color:9900FF;'>ค้างชําระ</span>";
                        } elseif ($data['order_status'] == 4) {
                            echo "<span style='padding-left:20px;color:FF0000;'>ยกเลิก</span>";
                        }
                        ?></td>
                </tr>
                <td width="160" height="45" align="right"><strong>ประเภทชําระ :</strong><span style="color:red; "></span></td>
                <td><?php
                    if ($receipt_data2['receipt_tye'] == 0) {
                        echo "<span style='padding-left:20px;color:CC6666;'>เงินสด</span>";
                    } elseif ($receipt_data2['receipt_tye'] == 1) {
                        echo "<span style='padding-left:20px;color:339999;'>เงินโอน</span>";
                    } elseif ($receipt_data2['receipt_tye'] == 2) {
                        echo "<span style='padding-left:20px;color:FF9999;'>บัตรเดบิต</span>";
                    } elseif ($receipt_data2['receipt_tye'] == 3) {
                        echo "<span style='padding-left:20px;color:0000DD;'>บัตรเครดิต</span>";
                    }
                    
                    ?></td>
                <td width="160" height="45" align="right"><strong>หมายเลขจัดส่ง :</strong><span style="color:red;">*</span> </td>
                <td width="200" style="padding-left:20px;"><label for="textfield3"></label>
                    <input type="text" style="width:200px; " onkeypress="return notThai(event);" class="form-control" name="order_deliverynumber" id="order_deliverynumber" minlength="13" maxlength="13" required /></td>
                </tr>
                <tr>
                    <td width="229" align="right"><strong>วันที่จัดส่ง :</strong><span style="color:red;">*</span></td>
                    <td width="301" style="padding-left:20px;"><label for="textfield"></label>
                        <input type="text" style="width:200px;" onfocus="$(this).blur();" onkeypress="return false;" class="form-control datepicker-checkout" name="order_delivery_date" id="order_delivery_date" min="<?= date("Y-m-d"); ?>" required /></td>

                    <td width="200" height="45" align="right"><strong></strong> </td>
                    <td width="250" style="padding-left:20px;"></td>

                </tr>

                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
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
            <td style="padding-top:30px; " colspan="8" align="center"><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึกจัดส่งสินค้า?')) return true; else return false;">บันทึก</button>
                <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>

            </td>
        </tr>
        </table>
        </form>
    </div>
</body>