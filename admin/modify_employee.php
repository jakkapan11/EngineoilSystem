<head>
  <title>แก้ไขข้อมุลพนักงาน</title>
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
                         minlength: "<font color='red'>กรุณาระบุ ไม่น้อยกว่า 9 ตัวอักษร</font>",
                         maxlength: "<font color='red'>กรุณาระบุ ไม่เกิน 10 ตัวอักษร</font>",
                        
                     },
                    
                     emp_idcard: {
                         required: "<font color='red'>กรุณากรอกหมายเลขบัตรประชาชน</font>",
                         minlength: "<font color='red'>กรุุณากรอก ให้ครบ 13 ตัวอักษร</font>",
                         maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 13 ตัวอักษร</font>",
                        
                     },
                     emp_address: {
                         required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
                     },
                     emp_level: {
                         required: "<font color='red'>กรุณาเลือกระดับ</font>",
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
  <h2 class="page-header text-center" style="padding-top:25px;">แก้ไขข้อมูลพนักงาน</h2>
  <hr>

  <?php
  if (!isset($_GET['emp_id'])) {
    echo "<script></script>";
  }


  $sql = "SELECT * FROM employee WHERE emp_id = '" . $_GET['emp_id'] . "'";
  $query = mysqli_query($link, $sql);
  $result =  mysqli_fetch_assoc($query);

  
  ?>

  <form id="form1" name="form1"class="form-horizontal" method="post" action="modifiy_employee2.php" enctype="multipart/form-data">
    <table width="804" border="0" align="center">
      <tr>
        <td width="190" height="50" align="right"><strong>รหัสพนักงาน</strong> :</td>
        <td width="302"><label for="textfield1"></label>
          <?= $result['emp_id'] ?>
          <input type="text" style="width:300px;" value="<?= $result['emp_id'] ?>" name="emp_id" id="emp_id" hidden /></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>ชื่อ-นามสกุล </strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield"></label>
          <input type="text" style="width:300px;"class="form-control" name="emp_name" value="<?= $result['emp_name'] ?>" pattern="^[ก-๏a-zA-Z\s]+$" id="emp_name" required /></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>วันเกิด</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield2"></label>
          <input type="text" style="width:300px; padding-left:14px;" onfocus="$(this).blur();" class="form-control datepicker" onkeypress="return false;" name="emp_birthday" value="<?= tothaiyear($result['emp_birthday']) ?>" id="emp_birthday" required /></td>
        <td>
          <font style="padding-left:40px; color:gray;">(เลือก วัน/เดือน/ปี ที่เกิดจากปฎิทิน)</font>
      </tr>
      <tr>
        <td height="50" align="right"><strong>เบอร์โทรศัพท์</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield3"></label>
          <input type="text" style="width:300px; " class="form-control" name="emp_phone" onkeypress="return isNumberKey(event)" minlength="9" maxlength="10" value="<?= $result['emp_phone'] ?>" id="emp_phone" required /></td>
        <td>
          <font style="padding-left:40px; color:gray;">(กรอกอย่างน้อย 9 ตัวอักษร)</font>
      </tr>
      <tr>
        <td height="50" align="right"><strong>อีเมล</strong> :<span style="color:red;"></span></td>
        <td><label for="textfield4"></label>
          <input type="email" style="width:300px; " class="form-control" name="emp_email" value="<?= $result['emp_email'] ?>" id="emp_email" /></td>
          <td <font style="padding-left:40px; color:gray;">(กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@hotmail.com)</font></td>
      </tr>
      <tr>
        <td height="130" align="right"><strong>ที่อยู่</strong> :<span style="color:red;">*</span></td>
        <td><label for="textarea"></label>
          <textarea name="emp_address" style="width:300px; " id="emp_address" required cols="30" rows="5" class="form-control"><?= $result['emp_address'] ?></textarea></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>หมายเลขบัตรประชาชน</strong> :<span style="color:red;">*</span></td>
        <td><label for="textfield5"></label>
          <input type="text" style="width:300px;" id="emp_idcard" class="form-control" name="emp_idcard" onkeypress="return isNumberKey(event)" minlength="10" maxlength="13" value="<?= $result['emp_idcard']; ?>" required /></td>
        <td>
          <font style="padding-left:40px; color:gray;">(กรอก 13 ตัวอักษร)</font>
      </tr>
      <tr>
        <td height="50" align="right"><strong>ระดับ</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <select name="emp_level" style="width:300px;" id="emp_level" class="form-control">
            <option selected="selected" disabled="disabled">-- กรุณาเลือกระดับ --</option>
            <option <?php if ($result['emp_level'] == 0) echo "selected"; ?> value="0">พนักงาน</option>
            <option <?php if ($result['emp_level'] == 1) echo "selected"; ?> value="1">เจ้าของ</option>
          </select></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>สถานะ</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <label for="select"></label>
          <select name="emp_status" style="width:300px; " class="form-control" id="emp_select">
            <option selected="selected" disabled="disabled">-- กรุณาเลือกระดับ --</option>
            <option <?php if ($result['emp_status'] == 0) echo "selected"; ?> value="0">ทํางาน</option>
            <option <?php if ($result['emp_status'] == 1) echo "selected"; ?> value="1">ลาออก</option>
          </select></td>
      </tr>
      <tr>
        <td height="95">&nbsp;</td>
        <td>
          <button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการแก้ไข?')) return true; else return false;">บันทึก</button>
          <input class="btn btn-info" type="reset" name="reset" id="reset" value="คืนค่า" />
          <button type="button" class="btn btn-primary" name="button" onclick="window.history.back();">ย้อนกลับ</button>
        </td>
      </tr>
    </table>
  </form>
</body>