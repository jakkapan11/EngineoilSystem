<head>
  <title>แก้ไขข้อมูลประเภทสินค้า</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");
  
  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }
  ?>
<body>
  <h2 class="page-header text-center" style="padding-top:25px;">แก้ไขข้อมูลประเภทสินค้า</h2>
  <hr>

  <?php
  if (!isset($_GET['category_id'])) {
    echo "<script></script>";
  }


  $sql = "SELECT * FROM category WHERE category_id = '" . $_GET['category_id'] . "'";
  $query = mysqli_query($link, $sql);
  $result =	mysqli_fetch_assoc($query);
  ?>
  
  <form id="form1" name="form1"  action="modify_category2.php" method="post">
  <table width="450" border="0" align="center">
   <tr>
      <td width="175" height="50" align="right"><strong>รหัสประเภท</strong> :</td>
      <td width="390"><label for="textfield1"></label>
      <?= $result['category_id'] ?>
      <input type="text" style="width:300px;" value="<?= $result['category_id'] ?>" name="category_id" id="cus_id" hidden/></td> 
  </tr>
  <tr>
    <td height="50"align="right"><strong>ชื่อประเภท</strong> :<span style="color:red;">*</span></td>
    <td><label for="textfield2"></label>
      <input type="text" name="category_name" style="width:300px;" class="form-control"value="<?= $result['category_name'] ?> "id="category_name"minlength="3" maxlength="50" required/></td>
  </tr>
      
      <tr>
        <td height="50" align="right"><strong>สถานะ</strong> :<span style="color:red;">*</span></td>
        <td><label for="select"></label>
          <select name="category_status" style="width:300px;" id="category_status" class="form-control">
            <option selected="selected" disabled="disabled">-- กรุณาเลือกสถานะ --</option>
            <option <?php if ($result['category_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
            <option <?php if ($result['category_status'] == 1) echo "selected"; ?> value="1">ไม่ใช้งาน</option>
          </select></td>
      </tr>
    <tr>
      <td height="95">&nbsp;</td>
      <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการแก้ไข?')) return true; else return false;">บันทึก</button>   
      	  <input  class="btn btn-info" type="reset" name="reset" id="reset" value="คืนค่า"/>
          <button type="button"class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
      </td>
     
    </tr>
  </table>
 </form>
</body>