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
            $('.datepicker-checkout').datepicker({
                language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                format: 'dd/mm/yyyy',
                disableTouchKeyboard: true,
                todayBtn: false,
                clearBtn: true,
                endDate: '+60d',
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

    $sql_invoice = "SELECT * FROM invoice WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_invoice) or die(mysqli_error($link));
    $invoice_data = mysqli_fetch_assoc($q3);

    $sql_receipt = "SELECT receipt_id , payment_date FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q3 = mysqli_query($link, $sql_receipt) or die(mysqli_error($link));
    $receipt_data = mysqli_fetch_assoc($q3);

    $sql_receipt2 = "SELECT * FROM receipt WHERE order_id = '" . $data['order_id'] . "'";
    $q4 = mysqli_query($link, $sql_receipt2) or die(mysqli_error($link));
    $receipt_data2 = mysqli_fetch_assoc($q4);


    if ($data['order_delivery_date'] == "0000-00-00")
        $order_delivery_date = "";
    else $order_delivery_date = tothaiyear($data['order_delivery_date']);

    //วันที่ชำระ +5 วัน (การเปลี่ยนสินค้า)
    $strStartDate   = $receipt_data['payment_date']; //วันที่ปัจจุบัน
    $strNewDate = date("Y-m-d", strtotime("+5 day", strtotime($strStartDate))); // วันที่ปัจจุบัน + 5 วัน




    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:80px;">บันทึกการเปลี่ยนสินค้า</h2>
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

                    <td align="right"><strong>สถานที่ส่ง :</strong> </span></td>
                    <td style="padding-left:20px;"><?php
                                                    if ($data['order_place'] != "") {
                                                        echo $data['order_place'];
                                                    } else {
                                                        echo " <left>-</left>";
                                                    } ?></td>
                </tr>
                <tr>
                    <td height="40" align="right"><strong>วันที่เปลี่ยน :</strong><span style="color:red;"></span></td>
                    <td style="padding-left:17px;"><label for="textfield"></label>
                        <?= tothaiyear(date("Y-m-d")) ?>
                        <input type="text" style="width:250px;" name="change_date" id="change_date" value="<?= tothaiyear(date("Y-m-d")) ?>" hidden /></td>


                    <td align="right"><strong></strong> </span></td>
                    <td style="padding-left:20px;"></td>
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
                        <th style="text-align:left; width:120px;">ชื่อสินค้า</th>
                        <th style="text-align:left;width:100px;">ประเภท</th>
                        <th style="text-align:center;width:100px;">หน่วยนับ</th>
                        <th style="text-align:right;width:110px;">จํานวนที่ซื้อ</th>
                        <th style="text-align:center;width:150px;">จํานวนเปลี่ยน</th>
                        <th style="text-align:center;width:180px;">หมายเหตุ</th>

                    </tr>
                    <?php
                    $i = 0;
                    $sql_orderlist = "SELECT * FROM orderlist WHERE order_id = '" . $_GET['orderid'] . "'";
                    $query_orderlist = mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));

                    while ($result_orderlist = mysqli_fetch_array($query_orderlist)) {

                        $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_id = '" . $result_orderlist['product_id'] . "' ";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        $result = mysqli_fetch_array($query);

                        $t1 = $result['product_price_unit'] * $result_orderlist['od_amount'];
                    ?>
                        <tr>
                            <!-- เช็คสถานะการเปลีย่น -->
                            <td align="center" label for="textfield4">
                                <input value="<?= $result_orderlist['od_id'] ?>" type="checkbox" name="od_status[]" <?= $result_orderlist['od_status'] ? "disabled" : "" ?> id="od_status" style="margin-top:15px;" /></td>
                            <td hidden><input type="text" name="od_id[]" id="od_id" value="<?php echo $result_orderlist['od_id'] ?>"></td>

                            <td style="padding-top:20px;" align="right"><?= $result_orderlist["product_id"]; ?></td>
                            <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="center"><?= $result["product_unit"]; ?></td>
                            <td style="padding-top:20px; text-align:right;"><?= $result_orderlist['od_amount'] ?><input type="hidden" name="old_amount" id="old_amount<?php echo $result_orderlist['product_id']; ?>" value="<?php echo $result_orderlist['od_amount']; ?>"></td>
                            <td align="center" label for="textfield"></label>
                                <input type="text" style="width:65px; " class="form-control" <?= $result_orderlist['od_status'] ? "disabled" : "" ?> name="change_amount_<?= $result_orderlist['od_id'] ?>" pattern="^[Z0-9]+$" title="กรุณาใส่ตัวเลข" onkeyup="check_amount('<?php echo $result_orderlist['product_id'] ?>');" id="change_amount<?php echo $result_orderlist['product_id'] ?>" autocomplete="off" /></td>

                            <td align="center" label for="textfield4"></label>
                                <input type="text" style="width:200px; " class="form-control" <?= $result_orderlist['od_status'] ? "disabled" : "" ?> name="change_notes_<?= $result_orderlist['od_id'] ?>" id="change_notes" /></td>

                        </tr>
                    <?php
                        $i++;
                    } ?>
        </form>

        <td style="padding-top:30px; " colspan="8" align="center"><span style="color:red;">การเปลี่ยนสินค้าจะเปลี่ยนได้ครั้งเดียวเท่านั้น โดยสินค้าเปลี่ยนภายใน 3-5 วันหลังจากวันที่ชําระ</span> </td>

        </table>
        </form>
        <table border="0" align="center">

            <?php
            $sql_disable = "SELECT od_id, od_status FROM orderlist WHERE order_id = '" . $data['order_id'] . "' AND od_status = '0'";
            $query_diable = mysqli_query($link, $sql_disable);
            if (mysqli_num_rows($query_diable) == 0) {
                $disable = "disabled";
            } else {
                $disable = "";
            }

            ?>
            <tr>
                <input type="hidden" name="date_change_product" id="date_change_product" value="<?php echo $strNewDate; ?>">
                <td style="padding-top:30px; "><button type="submit" id="sub" name="sub" <?= $disable ?> class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึกเปลี่ยนสินค้า?')) return true; else return false;">บันทึก</button>
                    <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                    <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button></td>
            </tr>
        </table>
    </div>
</body>

<script>
    $(document).ready(function() {
        var d = new Date();
        var current_date = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();

        // var date_change_product = $('#date_change_product').val();
        var date_change_product = new Date($('#date_change_product').val());
        var date_change_product_2 = date_change_product.getFullYear() + "-" + (date_change_product.getMonth() + 1) + "-" + date_change_product.getDate();
        // var date_change_product = Date.parse($("input[name='date_change_product']").val()) ;


        //  alert(current_date+"   "+date_change_product_2);

        if (date_change_product_2 < current_date) {
            //  alert('aa');

            $("#sub").attr("disabled", true);

        }

        // ปิดปุ่ม ตรงนี้
        checkbox = $('#od_status');
        if (checkbox.hasAttr) {
            console.log("Undefined");
        } else {
            console.log("NULL");
        }
    });


    function check_amount(product_id) {

        var amount = $('#old_amount' + product_id).val();
        var cheange_amount = parseInt($('#change_amount' + product_id).val());
        var amount_check = parseInt(amount);

        if (cheange_amount < 1) {
            alert('จำนวนที่กรอกต้องมากกว่า 1');
            $('#change_amount' + product_id).val('');

        } else {
            if (cheange_amount > amount) {
                alert('จํานวนเปลี่ยนต้องมากกว่า จำนวนที่ซื้อ');
                $('#change_amount' + product_id).val('');
            }
        }

    }
</script>