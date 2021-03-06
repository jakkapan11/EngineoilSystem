<head>
  <title>สมัครสมาชิก</title>
  <?php
  include("conf/head.php");
  include("conf/connection.php");
  include("conf/mali_cus.php");
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
        clearBtn: true,
        endDate: 'now',
        startDate: '-60y',
        autoclose: true, //Set เป็นปี พ.ศ.
        inline: true
      }) //กำหนดเป็นวันปัจุบัน       
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#form1").validate({
        messages: {
          cus_name: {
            required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
            //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
            pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
          },
          cus_phone: {
            required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            minlength: "<font color='red'>กรุณากรอก ให้ครบ 10 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณากรอก ใหครบ 10 ตัวอักษร</font>",

          },

          cus_zipcode: {
            required: "<font color='red'>กรุณากรอกหมายเลขบัตรประชาชน</font>",
            minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",

          },
          cus_address: {
            required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
          },
          cus_username: {
            required: "<font color='red'>กรุณากรอกชื่อผู้ใช้</font>",
            minlength: "<font color='red'>กรุณากรอกอย่างน้อย 5 ตัวอักษร</font>",
						pattern: "<font color='red'>กรุณากรอกเป็นตัวอักษร A-z และ 0-9 อย่างน้อย 5 ตัว</font>",
          },
          cus_password: {
						required: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
						minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
					},
					cus_password2: {
						required: "<font color='red'>กรุณากรอกรหัสผ่านให้ตรงกับ รหัสผ่าน</font>",
						minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
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
</head>

<body>
  <h2 class="page-header text-center" style="padding-top:80px;">สมัครสมาชิก</h2>
  <hr>

  <form id="form1" name="form1" method="post" action="register2.php">
    <table width="881" border="0" align="center">
      <tr>
        <td width="229" height="45" align="right"><strong>ชื่อ-นามสกุล </strong> :<span style="color:red;">*</span></td>
        <td width="301"><label for="textfield"></label>
          <input type="text" style="width:300px;" class="form-control" name="cus_name" pattern="^[ก-๏a-zA-Z\s]+$" id="cus_name" required /></td>
        <td width="">&nbsp;</td>
      </tr>
      <tr>
        <td height="45" align="right"><strong>วันเกิด</strong> :<span style="color:red;"></span></td>
        <td><label for="textfield2"></label>
          <input type="text" onfocus="$(this).blur();" id="cus_birthday" name="cus_birthday" class="form-control datepicker" onkeydown="return false;" onkeypress="return false;" style="background-color:white; width:300; padding-left:13px" data-provide="datepicker" autocomplete="off" data-date-format="dd/mm//yyyy" />
        </td>
        <td>
          <font style="padding-left:30px; color:gray;">(เลือก วัน/เดือน/ปี จากปฎิทิน)</font>
        </td>
      </tr>
      <tr>
        <td height="45" align="right"><strong>เบอร์โทรศัพท์</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield3"></label>
          <input type="text" style="width:300px;" class="form-control" name="cus_phone" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" id="cus_phone" minlength="10" maxlength="10" required /></td>
        <td>
          <font style="padding-left:30px; color:gray;">(กรอก 10 ตัวอักษร)</font>
        </td>
      </tr>
      <tr>
        <td height="45" align="right"><strong>อีเมล</strong>:<span style="color:red;"></span></td>
        <td><label for="textfield4"></label>
          <input style="width:300px;" class="form-control" type="email" name="cus_email" id="cus_email"  /></td>
        <td <font style="padding-left:30px; color:gray;">(กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@hotmail.com)</font>
      </tr>
      <tr>
        <td height="120" align="right"><strong>ที่อยู่</strong> :<span style="color:red;">*</span></td>
        <td><label for="textarea"></label>
          <textarea name="cus_address" style="width:300px;" class="form-control" id="cus_address" required cols="30" rows="5"></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="45" align="right"><strong>รหัสไปรษณีย์</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield5"></label>
          <input type="text" name="cus_zipcode" style="width:300px;" class="form-control" onkeypress="return isNumberKey(event)" id="cus_zipcode" minlength="4" maxlength="5" required /></td>
        <td <font style="padding-left:30px; color:gray;">(กรอก 5 ตัวอักษร)</font>
      </tr>
      <tr>
      <tr>
        <td height="50" align="right"><strong>ชื่อผู้ใช้</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield5"></label>
          <input type="text" name="cus_username" style="width:300px; " class="form-control" id="cus_username" minlength="5" maxlength="16" required /></td>
          
          <td <font style="padding-left:30px; color:gray;">(กรอกเป็นตัวอักษร A-z และ 0-9 อย่างน้อย 5 ตัว)</font>
      </tr>
      <td height="50" align="right"><strong>รหัสผ่าน</strong> :<span style="color:red;">*</span></td>
      <td><label for="textfield6"></label>
        <input type="password" name="cus_password" minlength="8" maxlength="20" style="width:300px; " class="form-control" id="cus_password" minlength="8" maxlength="20" required /></td>
      <td>
        <font style="padding-left:30px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="50" align="right"><strong>ยืนยันรหัสผ่าน</strong> :<span style="color:red;">*</span></td>
          <td><label for="textfield7"></label>
            <input type="password" name="cus_password2" style="width:300px; " class="form-control" id="cus_password2" minlength="8" maxlength="20" oninput='cus_password2.setCustomValidity(cus_password2.value != cus_password.value ? "กรอกรหัสผ่านให้ตรงกัน!" : "")' required /></td>
          <td>
            <font size="3" style="padding-left:30px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>

        <tr>
          <td height="95">&nbsp;</td>
          <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึก?')) return true; else return false;">บันทึก</button>
            <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
            <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
          </td>
          <td>&nbsp;</td>
        </tr>
    </table>
  </form>
</body>