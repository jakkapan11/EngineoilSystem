<html>

<head>
  <title>หน้าแรก | อู่ชัยยานยนต์ </title>
</head>

<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['emp_id'])) {
  echo "<script>window.location.assign('login.php')</script>";
  exit();
}
include("config/head_admin.php");
include_once("config/connect.php");
?>
<h2 class="page-header text-center" style="padding-top:90px;"><img src="image/general/shop_name.png" width="245" class="rounded" alt=""></h2>
<h6 class="page-header text-center" style="padding-top:px;">32/2 หมู่ 2 ตำบลแหลมงอบ อำเภอแหลมงอบ จังหวัดตราด 23120</h6>
<hr>
<div class="container" style="padding-top:20px;">

  <body>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" style="width:1024px; height:400px;" style=width src="image/general/banner5.jpg"alt="First slide">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

    <h4 class="page-header text-center" style="padding-top:40px;">สินค้าแนะนํา</h4>
    <hr>

    <?php
    $sql_rec = "SELECT * FROM product WHERE product_status = 0 ORDER BY product_id ASC";
    $query_rec = mysqli_query($link, $sql_rec);
    $limit_recomend = 6; // จำนวนที่ต้องการจะแสดง

    ?>
    <div class="container">
      <?php
      for ($i = 1; $i <= $limit_recomend; $i++) {
        $result_rec = mysqli_fetch_array($query_rec)
        ?>
        <?php if ($i == 1) { ?><div class="row text-center"> <?php } ?>
          <div class="col-md-4" style="padding-bottom:15px;">

            <div class="card" style="border: 1px solid #C0C0C0;">

              <center>
                <img class="card-img-top" style="width:95px; height:115px; padding-top:10px;" src="../<?= $result_rec['product_picture'] ?>" alt="Card image cap">
              </center>
              <div class="card-body" style="min-height:265px;">
                <h5 class="card-title" style="min-height:50px;"><?= $result_rec['product_name'] ?></h5>
                <hr>
                <p class="card-text"> <?= $result_rec['product_description'] ?></p>
                <hr>
                <form method="POST" class="form-inline" action="add_basket.php">
                  <table border="0" width="220px" align="center">
                    <tr>
                      <td align="right"><b> ราคา </b> </td>
                      <td align="right" style="padding-right:15px;"><b> <?= number_format($result_rec['product_price_unit'], 2); ?></b></td>
                      <td><b>บาท</b></td>
                    </tr>
                    <tr>
                      <td height="100" align="center" colspan="3">
                        <input type="text" name="product_id" id="product_id" value="<?= $result_rec['product_id'] ?>" hidden />
                        <input style="width:80px;" class="form-control" autocomplete="off" onpaste="return false;" onchange="if(this.value <= 0) {alert('จำนวนไม่สามารถน้อยกว่า 1'); this.value='1'; } if (this.value > <?= $result_rec['product_amount'] ?>) { alert('กรุณาตรวจสอบจำนวน'); this.value = '';}" type="number" name="qty" />
                        <input type="submit" class="btn btn-info" name="submit" value="ตะกร้า" />
                      </td>
                    </tr>
                  </table>
                </form>
              </div>


            </div>


          </div>
        <?php if ($i % 3 == 0) {
            echo "</div><div class='row text-center'>";
          }
        }
        ?>
  </body>