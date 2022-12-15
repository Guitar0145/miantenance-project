<?php
    session_start();
    include_once ('functions-machine.php');
    $updatedata = new DB_con();

    if (isset($_POST['submitupdate'])){

        $m_mac_id = $_GET['id'];
        $m_check_status = $_POST['m_check_status'];
        $m_mac_datecheck = $_POST['m_mac_datecheck'];
        $m_mac_comment = $_POST['m_mac_comment'];
        $m_mac_check = $_POST['m_mac_check'];

        $sql =  $updatedata->updateUsercheck($m_check_status, $m_mac_datecheck, $m_mac_comment, $m_mac_check, $m_mac_id);
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
  <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
  <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid my-3 "> <!--start container-->
<?php
    $m_mac_id = $_GET['id'];
    $upstatus = new DB_con();
    $sql = $upstatus ->fetchstatusend($m_mac_id);
    while($row = mysqli_fetch_array($sql)) {
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header text-strat">
        
      </div>
      <div class="modal-body">
        <h5 class="text-center">ยืนยันตรวจสอบปิดงานช่าง </h5>
        <h5>รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_mac_id'] ?></h5>
        <form method="post">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_mac_id'] ?>" name="m_mac_id" id="m_mac_id" required>
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control" value="YES" name="m_check_status" id="m_check_status" required>
          </div> 
          <div class="mb-3">
          <div class="input-group mb-3">
            <span class="input-group-text">comment</span>
            <textarea class="form-control" name="m_mac_comment" id="m_mac_comment" required ></textarea>
          </div>
          <div class="input-group mb-3">
                <span class="input-group-text">วันที่ยืนยัน</span>
                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                <input type="datetime" class="form-control" name="m_mac_datecheck" id="m_mac_datecheck" readonly value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?> " required >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">ผู้ตรวจสอบ</span>
            <input type="text" class="form-control" value="<?php echo $_SESSION['u_name']; ?>" name="m_mac_check" id="m_mac_check" required>
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