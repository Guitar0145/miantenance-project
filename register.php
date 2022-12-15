<?php
        include_once ('functions-maint.php');

        $userdata = new DB_con();
        
        if (isset($_POST['submit'])){
            $fname = $_POST['fname'];
            $u_depart = $_POST['u_depart'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $level = $_POST['level'];

            $sql = $userdata->registration($fname, $u_depart, $username, $password, $level);

            if ($sql){
                echo "<script>alert('สมัครสมาชิกสำเร็จ !!');</script>";
                echo "<script>window.location.href='index.php'</script>";
            } else{
                echo "<script>alert('สมัครสมาชิกไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
                echo "<script>window.location.href='index.php'</script>";
            }
        }
?>
<?php
        include('connect_sqli.php'); 
        $query = "SELECT * FROM categories ORDER BY c_id " or die("Error:" . mysqli_error());
        $cate = mysqli_query($con, $query);

        $query3 = "SELECT * FROM subtasks ORDER BY st_id " or die("Error:" . mysqli_error());
        $subt= mysqli_query($con, $query3);

        $query2 = "SELECT * FROM depart ORDER BY depart_id " or die("Error:" . mysqli_error());
        $depart = mysqli_query($con, $query2);      
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบซ่อม IT Service</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
</head>

<body>
<?php include 'navbar.php';?>
<div class="container-fluid p-5 my-5 "> <!--start container-->
<div class="card">
  <div class="card-body">
    <div class="container col-4">
        <div class="card">
             <div class="card-header">
                <h1 class="mt-5">Register page</h1>
                <hr>
                <form method="post">
                    <div class="mb-3">
                        <label for="fname" class="form-label">ชื่อ-สกุล</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="depart" class="form-label">แผนก</label>
                        <select class="form-select" required name="u_depart" id="u_depart">
                                <option selected>เลือกแผนก...</option>
                                <?php foreach($depart as $depart){?>
                                    <option value="<?php echo $depart["depart_sub_name"];?>"><?php echo $depart["depart_sub_name"];?></option>
                                <?php } ?>
                                </select>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="username" name="username" required onblur="checkusername(this.value)">
                        <span id="usernameavailable"></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" required name="password">
                    </div>
                    <div class="mb-3">
                        <label for="depart" class="form-label">ระดับสิทธิ</label>
                        <select class="form-select" required name="level" id="level">
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                    </div>
                    <button type="submit" name="submit" id="submit" class="btn btn-success">สมัครสมาชิก</button>
                </form>
            </div>
        </div>
    </div>

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
</div>
</div> <!--End container--> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> //เช็ค user ที่เหมือนกัน
    function checkusername(val) {
        $.ajax({
            type: 'POST',
            url: 'checkuser_available.php',
            data: 'username='+val,
            success: function(data){
                $('#usernameavailable').html(data);
            }
        });
    }
</script>
<?php include 'footer.php';?>
</body>
</html>