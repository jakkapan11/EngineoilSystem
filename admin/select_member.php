<head>
    <title>เลือกลูกค้า</title>
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

    <h2 class="page-header text-center" style="padding-top:75px;">เลือกลูกค้า</h2>
    <hr>
    <div class="container">
        <form get="POST" class="form-inline" action="">
            <table width="100%" border="0" align="center">
                <tr>
                    <td width="">
                        <input type="text" class="form-control" placeholder="ค้นหารหัส,ชื่อ,เบอร์โทรศัพท์,อีเมล" style="width:250px" name="search_customers" id="search_customers" />
                        <input type="submit" class="btn btn-primary" id="ค้นหา" value="ค้นหา" />
                    </td>
                </tr>
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
                    <th style="text-align:center;">เลือก</th>
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
              <td align="center">
               <?php   if ($result['cus_status'] != 1) { ?>
               <a href="#" style="padding-left:10px;" class="btn btn-primary" onclick ="select_cus('<?php echo $result['cus_id'];?>','<?php echo $result['cus_name'];?>','<?php echo $result['cus_phone'] ?>');"><i class="fa fa-user"></i> เลือก </a>
                <?php } else { ?>
                  <center>-</center>
                <?php } ?>
            </td>
            </tr>
            
        <?php }
        } else { ?>
          <td align="center" bgcolor="#E4E3EA" colspan="7">ไม่พบข้อมูล</td>
      <?php  } ?>
      </tbody>
    </table>
  </div>  

  <script>
  function select_cus(cus_id , cus_name , cus_phone){


    window.location = 'checkoutemp.php?cus_id=' + cus_id +'&cus_name=' + cus_name + '&cus_phone=' + cus_phone;
    

  }
  
  </script>
