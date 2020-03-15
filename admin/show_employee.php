<head>
  <title>แสดง/ลบข้อมูลพนักงาน</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");
 
  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }

  $strKeyword = null;
  if (isset($_POST["search_employee"])) {
    $strKeyword = $_POST["search_employee"];
  }
  if (isset($_GET["search_employee"])) {
    $strKeyword = $_GET["search_employee"];
  }
  ?>
  
  <h2 class="page-header text-center"style="padding-top:25px;">แสดง/ลบข้อมูลพนักงาน</h2>
  <hr>
<body>
  
  
  <div class="container">
  <form get="POST" class="form-inline" action="">
    <table width="100%" border="0" align="center">
      <tr>
        <td width="">
          <input type="text" class="form-control" placeholder="ค้นหารหัส,ชื่อ,เบอร์โทรศัพท์,อีเมล" style="width:250px" name="search_employee" id="search_employee" />
          <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
        </td>
        <td width="">
          <div align="right">
            <a href="add_employee.php" class="btn btn-primary"><i class="fa fa-user"></i> เพิ่มข้อมูล</a>
          </div>
</td>
      <tr>
    </table>
  </form>
  <br>
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="text-align:right;width:130px;">รหัสพนักงาน</th>
          <th style="text-align:left;width:200px;">ชื่อ-นามสกุล</th>
          <th style="text-align:center;">เบอร์โทรศัพท์</td>
          <th style="text-align:left;width:240px;">อีเมล</th>
          <th style="text-align:left;width:100px;">สถานะ</th>
          <th style="text-align:center;">แก้ไข</th>
          <th style="text-align:center;">ลบ</th>
        </tr>
      </thead>
      <tbody>
        <?php

        require_once("config/connect.php");
        $sql = "SELECT * FROM employee WHERE emp_id LIKE '%" . $strKeyword . "%' OR emp_name LIKE '%" . $strKeyword ."%' OR emp_email LIKE '%" . $strKeyword ."%' OR emp_phone LIKE '%" . $strKeyword . "%' ORDER BY emp_id DESC";
        
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $num_rows = mysqli_num_rows($query);

        if ($num_rows > 0) { 
          while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
            <tr>
              <td align="right"><?= $result['emp_id']; ?></td>
              <td><?= $result['emp_name']; ?></td>
              <td align="center"><?= $result['emp_phone']; ?></td>
              <td><?php
                if ($result['emp_email'] != ""){
                  echo $result['emp_email']; 
                } else { echo " <left>-</left>"; } ?></td></td>
              
              <td><?php
                      if ($result['emp_status'] == 0) {
                        echo "<span style='color:green;'>ทำงาน</span>";
                      } elseif ($result['emp_status'] == 1) {
                        echo "<span style='color:red;'>ลาออก</span>";
                      }
                      ?></td>
              <td align="center"><a href="modify_employee.php?emp_id=<?= $result['emp_id'] ?>"style="width:85px "class="btn btn-primary"><i class="fa fa-pencil-square"></i> แก้ไข</a></td>
              <td align="center"><a href="delete_employee.php?emp_id=<?= $result['emp_id']?>" onclick="if(confirm('ต้องการลบข้อมูลหรือไม่?')) return true; else return false;" style="width:80px" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ</a></td>
            </tr>
        <?php }
        } else { ?>
          <td align="center" bgcolor="#E4E3EA" colspan="7">ไม่พบข้อมูล</td>
      <?php  } ?>
      </tbody>
    </table>
  </div>