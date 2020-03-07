<head>
    <title>รายงานหนี้ค้างชําระประจําเดือน</title>
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
    <h2 class="page-header text-center" style="padding-top:90px;">รายงานหนี้ค้างชําระประจําเดือน</h2>
    <hr>
    <form id="form1" name="form1" method="post" target="_blank" action="report_invoice.php">
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
                        <?php

                        $sql_year = "SELECT DISTINCT year(invoice_paymendate) FROM invoice WHERE invoice_paymendate != '0000-00-00'";
                        $query_year = mysqli_query($link, $sql_year) or die(mysqli_error($link));

                        while ($result_year = mysqli_fetch_array($query_year)) {
                            echo "<option value='" . $result_year[0] . "' >" . ($result_year[0] + 543) . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <button style="margin-top:8px;" class="btn btn-primary" name="search" type="submit">ค้นหา</button>
                </td>
            </tr>
        </table>
    </form>
    <hr>
</body>