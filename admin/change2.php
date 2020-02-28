<?php
session_start();
require('config/connect.php');
include_once("config/etc_funct_admin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['od_status'])) {
        for ($i = 0; $i < count($_POST['od_status']); $i++) {

            $od = $_POST['od_status'];

            if (isset($od[$i]) && $_POST['change_amount_' . $od[$i]] != "") { //ถ้ามีค่าที่ใส่มาจะ insert ลงฐานข้อมูล
                $sql_change = "INSERT INTO amount_change SET 
                    change_date	        = '" . tochristyear($_POST['change_date']) . "',
                    change_amount		= '" . $_POST['change_amount_' . $od[$i]] . "',
                    change_notes	    = '" . $_POST['change_notes_' . $od[$i]] . "',
                    od_id	        	= '" . $od[$i] . "' ";
                //  echo $i."<br>";

                // echo $_POST['change_amount'][$i]. "<br>";
                //echo $_POST['od_id'][$i]."<BR>";

                if (mysqli_query($link, $sql_change) or die(mysqli_error($link))) {
                    $new_bank = mysqli_insert_id($link);
                }

                $sql_orderlist = "UPDATE orderlist SET
                    od_status = '1' WHERE od_id = '" . $od[$i] . "'";
                mysqli_query($link, $sql_orderlist) or die(mysqli_error($link));
            }
        }
        echo '<script> 
        alert("บันทึกการเปลี่ยนสินค้า\nรหัสสั่งซื้อ ' .  $_POST['order_id'] . ' รหัสการเปลี่ยน ' . str_pad($new_bank, 5, 0, STR_PAD_LEFT) .   '"); 
        window.location.assign("showpay_emp.php");
        </script>';
    } else {
        //   echo "<script>      </script>";
        echo "<script> alert('กรุณาเลือกสินค้าที่ต้องการเปลี่ยน'); window.history.back(); </script>";
    }
}