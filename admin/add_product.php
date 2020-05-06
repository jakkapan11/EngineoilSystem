<head>
  <title>เพิ่มข้อมูลสินค้า</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");

  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }
  ?>
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
          product_name: {
            required: "<font color='red'>กรุณากรอกชื่อสินค้า</font>",
            //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
            //pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
          },
          category_id: {
            required: "<font color='red'>กรุณาเลือกประเภท</font>",

          },
          product_amount: {
            required: "<font color='red'>กรุณากรอกจำนวนสินค้า</font>",
            min: "<font color='red'>กรุณากรอกเป็นจำนวนเต็ม</font>",
          },
          product_price_unit: {
            required: "<font color='red'>กรุณากรอกราคาต่อหน่วย</font>",
                    min: "<font color='red'>กรุณากรอกราคาไม่น้อยกว่า 600 บาท</font>",

          },
          product_unit: {
            required: "<font color='red'>กรุณากรอกหน่วยนับ</font>",
          },
          product_pic: {
            required: "<font color='red'>กรุณาเลือกไฟล์รูปภาพ</font>",
          },
          product_description: {
            required: "<font color='red'>กรุณารายละเอียดสินค้า</font>",
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
  <h2 class="page-header text-center" style="padding-top:25px;">เพิ่มข้อมูลสินค้า</h2>
  <hr>

  <form id="form1" name="form1" method="post" action="add_product2.php" enctype="multipart/form-data">
    <table width="560" border="0" align="center">
      <tr>
        <td width="229" height="50" align="right"><strong>ชื่อสินค้า </strong> :<span style="color:red;">*</span></td>
        <td width="330"><label for="textfield"></label>
          <input type="text"style="width:300px;"class="form-control" name="product_name" id="product_name"  required /></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>ประเภท</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <select name="category_id" style="width:300px; " class="form-control" id="category_id" required>
            <option selected disabled value="">-- กรุณาเลือกประเภท --</option>
            <?php
            $sql_cat = "SELECT * FROM category WHERE category_status = '0'";
            $query_catg = mysqli_query($link, $sql_cat);
            while ($catg = mysqli_fetch_array($query_catg)) { ?>
              <option value="<?= $catg['category_id'] ?>"><?= $catg['category_name'] ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>จํานวน</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
        <input type="number" class="form-control" style="width:300px" id="product_amount" min="1" onkeypress="return isNumberKey(event)" value="" name="product_amount" required>
          
      </tr>

      <tr>
        <td height="50" align="right"><strong>ราคาต่อหน่วย (บาท)</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
        <input type="text" class="form-control" style="width:300px" id="product_price_unit" min="600" onkeypress="return isNumberKey(event)" value="" name="product_price_unit" required>
        
        <td>
          <font style="padding-left:70px; color:gray;"></font>
        </td>
      </tr>

      <tr>
        <td height="50" align="right"><strong>หน่วยนับ</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
          <input type="text" style="width:300px; " class="form-control" name="product_unit" id="product_unit" required /></td>
      </tr>
      <tr>
      <tr>
        <td height="50" align="right"><strong>รูปภาพ</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
          <input type="file" style="width:300px; " class="form-control" id="product_pic" name="product_pic" accept="image/gif, image/jpeg, image/png" required>
      </tr>
      <tr>
        <td height="130" align="right"><strong>รายละเอียด</strong> :<span style="color:red;">*</span></td>
        <td><label for="textarea"></label>
          <textarea name="product_description" style="width:300px; " class="form-control" id="product_description" required cols="30" rows="5"></textarea></td>
      </tr>
      <tr>
        <td height="100">&nbsp;</td>
        <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการบันทึก?')) return true; else return false;">บันทึก</button>
          <input class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
          <inbutton class="btn btn-primary" name="button" onclick="window.history.back();" >ย้อนกลับ</inbutton>
        </td>
      </tr>
    </table>
  </form>
</body>