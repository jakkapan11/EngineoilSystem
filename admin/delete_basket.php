<?php
if (!isset($_SESSION)) {
    session_start();
}

$Line = $_GET["Line"];
unset($_SESSION["productid"][$Line]);
unset($_SESSION["strqty2"][$Line]);

$new_product_id = array_values($_SESSION['productid']);
 unset($_SESSION['productid']);
 $_SESSION['productid'] = $new_product_id;
 
 $new_qty = array_values($_SESSION['strqty2']);
 unset($_SESSION['strqty2']);
 $_SESSION['strqty2'] = $new_qty;


$_SESSION["intline2"] = $_SESSION["intline2"]-1;

if (count($_SESSION['productid']) == 0) {
    unset($_SESSION['intline2']);
    unset($_SESSION['productid']);
    unset($_SESSION['strqty2']);
    
}




echo "<script>  window.location.assign('after_basket.php')</script>";
?>
