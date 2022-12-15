
<?php 
    include('connect_sqli.php'); 
     $query = "SELECT * ,COUNT(tasker.task_id) AS takerCount
        FROM tasker
        LEFT JOIN technician ON tasker.tc_id = technician.tc_id
        WHERE tasker.task_status = 'กำลังทำงาน'
        GROUP BY tasker.tc_id
        ORDER BY tasker.tc_id ASC
    " or die("Error:" . mysqli_error());
    $taker = mysqli_query($con, $query); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทดสอบคิวทำงานช่าง</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container pt-3">
        <table class="table table-sm table-bordered">
        <thead>
            <tr class="text-center">
            <th scope="col-1">รหัสช่าง</th>
            <th scope="col-1">ชื่อ</th>
            <th scope="col-1">ชื่อเล่น</th>
            <th scope="col-1">ช่าง</th>
            <th scope="col-auto">จำนวนงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taker as $taker){?>
                <tr>
                <td class="text-center"><?php echo $taker['tc_id']; ?></td>
                <th><?php echo $taker['tc_name']; ?></th>
                <th><?php echo $taker['tc_nickname']; ?></th>
                <th><?php echo $taker['tc_depart']; ?></th>
                <td class="text-center"><?php echo $taker['takerCount']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
        </table>

        
        <hr>
        <?php 
            $queryWork2 = "SELECT * 
            FROM technician
            WHERE NOT technician.tc_id IN (SELECT tc_id FROM tasker WHERE task_status = 'กำลังทำงาน')
            " or die("Error:" . mysqli_error());
            $listwork = mysqli_query($con, $queryWork2);
        ?>
        <table class="table table-sm table-bordered">
            <tr></tr>
        <thead>
            <tr class="text-center">
                <th scope="col-1">รหัสช่าง</th>
                <th scope="col-1">ชื่อ</th>
                <th scope="col-1">ชื่อเล่น</th>
                <th scope="col-1">ช่าง</th>
                <th scope="col-auto">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listwork as $listwork){?>
                <tr>
                <td class="text-center"><?php echo $listwork['tc_id']; ?></td>
                <th><?php echo $listwork['tc_name']; ?></th>
                <th><?php echo $listwork['tc_nickname']; ?></th>
                <th><?php echo $listwork['tc_depart']; ?></th>
                <td class="text-center">ว่าง</td>            
                </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
</body>
</html>