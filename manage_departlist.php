<?php 
session_start();
include('connect_sqli.php');
include_once ('functions-maint.php');

$departdata = new DB_con();

if (isset($_POST['submitDepart'])){
    $dep_sub = $_POST['depart_sub_name'];
    $dep_name = $_POST['depart_name'];

    $sql = $departdata->adddepart($dep_sub, $dep_name);

    if ($sql){
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ !');</script>";
        echo "<script>window.location.href='manage_departlist.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_departlist.php'</script>";
    }
} 

$techData= new DB_con();

if (isset($_POST['submitTech'])){
    $tc_name = $_POST['tc_name'];
    $tc_nickname = $_POST['tc_nickname'];
    $tc_depart = $_POST['tc_depart'];
    $tc_status = $_POST['tc_status'];

    $sql = $techData->addTech($tc_name, $tc_nickname, $tc_depart, $tc_status);

    if ($sql){
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ !');</script>";
        echo "<script>window.location.href='manage_departlist.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_departlist.php'</script>";
    }
} 
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
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-1 mt-2">
            <div class="card p-1">
                <div class="row p-3">
 <!--------------------------------------------- Start Card List Depart------------------------------------------------------------------------------------>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                    <div class="card shadow p-4 mb-4 bg-white">
                        <div class="row ps-3">
                        <div class="col-12">
                            
                            <form method="post"  class="row g-1">
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xxl-5">
                                <input type="text" class="form-control" name="depart_sub_name"  placeholder="แผนก...." required>
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xxl-5">
                                <input type="text" class="form-control" name="depart_name" placeholder="ฝ่าย..." required>
                                </div>
                                <div class="col-sm-12 col-md-1 col-lg-1 col-xxl-1">
                                <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="submitDepart"><i class="fas fa-plus">&nbsp;เพิ่ม</i></button>
                                </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="card-body">
                        <h5>รายการแผนก</h5>
                        <table class="table table-sm table-hover table-bordered">
                            <tr class="text-center">
                            <th>รหัส</th>  
                            <th>แผนก</th>  
                            <th>ฝ่าย</th>  
                            <th>จัดการ</th>  
                            </tr>
                            <?php
                        //Getting default page number
                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                                } else {
                                $pageno = 1;
                                }
                        // Formula for pagination  
                                $no_of_records_per_page = 10;
                                $offset = ($pageno-1) * $no_of_records_per_page;
                        // Getting total number of pages
                                $total_pages_sql = "SELECT COUNT(*) FROM depart";
                                $result = mysqli_query($con,$total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT * FROM depart LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($con,$sql);
                                $cnt=1;
                                while($row = mysqli_fetch_array($res_data)){?>

                            <tr>
                            <td class="text-center"><?php echo $row['depart_id'];?></td>
                            <td><?php echo $row['depart_sub_name'];?></td>
                            <td><?php echo $row['depart_name'];?></td>
                            <td class="text-center col-1"><button type="button" name="submitstatus" id="submitstatus" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editDepart<?php echo $row['depart_id'];?>"><i class="far fa-edit">&nbsp;แก้ไข</i></button></td>
                            </tr>
                            <div class="modal fade" id="editDepart<?php echo $row['depart_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data" action="update-depart.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายการแผนก #<?php echo $row['depart_id'];?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">แผนก</span>
                                        <input type="hidden" class="form-control" name="depart_id" value="<?php echo $row['depart_id'];?>">
                                        <input type="text" class="form-control" name="depart_sub_name" value="<?php echo $row['depart_sub_name'];?>" placeholder="แผนก...." required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ฝ่าย</span>
                                        <input type="text" class="form-control" name="depart_name" value="<?php echo $row['depart_name'];?>" placeholder="ฝ่าย..." required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="editDepart" class="btn btn-primary">ยืนยัน</button>
                                     </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                    </div>
                                    </div>
                                </div>
                            </div> 

                            <?php $cnt++; } ?>
                        </table>
                            <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="?pageno=1">หน้าแรก</a></li>
                                <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">ก่อนหน้า</a></li>
                                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">ถัดไป</a></li>
                                <li class="page-item"><a class="page-link"href="?pageno=<?php echo $total_pages; ?>">สุดท้าย</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                    </div>
<!----------------------------------------------------------- End Card List Depart------------------------------------------------------------------------------------>
<!----------------------------------------------------------- Start Card List Tech------------------------------------------------------------------------------------>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                    <div class="card shadow p-4 mb-4 bg-white">
                        <div class="row ps-3">
                        <div class="col-12">
                            
                            <form method="post"  class="row g-1">
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xxl-3">
                                <input type="text" class="form-control" name="tc_name"  placeholder="ชื่อ...." required>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xxl-3">
                                <input type="text" class="form-control" name="tc_nickname" placeholder="ชื่อเล่น..." required>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xxl-3">
                                    <select class="form-select" name="tc_depart" aria-label="Default select example">
                                        <option selected>เลือกแผนกงานช่าง</option>
                                        <option value="ช่างกล">ช่างกล</option>
                                        <option value="ช่างไฟฟ้า">ช่างไฟฟ้า</option>
                                        <option value="ช่างซับพอร์ต">ช่างซับพอร์ต</option>
                                    </select>
                                <input type="hidden" class="form-control" name="tc_status" value="Enable" required>
                                </div>
                                
                                <div class="col-sm-12 col-md-1 col-lg-1 col-xxl-1">
                                <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="submitTech"><i class="fas fa-plus">&nbsp;เพิ่ม</i></button>
                                </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="card-body">
                        <h5>รายการช่าง</h5>
                        <table class="table table-sm table-hover table-bordered">
                            <tr class="text-center">
                            <th>รหัส</th>  
                            <th>ชื่อ</th>  
                            <th>ชื่อเล่น</th>  
                            <th>ช่าง</th>
                            <th>จัดการ</th> 
                            </tr>
                            <?php
                        //Getting default page number
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                                } else {
                                $page = 1;
                                }
                        // Formula for pagination  
                                $no_of_records_per_page = 10;
                                $offset = ($page-1) * $no_of_records_per_page;
                        // Getting total number of pages
                                $total_pages_sql = "SELECT COUNT(*) FROM technician";
                                $result = mysqli_query($con,$total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT * FROM technician LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($con,$sql);
                                $cnt=1;
                                while($row = mysqli_fetch_array($res_data)){?>

                            <tr>
                            <td class="text-center"><?php echo $row['tc_id'];?></td>
                            <td><?php echo $row['tc_name'];?></td>
                            <td><?php echo $row['tc_nickname'];?></td>
                            <td><?php echo $row['tc_depart'];?></td>
                            <td class="text-center col-1"><button type="button" name="submitstatus" id="submitstatus" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTech<?php echo $row['tc_id'];?>"><i class="far fa-edit">&nbsp;แก้ไข</i></button></td>
                            </tr>
                            <div class="modal fade" id="editTech<?php echo $row['tc_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data" action="update-tech.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายการช่าง #<?php echo $row['tc_id'];?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ชื่อ</span>
                                        <input type="hidden" class="form-control" name="tc_id" value="<?php echo $row['tc_id'];?>">
                                        <input type="text" class="form-control" name="tc_name" value="<?php echo $row['tc_name'];?>" placeholder="ชื่อ...." required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ชื่อเล่น</span>
                                        <input type="text" class="form-control" name="tc_nickname" value="<?php echo $row['tc_nickname'];?>" placeholder="ชื่อเล่น..." required>
                                        </div>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">ช่าง</span>
                                            <select class="form-select" name="tc_depart" aria-label="Default select example">
                                                <option selected>เลือกแผนกงานช่าง</option>
                                                <option value="ช่างกล">ช่างกล</option>
                                                <option value="ช่างไฟฟ้า">ช่างไฟฟ้า</option>
                                                <option value="ช่างซับพอร์ต">ช่างซับพอร์ต</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="editTech" class="btn btn-primary">ยืนยัน</button>
                                     </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                    </div>
                                    </div>
                                </div>
                            </div> 

                            <?php $cnt++; } ?>
                        </table>
                            <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="?page=1">หน้าแรก</a></li>
                                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($pageno - 1); } ?>">ก่อนหน้า</a></li>
                                <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">ถัดไป</a></li>
                                <li class="page-item"><a class="page-link"href="?page=<?php echo $total_pages; ?>">สุดท้าย</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                    </div>
<!----------------------------------------------------------- End Card List Tech------------------------------------------------------------------------------------>
                </div>
            
            </div>
        </div>
    </div>  
<?php include 'footer.php';?>
    
</body>
</html>