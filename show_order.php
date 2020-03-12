<head>
    <title>แสดงรายการสั่งซื้อ</title>
    <?php
    include("conf/head.php");
    include("conf/connection.php");
    include("conf/etc_funct.php");
    include("conf/mali_cus.php");

    if (!isset($_SESSION['cus_username'])) {
        echo "<script>window.location.assign('login.php')</script>";
    }
    ?>

<body>
    <?php
    $strKeyword = null;
    if (isset($_POST["search_order"])) {
        $strKeyword = $_POST["search_order"];
    }
    if (isset($_GET["search_order"])) {
        $strKeyword = $_GET["search_order"];
    }
    ?>

    <h2 style="padding-top:70px;" class="page-header text-center">แสดงรายการสั่งซื้อ</h2>
    <hr>


    <form get="POST" class="form-inline" action="">
        <table width="1230px" border="0" align="center">
            <tr>
                <td width="100%">

                    <input type="text" class="form-control" placeholder="ค้นหารหัสการสั่งซื้อ" style="width:200px" name="search_order" id="search_order" />
                    <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />

                </td>
        </table>
    </form>
    <br>


    <table class="table table-striped" align="center" border="0" style="width:1230px;">
        <thead>
            <tr>
                <th style="text-align:center;width:110px">วันที่สั่งซื้อ</th>
                <th style="text-align:center; width:125px;">รหัสการสั่งซื้อ</th>
                <th style="text-align:right;width:150px;">ราคารวม (บาท)</th>
                <th style="text-align:right;width:115px;">ค่าส่ง (บาท)</th>
                <th style="text-align:right;width:140px;">รวมสุทธิ (บาท)</th>
                <th style="text-align:left;width:130px;">สถานะสั่งซื้อ</th>
                <th style="text-align:center;width:150px;">หมายเลขจัดส่ง</th>
                <th style="text-align:center;width:160px;">แจ้งหลักฐาน</th>
                <th style="text-align:center;width:150px;">รายละเอียด</th>
            </tr>
        </thead>
        <tbody>
            <?php

            require_once("conf/connection.php");
            $sql = "SELECT * FROM orders WHERE order_id LIKE '%" . $strKeyword . "%' and cus_id = '" . $_SESSION['cus_id'] . "' ORDER BY order_id DESC";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $num_rows = mysqli_num_rows($query);

            if ($num_rows > 0) { // ค้นหพบรายการ ให้แสดง
                while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
                    <tr>
                        <td align="center"><?= tothaiyear($result['order_date']); ?></td>
                        <td align="center"><?= $result['order_id']; ?></td>
                        <td align="right"><?= number_format($result['order_total'], 2); ?></td>
                        <td align="right"><?= $result['order_deliverycost']; ?></td>
                        <td align="right"><?= number_format($result['order_deliverycost'] + $result['order_total'], 2) ?></td>
                        <td><?php
                            if ($result['order_status'] == 0) {
                                echo "<span style='color:orange;'>ยังไม่แจ้งชําระ</span>";
                            } elseif ($result['order_status'] == 1) {
                                echo "<span style='color:3366CC;'>รอการตรวจสอบ</span>";
                            } elseif ($result['order_status'] == 2) {
                                echo "<span style='color:54BD54;'>ชําระแล้ว</span>";
                            } elseif ($result['order_status'] == 3) {
                                echo "<span style='color:9900FF;'>ค้างชําระ</span>";
                            } elseif ($result['order_status'] == 4) {
                                echo "<span style='color:#FF0000;'>ยกเลิก</span>";
                            }
                            ?></td>
                        <td align="center"><?php
                                            if (!empty($result['order_deliverynumber']))
                                                echo $result['order_deliverynumber'];
                                            else echo "-" ?>
                        <td class="text-center">
                            <?php if ($result['order_status'] == 0) { ?>
                                <a href="evidence.php?orderid=<?= $result['order_id'] ?>" class="btn btn-primary"><i class="fa fa-pencil-square"></i> แจ้งหลักฐาน</a>

                                <?php } elseif ($result['order_status'] == 1 || $result['order_status'] == 2) {
                                if ($result['order_evidence'] != "") { ?>
                                    <a href="#img_<?php echo $result['order_id']; ?>" data-toggle="modal"></i><img height="100px" width="75px" src="<?= $result['order_evidence'] ?>"></a>
                                    <div class="modal fade" id="img_<?php echo $result['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <h4 class="modal-title" id="myModalLabel">หลักฐานการชำระ</h4>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <img height="400px" width="300px" src="<?= $result['order_evidence'] ?>">
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

                                <?php } else {echo "-"; }
                            } else { ?>
                                <center>-</center>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="description.php?orderid=<?= $result['order_id'] ?>" class="btn btn-primary"><i class="fa fa-search-plus"></i> รายละเอียด</a></td>
                    </tr>
                <?php }
            } else { ?>
                <td align="center" bgcolor="#E4E3EA" colspan="10">ไม่พบข้อมูล</td>
            <?php  } ?>
        </tbody>
    </table>