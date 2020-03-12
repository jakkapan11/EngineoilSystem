<html>

<head>
  <title>หน้าแรก | อู่ชัยยานยนต์ </title>
</head>

<?php
include("conf/head.php");
include_once("conf/connection.php");
include("conf/mali_cus.php");
?>
</head>
<h2 class="page-header text-center" style="padding-top:70px;"><img src="image/general/shop_name.png" width="245" class="rounded" alt=""></h2>
<hr>
<div class="container" style="padding-top:20px;">

  <body>
    <div class="container mt-3">
      <div class="row">
        <div class="col-12">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleControls" data-slide-to="1"></li>
              <li data-target="#carouselExampleControls" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" style="width:1024px; height:400px;" style=width src="image/general/banner5.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" style="width:1024px; height:400px;" style=width src="image/general/banner4.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" style="width:1024px; height:400px;" style=width src="image/general/banner6.jpg" alt="Third slide">
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
          </div>
        </div>
      </div>

    </div>

    <h5 class="page-header text-center" style="padding-top:30px;"><img src="image/general/product.png" width="150" class="rounded" alt=""></h5>
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
                <img class="card-img-top" style="width:95px; height:115px; padding-top:10px;" src="<?= $result_rec['product_picture'] ?>" alt="Card image cap">
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