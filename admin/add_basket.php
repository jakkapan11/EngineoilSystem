<?php
session_start();
if (!isset($_POST['product_id'])) {
    header("location:show.php");
    exit();
}

if ($_POST['qty'] == 0) {
    echo "<script> alert('กรุณาใส่จำนวน'); window.history.back();</script>";
    exit();
}

include("config/connect.php");
$sql_products = "SELECT * FROM product WHERE product_id = '" . $_POST['product_id'] . "'";
$result = mysqli_fetch_assoc(mysqli_query($link, $sql_products));

if (!isset($_SESSION["productid"])) {
    $_SESSION["intline2"] = 0;
    $_SESSION["productid"][0] = $_POST["product_id"];
    $_SESSION["strqty2"][0] = $_POST['qty'];
    header("location:after_basket.php");
} else {
    $key = array_search($_POST["product_id"], $_SESSION["productid"]);
    if ((string) $key != "") {
        if (($_SESSION["strqty2"][$key] + $_POST['qty']) <= $result['product_amount']) {
            $_SESSION["strqty2"][$key] = $_SESSION["strqty2"][$key] + $_POST['qty'];
        } else {
            echo "<script>alert('จำนวนสินค้าต้องไม่เกิน " . $result['product_amount'] . " แกลลอน'); window.history.back();</script>";
            exit();
        }
    } else {
        $_SESSION["intline2"] = $_SESSION["intline2"] + 1;
        $intNewLine = $_SESSION["intline2"];
        $_SESSION["productid"][$intNewLine] = $_POST["product_id"];
        $_SESSION["strqty2"][$intNewLine] = $_POST['qty'];
    }
    header("location:after_basket.php");
}
