<?php
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
    <title>Test Count</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>
    <div class="container">
        <div class="card p-3 my-2">
<table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-auto">ปัญหา</th>
                                            <th class="col-auto">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th colspan="2" class="col-auto text-center">m_num / m_task</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php foreach($tasker as $tasker){
                                        $m_id_count = $tasker["m_id"];
                                    ?>
                                    
                                        <?php
                                            $sql="SELECT * FROM tasker WHERE m_id = $m_id_count and task_status = 'ทำงานเสร็จสิ้น'";
                                            if ($result=mysqli_query($con,$sql))
                                            {
                                                $countEnd=mysqli_num_rows($result);
                                                mysqli_free_result($result);
                                            }

                                            $sql2 = "SELECT * FROM tasker WHERE m_id = $m_id_count ";
                                            if ($result2=mysqli_query($con,$sql2))
                                            {
                                                $countPer=mysqli_num_rows($result2);
                                                mysqli_free_result($result2);
                                            }
                                        ?>

                                        <tr>
                                            <th class="text-center"><?php echo $m_id_count; ?></th>
                                            <td colspan="2"><?php echo $tasker["m_user"]; ?> / <?php echo $tasker["depart_sub_name"]; ?></td>
                                            <td><?php echo $tasker["m_issue"]; ?></td>
                                            <td class=""><?php echo $tasker["m_urgency"]; ?></td></td>
                                            <td class="text-center"><?php echo $tasker["m_status"]; ?></td>
                                            <td class="text-center"><?php echo $tasker["m_rate"]; ?></td>
                                            <td><?php echo $countPer; ?></td>
                                            <td><?php echo $countEnd; ?></td>
                                            <td class="text-center">
                                                <!-- Example single danger button -->
                                                <div class="btn-group">
                                                    <button type="button" class="badge btn bg-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">ดูเพิ่มเติม</a></li>
                                                        <li><a class="dropdown-item" href="#">จ่ายงานช่าง</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="#">ปิดงานช่าง</a></li>
                                                        <?php if($countPer == $countEnd) {?>
                                                        <li><a class="dropdown-item" href="#">ปิดงานเคสงาน</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>  
                                </div>
                                </div>
</body>
</html>