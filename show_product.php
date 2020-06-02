<head>
  <title>แสดงสินค้า</title>
  <?php

  session_start();



  include("conf/head.php");
  include("conf/connection.php");
  include("conf/mali_cus.php");

  $strKeyword = null;
  $catg = null;

  if (isset($_POST["search_product"])) {
    $strKeyword = $_POST["search_product"];
  }
  if (isset($_GET["search_product"])) {
    $strKeyword = $_GET["search_product"];
  }
  if (isset($_GET["catg"])) {
    $category = $_GET["catg"];
  }
  ?>

  <h2 class="page-header text-center" style="padding-top:70px;">แสดงสินค้า</h2>
  <hr>

<body>

  <div class="container" style="width:;">
    <form get="POST" class="form-inline" action="">
      <table width="1600px" border="0" align="center">

        <div class="col-sm-5">
          <td width="">

            <?php
            $sql_catg = "SELECT * FROM category WHERE category_status = 0";
            $query_catg = mysqli_query($link, $sql_catg);
            ?>
            <select class="form-control" onchange="if (this.value) window.location.href=this.value">
              <option value="">-- เลือกประเภท -- </option>
              <option value="show_product.php">ทุกประเภท</option>
              <?php while ($result_catg = mysqli_fetch_array($query_catg)) { ?>
                <option value="show_product.php?catg=<?= $result_catg['category_id'] ?>"><?= $result_catg['category_name'] ?></option>

              <?php } ?>
            </select>
        </div>
        <td width="">
          <div align="right">
            <input type="text" class="form-control" placeholder="ค้นหารหัส,ชื่อสินค้า" style="width:200px" name="search_product" id="search_product" />
            <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
        </td>
  </div>
  </td>
  <tr>
    </table>
    </form>
    <br>
    </div>

    <table class="table" align="center" border="0" style="width:1130px;">
      <thead>
        <tr>
          <th style=" text-align:right;width:100">รหัสสินค้า</th>
          <th style="text-align:left;width:20%;">ชื่อสินค้า</th>
          <th style="text-align:center;width:115px;">รูปภาพ</th>
          <th style="text-align:left;width:110px;">ประเภท</th>
          <th style="text-align:right;width:130px;">จํานวน</th>
          <th style="text-align:right;width:180px;">ราคาต่อหน่วย (บาท)</th>
          <th style="text-align:center;width:120px;">จํานวนซื้อ</th>
          <th style="text-align:center;width:80px;"></th>

        </tr>
      </thead>
      <tbody>
        <?php

        require_once("conf/connection.php");
        if (!isset($_GET['catg'])) {
          $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_status = '0' AND category.category_status = 0 AND (product_id LIKE '%" . $strKeyword . "%' OR product_name LIKE '%" . $strKeyword . "%')ORDER BY product_id ASC";
        } else {
          $sql = "SELECT * FROM product LEFT JOIN category on product.category_id = category.category_id WHERE product_status = '0' AND category.category_status = 0 AND (product_id LIKE '%" . $strKeyword . "%' OR product_name LIKE '%" . $strKeyword . "%') AND product.category_id LIKE '" . $category . "'";
        }
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $num_rows = mysqli_num_rows($query);

        if ($num_rows > 0) { // ค้นหพบรายการ ให้แสดง
          while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            if ($result['product_amount'] == 0)
              $product_amount = "<font color='red'>**สินค้าหมด**</font>";
            else
              $product_amount = $result['product_amount'];

        ?>
            <form action="add_basket.php" method="post">
              <tr>
                <td align="right"><?= $result['product_id']; ?>

                </td>

                <td><?= $result['product_name']; ?></td>
                <td align="center"><img style="width:66px; height:67px;" src="<?= $result['product_picture']; ?>"></td>
                <td><?= $result['category_name']   ?></td>
                <td align="right"><?= $product_amount ?></td>
                <td align="right"><?= number_format($result['product_price_unit'], 2); ?></td>
                <td align="center" label for="textfield"></label>
                  <input type="text" name="product_id" id="product_id" value="<?= $result['product_id'] ?>" hidden />
                  <input style="width:75px;" <?php if ($result['product_amount'] == 0) echo "readonly"; ?> class="form-control" autocomplete="off" onpaste="return false;" onchange="if(this.value <= 0) {alert('จำนวนไม่สามารถน้อยกว่า 1'); this.value='1'; } if (this.value > <?= $result['product_amount'] ?>) { alert('กรุณาตรวจสอบจำนวน'); this.value = '';}" type="number" name="qty" /></td>

               
                  <td  <?php if ($result['product_amount'] != 0) { ?> class="text-center"><button type="submit" class="btn btn-info"><i class="fa fa-shopping-cart"></i> ตะกร้า</a></td>
                <?php } ?>
              </tr>
            </form>
          <?php }
        } else { ?>
          <td align="center" bgcolor="#E4E3EA" colspan="10">ไม่พบข้อมูล</td>
        <?php  } ?>
      </tbody>
    </table>