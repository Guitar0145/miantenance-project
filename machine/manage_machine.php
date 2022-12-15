<?php 
session_start();
include_once ('functions-machine.php');
$datMachine = new DB_con();

if (isset($_POST['submit'])){
    $mac_name = $_POST['mac_name'];
    $mac_serial = $_POST['mac_serial'];
    $mac_pic = $_POST['mac_pic'];
    $depsub_mac_id = $_POST['depsub_mac_id'];
    $mac_status = $_POST['mac_status'];

    $sql = $datMachine->addMachine($mac_name, $mac_serial, $mac_pic, $depsub_mac_id, $mac_status);

    if ($sql){
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ !');</script>";
        echo "<script>window.location.href='manage_machine.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_machine.php'</script>";
    }
} 
?>
<?php 
include('../connect_sqli.php');
$query = "SELECT * FROM depsub_machine " or die("Error:" . mysqli_error());
$depSubSelect = mysqli_query($con, $query);

$query = "SELECT * FROM machine 
        INNER JOIN depsub_machine ON machine.depsub_mac_id = depsub_machine.depsub_mac_id
" or die("Error:" . mysqli_error());
$listMac = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    </head>
<body>
    <?php include 'navbar-machine.php' ?>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header bg-primary text-white">
                            เพิ่มรายการเครื่องจักร
                        </div>
                            <div class="card-body shadow p-4 mb-4 bg-white">
                                <div class="row">
                                <form method="POST">
                                    <div class="col-lg-7">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="mac_name" placeholder="กรอกชื่อเครื่องจักร">
                                            <input type="text" class="form-control" name="mac_serial" placeholder="กรอกซีเรียลเครื่องจักร">
                                            <input type="hidden" class="form-control" name="mac_pic" placeholder="mac_pic" value="upload/no_picture.png">
                                            <select class="form-select" name="depsub_mac_id">
                                                <option selected>เลือกแผนกเครื่องจักร</option>
                                                <?php foreach($depSubSelect as $row) { ?>
                                                <option value="<?php echo $row['depsub_mac_id'] ?>"><?php echo $row['depsub_mac_name'] ?></option>
                                            <?php } ?>
                                            </select>
                                            <input type="hidden" class="form-control" name="mac_status" placeholder="สถานะเครื่องจักร" value="Enable">

                                            <button type="submit" name="submit" class="btn btn-sm btn-primary">เพิ่มข้อมูล</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                    </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <div class="col-md-12">
                        <div class="card-header bg-secondary text-white">
                            รายการเครื่องจักรทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <table id="TableMac" class="table table-sm table-hover table-bordered p-1">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>เครื่องจักร</th>
                                    <th>Serial No.</th>
                                    <th>รูปภาพ</th>
                                    <th>แผนก</th>
                                    <th>สถานะเครื่องจักร</th>
                                    <th class="col-1">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listMac as $row) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $row ['mac_id']; ?></td>
                                    <td><?php echo $row ['mac_name']; ?></td>
                                    <td><?php echo $row ['mac_serial']; ?></td>
                                    <td class="text-center"><?php echo $row ['mac_pic']; ?></td>
                                    <td><?php echo $row ['depsub_mac_name']; ?></td>
                                    <td class="text-center" style="<?php if($row['mac_status'] == 'Enable') {?>color:green;<?php } else { ?>color:red;<?php } ?>"><?php echo $row ['mac_status']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" name="editMac" id="editMac" data-bs-toggle="modal" data-bs-target="#editMac<?php echo $row ['mac_id']; ?>">แก้ไข</button>
                                        <button class="btn btn-sm btn-primary" name="editImgMac" id="editImgMac" data-bs-toggle="modal" data-bs-target="#editImgMac<?php echo $row['mac_id']; ?>">รูป</button>
                                    </td>
                                </tr>
                                <!--------------------------------------------------------------------------------------Open Modal Update IMG ----------------------------------------------------------------------------------->
                                <div class="modal fade" id="editImgMac<?php echo $row['mac_id']; ?>" aria-hidden="true">                      
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data" action="Upload-ImgMachine.php">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">อัพโหลดรูปภาพ</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <h5>รูปภาพเดิม</h5>
                                                                <hr>
                                                                <div class="text-center">
                                                                <img src="<?php echo $row['mac_pic']?>" height="200" width="auto" />
                                                                </div>
                                                                <input type="hidden" name="previous" value="<?php echo $row['mac_pic']?>"/>
                                                                <hr>
                                                                <h5>รูปภาพใหม่</h5>
                                                                <input type="file" class="form-control" name="photo" value="<?php echo $row['mac_pic']?>" required="required"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?php echo $row['mac_id']?>" name="mac_id"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br style="clear:both;"/>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" name="edit"><span class="glyphicon glyphicon-save"></span>Upload</button>
                                                        <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
<!--------------------------------------------------------------------------------------Close Modal Update IMG ----------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------- Modal ------------------------------------------------------------------------------->
                                <div class="modal fade" id="editMac<?php echo $row['mac_id']; ?>" aria-hidden="true">   
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขเครื่องจักร : <?php echo $row ['mac_name']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="edit-machine.php" method="POST">
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">เครื่องจักร</span>
                                                <input type="hidden" class="form-control" name="mac_id" value="<?php echo $row ['mac_id']; ?>">
                                                <input type="text" class="form-control" name="mac_name" value="<?php echo $row ['mac_name']; ?>">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Serial</span>
                                                <input type="text" class="form-control" name="mac_serial" value="<?php echo $row ['mac_serial']; ?>">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">แผนก</span>
                                                <select class="form-select" name="depsub_mac_id">
                                                    <option selected>เลือกแผนก</option>
                                                    <?php foreach($depSubSelect as $row) { ?>
                                                    <option value="<?php echo $row['depsub_mac_id'] ?>"><?php echo $row ['depsub_mac_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Status</span>
                                                <select class="form-select" name="mac_status">
                                                    <option value="Enable">Enable</option>
                                                    <option value="Disable">Disable</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="editMac" class="btn btn-primary">ยืนยัน</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
<!-------------------------------------------------------------------------------- Modal ------------------------------------------------------------------------------------------->

                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
   
    <?php include '../footer.php';?>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#TableMac').DataTable();
        } );
    </script>
</body>
</html>