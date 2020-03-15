<head>
  <title>แสดง/ลบข้อมูลประเภทสินค้า</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");

  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }

  $strKeyword = null;
  if (isset($_POST["search_category"])) {
    $strKeyword = $_POST["search_category"];
  }
  if (isset($_GET["search_category"])) {
    $strKeyword = $_GET["search_category"];
  }
  ?>
  
  <h2 class="page-header text-center"style="padding-top:25px;">แสดง/ลบข้อมูลประเภทสินค้า</h2>
  <hr>
<body>
  

  
  <div class="container">
  <form get="POST" class="form-inline" action="">
    <table width="100%" border="0" align="center">
      <tr>
        <td width="">
          <input type="text" class="form-control"placeholder="ค้นหารหัส,ชื่อประเภท" style="width:200px" name="search_category" id="search_category" />
          <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
        </td>
        <td width="">
          <div align="right">
            <a href="add_category.php" class="btn btn-primary"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
          </div>
</td>
      <tr>
    </table>
  </form>
  <br>
    <table class="table table-striped"border="0">
      <thead>
        <tr>
          <th style="text-align:right;width:200px;">รหัสประเภท</th>
          <th style="text-align:left;width:700px;">ชื่อประเภท</th>
          <th style="text-align:left;width:500px;">สถานะ</th>
          <th style="text-align:center;width:450px;">แก้ไข</th>
          <th style="text-align:center;width:100px;">ลบ</th>
        </tr>
      </thead>
      <tbody>
        <?php

        require_once("config/connect.php");
        $sql = "SELECT * FROM category WHERE category_id LIKE '%" . $strKeyword . "%' OR category_name LIKE '%" . $strKeyword . "%'";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $num_rows = mysqli_num_rows($query);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
          while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
            <tr>
              <td align="right"><?= $result['category_id']; ?></td>
              <td><?= $result['category_name']; ?></td>
              <td><?php
                      if ($result['category_status'] == 0) {
                        echo "<span style='color:green;'>ใช้งาน</span>";
                      } elseif ($result['category_status'] == 1) {
                        echo "<span style='color:red;'>ไม่ใช้งาน</span>";
                      }
              ?></td>
              <td align="center"><a href="modify_category.php?category_id=<?= $result['category_id']?>" style="width:85px "class="btn btn-primary"><i class="fa fa-pencil-square"></i> แก้ไข</a></td>
              <td align="center"><a href="delete_category.php?category_id=<?= $result['category_id']?>" onclick="if(confirm('ต้องการลบข้อมูลหรือไม่?')) return true; else return false;"  style="width:75px" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ</a></td>
            </tr>
      <?php }
        } else { ?>
          <td align="center" bgcolor="#E4E3EA" colspan="5">ไม่พบข้อมูล</td>
      <?php  } ?>
      </tbody>
    </table>
  </div>