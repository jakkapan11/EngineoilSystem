<head>
  <title>แก้ไขข้อมูลสินค้า</title>
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
</head>
<body>
  <h2 class="page-header text-center" style="padding-top:80px;">แก้ไขข้อมูลสินค้า</h2>
  <hr>

  <?php
  if (!isset($_GET['product_id'])) {
    echo "<script></script>";
  }



  $sql = "SELECT * FROM product WHERE product_id = '" . $_GET['product_id'] . "'";
  $query = mysqli_query($link, $sql);
  $result =  mysqli_fetch_assoc($query);
  ?>
  <form id="form1" name="form1" method="post" action="modify_product2.php" enctype="multipart/form-data">
    <table width="500" border="0" align="center">
      <tr>
        <td width="175" height="50" align="right"><strong>รหัสสินค้า</strong> :</td>
        <td width="350"><label for="textfield1"></label>
        <?= $result['product_id'] ?>
          <input type="text" style="width:300px;" value="<?= $result['product_id'] ?>" name="product_id" id="product_id" hidden /></td>
      </tr>
      <tr>
        <td width="229" height="50" align="right"><strong>ชื่อสินค้า </strong> :<span style="color:red;">*</span></td>
        <td width="301"><label for="textfield"></label>
          <input type="text " style="width:300px; " class="form-control" name="product_name" value="<?= $result['product_name'] ?>" id="product_name" required /></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>ประเภท</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <select name="category_id" style="width:300px; " class="form-control" <?= $result['category_id'] ?> id="category_id">
            <option selected="selected" disabled="disabled">-- กรุณาเลือกประเภท --</option>
            <?php
            $sql_cat = "SELECT * FROM category WHERE category_status = '0'";
            $query_catg = mysqli_query($link, $sql_cat);
            while ($catg = mysqli_fetch_array($query_catg)) { ?>
              <option <?php if ($result['category_id'] == $catg['category_id']) {
                          echo "selected";
                        } ?> value="<?= $catg['category_id'] ?>"><?= $catg['category_name'] ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>จํานวน</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
          <input type="number" style="width:300px; " class="form-control" name="product_amount" min="0" max="100" onkeypress="return isNumberKey(event)" value="<?= $result['product_amount'] ?>"   id="product_amount"autocomplete="off" onpaste="return false;" onchange="if(this.value <= 0) {alert('จำนวนไม่สามารถน้อยกว่า 1'); this.value='1'; } " required /></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>ราคาต่อหน่วย (บาท)</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
          <input type="text"style="width:300px; " class="form-control" name="product_price_unit" value="<?= $result['product_price_unit'] ?>" onkeypress="return isNumberKey(event)" id="product_price_unit"required /></td>
         
        </tr>
      <tr>
        <td height="50" align="right"><strong>หน่วยนับ</strong>:<span style="color:red;">*</span></td>
        <td><label for="textfield4"></label>
          <input type="text" style="width:300px; " class="form-control" name="product_unit" value="<?= $result['product_unit'] ?>" id="product_unit" required /></td>
      </tr>
      <tr>
        <td></td>
        <td height= "150" align="left" colspan="2"><img height="" width="120" src="../<?= $result['product_picture'] ?>"</td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>รูปภาพ</strong>:<span style="color:red;"></span></td>
        <td><label for="textfield4"></label>
          <input type="file" name="product_pic" style="width:300px;" class="form-control" id="product_pic" accept="image/gif, image/jpeg, image/png" /></td>
      </tr>
      <tr>
        <td height="130" align="right"><strong>รายละเอียด</strong> :<span style="color:red;">*</span></td>
        <td><label for="textarea"></label>
          <textarea name="product_description" style="width:300px; " class="form-control" id="product_description" required cols="30" rows="5"><?= $result['product_description'] ?></textarea></td>
      </tr>
      <tr>
        <td height="50" align="right"><strong>สถานะ</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <select name="product_status" style="width:300px;" id="product_status" class="form-control">
            <option selected="selected" disabled="disabled">-- กรุณาเลือกสถานะ --</option>
            <option <?php if ($result['product_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
            <option <?php if ($result['product_status'] == 1) echo "selected"; ?> value="1">ไม่ใช้งาน</option>
          </select></td>
      </tr>
      <tr>
        <td height="100">&nbsp;</td>
        <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการแก้ไข?')) return true; else return false;">บันทึก</button>
          <input class="btn btn-info" type="reset" name="reset" id="reset" value="คืนค่า" />
          <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
        </td>
      </tr>
    </table>
  </form>
</body>