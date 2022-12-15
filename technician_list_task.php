<?php
        include_once ('test-functions.php');
        include('connect_sqli.php'); 
        $query = "SELECT * 
        FROM maintenance 
        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
        ORDER BY m_id " or die("Error:" . mysqli_error());
        $tasker = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <table class="table table-sm table-hover table-bordered mt-2">
        <thead>
            <tr>
                <th colspan="10">คิวงานช่าง : <?php echo $tc_name; ?></th>
            </tr>
            <tr class="table-active text-center">
                <th>รหัสงานซ่อม</th>
                <th>ผู้แจ้ง</th>
                <th>แผนก</th>
                <th>สถานะงาน</th>
                <th>วันที่แจ้ง</th>
                <th>เวลาที่แจ้ง</th>
                <th>วันที่รับงาน</th>
                <th>เวลารับงาน</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $tc_id = $_GET['id'];
                $upstatus = new DB_con();
                $sql = $upstatus ->fetchTasklist($tc_id);
                while($row = mysqli_fetch_array($sql)) {
                $tc_name = $row['tc_name'];
            ?>
            <tr>
                <th class="text-center"><?php echo $row['m_id']; ?></th>
                <td><?php echo $row ['m_user']; ?></td>
                <td><?php echo $row ['depart_sub_name']; ?></td>
                <td><?php echo $row ['m_status']; ?></td>
                
               
            </tr>
               
            
            <?php } ?>
        </tbody>
        </table>
    </div>
</body>
</html>