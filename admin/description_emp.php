<head>
    <title>รายละเอียดการสั่งซื้อ</title>
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

    if ($data['order_deadline_date'] == "0000-00-00")
        $order_deadline_date = "";
    else $order_deadline_date = tothaiyear($data['order_deadline_date']);
    ?>

    <div class="container">
        <h2 class="page-header text-center" style="padding-top:25px;">รายละเอียดการสั่งซื้อ</h2>
        <hr>
        <form action="#" enctype="multipart/form-data" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td colspan="4" height="10px"></td>
                </tr>
                <td width="200" align="right"><strong>รหัสการสั่งซื้อ :</strong></td>
                <td width="25%" style="padding-left:20px;"><?= $data['order_id']; ?>

                <td width="215" height="45" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                <td width="270" style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>
                </tr>

                <tr>
                    <td width="220" align="right"><strong>วันที่กําหนดส่ง :</strong></span></td>
                    <td width="25%" style="height:45px; padding-left:20px;"><?php
                                                                            if ($order_deadline_date != "") {
                                                                                echo $order_deadline_date;
                                                                            } else {
                                                                                echo " <left>-</left>";
                                                                            } ?></td>

                    <td width="215" height="50" align="right"><strong>รหัสลูกค้า :</strong> </td>
                    <td width="270" style="padding-left:20px;"><?php echo $cus_data['cus_id'] ?></td>
                </tr>

                <tr>
                    <td align="right"><strong>สถานะ :</strong><span style="color:red; "></span></td>
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

                    <td width="215" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="270" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
                </tr>

                <tr>
                    <td align="right"><strong>สถานที่ส่ง :</strong><span style="color:red;"></span></td>
                    <td width="25%" style="padding-left:20px;"><?php
                                                                if ($data['order_place'] != "") {
                                                                    echo $data['order_place'];
                                                                } else {
                                                                    echo " <left>-</left>";
                                                                } ?></td>

                    <td width="229" height="45" align="right"><strong>เบอร์โทรศัพท์ :</strong> </td>
                    <td width="270" style="padding-left:20px;"><?php echo $cus_data['cus_phone']; ?></td>
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
                        <th style="text-align:right;width:120px;">จํานวน</th>
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
            <td style="padding-top:30px; " colspan="9" align="center"> <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
            </td>
        </tr>
        </table>
        </form>
    </div>