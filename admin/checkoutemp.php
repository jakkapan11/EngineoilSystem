<head>
    <title>บันทึกการสั่งซื้อ</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['productid'])) {
        echo "<script> alert('ต้องทําการเลือกสินค้าก่อน'); window.location.assign('after_basket.php'); </script>";
        exit();


        $sql_orderdata = "SELECT * FROM orders WHERE order_id = '" . $_GET['orderid'] . "'";
        $q = mysqli_query($link, $sql_orderdata) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($q);
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

            $("#order_type").change(function() { // ประเภทจัดส่ง
                if ($("#order_type").val() == 2) {
                    $('#order_deadline_date').val("");
                    $('#order_deadline_date').attr("disabled", true);
                    //$('#order_deadline_date').removeClass("datepicker-checkout");
                } else {
                    $('#order_deadline_date').attr("disabled", false);
                }
            });


            $("#order_status").change(function() {
                var status = $("#order_status").val();

                if (status == 2) { // =ำระแล้ว
                    $('.credits').hide();
                    $('.credits2').show();

                    $("#invoice_credit").attr("required", false);

                    $('#receipt_tye').removeAttr("disabled");
                    $('#receipt_tye').attr('required', true);

                    $('#receipt_payment_details').prop('disabled', false);
                    $('#receipt_payment_details').attr('required', true);

                } else if (status == 3) { // ค้างชำระ
                    $(".credits").show();
                    $('.credits2').hide();

                    $("#invoice_credit").attr("required", true);

                    // ประเภทการชำระ รายละเอียดการชำระ
                    $('#receipt_tye').prop('disabled', true);
                    $('#receipt_tye').attr('readonly', false);

                    $('#receipt_payment_details').prop('disabled', true);
                    $('#receipt_payment_details').attr('required', false);

                }
            });

            $("#invoice_credit").change(function() {
                var date = new Date(); // วันที่ปัจจุบัน
                var plus = parseInt($('#invoice_credit').val(), 10); //จำวนวัน
                date.setDate(date.getDate() + plus);

                if (date.getDate() < 10) {
                    d = "0" + date.getDate();
                } else {
                    d = date.getDate();
                }
                if ((date.getMonth() + 1) < 10) {
                    m = "0" + (date.getMonth() + 1)
                } else {
                    m = (date.getMonth() + 1);
                }

                var new_date = d + "/" + m + "/" + (date.getFullYear() + 543);

                //console.log(new_date);
                $('.invoice_paymendate').html(new_date);
                // $('#invoice_paymendate').val(new_date);
                // alert(date);

            });
        });
    </script>
</head>

