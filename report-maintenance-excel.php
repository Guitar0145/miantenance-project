<?php
include('connect_sqli.php');
$query = "SELECT * 
        FROM maintenance
        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
        WHERE m_status = '" . $_GET['m_status'] . "' AND m_datetime 
        BETWEEN '" . $_GET['from_date'] . "' AND '" . $_GET['to_date'] . "' 
        " or die("Error:" . mysqli_error());
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=รายงานระบบแจ้งซ่อมบำรุง.xls");
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
    <style>
        table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
    </style>
</head>

<body>
    <table >
        <tr>
        <tr class="text-center">
            <th>#</th>
            <th>ผู้แจ้ง</th>
            <th>แผนก</th>
            <th class="col-3">อาการ</th>
            <th>ระดับ</th>
            <th>การแก้ไข</th>
            <th>ผู้ตรวจสอบ</th>
            <th>เวลาที่ตรวจสอบ</th>
            <th>สถานะ</th>
            <th>แจ้ง->รับ</th>
            <th>รับ->ปิดเคส</th>
            <th>แจ้ง->ปิดเคส</th>
        </tr>
        </tr>
        <?php foreach ($export as $row) { ?>
        <tr>
            <td>
                <?php echo $row['m_id']; ?>
            </td>
            <td>
                <?php echo $row['m_user']; ?>
            </td>
            <td>
                <?php echo $row['depart_sub_name']; ?>
            </td>
            <td>
                <?php echo $row['m_issue']; ?>
            </td>
            <td>
                <?php echo $row['m_rate']; ?>
            </td>
            <td>
                <?php echo $row['suc_issue']; ?>
            </td>
            <td>
                <?php echo $row['name_check']; ?>
            </td>
            <td>
                <?php echo $row['date_check']; ?>
            </td>
            <td>
                <?php echo $row['m_status']; ?>
            </td>


            <!----------------------------แจ้ง ถึง รับ------------------------------>
            <td>
                <?php
                    $startAp = $row['m_datetime'];
                    $stopAp = $row['ap_datetime'];
                    $diff = strtotime($stopAp) - strtotime($startAp);

                    $fullHours = floor($diff / (60 * 60));
                    $fullMinutes = floor(($diff - ($fullHours * 60 * 60)) / 60);
                    $fullSeconds = floor($diff - ($fullHours * 60 * 60) - ($fullMinutes * 60));
                ?>
                <?php echo $fullHours; ?> ชม.
                <?php echo $fullMinutes; ?> นาที
            </td>
            <!--------------------------------------------------------------------->

            <!----------------------------รับ ถึง ปิดเคส------------------------------>
            <td>
                <?php
                    $suc_date = $row['suc_date'];
                    $suc_time = $row['suc_time'];
                    $MergeDateTime = date('Y-m-d H:i:s', strtotime("$suc_date $suc_time"));
                    $startAp2 = $row['ap_datetime'];
                    $stopSuc = $MergeDateTime;
                    $diff2 = strtotime($stopSuc) - strtotime($startAp2);

                    $fullHours2 = floor($diff2 / (60 * 60));
                    $fullMinutes2 = floor(($diff2 - ($fullHours2 * 60 * 60)) / 60);
                    $fullSeconds2 = floor($diff2 - ($fullHours2 * 60 * 60) - ($fullMinutes2 * 60));
                ?>
                <?php echo $fullHours2; ?> ชม.
                <?php echo $fullMinutes2; ?> นาที
            </td>
            <!--------------------------------------------------------------------->

            <!----------------------------แจ้ง ถึง ปิดเคส------------------------------>
            <td>
                <?php
                    $suc_date3 = $row['suc_date'];
                    $suc_time3 = $row['suc_time'];
                    $MergeDateTime3 = date('Y-m-d H:i:s', strtotime("$suc_date3 $suc_time3"));
                    $startAp3 = $row['m_datetime'];
                    $stopSuc3 = $MergeDateTime3;
                    $diff3 = strtotime($stopSuc3) - strtotime($startAp3);

                    $fullHours3 = floor($diff3 / (60 * 60));
                    $fullMinutes3 = floor(($diff3 - ($fullHours3 * 60 * 60)) / 60);
                    $fullSeconds3 = floor($diff3 - ($fullHours3 * 60 * 60) - ($fullMinutes3 * 60));
                ?>
                <?php echo $fullHours3; ?> ชม.
                <?php echo $fullMinutes3; ?> นาที
            </td>
            <!--------------------------------------------------------------------->
        </tr>
        <?php } ?>
    </table>
</body>

</html>