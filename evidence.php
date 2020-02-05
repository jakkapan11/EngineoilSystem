<head>
    <title>แจ้งหลักฐานการชําระ</title>
    <?php
    include("conf/head.php");
    include("conf/connection.php");
    include_once("conf/etc_funct.php");
    include("conf/mali_cus.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['cus_username'])) {
        echo "<script>window.location.assign('login.php')</script>";
    }

    if (!isset($_GET['orderid'])) {
        echo "<script> window.location.assign('show_order.php'); </script>";
    }


    ?>

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
        <h2 class="page-header text-center" style="padding-top:80px;">แจ้งหลักฐานการชําระ</h2>
        <hr>
        <form action="provide_evidence.php" enctype="multipart/form-data" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td colspan="4" height="10px"></td>
                </tr>
                <tr>
                    <td width="220" align="right"><strong>รหัสการสั่งซื้อ :<strong></td>
                    <td width="30%" style="padding-left:20px;"><?= $data['order_id']; ?>
                    <input type="text" name="orders_id" hidden value="<?= $data['order_id']?>"></td>
                    <td width="215" height="45" align="right"><strong>วันที่สั่งซื้อ :</strong> </td>
                    <td width="301" style="padding-left:20px;"><?= tothaiyear($data['order_date']); ?></td>
                </tr>
                <tr>
                    <td height="50" align="right"><strong>แจ้งหลักฐาน :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><input type="file" name="order_evidence" style="width:250px; height:45px;" class="form-control" id="order_evidence" accept="image/gif, image/jpeg, image/png," required /></td>
                    <td width="215" height="50" align="right"><strong>รหัสลูกค้า :</strong> </td>
                    <td width="30%" style="padding-left:20px;"><?php echo $_SESSION['cus_id'] ?></td>

                </tr>
                <tr>
                    <td width="220" align="right"><strong>วันที่แจ้ง :</strong><span style="color:red;"></span></td>
                    <td width="301" style="height:45px; padding-left:14px;"><label for="textfield"></label>
                    <?= tothaiyear (date("Y-m-d")) ?>   
                    <input type="text" style="width:250px;" name="order_notification" id="order_notification" value="<?= tothaiyear (date("Y-m-d")) ?>" hidden /></td>
                    <td width="215" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="350px" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>

                </tr>
                <tr>
                    <td width="220" align="right"><strong>วันที่กําหนดส่ง :</strong></span></td>
                    <td width="301" style="height:45px; padding-left:20px;"><?php 
                                                                          if ($order_deadline_date != "") { 
                                                                          echo $order_deadline_date;
                                                                          } else {echo " <left>-</left>"; } ?></td></td>

                    <td align="right"><strong>สถานที่ส่ง :</strong><span style="color:red;"></span></td>
                    <td width="301" style="padding-left:20px;"><?php 
                                                                if ($data['order_place'] != ""){
                                                                echo $data['order_place'];
                                                                } else { echo " <left>-</left>"; } ?></td>
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
                        <th style="text-align:right;width:190px;">ราคาต่อหน่วย (บาท)</th>
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
                            <td align="center"><img style="width:66px; height:67px;" src="<?= $result['product_picture']; ?>"></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
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
            <td style="padding-top:30px; " colspan="8" align="center"><button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการแจ้งหลักฐาน?')) return true; else return false;">บันทึก</button>
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
            </td>
        </tr>
        </table>
        </form>
    </div>