<body>
    <?php
    $sql_cusdata    = "SELECT * FROM customers WHERE cus_id = '" . $_GET['cus_id'] . "'";
    $q_cus = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($q_cus);
    ?>
    <div class="container">
        <h2 class="page-header text-center" style="padding-top:25px;">บันทึกการสั่งซื้อ</h2>
        <hr>
        <form action="save_checkout_order_emp.php" method="POST">
            <table border="0" align="center" style="border:1px solid #C0C0C0; background:#F5F5F5;">
                <tr>
                    <td colspan="4"><label for="select"></label>
                </tr>
                <tr>
                    <td width="229" height="50" align="right"><strong></strong> </td>
                    <td style="padding-left:80px;"><a href="select_member.php" style="padding-left:10px;" class="btn btn-primary"><i class="fa fa-user"></i> เลือกลูกค้า</a></td>
                    <td width="229" align="right"><strong>วันที่สั่งซื้อ :</strong></td>
                    <td width="301" style="padding-left:14px;"><label for="textfield"></label>
                        <?= tothaiyear(date("Y-m-d")); ?>
                        <input type="text" style="width:250px;" name="order_date" id="order_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden /></td>

                </tr>
                <tr>
                    <td align="right"><strong>ประเภทจัดส่ง :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select required name="order_type" onchange="fee()" style="width:250px;" id="order_type" class="form-control">
                            <option value="" disabled selected>-- กรุณาเลือกประเภทจัดส่ง --</option> -->
                            <option value="0">ลงทะเบียน ค่าส่ง 50 บาท</option>
                            <option value="1">EMS ค่าส่ง 100 บาท</option>
                            <option value="2">นําสินค้ากลับบ้านเอง</option>
                        </select>
                    </td>



                    <td width="229" height="40" align="right"><strong>รหัสลูกค้า :</strong> </td>
                    <td width="301" style="padding-left:20px;">
                        <?php
                        $cus_id = "";
                        if (isset($_GET['cus_id'])) {
                            echo $_GET['cus_id'];
                            $cus_id = $_GET['cus_id'];
                        } else {
                            echo "";
                            $cus_id = "";
                        }
                        ?>
                        <input type="hidden" id="cus_id" name="cus_id" value="<?php echo $cus_id; ?>">
                    </td>
                </tr>
                <tr>
                    <td height="45" align="right"><strong>วันที่กําหนดส่ง :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="textfield"></label>
                        <input type="text" onfocus="$(this).blur();" style="width:250px;" onkeypress="return false;" class="form-control datepicker-checkout" name="order_deadline_date" id="order_deadline_date" min="<?= date("Y-m-d"); ?>" required/></td>


                    <td width="229" height="45" align="right"><strong>ชื่อ-นามสกุล :</strong> </td>
                    <td width="301" style="padding-left:20px;">
                        <?php
                        $cus_name = "";
                        if (isset($_GET['cus_name'])) {
                            echo $_GET['cus_name'];
                            $cus_name = $_GET['cus_name'];
                        } else {
                            echo "";
                            $cus_name = "";
                        }
                        ?>
                        <input type="hidden" id="cus_name" name="cus_name" value="<?php echo $cus_name; ?>">
                    </td>

                </tr>
                <tr>
                    <td height="10" align="right"><strong></strong> </td>
                    <td style="padding-left:13px;" align="center">
                        <font size="2" color="red">สามารถเลือกวันกําหนดส่งได้ภายใน 1 เดือน เท่านั้น</font>
                    </td>

                    <td height="10" align="right"><strong></strong> </td>
                    <td></td>
                </tr>
                
                <tr>

                    <td height="50" align="right"><strong>สถานะสั่งซื้อ :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select name="order_status" style="width:250px;" class="form-control" id="order_status" required>
                            <option value="" disabled selected>-- กรุณาเลือกสถานะสั่งซื้อ --</option>
                            <option value="2">ชําระเต็ม</option>
                            <option value="3">ยังไม่ชําระ</option>
                        </select></td>
                    <td width="229" height="45" align="right"><strong>เบอร์โทรศัพท์ :</strong> </td>
                    <td width="301" style="padding-left:20px;">
                        <?php
                        $cus_phone = "";
                        if (isset($_GET['cus_phone'])) {
                            echo $_GET['cus_phone'];
                            $cus_phone = $_GET['cus_phone'];
                        } else {
                            echo "";
                            $cus_phone = "";
                        }

                        ?>
                        <input type="hidden" id="cus_phone" name="cus_phone" value="<?php echo $cus_phone; ?>">
                    </td>
                </tr>

                <tr class="credits2" style="display:none;">
                    <td height="40" align="right"><strong>ประเภทการชําระ :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select name="receipt_tye" style="width:250px; " class="form-control" id="receipt_tye" required>
                            <option value="" disabled selected> กรุณาเลือกประเภทการชําระ</option>
                            <option value="0">เงินสด</option>
                            <option value="1">โอน</option>
                            <option value="2">บัตรเดบิต</option>
                            <option value="3">บัตรเครดิต</option>
                        </select></td>

                    <td align="right"><strong>รายละเอียดการชําระ :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="textarea"></label>
                        <input type="text" name="receipt_payment_details" style="width:250px;" class="form-control" id="receipt_payment_details" required cols="30" rows="3" required></td>
                </tr>



                <tr class="credits" style="display:none;">
                    <td height="40" align="right"><strong>เครดิต (วัน) :</strong><span style="color:red;">*</span></td>
                    <td style="padding-left:20px;"><label for="select"></label>
                        <select name="invoice_credit" style="width:250px; " class="form-control" id="invoice_credit" required>
                            <option value="" disabled selected>-- กรุณาเลือกเครดิต --</option>
                            <option value="1">เครดิต 1 วัน</option>
                            <option value="2">เครดิต 2 วัน</option>
                            <option value="3">เครดิต 3 วัน</option>
                            <option value="4">เครดิต 4 วัน</option>
                            <option value="5">เครดิต 5 วัน</option>
                            <option value="6">เครดิต 6 วัน</option>
                            <option value="7">เครดิต 7 วัน</option>

                        </select></td>

                    <td height="45" align="right">
                        <strong>วันกําหนดชําระ :</strong>
                        <input type="text" style="width:250px;" hidden name="invoice_issued_date" id="invoice_issued_date" value="<?= tothaiyear(date("Y-m-d")); ?>" hidden /></td>
                    </td>
                    <td style="padding-left:20px;">
                        <span class="invoice_paymendate"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><label for="select"></label>
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
                    for ($i = 0; $i <= (int) ($_SESSION['intline2']); $i++) {
                        // if ($_SESSION["strproductid"][$i] != "") {
                        $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_id = '" . $_SESSION["productid"][$i] . "' ";
                        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                        $result = mysqli_fetch_array($query);

                        $total = $_SESSION["strqty2"][$i] * $result["product_price_unit"];
                        //  $sumtotal = $sumtotal + $total;
                    ?>
                        <tr>

                            <td style="padding-top:20px;" align="right"><?= $_SESSION["productid"][$i]; ?></td>
                            <td style="padding-top:20px;"><?= $result["product_name"]; ?></td>
                            <td align="center"><img style="width:66px; height:67px;" src="../<?= $result['product_picture']; ?>"></td>
                            <td style="padding-top:20px;"><?= $result['category_name'] ?></td>
                            <td style="padding-top:20px;" align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
                            <td style="padding-top:20px; text-align:right;"><?= $_SESSION["strqty2"][$i]; ?></td>
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
            <td><b><span id="fee">0.00</b></span></td>
            <td align="left" colspan="2"><b>บาท</b></td>
        </tr>
        <tr align="right">
            <td colspan="6"><b>รวมสุทธิ</b></td>
            <td><b id="sum_total"><?= number_format(array_sum($sumall), 2); ?></b></td>
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
            if (fee_type.value == "2") {
                fee.innerHTML = "0.00";
                var sumtotal = (parseFloat(fee.innerHTML) + sum);
                sum_total.innerHTML = sumtotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });

            } else if (fee_type.value == 0) {
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