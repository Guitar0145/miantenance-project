<?php
    include_once ('function-update-file.php');
    $updatedata = new DB_con();

// Insert Record in customer table
    if(isset($_POST['submit'])) {

        $m_id = $_GET['id'];
        $file = $_FILES['m_img'];
        $insertData = $updatedata->UploadImg($file, $m_id);

        if ($insertData){
            header("Location:index.php");
        }else{
            return false;
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
    $sql = $upstatus ->fetchImg($m_id);
    while($row = mysqli_fetch_array($sql)) {
?>
<div class="card">
  <div class="card-body">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">อัปโหลดไฟล์ภาพ รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_id'] ?></h5>
      </div>
      <div class="modal-body">
      <form method="POST" action="upload-file.php" enctype="multipart/form-data">
        <div class="mb-3">
			  <div class="mb-3">
            <input type="hidden" class="form-control" readonly placeholder="รหัสแจ้งซ่อม" value="<?php echo $row['m_id'] ?>" name="m_id" id="m_id" required>
          </div>
          <div class="mb-3">
            <input type="file" class="form-control" readonly name="m_img" id="m_img" required>
          </div>
      </div>
      <?php } ?>
      <div class="modal-footer">    
        <button type="submit" name="submit" id="submit" class="btn btn-primary">อัปโหลด</button>
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