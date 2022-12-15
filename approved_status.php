<?php
    session_start();
    include_once ('functions-maint.php');
    include('connect_sqli.php'); 
    $updatedata = new DB_con();

    if (isset($_POST['submitupdate'])){

        $m_id = $_GET['id'];
        $m_issue = $_POST['m_issue'];
        $check_status = $_POST['check_status'];
        $m_admin = $_POST['m_admin'];
        $m_status = $_POST['m_status'];
        $m_c_id = $_POST['m_c_id'];
        $times_limit = $_POST['times_limit'];
        $m_rate = $_POST['m_rate'];
        $ap_datetime = $_POST['ap_datetime'];

        $sql =  $updatedata->updatestatus($m_issue, $check_status, $m_admin, $m_status, $m_c_id, $times_limit, $m_rate, $ap_datetime, $m_id);
        if ($sql) {
          echo "<script>alert('อัพเดทข้อมูล สำเร็จ !!');</script>";
          echo "<script>window.close();</script>";
        } else {
          echo "<script>alert('อัพเดทข้อมูล ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='appove_status.php'</script>";
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
    $sql = $upstatus ->fetchonerecord($m_id);
    while($row = mysqli_fetch_array($sql)) {
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">รับงาน รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_id'] ?></h5>
      </div>
      <div class="modal-body">
        <form method="post">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_id'] ?>" name="m_id" id="m_id" required>
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="ผู้แจ้งซ่อม(ชื่อเล่น)" value="<?php echo $row['m_user'] ?>" name="m_user" id="m_user" required>
          </div>
          <div class="input-group mb-3">
          <span class="input-group-text">ประเภทงาน</span>
            <input type="text" class="form-control" readonly  value="<?php echo $row['c_name'] ?>" name="c_name" id="c_name" required>
          </div>
          <div class="input-group mb-3">
          <span class="input-group-text">อาการ</span>
            <textarea class="form-control" name="m_issue" id="m_issue"  required ><?php echo $row['m_issue'] ?></textarea>
          </div>
          <div class="mb-3">
         
          <div class="mb-3">
            <input type="hidden" class="form-control" readonly value="กำลังดำเนินการ" name="m_status" id="m_status" required>
          </div> 
          <div class="mb-3">
        <div class="input-group mb-3">
        <span class="input-group-text">ผู้รับงาน</span>
            <input type="text" readonly class="form-control" placeholder="ผู้รับงาน" value="<?php echo $_SESSION['u_name']; ?>" name="m_admin" id="m_admin" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">การตรวจสอบ</span>
            <select class="form-select" required name="check_status" id="check_status">
                <option value="ตรวจสอบแล้ว">ตรวจสอบแล้ว</option>
                <option value="ยกเลิก">ยกเลิก</option>
            </select>
          </div>
          <div class="input-group mt-3">
              <span class="input-group-text">ประเภทงาน</span>
              <?php $strDefault = $row['m_c_id']; ?>
                  <select class="form-select" name="m_c_id">
                      <option value=""><-- เลือกประเภทงานซ่อม --></option>
                      <?php
                          $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                          $objQuery = mysqli_query($con,$strSQL);
                          while($objResuut = mysqli_fetch_array($objQuery))
                          {
                              if($strDefault == $objResuut["c_id"])
                              {
                                  $categories = "selected";
                              } else
                              {
                                  $categories = "";
                              }
                      ?>
                      <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                      <?php } ?>
                  </select>
          </div>
          <div class="input-group mt-3">
        <span class="input-group-text">ระยะเวลางาน</span>
            <input type="number" class="form-control" placeholder="ระยะเวลา(ชม.)" value="" min="0" name="times_limit" id="times_limit" required>
        </div>
                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                <input type="hidden" class="form-control" name="ap_datetime" id="ap_datetime" readonly value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?> " required >
			  <div class="mt-2">
          <label for="customRange2" class="form-label">ระดับความยากง่ายของงาน</label>
          <input type="range" class="form-range" min="0" max="10" name="m_rate" id="myRange">
          <h5>ความยาก : <span id="demo"></span></h5>
        </div>
        
      </div>
      <?php } ?>
      <div class="modal-footer">    
        <button type="submit" name="submitupdate" id="submsubmitupdateit" class="btn btn-primary">ยืนยัน</button>
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