<head>
    <title>รายงานสินค้าแยกตามประเภท</title>
    <?php
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('index.php')</script>";
        exit();
      }
    ?>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<h4 align="center" class="page-header text-center" style="padding-top:70px;">อู่ชัยยานยนต์</h4>
<h3 align="center" class="page-header text-center" style="padding-top:1px;">รายงานสินค้าแยกตามประเภท</h3>

<body>
    <table width="57%" border="0" align="center">
        <tr>
    <td colspan="8" align="right" style="border-bottom:1px solid;"
<?php
echo "<meta charset='utf-8'>";
date_default_timezone_set("Asia/Bangkok");
function ThDate()
{
//วันภาษาไทย
$ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
$ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
 
//กำหนดคุณสมบัติ
$week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
$months = date( "m" )-1; // ค่าเดือน (1-12)
$day = date( "d" ); // ค่าวันที่(1-31)
$years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
 
return "วันที่พิมพ์
$day  $ThMonth[$months] พ.ศ. $years";
}
echo ThDate(); // วันที่แสดง
?>
</tr>
        <tr>
            <td style="border-bottom:1px solid; padding-right:20px;" width="110" align="right"><b>รหัสประเภท</b></td>
            <td style="border-bottom:1px solid;" width="99"><b>ชื่อประเภท</b></td>
            <td style="border-bottom:1px solid;padding-right:20px;" width="96" align="right"><B>รหัสสินค้า</B></td>
            <td style="border-bottom:1px solid;" width="80"><b>ชื่อสินค้า</b></td>
            <td style="border-bottom:1px solid;" width="150" align="right"><b>ราคาต่อหน่วย (บาท)</b></td>
            <td style="border-bottom:1px solid;" width="114" align="right"><b>จํานวนสินค้า</b></td>
            <td style="border-bottom:1px solid;" width="102" align="center"><b>หน่วยนับ</b></td>
            <td style="border-bottom:1px solid;" width="90"><b>สถานะ</b></td>
        </tr>

        <?php
        $sql = "SELECT * FROM category WHERE category_status = '0'";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
            <tr>
                <td style="padding-right:20px;" align="right"><?= $result['category_id']; ?></td>
                <td><?= $result['category_name']; ?></td>
                <?php
                    $sql_product = "SELECT * FROM product WHERE category_id = '" . $result['category_id'] . "'";
                    $query_product = mysqli_query($link, $sql_product);
                    $i = 0;
                    $use = 0;
                    $not_use = 0;
                    $sum_all[] = 0;
                    while ($result_product = mysqli_fetch_array($query_product, MYSQLI_ASSOC)) {
                        if ($i == 0) { ?>

                        <td style="padding-right:20px;" height="37" align="right"><?= $result_product['product_id'] ?></td>
                        <td><?= $result_product['product_name'] ?></td>
                        <td align="right"><?= number_format($result_product['product_price_unit'], 2); ?></td>
                        <td align="right"><?= $result_product['product_amount'] ?></td>
                        <td align="center"><?= $result_product['product_unit'] ?></td>
                        <td><?php
                                        if ($result_product['product_status'] == 0) {
                                            echo "<span style='color:green;'>ใช้งาน</span>";
                                        } elseif ($result_product['product_status'] == 1) {
                                            echo "<span style='color:red;'>ไม่ใช้งาน</span>";
                                        }
                                        ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="2"></td>
                <td sdtyle="border-bottom:1px soild; padding-right:20px;" height="37" align="right"><?= $result_product['product_id'] ?></td>
                <td style="border-bottom:1px soild;"><?= $result_product['product_name'] ?></td>
                <td style="border-bottom:1px soild;" align="right"><?= number_format($result_product['product_price_unit'], 2); ?></td>
                <td style="border-bottom:1px soild;" align="right"><?= $result_product['product_amount'] ?></td>
                <td style="border-bottom:1px soild;" align="center"><?= $result_product['product_unit'] ?></td>
                <td><?php
                                if ($result_product['product_status'] == 0) {
                                    echo "<span style='color:green;'>ใช้งาน</span>";
                                } elseif ($result_product['product_status'] == 1) {
                                    echo "<span style='color:red;'>ไม่ใช้งาน</span>";
                                }
                                ?></td>
            <?php }
                    if ($result_product['product_status'] == 0) {
                        $use++;
                    } elseif ($result_product['product_status'] == 1) {
                        $not_use++;
                    }
                    $i++;
                    ?>
            </tr>
        <?php
            }
            $sum_all[] = $i;
            $use2[] = $use;
            $not_use2[] = $not_use;
            ?>
        </tr>
        <tr>
            <td colspan="4" style="border-top:1px solid; text-align:right;"><b> รวม </b></td>
            <td style="border-top:1px solid; text-align:right; padding-right:10px;"><b><?= $i  ?></b></td>
            <td style="border-top:1px solid;" colspan="3"><b>รายการ</b></td>
        </tr>
        <tr>
            <td colspan="8" style="border-bottom:1px solid;"></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="4" style="border-top:1px solid; text-align:right;"><b> รวมสินค้าทั้งหมด </b></td>
        <td style="border-top:1px solid; text-align:right; padding-right:10px;"><b><?= array_sum($sum_all) ?></b></td>
        <td style="border-top:1px solid;" colspan="3"><b>รายการ</b></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:right; color:green;"><b> รวมใช้งานทั้งหมด </b></td>
        <td style="text-align:right; padding-right:10px;color:green;"><b><?= array_sum($use2) ?></b></td>
        <td style="" colspan="3"><b style="color:green;">รายการ</b></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom:1px solid; text-align:right "><b style="color:red;"> รวมไม่ใช้งานทั้งหมด </b></td>
        <td style="border-bottom:1px solid; text-align:right; padding-right:10px;"><b style="color:red;"><?= array_sum($not_use2) ?></b></td>
        <td style="border-bottom:1px solid;" colspan="3"><b style="color:red;">รายการ</b></td>
    </tr>
    </table>
</body>