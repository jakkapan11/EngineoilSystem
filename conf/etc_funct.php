<?php
function tothaiyear($dates) // สำหรับ input type date ค.ศ -> พ.ศ.
{
    $date = date("d-m-Y", strtotime($dates));
    $d1 = substr($date, 0, 2);
    $m1 = substr($date, 3, 2);
    $y = substr($date, 6, 4);
    $y1 = $y + 543;
    $h1 = substr($date, 10, 6);
    if ($date == "") {
        return "";
    } else {
        return $d1 . "/" . $m1 . "/" . $y1;
    }
}

function tochristyear($dates)  // สำหรับ input type date พ.ศ. -> ค.ศ
{
    $d1 = substr($dates, 0, 2);
    $m1 = substr($dates, 3, 2);
    $y = substr($dates, 6, 4);
    $y1 = $y - 543;
    $h1 = substr($dates, 10, 6);
    if ($dates == "") {
        return "";
    } else {
        return $y1 . "-" . $m1 . "-" . $d1;
    }
}

?>