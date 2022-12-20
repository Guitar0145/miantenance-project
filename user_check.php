<?php
    session_start();
    include_once ('functions-maint.php');
    $updatedata = new DB_con();

    if (isset($_POST['submitupdate'])){

        $m_id = $_GET['id'];
        $user_check = $_POST['user_check'];
        $date_check = $_POST['date_check'];
        $user_comment = $_POST['user_comment'];
        $name_check = $_POST['name_check'];
        $m_status = $_POST['m_status'];


        $sql =  $updatedata->updateUsercheck($user_check, $date_check, $user_comment, $name_check, $m_status, $m_id);
        if ($sql) {
          echo "<script>alert('อัพเดทข้อมูล สำเร็จ !!');</script>";
          echo "<script>window.close();</script>";
        } else {
          echo "<script>alert('อัพเดทข้อมูล ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='appove_status_end.php'</script>";
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัพเดทสถานะ</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid my-3 "> <!--start container-->
<?php
    $m_id = $_GET['id'];
    $upstatus = new DB_con();
    $sql = $upstatus ->fetchstatusend($m_id);
    while($row = mysqli_fetch_array($sql)) {
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header text-strat">
        
      </div>
      <div class="modal-body">
        <h5 class="text-center">ยืนยันตรวจสอบปิดงานช่าง </h5>
        <h5>รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_id'] ?></h5>
        <form method="post">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_id'] ?>" name="m_id" id="m_id" required>
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control" value="YES" name="user_check" id="user_check" required>
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control" value="ตรวจรับงานแล้ว" name="m_status" id="m_status" required>
          </div> 
          <div class="mb-3">
          <div class="input-group mb-3">
            <span class="input-group-text">comment</span>
            <textarea class="form-control" name="user_comment" id="user_comment" required ></textarea>
          </div>
          <div class="input-group mb-3">
                <span class="input-group-text">วันที่ยืนยัน</span>
                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                <input type="datetime" class="form-control" name="date_check" id="date_check" readonly value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?> " required >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">ผู้ตรวจสอบ</span>
            <input type="text" class="form-control" value="<?php echo $_SESSION['u_name']; ?>" name="name_check" id="name_check" required>
          </div> 
      </div>
      <?php } ?>
      <div class="modal-footer">    
        <button type="submit" name="submitupdate" id="submitupdat" class="btn btn-primary" onclick="return confirm('ยืนยันการตรวจสอบ งานช่าง !!')">ยืนยัน</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--End Modal แจ้งซ่อม--><!--จบอัพเดทสถานะ-->  
</body>
</html>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>