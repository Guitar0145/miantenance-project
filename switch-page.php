<?php
    session_start();
    $con = mysqli_connect("localhost","root","rootroot","mtservice");
    $sql = "SELECT * FROM `switch`";
    $Sql_query = mysqli_query($con,$sql);
    $All_switch = mysqli_fetch_all($Sql_query,MYSQLI_ASSOC);
?>

<?php
    $sql2 = "SELECT * FROM `switch` WHERE switch_id = '1' ";
    $Sql_query2 = mysqli_query($con,$sql2);
    $rowSwitch = mysqli_fetch_all($Sql_query2,MYSQLI_ASSOC);
?>
<?php
    $sql3 = "SELECT * FROM `switch` WHERE switch_id = '2' ";
    $Sql_query3 = mysqli_query($con,$sql3);
    $rowSwitch3 = mysqli_fetch_all($Sql_query3,MYSQLI_ASSOC);
?>
<?php 
//เขียนแบบ PDO 
$servername = "localhost";
$username = "root";
$password = "rootroot";

try {
  $connect = new PDO("mysql:host=$servername;dbname=mtservice", $username, $password);
  // set the PDO error mode to exception
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Switch</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>
<?php include 'navbar.php' ?>
<div class="container mt-2">
    <h2>Switch Functions</h2>
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th class="col-6">Switch Founction</th>
            <th class="col-5">Switch Status</th>
            <th class="col-auto">Toggle</th>
        </tr>
            <?php
                foreach ($All_switch as $switch) { 
            ?>
            <tr>
                <td><?php echo $switch['switch_name']; ?> | 
                    <?php if($switch['status'] == '1') {?>
                        <a style="color:green;">เปิดใช้งานแล้ว</a>
                    <?php } 
                        else {
                            echo '<a style="color:red;">ปิดใช้งาน</a>';
                        }
                    ?>
                </td>
                <td><?php 
                        if($switch['status']=="1") 
                            echo "<span style='color:green;'>ON</span>";
                        else 
                            echo "<span style='color:red;'>OFF</span>";
                    ?>                          
                </td>
                <td><?php 
                        if($switch['status']=="1") 
                            echo "<a href=disable.php?switch_id=".$switch['switch_id']."><i class='fas fa-toggle-on' style='font-size:24px; color:green;'></i></a>";
                        else 
                            echo "<a href=enable.php?switch_id=".$switch['switch_id']." ><i class='fas fa-toggle-off' style='font-size:24px; color:black;'></i></a>";
                    ?>
                </td>
            </tr>
           <?php
                }
           ?>
    </table>
    <?php foreach ($rowSwitch as $rowSwitch) { $status = $rowSwitch['status'];?><?php } ?>

    <!----------------------------------------------------------------------Switch Edit Time Tasker --------------------------------------------------------------------------------->
    <?php foreach ($rowSwitch3 as $rowSwitch3) { $status3 = $rowSwitch3['status'];?><?php } ?>

    <?php if($status3 == '1') {?> 
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>แก้ไขเวลาการแบ่งงานช่าง(ย้อนหลัง)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control"  name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" placeholder="ค้นหารายการ ด้วย ชื่อรหัสแจ้งซ่อม" >
                                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-auto">รหัสแจ้งซ่อม</th>
                                    <th class="col-auto">อาการ</th>
                                    <th class="col-auto">ช่าง</th>
                                    <th class="col-auto">สถานะงาน</th>
                                    <th class="col-auto">เวลา</th>
                                    <th class="col-auto">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","rootroot","mtservice");

                                    if(isset($_GET['search']))
                                    {
                                        
                                        $filtervalue = $_GET['search'];
                                        $nolimit = 50;
                                        $where ="";
                                        if ($filtervalue){
                                            $where .= " AND CONCAT(tasker.m_id) LIKE '%$filtervalue%'";
                                        } else {
                                            unset ($filtervalue);
                                        }

                                        $query = "SELECT * 
                                            FROM tasker
                                            INNER JOIN technician on tasker.tc_id = technician.tc_id
                                            LEFT JOIN maintenance on tasker.m_id = maintenance.m_id
                                            WHERE tasker.task_id > 0 {$where}
                                            ORDER BY task_id DESC
                                            LIMIT 50
                                                 ";
                                        $row = mysqli_query($con, $query);

                                        if(mysqli_num_rows($row) > 0)
                                        {
                                            foreach ($row as $item)
                                            {
                                                ?>
                                                 <tr>
                                                    <td class="text-center"><?= $item['m_id']; ?></td>
                                                    <td class="col-4"><?= $item['m_issue']; ?></td>
                                                    <td><?= $item['tc_name']; ?> ( <?php echo $item['tc_nickname']; ?> )</td>
                                                    <td><?= $item['task_status']; ?></td>
                                                    <td><?= $item['date_task']; ?></td>
                                                    <td class="text-center"><button class="btn btn-sm btn-primary" data-bs-toggle="modal" name="edittime" id="edittime" data-bs-target="#edittime<?php echo $item['task_id']?>">แก้ไข</button></td>
                                                </tr>
                                                <!--Start Modal See More-->
                                                <div class="modal fade" id="edittime<?php echo $item['task_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-timetasker.php">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียด การแจ้งซ่อมที่ #<?php echo $item['task_id'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="input-group mb-3">
                                                        <input type="hidden" name="task_id" value="<?php echo $item['task_id']; ?>">
                                                        <span class="input-group-text" id="basic-addon3">วันที่</span>
                                                        <input type="datetime-local" class="form-control" id="date_task" name="date_task">
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" name="edittime"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                    </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!--End Modal See More -->
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td class="text-center" colspan="12">
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <strong>ไม่เจอข้อมูลที่ท่านต้องการ<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                        }

                                        
                                    }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>
    <!------------------------------------------------------------------End Switch Edit Time Tasker --------------------------------------------------------------------------------->
</div>




<br><br><br><br><br><br><br><br><br>

<?php include '';?>
</body>
  
</html>