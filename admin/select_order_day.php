<head>
    <title>รายงานการสั่งซื้อประจําวัน</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");
    include("config/mali.php");

    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }

    ?>
    <script>
        var endYear = new Date((2019+10), 11, 32);
        var startYear = new Date(2019, 0, 1);
        $(document).ready(function() {
            $('.datepicker').datepicker({
                language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                format: 'dd/mm/yyyy',
                disableTouchKeyboard: true,
                todayBtn: false,
                clearBtn: true,
                startView: 0,
                endDate: endYear, // สมัครได้ เมื่ออายุมากกว่า 10ปี
                startDate: startYear,
                autoclose: true, //Set เป็นปี พ.ศ.
                inline: true
            }) //กำหนดเป็นวันปัจุบัน
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#form1").validate({
                messages: {
                    startdate: {
                        required: "<font size='2' style='padding-left:43px;' color='red'>กรุณาเลือกวันที่ต้องการเริ่มต้นการค้นหา</font>",
                    },
                    enddate: {
                        required: "<font size='2' style='padding-left:43px;' color='red'>กรุณาเลือกวันที่ต้องการสิ้นสุดการค้นหา</font>",
                    },

                },
                onfocusout: function(element) {
                    // "eager" validation
                    this.element(element);
                },
            });
        });
    </script>
</head>

<body>
    <h2 class="page-header text-center" style="padding-top:25px;">เงื่อนไขรายงานการสั่งซื้อประจําวัน</h2>
    <hr>
    <form id="form1" name="form1" method="post" target="_blank" action="report_order.php">
        <table width="825" border="0" align="center" style="width:900px;">
            <tr>
                <td height="50" align="right"><strong>ตั้งแต่วันที่ :</strong><span style="color:red;">*</span></td>
                <td><label for="textfield2"></label>
                <input type="text" class="form-control datepicker" onfocus="$(this).blur();" name="startdate" id="startdate"style="width:300; padding-left:13px;" placeholder="กรุณาเลือกวันที่ที่ต้องการ" onkeypress="return false; event.preventDefault();" autocomplete="off" required></td>
               
                <td width="120" height="50" align="right"><strong>ถึงวันที่ :</strong><span style="color:red;">*</span></td>
                <td><label for="textfield2"></label>
                <input type="text" class="form-control datepicker" onfocus="$(this).blur();" name="enddate" id="enddate"style=" width:300; padding-left:13px;" placeholder="กรุณาเลือกวันที่ที่ต้องการ" onkeypress="return false; event.preventDefault();" autocomplete="off" required></td>

                <td>
                    <button style="margin-top:8px;" class="btn btn-primary" id="search_report_daily" name="search" type="submit">ค้นหา</button>
                </td>
            </tr>
        </table>
    </form>
    <hr>
</body>