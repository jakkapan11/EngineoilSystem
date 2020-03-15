<head>
  <title>แสดง/ลบข้อมูลสินค้า</title>
  <?php
  include("config/head_admin.php");
  include("config/connect.php");
  
  if (!isset($_SESSION['emp_id'])) {
    echo "<script>window.location.assign('login.php')</script>";
    exit();
  }

  $strKeyword = null;
  if (isset($_POST["search_product"])) {
    $strKeyword = $_POST["search_product"];
  }
  if (isset($_GET["search_product"])) {
    $strKeyword = $_GET["search_product"];
  }
  ?>
  
  <h2 class="page-header text-center"style="padding-top:25px;">แสดง/ลบข้อมูลสินค้า</h2>
  <hr>

<body>



  
    <form get="POST" class="form-inline" action="">
      <table width="1230px" border="0" align="center">
        <tr>
          <td width="100%">
            <input type="text" class="form-control" placeholder="ค้นหารหัส,ชื่อสินค้า" style="width:200px" name="search_product" id="search_product" />
            <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
          </td>
          <td width="">
            <div align="right">
              <a href="add_product.php"style="width:110px" class="btn btn-primary"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
            </div>
          </td>
        <tr>
      </table>
    </form>
    <br>
  

  <table class="table" align="center" border="0" style="width:1230px;">
    <thead>
      <tr>
        <th style="text-align:right; width:100px;">รหัสสินค้า</th>
        <th style="text-align:left; width:130px;">ชื่อสินค้า</th>
        <th style="text-align:center;width:100px;">รูปภาพ</th>
        <th style="text-align:right;width:100px;">จํานวน</th>
        <th style="text-align:right;width:200px;">ราคาต่อหน่วย (บาท)</th>
        <th style="text-align:center;width:120px;">หน่วยนับ</th>
        <th style="text-align:left;width:100px;">ประเภท</th>
        <th style="text-align:left;width:100px;">สถานะ</th>
        <th style="text-align:center;width:70px;">แก้ไข</th>
        <th style="text-align:center;width:70px;">ลบ</th>
      </tr>
    </thead>
    <tbody>
      <?php

      require_once("config/connect.php");
      $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE category.category_status = 0 AND (product_id LIKE '%" . $strKeyword . "%' OR product_name LIKE '%" . $strKeyword . "%') ORDER BY product_id ASC";
      $query = mysqli_query($link, $sql) or die(mysqli_error($link));
      $num_rows = mysqli_num_rows($query);

      if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
          ?>
          <tr>
            <td align="right"><?= $result['product_id']; ?></td>
            <td><?= $result['product_name']; ?></td>
            <td align="center"><img style="width:66px; height:67px;"src="../<?= $result['product_picture']; ?>"></td>
            <td align="right"><?= $result['product_amount']; ?></td>
            <td align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
            <td align="center"><?= $result['product_unit']; ?></td>
            <td><?= $result['category_name']   ?></td>
            
            <td><?php
                    if ($result['product_status'] == 0) {
                      echo "<span style='color:green;'>ใช้งาน</span>";
                    } elseif ($result['product_status'] == 1) {
                      echo "<span style='color:red;'>ไม่ใช้งาน</span>";
                    }
                    ?></td>
           
            <td class="text-center"><a href="modify_product.php?product_id=<?= $result['product_id']?>" style="width:85px "class="btn btn-primary"><i class="fa fa-pencil-square"></i> แก้ไข</a></td>
            <td align="center"><a href="delete_product.php?product_id=<?= $result['product_id']?>" onclick="if(confirm('ต้องการลบข้อมูลหรือไม่?')) return true; else return false;" style="width:80px" class="btn btn-danger"><i class="fa fa-trash-o"></i>  ลบ</a></td>
          </tr>
      <?php }
      } else { ?>
        <td align="center" bgcolor="#E4E3EA" colspan="10">ไม่พบข้อมูล</td>
    <?php  } ?>
    </tbody>
  </table>