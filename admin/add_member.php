<head>
  <title>เพิ่มข้อมูลสมาชิก</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");
  include_once("config/etc_funct_admin.php");

  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }
  ?>
  <script>
    var endYear = new Date(new Date().getFullYear() - 15, 11, 32);
    var startYear = new Date(new Date().getFullYear() - 200, 11, 1);
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
    $(document).ready(function() {
      $('.datepicker-checkout').datepicker({
        language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        format: 'dd/mm/yyyy',
        disableTouchKeyboard: true,
        todayBtn: false,
        endDate: 'now',
        startDate: '-60y',
        autoclose: true, //Set เป็นปี พ.ศ.
        inline: true
      }) //กำหนดเป็นวันปัจุบัน       
    });
  </script>
  <script type="text/javascript">
    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
      return true;
    }


    function isNumericKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return true;
      return false;
    }
  </script>
  <script>
    // Wait for the DOM to be ready
    $(document).ready(function() {
      $("#form1").validate({
        // Specify validation rules

        messages: {
          cus_name: {
            required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
            //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
            pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",

          },
          cus_phone: {
            required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            minlength: "<font color='red'>กรุุณากรอก ให้ครบ 10 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 10 ตัวอักษร</font>",

          },

          cus_zipcode: {
            required: "<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>",
            minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",

          },
          cus_address: {
            required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
          },
          cus_email: {
            email: "<font color='red'>กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง</font>",
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
  <h2 class="page-header text-center" style="padding-top:25px;">เพิ่มข้อมูลสมาชิก</h2>
  <hr>



  <form id="form1" name="form1" method="post" action="add_member2.php">
    <table width="840" border="0" align="center">
      <tr>
        <td width="229" height="50" align="right"><strong>ชื่อ-นามสกุล </strong> :<span style="color:red;">*</span></td>
        <td width="301"><label for="textfield"></label>
          <input type="text" style="width:300px;" class="form-control" name="cus_name" pattern="^[ก-๏a-zA-Z\s]+$" id="cus_name" required /></td>
        <td width="244">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="right"><strong>วันเกิด</strong> :<span style="color:red;"></span></td>
        <td><label for="textfield2"></label>
          <input type="text" onfocus="$(this).blur();" id="cus_birthday" name="cus_birthday" class="form-control datepicker" onkeypress="return false;" style="width:300; padding-left:13px" data-provide="datepicker" autocomplete="off" data-date-format="dd/mm//yyyy" /></td>
        <td>
          <font style="padding-left:40px; color:gray;">(เลือก วัน/เดือน/ปี จากปฎิทิน)</font>
      </tr>
      <tr>
        <td height="50" align="right"><strong>เบอร์โทรศัพท์</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield3"></label>
          <input type="text" style="width:300px;" class="form-control" name="cus_phone" onkeypress="return isNumberKey(event)" id="cus_phone" minlength="10" maxlength="10" required /></td>
        <td>
          <font style="padding-left:40px; color:gray;">(กรอก 10 ตัวอักษร)</font>
        </td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>อีเมล</strong>:<span style="color:red;"></span></td>
        <td><label for="textfield4"></label>
          <input style="width:300px;" class="form-control" type="email" name="cus_email" id="cus_email" /></td>
        <td <font style="padding-left:40px; color:gray;">(กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@hotmail.com)</font>
        </td>
      </tr>
      <tr>
        <td height="130" align="right"><strong>ที่อยู่</strong> :<span style="color:red;">*</span></td>
        <td><label for="textarea"></label>
          <textarea name="cus_address" style="width:300px;" class="form-control" id="cus_address" required cols="30" rows="5"></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>รหัสไปรษณีย์</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield5"></label>
          <input type="text" name="cus_zipcode" style="width:300px;" class="form-control" onkeypress="return isNumberKey(event)" id="cus_zipcode" minlength="4" maxlength="5" required /></td>
        <td <font style="padding-left:40px; color:gray;">(กรอก 5 ตัวอักษร)</font>
      </tr>
      <tr>
        <td height="95">&nbsp;</td>
        <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึก?')) return true; else return false;">บันทึก</button>
          <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
          <inbutton class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</inbutton>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</body>