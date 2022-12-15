<?php
    include_once ('functions-machine.php');
?>
<?php
        include('../connect_sqli.php'); 
        $query = "SELECT * FROM cate_repair ORDER BY cate_re_id " or die("Error:" . mysqli_error());
        $cate_re = mysqli_query($con, $query);

        $query2 = "SELECT * FROM department ORDER BY dep_id " or die("Error:" . mysqli_error());
        $depart = mysqli_query($con, $query2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดงาน</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style>
        .gold {
            color:#FFD700;
        }
    </style>
</head>
<body>
<div class="container-fluid">
<div class="card p-2">
<?php
    $m_mac_id = $_GET['id'];
    $detailTask = new DB_con();
    $sql = $detailTask ->fetchTaskmaint($m_mac_id);
    while($row = mysqli_fetch_array($sql)) {
?>
    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="6">รายการแจ้งซ่อมเครื่องจักร #<?php echo $row['m_mac_id'] ?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ผู้แจ้ง</th>
                <th>อาการ</th>
                <th>ความเร่งด่วน</th>
                <th>ตรวจสอบ</th>
                <th>วันที่แจ้ง</th>
                </tr>
                <tr class="text-center">
                <td><?php echo $row['m_mac_name'] ?> / <?php echo $row['depart_sub_name'] ?></td>
                <td><?php echo $row['m_mac_issue'] ?></td>
                <td><?php echo $row['m_mac_urgency'] ?></td>
                <td><?php echo $row['check_status'] ?></td>
                <td><?php echo $row['m_mac_datetime'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <hr>
    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="4">ผู้รับงาน</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ผู้รับงาน</th>
                <th>สถานะงาน</th>
                <th>ความยาก</th>
                <th>วัน/เวลาที่รับงาน</th>
                </tr>
                <tr class="text-center">
                <td><?php echo $row['m_mac_approve'] ?></td>
                <td><?php echo $row['mainmac_status'] ?></td>
                <td><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $row['m_mac_rate'] ?>&nbsp;<i class="fas fa-star gold"></i>
                <td><?php echo $row['m_approve_date'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>

   <hr>
    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="4">ช่างผู้รับผิดชอบ</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ลำดับ</th>
                <th>ชื่อ</th>
                <th>ชื่อเล่น</th>
                <th>แผนก</th>
                </tr>
                <?php
                    $number=1;
                    $m_mac_id = $_GET['id'];
                    $detailTask = new DB_con();
                    $sql = $detailTask ->fetchOnetask($m_mac_id);
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                <th class="text-center"><?php echo $number; ?></th>
                <td><?php echo $row['tc_name'] ?></td>
                <td><?php echo $row['tc_nickname'] ?></td>
                <td><?php echo $row['tc_depart'] ?></td>
                </tr>
                <?php $number+=1; } ?>
            </tbody>
        </table>
    </div>
   
    </div>
</div>
</body>
</html>