<head>
    <title>เข้าสู่ระบบ </title>
</head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="css/font-awesome.min.css"></script>
<link rel="shortcut icon" href="favicon.ico" />
</body>
<?php
session_start();
if (isset($_SESSION['cus_id'])) {
    header("Location: index.php");
    exit();
}
?>

</head>

<body>
    <?php
    include("conf/head.php");
    include("conf/mali_cus.php");
    ?>
    <div class="cotainer" style="padding-top:150px;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">เข้าสู่ระบบ</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">ชื่อผู้ใช้ :<span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="username" minlength="3" maxlength="20" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่าน :<span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" minlength="8" maxlength="20" required>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                                <a href="index.php" class="btn btn-primary" style="width:95px;">ออก</a>
                            </div>
                            <p class="col-md-4 col-form-label text-md-right"><a target="_blank" href="forgot_ password.php">ลืมรหัสผ่าน?</a></p>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('conf/connection.php');

    // ตรวจสอบว่ามีการล็อคอินอยู่แล้วหรือไม่
    $username    = mysqli_real_escape_string($link, $_POST['username']);
    $password    = mysqli_real_escape_string($link, $_POST['password']);

    $sql        =    "SELECT * FROM customers WHERE cus_username = '" . $username . "' AND cus_password = '" . $password . "' ";
    $data       =     mysqli_query($link, $sql);

    //เช็คผู้ใช้งานซ้ำ
    if (mysqli_num_rows($data) != "0") {
        $data_user              =    mysqli_fetch_assoc($data);
        $_SESSION['cus_id']     = $data_user['cus_id'];
        $_SESSION['cus_username']  = $data_user['cus_username'];
        $_SESSION['cus_status'] = $data_user['cus_status'];

        echo "<script> alert('เข้าสู่ระบบสำเร็จ');window.location.assign('index.php') </script>";
    } else {
        echo "<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); </script>";
    }

    mysqli_close($link);
}
?>