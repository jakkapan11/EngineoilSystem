<?php
session_start();
if (!isset($_SESSION['cus_id'])) {
    echo "<script> alert('กรุณาเข้าสู่ระบบก่อนสั่งสินค้า'); window.location.assign('login.php');</script>";
    exit();
}

if (!isset($_POST['product_id'])) {
    header("location:show.php");
    exit();
}

if ($_POST['qty'] == 0) {
    echo "<script> alert('กรุณาใส่จำนวน'); window.history.back();</script>";
    exit();
}

include("conf/connection.php");
$sql_products = "SELECT * FROM product WHERE product_id = '" . $_POST['product_id'] . "'";
$result = mysqli_fetch_assoc(mysqli_query($link, $sql_products));

if (!isset($_SESSION["product_id"])) {
    $_SESSION["intline"] = 0;
    $_SESSION["product_id"][0] = $_POST["product_id"];
    $_SESSION["strqty"][0] = $_POST['qty'];
    header("location:basket.php");
} else {
    $key = array_search($_POST["product_id"], $_SESSION["product_id"]);
    if ((string) $key != "") {
        if (($_SESSION["strqty"][$key] + $_POST['qty']) <= $result['product_amount']) {
            $_SESSION["strqty"][$key] = $_SESSION["strqty"][$key] + $_POST['qty'];
        } else {
            echo "<script>alert('จำนวนสินค้าต้องไม่เกิน ". $result['product_amount'] ." แกลลอน'); window.history.back();</script>";
            exit();
         }
    } else {
        $_SESSION["intline"] = $_SESSION["intline"] + 1;
        $intNewLine = $_SESSION["intline"];
        $_SESSION["product_id"][$intNewLine] = $_POST["product_id"];
        $_SESSION["strqty"][$intNewLine] = $_POST['qty'];
    }
    header("location:basket.php");
}
