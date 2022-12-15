<?php session_start(); ?>
<?php 
    include_once ('functions-machine.php');
    include('connect_sqli.php');

    $get_id = $_GET['depsub_mac_id'];
    $query = "SELECT * FROM machine 
    INNER JOIN depsub_machine ON machine.depsub_mac_id = depsub_machine.depsub_mac_id
    WHERE mac_status = 'Enable' AND machine.depsub_mac_id = '$get_id'
    " or die("Error:" . mysqli_error());
    $machine = mysqli_query($con, $query);


    // รับค่า POST ส่งค่าไป INSERT เข้า DATABASE
    $dataRepair = new DB_con();
    if (isset($_POST['repairMac'])){
    $m_mac_name = $_POST['m_mac_name'];
    $depart_id = $_POST['depart_id'];
    $mac_id = $_POST['mac_id'];
    $m_mac_issue = $_POST['m_mac_issue'];
    $m_mac_urgency = $_POST['m_mac_urgency'];
    $m_mac_pic = $_POST['m_mac_pic'];
    $check_status = $_POST['check_status'];
    $m_mac_datetime = $_POST['m_mac_datetime'];


    $sql = $dataRepair->addRepairMac($m_mac_name, $depart_id, $mac_id, $m_mac_issue, $m_mac_urgency, $m_mac_pic, $check_status, $m_mac_datetime);

            if ($sql){
                echo "<script>alert('แจ้งซ่อมเครื่องจักร สำเร็จ !');</script>";
                echo "<script>window.location.href='index-machine.php'</script>";
            } else{
                echo "<script>alert('แจ้งซ่อมเครื่องจักร ไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
                echo "<script>window.location.href='index-machine.php'</script>";
            }
    }
?>
<?php 
$query = "SELECT * FROM depart " or die("Error:" . mysqli_error());
$departSelect = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    </head>
<body>
    <?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
                                <?php  include('connect_sqli.php');
                                    $query = "SELECT * FROM dep_machine " or die("Error:" . mysqli_error());
                                    $menu_depart = mysqli_query($con, $query);
                                    foreach ($menu_depart as $menu) { $dep_mac_id = $menu ['dep_mac_id'];
                                ?>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo $menu['dep_mac_name'] ?>
                                        </a>
                                    
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <?php 
                                                $query = "SELECT * FROM depsub_machine WHERE dep_mac_id = '$dep_mac_id' " or die("Error:" . mysqli_error());
                                                $menu_sub = mysqli_query($con, $query);
                                                foreach ($menu_sub as $menu_sub) { 
                                            ?>
                                            <li><a class="dropdown-item" href="test-menu.php?depsub_mac_id=<?php echo $menu_sub['depsub_mac_id'] ?>"><?php echo $menu_sub['depsub_mac_name'] ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                                <?php }  ?>
                            </div>
                        </nav>
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
                            รายการเครื่องจักร แผนก : <?php echo $get_id; ?>
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                         <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>เครื่องจักร</th>
                                    <th>Serial No.</th>
                                    <th>รูปภาพ</th>
                                    <th>ห้อง</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($machine as $row) { ?>
                                <tr>
                                    <td><?php echo $row['mac_id']; ?></td>
                                    <td><?php echo $row['mac_name']; ?></td>
                                    <td><?php echo $row['mac_serial']; ?></td>
                                    <td><?php echo $row['mac_pic']; ?></td>
                                    <td><?php echo $row['depsub_mac_name']; ?></td>
                                    <td><?php echo $row['mac_status']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                         </table>
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
                            ทดสอบรายการแบบการ์ด
                        </div>
                        <div class="card-body shadow p-4 mb-2 bg-white">
                        
                            <div class="row">
                            <?php foreach ($machine as $rowcard) { ?>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                            <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#inform<?php echo $rowcard['mac_id']; ?>" data-bs-whatever="@mdo"><img class="card-img-top" src="<?php echo $rowcard ['mac_pic']; ?>" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;"><?php echo $rowcard ['mac_name']; ?></h6>
                                </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="inform<?php echo $rowcard['mac_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $rowcard['mac_name'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" action="test-menu.php" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" nam="">ผู้แจ้ง</span>
                                        <input type="text" class="form-control" placeholder="ผู้แจ้ง(ชื่อเล่น)" name="m_mac_name">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">แผนก</span>
                                        <select class="form-select" name="depart_id">
                                            <option selected>เลือกแผนก</option>
                                        <?php foreach ($departSelect as $row ) {  ?>
                                            <option value="<?php echo $row['depart_id'] ?>"><?php echo $row['depart_sub_name'] ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" name="name_machine">เครื่องจักร</span>
                                        <input type="text" class="form-control" value="<?php echo $rowcard['mac_name']; ?>" name="name_machine">
                                        
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" name="m_mac_issue">อาการ</span>
                                        <textarea class="form-control" name="m_mac_issue" rows="3"></textarea>
                                    </div>
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">ความเร่งด่วน</span>
                                        <select class="form-select" name="m_mac_urgency">
                                            <option value="Hight">Hight</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" value="<?php echo $rowcard['mac_id']; ?>" name="mac_id">
                                        <input type="hidden" class="form-control" value="upload/no_picture.png" name="m_mac_pic">
                                        <input type="hidden" class="form-control" value="รอตรวจสอบ" name="check_status">
                                        <?php date_default_timezone_set("Asia/Bangkok"); ?>
                                        <input type="hidden" class="form-control" value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?>" name="m_mac_datetime">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="repairMac" class="btn btn-primary">แจ้งซ่อม</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    
                                </div>
                                </div>
                            </div>
                            </div>
                            <!--End Modal -->

                        <?php } ?>
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

            </div>
        </div>
    </div>
   
    <?php include 'footer.php';?>
</body>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>
</html>