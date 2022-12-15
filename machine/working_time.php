<?php session_start(); 
include('../connect_sqli.php'); 
include_once ('functions-machine.php');

$WorkData = new DB_con();
if (isset($_POST['SubmitStart'])){
$m_mac_id = $_POST['m_mac_id'];
$mc_date_start = $_POST['mc_date_start'];
$mc_user_start = $_POST['mc_user_start'];
$mc_status_work = $_POST['mc_status_work'];

$sql = $WorkData->AddWorking($m_mac_id, $mc_date_start, $mc_user_start, $mc_status_work);

        if ($sql){
            echo "<script>alert('เพิ่มเวลาการทำงาน สำเร็จ!');</script>";
            echo "<script>window.location.href='working_time.php</script>";
        } else{
            echo "<script>alert('เพิ่มเวลการทำงาน ไม่สำเร็จ !!');</script>";
            echo "<script>window.location.href='working_time.php'</script>";
        }
}

$updatedata = new DB_con();

    if (isset($_POST['SubmitEnd'])){

        $mc_work_id = $_POST['mc_work_id'];
        $mc_status_work = $_POST['mc_status_work'];
        $mc_date_end = $_POST['mc_date_end'];
        $mc_user_end = $_POST['mc_user_end'];


        $sql =  $updatedata->updateWorkEnd($mc_work_id, $mc_status_work, $mc_date_end, $mc_user_end);
        if ($sql) {
          echo "<script>alert('หยุดเวลาการทำงาน สำเร็จ !!');</script>";
          echo "<script>window.location.href='working_time.php</script>";
        } else {
          echo "<script>alert('หยุดเวลาการทำงาน ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='working_time.php</script>";
        }
    }

    $Get_id = $_GET['id'];
    $query = "SELECT * FROM working_mc WHERE m_mac_id = '$Get_id' " or die("Error:" . mysqli_error());
    $working = mysqli_query($con, $query);

    $id_count = $_GET['id'];
    $sql3 = "SELECT * FROM working_mc WHERE m_mac_id = $id_count AND mc_status_work = 'กำลังทำงาน' ";
    if ($result3=mysqli_query($con,$sql3))
    {
    $countWorking=mysqli_num_rows($result3);
    mysqli_free_result($result3);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    </head>
<body>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-primary text-white">
                            เพิ่มเวลาการทำงานช่าง : <?php echo $_GET['id']; ?> 
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <div class="col-4">
                            <form method="POST">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" placeholder="รหัสแจ้งซ่อม" value="<?php echo $_GET['id']; ?>" name="m_mac_id" required>
                                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                                <input type="hidden" class="form-control" placeholder="วันที่เริ่ม" value="<?php echo date("Y-m-d H:i:s"); ?>" name="mc_date_start">
                                <span class="input-group-text">ผู้ยืนยัน</span>
                                <input type="text" class="form-control" placeholder="ผู้ยืนยัน" value="<?php echo $_SESSION['u_name']; ?>" name="mc_user_start">
                                <input type="hidden" class="form-control" placeholder="สถานะการทำงาน" value="กำลังทำงาน" name="mc_status_work" required>
                                <button type="submit" class="btn btn-primary" <?php if ($countWorking > 0) { ?>disabled<?php } ?> name="SubmitStart">Start</button>
                            </div>
                            </form>
                        </div>  
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-success text-white">
                        รายการการทำงานช่าง : <?php echo $_GET['m_id']; ?>

                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>รหัส</th>
                                    <th>วันที่เริ่ม</th>
                                    <th>วันที่สิ้นสุด</th>
                                    <th>สถานะ</th>
                                    <th>Admin</th>
                                    <th>ยืนยัน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($working as $row) { 
                                   $datetime_start = $row['mc_date_start'];
                                   $datetime_end = $row['mc_date_end'];
                                   $seconds = strtotime($datetime_end) - strtotime($datetime_start);
                                   $sum += $seconds;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['mc_work_id']; ?></td>
                                    <td class="text-center"><?php echo $row['mc_date_start']; ?></td>
                                    <td class="text-center"><?php echo $row['mc_date_end']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['mc_status_work'] == 'กำลังทำงาน' ){
                                                echo '<span style="color:#F99607">กำลังทำงาน&nbsp;<i class="far fa-clock"></i></span>' ;
                                            } else {
                                                echo '<span style="color:green;">สิ้นสุดการทำงาน&nbsp;<i class=""></i></span>' ;
                                            }
                                        ?>
                                
                                    </td>
                                    <td class="text-center"><?php echo $row['mc_user_start']; ?></td>
                                    <td class="col-1 text-center">
                                        <form method="POST">
                                            <input type="hidden" name="mc_work_id" value="<?php echo $row['mc_work_id']; ?>">
                                            <input type="hidden" name="mc_status_work" value="สิ้นสุดการทำงาน">
                                            <input type="hidden" name="mc_date_end" value="<?php echo date("Y-m-d H:i:s"); ?>">
                                            <input type="hidden" name="mc_user_end" value="<?php echo $_SESSION['u_name']; ?>">

                                        <button type="submit" name="SubmitEnd" onClick="return confirm('ยืนยันสิ้นสุดนับเวลาการทำงาน ?');" class="btn btn-sm btn-danger" <?php if ($row['mc_status_work'] == 'สิ้นสุดการทำงาน') { ?>disabled<?php } ?>><i class="fas fa-check-circle">&nbsp;Stop</i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                     <?php 
                                     
                                     ?>
                                    <th colspan="6">
                                    
                                        รวมเวลา : 
                                        <?php 
                                            $days    = floor($sum / 86400);
                                            $hours   = floor(($sum - ($days * 86400)) / 3600);
                                            $minutes = floor(($sum - ($days * 86400) - ($hours * 3600))/60);
                                            $sum = floor(($sum - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                                         ?>
                                         <?php if ($countWorking == 0) { ?>
                                            <?php echo $days." วัน ".$hours." ชั่วโมง ".$minutes." นาที "; ?>
                                         <?php } ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>
</html>