<head>
    <title>เข้าสู่ระบบ||ระบบขายนํ้ามันเครื่อง</title>
</head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" />
<script src="css/font-awesome.min.css"></script>

<head>
    <?php
    session_start();
    if (isset($_SESSION['emp_id'])) {
        header("Location: index.php");
        exit();
    }

    ?>


</head>

<body>
    <div class="cotainer" style="padding-top:260px;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">เข้าสู่ระบบขายนํ้ามันเครื่อง</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">ชื่อผู้ใช้ :<span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="username" minlength="5" maxlength="15" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่าน :<span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" minlength="8" maxlength="20" required>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="btn btn-primary col-md-12" >เข้าสู่ระบบ</button>  
                            </div>
                            <p class="col-md-4 col-form-label text-md-right"><a target="_blank" href="forgot_password.php"><u>ลืมรหัสผ่าน?</u></a></p>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('config/connect.php');

    // ตรวจสอบว่ามีการล็อคอินอยู่แล้วหรือไม่
    $username    = mysqli_real_escape_string($link, $_POST['username']);
    $password    = mysqli_real_escape_string($link, $_POST['password']);

    $sql         =    "SELECT * FROM employee WHERE emp_username = '" . $username . "' AND emp_password = '" . $password . "' ";

    $data        =     mysqli_query($link, $sql);




    //เช็คผู้ใช้งานซ้ำ
    if (mysqli_num_rows($data) != "0") {
        $data_user              =    mysqli_fetch_assoc($data);

        if ($data_user['emp_status'] == 1) {
            echo "<script> alert('ตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('index.php');</script> ";
            exit();
        }
        $_SESSION['emp_id']     = $data_user['emp_id'];
        $_SESSION['emp_username']  = $data_user['emp_username'];
        $_SESSION['emp_level'] = $data_user['emp_level'];
        echo "<script> alert('เข้าสู่ระบบสำเร็จ');window.location.assign('index.php') </script>";
    } else {
        echo "<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); </script>";
    }

    mysqli_close($link);
}
?>