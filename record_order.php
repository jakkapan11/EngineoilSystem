<head>
    <title>บันทึกการสั่งซื้อ</title>
    <?php
    include("conf/head.php");
    include("conf/connection.php");
    include_once("conf/etc_funct.php");
    include("conf/mali_cus.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['product_id'])) {
        echo "<script> alert('ต้องทําการเลือกสินค้าก่อน'); window.location.assign('basket.php'); </script>";
        exit();
    }

    $sql_cusdata    = "SELECT * FROM customers WHERE cus_id = '{$_SESSION['cus_id']}'";
    $q = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($q);


    if ($cus_data['cus_status'] == 1) {
        echo "<script> alert('กรุณาติดต่อพนักงาน'); window.location.assign('basket.php');</script>";
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
    </script>
</head>

<body>
    <div class="container">
        <h2 class="page-header text-center" style="padding-top:80px;">บันทึกการสั่งซื้อ</h2>
        <hr>
        <form action="save_checkout_order.php" method="POST">
            <table border="0" align="center" width="100%" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td width="20%" align="right"><strong>รหัสลูกค้า :</strong> </td>
                    <td width="30%" style="padding-left:20px;"><?php echo $_SESSION['cus_id'] ?></td>
                    <td width="13%" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="30%" style="padding-left:20px;"><?php echo $cus_data['cus_name']; ?></td>
                </tr>
                <tr>
                    <td align="right"><strong>วันที่สั่งซื้อ :</strong></td>
                    <td style="padding-left:14px;">
                        <?= tothaiyear(date("Y-m-d")); ?>
                        <input type="text" style="width:250px;" name="order_date" id="order_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden />
                    </td>
                    <td height="45px" align="right"><strong>เบอร์โทรศัพท์ :</strong> </td>
                    <td style="padding-left:20px;"><?php echo $cus_data['cus_phone']; ?></td>
                </tr>
                <tr>
                    <td height="45" align="right"><strong>วันที่กําหนดส่ง :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="textfield"></label>
                        <input type="text" onfocus="$(this).blur();" style="width:250px;" onkeypress="return false;" class="form-control datepicker-checkout" name="order_deadline_date" id="order_deadline_date" min="<?= date("Y-m-d"); ?>" required /></td>

                    <td align="right"><strong>ประเภทจัดส่ง :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select name="order_type" onchange="fee()" style="width:250px;" id="order_type" class="form-control">
                            <!-- <option selected="selected" disabled="disabled">-- กรุณาเลือกสถานะ --</option> -->
                            <option value="0">ลงทะเบียน ค่าส่ง 50 บาท</option>
                            <option value="1">EMS ค่าส่ง 100 บาท</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="20" align="right"><strong></strong> </td>
                    <td style="padding-right:70px;" align="center">
                        <font size="2" color="red">กําหนดส่งได้ภายใน 1 เดือน</font>
                    <td>
                   
                    <td >
                    </td>
                </tr>
                <tr>
                    <td height="30" align="right"><strong>สถานที่ส่ง :</strong><span style="color:red;">*</span></td>
                    <td height="15" colspan="3" style="padding-left:20px;"><label for="textarea"></label>
                        <textarea name="order_place" style="width:250px;" class="form-control" id="order_place" required cols="30" rows="3" required><?= $cus_data['cus_address'] ?></textarea></td>

                </tr>
                <tr>
                    <td height="10px" colspan="4">

                    </td>
                </tr>
            </table>

            <h4 class="page-header text-center" style="padding-top:30px; padding-bottom:20px;">รายการสินค้า</h4>
            <table class="table" align="center" border="0">
                <thead>
                    <tr>
                        <th style="text-align:right;width:100px;">รหัสสินค้า</th>
                        <th style="text-align:left; width:120px;">ชื่อสินค้า</th>
                        <th style="text-align:center;width:100px;">รูปภาพ</th>
                        <th style="text-align:left;width:100px;">ประเภท</th>
                        <th style="text-align:right;width:190px;">ราคาต่อหน่วย (บาท)</th>
                        <th style="text-align:right;width:100px;">จํานวน</th>
                        <th style="text-align:right;width:150px;">ราคารวม (บาท)</th>
                        <th style="text-align:left;width:57px;"></th>
                    </tr>
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

                            <td style="padding-top:20px;" align="right"><?= $_SESSION["product_id"][$i]; ?></td>
                            <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                            <td align="center"><img style="width:66px; height:67px;" src="<?= $result['product_picture']; ?>"></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
                            <td style="padding-top:20px; text-align:right;"><?= $_SESSION["strqty"][$i]; ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($total, 2); ?></td>
                            <td></td>
                        </tr>
                        <?php $sumall[] = $total; ?>
                    <?php
                    } ?>
        </form>
        <?php
        $sum1 = array_sum($sumall);
        ?>
        <tr align="right">
            <td colspan="6"><b>รวมทั้งหมด</b></td>
            <input type="text" hidden name="order_total" value="<?= $sum1 ?>">
            <td><b id="sum"><?= number_format(array_sum($sumall), 2); ?></b></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td colspan="6"><b>ค่าจัดส่ง</b></td>
            <td><b><span id="fee">50.00</b></span></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td colspan="6"><b>รวมสุทธิ</b></td>
            <td><b id="sum_total"><?= number_format(array_sum($sumall) + 50, 2); ?></b></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr>
            <td style="padding-top:30px; " colspan="9" align="center"><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการสั่งซื้อ?')) return true; else return false;">บันทึก</button>
                <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
                <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
            </td>
        </tr>
        </table>
        </form>
    </div>
    <script>
        function fee() {

            var fee_type = document.getElementsByName("order_type")[0];
            var fee = document.getElementById("fee");
            var sum = Number(<?= $sum1 ?>);
            var sum_total = document.getElementById("sum_total");

            //  alert(fee_type.value);

            if (fee_type.value == 0) {
                fee.innerHTML = "50.00";
                var sumtotal = (parseFloat(fee.innerHTML) + sum);
                sum_total.innerHTML = sumtotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });

            } else if (fee_type.value == 1) {
                fee.innerHTML = "100.00";
                var sumtotal = (parseFloat(fee.innerHTML) + sum);
                sum_total.innerHTML = sumtotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });

            }
        }
    </script>
</body>