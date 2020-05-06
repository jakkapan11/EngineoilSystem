<head>
  <title>แก้ไขสมาชิก</title>
  <?php
  include("conf/head.php");
  include("conf/connection.php");
  include_once("conf/etc_funct.php");
  include("conf/mali_cus.php");

  if (!isset($_SESSION['cus_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }
  ?>
  <script>
    var endYear = new Date(new Date().getFullYear() - 15, 11, 32);
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
      $("#profile").validate({
        messages: {
          cus_name: {
            required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
            //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
            pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
          },
          cus_phone: {
            required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
            minlength: "<font color='red'>กรุณาระบุ ไม่น้อยกว่า 9 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณาระบุ ไม่เกิน 10 ตัวอักษร</font>",

          },

          cus_zipcode: {
            required: "<font color='red'>กรุณากรอกหมายเลขบัตรประชาชน</font>",
            minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",

          },
          cus_address: {
            required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
          },
          cus_password: {
            minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
          },
          cus_password2: {
            required: "<font color='red'>กรุณากรอกรหัสผ่านให้ตรงกัน</font>",
            minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
            maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-20 ตัวอักษร</font>",
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
  <h2 class="page-header text-center" style="padding-top:80px;">แก้ไขสมาชิก</h2>
  <hr>

  <?php
  if (!isset($_GET['cus_id'])) {
    echo "<script></script>";
  }

  $sql = "SELECT * FROM customers WHERE cus_id = '" . $_SESSION['cus_id'] . "'";
  $query = mysqli_query($link, $sql);
  $result =  mysqli_fetch_assoc($query);

  if ($result['cus_birthday'] == "0000-00-00")
    $cus_birthday = "";
  else $cus_birthday = tothaiyear($result['cus_birthday']);
  ?>

  <body>
    <form id="profile" name="profile" action="profile2.php" method="post">
      <table width="796" border="0" align="center">
        <tr>
          <td width="175" height="50" align="right"><strong>รหัสลูกค้า</strong> :</td>
          <td width="302"><label for="textfield1"></label>
            <?= $result['cus_id'] ?>
            <input type="text" style="width:250px;" value="<?= $result['cus_id'] ?>" name="cus_id" id="cus_id" hidden /></td>
        </tr>
        <tr>
          <td width="192" height="50" align="right"><strong>ชื่อ-นามสกุล </strong>:<span style="color:red;">*</span></td>
          <td width="270"><label for="textfield"></label>
            <input type="text" style="width:300px; " class="form-control" name="cus_name" value="<?= $result['cus_name'] ?>" pattern="^[ก-๏a-zA-Z\s]+$" id="cus_name" required /></td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>วันเกิด</strong> :<span style="color:red;"></span></td>
          <td><label for="textfield8"></label>
            <input type="text" name="cus_birthday" onfocus="$(this).blur();" style="width:300px; padding-left:14px;" onkeypress="return false;" class="form-control datepicker" value="<?= $cus_birthday ?>" id="cus_birthday" /></td>
          <td>
            <font style="padding-left:30px; color:gray;">(เลือก วัน/เดือน/ปี ที่เกิดจากปฎิทิน)</font>
          </td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>เบอร์โทรศัพท์</strong>:<span style="color:red;">*</span></td>
          <td><label for="textfield2"></label>
            <input type="text" style="width:300px; " class="form-control" name="cus_phone" value="<?= $result['cus_phone'] ?>" id="cus_phone" minlength="8" maxlength="10" required /></td>
          <td>
            <font width="667;" style="padding-left:30px; color:gray;">(กรอกอย่างน้อย 9 ตัวอีกษร)</font>
        </tr>
        <tr>
          <td height="50" align="right"><strong>อีเมล</strong> :<span style="color:red;"></span></td>
          <td><label for="textfield3"></label>
            <input type="email" name="cus_email" style="width:300px; " class="form-control" value="<?= $result['cus_email'] ?>" id="cus_email" /></td>
          <td <font style="padding-left:30px; color:gray;">(กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@hotmail.com)</font>
          </td>
        </tr>
        <tr>
          <td height="120" align="right"><strong>ที่อยู่</strong> :<span style="color:red;">*</span></td>
          <td><label for="textarea"></label>
            <textarea name="cus_address" style="width:300px; " id="cus_address" required cols="30" rows="5" class="form-control"><?= $result['cus_address'] ?></textarea></td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>รหัสไปรษณีย์</strong> :<span style="color:red;">*</span></td>
          <td><label for="textfield4"></label>
            <input type="text" name="cus_zipcode" style="width:300px; " class="form-control" value="<?= $result['cus_zipcode'] ?>" id="cus_zipcode" minlength="5" maxlength="5" required /></td>
          <td>
            <font style="padding-left:30px; color:gray;">(กรอก 5 ตัวอักษร)</font>
          </td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>ชื่อผู้ใช้</strong> :</span></td>
          <td><label for="textfield5"></label>
            <?= $result['cus_username'] ?>
            <input type="text" name="cus_username" style="width:300px; " value="<?= $result['cus_username'] ?>" id="cus_username" hidden /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="50" align="right"><strong>รหัสผ่าน</strong> :</span></td>
          <td><label for="textfield6"></label>
            <input type="password" name="cus_password" minlength="8" maxlength="20" style="width:300px; " class="form-control" id="cus_password" minlength="8" maxlength="20" /></td>
          <td>
            <font style="padding-left:30px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="50" align="right"><strong>ยืนยันรหัสผ่าน</strong> :</span></td>
          <td><label for="textfield7"></label>
            <input type="password" name="cus_password2" style="width:300px; " class="form-control" id="cus_password2" oninput='cus_password2.setCustomValidity(cus_password2.value != cus_password.value ? "กรอกรหัสผ่านให้ตรงกัน!" : "")' minlength="8" maxlength="20" /></td>
          <td>
            <font style="padding-left:30px; color:gray;">(กรอกอย่างน้อย 8 ตัวอักษร)</font>
        </tr>
        <tr>
          <td height="100" align="right">&nbsp;</td>
          <td>
            <button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการแก้ไขข้อมูลสมาชิก?')) return true; else return false;">บันทึก</button>
            <input class="btn btn-info" type="reset" name="reset" id="reset" value="คืนค่า" />
            <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
          </td>
        </tr>
      </table>
    </form>

  </body>