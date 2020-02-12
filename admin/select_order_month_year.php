<head>
    <title>เงื่อนไขรายงานการสั่งซื้อประจําเดือน</title>
    <?php
    include("config/head_admin.php");
    include("config/connect.php");
    include_once("config/etc_funct_admin.php");

    if (!isset($_SESSION['emp_id'])) {
        echo "<script>window.location.assign('login.php')</script>";
        exit();
    }

    ?>

<body>
    <h2 class="page-header text-center" style="padding-top:90px;">เงื่อนไขรายงานการสั่งซื้อประจําเดือน</h2>
    <hr>
    <form id="form1" name="form1" method="post" target="_blank" action="report_order_month.php">
        <table width="825" border="0" align="center" style="width:900px;">
            <tr>
                <td height="50" align="right"><strong>เดือน :</strong><span style="color:red;">*</span></td>
                <td><label for="select"></label>
                    <select name="month" style="width:300px; " class="form-control" id="month" required>
                        <option value="" selected disabled>-- กรุณาเลือกเดือนที่ต้องการ --</option>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select></td>
                <td width="100" height="50" align="right"><strong>ปี พ.ศ. :</strong><span style="color:red;">*</span></td>
                <td><label for="select"></label>
                    <select name="year" style="width:300px; " class="form-control" id="year" required>
                        <option value="" selected disabled>-- กรุณาเลือกปี พ.ศ. ที่ต้องการ --</option>
                        <option value="2019">2562</option>
                        <option value="2020">2563</option>
                        <option value="2021">2564</option>
                        <option value="2022">2565</option>
                        <option value="2023">2566</option>
                        <option value="2024">2567</option>
                        <option value="2025">2568</option>
                        <option value="2026">2569</option>
                        <option value="2027">2570</option>
                        <option value="2028">2571</option>
                        <option value="2028">2572</option>
                    </select></td>
                <td>
                    <button style="margin-top:8px;" class="btn btn-primary" name="search" type="submit">ค้นหา</button>
                </td>
            </tr>
        </table>
    </form>
    <hr>
</body>