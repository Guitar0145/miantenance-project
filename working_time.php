<?php session_start(); 
include('connect_sqli.php'); 
include_once ('functions-maint.php');

$WorkData = new DB_con();
if (isset($_POST['SubmitStart'])){
$m_id = $_POST['m_id'];
$date_start = $_POST['date_start'];
$user_start = $_POST['user_start'];
$status_work = $_POST['status_work'];

$sql = $WorkData->AddWorking($m_id, $date_start, $user_start, $status_work);

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

        $work_id = $_POST['work_id'];
        $status_work = $_POST['status_work'];
        $date_end = $_POST['date_end'];
        $user_end = $_POST['user_end'];


        $sql =  $updatedata->updateWorkEnd($work_id, $status_work, $date_end, $user_end);
        if ($sql) {
          echo "<script>alert('หยุดเวลาการทำงาน สำเร็จ !!');</script>";
          echo "<script>window.location.href='working_time.php</script>";
        } else {
          echo "<script>alert('หยุดเวลาการทำงาน ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='working_time.php</script>";
        }
    }

    $Get_id = $_GET['m_id'];
    $query = "SELECT * FROM working WHERE m_id = '$Get_id' " or die("Error:" . mysqli_error());
    $working = mysqli_query($con, $query);

    $query2 = "SELECT * FROM maintenance WHERE m_id = '$Get_id' " or die("Error:" . mysqli_error());
    $mainternace = mysqli_query($con, $query2);

    $m_id_count = $_GET['m_id'];
    $sql3 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
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
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
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
                            เพิ่มเวลาการทำงานช่าง : <?php echo $_GET['m_id']; ?> 
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <div class="col-4">
                            <form method="POST">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" placeholder="รหัสแจ้งซ่อม" value="<?php echo $_GET['m_id']; ?>" name="m_id" required>
                                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                                <input type="hidden" class="form-control" placeholder="วันที่เริ่ม" value="<?php echo date("Y-m-d H:i:s"); ?>" name="date_start">
                                <span class="input-group-text">ผู้ยืนยัน</span>
                                <input type="text" class="form-control" placeholder="ผู้ยืนยัน" value="<?php echo $_SESSION['u_name']; ?>" name="user_start">
                                <input type="hidden" class="form-control" placeholder="สถานะการทำงาน" value="กำลังทำงาน" name="status_work" required>
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
                                    
                                    $datetime_start = $row['date_start'];
                                    $datetime_end = $row['date_end'];
                                    $seconds = strtotime($datetime_end) - strtotime($datetime_start);
                                    $sum += $seconds;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['work_id']; ?></td>
                                    <td class="text-center"><?php echo $row['date_start']; ?></td>
                                    <td class="text-center"><?php echo $row['date_end']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['status_work'] == 'กำลังทำงาน' ){
                                                echo '<span style="color:#F99607">กำลังทำงาน&nbsp;<i class="far fa-clock"></i></span>' ;
                                            } else {
                                                echo '<span style="color:green;">สิ้นสุดการทำงาน&nbsp;<i class=""></i></span>' ;
                                            }
                                        ?>
                                
                                    </td>
                                    <td class="text-center"><?php echo $row['user_start']; ?></td>
                                    <td class="col-1 text-center">
                                        <form method="POST">
                                            <input type="hidden" name="work_id" value="<?php echo $row['work_id']; ?>">
                                            <input type="hidden" name="status_work" value="สิ้นสุดการทำงาน">
                                            <input type="hidden" name="date_end" value="<?php echo date("Y-m-d H:i:s"); ?>">
                                            <input type="hidden" name="user_end" value="<?php echo $_SESSION['u_name']; ?>">

                                        <button type="submit" name="SubmitEnd" onClick="return confirm('ยืนยันสิ้นสุดนับเวลาการทำงาน ?');" class="btn btn-sm btn-danger" <?php if ($row['status_work'] == 'สิ้นสุดการทำงาน') { ?>disabled<?php } ?>><i class="fas fa-check-circle">&nbsp;Stop</i></button>
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

                                         | <a style="color:red; font-weight:bold;">Time Limit :  </a>
                                            <?php foreach ($mainternace AS $mainternace) 
                                            { 
                                                $times_limit = $mainternace['times_limit'];
                                                $limit_day = floor ($mainternace['times_limit']/8);
                                                $limit_hours = $mainternace['times_limit']%8;
                                                echo "<a style='color:red; font-weight:bold;'>" .$limit_day. " วัน ". $limit_hours." ชั่วโมง " . "</a>" ;
                                            } ?>
                                       
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