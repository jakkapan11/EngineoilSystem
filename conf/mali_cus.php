<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    if (date("m", strtotime($strDate)) < 10) {
        $strMonth = substr(date("m", strtotime($strDate)), 1, 1);
    } else {
        $strMonth = date("m", strtotime($strDate));
    }
    if (date("d", strtotime($strDate)) < 10) {
        $strDay = substr(date("d", strtotime($strDate)), 1, 1);
    } else {
        $strDay =  date("d", strtotime($strDate));
    }

    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai พ.ศ. $strYear";
}
function MonthThai($strMonth)
{
    // $strYear = date("Y", strtotime($strDate)) + 543;


    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strMonthThai";
}

/*function DateThaii($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        if (date("m", strtotime($strDate)) < 10) {
            $strMonth = substr(date("m", strtotime($strDate)), 1, 1);
        } else {
            $strMonth = date("m", strtotime($strDate));
        }
        if (date("d", strtotime($strDate)) < 10) {
            $strDay = substr(date("d", strtotime($strDate)), 1, 1);
        } else {
            $strDay =  date("d", strtotime($strDate));
        }

        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พ.ย.", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }*/






function short_datetime_thai($dates)
{

    $dates_n = tothaiyear($dates);

    $d = substr($dates_n, 0, 2);
    $m = substr($dates_n, 3, 2);
    $y = substr($dates_n, 6, 4);
    $hi = substr($dates_n, 11, 5);


    if ($d < 10) {
        $d = substr($d, 1, 1);
        $d = "0" . $d;
    }
    if ($m < 10) {
        $m = substr($m, 1, 1);
    }


    $months = array(
        '',
        'ม.ค.',
        'ก.พ.',
        'มี.ค.',
        'เม.ย.',
        'พ.ค.',
        'มิ.ย.',
        'ก.ค. ',
        'ส.ค.',
        'ก.ย.',
        'ต.ค.',
        'พ.ย.',
        'ธ.ค.',
    );


    if ($dates == "") {
        return "";
    } else {
        return $d . " " . $months[$m] . " " . ($y);
    }
}


?>
<script>
    document.onkeydown = function(e) {
        if (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 117) || e.keyCode === 123) { // Key 123 = F12, Key 85 = U
            return false;
        }
    };
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
    
</script>