<?php include('connect_sqli.php');
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
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="container">
        <h3 class="text-center">ค้นหาการรับงานช่าง...</h3>
        <div class="row">
            <div class="col">
                <form action="report-technician.php" method="GET" class="row my-2 g-1">
                    <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <select name="tc_name" class="form-select">
                                <option selected><?php if(isset($_GET['tc_name'])){echo $_GET['tc_name']; } ?></option>
                                <?php foreach($technic as $technic){?>
                                <option value="<?php echo $technic['tc_name'];?>"><?php echo $technic['tc_name'];?></option>
                                <?php } ?>
                            </select>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <select name="task_status" class="form-select">
                                <option selected><?php if(isset($_GET['task_status'])){echo $_GET['task_status']; } ?></option>
                                <option value="ทำงานเสร็จสิ้น">ทำงานเสร็จสิ้น</option>
                                <option value="กำลังทำงาน">กำลังทำงาน</option>
                            </select>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                           <input type="date" class="form-control" name="from_date" placeholder="dd-mm-yyyy" id="from" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date']; } ?>">
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                           <input type="date" class="form-control" name="to_date" id="to" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date']; } ?>">
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                        <button name="submit" type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>


                </form>
            </div>

            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th class="col-1">#</th>
                            <th class="col-1">รหัสแจ้ง</th>
                            <th>ชื่อ</th>
                            <th>ชื่อเล่น</th>
                            <th>ช่าง</th>
                            <th>สถานะงาน</th>
                            <th>ประเมิน</th>
                            <th>วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(isset($_GET['submit'])){
                                $tc_name = $_GET['tc_name'];
                                $task_status = $_GET['task_status'];
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];

                                if($tc_id != "" || $task_status != "" || $fdate != "" || $tdate != "" ){
                                      $query = "SELECT * 
                                        FROM technician
                                        INNER JOIN tasker ON technician.tc_id = tasker.tc_id 
                                        WHERE tc_name = '$tc_name' AND task_status = '$task_status' AND date_task 
                                        BETWEEN '". $from_date."' AND '".$to_date."' 
                                        
                                        ";
                                    
                                    $data = mysqli_query($con, $query) or die('error');
                                    if(mysqli_num_rows($data) > 0){
                                        while ($row = mysqli_fetch_assoc($data)){
                                            $task_id = $row['task_id'];
                                            $m_id = $row['m_id'];
                                            $tc_name = $row['tc_name'];
                                            $tc_nickname = $row['tc_nickname'];
                                            $tc_depart = $row['tc_depart'];
                                            $task_status = $row['task_status'];
                                            $task_score = $row['task_score'];
                                            $date_task = $row['date_task'];
                                            ?>
                                            <tr class="text-center">
                                                <td><?php echo $task_id; ?></td>
                                                <td><?php echo $m_id; ?></td>
                                                <td><?php echo $tc_name; ?></td>
                                                <td><?php echo $tc_nickname; ?></td>
                                                <td><?php echo $tc_depart; ?></td>
                                                <td><?php echo $task_status; ?></td>
                                                <td><?php echo $task_score; ?></td>
                                                <td><?php echo $date_task; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center">ไม่เจอข้อมูลที่ท่านต้องการ !</td>
                                        </tr>
                                        <?php
                                    }
                                }
                                
                            }
                        ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
<?php include 'footer.php';?>
</body>
</html>