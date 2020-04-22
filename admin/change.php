<head>
    <title>บันทึกการเปลี่ยนสินค้า</title>
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
            let receipt_date = $('#receipt_date').val();

            startdate_change = new Date(receipt_date);

            end_change = new Date(receipt_date);
            cc = end_change.setDate(end_change.getDate() + 5);
            end_date = new Date(`${end_change.getFullYear()}-${end_change.getMonth()+1}-${end_change.getDate()}`);

            $('.datepicker-checkout').datepicker({
                language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                format: 'dd/mm/yyyy',
                disableTouchKeyboard: true,
                todayBtn: false,
                clearBtn: true,
                endDate: '+0d',
                startDate: startdate_change,
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

    $sql_invoice = "SELECT * FROM invoice WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_invoice) or die(mysqli_error($link));
    $invoice_data = mysqli_fetch_assoc($q3);

    $sql_receipt = "SELECT receipt_id , receipt_date FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_receipt) or die(mysqli_error($link));
    $receipt_data = mysqli_fetch_assoc($q3);

    $sql_receipt2 = "SELECT * FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q4 = mysqli_query($link, $sql_receipt2) or die(mysqli_error($link));
    $receipt_data2 = mysqli_fetch_assoc($q4);

    // -------------------------------- สำหรับปิด ช่องวันที่เปลี่ยน ----------------------------------
    $sql_orderlist = "SELECT * FROM orderlist  WHERE order_id = '" . $_GET['orderid'] . "'";

    $q5 = mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));
    $change_num_rows = mysqli_num_rows($q5);
    $change_count = 0;
    while ($orderlist = mysqli_fetch_assoc($q5)) {
        if ($orderlist['od_status'] == 1) {
            $change_count++;
        }
    }
    // ----------------------------------------------------------------------------------------

    if ($data['order_delivery_date'] == "0000-00-00")
        $order_delivery_date = "";
    else $order_delivery_date = tothaiyear($data['order_delivery_date']);





    //วันที่ชำระ +5 วัน (การเปลี่ยนสินค้า)
    $strStartDate   =  $receipt_data['receipt_date']; //วันที่ปัจจุบัน
    $strNewDate = date("Y-m-d", strtotime("+5 day", strtotime($strStartDate))); // วันที่ปัจจุบัน + 5 วัน
    $today = date("Y-m-d");
    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:25px;">บันทึกการเปลี่ยนสินค้า</h2>
        <hr>
        <form action="change2.php" method="post" enctype="multipart/form-data">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;width:900px;">
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
                <tr>

                    <td width="190" height="40" align="right"><strong>รหัสการสั่งซื้อ :</strong></td>
                    <td width="30%" style="padding-left:20px;"><?= $data['order_id']; ?></td>
                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $data['order_id']; ?>">

                    <td width="160" align="right"><strong>เลขที่ใบเสร็จรับเงิน :</strong> </span></td>
                    <td width="300" style="padding-left:20px;"><?= $receipt_data2['receipt_id'] ?></td>
                </tr>

                <tr>
                    <td height="40" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                    <td style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>

                    <td height="40" align="right"><strong>สถานะ :</strong> <span style="color:red; "></span></td>
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

                <tr>
                    <td height="40" align="right"><strong>วันที่จัดส่ง :</strong> </span></td>
                    <td style="padding-left:20px;"><?php
                                                    if ($order_delivery_date != "") {
                                                        echo $order_delivery_date;
                                                    } else {
                                                        echo " <left>-</left>";
                                                    } ?></td>

                    <td height="40" align="right"><strong>รวมสุทธิ (บาท) :</strong> </span></td>
                    <td style="padding-left:20px;"><?= number_format($data['order_deliverycost'] + $data['order_total'], 2) ?></td>
                </tr>

                <tr>
                    <td height="40" align="right"><strong>ชื่อ-นามสกุล :</strong></td>
                    <td style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>

                    <td height="40" align="right"><strong>วันทีชําระ :</strong><span style="color:red;"></span></td>
                    <td width="300" style="padding-left:20px;"><?= tothaiyear($receipt_data['receipt_date']) ?></td>
                </tr>
                <tr>
                    <td height="40" align="right"><strong>วันที่เปลี่ยน :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:17px;"><label for="textfield"></label>

                        <input type="text" name="receipt_date" id="receipt_date" hidden value="<?= $receipt_data['receipt_date'] ?>">
                        <input type="text" onfocus="$(this).blur();" style="width:200px;" onkeypress="return false;" class="form-control datepicker-checkout" <?= (($change_num_rows == $change_count) || ($today >= $strNewDate)) ? "disabled" : "" ?> name="change_date" id="change_date" min="<?= date("Y-m-d"); ?>" required /></td>

                    <td align="right"><strong>สถานที่ส่ง :</strong> </span></td>
                    <td style="padding-left:20px;"><?php
                                                    if ($data['order_place'] != "") {
                                                        echo $data['order_place'];
                                                    } else {
                                                        echo " <left>-</left>";
                                                    } ?></td>
                </tr>
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
            </table>

            <h4 class="page-header text-center" style="padding-top:30px; padding-bottom:5px;">รายการสั่งซื้อ</h4>
            <table class="table" align="center" border="0">
                <thead>
                    <tr>
                        <th style="text-align:right;width:50px;">เลือก</th>
                        <th style="text-align:right;width:100px;">รหัสสินค้า</th>
                        <th style="text-align:left; width:230px;">ชื่อสินค้า</th>
                        <th style="text-align:left;width:90px;">ประเภท</th>
                        <th style="text-align:center;width:90px;">หน่วยนับ</th>
                        <th style="text-align:right;width:110px;">จํานวนที่ซื้อ</th>
                        <th style="text-align:center;width:130px;">จํานวนเปลี่ยน</th>
                        <th style="text-align:center;width:100px;">หมายเหตุ</th>
                        <th style="text-align:center;width:110px;">วันเปลี่ยน</th>

                    </tr>
                    <?php
                    $i = 0;
                    $sql_orderlist = "SELECT * FROM orderlist 
                    WHERE order_id = '" . $_GET['orderid'] . "'";
                    $query_orderlist = mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

                    while ($result_orderlist = mysqli_fetch_array($query_orderlist)) {

                        $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_id = '" . $result_orderlist['product_id'] . "' ";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        $result = mysqli_fetch_array($query);

                        $sql_change = "SELECT * FROM amount_change WHERE od_id = '" . $result_orderlist['od_id'] . "'";
                        $query_change = mysqli_query($link, $sql_change) or die(mysqli_error($link));
                        $amount_change = mysqli_fetch_assoc($query_change);

                        $t1 = $result['product_price_unit'] * $result_orderlist['od_amount'];

                        if ($amount_change['change_date'] == "0000-00-00")
                            $change_date = "";
                        else $change_date = tothaiyear($amount_change['change_date']);

                    ?>
                        <tr>
                            <!-- เช็คสถานะการเปลีย่น -->
                            <td align="center" label for="textfield4">
                                <input value="<?= $result_orderlist['od_id'] ?>" onchange='require_amount($(this).attr("id"))' type="checkbox" name="od_status[]" <?= ($result_orderlist['od_status']) || ($today >= $strNewDate) ? "disabled" : "" ?> id="od_status<?= $i ?>" style="margin-top:15px;" />
                                <input hidden type="text" name="od_id[]" id="od_id" value="<?php echo $result_orderlist['od_id'] ?>">
                                <input name="products_id" hidden id="products_id_<?= $result_orderlist['od_id'] ?>" value="<?= $result_orderlist['product_id'] ?>" </td> <td style="padding-top:20px;" align="right"><?= $result_orderlist["product_id"]; ?></td>
                            <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="center"><?= $result["product_unit"]; ?></td>
                            <td style="padding-top:20px; text-align:right;"><?= $result_orderlist['od_amount'] ?><input type="hidden" name="old_amount" id="old_amount<?php echo $result_orderlist['product_id']; ?>" value="<?php echo $result_orderlist['od_amount']; ?>"></td>
                            <td align="center" label for="textfield"></label>
                                <input type="text" style="width:65px; " value="<?= ($amount_change['change_amount'] ? $amount_change['change_amount'] : "") ?>" class="text-center form-control" <?= ($result_orderlist['od_status'] || ($today >= $strNewDate)) ? "disabled" : "" ?> name="change_amount_<?= $result_orderlist['od_id'] ?>" pattern="^[Z0-9]+$" title="กรุณาใส่ตัวเลข" onkeyup="check_amount('<?php echo $result_orderlist['product_id'] ?>');" id="change_amount<?php echo $result_orderlist['product_id'] ?>" autocomplete="off" /></td>

                            <td align="center" label for="textfield4"></label>
                                <input type="text" style="width:150px;" class="text-center form-control" value="<?= ($amount_change['change_amount'] ? $amount_change['change_notes'] : "") ?>" <?= ($result_orderlist['od_status'] || ($today >= $strNewDate)) ? "disabled" : "" ?> name="change_notes_<?= $result_orderlist['od_id'] ?>" id="change_notes" /></td>

                            <td style="padding-top:20px;"align="center"><?php
                                                if ($amount_change['change_date'] == "0000-00-00" || !$amount_change['change_date'])
                                                    echo "-";
                                                else
                                                    echo tothaiyear($amount_change['change_date']);

                                                ?>
                        </tr>

                    <?php
                        $i++;
                    } ?>
        </form>

        <td style="padding-top:30px; " colspan="9" align="center"><span style="color:red;"><u>หมายเหตุ</u> การเปลี่ยนสินค้าจะเปลี่ยนได้ครั้งเดียวเท่านั้น โดยสินค้าเปลี่ยนไม่เกิน 5 วันนับจากวันที่ชําระ</span> </td>

        </table>
        </form>
        <table border="0" align="center">
            <tr>
                <input type="hidden" name="date_change_product" id="date_change_product" value="<?php echo $strNewDate; ?>">
                <td style="padding-top:30px; ">

                    <?php
                    $sql_disable = "SELECT od_id, od_status FROM orderlist WHERE order_id = '" . $data['order_id'] . "' AND od_status = '0'";
                    $query_diable = mysqli_query($link, $sql_disable);

                    //echo "$today > $strNewDate";

                    if (mysqli_num_rows($query_diable) == 0 || ($today >= $strNewDate)) {
                        // กรณี ปิดปุ่ม
                    } else {
                    ?>
                        <button type="submit" id="sub" name="sub" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึกเปลี่ยนสินค้า?')) return true; else return false;">บันทึก</button>
                        <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                    <?php } ?>
                    <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button></td>
            </tr>
        </table>
    </div>

