<head>
    <title>เลือก/ยกเลิกรายการสั่งซื้อ</title>
    <?php
    include("conf/head.php");
    include("conf/connection.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    ?>

</head>

<body>
    <h2 class="page-header text-center" style="padding-top:80px;">เลือก/ยกเลิกรายการสั่งซื้อ</h2>
    <hr>
    <table class="table" align="center" border="0" style="width:1230px;">
        <thead>
            <tr>
                <th style="text-align:right;width:100px;">รหัสสินค้า</th>
                <th style="text-align:left;width:20%;">ชื่อสินค้า</th>
                <th style="text-align:center;width:100px;">รูปภาพ</th>
                <th style="text-align:left;width:100px;">ประเภท</th>
                <th style="text-align:right;width:100px;">จํานวน</th>
                <th style="text-align:right;width:180px;">ราคาต่อหน่วย (บาท)</th>
                <th style="text-align:center;width:120px;">จํานวนซื้อ</th>
                <th style="text-align:right;width:140px;">ราคารวม (บาท)</th>

                <th style="text-align:center;width:110px;"></th>
            </tr>
        </thead>
        <?php
        $total = 0;
        $sumtotal = 0;
        if (!isset($_SESSION['product_id'])) {
            echo "<tr><td bgcolor='' align='center' colspan='9'>ไม่มีสินค้าในตะกร้า</td></tr>";
            // exit();
        } else { ?>
            <form action="update_basket.php" method="POST">
                <?php
                    for ($i = 0; $i <= (int) ($_SESSION['intline']); $i++) {
                        // if ($_SESSION["strproductid"][$i] != "") {
                        $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_id = '" . $_SESSION["product_id"][$i] . "' ";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        $result = mysqli_fetch_array($query);
                        $total = $_SESSION["strqty"][$i] * $result["product_price_unit"];
                        //  $sumtotal = $sumtotal + $total;
                        ?>
                    <tr>
                        <td align="right" style="padding-top:20px;"><?= $_SESSION["product_id"][$i]; ?></td>
                        <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                        <td align="center"><img style="width:66px; height:67px;" src="<?= $result['product_picture']; ?>"></td>
                        <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                        <td align="right" style="padding-top:20px;"><?= $result['product_amount']; ?></td>
                        <td style="padding-top:20px;" align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
                        <td align="center"><input type="number" class="form-control" style="width:75px;" onclick="test(this)" onpaste="return false" ; onchange="if(this.value <= 0) {alert('จำนวนไม่สามารถน้อยกว่า 1'); this.value='1';} else if (this.value > <?= $result['product_amount'] ?>) { alert('กรุณาตรวจสอบจำนวน'); this.value = '<?= $result['product_amount'] ?>'; } else { this.form.submit(); }" name="qty_<?= $i ?>" value="<?= $_SESSION["strqty"][$i]; ?>" /></td>
                        <td style="padding-top:20px;" align="right"><?= number_format($total, 2); ?></td>
                        <td align="center"><a onclick="" href="delete_basket.php?Line=<?= $i; ?>" style="width:75px;" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ</a></td>

                    </tr>
                    <?php $sumall[] = $total; ?>
                <?php
                    } ?>


                <tr align="right">
                    <td colspan="7"><b>รวมทั้งหมด</b></td>
                    <td><b><?= number_format(array_sum($sumall), 2); ?></b></td>
                    <td align="left" colspan="2"><b>บาท</b></td>
                </tr>
            <?php
            }
            ?>
            <td colspan="9" align="center">
               <!-- <button type="submit" class="btn btn-warning">คำนวณราคาใหม่</button> -->
                <a href="show_product.php" class="btn btn-primary">เลือกสินค้า</a>
                <a href="record_order.php" class="btn btn-success"> ยืนยัน</a>
                <a href="delete_all_basket.php" class="btn btn-danger" onclick="if(confirm('ยืนยันการล้างตะกร้า?')) return true; else return false;"></i>ล้างตะกร้า</a>
            </td>
            </tr>
            </form>

    </table>