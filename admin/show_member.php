<head>
  <title>แสดง/ลบข้อมูลสมาชิก</title>
  <?php
 
 if (!isset($_SESSION)) {
  session_start();
}
  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }

  $strKeyword = null;
  if (isset($_POST["search_customers"])) {
    $strKeyword = $_POST["search_customers"];
  }
  if (isset($_GET["search_customers"])) {
    $strKeyword = $_GET["search_customers"];
  }
  include("config/head_admin.php");
  include("config/connect.php");
  ?>
  
  <h2 class="page-header text-center"style="padding-top:75px;">แสดง/ลบข้อมูลสมาชิก</h2>
  <hr>

<body>



  <div class="container">
    <form get="POST" class="form-inline" action="">
      <table width="100%" border="0" align="center">
        <tr>
          <td width="">
            <input type="text" class="form-control" placeholder="ค้นหารหัส,ชื่อ,เบอร์โทรศัพท์,อีเมล" style="width:250px" name="search_customers" id="search_customers" />
            <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
          </td>
          <td width="">
            <div align="right">
              <a href="add_member.php" class="btn btn-primary"><i class="fa fa-user"></i> เพิ่มข้อมูล</a>
  
            </div>
          </td>
        <tr>
      </table>
    </form>
    <br>
    <table class="table table-striped" border="0">
      <thead>
        <tr>
          <th style="text-align:right;width:110px;">รหัสลูกค้า</th>
          <th style="text-align:left;width:200px;">ชื่อ-นามสกุล</th>
          <th style="text-align:center;">เบอร์โทรศัพท์</th>
          <th style="text-align:left;width:240px;">อีเมล</th>
          <th style="text-align:left;width:100px;">สถานะ</th>
          <th style="text-align:center;">แก้ไข</th>
          <th style="text-align:center;">ลบ</th>
        </tr>
      </thead>
      <tbody>
        <?php

        require_once("config/connect.php");
        $sql = "SELECT * FROM customers WHERE cus_id LIKE '%" . $strKeyword . "%' OR cus_name LIKE '%" . $strKeyword . "%' OR cus_email LIKE '%" . $strKeyword .  "%' OR 	cus_phone LIKE '%" . $strKeyword . "%' ORDER BY cus_id DESC";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $num_rows = mysqli_num_rows($query);

        if ($num_rows > 0) { // ค้นหพบรายการ ให้แสดง
          while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
            <tr>
              <td align="right"><?= $result['cus_id']; ?></td>
              <td><?= $result['cus_name']; ?></td>
              <td align="center"> <?= $result['cus_phone']; ?></td>
              <td><?= $result['cus_email']; ?></td>
              <td><?php
                      if ($result['cus_status'] == 0) {
                        echo "<span style='color:green;'>ลูกค้าปกติ</span>";
                      } elseif ($result['cus_status'] == 1) {
                        echo "<span style='color:red;'>บัญชีดํา</span>";
                      }
                      ?></td>
              <td align="center"><a href="modify_member.php?cus_id=<?= $result['cus_id']?>" style="width:85px "class="btn btn-primary"><i class="fa fa-pencil-square"></i> แก้ไข</a></td>
              <td align="center"><a href="delete_member.php?cus_id=<?= $result['cus_id']?>" onclick="if(confirm('ต้องการลบข้อมูลหรือไม่?')) return true; else return false;" style="width:80px" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ</a></td>
            </tr>
            </tr>
        <?php }
        } else { ?>
          <td align="center" bgcolor="#E4E3EA" colspan="7">ไม่พบข้อมูล</td>
      <?php  } ?>
      </tbody>
    </table>
  </div>  
