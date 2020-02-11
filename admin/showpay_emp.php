<head>
    <title>แสดงการชําระ</title>
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
    if (isset($_POST["search_receipt"])) {
        $strKeyword = $_POST["search_receipt"];
    }
    if (isset($_GET["search_receipt"])) {
        $strKeyword = $_GET["search_receipt"];
    }
    ?>

    <h2 style="padding-top:80px;" class="page-header text-center">แสดงการชําระ</h2>
    <hr>

    <form get="POST" class="form-inline" action="">
        <table width="1530px" border="0" align="center">
            <tr>
                <td width="100%">

                    <input type="text" class="form-control" placeholder="ค้นหาเลขที่ใบเสร็จรับเงิน" style="width:200px" name="search_receipt" id="search_receipt" />
                    <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />

                </td>
        </table>
    </form>
    <br>


    <table class="table table-striped table-bordered" align="center" border="0" style="width:1530px;">
        <thead>
            <tr>
                <th style="text-align:center;width:280px;">เลขที่ใบเสร็จรับเงิน</th>
                <th style="text-align:center;width:190px;">รหัสการสั่งซื้อ</th>
                <th style="text-align:center;width:150px">วันที่สั่งซื้อ</th>
                <th style="text-align:center;width:150px">วันที่ชําระ</th>
                <th style="text-align:center;width:235px;">เลขที่ใบแจ้งหนี้</th>
                <th style="text-align:center;width:190px;">วันกําหนดชําระ</th>
                <th style="text-align:left;width:240px;">ประเภทการชําระ</th>
                <th style="text-align:center;width:250px;">หลักฐานการชําระ</th>
                <th style="text-align:center;width:160px;">จัดส่ง</th>
                <th style="text-align:center;width:140px;">เปลี่ยน</th>
                <th style="text-align:center;width:150px;">พิมพ์</th>
            </tr>
        </thead>
        <tbody>
            <?php

            require_once("config/connect.php");
            $sql = "SELECT inv.invoice_date , ord.order_date , re.receipt_id , ord.order_id , ord.order_type,
                    inv.invoice_id , inv.invoice_paymendate , re.receipt_tye , ord.order_deliverynumber , ord.order_evidence , ord.order_status 
                    FROM receipt AS re 
                    LEFT JOIN orders AS ord  
                    ON re.order_id = ord.order_id 
                    LEFT JOIN invoice AS inv
                    ON inv.order_id = re.order_id
                    WHERE ord.order_status IN('2') AND re.receipt_id LIKE '%" . $strKeyword . "%'
                    ORDER BY receipt_id DESC";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            $num_rows = mysqli_num_rows($query);

            if ($num_rows > 0) { // ค้นหพบรายการ ให้แสดง
                while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {

                    if ($result['invoice_date'] == "0000-00-00")
                        $invoice_date = "-";
                    else $invoice_date = tothaiyear($result['invoice_date']);

            ?>

                    <tr>
                        <?php
                        if ($result['receipt_tye'] == '0') {
                            $type_show = '<font color="CC6666"> เงินสด </font>';
                        } elseif ($result['receipt_tye'] == '1') {
                            $type_show = '<font color="339999">เงินโอน</font>';
                        } elseif ($result['receipt_tye'] == '2') {
                            $type_show = '<font color="FF9999">บัตรเดบิต</font>';
                        } elseif ($result['receipt_tye'] == '3') {
                            $type_show = '<font color="0000DD">บัตรเครดิต</font>';
                        }

                        ?>
                        <td align="center"><?php echo $result['receipt_id'] ?></td>
                        <td align="center"><?= $result['order_id']; ?></td>
                        
                        <td align="center"><?= tothaiyear($result['order_date']); ?></td>
                        <td align="center"><?php
                                            if (!empty($result['invoice_date']))
                                                echo tothaiyear($result['invoice_date']);
                                            else echo "-" ?>

                        <td align="center"><?php
                                            if (!empty($result['invoice_id']))
                                                echo $result['invoice_id'];
                                            else echo "-" ?>
                        </td>
                        <td align="center"><?php
                                            if ($result['invoice_id'] != NULL)
                                                echo tothaiyear($result['invoice_paymendate']);
                                            else echo "-";
                                            ?></td>

                        <td align="left">
                            <?php
                            if ($result['order_status'] != 3)
                                echo $type_show;
                            else
                                echo "-"
                            ?>
                        </td>

                        <td class="text-center">
                            <?php if ($result['order_status'] == 2) { ?>
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

                        <td align="center">
                            <?php
                            if ($result['order_deliverynumber'] == "" && $result['order_type'] != 2) {
                            ?>
                                <a href="delivery.php?orderid=<?= $result['order_id'] ?>" class="btn btn-success"><i class="fa fa-truck"></i> จัดส่ง</a>
                            <?php } else {
                                echo "  <center>-</center>";
                            } ?>
                        </td>

                        <td align="center">
                            <a href="change.php?orderid=<?= $result['order_id'] ?>" class="btn btn-success"><i class="fa fa-wpforms"></i> เปลี่ยน</a>
                        </td>

                        <td align="center">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-print"></i> พิมพ์
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" target="_blank" href="bill.php?orderid=<?= $result['order_id'] ?>">พิมพ์ใบเสร็จรับเงิน</a></li>
                                    
                                    <?php if ($result['order_deliverynumber'] != '') { ?>
                                        <li><a class="dropdown-item" target="_blank" href="delivery_emp.php?orderid=<?= $result['order_id'] ?>">พิมพ์ใบส่งของ</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php }
                } else { ?>
                        <td align="center" bgcolor="#E4E3EA" colspan="11">ไม่พบข้อมูล</td>
                    <?php  } ?>
        </tbody>