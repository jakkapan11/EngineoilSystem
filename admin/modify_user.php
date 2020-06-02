<head>
  <title>แก้ไขข้อมูลผู้ใช้</title>
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
    var endYear = new Date(new Date().getFullYear() - 18, 11, 32);
    var startYear = new Date(new Date().getFullYear() - 61, 11, 1);
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
    $(document).ready(function() {
      $("#form1").validate({
        messages: {
          emp_name: {
            required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
            //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
            pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
          },
          emp_birthday: {
            required: "<font color='red'>กรุณาเลือกวันเกิดของท่าน</font>",
          },
           emp_phone: {
                         required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                         digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                         minlength: "<font color='red'>กรุณากรอก ให้ครบ 10 ตัวอักษร</font>",
                         maxlength: "<font color='red'>กรุณากรอก ให้ครบ 10 ตัวอักษร</font>",
          },
          emp_idcard: {
            required: "<font color='red'>กรุณากรอกหมายเลขบัตรประชาชน</font>",
            minlength: "<font color='red'>กรุุณากรอกให้ครบ 13 หลัก</font>",
            maxlength: "<font color='red'>กรุุณากรอกให้ครบ 13 หลัก</font>",

          },
          emp_address: {
            required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
          },
         
          emp_password: {
            minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
          },
          emp_password2: {
            required: "<font color='red'>กรุณากรอกรหัสผ่านให้ตรงกัน</font>",
            minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
          },
          emp_email: {
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
  <h2 class="page-header text-center" style="padding-top:25px;">แก้ไขข้อมูลผู้ใช้</h2>
  <hr>

  <?php
  if (!isset($_GET['emp_id'])) {
    echo "<script></script>";
  }

  $sql = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['emp_id'] . "'";
  $query = mysqli_query($link, $sql);
  $result =  mysqli_fetch_assoc($query);
  ?>

  <body>
    <form id="form1" name="form1" action="modify_user2.php" method="post">
      <table width="809" border="0" align="center">
        <tr>
          <td width="175" height="50" align="right"><strong>รหัสพนักงาน</strong> :</td>
          <td width="302"><label for="textfield1"></label>
            <?= $result['emp_id'] ?>
            <input type="text" style="width:300px;" value="<?= $result['emp_id'] ?>" name="emp_id" id="emp_id" hidden /></td>
        </tr>
        <tr>
          <td width="192" height="50" align="right"><strong>ชื่อ-นามสกุล </strong>:<span style="color:red;">*</span></td>
          <td width="270"><label for="textfield"></label>
            <input type="text" style="width:300px; " class="form-control" name="emp_name" value="<?= $result['emp_name'] ?>" pattern="^[ก-๏a-zA-Z\s]+$"  id="emp_name" required /></td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>วันเกิด</strong> :<span style="color:red;">*</span></td>
          <td><label for="textfield8"></label>
            <input type="text" name="emp_birthday" style="width:300px; padding-left:14px;" onfocus="$(this).blur();" class="form-control datepicker" onkeypress="return false;" value="<?= tothaiyear($result['emp_birthday']) ?>" id="emp_birthday" required /></td>
          <td>
            <font style="padding-left:40px; color:gray;">(เลือก วัน/เดือน/ปี จากปฎิทิน)</font>
          </td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>เบอร์โทรศัพท์</strong>:<span style="color:red;">*</span></td>
          <td><label for="textfield2"></label>
            <input type="text" name="emp_phone" style="width:300px; " class="form-control" onkeypress="return isNumberKey (event)" value="<?= $result['emp_phone'] ?>" minlength="10" maxlength="10" id="emp_phone" required /></td>
          <td>
            <font style="padding-left:40px; color:gray;">(กรอกอ 10 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="50" align="right"><strong>อีเมล</strong> :<span style="color:red;"></span></td>
          <td><label for="textfield3"></label>
            <input type="email" name="emp_email" style="width:300px; " class="form-control" value="<?= $result['emp_email'] ?>" id="emp_email" /></td>
          <td <font style="padding-left:40px; color:gray;">(กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@hotmail.com)</font>
          </td>
        </tr>
        <tr>
          <td height="120" align="right"><strong>ที่อยู่</strong> :<span style="color:red;">*</span></td>
          <td><label for="textarea"></label>
            <textarea name="emp_address" style="width:300px; " id="emp_address" required cols="30" rows="5" class="form-control"><?= $result['emp_address'] ?></textarea></td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>หมายเลขบัตรประชาชน</strong> :<span style="color:red;">*</span></td>
          <td><label for="textfield4"></label>
            <input type="text" name="emp_idcard" style="width:300px;" class="form-control" value="<?= $result['emp_idcard'] ?>" id="emp_idcard" onkeypress="return isNumberKey(event)" id="emp_idcard" minlength="10" maxlength="13" required /></td>
          <td <font style="padding-left:40px; color:gray;">(กรอก 13 ตัวอักษร)</font>
          </td>
          <td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>ชื่อผู้ใช้</strong> :</span></td>
          <td><label for="textfield5"></label>
            <?= $result['emp_username'] ?>
            <input type="text" name="emp_username" style="width:300px;" value="<?= $result['emp_username'] ?>" id="emp_username" hidden /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>รหัสผ่าน</strong> :</span></td>
          <td><label for="textfield6"></label>
            <input type="password" name="emp_password" minlength="8" maxlength="20" style="width:300px; " class="form-control" id="emp_password" /></td>
          <td>
            <font style="padding-left:40px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="50" align="right"><strong>ยืนยันรหัสผ่าน</strong> :</span></td>
          <td><label for="textfield7"></label>
            <input type="password" name="emp_password2" style="width:300px; " class="form-control" id="emp_password2" oninput='emp_password2.setCustomValidity(emp_password2.value != emp_password.value ? "กรอกรหัสผ่านให้ตรงกัน!" : "")' minlength="8" maxlength="20" /></td>
          <td>
            <font style="padding-left:40px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="100" align="right">&nbsp;</td>
          <td>
            <button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการแก้ไขข้อมูลผู้ใช้?')) return true; else return false;">บันทึก</button>
            <input class="btn btn-info" type="reset" name="reset" id="reset" value="คืนค่า" />
            <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
          </td>
        </tr>
      </table>
    </form>

  </body>