<?php 
include('connect_sqli.php');

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


$query = "SELECT * 
        FROM technician
        INNER JOIN tasker ON technician.tc_id = tasker.tc_id
        LEFT JOIN maintenance ON tasker.m_id = maintenance.m_id
        LEFT JOIN categories ON maintenance.m_c_id = categories.c_id
        LEFT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
        WHERE {$whereTech} {$whereStatus} date_task 
        BETWEEN '".$_GET['from_date']."' AND '".$_GET['to_date']."'
        ORDER BY  maintenance.m_id ASC
        " or die("Error:" . mysqli_error());
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=การรับงาน ".$_GET['tc_name'].".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    
        
$export = mysqli_query($con, $query);  


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Excel</title>
</head>
<body>
<table>
    <tr>
        <th>#</th>
        <th>รหัสแจ้ง</th>
        <th>ผู้แจ้ง</th>
        <th>อาการ</th>
        <th>จำนวนคน</th>
        <th>ความเร่งด่วน</th>
        <th>ประเภทงาน</th>
        <th>ประเภทงานย่อย</th>
        <th>การแก้ไข</th>
        <th>ชื่อผู้รับงาน</th>
        <th>ชื่อเล่น</th>
        <th>ช่าง</th>
        <th>สถานะงาน</th>
        <th>ความยาก</th>
        <th>วันที่แจ้งซ่อม(User)</th>
        <th>วันที่รับงาน(ช่าง)</th>
        <th>ตรวจสอบงาน(User)</th>
        <th>เวลารอคอยช่าง</th>
        <th>เวลาที่ใช้ซ่อม</th>
        <th>เวลา (ชม:นาที)</th>
        <th>Time Limit</th>
        <th>เวลา(ชม:นาที)</th>
        <th>รอตรวจสอบ(วัน:ชม:นาที)</th>
    </tr>
    <?php foreach($export as $row){
        $daterepair = $row['m_datetime'];
        $dateapprove = $row['date_task'];
        $seconds_approve = strtotime($dateapprove) - strtotime($daterepair);

        $m_id_count = $row['m_id'];
        $sql2 = "SELECT * FROM tasker WHERE m_id = $m_id_count ";
        if ($result2=mysqli_query($con,$sql2))
        {
            $countPer=mysqli_num_rows($result2);
            mysqli_free_result($result2);
        }
    ?>
    <tr>
        <td><?php echo $row ['task_id']; ?></td>
        <td><?php echo $row ['m_id']; ?></td>
        <td><?php echo $row ['m_user']; ?></td>
        <td><?php echo $row ['m_issue']; ?></td>
        <td><?php echo $countPer; ?></td>
        <td><?php echo $row ['m_urgency']; ?></td>
        <td><?php echo $row ['c_name']; ?></td>
        <td><?php echo $row ['st_name']; ?></td>
        <td><?php echo $row ['suc_issue']; ?></td>
        <td><?php echo $row ['tc_name']; ?></td>
        <td><?php echo $row ['tc_nickname']; ?></td>
        <td><?php echo $row ['tc_depart']; ?></td>
        <td><?php echo $row ['task_status']; ?></td>
        <td><?php echo $row ['m_rate']; ?></td>
        <td><?php echo $row ['m_datetime']; ?></td>
        <td><?php echo $row ['date_task']; ?></td>
        <td><?php echo $row ['date_check']; ?></td>
        <td class="text-end">
        <?php 
            $days    = floor($seconds_approve / 86400);
            $hours   = floor(($seconds_approve - ($days * 86400)) / 3600);
            $minutes = floor(($seconds_approve - ($days * 86400) - ($hours * 3600))/60);
            $seconds_approve = floor(($seconds_approve - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
            echo $days." วัน ".$hours." ชั่วโมง ".$minutes ." นาที ";
        ?>
        </td>
        <td class="text-end">
        <?php 
            $Get_id = $m_id_count;
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
            echo $days_real ." วัน ".$hours_real ." ชั่วโมง ".$minutes_real ." นาที "; 
        ?>
        </td>
        <td class="text-center">
            <?php 
                $Get_id2 = $m_id_count;
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
        <td>
            <?php 
                $query2 = "SELECT * FROM maintenance WHERE m_id = '$Get_id' " or die("Error:" . mysqli_error());
                $mainternace = mysqli_query($con, $query2);
            ?>
            <?php foreach ($mainternace AS $mainternace) 
                { 
                    $times_limit = floor ($mainternace['times_limit']);
                    $limit_day = floor ($mainternace['times_limit']/8);
                    $limit_hours = $mainternace['times_limit']%8;
                    $limit_min = 0;
                    $limit_second = 0;
                    echo "<a>" .$limit_day. " วัน ". $limit_hours." ชั่วโมง " . "</a>" ;
                } ?>
        </td>
        <td><?php echo $times_limit .":".$limit_min .":".$limit_second ."";  ?></td>
        <td><?php echo $days.":".$hours.":".$minutes."";  ?></td>

    </tr>
    <?php } ?>
</table>
</body>
</html>