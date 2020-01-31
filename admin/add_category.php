<head>
  <title>เพิ่มข้อมูลประเภทสินค้า</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");
 
  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }
?>
<body>
  <h2 class="page-header text-center" style="padding-top:80px;">เพิ่มข้อมูลประเภทสินค้า</h2>
  <hr>
  </body>
  
  <body>
  <form id="form1" name="form1" method="post" action="add_category2.php">
  <table width="550" border="0" align="center">
  <tr>
    <td height="50"align="right"><strong>ชื่อประเภท</strong> :<span style="color:red;">*</span></td>
    <td><label for="textfield2"></label>
      <input type="text" name="category_name" style="width:300px;" class="form-control" id="category_name" minlength="3" maxlength="50" required/></td>
  </tr>
      
    <tr>
      <td height="95">&nbsp;</td>
      <td><button type="submit" class="btn btn-secondary" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
      	  <input  class="btn btn-info" type="reset" name="reset" id="reset" value="ล้างค่า" />
          <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">ย้อนกลับ</button>
      </td>
      
  </table>
 </form>
</body>
  