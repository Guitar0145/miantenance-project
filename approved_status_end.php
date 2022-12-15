<?php
    include('connect_sqli.php');
    include_once ('functions-maint.php');
    $updatedata = new DB_con();

    if (isset($_POST['submitupdate'])){

        $m_id = $_GET['id'];
        $m_status = $_POST['m_status'];
        $suc_issue = $_POST['suc_issue'];
        $suc_date = $_POST['suc_date'];
        $suc_time = $_POST['suc_time'];
        $task_status = $_POST['task_status'];


        $sql =  $updatedata->updateEnd2($m_status, $suc_issue, $suc_date, $suc_time, $task_status, $m_id);
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
     
      
      $query = "SELECT * FROM tasker WHERE m_id = $m_id " or die("Error:" . mysqli_error());
      $taskerEnd = mysqli_query($con, $query);
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ปิดงานเคสงาน รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_id'] ?></h5>
      </div>
      <div class="modal-body">
        <form method="post">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_id'] ?>" name="m_id" id="m_id" required>
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control" readonly value="เสร็จสิ้น" name="m_status" id="m_status" required>
          </div> 
          <div class="mb-3">
          <div class="input-group mb-3">
            <span class="input-group-text">การแก้ไข</span>
            <textarea class="form-control" name="suc_issue" id="suc_issue"  required ></textarea>
          </div>

            <?php date_default_timezone_set("Asia/Bangkok"); ?>
            <input type="hidden" class="form-control" name="suc_date" id="suc_date" value="<?php echo date("Y-m-d"); ?>" required>
            <input type="hidden" class="form-control" name="suc_time" id="suc_time" value="<?php echo date("H:i:s"); ?> " required>
            <?php foreach ( $taskerEnd AS $taskerEnd ) { ?>
            <input type="hidden" class="form-control" name="task_status" id="task_status" value="ทำงานเสร็จสิ้น" required>
              <?php } ?>

      </div>
      <?php } ?>
      <div class="modal-footer">    
        <button type="submit" name="submitupdate" id="submsubmitupdateit" class="btn btn-primary">ปิดงาน</button>
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