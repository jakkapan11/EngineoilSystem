<head>
    <title>แสดง/ยกเลิกรายการสั่งซื้อ</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include("config/etc_funct_admin.php");

    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
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

    <h2 style="padding-top:25px;" class="page-header text-center">แสดง/ยกเลิกรายการสั่งซื้อ</h2>
    <hr>


    <form get="POST" class="form-inline" action="">
        <table width="1550px" border="0" align="center">
            <tr>
                <td width="100%">

                    <input type="text" class="form-control" placeholder="ค้นหารหัสการสั่งซื้อ" style="width:200px" name="search_order" id="search_order" />
                    <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />

                </td>
        </table>
    </form>
    <br>


    <table class="table table-striped table-bordered" align="center" border="0" style="width:1550px;">
        <thead>
            <tr>
                <th style="text-align:center;width:140px">วันที่สั่งซื้อ</th>
                <th style="text-align:center;width:150px">วันกําหนดชําระ</th>
                <th style="text-align:center;width:150px;">รหัสการสั่งซื้อ</th>
                <th style="text-align:left;width:240px;">ชื่อ-นามสกุล</th>
                <th style="text-align:center;width:190px;">หลักฐานการชําระ</th>
                <th style="text-align:right;width:150px;">รวมสุทธิ (บาท)</th>
                <th style="text-align:left;width:160px;">สถานะสั่งซื้อ</th>
                <th style="text-align:center;width:170px;">ยกเลิกสั่งซื้อ</th>
                <th style="text-align:center;width:150px;">รับชําระ</th>
                <th style="text-align:center;width:200px;">พิมพ์ใบแจ้งหนี้</th>
            </tr>
        </thead>
        <tbody>
            <?php

            require_once("config/connect.php");
            $sql = "SELECT * FROM orders WHERE orders.order_id LIKE '%" . $strKeyword . "%' ORDER BY orders.order_id DESC";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $num_rows = mysqli_num_rows($query);

            if ($num_rows > 0) { // ค้นหพบรายการ ให้แสดง
                while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    $sql_cusdata    = "SELECT * FROM customers WHERE cus_id = '{$result['cus_id']}'";
                    $q = mysqli_query($link, $sql_cusdata);
                    $cus_data = mysqli_fetch_assoc($q);

                    $sql_invoice_paymendate = "SELECT invoice_paymendate FROM invoice 
                                                WHERE order_id = '" . $result['order_id'] . "'";
                    $query_invoice_paymendate = mysqli_query($link, $sql_invoice_paymendate);
                    $result_invoice_paymendate = mysqli_fetch_assoc($query_invoice_paymendate);
            ?>
                    <tr>
                        <td align="center"><?= tothaiyear($result['order_date']); ?></td>

                        <?php if ($result_invoice_paymendate['invoice_paymendate'] != null) {
                        ?>
                            <td align="center"><?php echo tothaiyear($result_invoice_paymendate['invoice_paymendate']) ?></td>
                        <?php } else {
                            echo "<td align='center'>-</td>";
                        } ?>

                        <td align="center" style="text-decoration:underline;"><a href="description_emp.php?orderid=<?= $result['order_id'] ?>"><?= $result['order_id']; ?></a></td>
                        <td align="left"><?php echo $cus_data['cus_name']; ?></td>
                        <td class="text-center">

                            <?php if ($result['order_status'] == 1 || $result['order_status'] == 2) { ?>
                                <?php if ($result['order_evidence'] != "") { ?>
                                    <a href="#img_<?php echo $result['order_id']; ?>" data-toggle="modal"></i><img height="100px" width="75px" src="../<?= $result['order_evidence'] ?>"></a>
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
                                                        <img height="400px" width="300px" src="../<?= $result['order_evidence'] ?>">
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

                                <?php } else {
                                    echo "-";
                                }
                            } else { ?>
                                <center>-</center>
                            <?php } ?>
                        </td>


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
                                echo "<span style='color:FF0000;'>ยกเลิก</span>";
                            }
                            ?></td>

                        <td align="center">
                            <?php if ($result['order_status'] != 4 && $result['order_status'] != 2) { ?>
                                <button id="cancel_order" name="cancel_order" onclick="if(confirm('ต้องการยกเลิกหรือไม่?')){ cancel_order('<?php echo $result['order_id']; ?>');}else{ return false;}" style="width:125px" class="btn btn-danger"><i class="fa fa-times"></i> ยกเลิกสั่งซื้อ</button>
                            <?php } else { ?>
                                <center>-</center>
                            <?php } ?>
                        </td>

                        <td align="center">
                            <?php if ($result['order_status'] != 0 &&  $result['order_status'] != 2 &&  $result['order_status'] != 4) { ?>
                                <a href="payemp.php?orderid=<?= $result['order_id'] ?>" class="btn btn-success"><i class="fa fa-wpforms"></i> รับชําระ</a>
                            <?php } else { ?>
                                <center>-</center>
                            <?php } ?>
                        </td>



                        <td align="center">
                            <?php
                            if ($result_invoice_paymendate['invoice_paymendate']) {
                                ?>
                                    <a target="_blank" href="invoice.php?orderid=<?= $result['order_id'] ?>" class="btn btn-primary"><i class="fa fa-print"></i> พิมพ์ใบแจ้งหนี้</a>
                                <?php } else { ?>
                                    <center>-</center>
                                <?php } ?>
                        </td>
                <?php } 
                    } else { ?>
                <td align="center" bgcolor="#E4E3EA" colspan="10">ไม่พบข้อมูล</td>
            <?php  } ?>
        </tbody>
    </table>
    <script>
        function cancel_order(order_id) {
            $.ajax({
                url: "ajax_cancel_order.php",
                data: {
                    update_order_id: order_id
                },
                dataType: "text",
                type: "POST",
                success: function(result) {
                    alert("ยกเลิกรายการสั่งซื้อ รหัส " + order_id + " เรียบร้อยแล้ว");
                    location.reload();
                }
            });

        }
    </script>