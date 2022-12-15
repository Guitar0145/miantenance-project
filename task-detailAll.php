<?php
    include_once ('functions-maint.php');
?>
<?php
        include('connect_sqli.php'); 
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
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
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
    $m_id = $_GET['id'];
    $detailTask = new DB_con();
    $sql = $detailTask ->fetchTaskmaint($m_id);
    while($row = mysqli_fetch_array($sql)) {
?>
    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="6">รายการแจ้งซ่อม #<?php echo $row['m_id'] ?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ผู้แจ้ง</th>
                <th>ประเภทงาน</th>
                <th>อาการ</th>
                <th>ความเร่งด่วน</th>
                <th>ตรวจสอบ</th>
                <th>วันที่แจ้ง</th>
                </tr>
                <tr class="text-center">
                <td><?php echo $row['m_user'] ?> / <?php echo $row['depart_sub_name'] ?></td>
                <td><?php echo $row['st_name'] ?> / <?php echo $row['c_name'] ?></td>
                <td><?php echo $row['m_issue'] ?></td>
                <td><?php echo $row['m_urgency'] ?></td>
                <td><?php echo $row['check_status'] ?></td>
                <td><?php echo $row['m_datetime'] ?></td>
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
                <td><?php echo $row['m_admin'] ?></td>
                <td><?php echo $row['m_status'] ?></td>
                <td><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $row['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i>
                <td><?php echo $row['ap_datetime'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>

    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="5">ช่างผู้รับผิดชอบ</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ลำดับ</th>
                <th>ชื่อ</th>
                <th>ชื่อเล่น</th>
                <th>แผนก</th>
                <th>วันที่</th>
                </tr>
                <?php
                    $number=1;
                    $m_id = $_GET['id'];
                    $detailTask = new DB_con();
                    $sql = $detailTask ->fetchOnetask($m_id);
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                <th class="text-center"><?php echo $number; ?></th>
                <td><?php echo $row['tc_name'] ?></td>
                <td><?php echo $row['tc_nickname'] ?></td>
                <td><?php echo $row['tc_depart'] ?></td>
                <td class="text-center"><?php echo $row['date_task'] ?></td>
                </tr>
                
                <?php $number+=1; } ?>
            </tbody>
        </table>
    </div>
   
    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="4">ผู้ตรวจสอบงาน</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ชื่อ</th>
                <th>Comment</th>
                <th>การตรวจสอบ</th>
                <th>วันที่ตรวจสอบ</th>
                </tr>
                <?php
                    $m_id = $_GET['id'];
                    $detailTask2 = new DB_con();
                    $sql = $detailTask2 ->fetchTaskmaint2($m_id);
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                <?php if($row['user_check'] == 'YES') { ?>
                <tr>
                <th><?php echo $row['name_check'] ?></th>
                <td><?php echo $row['user_comment'] ?></td>
                <td class="text-center"><?php echo $row['user_check'] ?></td>
                <td class="text-center"><?php echo $row['date_check'] ?></td>
                </tr>
                <?php } else {?>
                    <tr>
                        <td class="text-center" colspan="4" style="color:red;">User ยังไม่ได้ตรวจสอบ</td>
                    </tr>
                <?php } ?>
                <?php }  ?>
            </tbody>
        </table>
    </div>

    <div class="table-responsive-md my-2">
        <table class="table table-sm table-bordered border-dark">
            <thead class="table-active">
                <tr>
                <th class="text-center" colspan="4">ผู้ปิดเคสงาน # <?php echo $m_id; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                <th>ชื่อ</th>
                <th>การแก้ไข</th>
                <th>วัน/เวลา</th>
                </tr>
                <?php
                    $m_id = $_GET['id'];
                    $detailTask2 = new DB_con();
                    $sql = $detailTask2 ->fetchTaskmaint2($m_id);
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                <th><?php echo $row['m_admin'] ?></th>
                <td><?php echo $row['suc_issue'] ?></td>
                <td class="text-center"><?php echo $row['suc_date'] ?> <?php echo $row['suc_time'] ?></td>
                </tr>
                <?php }  ?>
            </tbody>
        </table>
    </div>
   
    </div>
</div>
</body>
</html>