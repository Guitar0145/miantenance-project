<?php
    include('../connect_sqli.php');
    include_once ('functions-machine.php');
    $updatedata = new DB_con();

    if (isset($_POST['submitupdate'])){

        $m_mac_id = $_GET['id'];
        $mainmac_status = $_POST['mainmac_status'];
        $m_suc_issue = $_POST['m_suc_issue'];
        $m_suc_date = $_POST['m_suc_date'];
        $switch_machine = $_POST['switch_machine'];
        $task_mac_status = $_POST['task_mac_status'];


        $sql =  $updatedata->updateEnd2($mainmac_status, $m_suc_issue, $m_suc_date, $switch_machine, $task_mac_status, $m_mac_id);
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
  <script src="../js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid my-3 "> <!--start container-->
<?php
    $m_mac_id = $_GET['id'];
    $upstatus = new DB_con();
    $sql = $upstatus ->fetchstatusend($m_mac_id);
    while($row = mysqli_fetch_array($sql)) {
     
      
      $query = "SELECT * FROM tasker_mac WHERE m_mac_id = $m_mac_id " or die("Error:" . mysqli_error());
      $taskerEnd = mysqli_query($con, $query);
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ปิดงานเคสงาน รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_mac_id'] ?></h5>
      </div>
      <div class="modal-body">
        <form method="post">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="text" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_mac_id'] ?>" name="m_mac_id" id="m_mac_id" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" readonly value="เสร็จสิ้น" name="mainmac_status" id="mainmac_status" required>
          </div> 
          <div class="mb-3">
          <div class="input-group mb-3">
            <span class="input-group-text">การแก้ไข</span>
            <textarea class="form-control" name="m_suc_issue" id="m_suc_issue"  required ></textarea>
          </div>

            <?php date_default_timezone_set("Asia/Bangkok"); ?>
            <input type="text" class="form-control" name="m_suc_date" id="m_suc_date" value="<?php echo date("Y-m-d H:i:s"); ?>" required>
            <input type="text" class="form-control" name="switch_machine" id="switch_machine" value="1" required>
            <?php foreach ( $taskerEnd AS $taskerEnd ) { ?>
            <input type="text" class="form-control" name="task_mac_status" id="task_mac_status" value="ทำงานเสร็จสิ้น" required>
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