</body>

<script>
    $(document).ready(function() {
        var d = new Date();
        // var current_date = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();

        // var date_change_product = $('#date_change_product').val();
        var date_change_product = new Date($('#date_change_product').val());
        //   var date_change_product_2 = date_change_product.getFullYear() + "-" + (date_change_product.getMonth() + 1) + "-" + date_change_product.getDate();
        // var date_change_product = Date.parse($("input[name='date_change_product']").val()) ;
    });

    function require_amount(checkbox) {

        check_value = $('#' + checkbox).val();
        product_id = $('#products_id_' + check_value).val();
        //  od_id = $('#' + checkbox).next().val();
        // console.log($('#' + checkbox).is(':checked'));
        if ($('#' + checkbox).is(':checked')) {
            $('#' + "change_amount" + product_id).attr("required", true);
            //    console.log("TRUE");
        } else {
            $('#' + "change_amount" + product_id).attr("required", false);
            //     console.log("FALSE");
        }

    }

    function check_amount(product_id) {

        var amount = $('#old_amount' + product_id).val();
        var cheange_amount = parseInt($('#change_amount' + product_id).val());
        var amount_check = parseInt(amount);

        if (cheange_amount < 1) {
            alert('จำนวนที่กรอกต้องมากกว่า 1');
            $('#change_amount' + product_id).val('');

        } else {
            if (cheange_amount > amount) {
                alert('จํานวนเปลี่ยนต้องเท่ากับ จำนวนที่ซื้อ');
                $('#change_amount' + product_id).val('');
            }
        }
    }
</script>