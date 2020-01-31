<?php
if (!isset($_SESSION)) {
    session_start();
}

$Line = $_GET["Line"];
unset($_SESSION["product_id"][$Line]);
unset($_SESSION["strqty"][$Line]);

$new_product_id = array_values($_SESSION['product_id']);
 unset($_SESSION['product_id']);
 $_SESSION['product_id'] = $new_product_id;
 
 $new_qty = array_values($_SESSION['strqty']);
 unset($_SESSION['strqty']);
 $_SESSION['strqty'] = $new_qty;


$_SESSION["intline"] = $_SESSION["intline"]-1;

if (count($_SESSION['product_id']) == 0) {
    unset($_SESSION['intline']);
    unset($_SESSION['product_id']);
    unset($_SESSION['strqty']);
    
}




echo "<script>  window.location.assign('basket.php')</script>";
?>
