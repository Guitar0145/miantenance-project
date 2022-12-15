<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

date_default_timezone_set("Asia/Bangkok");
 
 
$step_1 = "09.30";
$work_time_1 = " +1 hour +30 minute ";
$step_1_end = date("Y-m-d H:i",strtotime($step_1.$work_time_1));

$step_2 = $step_1_end;
$work_time_2 = " +1 hour ";
$step_2_end = date("Y-m-d H:i",strtotime($step_2.$work_time_2));

$step_3 = $step_2_end;
$work_time_3 = " +30 minute ";
$step_3_end = date("Y-m-d H:i",strtotime($step_3.$work_time_3));


?>
<?php echo $step_1_end; ?><br>
<?php echo $step_2_end; ?><br>
<?php echo $step_3_end; ?><br>

<hr>

<?php
// รูปแบบของเวลาที่ใช้คำนวณ แบบ 
// อยู่ในรูปแบบ 00:00:00 ถึง 23:59:59
	$time_a="13:20:20";
	$time_b="14:27:14";
    $now_time1=strtotime(date("Y-m-d ".$time_a));
    $now_time2=strtotime(date("Y-m-d ".$time_b));
    $time_diff=abs($now_time2-$now_time1);
    $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน
    $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน
    $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน

// ผลลัพธิ์
// 1 ชั่วโมง 4 นาที 55 วินาที 
?>
<?php echo $time_diff_h; ?> ชม.<?php echo $time_diff_m; ?> นาที<?php echo $time_diff_s; ?> วินาที
<p>
<?php
    $datefist = "2022-09-09";
    $datesecon = "2022-09-12";
    $date1 = new DateTime("$datefist");
    $date2 = new DateTime("$datesecon");
    $diff = $date1->diff($date2);
    echo "".$diff->d." วัน ".$diff->m." เดือน ".$diff->y. " ปี";
?>
<hr>
<br><?php echo $datefist ?> 
<br><?php echo $datesecon ?>
</p>

</body>
</html>
