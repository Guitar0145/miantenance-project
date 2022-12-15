<?php 
session_start(); 
include_once ('functions-machine.php');
$departdata = new DB_con();

if (isset($_POST['submitDepart'])){
    $dep_mac_name = $_POST['dep_mac_name'];

    $sql = $departdata->addMacDepart($dep_mac_name);

    if ($sql){
        echo "<script>window.location.href='manage_dep_machine.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_dep_machine.php'</script>";
    }
} 

$departSubdata = new DB_con();
if (isset($_POST['submitDepartSub'])){
    $depsub_mac_name = $_POST['depsub_mac_name'];
    $dep_mac_id = $_POST['dep_mac_id'];


    $sql = $departSubdata->addMacDepartSub($depsub_mac_name, $dep_mac_id,);

    if ($sql){
        echo "<script>window.location.href='manage_dep_machine.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_dep_machine.php'</script>";
    }
} 
?>
<?php 
include('../connect_sqli.php');
$query = "SELECT * FROM dep_machine " or die("Error:" . mysqli_error());
$depselect = mysqli_query($con, $query);

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    </head>
<body>
    <?php include 'navbar-machine.php' ?>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">      
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแผนกเครื่องจักร
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <form method="post">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="dep_mac_name" class="form-control" placeholder="กรอกรายการแผนก" required>
                                        <button type="submit" name="submitDepart" class="btn btn-primary">เพิ่ม</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive-lg">
                            <table id="TableDep" class="table table-striped table-hover table-bordered p-1">
                                <thead>
                                    <tr class="text-center">
                                        <td class="col-1">#</td>
                                        <td>รายการแผนก</td>
                                        <td class="col-1">จัดการ</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        $query = "SELECT * FROM dep_machine " or die("Error:" . mysqli_error());
                                        $depmac = mysqli_query($con, $query);
                                    ?>
                                    <?php foreach ($depmac as $row ) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $row['dep_mac_id'];?></td>
                                        <td><?php echo $row['dep_mac_name'];?></td>
                                        <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editdep<?php echo $row['dep_mac_id']; ?>">แก้ไข</button></td>
                                    </tr>
                                
                                    <!--Start Modal Edit DepartMachine-->
                                    <div class="modal fade" id="editdep<?php echo $row['dep_mac_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขแผนก #<?php echo $row['dep_mac_id'];?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="edit-depmachine.php" method="POST" >
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" name="dep_mac_name">แผนก</span>
                                                <input type="hidden" class="form-control" name="dep_mac_id" value="<?php echo $row['dep_mac_id'];?>">
                                                <input type="text" class="form-control" name="dep_mac_name" value="<?php echo $row['dep_mac_name'];?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="editdep" class="btn btn-primary">ยืนยัน</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--End Modal -->
                                
                                <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการหน่วยเครื่องจักร
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <form method="post">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="depsub_mac_name" class="form-control" placeholder="กรอกรายการแผนกย่อย" required>
                                        <select class="form-select" name="dep_mac_id">
                                            <option selected>เลือกแผนก</option>
                                            <?php foreach ($depselect as $row ) { ?>
                                            <option value="<?php echo $row['dep_mac_id']; ?>"><?php echo $row['dep_mac_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <button type="submit" name="submitDepartSub" class="btn btn-primary">เพิ่ม</button>
                                    </div>
                                </div>
                            </form>

                            <hr>
                            <div class="table-responsive-lg">
                            <table id="TableDepSub" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <td class="col-1">#</td>
                                        <td>หน่วย</td>
                                        <td>แผนก</td>
                                        <td class="col-1">จัดการ</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $query = "SELECT * FROM depsub_machine 
                                    INNER JOIN dep_machine ON depsub_machine.dep_mac_id = dep_machine.dep_mac_id
                                    ORDER BY depsub_machine.depsub_mac_id ASC
                                    " or die("Error:" . mysqli_error());
                                    $depsubmac = mysqli_query($con, $query);
                                    foreach ($depsubmac as $row ) { 
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['depsub_mac_id'];?></td>
                                    <td><?php echo $row['depsub_mac_name'];?></td>
                                    <td><?php echo $row['dep_mac_name'];?></td>
                                    <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editdepsub<?php echo $row['depsub_mac_id']; ?>">แก้ไข</button></td>
                                </tr>
                                    <!--Start Modal Edit DepartMachine-->
                                    <div class="modal fade" id="editdepsub<?php echo $row['depsub_mac_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขแผนก #<?php echo $row['depsub_mac_id'];?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="edit-depsub-machine.php" method="POST" >
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" name="depsub_mac_name">แผนกย่อย</span>
                                                <input type="hidden" class="form-control" name="depsub_mac_id" value="<?php echo $row['depsub_mac_id'];?>">
                                                <input type="text" class="form-control" name="depsub_mac_name" value="<?php echo $row['depsub_mac_name'];?>">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" name="dep_mac_id">แผนก</span>
                                                <select class="form-select" name="dep_mac_id">
                                                    <option selected>เลือกแผนก</option>
                                                    <?php foreach ($depselect as $row ) { ?>
                                                    <option value="<?php echo $row['dep_mac_id']; ?>"><?php echo $row['dep_mac_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="editdepsub" class="btn btn-primary">ยืนยัน</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--End Modal -->
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#TableDep').DataTable();
        } );
    </script>
    <script>
        $(document).ready( function () {
            $('#TableDepSub').DataTable();
        } );
    </script>
    <?php include '../footer.php';?>
</body>
   
</html>