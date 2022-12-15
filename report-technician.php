<?php 
session_start();
include('connect_sqli.php');
$query = "SELECT * FROM technician " or die("Error:" . mysqli_error());
$technic = mysqli_query($con, $query);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานช่าง</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>
<?php include 'navbar.php' ?>
<div class="container-fluid">
        <div class="mt-2">
            <div class="card p-1">
            <div class="card-header text-white" style="font-weight: bold; background-color:#058961;">
                           เลือก Filter ให้ครบเพื่อกรองรายงานช่าง
                        </div>
                    <div class="card-body shadow mb-2 bg-white">
                    <form action="report-technician.php" method="GET" class="row my-2 g-1">
                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                                    <select name="tc_name" class="form-select">
                                        <option selected>
                                        <?php 
                                                if(isset($_GET['tc_name']))
                                                {
                                                    echo $_GET['tc_name']; 
                                                } else {
                                                    echo 'เลือกช่าง';
                                                }
                                                ?>
                                        </option>
                                        <?php foreach($technic as $technic){?>
                                        <option value="<?php echo $technic['tc_name'];?>"><?php echo $technic['tc_name'];?></option>
                                        <?php } ?>
                                        <option value="ทั้งหมด">ทั้งหมด</option>
                                    </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                                    <select name="task_status" class="form-select">
                                        <option selected>
                                            <?php 
                                                if(isset($_GET['task_status']))
                                                {
                                                    echo $_GET['task_status']; 
                                                } else {
                                                    echo 'เลือกสถานะ'; 
                                                }
                                            ?>
                                        </option>
                                        <option value="ทำงานเสร็จสิ้น">ทำงานเสร็จสิ้น</option>
                                        <option value="กำลังทำงาน">กำลังทำงาน</option>
                                        <option value="ทั้งหมด">ทั้งหมด</option>
                                    </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                                <input type="date" class="form-control" name="from_date" placeholder="dd-mm-yyyy" id="from" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date']; } ?>">
                            </div>
                            <div class="col-auto p-2">
                                <span>ถึง</span>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                                <input type="date" class="form-control" name="to_date" id="to" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date']; } ?>">
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                                <button name="submit" type="submit" class="btn btn-primary">ค้นหา</button>
                            </div>
                        </form>
                            <div class="table-responsive-md">
                        <table id="myTable" class="table table-hover table-striped table-bordered p-1" style="font-size:14px;">
                            <thead class="sticky-top" style="background-color: #0067B8;color:#fff;">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="col-3">อาการ</th>
                                    <th>ชื่อ</th>
                                    <th>สถานะงาน</th>
                                    <th>ความยาก</th>
                                    <th>วันที่แจ้งซ่อม(User)</th>
                                    <th>วันที่รับงาน(ช่าง)</th>
                                    <th>ตรวจสอบงาน(User)</th>
                                    <th>เวลารอคอยช่าง</th>
                                    <th>เวลาที่ใช้ซ่อม</th>
                                    <th>เวลา (ชม:นาที)</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <?php 
                                    if(isset($_GET['submit'])){
                                        $whereTech = "";
                                        $whereStatus = "";
                                        $allTech = "ทั้งหมด";
                                        $allStatus = "ทั้งหมด";
                                        $tc_name = $_GET['tc_name'];
                                        if( $tc_name == $allTech ){
                                            $whereTech .= "";
                                        }else {
                                            $whereTech .= "technician.tc_name = '$tc_name' AND";
                                        }

                                        $task_status = $_GET['task_status'];
                                        if ($task_status == $allStatus ) {
                                            $whereStatus .= "";
                                        } else {
                                            $whereStatus .= "task_status = '$task_status' AND";
                                        }

                                        $from_date = $_GET['from_date'];
                                        $to_date = $_GET['to_date'];

                                        if($tc_id != "" || $task_status != "" || $fdate != "" || $tdate != "" ){
                                            $query = "SELECT * 
                                                FROM technician
                                                INNER JOIN tasker ON technician.tc_id = tasker.tc_id
                                                LEFT JOIN maintenance ON tasker.m_id = maintenance.m_id
                                                WHERE {$whereTech} {$whereStatus}  date_task 
                                                BETWEEN '". $from_date."' AND '".$to_date."' 
                                                
                                                ";
                                            
                                            $data = mysqli_query($con, $query) or die('error');
                                            if(mysqli_num_rows($data) > 0){
                                                while ($row = mysqli_fetch_assoc($data)){
                                                    $m_id = $row['m_id'];
                                                    $m_issue = $row['m_issue'];
                                                    $tc_name = $row['tc_name'];
                                                    $task_status = $row['task_status'];
                                                    $m_rate = $row['m_rate'];
                                                    $task_score = $row['task_score'];
                                                    $m_datetime = $row['m_datetime'];
                                                    $date_task = $row['date_task'];
                                                    $date_check = $row['date_check'];

                                                    // ตัวแปรเก็บค่า เวลาคำนวณรอคอยช่าง
                                                    $daterepair = $row['m_datetime'];
                                                    $dateapprove = $row['date_task'];
                                                    $seconds_approve = strtotime($dateapprove) - strtotime($daterepair);
                                                     
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $m_id; ?></td>
                                                        <td><?php echo $m_issue; ?></td>
                                                        <td><?php echo $tc_name; ?></td>
                                                        <td class="text-center"><?php echo $task_status; ?></td>
                                                        <td class="text-center"><?php echo $m_rate; ?></td>
                                                        <td class="text-center"><?php echo $m_datetime; ?></td>
                                                        <td class="text-center"><?php echo $date_task; ?></td>
                                                        <td class="text-center"><?php echo $date_check; ?></td>
                                                        <td class="text-end">
                                                        <?php 
                                                            $days    = floor($seconds_approve / 86400);
                                                            $hours   = floor(($seconds_approve - ($days * 86400)) / 3600);
                                                            $minutes = floor(($seconds_approve - ($days * 86400) - ($hours * 3600))/60);
                                                            $seconds_approve = floor(($seconds_approve - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                                                        ?>
                                                        <?php echo $days." วัน ".$hours." ชั่วโมง ".$minutes ." นาที "; ?>
                                                        </td>
                                                        <td class="text-end">
                                                        <?php 
                                                            $Get_id = $m_id;
                                                            $query2 = "SELECT * FROM working WHERE m_id = '$Get_id' AND status_work = 'สิ้นสุดการทำงาน' " or die("Error:" . mysqli_error());
                                                            $working = mysqli_query($con, $query2);

                                                            foreach ($working as $row ) {
                                                            // ตัวแปรเก็บค่า เวลาคำนวณรอคอยช่าง
                                                            $date_start = $row['date_start'];
                                                            $date_stop = $row['date_end'];
                                                            $seconds_real = strtotime($date_stop) - strtotime($date_start);
                                                        
                                                            // sum รวมผลลัพธ์ทุกแถวที่ได้จากตัวแปร seconds
                                                            $sum += $seconds_real;
                                                        }
                                                            $days_real    = floor($sum / 28800);
                                                            $hours_real   = floor(($sum - ($days_real  * 28800)) / 3600);
                                                            $minutes_real = floor(($sum - ($days_real  * 28800) - ($hours_real  * 3600))/60);
                                                            $sum = floor(($sum - ($days_real  * 28800) - ($hours_real  * 3600) - ($minutes_real *60)));
                                                            // 28800 คือจำนวนวินาที ของ 8 ชม โดยการคิดเวลาการทำงาน 8 ชม มีค่าเท่ากับ 1 วัน
                                                        ?>
                                                        <?php echo $days_real ." วัน ".$hours_real ." ชั่วโมง ".$minutes_real ." นาที ";  ?>
                                                        </td>
                                                        <td class="text-end">
                                                        <?php 
                                                            $Get_id2 = $m_id;
                                                            $query3 = "SELECT * FROM working WHERE m_id = '$Get_id2' AND status_work = 'สิ้นสุดการทำงาน' " or die("Error:" . mysqli_error());
                                                            $working = mysqli_query($con, $query3);

                                                            foreach ($working as $row ) {
                                                            // ตัวแปรเก็บค่า เวลาคำนวณรอคอยช่าง
                                                            $date_start2 = $row['date_start'];
                                                            $date_stop2 = $row['date_end'];
                                                            $seconds_real2 = strtotime($date_stop2) - strtotime($date_start2);
                                                        
                                                            // sum รวมผลลัพธ์ทุกแถวที่ได้จากตัวแปร seconds
                                                            $sum2 += $seconds_real2;
                                                        }
                                                            $hours_real2   = floor($sum2 / 3600);
                                                            $minutes_real2 = floor(($sum2 - ($hours_real2  * 3600))/60);
                                                            $sum2 = floor(($sum2 - ($hours_real2  * 3600) - ($minutes_real2 *60)));
                                                        
                                                        ?>
                                                        <?php echo $hours_real2 .":".$minutes_real2 .":".$sum2 ."";  ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                <tr>
                                                    <td colspan="12" class="text-center" style="color:red;">ไม่เจอข้อมูลที่ท่านต้องการ !</td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        
                                    }
                                ?>

                            </tbody>
                        </table>
                        <form action="report-technician-excel.php" method="get">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3"><button type="submit" class="btn btn-success shadow mb-4" >
                                    <input type="hidden" value="<?php if(isset($_GET['tc_name'])){ echo $_GET['tc_name']; } ?>" name="tc_name">
                                    <input type="hidden" value="<?php if(isset($_GET['task_status'])){echo $_GET['task_status']; }?>" name="task_status">
                                    <input type="hidden" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date']; } ?>" name="from_date">
                                    <input type="hidden" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date']; } ?>" name="to_date">
                                <i class="fas fa-file-excel"></i>&nbsp;Export</button>
                            </div>
                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
    $('#myTable').DataTable();
        } );
    </script>
    <?php include 'footer.php';?>
</body>
</html>